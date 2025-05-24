<?php

Route::group(['prefix' => 'operators'], function () {

    Route::get('/'      , 'OperatorController@list')->name('api.operators.index');
    Route::get('{id}'   , 'OperatorController@operator')->name('api.operators.show');

});
