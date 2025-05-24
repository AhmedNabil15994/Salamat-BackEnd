<?php

Route::group(['prefix' => 'coupons' , 'middleware' => 'auth:api'], function () {

    Route::post('/'    , 'CouponController@coupons')->name('api.coupons.index');

});
