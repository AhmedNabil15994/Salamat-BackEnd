<?php

Route::group(['prefix' => 'cities'], function () {

  	Route::get('/' ,'CityController@index')
  	->name('dashboard.cities.index')
    ->middleware(['permission:show_cities']);

    Route::get('datatable'	,'CityController@datatable')
    ->name('dashboard.cities.datatable')
    ->middleware(['permission:show_cities']);

  	Route::get('create'		,'CityController@create')
  	->name('dashboard.cities.create')
    ->middleware(['permission:add_cities']);

  	Route::post('/'			,'CityController@store')
  	->name('dashboard.cities.store')
    ->middleware(['permission:add_cities']);

  	Route::get('{id}/edit'	,'CityController@edit')
  	->name('dashboard.cities.edit')
    ->middleware(['permission:edit_cities']);

  	Route::put('{id}'		,'CityController@update')
  	->name('dashboard.cities.update')
    ->middleware(['permission:edit_cities']);

  	Route::delete('{id}'	,'CityController@destroy')
  	->name('dashboard.cities.destroy')
    ->middleware(['permission:delete_cities']);

  	Route::get('deletes'	,'CityController@deletes')
  	->name('dashboard.cities.deletes')
    ->middleware(['permission:delete_cities']);

  	Route::get('{id}','CityController@show')
  	->name('dashboard.cities.show')
    ->middleware(['permission:show_cities']);

});

Route::group(['prefix' => 'countries'], function () {

  	Route::get('/' ,'CountryController@index')
  	->name('dashboard.countries.index')
    ->middleware(['permission:show_countries']);

  	Route::get('datatable'	,'CountryController@datatable')
  	->name('dashboard.countries.datatable')
  	->middleware(['permission:show_countries']);

  	Route::get('create'		,'CountryController@create')
  	->name('dashboard.countries.create')
    ->middleware(['permission:add_countries']);

  	Route::post('/'			,'CountryController@store')
  	->name('dashboard.countries.store')
    ->middleware(['permission:add_countries']);

  	Route::get('{id}/edit'	,'CountryController@edit')
  	->name('dashboard.countries.edit')
    ->middleware(['permission:edit_countries']);

  	Route::put('{id}'		,'CountryController@update')
  	->name('dashboard.countries.update')
    ->middleware(['permission:edit_countries']);

  	Route::delete('{id}'	,'CountryController@destroy')
  	->name('dashboard.countries.destroy')
    ->middleware(['permission:delete_countries']);

  	Route::get('deletes'	,'CountryController@deletes')
  	->name('dashboard.countries.deletes')
    ->middleware(['permission:delete_countries']);

  	Route::get('{id}','CountryController@show')
  	->name('dashboard.countries.show')
    ->middleware(['permission:show_countries']);

});

Route::group(['prefix' => 'states'], function () {

  	Route::get('/' ,'StateController@index')
  	->name('dashboard.states.index')
    ->middleware(['permission:show_states']);

  	Route::get('datatable'	,'StateController@datatable')
  	->name('dashboard.states.datatable')
  	->middleware(['permission:show_states']);

  	Route::get('create'		,'StateController@create')
  	->name('dashboard.states.create')
    ->middleware(['permission:add_states']);

  	Route::post('/'			,'StateController@store')
  	->name('dashboard.states.store')
    ->middleware(['permission:add_states']);

  	Route::get('{id}/edit'	,'StateController@edit')
  	->name('dashboard.states.edit')
    ->middleware(['permission:edit_states']);

  	Route::put('{id}'		,'StateController@update')
  	->name('dashboard.states.update')
    ->middleware(['permission:edit_states']);

  	Route::delete('{id}'	,'StateController@destroy')
  	->name('dashboard.states.destroy')
    ->middleware(['permission:delete_states']);

  	Route::get('deletes'	,'StateController@deletes')
  	->name('dashboard.states.deletes')
    ->middleware(['permission:delete_states']);

  	Route::get('{id}','StateController@show')
  	->name('dashboard.states.show')
    ->middleware(['permission:show_states']);

});
