<?php

Route::group(['prefix' => 'orders' ,'middleware' => 'auth:api'] , function () {

    Route::post('request'           , 'OrderController@request')->name('api.orders.request');
    Route::post('pending/request'   , 'OrderController@pendingRequest')->name('api.orders.pending.request');
    Route::get('list'               , 'OrderController@list')->name('api.orders.list');
    Route::get('pending'            , 'OrderController@pending')->name('api.orders.pending');
    Route::post('rate'              , 'OrderController@rate')->name('api.orders.rate');

});

Route::group(['prefix' => 'orders' ] , function () {

    Route::get('success'    , 'OrderController@success')->name('api.orders.success');
    Route::get('failed'     , 'OrderController@failed')->name('api.orders.failed');
    Route::post('webhook'   , 'OrderController@webhook')->name('api.orders.webhook');
    
});
