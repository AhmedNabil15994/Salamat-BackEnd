<?php

Route::group(['prefix' => 'specialties'], function () {

    Route::get('/'      , 'SpecialtyController@all')->name('api.specialties.index');
    Route::get('{id}'   , 'SpecialtyController@show')->name('api.specialties.show');

});
