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
            Route::any('/list/up_storage_stock','admin\storage\StorageListController@up_storage_stock');//修改商品库存
            Route::post('/list/storage_stock_show','admin\storage\StorageListController@storage_stock_show');//商品库存详情
            Route::any('/list/product_data_smail','admin\storage\StorageListController@product_data_smail');
            Route::get('/list/del_storage_stock','admin\storage\StorageListController@del_storage_stock');//删除商品库存
            //数据校准
            Route::get('/check','admin\storage\StorageListController@check');
            Route::get('/list/order_data','admin\storage\StorageListController@order_data');//订单列表
            Route::get('/list/back_order','admin\storage\StorageListController@back_order');//订单驳回
            Route::get('/list/check_order','admin\storage\StorageListController@check_order');//仓储数据校准
            //补货
            Route::any('/add','admin\storage\StorageAddController@add');//购置单列表
            Route::any('/add/add_goods','admin\storage\StorageAddController@add_goods');//新增购置单
            Route::post('/add/get_goods_config','admin\storage\StorageAddController@get_goods_config');//购置单获取添加产品属性
            Route::any('add/show_goods_kind','admin\storage\StorageAddController@show_goods_kind');//采购单商品列表
            Route::get('add/append_goods_del','admin\storage\StorageAddController@append_goods_del');//删除采购单商品
            Route::any('add/append_goods_edit','admin\storage\StorageAddController@append_goods_edit');//修改采购单商品个数页面
            Route::post('add/append_goods_num','admin\storage\StorageAddController@append_goods_num');//修改采购单商品个数操作
        });

	Route::get('/notallow','admin\storage\StorageController@notallow');