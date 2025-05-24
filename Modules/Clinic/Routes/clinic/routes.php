<?php

Route::group(['prefix' => 'clinics'], function () {

    Route::get('details' ,'ClinicController@detailsByClinicId')
    ->name('clinic.clinics.details');

  	// Route::get('/' ,'ClinicController@index')
  	// ->name('clinic.clinics.index');

  	Route::get('datatable'	,'ClinicController@datatable')
  	->name('clinic.clinics.datatable');

  	// Route::get('create'		,'ClinicController@create')
  	// ->name('clinic.clinics.create');

  	Route::post('/'			,'ClinicController@store')
  	->name('clinic.clinics.store');

  	Route::get('{id}/edit'	,'ClinicController@edit')
  	->name('clinic.clinics.edit');

  	Route::put('{id}'		,'ClinicController@update')
  	->name('clinic.clinics.update');

  	Route::delete('{id}'	,'ClinicController@destroy')
  	->name('clinic.clinics.destroy');

  	Route::get('deletes'	,'ClinicController@deletes')
  	->name('clinic.clinics.deletes');

  	Route::get('{id}','ClinicController@show')
  	->name('clinic.clinics.show');

});
