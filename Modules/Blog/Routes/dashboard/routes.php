<?php

Route::group(['prefix' => 'blogs'], function () {

  	Route::get('/' ,'BlogController@index')
  	->name('dashboard.blogs.index')
    ->middleware(['permission:show_blogs']);

  	Route::get('datatable'	,'BlogController@datatable')
  	->name('dashboard.blogs.datatable')
  	->middleware(['permission:show_blogs']);

  	Route::get('create'		,'BlogController@create')
  	->name('dashboard.blogs.create')
    ->middleware(['permission:add_blogs']);

  	Route::post('/'			,'BlogController@store')
  	->name('dashboard.blogs.store')
    ->middleware(['permission:add_blogs']);

  	Route::get('{id}/edit'	,'BlogController@edit')
  	->name('dashboard.blogs.edit')
    ->middleware(['permission:edit_blogs']);

  	Route::put('{id}'		,'BlogController@update')
  	->name('dashboard.blogs.update')
    ->middleware(['permission:edit_blogs']);

  	Route::delete('{id}'	,'BlogController@destroy')
  	->name('dashboard.blogs.destroy')
    ->middleware(['permission:delete_blogs']);

  	Route::get('deletes'	,'BlogController@deletes')
  	->name('dashboard.blogs.deletes')
    ->middleware(['permission:delete_blogs']);

  	Route::get('{id}','BlogController@show')
  	->name('dashboard.blogs.show')
    ->middleware(['permission:show_blogs']);

});
