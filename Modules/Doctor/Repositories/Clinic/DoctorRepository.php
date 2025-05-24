<?php

namespace Modules\Doctor\Repositories\Clinic;

use Modules\Core\Traits\SyncRelationModel;
use Modules\Doctor\Entities\Doctor;
use ClinicFacade;
use Hash;
use DB;

class DoctorRepository
{
    use SyncRelationModel;

    function __construct(Doctor $doctor)
    {
        $this->doctor      = $doctor;
    }

    public function getServicesByDoctorId($request)
    {
        $doctor = $this->doctor->with(['services'])->where('id',$request['doctor_id'])->first();
        return $doctor;
    }

    /*
    * Get All Normal Doctors with Doctor Roles
    */
    public function getAllDoctors($order = 'id', $sort = 'desc')
    {
        $doctors = $this->doctor->whereHas('clinic', function($query){
                    $query->where('clinic_id',ClinicFacade::id());
                  })->whereHas('roles.perms', function($query){
                    $query->where('name','doctor_access');
                  })->orderBy($order, $sort)->get();
        return $doctors;
    }

    public function countDoctors($order = 'id', $sort = 'desc')
    {
        $doctors = $this->doctor->whereHas('clinic', function($query){
                        $query->where('clinic_id',ClinicFacade::id());
                  })->whereHas('roles.perms', function($query){
                        $query->where('name','doctor_access');
                  })->count();

        return $doctors;
    }

    /*
    * Find Object By ID
    */
    public function findById($id)
    {
        $doctor = $this->doctor->whereHas('clinic', function($query){
                    $query->where('clinic_id',ClinicFacade::id());
                  })->withDeleted()->find($id);
        return $doctor;
    }

    /*
    * Find Object By ID
    */
    public function findByEmail($email)
    {
        $doctor = $this->doctor->whereHas('clinic', function($query){
                    $query->where('clinic_id',ClinicFacade::id());
                  })->where('email',$email)->first();
        return $doctor;
    }

