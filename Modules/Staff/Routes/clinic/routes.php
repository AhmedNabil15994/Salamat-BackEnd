<?php

Route::group(['prefix' => 'staffs'], function () {

  	Route::get('/' ,'StaffController@index')
  	->name('clinic.staffs.index');

  	Route::get('datatable'	,'StaffController@datatable')
  	->name('clinic.staffs.datatable');

  	Route::get('create'		,'StaffController@create')
  	->name('clinic.staffs.create');

  	Route::post('/'			,'StaffController@store')
  	->name('clinic.staffs.store');

  	Route::get('{id}/edit'	,'StaffController@edit')
  	->name('clinic.staffs.edit');

  	Route::put('{id}'		,'StaffController@update')
  	->name('clinic.staffs.update');

  	Route::delete('{id}'	,'StaffController@destroy')
  	->name('clinic.staffs.destroy');

  	Route::get('deletes'	,'StaffController@deletes')
  	->name('clinic.staffs.deletes');

  	Route::get('{id}','StaffController@show')
  	->name('clinic.staffs.show');

});
