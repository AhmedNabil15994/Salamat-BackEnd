<?php

Route::group(['prefix' => 'booked_offers'], function () {

  	Route::get('/' ,'BookedOfferController@index')
  	->name('dashboard.booked_offers.index')
    ->middleware(['permission:show_offers']);

  	Route::get('datatable'	,'BookedOfferController@datatable')
  	->name('dashboard.booked_offers.datatable')
  	->middleware(['permission:show_offers']);

  	Route::get('create'		,'BookedOfferController@create')
  	->name('dashboard.booked_offers.create')
    ->middleware(['permission:add_offers']);

  	Route::post('/'			,'BookedOfferController@store')
  	->name('dashboard.booked_offers.store')
    ->middleware(['permission:add_offers']);

  	Route::get('{id}/edit'	,'BookedOfferController@edit')
  	->name('dashboard.booked_offers.edit')
    ->middleware(['permission:edit_offers']);

  	Route::put('{id}'		,'BookedOfferController@update')
  	->name('dashboard.booked_offers.update')
    ->middleware(['permission:edit_offers']);

  	Route::delete('{id}'	,'BookedOfferController@destroy')
  	->name('dashboard.booked_offers.destroy')
    ->middleware(['permission:delete_offers']);

  	Route::get('deletes'	,'BookedOfferController@deletes')
  	->name('dashboard.booked_offers.deletes')
    ->middleware(['permission:delete_offers']);

  	Route::get('{id}','BookedOfferController@show')
  	->name('dashboard.booked_offers.show')
    ->middleware(['permission:show_offers']);

});


Route::group(['prefix' => 'offers'], function () {

  	Route::get('/' ,'OfferController@index')
  	->name('dashboard.offers.index')
    ->middleware(['permission:show_offers']);

  	Route::get('datatable'	,'OfferController@datatable')
  	->name('dashboard.offers.datatable')
  	->middleware(['permission:show_offers']);

  	Route::get('create'		,'OfferController@create')
  	->name('dashboard.offers.create')
    ->middleware(['permission:add_offers']);

  	Route::post('/'			,'OfferController@store')
  	->name('dashboard.offers.store')
    ->middleware(['permission:add_offers']);

  	Route::get('{id}/edit'	,'OfferController@edit')
  	->name('dashboard.offers.edit')
    ->middleware(['permission:edit_offers']);

  	Route::put('{id}'		,'OfferController@update')
  	->name('dashboard.offers.update')
    ->middleware(['permission:edit_offers']);

  	Route::delete('{id}'	,'OfferController@destroy')
  	->name('dashboard.offers.destroy')
    ->middleware(['permission:delete_offers']);

  	Route::get('deletes'	,'OfferController@deletes')
  	->name('dashboard.offers.deletes')
    ->middleware(['permission:delete_offers']);

  	Route::get('{id}','OfferController@show')
  	->name('dashboard.offers.show')
    ->middleware(['permission:show_offers']);

});
