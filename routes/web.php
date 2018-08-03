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
Route::middleware('checkurl')->group(function(){
	Route::get('/','home\IndexController@index');
	/*Route::get('/{rand}','home\IndexController@index');*/
	Route::post('/comment','home\IndexController@comment');
	Route::get('/send','home\IndexController@send');
	Route::get('/sendmsg','home\IndexController@get_sendmsg');
	Route::match(['get', 'post'],'/getsendmsg','home\IndexController@getsendmsg');
	Route::match(['get', 'post'],'/gethtml','home\IndexController@gethtml');
	Route::match(['get', 'post'], '/pay','home\IndexController@pay');
	Route::match(['get', 'post'], '/saveform','home\IndexController@saveform');
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
});
