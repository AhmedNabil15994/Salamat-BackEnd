<?php

Route::group(['prefix' => 'login'], function () {

    if (env('LOGIN')):

        // Show Login Form
        Route::get('/', 'LoginController@showLogin')
        ->name('clinic.login')
        ->middleware('guest');

        // Submit Login
        Route::post('/', 'LoginController@postLogin')
        ->name('clinic.login');

    endif;

});


Route::group(['prefix' => 'logout','middleware' => 'auth'], function () {

    // Logout
    Route::any('/', 'LoginController@logout')
    ->name('clinic.logout');

});