    /*
    * Create New Object & Insert to DB
    */
    public function create($request)
    {
        DB::beginTransaction();

        try {
                $image = $request['image'] ? path_without_domain($request['image']) : '/uploads/users/user.png';

                $doctor = $this->doctor->create([
                  'name'          => $request['name'],
                  'email'         => $request['email'],
                  'status'        => $request->status ? 1 : 0,
                  'mobile'        => $request['mobile'],
                  'password'      => Hash::make($request['password']),
                  'image'         => $image,
                ]);

                $doctor->specialties()->sync($request['specialty_id']);

                if($request['roles'] != null)
                  $this->syncRoles($doctor,$request);

                $this->createOrUpdateProfile($doctor,$request);
                $this->clinic($doctor,$request);
                $this->contacts($doctor,$request);
                $this->gallery($doctor,$request);
                $this->socialMedia($doctor,$request);
                $this->shift($doctor,$request);
                $this->offDays($doctor,$request);
                $this->offTimes($doctor,$request);
                $this->offDates($doctor,$request);
                $this->customOff($doctor,$request);

          DB::commit();
          return $doctor;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    /*
    * Find Object By ID & Update to DB
    */
    public function update($request,$id)
    {
        DB::beginTransaction();

        $doctor = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelte($doctor) : null;

        try {

          $image = $request['image'] ? path_without_domain($request['image']) : $doctor->image;

          if ($request['password'] == null)
              $password = $doctor['password'];
          else
              $password  = Hash::make($request['password']);

            $doctor->update([
                'name'          => $request['name'],
                'status'        => $request->status ? 1 : 0,
                'email'         => $request['email'],
                'mobile'        => $request['mobile'],
                'password'      => $password,
                'image'         => $image,
            ]);

            if($request['roles'] != null){
                DB::table('role_user')->where('user_id',$id)->delete();
                foreach ($request['roles'] as $key => $value) {
                    $doctor->attachRole($value);
                }
            }

            $doctor->specialties()->sync($request['specialty_id']);

            $this->createOrUpdateProfile($doctor,$request);
            $this->clinic($doctor,$request);
            $this->contacts($doctor,$request);
            $this->gallery($doctor,$request);
            $this->socialMedia($doctor,$request);
            $this->shift($doctor,$request);
            $this->offDays($doctor,$request);
            $this->offTimes($doctor,$request);
            $this->offDates($doctor,$request);
            $this->customOff($doctor,$request);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function syncRoles($doctor,$request)
    {
        foreach ($request['roles'] as $key => $value) {
            $doctor->attachRole($value);
        }

        return true;
    }

    public function createOrUpdateProfile($doctor,$request)
    {
        $profile = $doctor->profile()->updateOrCreate(
            [
                'doctor_id'  => $doctor['id']
            ],
            [
                'status'     => true,
            ]
        );

        foreach ($request['about'] as $locale => $value) {
            $profile->translateOrNew($locale)->about      = $value;
            $profile->translateOrNew($locale)->job_title  = $request['job_title'][$locale];
            $profile->translateOrNew($locale)->name       = $request['name_'][$locale];
        }

        $profile->save();

        return $profile;
    }

    public function shift($doctor,$request)
    {
        $doctor->shift()->updateOrCreate(
        [
            'shiftable_type' => 'Modules\Doctor\Entities\Doctor',
            'shiftable_id'   => $doctor['id']
        ],
        [
            'start_time'   => date('H:i:s', strtotime($request['open_time'])),
            'end_time'     => date('H:i:s', strtotime($request['close_time'])),
        ]);
    }

    public function clinic($doctor,$request)
    {
        $doctor->clinic()->updateOrCreate(
        [
            'doctor_id' => $doctor['id']
        ],
        [
            'clinic_id'   => ClinicFacade::id()
        ]);
    }

    public function offDays($doctor,$request)
    {
        $doctor->offDays()->delete();

        if (isset($request['off_days'])) {

            foreach ($request['off_days'] as $key => $day) {

                $doctor->offDays()->updateOrCreate([
                    'day'  => $day,
                ],[
                    'day'          => $day,
                    'start_time'   => date('H:i:s', strtotime($request['day_time_from'][$key])),
                    'end_time'     => date('H:i:s', strtotime($request['day_time_to'][$key])),
                ]);

            }

        }
    }

    public function offTimes($doctor,$request)
    {
        $oldValues = isset($request['old_off_times']['old']) ? $request['old_off_times']['old'] : [];

        $sync = $this->syncRelation($doctor,'offTimes',$oldValues);

        if ($sync['deleted']) {
           $doctor->offTimes()->whereIn('id', $sync['deleted'])->delete();
        }

        if ($sync['updated']) {
            foreach ($sync['updated'] as $id) {
                $doctor->offTimes()->find($id)->update([
                    'time_from'   => date('H:i:s', strtotime($request['time_from_old'][$id])),
                    'time_to'     => date('H:i:s', strtotime($request['time_to_old'][$id])),
                ]);
            }
        }

        if ($request['time_to']) {
            foreach ($request['time_to'] as $key => $timeTo) {
                $doctor->offTimes()->create([
                  'time_to'     => date('H:i:s', strtotime($timeTo)),
                  'time_from'   => date('H:i:s', strtotime($request['time_from'][$key])),
                ]);
            }
        }
    }

    public function offDates($doctor,$request)
    {
        $oldValues = isset($request['old_off_dates']['old']) ? $request['old_off_dates']['old'] : [];

        $sync = $this->syncRelation($doctor,'offDates',$oldValues);

        if ($sync['deleted']) {
           $doctor->offDates()->whereIn('id', $sync['deleted'])->delete();
        }

        if ($sync['updated']) {
            foreach ($sync['updated'] as $id) {
                $doctor->offDates()->find($id)->update([
                  'date_from'  => $request['date_from_old'][$id],
                  'date_to'    => $request['date_to_old'][$id],
                ]);
            }
        }

        if ($request['date_from']) {
            foreach ($request['date_from'] as $key => $dateFrom) {
                $doctor->offDates()->create([
                  'date_from'    => $dateFrom,
                  'date_to'      => $request['date_to'][$key],
                ]);
            }
        }
    }

    public function customOff($doctor,$request)
    {
        $oldValues = isset($request['old_custom_off']['old']) ? $request['old_custom_off']['old'] : [];

        $sync = $this->syncRelation($doctor,'offCustomDates',$oldValues);

        if ($sync['deleted']) {
           $doctor->offCustomDates()->whereIn('id', $sync['deleted'])->delete();
        }

        if ($sync['updated']) {
            foreach ($sync['updated'] as $id) {
                $doctor->offCustomDates()->find($id)->update([
                  'date'       => $request['custom_old_date'][$id],
                  'time_from'  => date('H:i:s', strtotime($request['custom_time_from_old'][$id])),
                  'time_to'    => date('H:i:s', strtotime($request['custom_to_from_old'][$id])),
                ]);
            }
        }

        if ($request['custom_date']) {
            foreach ($request['custom_date'] as $key => $customDate) {

                $doctor->offCustomDates()->create([
                  'date'      => $customDate,
                  'time_from' => date('H:i:s', strtotime($request['custom_time_from'][$key])),
                  'time_to'   => date('H:i:s', strtotime($request['custom_time_to'][$key])),
                ]);

            }
        }
    }

    public function contacts($doctor,$request)
    {
        $oldValues = isset($request['mobile_']['old']) ? $request['mobile_']['old'] : [];

        $sync = $this->syncRelation($doctor,'contacts',$oldValues);

        if ($sync['deleted']) {
           $doctor->contacts()->whereIn('id', $sync['deleted'])->delete();
        }

        if ($sync['updated']) {

          foreach ($sync['updated'] as $id) {
            $doctor->contacts()->find($id)->update([
              'mobile' => $request['mobile_']['old'][$id]
            ]);
          }

        }

        if ($request['mobile_']['new']) {
            foreach ($request['mobile_']['new'] as $value) {
              if ($value != null)
                  $doctor->contacts()->create([
                    'mobile'  => $value
                  ]);
            }
        }
    }

    public function gallery($doctor,$request)
    {

        $oldValues = isset($request['images']['old']) ? $request['images']['old'] : [];

        $sync = $this->syncRelation($doctor,'gallery',$oldValues);

        if ($sync['deleted']) {
           $doctor->gallery()->whereIn('id', $sync['deleted'])->delete();
        }

        if ($sync['updated']) {

          foreach ($sync['updated'] as $id) {
            $doctor->gallery()->find($id)->update([
              'image' => path_without_domain($request['images']['old'][$id])
            ]);
          }

        }

        if ($request['images_new']) {
            foreach ($request['images_new'] as $value) {
              if ($value != null)
                  $doctor->gallery()->create([
                    'image'  => path_without_domain($value)
                  ]);
            }
        }
    }

    public function socialMedia($doctor,$request)
    {
        foreach ($request['social'] as $key => $value) {

            $doctor->socialMedia()->updateOrCreate(
            [
              'name'  => $key
            ],
            [
              'link'  => $value ? $value : '#'
            ]);

        }
    }

    public function restoreSoftDelte($model)
    {
        $model->restore();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $model = $this->findById($id);

            if ($model->trashed()):
              $model->forceDelete();
            else:
              $model->delete();
            endif;

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    /*
    * Find all Objects By IDs & Delete it from DB
    */
    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {

            foreach ($request['ids'] as $id) {
                $model = $this->delete($id);
            }

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    /*
    * Generate Datatable
    */
    public function QueryTable($request)
    {
        $query = $this->doctor->whereHas('clinic', function($query){
                    $query->where('clinic_id',ClinicFacade::id());
                  })->where('id','!=',auth()->id())->whereHas('roles.perms', function($query){
                        $query->where('name','doctor_access');
                  })->where(function($query) use($request){
                        $query->where('id'                , 'like' , '%'. $request->input('search.value') .'%');
                        $query->orWhere('name'            , 'like' , '%'. $request->input('search.value') .'%');
                        $query->orWhere('email'           , 'like' , '%'. $request->input('search.value') .'%');
                        $query->orWhere('mobile'          , 'like' , '%'. $request->input('search.value') .'%');
                  });

        $query = $this->filterDataTable($query,$request);

        return $query;
    }

    /*
    * Filteration for Datatable
    */
    public function filterDataTable($query,$request)
    {
        // Search Doctors by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);


        if (isset($request['req']['roles'])){

            $query->whereHas('roles', function ($query) use ($request){
                $query->where('id',$request['req']['roles']);
            });

        }

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with')
            $query->withDeleted();


        return $query;
    }

}
