<?php

Route::group(['prefix' => 'services'], function () {

  	Route::get('/' ,'ServiceController@index')
  	->name('dashboard.services.index')
    ->middleware(['permission:show_services']);

  	Route::get('datatable'	,'ServiceController@datatable')
  	->name('dashboard.services.datatable')
  	->middleware(['permission:show_services']);

  	Route::get('create'		,'ServiceController@create')
  	->name('dashboard.services.create')
    ->middleware(['permission:add_services']);

  	Route::post('/'			,'ServiceController@store')
  	->name('dashboard.services.store')
    ->middleware(['permission:add_services']);

  	Route::get('{id}/edit'	,'ServiceController@edit')
  	->name('dashboard.services.edit')
    ->middleware(['permission:edit_services']);

  	Route::put('{id}'		,'ServiceController@update')
  	->name('dashboard.services.update')
    ->middleware(['permission:edit_services']);

  	Route::delete('{id}'	,'ServiceController@destroy')
  	->name('dashboard.services.destroy')
    ->middleware(['permission:delete_services']);

  	Route::get('deletes'	,'ServiceController@deletes')
  	->name('dashboard.services.deletes')
    ->middleware(['permission:delete_services']);

  	Route::get('{id}','ServiceController@show')
  	->name('dashboard.services.show')
    ->middleware(['permission:show_services']);

});
