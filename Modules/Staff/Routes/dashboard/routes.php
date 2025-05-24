<?php

Route::group(['prefix' => 'staffs'], function () {

  	Route::get('/' ,'StaffController@index')
  	->name('dashboard.staffs.index')
    ->middleware(['permission:show_staffs']);

  	Route::get('datatable'	,'StaffController@datatable')
  	->name('dashboard.staffs.datatable')
  	->middleware(['permission:show_staffs']);

  	Route::get('create'		,'StaffController@create')
  	->name('dashboard.staffs.create')
    ->middleware(['permission:add_staffs']);

  	Route::post('/'			,'StaffController@store')
  	->name('dashboard.staffs.store')
    ->middleware(['permission:add_staffs']);

  	Route::get('{id}/edit'	,'StaffController@edit')
  	->name('dashboard.staffs.edit')
    ->middleware(['permission:edit_staffs']);

  	Route::put('{id}'		,'StaffController@update')
  	->name('dashboard.staffs.update')
    ->middleware(['permission:edit_staffs']);

  	Route::delete('{id}'	,'StaffController@destroy')
  	->name('dashboard.staffs.destroy')
    ->middleware(['permission:delete_staffs']);

  	Route::get('deletes'	,'StaffController@deletes')
  	->name('dashboard.staffs.deletes')
    ->middleware(['permission:delete_staffs']);

  	Route::get('{id}','StaffController@show')
  	->name('dashboard.staffs.show')
    ->middleware(['permission:show_staffs']);

});
