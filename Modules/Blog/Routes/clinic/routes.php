<?php

Route::group(['prefix' => 'blogs'], function () {

  	Route::get('/' ,'BlogController@index')
  	->name('clinic.blogs.index');

  	Route::get('datatable'	,'BlogController@datatable')
  	->name('clinic.blogs.datatable');

  	Route::get('create'		,'BlogController@create')
  	->name('clinic.blogs.create');

  	Route::post('/'			,'BlogController@store')
  	->name('clinic.blogs.store');

  	Route::get('{id}/edit'	,'BlogController@edit')
  	->name('clinic.blogs.edit');

  	Route::put('{id}'		,'BlogController@update')
  	->name('clinic.blogs.update');

  	Route::delete('{id}'	,'BlogController@destroy')
  	->name('clinic.blogs.destroy');

  	Route::get('deletes'	,'BlogController@deletes')
  	->name('clinic.blogs.deletes');

  	Route::get('{id}','BlogController@show')
  	->name('clinic.blogs.show');

});
