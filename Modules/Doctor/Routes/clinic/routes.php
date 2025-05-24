<?php

Route::group(['prefix' => 'doctors'], function () {

    Route::get('services' ,'DoctorController@services')
  	->name('clinic.doctors.services');

  	Route::get('/' ,'DoctorController@index')
  	->name('clinic.doctors.index');

  	Route::get('datatable'	,'DoctorController@datatable')
  	->name('clinic.doctors.datatable');

  	Route::get('create'		,'DoctorController@create')
  	->name('clinic.doctors.create');

  	Route::post('/'			,'DoctorController@store')
  	->name('clinic.doctors.store');

  	Route::get('{id}/edit'	,'DoctorController@edit')
  	->name('clinic.doctors.edit');

  	Route::put('{id}'		,'DoctorController@update')
  	->name('clinic.doctors.update');

  	Route::delete('{id}'	,'DoctorController@destroy')
  	->name('clinic.doctors.destroy');

  	Route::get('deletes'	,'DoctorController@deletes')
  	->name('clinic.doctors.deletes');

  	Route::get('{id}','DoctorController@show')
  	->name('clinic.doctors.show');

});
