<?php

Route::group(['prefix' => 'users'], function () {

  	Route::get('/' ,'UserController@index')
  	->name('dashboard.users.index')
    ->middleware(['permission:show_users']);

  	Route::get('datatable'	,'UserController@datatable')
  	->name('dashboard.users.datatable')
  	->middleware(['permission:show_users']);

  	Route::get('create'		,'UserController@create')
  	->name('dashboard.users.create')
    ->middleware(['permission:add_users']);

  	Route::post('/'			,'UserController@store')
  	->name('dashboard.users.store')
    ->middleware(['permission:add_users']);

  	Route::get('{id}/edit'	,'UserController@edit')
  	->name('dashboard.users.edit')
    ->middleware(['permission:edit_users']);

  	Route::put('{id}'		,'UserController@update')
  	->name('dashboard.users.update')
    ->middleware(['permission:edit_users']);

  	Route::delete('{id}'	,'UserController@destroy')
  	->name('dashboard.users.destroy')
    ->middleware(['permission:delete_users']);

  	Route::get('deletes'	,'UserController@deletes')
  	->name('dashboard.users.deletes')
    ->middleware(['permission:delete_users']);

  	Route::get('{id}','UserController@show')
  	->name('dashboard.users.show')
    ->middleware(['permission:show_users']);

});


Route::group(['prefix' => 'admins'], function () {

  	Route::get('/' ,'AdminController@index')
  	->name('dashboard.admins.index')
    ->middleware(['permission:show_admins']);

  	Route::get('datatable'	,'AdminController@datatable')
  	->name('dashboard.admins.datatable')
  	->middleware(['permission:show_admins']);

  	Route::get('create'		,'AdminController@create')
  	->name('dashboard.admins.create')
    ->middleware(['permission:add_admins']);

  	Route::post('/'			,'AdminController@store')
  	->name('dashboard.admins.store')
    ->middleware(['permission:add_admins']);

  	Route::get('{id}/edit'	,'AdminController@edit')
  	->name('dashboard.admins.edit')
    ->middleware(['permission:edit_admins']);

  	Route::put('{id}'		,'AdminController@update')
  	->name('dashboard.admins.update')
    ->middleware(['permission:edit_admins']);

  	Route::delete('{id}'	,'AdminController@destroy')
  	->name('dashboard.admins.destroy')
    ->middleware(['permission:delete_admins']);

  	Route::get('deletes'	,'AdminController@deletes')
  	->name('dashboard.admins.deletes')
    ->middleware(['permission:delete_admins']);

  	Route::get('{id}','AdminController@show')
  	->name('dashboard.admins.show')
    ->middleware(['permission:show_admins']);

});
