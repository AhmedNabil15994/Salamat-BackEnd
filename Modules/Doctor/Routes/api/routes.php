<?php

Route::group(['prefix' => 'doctors'], function () {

    Route::get('/' , 'DoctorController@list')->name('api.doctors.index');
    Route::get('{id}' , 'DoctorController@doctor')->name('api.doctors.show');

});
