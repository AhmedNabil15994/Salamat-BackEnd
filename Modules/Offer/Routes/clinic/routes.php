<?php

Route::group(['prefix' => 'offers'], function () {

  	Route::get('/' ,'OfferController@index')
  	->name('clinic.offers.index');

  	Route::get('datatable'	,'OfferController@datatable')
  	->name('clinic.offers.datatable');

  	Route::get('create'		,'OfferController@create')
  	->name('clinic.offers.create');

  	Route::post('/'			,'OfferController@store')
  	->name('clinic.offers.store');

  	Route::get('{id}/edit'	,'OfferController@edit')
  	->name('clinic.offers.edit');

  	Route::put('{id}'		,'OfferController@update')
  	->name('clinic.offers.update');

  	Route::delete('{id}'	,'OfferController@destroy')
  	->name('clinic.offers.destroy');

  	Route::get('deletes'	,'OfferController@deletes')
  	->name('clinic.offers.deletes');

  	Route::get('{id}','OfferController@show')
  	->name('clinic.offers.show');

});


Route::group(['prefix' => 'booked'], function () {

  	Route::get('/' ,'BookedOfferController@index')
  	->name('clinic.booked_offers.index');

  	Route::get('datatable'	,'BookedOfferController@datatable')
  	->name('clinic.booked_offers.datatable');

  	Route::get('create'		,'BookedOfferController@create')
  	->name('clinic.booked_offers.create');

  	Route::post('/'			,'BookedOfferController@store')
  	->name('clinic.booked_offers.store');

  	Route::get('{id}/edit'	,'BookedOfferController@edit')
  	->name('clinic.booked_offers.edit');

  	Route::put('{id}'		,'BookedOfferController@update')
  	->name('clinic.booked_offers.update');

  	Route::delete('{id}'	,'BookedOfferController@destroy')
  	->name('clinic.booked_offers.destroy');

  	Route::get('deletes'	,'BookedOfferController@deletes')
  	->name('clinic.booked_offers.deletes');

  	Route::get('{id}','BookedOfferController@show')
  	->name('clinic.booked_offers.show');

});
