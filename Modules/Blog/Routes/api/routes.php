<?php

Route::group(['prefix' => 'blogs'], function () {

    Route::get('/'    , 'BlogController@blogs')->name('api.blogs.index');
    Route::get('{id}' , 'BlogController@blog')->name('api.blogs.show');

});
