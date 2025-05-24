<?php

Route::group(['prefix' => 'operators'], function () {

  	Route::get('/' ,'OperatorController@index')
  	->name('dashboard.operators.index')
    ->middleware(['permission:show_operators']);

  	Route::get('datatable'	,'OperatorController@datatable')
  	->name('dashboard.operators.datatable')
  	->middleware(['permission:show_operators']);

  	Route::get('create'		,'OperatorController@create')
  	->name('dashboard.operators.create')
    ->middleware(['permission:add_operators']);

  	Route::post('/'			,'OperatorController@store')
  	->name('dashboard.operators.store')
    ->middleware(['permission:add_operators']);

  	Route::get('{id}/edit'	,'OperatorController@edit')
  	->name('dashboard.operators.edit')
    ->middleware(['permission:edit_operators']);

  	Route::put('{id}'		,'OperatorController@update')
  	->name('dashboard.operators.update')
    ->middleware(['permission:edit_operators']);

  	Route::delete('{id}'	,'OperatorController@destroy')
  	->name('dashboard.operators.destroy')
    ->middleware(['permission:delete_operators']);

  	Route::get('deletes'	,'OperatorController@deletes')
  	->name('dashboard.operators.deletes')
    ->middleware(['permission:delete_operators']);

  	Route::get('{id}','OperatorController@show')
  	->name('dashboard.operators.show')
    ->middleware(['permission:show_operators']);

});
