<?php

Route::group(['prefix' => 'offers' ,'middleware' => 'auth:api'] , function () {
    Route::get('list' , 'OfferController@list')->name('api.offers.list');
    Route::post('booking'   , 'OfferController@booking')->name('api.offers.booking');
});


Route::group(['prefix' => 'offers' ] , function () {
    Route::get('success'    , 'OfferController@success')->name('api.offers.success');
    Route::get('failed'     , 'OfferController@failed')->name('api.offers.failed');
    Route::post('webhook'   , 'OfferController@webhook')->name('api.offers.webhook');
});
