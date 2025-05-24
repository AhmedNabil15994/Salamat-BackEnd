<?php

namespace Modules\Category\Repositories\Clinic;

use Modules\Category\Entities\Category;
use ClinicFacade;
use DB;

class CategoryRepository
{

    function __construct(Category $category)
    {
        $this->category   = $category;
    }public function sorting($request)
    {
        DB::beginTransaction();

        try {

            foreach ($request['category'] as $key => $value) {

              $key++;

              $this->category->find($value)->update([
                  'sorting' => $key,
              ]);

            }

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $categories = $this->category->where('clinic_id',ClinicFacade::id())->active()->orderBy($order, $sort)->get();
        return $categories;
    }

    public function getAllGroupByClinic($order = 'id', $sort = 'desc')
    {
        $categories = $this->category->where('clinic_id',ClinicFacade::id())->with('clinic')->orderBy($order, $sort)->get()->groupBy('clinic.title');
        return $categories;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $categories = $this->category->where('clinic_id',ClinicFacade::id())->orderBy($order, $sort)->get();
        return $categories;
    }

    public function findById($id)
    {
        $category = $this->category->where('clinic_id',ClinicFacade::id())->withDeleted()->find($id);
        return $category;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

          $image = $request['image'] ? path_without_domain($request['image']) : setting('logo');

          $category = $this->category->create([
            'clinic_id'         => ClinicFacade::id(),
            'status'            => $request->status ? 1 : 0,
            'image'             => $image,
          ]);

          $this->translateTable($category,$request);

          DB::commit();
          return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function update($request,$id)
    {
        DB::beginTransaction();

        $category = $this->findById($id);

        $restore = $request->restore ? $this->restoreSoftDelte($category) : null;

        $image = $request['image'] ? path_without_domain($request['image']) : $category->image;

        try {

            $category->update([
              'clinic_id'         => ClinicFacade::id(),
              'status'            => $request->status ? 1 : 0,
              'image'             => $image,
            ]);

            $this->translateTable($category,$request);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelte($model)
    {
        $model->restore();
    }

    public function translateTable($model,$request)
    {
        foreach ($request['title'] as $locale => $value) {
            $model->translateOrNew($locale)->title           = $value;
            $model->translateOrNew($locale)->slug            = slugfy($value);
        }

        $model->save();
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

    public function QueryTable($request)
    {
        $query = $this->category->where('clinic_id',ClinicFacade::id())->where(function($query) use($request){
                      $query->where('id', 'like' , '%'. $request->input('search.value') .'%');
                      $query->orWhere( function( $query ) use($request){
                          $query->whereHas('translations', function($query) use($request) {
                              $query->where('title'        , 'like' , '%'. $request->input('search.value') .'%');
                              $query->orWhere('slug'             , 'like' , '%'. $request->input('search.value') .'%');
                          });
                      });
                });

        $query = $this->filterDataTable($query,$request);

        return $query;
    }

    public function filterDataTable($query,$request)
    {
        // Search Categories by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);

        if (isset($request['req']['status']) &&  $request['req']['status'] == '1')
            $query->active();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '0')
            $query->unactive();

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with')
            $query->withDeleted();

        return $query;
    }

}
