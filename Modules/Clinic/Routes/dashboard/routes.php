<?php

Route::group(['prefix' => 'clinics'], function () {

    Route::get('sorting' ,'ClinicController@sorting')
    ->name('dashboard.clinics.sorting')
    ->middleware(['permission:show_clinics']);

    Route::get('store/sorting' ,'ClinicController@storeSorting')
    ->name('dashboard.clinics.store.sorting')
    ->middleware(['permission:show_clinics']);

    Route::get('details' ,'ClinicController@detailsByClinicId')
    ->name('dashboard.clinics.details')
    ->middleware(['permission:show_clinics']);

    Route::get('doctors' ,'ClinicController@doctorsByClinicId')
    ->name('dashboard.clinics.doctors')
    ->middleware(['permission:show_clinics']);

    Route::get('doctors2' ,'ClinicController@doctorsByClinicId2')
    ->name('dashboard.clinics.doctors2')
    ->middleware(['permission:show_clinics']);

    Route::get('services' ,'ClinicController@servicesByClinicId')
    ->name('dashboard.clinics.services')
    ->middleware(['permission:show_clinics']);

  	Route::get('/' ,'ClinicController@index')
  	->name('dashboard.clinics.index')
    ->middleware(['permission:show_clinics']);

  	Route::get('datatable'	,'ClinicController@datatable')
  	->name('dashboard.clinics.datatable')
  	->middleware(['permission:show_clinics']);

  	Route::get('create'		,'ClinicController@create')
  	->name('dashboard.clinics.create')
    ->middleware(['permission:add_clinics']);

  	Route::post('/'			,'ClinicController@store')
  	->name('dashboard.clinics.store')
    ->middleware(['permission:add_clinics']);

  	Route::get('{id}/edit'	,'ClinicController@edit')
  	->name('dashboard.clinics.edit')
    ->middleware(['permission:edit_clinics']);

  	Route::put('{id}'		,'ClinicController@update')
  	->name('dashboard.clinics.update')
    ->middleware(['permission:edit_clinics']);

  	Route::delete('{id}'	,'ClinicController@destroy')
  	->name('dashboard.clinics.destroy')
    ->middleware(['permission:delete_clinics']);

  	Route::get('deletes'	,'ClinicController@deletes')
  	->name('dashboard.clinics.deletes')
    ->middleware(['permission:delete_clinics']);

  	Route::get('{id}','ClinicController@show')
  	->name('dashboard.clinics.show')
    ->middleware(['permission:show_clinics']);

});
