<?php

Route::group(['prefix' => 'orders'], function () {

    Route::get('calendar' ,'OrderController@calendar')
  	->name('clinic.orders.calendar');

  	Route::get('/' ,'OrderController@index')
  	->name('clinic.orders.index');

  	Route::get('datatable'	,'OrderController@datatable')
  	->name('clinic.orders.datatable');

  	Route::get('create'		,'OrderController@create')
  	->name('clinic.orders.create');

  	Route::post('/'			,'OrderController@store')
  	->name('clinic.orders.store');

  	Route::get('{id}/edit'	,'OrderController@edit')
  	->name('clinic.orders.edit');

  	Route::put('{id}'		,'OrderController@update')
  	->name('clinic.orders.update');

  	Route::delete('{id}'	,'OrderController@destroy')
  	->name('clinic.orders.destroy');

  	Route::get('deletes'	,'OrderController@deletes')
  	->name('clinic.orders.deletes');

  	Route::get('{id}','OrderController@show')
  	->name('clinic.orders.show');

});


Route::group(['prefix' => 'order-statuses'], function () {

  	Route::get('/' ,'OrderStatusController@index')
  	->name('clinic.order-statuses.index')
    ->middleware(['permission:show_order_statuses']);

  	Route::get('datatable'	,'OrderStatusController@datatable')
  	->name('clinic.order-statuses.datatable')
  	->middleware(['permission:show_order_statuses']);

  	Route::get('create'		,'OrderStatusController@create')
  	->name('clinic.order-statuses.create')
    ->middleware(['permission:add_order_statuses']);

  	Route::post('/'			,'OrderStatusController@store')
  	->name('clinic.order-statuses.store')
    ->middleware(['permission:add_order_statuses']);

  	Route::get('{id}/edit'	,'OrderStatusController@edit')
  	->name('clinic.order-statuses.edit')
    ->middleware(['permission:edit_order_statuses']);

  	Route::put('{id}'		,'OrderStatusController@update')
  	->name('clinic.order-statuses.update')
    ->middleware(['permission:edit_order_statuses']);

  	Route::delete('{id}'	,'OrderStatusController@destroy')
  	->name('clinic.order-statuses.destroy')
    ->middleware(['permission:delete_order_statuses']);

  	Route::get('deletes'	,'OrderStatusController@deletes')
  	->name('clinic.order-statuses.deletes')
    ->middleware(['permission:delete_order_statuses']);

  	Route::get('{id}','OrderStatusController@show')
  	->name('clinic.order-statuses.show')
    ->middleware(['permission:show_order_statuses']);

});
