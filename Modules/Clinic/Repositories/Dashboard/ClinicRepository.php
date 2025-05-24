<?php

namespace Modules\Clinic\Repositories\Dashboard;

use Modules\Core\Traits\SyncRelationModel;
use Modules\Clinic\Entities\Clinic;
use Modules\User\Entities\User;
use DB;

class ClinicRepository
{
    use SyncRelationModel;

    public function __construct(Clinic $clinic, User $user)
    {
        $this->clinic   = $clinic;
        $this->user     = $user;
    }

    public function getClinicUsers($clinicId)
    {
        $users = $this->user->where(function ($query) use ($clinicId) {
            $query->whereHas('orders.doctor.clinic', function ($query) use ($clinicId) {
                $query->where('clinic_id', $clinicId);
            })
            ->orWhereHas('orders.operator.clinic', function ($query) use ($clinicId) {
                $query->where('clinic_id', $clinicId);
            })
            ->orWhereHas('orders.room.clinic', function ($query) use ($clinicId) {
                $query->where('clinic_id', $clinicId);
            });
        })->orderBy('id', 'DESC')->get();

        return $users;
    }

    public function sorting($request)
    {
        DB::beginTransaction();

        try {
            foreach ($request['clinic'] as $key => $value) {
                $key++;

                $this->clinic->find($value)->update([
                  'sorting' => $key,
                ]);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function countClinics()
    {
        $clinics = $this->clinic->count();
        return $clinics;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $clinics = $this->clinic->with('translations')->active()->orderBy($order, $sort)->get();
        return $clinics;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $clinics = $this->clinic->orderBy($order, $sort)->get();
        return $clinics;
    }

    public function findById($id)
    {
        $clinic = $this->clinic->withDeleted()->find($id);
        return $clinic;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {
            $image = $request['image'] ? path_without_domain($request['image']) : setting('logo');

            $clinic = $this->clinic->create([
              'is_busy'         => $request->is_busy ? 1 : 0,
              'status'          => $request->status ? 1 : 0,
              'blogs_limit'     => $request->blogs_limit,
              'supplier_code'   => $request->supplier_code,
              'supplier_value'  => $request->supplier_value,
              'image'           => $image,
            ]);

            $this->translateTable($clinic, $request);

            $this->contacts($clinic, $request);
            $this->gallery($clinic, $request);
            $this->socialMedia($clinic, $request);
            $this->shift($clinic, $request);
            $this->offDays($clinic, $request);
            $this->offTimes($clinic, $request);
            $this->offDates($clinic, $request);
            $this->customOff($clinic, $request);
            $this->branches($clinic, $request);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();

        $clinic = $this->findById($id);

        $restore = $request->restore ? $this->restoreSoftDelte($clinic) : null;

        $image = $request['image'] ? path_without_domain($request['image']) : $clinic->image;

        try {
            $clinic->update([
                'is_busy'       => $request->is_busy ? 1 : 0,
                'status'        => $request->status ? 1 : 0,
                'blogs_limit'   => $request->blogs_limit,
                'supplier_code' => $request->supplier_code,
                'supplier_value' => $request->supplier_value,
                'image'         => $image,
            ]);

            $this->translateTable($clinic, $request);

            $this->contacts($clinic, $request);
            $this->gallery($clinic, $request);
            $this->shift($clinic, $request);
            $this->socialMedia($clinic, $request);
            $this->offDays($clinic, $request);
            $this->offTimes($clinic, $request);
            $this->offDates($clinic, $request);
            $this->customOff($clinic, $request);
            $this->branches($clinic, $request);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function shift($clinic, $request)
    {
        $clinic->shift()->updateOrCreate(
            [
            'shiftable_type' => 'Modules\Clinic\Entities\Clinic',
            'shiftable_id'   => $clinic['id']
            ],
            [
            'start_time'   => date('H:i:s', strtotime($request['open_time'])),
            'end_time'     => date('H:i:s', strtotime($request['close_time'])),
            ]
        );
    }

    public function offDays($clinic, $request)
    {
        $clinic->offDays()->delete();

        if (isset($request['off_days'])) {
            foreach ($request['off_days'] as $key => $day) {
                $clinic->offDays()->updateOrCreate([
                    'day'  => $day,
                ], [
                    'day'          => $day,
                    'start_time'   => date('H:i:s', strtotime($request['day_time_from'][$key])),
                    'end_time'     => date('H:i:s', strtotime($request['day_time_to'][$key])),
                ]);
            }
        }
    }

    public function offTimes($clinic, $request)
    {
        $oldValues = isset($request['old_off_times']['old']) ? $request['old_off_times']['old'] : [];

        $sync = $this->syncRelation($clinic, 'offTimes', $oldValues);

        if ($sync['deleted']) {
            $clinic->offTimes()->whereIn('id', $sync['deleted'])->delete();
        }

        if ($sync['updated']) {
            foreach ($sync['updated'] as $id) {
                $clinic->offTimes()->find($id)->update([
                    'time_from'   => date('H:i:s', strtotime($request['time_from_old'][$id])),
                    'time_to'     => date('H:i:s', strtotime($request['time_to_old'][$id])),
                ]);
            }
        }

        if ($request['time_to']) {
            foreach ($request['time_to'] as $key => $timeTo) {
                $clinic->offTimes()->create([
                  'time_to'     => date('H:i:s', strtotime($timeTo)),
                  'time_from'   => date('H:i:s', strtotime($request['time_from'][$key])),
                ]);
            }
        }
    }

    public function offDates($clinic, $request)
    {
        $oldValues = isset($request['old_off_dates']['old']) ? $request['old_off_dates']['old'] : [];

        $sync = $this->syncRelation($clinic, 'offDates', $oldValues);

        if ($sync['deleted']) {
            $clinic->offDates()->whereIn('id', $sync['deleted'])->delete();
        }

        if ($sync['updated']) {
            foreach ($sync['updated'] as $id) {
                $clinic->offDates()->find($id)->update([
                  'date_from'  => $request['date_from_old'][$id],
                  'date_to'    => $request['date_to_old'][$id],
                ]);
            }
        }

        if ($request['date_from']) {
            foreach ($request['date_from'] as $key => $dateFrom) {
                $clinic->offDates()->create([
                  'date_from'    => $dateFrom,
                  'date_to'      => $request['date_to'][$key],
                ]);
            }
        }
    }

    public function customOff($clinic, $request)
    {
        $oldValues = isset($request['old_custom_off']['old']) ? $request['old_custom_off']['old'] : [];

        $sync = $this->syncRelation($clinic, 'offCustomDates', $oldValues);

        if ($sync['deleted']) {
            $clinic->offCustomDates()->whereIn('id', $sync['deleted'])->delete();
        }

        if ($sync['updated']) {
            foreach ($sync['updated'] as $id) {
                $clinic->offCustomDates()->find($id)->update([
                  'date'       => $request['custom_old_date'][$id],
                  'time_from'   => date('H:i:s', strtotime($request['custom_time_from_old'][$id])),
                  'time_to'   => date('H:i:s', strtotime($request['custom_to_from_old'][$id])),
                ]);
            }
        }

        if ($request['custom_date']) {
            foreach ($request['custom_date'] as $key => $customDate) {
                $clinic->offCustomDates()->create([
                  'date'      => $customDate,
                  'time_from' => date('H:i:s', strtotime($request['custom_time_from'][$key])),
                  'time_to'   => date('H:i:s', strtotime($request['custom_time_to'][$key])),
                ]);
            }
        }
    }

    public function contacts($clinic, $request)
    {
        $oldValues = isset($request['mobile_']['old']) ? $request['mobile_']['old'] : [];

        $sync = $this->syncRelation($clinic, 'contacts', $oldValues);

        if ($sync['deleted']) {
            $clinic->contacts()->whereIn('id', $sync['deleted'])->delete();
        }

        if ($sync['updated']) {
            foreach ($sync['updated'] as $id) {
                $clinic->contacts()->find($id)->update([
                    'mobile' => $request['mobile_']['old'][$id]
                ]);
            }
        }

        if ($request['mobile_']['new']) {
            foreach ($request['mobile_']['new'] as $value) {
                if ($value != null) {
                    $clinic->contacts()->create([
                    'mobile'  => $value
                    ]);
                }
            }
        }
    }

    public function gallery($clinic, $request)
    {
        $oldValues = isset($request['images']['old']) ? $request['images']['old'] : [];

        $sync = $this->syncRelation($clinic, 'gallery', $oldValues);

        if ($sync['deleted']) {
            $clinic->gallery()->whereIn('id', $sync['deleted'])->delete();
        }

        if ($sync['updated']) {
            foreach ($sync['updated'] as $id) {
                $clinic->gallery()->find($id)->update([
                'image' => path_without_domain($request['images']['old'][$id])
                ]);
            }
        }

        if ($request['images_new']) {
            foreach ($request['images_new'] as $value) {
                if ($value != null) {
                    $clinic->gallery()->create([
                    'image'  => path_without_domain($value)
                    ]);
                }
            }
        }
    }

    public function socialMedia($clinic, $request)
    {
        foreach ($request['social'] as $key => $value) {
            $clinic->socialMedia()->updateOrCreate(
                [
                'name'  => $key
                ],
                [
                'link'  => $value ? $value : '#'
                ]
            );
        }
    }

    public function branches($clinic, $request)
    {
        $clinic->branches()->updateOrCreate(
            [
            'clinic_id'     => $clinic['id']
            ],
            [
            'state_id'            => $request['state_id'],
            'building'            => $request['building'],
            'street'              => $request['street'],
            'block'               => $request['block'],
            'phone_number'        => $request['phone_number'],
            'address_details'     => $request['address_details'],
            'another_phone_number' => $request['another_phone_number'],
            'lat'                 => $request['lat'],
            'lang'                => $request['lang'],
            'status'              => 1,
            ]
        );
    }

    public function findDetailsByClinicId($id)
    {
        $clinic = $this->clinic->active()->with([
          'doctors','categories','operators','rooms'
        ])->where('id', $id)->first();

        return $clinic;
    }

    public function findDoctorByClinicId($id)
    {
        $clinic = $this->clinic->active()->with([
          'doctors'
        ])->where('id', $id)->first();

        return $clinic;
    }

    public function findServicesByClinicId($id)
    {
        $clinic = $this->clinic->active()->with([
          'services'
        ])->where('id', $id)->first();

        return $clinic;
    }

    public function restoreSoftDelte($model)
    {
        $model->restore();
    }

    public function translateTable($model, $request)
    {
        foreach ($request['title'] as $locale => $value) {
            $model->translateOrNew($locale)->title           = $value;
            $model->translateOrNew($locale)->slug            = slugfy($value);
            $model->translateOrNew($locale)->description     = $request['description'][$locale];
            $model->translateOrNew($locale)->open_time_message  = $request['open_time_message'][$locale];
        }

        $model->save();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $model = $this->findById($id);

            if ($model->trashed()) :
                $model->forceDelete();
            else :
                    $model->delete();
            endif;

                DB::commit();
                return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {
            foreach ($request['ids'] as $id) {
                $model = $this->delete($id);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->clinic->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere(function ($query) use ($request) {
                $query->whereHas('translations', function ($query) use ($request) {
                    $query->where('description', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('title', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('slug', 'like', '%' . $request->input('search.value') . '%');
                });
            });
        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
        // Search Clinics by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '') {
            $query->whereDate('created_at', '>=', $request['req']['from']);
        }

        if (isset($request['req']['to']) && $request['req']['to'] != '') {
            $query->whereDate('created_at', '<=', $request['req']['to']);
        }

        if (isset($request['req']['status']) &&  $request['req']['status'] == '1') {
            $query->active();
        }

        if (isset($request['req']['status']) &&  $request['req']['status'] == '0') {
            $query->unactive();
        }

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only') {
            $query->onlyDeleted();
        }

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with') {
            $query->withDeleted();
        }

        return $query;
    }
}
