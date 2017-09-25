<?php

Route::group(['middleware' => 'web'], function () {
	Route::get(config('adminamazing.path').'/adminrole', 'selfreliance\adminrole\AdminRoleController@index')->name('AdminRolesHome');
	Route::post(config('adminamazing.path').'/adminrole/create', 'selfreliance\adminrole\AdminRoleController@create')->name('AdminRolesCreate');
	Route::delete(config('adminamazing.path').'/adminrole/delete', 'selfreliance\adminrole\AdminRoleController@delete')->name('AdminRolesDelete');
});