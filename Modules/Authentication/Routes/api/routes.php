<?php

Route::group(['prefix' => 'auth'], function () {

    Route::post('login'             , 'LoginController@postLogin')->name('api.auth.login');
    Route::post('register'          , 'RegisterController@register')->name('api.auth.register');
    Route::post('forget-password'   , 'ForgotPasswordController@forgetPassword')->name('api.auth.password.forget');

    Route::group(['prefix' => '/','middleware' => 'auth:api'], function () {

        Route::post('logout', 'LoginController@logout')->name('api.auth.logout');

    });

});
