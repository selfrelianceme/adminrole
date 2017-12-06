<?php

Route::group(['prefix' => config('adminamazing.path').'/adminrole', 'middleware' => ['web', 'CheckAccess']], function() {
	Route::get('/', 'selfreliance\adminrole\AdminRoleController@index')->name('AdminRolesHome');
	Route::get('/edit/{id}', 'selfreliance\adminrole\AdminRoleController@edit')->name('AdminRolesEdit');
	Route::put('/update/{id}', 'selfreliance\adminrole\AdminRoleController@update')->name('AdminRolesUpdate');
	Route::post('/create', 'selfreliance\adminrole\AdminRoleController@create')->name('AdminRolesCreate');
	Route::delete('/{id?}', 'selfreliance\adminrole\AdminRoleController@destroy')->name('AdminRolesDelete');
});