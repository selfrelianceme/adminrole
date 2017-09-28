<?php

Route::group(['prefix' => 'admin/adminrole', 'middleware' => 'web'], function() {
	Route::get('/', 'selfreliance\adminrole\AdminRoleController@index')->name('AdminRolesHome');
	Route::post('/', 'selfreliance\adminrole\AdminRoleController@create')->name('AdminRolesCreate');
	Route::delete('/delete/{name}', 'selfreliance\adminrole\AdminRoleController@delete')->name('AdminRolesDelete');
	Route::get('/{name}', 'selfreliance\adminrole\AdminRoleController@edit')->name('AdminRolesEdit');
	Route::put('/{name}', 'selfreliance\adminrole\AdminRoleController@update')->name('AdminRolesUpdate');
});