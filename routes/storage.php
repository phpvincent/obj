<?php
	Route::group(['middleware' => ['storage']], function ($router)
	    {
 			Route::get('/index','admin\storage\StorageController@index');
 			Route::get('/blade','admin\storage\StorageController@blade');
 			Route::get('/home','admin\storage\StorageController@homepage');
 			Route::get('/admin_info','admin\storage\StorageController@admin_info');
 			Route::post('/up_self','admin\storage\StorageController@up_self');
 			Route::any('/password','admin\storage\StorageController@password');
 			//仓库管理
 			Route::get('/list','admin\storage\StorageListController@list');
 			Route::get('/list/data','admin\storage\StorageListController@list_data');
 			Route::get('/list/del_storage','admin\storage\StorageListController@del_storage');
 			Route::get('/list/product_data','admin\storage\StorageListController@product_data');
 	    });
	Route::get('/notallow','admin\storage\StorageController@notallow');