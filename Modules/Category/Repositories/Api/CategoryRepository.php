<?php

namespace Modules\Category\Repositories\Api;

use Modules\Category\Entities\Category;
use DB;

class CategoryRepository
{

    function __construct(Category $category)
    {
        $this->category   = $category;
    }

    public function getAllActivePaginate($request,$order = 'sorting', $sort = 'ASC')
    {
        $categories = $this->category->active()
                      ->with([
                        'services' => function ($query) use($request){
                            $query->whereHas('doctor', function($query) use($request){
                               $query->where('doctor_id',$request['doctor_id']);
                            })->where('hidden',false)->active()->with([
                                'points',
                                'doctor' => function ($query) use($request){
                                    $query->with([
                                        'doctor' => function ($query) use($request){
                                            $query->with([
                                            'offTimes','offDates','offDays','offCustomDates','shift','profile','rates',
                                                'upcomingOrders' => function ($query) use($request){
                                                    $query->with([
                                                        'transactions','orderStatus','rates'
                                                    ]);
                                                },
                                            ]);
                                        },
                                    ]);
                                    $query->where('doctor_id',$request['doctor_id']);
                                },
                            ])->orderBy('id','DESC');
                        },
                      ])->whereHas('services', function($query) use($request){
                         $query->where('hidden',false)->active()->whereHas('doctor', function($query) use($request){
                            $query->where('doctor_id',$request['doctor_id']);
                         });
                      })->orderBy($order, $sort)->paginate(24);

        return $categories;
    }

    public function findById($id)
    {
        return $this->category->active()
        ->with([
          'services' => function ($query) use($id){
              $query->where('hidden',false)->active()->with([
                'doctor' => function ($query) use($id){
                    $query->where('doctor_id',$id);
                },
              ])->orderBy('id','DESC');
          },
        ])->whereHas('services', function($query) use($id){
           $query->where('hidden',false)->active()->whereHas('doctor', function($query) use($id){
              $query->where('doctor_id',$id);
           });
        })->find($id);
    }

}
