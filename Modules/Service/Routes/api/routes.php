<?php

Route::group(['prefix' => 'services'], function () {

    Route::get('/'          , 'ServiceController@services')->name('api.services.index');
    Route::get('times/{id}' , 'ServiceController@times')->name('api.services.times');
    Route::get('{id}'       , 'ServiceController@service')->name('api.services.show');

});
