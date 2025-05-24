<?php

Route::group(['prefix' => 'services'], function () {

  	Route::get('/' ,'ServiceController@index')
  	->name('clinic.services.index');

  	Route::get('datatable'	,'ServiceController@datatable')
  	->name('clinic.services.datatable');

  	Route::get('create'		,'ServiceController@create')
  	->name('clinic.services.create');

  	Route::post('/'			,'ServiceController@store')
  	->name('clinic.services.store');

  	Route::get('{id}/edit'	,'ServiceController@edit')
  	->name('clinic.services.edit');

  	Route::put('{id}'		,'ServiceController@update')
  	->name('clinic.services.update');

  	Route::delete('{id}'	,'ServiceController@destroy')
  	->name('clinic.services.destroy');

  	Route::get('deletes'	,'ServiceController@deletes')
  	->name('clinic.services.deletes');

  	Route::get('{id}','ServiceController@show')
  	->name('clinic.services.show');

});
