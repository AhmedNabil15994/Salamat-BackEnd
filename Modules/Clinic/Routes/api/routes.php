<?php
Route::group(['prefix' => 'clinics'], function () {

    Route::get('/'      , 'ClinicController@clinics')->name('api.clinics.index');
    Route::get('{id}'   , 'ClinicController@clinic')->name('api.clinics.show');

});
