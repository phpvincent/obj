<?php
//	Route::group(['middleware' => ['woker']], function ($router)
	Route::group([], function ($router)
	    {
 			Route::get('/index','admin\worker\WorkerController@index');
 			Route::get('/blade','admin\worker\WorkerController@blade');
 			Route::get('/home','admin\worker\WorkerController@homepage');
 			Route::get('/admin_info','admin\worker\WorkerController@admin_info');
 			Route::post('/up_self','admin\worker\WorkerController@up_self');
 			Route::any('/password','admin\worker\WorkerController@password');
 			Route::get('/jsq','admin\worker\WorkerController@jsq');

 			//平台监控
            Route::get('/monitor/page/list','admin\worker\MonitorController@list'); //网页监控
            Route::get('/monitor/page/get_table','admin\worker\MonitorController@get_table'); //网页监控路由数据
            Route::any('/monitor/page/ip_list','admin\worker\MonitorController@ip_list'); //网页监控IP数据
            Route::any('/monitor/page/ip_info','admin\worker\MonitorController@ip_info'); //网页监控用户IP信息
            Route::any('/monitor/set','admin\worker\MonitorController@set'); //监控设置
        });

	Route::get('/notallow','admin\worker\WorkerController@notallow');