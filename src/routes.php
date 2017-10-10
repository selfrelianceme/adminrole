<?php

Route::group(['prefix' => config('adminamazing.path').'/adminrole', 'middleware' => ['web', 'CheckAccess']], function() {
	Route::get('/', 'selfreliance\adminrole\AdminRoleController@index')->name('AdminRolesHome');
	Route::get('/edit/{name}', 'selfreliance\adminrole\AdminRoleController@edit')->name('AdminRolesShowEdit');
	Route::post('/edit/{name}', 'selfreliance\adminrole\AdminRoleController@edit')->name('AdminRolesEdit');
	Route::delete('/delete/{name}', 'selfreliance\adminrole\AdminRoleController@delete')->name('AdminRolesDelete');
});