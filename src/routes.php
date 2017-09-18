<?php

Route::group(['middleware' => 'web'], function () {
	Route::get(config('adminamazing.path').'/adminrole', 'selfreliance\adminrole\AdminRoleController@index')->middleware('web', 'role:admin')->name('AdminRoles');
	Route::delete(config('adminamazing.path').'/adminrole/{id}', 'selfreliance\adminrole\AdminRoleController@detachRole')->middleware('web', 'role:admin')->name('AdminDetachRole');
	Route::get(config('adminamazing.path').'/adminrole/affix', 'selfreliance\adminrole\AdminRoleController@showAffixRole')->middleware('web', 'role:admin');
	Route::post(config('adminamazing.path').'/adminrole/affix', 'selfreliance\adminrole\AdminRoleController@affixRole')->middleware('web', 'role:admin')->name('AdminAffixRole');
	Route::get(config('adminamazing.path').'/adminrole/create', 'selfreliance\adminrole\AdminRoleController@showCreateRole')->middleware('web', 'role:admin');
	Route::post(config('adminamazing.path').'/adminrole/create', 'selfreliance\adminrole\AdminRoleController@createRole')->middleware('web', 'role:admin')->name('AdminCreateRole');
});