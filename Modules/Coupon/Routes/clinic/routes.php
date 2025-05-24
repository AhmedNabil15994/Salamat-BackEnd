<?php

Route::group(['prefix' => 'coupons'], function () {

  	Route::get('/' ,'CouponController@index')
  	->name('clinic.coupons.index');

  	Route::get('datatable'	,'CouponController@datatable')
  	->name('clinic.coupons.datatable');

  	Route::get('create'		,'CouponController@create')
  	->name('clinic.coupons.create');

  	Route::post('/'			,'CouponController@store')
  	->name('clinic.coupons.store');

  	Route::get('{id}/edit'	,'CouponController@edit')
  	->name('clinic.coupons.edit');

  	Route::put('{id}'		,'CouponController@update')
  	->name('clinic.coupons.update');

  	Route::delete('{id}'	,'CouponController@destroy')
  	->name('clinic.coupons.destroy');

  	Route::get('deletes'	,'CouponController@deletes')
  	->name('clinic.coupons.deletes');

  	Route::get('{id}','CouponController@show')
  	->name('clinic.coupons.show');

});
