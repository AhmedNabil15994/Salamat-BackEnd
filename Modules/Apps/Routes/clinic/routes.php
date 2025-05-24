<?php

Route::group(['prefix' => '/' ,'middleware' => [
    'clinic.auth',
    'clinic.redirect'
]], function() {

    Route::get('/'  , 'ClinicController@index')->name('clinic.home');

});
