<?php
	Route::group(['middleware' => ['storage']], function ($router)
	    {
 			Route::get('/index','admin\StorageController@index');
 			Route::get('/blade','admin\StorageController@blade');
 			Route::get('/home','admin\StorageController@homepage');
 			Route::get('/admin_info','admin\StorageController@admin_info');
 	    });
	Route::get('/notallow','admin\StorageController@notallow');