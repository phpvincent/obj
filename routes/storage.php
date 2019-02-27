<?php
	Route::group(['middleware' => ['storage']], function ($router)
	    {
 			Route::get('/index','admin\StorageController@index');
 			Route::get('/blade','admin\StorageController@blade');
 	    });
	Route::get('/notallow','admin\StorageController@notallow');