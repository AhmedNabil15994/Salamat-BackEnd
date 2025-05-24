<?php

Route::group(['prefix' => 'orders'], function () {

    Route::get('logs/{id}/{type}' ,'OrderController@logs')
  	->name('dashboard.orders.logs')
    ->middleware(['permission:show_orders']);

    Route::get('calendar' ,'OrderController@calendar')
  	->name('dashboard.orders.calendar')
    ->middleware(['permission:show_orders']);

  	Route::get('/' ,'OrderController@index')
  	->name('dashboard.orders.index')
    ->middleware(['permission:show_orders']);

  	Route::get('datatable'	,'OrderController@datatable')
  	->name('dashboard.orders.datatable')
  	->middleware(['permission:show_orders']);

  	Route::get('create'		,'OrderController@create')
  	->name('dashboard.orders.create')
    ->middleware(['permission:add_orders']);

  	Route::post('/'			,'OrderController@store')
  	->name('dashboard.orders.store')
    ->middleware(['permission:add_orders']);

  	Route::get('{id}/edit'	,'OrderController@edit')
  	->name('dashboard.orders.edit')
    ->middleware(['permission:edit_orders']);

  	Route::put('{id}'		,'OrderController@update')
  	->name('dashboard.orders.update')
    ->middleware(['permission:edit_orders']);

  	Route::delete('{id}'	,'OrderController@destroy')
  	->name('dashboard.orders.destroy')
    ->middleware(['permission:delete_orders']);

  	Route::get('deletes'	,'OrderController@deletes')
  	->name('dashboard.orders.deletes')
    ->middleware(['permission:delete_orders']);

  	Route::get('{id}','OrderController@show')
  	->name('dashboard.orders.show')
    ->middleware(['permission:show_orders']);

});


Route::group(['prefix' => 'order-statuses'], function () {

  	Route::get('/' ,'OrderStatusController@index')
  	->name('dashboard.order-statuses.index')
    ->middleware(['permission:show_order_statuses']);

  	Route::get('datatable'	,'OrderStatusController@datatable')
  	->name('dashboard.order-statuses.datatable')
  	->middleware(['permission:show_order_statuses']);

  	Route::get('create'		,'OrderStatusController@create')
  	->name('dashboard.order-statuses.create')
    ->middleware(['permission:add_order_statuses']);

  	Route::post('/'			,'OrderStatusController@store')
  	->name('dashboard.order-statuses.store')
    ->middleware(['permission:add_order_statuses']);

  	Route::get('{id}/edit'	,'OrderStatusController@edit')
  	->name('dashboard.order-statuses.edit')
    ->middleware(['permission:edit_order_statuses']);

  	Route::put('{id}'		,'OrderStatusController@update')
  	->name('dashboard.order-statuses.update')
    ->middleware(['permission:edit_order_statuses']);

  	Route::delete('{id}'	,'OrderStatusController@destroy')
  	->name('dashboard.order-statuses.destroy')
    ->middleware(['permission:delete_order_statuses']);

  	Route::get('deletes'	,'OrderStatusController@deletes')
  	->name('dashboard.order-statuses.deletes')
    ->middleware(['permission:delete_order_statuses']);

  	Route::get('{id}','OrderStatusController@show')
  	->name('dashboard.order-statuses.show')
    ->middleware(['permission:show_order_statuses']);

});
