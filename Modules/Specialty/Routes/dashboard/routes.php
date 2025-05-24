<?php

Route::group(['prefix' => 'specialties'], function () {

  	Route::get('/' ,'SpecialtyController@index')
  	->name('dashboard.specialties.index')
    ->middleware(['permission:show_specialties']);

  	Route::get('datatable'	,'SpecialtyController@datatable')
  	->name('dashboard.specialties.datatable')
  	->middleware(['permission:show_specialties']);

  	Route::get('create'		,'SpecialtyController@create')
  	->name('dashboard.specialties.create')
    ->middleware(['permission:add_specialties']);

  	Route::post('/'			,'SpecialtyController@store')
  	->name('dashboard.specialties.store')
    ->middleware(['permission:add_specialties']);

  	Route::get('{id}/edit'	,'SpecialtyController@edit')
  	->name('dashboard.specialties.edit')
    ->middleware(['permission:edit_specialties']);

  	Route::put('{id}'		,'SpecialtyController@update')
  	->name('dashboard.specialties.update')
    ->middleware(['permission:edit_specialties']);

  	Route::delete('{id}'	,'SpecialtyController@destroy')
  	->name('dashboard.specialties.destroy')
    ->middleware(['permission:delete_specialties']);

  	Route::get('deletes'	,'SpecialtyController@deletes')
  	->name('dashboard.specialties.deletes')
    ->middleware(['permission:delete_specialties']);

  	Route::get('{id}','SpecialtyController@show')
  	->name('dashboard.specialties.show')
    ->middleware(['permission:show_specialties']);

});
