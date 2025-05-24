<?php


Route::group(['prefix' => '/' , 'middleware' => ['dashboard.auth','permission:dashboard_access']], function() {

  Route::get('/'    , 'DashboardController@index')->name('dashboard.home');
  Route::get('logs' , '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

});
