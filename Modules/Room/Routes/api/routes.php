<?php

Route::group(['prefix' => 'rooms'], function () {

    Route::get('/'      , 'RoomController@list')->name('api.rooms.index');
    Route::get('{id}'   , 'RoomController@room')->name('api.rooms.show');

});
