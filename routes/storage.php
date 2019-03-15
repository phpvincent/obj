<?php
	Route::group(['middleware' => ['storage']], function ($router)
	    {
 			Route::get('/index','admin\storage\StorageController@index');
 			Route::get('/blade','admin\storage\StorageController@blade');
 			Route::get('/home','admin\storage\StorageController@homepage');
 			Route::get('/admin_info','admin\storage\StorageController@admin_info');
 			Route::post('/up_self','admin\storage\StorageController@up_self');
 			Route::any('/password','admin\storage\StorageController@password');
 			Route::get('/jsq','admin\storage\StorageController@jsq');
 			
 			//仓库管理
 			Route::get('/list','admin\storage\StorageListController@list');
 			Route::get('/list/data','admin\storage\StorageListController@list_data');
 			Route::any('/list/add_storage','admin\storage\StorageListController@add_storage'); //新增仓库
 			Route::get('/list/del_storage','admin\storage\StorageListController@del_storage');//删除仓库
 			Route::any('/list/up_storage','admin\storage\StorageListController@up_storage');//修改仓库
            Route::get('list/product_data','admin\storage\StorageListController@product_data');//仓库数据页
            Route::post('list/get_table','admin\storage\StorageListController@get_table');//仓库数据列表
            Route::get('/list/up_storage_stock','admin\storage\StorageListController@up_storage_stock');//修改商品库存
            Route::any('/list/product_data_smail','admin\storage\StorageListController@product_data_smail');
            //数据校准
            Route::get('/check','admin\storage\StorageListController@check');
            Route::get('/list/order_data','admin\storage\StorageListController@order_data');//订单列表
            //补货
            Route::get('/add','admin\storage\StorageAddController@add');
        });

	Route::get('/notallow','admin\storage\StorageController@notallow');