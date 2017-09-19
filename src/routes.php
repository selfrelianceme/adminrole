<?php

Route::group(['middleware' => 'web'], function () {
	Route::get(config('adminamazing.path').'/adminrole/{type}', 'selfreliance\adminrole\AdminRoleController@index')->middleware('web', 'role:admin')->name('AdminRoles');
	Route::delete(config('adminamazing.path').'/adminrole/{type}{id}', 'selfreliance\adminrole\AdminRoleController@detach')->middleware('web', 'role:admin')->name('AdminDetach');
	Route::get(config('adminamazing.path').'/adminrole/affix/{type}', 'selfreliance\adminrole\AdminRoleController@showAffix')->middleware('web', 'role:admin');
	Route::post(config('adminamazing.path').'/adminrole/affix/{type}', 'selfreliance\adminrole\AdminRoleController@affix')->middleware('web', 'role:admin')->name('AdminAffix');
	Route::get(config('adminamazing.path').'/adminrole/create/{type}', 'selfreliance\adminrole\AdminRoleController@showCreate')->middleware('web', 'role:admin');
	Route::post(config('adminamazing.path').'/adminrole/create/{type}', 'selfreliance\adminrole\AdminRoleController@create')->middleware('web', 'role:admin')->name('AdminCreate');
});