<?php

Route::group(['prefix' => 'users'], function () {

  	Route::get('/' ,'UserController@index')
  	->name('clinic.users.index');

  	Route::get('datatable'	,'UserController@datatable')
  	->name('clinic.users.datatable');

  	Route::get('create'		,'UserController@create')
  	->name('clinic.users.create');

  	Route::post('/'			,'UserController@store')
  	->name('clinic.users.store');

  	Route::get('{id}/edit'	,'UserController@edit')
  	->name('clinic.users.edit');

  	Route::put('{id}'		,'UserController@update')
  	->name('clinic.users.update');

  	Route::delete('{id}'	,'UserController@destroy')
  	->name('clinic.users.destroy');

  	Route::get('deletes'	,'UserController@deletes')
  	->name('clinic.users.deletes');

  	Route::get('{id}','UserController@show')
  	->name('clinic.users.show');

});
