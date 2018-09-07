<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
	Route::get('/index/index','home\IndexController@channelindex')->name('index');
	Route::get('/index/fb','home\IndexController@fb');
Route::middleware(['checkbus','checkurl'])->group(function(){
	Route::get('/','home\IndexController@index');
	/*Route::get('/{rand}','home\IndexController@index');*/
	Route::post('/comment','home\IndexController@comment');
	Route::get('/send','home\IndexController@send');
	Route::get('/sendmsg','home\IndexController@get_sendmsg');
	Route::get('/visfrom','home\IndexController@visfrom');
	Route::get('/orderSuccess','home\IndexController@orderSuccess');
	Route::match(['get', 'post'],'/getsendmsg','home\IndexController@getsendmsg');
	Route::match(['get', 'post'],'/gethtml','home\IndexController@gethtml');
	Route::match(['get', 'post'], '/pay','home\IndexController@pay');
	Route::match(['get', 'post'], '/saveform','home\IndexController@saveform');
	Route::match(['get', 'post'], '/endsuccess','home\IndexController@endsuccess');
});
Route::middleware([])->group(function(){
	Route::any('/order/save_testcom','home\IndexController@savetestform');
	Route::get('/visfrom/settime','home\IndexController@settime');
	Route::get('/visfrom/setbuy','home\IndexController@setbuy');
	Route::get('/visfrom/setorder','home\IndexController@setorder');
	Route::post('/business/form','home\IndexController@busform');
});
//后台相关路由
Route::match(['get','post'],'/admin/login','admin\ManagerController@login')->name('login')->middleware('checkadmin');
Route::middleware(['auth:check','checkadmin'])->group(function(){
	Route::get('/logout',function(){
    	Auth::logout();
    	return redirect('/admin/login');
    });
	Route::get('/admin/index','admin\IndexController@index');
	Route::get('admin','admin\IndexController@index');
	Route::get('/admin/welcome','admin\IndexController@welcome');
	//商品相关
	Route::get('/admin/goods/index','admin\GoodsController@index');
	Route::post('/admin/goods/get_table','admin\GoodsController@get_table');
	Route::get('/admin/goods/delgoods','admin\GoodsController@delgoods');
	Route::get('/admin/goods/online','admin\GoodsController@online');
	Route::get('/admin/goods/close','admin\GoodsController@close');
	Route::get('/admin/goods/chgoods','admin\GoodsController@chgoods');
	Route::any('/admin/goods/outgoods','admin\GoodsController@outgoods');
	Route::post('/admin/goods/post_update','admin\GoodsController@post_update');
	Route::get('/admin/goods/getcuxiaohtml','admin\GoodsController@getcuxiaohtml');
	Route::get('/admin/goods/addgoods','admin\GoodsController@addgoods');
	Route::post('/admin/goods/post_add','admin\GoodsController@post_add');
	Route::post('/admin/goods/copy_goods','admin\GoodsController@copy_goods');
	Route::get('/admin/goods/only_name','admin\GoodsController@only_name');

	//订单相关
	Route::get('/admin/order/index','admin\OrderController@index');
	Route::post('/admin/order/get_table','admin\OrderController@get_table');
	Route::get('/admin/order/orderinfo','admin\OrderController@orderinfo');
	Route::get('/admin/order/heshen','admin\OrderController@heshen');
	Route::get('/admin/order/delorder','admin\OrderController@delorder');
	Route::get('/admin/order/getaddr','admin\OrderController@getaddr');
	Route::any('/admin/order/outorder','admin\OrderController@outorder');
	Route::post('/admin/order/order_type_change','admin\OrderController@order_type_change');
	//域名相关
	Route::get('/admin/url/goods_url','admin\UrlController@goods_url');
	Route::post('/admin/url/get_url','admin\UrlController@get_url');
	Route::get('/admin/url/churl','admin\UrlController@churl');
	Route::post('/admin/url/ajaxup','admin\UrlController@ajaxup');
	Route::any('/admin/url/url_add','admin\UrlController@url_add');
	//评论相关
	Route::get('/admin/comment/index','admin\CommentController@index');
	Route::post('/admin/comment/getindex','admin\CommentController@getindex');
	Route::get('/admin/comment/oncomment','admin\CommentController@oncomment');
	Route::get('/admin/comment/usecomment','admin\CommentController@usecomment');
	Route::get('/admin/comment/usercomment','admin\CommentController@usercomment');
	Route::get('/admin/comment/newcomment','admin\CommentController@newcomment');
	Route::get('/admin/comment/downcom','admin\CommentController@downcom');
	Route::get('/admin/comment/upcom','admin\CommentController@upcom');
	Route::post('/admin/comment/geton','admin\CommentController@geton');
	Route::post('/admin/comment/save_com','admin\CommentController@save_com');
	Route::post('/admin/comment/getusers','admin\CommentController@getusers');
 	//访问管理
	Route::get('/admin/vis/index','admin\VisController@index');
	Route::post('/admin/vis/getindex','admin\VisController@getindex');
	Route::get('/admin/vis/delvis','admin\VisController@delvis');
	Route::get('/admin/vis/pbvis','admin\VisController@pbvis');
	Route::get('/admin/vis/backvis','admin\VisController@backvis');
	Route::get('/admin/vis/prea','admin\VisController@prea');
	Route::get('/admin/vis/chvis','admin\VisController@chvis');
	Route::any('/admin/vis/outvis','admin\VisController@outvis');
	Route::get('/admin/vis/stime','admin\VisController@stime');
	Route::any('/admin/vis/statistic','admin\VisController@statistic');
	Route::post('/admin/vis/statistic_b','admin\VisController@statistic_b');
	Route::get('/admin/vis/ll','admin\VisController@ll');
	Route::post('/admin/vis/get_ajaxtable','admin\VisController@get_ajaxtable');
	Route::post('/admin/vis/get_zxtu','admin\VisController@get_zxtu');
	//管理员账户相关
	Route::get('/admin/admin/index','admin\AdminController@index');
	Route::post('/admin/admin/get_table','admin\AdminController@get_table');
	Route::any('/admin/admin/addadmin','admin\AdminController@addadmin');
	Route::any('/admin/admin/addgroup','admin\AdminController@addgroup');
	Route::get('/admin/admin/deladmin','admin\AdminController@deladmin');
	Route::get('/admin/admin/ch_root','admin\AdminController@ch_root');
	Route::get('/admin/admin/cl_root','admin\AdminController@cl_root');
	Route::get('/admin/admin/unuse','admin\AdminController@unuse');
	Route::get('/admin/admin/opuse','admin\AdminController@opuse');
	Route::any('/admin/admin/upadmin','admin\AdminController@upadmin');
	Route::any('/admin/admin/addrole','admin\AdminController@addrole');
	Route::any('/admin/admin/chrole','admin\AdminController@chrole');
	Route::post('/admin/admin/checkbox','admin\AdminController@checkbox');
	Route::get('/admin/admin/layershow','admin\AdminController@layershow');
});
