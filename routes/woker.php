<?php
	Route::group(['middleware' => ['woker']], function ($router)
	    {
 			/*Route::get('/index','admin\storage\StorageController@index');
 			Route::get('/blade','admin\storage\StorageController@blade');
 			Route::get('/home','admin\storage\StorageController@homepage');
 			Route::get('/admin_info','admin\storage\StorageController@admin_info');
 			Route::post('/up_self','admin\storage\StorageController@up_self');
 			Route::any('/password','admin\storage\StorageController@password');
 			Route::get('/jsq','admin\storage\StorageController@jsq');*/
        });

	//Route::get('/notallow','admin\storage\StorageController@notallow');