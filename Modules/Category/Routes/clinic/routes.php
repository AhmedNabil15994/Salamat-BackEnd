<?php

Route::group(['prefix' => 'categories'], function () {

    Route::get('sorting' ,'CategoryController@sorting')
    ->name('clinic.categories.sorting');

    Route::get('store/sorting' ,'CategoryController@storeSorting')
    ->name('clinic.categories.store.sorting');

  	Route::get('/' ,'CategoryController@index')
  	->name('clinic.categories.index');

  	Route::get('datatable'	,'CategoryController@datatable')
  	->name('clinic.categories.datatable');

  	Route::get('create'		,'CategoryController@create')
  	->name('clinic.categories.create');

  	Route::post('/'			,'CategoryController@store')
  	->name('clinic.categories.store');

  	Route::get('{id}/edit'	,'CategoryController@edit')
  	->name('clinic.categories.edit');

  	Route::put('{id}'		,'CategoryController@update')
  	->name('clinic.categories.update');

  	Route::delete('{id}'	,'CategoryController@destroy')
  	->name('clinic.categories.destroy');

  	Route::get('deletes'	,'CategoryController@deletes')
  	->name('clinic.categories.deletes');

  	Route::get('{id}','CategoryController@show')
  	->name('clinic.categories.show');

});
