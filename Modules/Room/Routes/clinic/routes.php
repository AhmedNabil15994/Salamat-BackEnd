<?php

Route::group(['prefix' => 'rooms'], function () {

  	Route::get('/' ,'RoomController@index')
  	->name('clinic.rooms.index');

  	Route::get('datatable'	,'RoomController@datatable')
  	->name('clinic.rooms.datatable');

  	Route::get('create'		,'RoomController@create')
  	->name('clinic.rooms.create');

  	Route::post('/'			,'RoomController@store')
  	->name('clinic.rooms.store');

  	Route::get('{id}/edit'	,'RoomController@edit')
  	->name('clinic.rooms.edit');

  	Route::put('{id}'		,'RoomController@update')
  	->name('clinic.rooms.update');

  	Route::delete('{id}'	,'RoomController@destroy')
  	->name('clinic.rooms.destroy');

  	Route::get('deletes'	,'RoomController@deletes')
  	->name('clinic.rooms.deletes');

  	Route::get('{id}','RoomController@show')
  	->name('clinic.rooms.show');

});
