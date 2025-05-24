<?php

Route::group(['prefix' => 'rooms'], function () {

  	Route::get('/' ,'RoomController@index')
  	->name('dashboard.rooms.index')
    ->middleware(['permission:show_rooms']);

  	Route::get('datatable'	,'RoomController@datatable')
  	->name('dashboard.rooms.datatable')
  	->middleware(['permission:show_rooms']);

  	Route::get('create'		,'RoomController@create')
  	->name('dashboard.rooms.create')
    ->middleware(['permission:add_rooms']);

  	Route::post('/'			,'RoomController@store')
  	->name('dashboard.rooms.store')
    ->middleware(['permission:add_rooms']);

  	Route::get('{id}/edit'	,'RoomController@edit')
  	->name('dashboard.rooms.edit')
    ->middleware(['permission:edit_rooms']);

  	Route::put('{id}'		,'RoomController@update')
  	->name('dashboard.rooms.update')
    ->middleware(['permission:edit_rooms']);

  	Route::delete('{id}'	,'RoomController@destroy')
  	->name('dashboard.rooms.destroy')
    ->middleware(['permission:delete_rooms']);

  	Route::get('deletes'	,'RoomController@deletes')
  	->name('dashboard.rooms.deletes')
    ->middleware(['permission:delete_rooms']);

  	Route::get('{id}','RoomController@show')
  	->name('dashboard.rooms.show')
    ->middleware(['permission:show_rooms']);

});
