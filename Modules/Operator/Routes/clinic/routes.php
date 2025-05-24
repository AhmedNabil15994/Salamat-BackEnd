<?php

Route::group(['prefix' => 'operators'], function () {

  	Route::get('/' ,'OperatorController@index')
  	->name('clinic.operators.index');

  	Route::get('datatable'	,'OperatorController@datatable')
  	->name('clinic.operators.datatable');

  	Route::get('create'		,'OperatorController@create')
  	->name('clinic.operators.create');

  	Route::post('/'			,'OperatorController@store')
  	->name('clinic.operators.store');

  	Route::get('{id}/edit'	,'OperatorController@edit')
  	->name('clinic.operators.edit');

  	Route::put('{id}'		,'OperatorController@update')
  	->name('clinic.operators.update');

  	Route::delete('{id}'	,'OperatorController@destroy')
  	->name('clinic.operators.destroy');

  	Route::get('deletes'	,'OperatorController@deletes')
  	->name('clinic.operators.deletes');

  	Route::get('{id}','OperatorController@show')
  	->name('clinic.operators.show');

});
