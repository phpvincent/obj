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
use Illuminate\Http\Request;
use App\url;
use App\goods;
use App\order;
use App\Jobs\SendHerbEmail;use Qcloud\Sms\SmsSingleSender;
	Route::get('/index/index','home\IndexController@channelindex')->name('index');
	Route::get('/index/fb','home\IndexController@fb');
/*	Route::get('/index/sendemail','home\IndexController@sendmail');*/
/*	Route::any('/paypal',function(Request $request){
		
		// 短信应用SDK AppID
		$appid = 1400178731; // 1400开头

		// 短信应用SDK AppKey
		$appkey = "c78bc34d27889db975b0916217fdee57";

		// 需要发送短信的手机号码
		$phoneNumbers = ["21212313123", "12345678902", "12345678903"];
		//templateId7839对应的内容是"您的验证码是: {1}"
		// 短信模板ID，需要在短信应用中申请
		$templateId = 7839;  // NOTE: 这里的模板ID`7839`只是一个示例，真实的模板ID需要在短信控制台中申请

		$smsSign = "腾讯云"; // NOTE: 这里的签名只是示例，请使用真实的已申请的签名，签名参数使用的是`签名内容`，而不是`签名ID`
		try {
		    $ssender = new SmsSingleSender($appid, $appkey);
		    $params = ["5678"];//数组具体的元素个数和模板中变量个数必须一致，例如事例中 templateId:5678对应一个变量，参数数组中元素个数也必须是一个
		    $result = $ssender->sendWithParam("86", $phoneNumbers[0], $templateId,
		        $params, $smsSign, "", "");  // 签名参数未提供或者为空时，会使用默认签名发送短信
		    $rsp = json_decode($result);
		    echo $result;
		} catch(\Exception $e) {
		    echo var_dump($e);
		}
		/*\Log::notice(json_encode($request->all()).'回调~~~~~~~~~~~~~~~~~~~~~~~~');return;
		 $url=$_SERVER['SERVER_NAME'];
        $goods=\App\goods::where('goods_id',43)->first();
        $order=\App\order::where('order_id','223')->first();
        return view('home.YinDuNiXiYa.sendmail')->with(compact('url','order','goods'));
		
		//SendHerbEmail::dispatch($order);
	});
*/Route::middleware(['checkbus','checkurl'])->group(function(){
	Route::get('/','home\IndexController@index');
	/*Route::get('/{rand}','home\IndexController@index');*/
	Route::post('/comment','home\IndexController@comment');
	Route::get('/send','home\IndexController@send');
	Route::get('/send_message','home\IndexController@sendMessages'); //发送短信消息
	Route::get('/sendmsg','home\IndexController@get_sendmsg');
	Route::get('/visfrom','home\IndexController@visfrom');
	Route::get('/orderSuccess','home\IndexController@orderSuccess');
	Route::match(['get', 'post'],'/getsendmsg','home\IndexController@getsendmsg');
	Route::match(['get', 'post'],'/gethtml','home\IndexController@gethtml');
	Route::match(['get', 'post'], '/pay','home\IndexController@pay');
	Route::match(['get', 'post'], '/saveform','home\IndexController@saveform');
	Route::match(['get', 'post'], '/paypal_pay','home\IndexController@paypal_pay');
	Route::match(['get', 'post'], '/paypal_success','home\IndexController@paypal_success');
	Route::match(['get', 'post'], '/paypal_send','home\IndexController@paypal_send');
	Route::match(['get', 'post'], '/endsuccess','home\IndexController@endsuccess');
	Route::match(['get', 'post'], '/endfail','home\IndexController@endfail');
	Route::match(['get', 'post'], '/expressCheckoutSuccess','home\IndexController@expressCheckoutSuccess');
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
	Route::get('/admin/goods/show','admin\GoodsController@show');
	Route::any('/admin/goods/addgoods_type','admin\GoodsController@addgoods_type');
	Route::any('/admin/goods/goods_kind','admin\GoodsController@goods_kind');
	Route::get('/admin/goods/goods_kind_s','admin\GoodsController@goods_kind_s');
	Route::get('/admin/goods/goods_real_name','admin\GoodsController@goods_real_name');
	Route::match(['get','post'],'/admin/goods/addgoods_kind','admin\GoodsController@addgoods_kind');
	Route::any('/admin/goods/attr','admin\GoodsController@goods_attr');
	Route::post('/admin/goods/add_giveaway', 'admin\GoodsController@add_giveaway');

	//订单相关
	Route::get('/admin/order/index','admin\OrderController@index');
	Route::get('/admin/order/edit', 'admin\OrderController@edit');
	Route::post('/admin/order/update', 'admin\OrderController@update');
	Route::post('/admin/order/get_table','admin\OrderController@get_table');
	Route::get('/admin/order/orderinfo','admin\OrderController@orderinfo');
	Route::get('/admin/order/heshen','admin\OrderController@heshen');
	Route::get('/admin/order/delorder','admin\OrderController@delorder');
	Route::get('/admin/order/getaddr','admin\OrderController@getaddr');
	Route::any('/admin/order/outorder','admin\OrderController@outorder');
	Route::post('/admin/order/order_type_change','admin\OrderController@order_type_change');
	Route::post('/admin/order/order_arr_change','admin\OrderController@order_arr_change');
	Route::get('/admin/order/payinfo','admin\OrderController@payinfo');//订单支付信息展示
	Route::match(['get','post'],'/admin/order/count','admin\OrderController@count');
	Route::match(['get','post'],'/admin/order/send_mail','admin\OrderController@send_mail');
	Route::match(['get','post'],'/admin/order/change_exl','admin\OrderController@change_exl');
	Route::match(['get','post'],'/admin/order/send_message', 'admin\OrderController@send_message');
    Route::get('/admin/order/message_logs', 'admin\OrderController@message_logs');
	//域名相关
	Route::get('/admin/url/goods_url','admin\UrlController@goods_url');
	Route::post('/admin/url/get_url','admin\UrlController@get_url');
	Route::get('/admin/url/churl','admin\UrlController@churl');
	Route::post('/admin/url/ajaxup','admin\UrlController@ajaxup');
	Route::any('/admin/url/url_add','admin\UrlController@url_add');
	Route::match(['get', 'post'],'admin/url/add_account','admin\UrlController@add_account');
	Route::match(['get', 'post'],'admin/url/update_account','admin\UrlController@update_account');
	Route::match(['post'],'admin/url/ajax_account','admin\UrlController@ajax_account');
	Route::match(['get'],'admin/url/clear_flag','admin\UrlController@clear_flag');
	Route::match(['get'],'admin/url/url_goods_ajax','admin\UrlController@url_goods_ajax');
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
	Route::post('/admin/vis/get_table','admin\VisController@get_table');
	Route::post('/admin/vis/pay_table','admin\VisController@pay_table');//花费表格
	Route::post('/admin/vis/get_zxtu','admin\VisController@get_zxtu');
	Route::any('/admin/vis/pay_money','admin\VisController@pay_money');//花费曲线图
	Route::any('/admin/vis/get_ajaxtop','admin\VisController@get_ajaxtop');//销售额排行榜
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
	//核审相关
	Route::get('/admin/check/index','admin\CheckController@index');
	Route::get('/admin/check/go_check','admin\CheckController@go_check');
	Route::get('/admin/check/no_check','admin\CheckController@no_check');
	Route::get('/admin/check/re_check','admin\CheckController@re_check');
	Route::post('/admin/check/getcheck','admin\CheckController@getcheck');
	Route::any('/admin/check/set','admin\CheckController@set');
	//花费相关
	Route::get('/admin/pay/index','admin\PayController@index');//花费首页
	Route::post('/admin/pay/get_table','admin\PayController@get_table');//花费列表
	Route::any('/admin/pay/spend_import','admin\PayController@spend_import');//导入花费信息
	Route::any('/admin/pay/add_spend','admin\PayController@add_spend');//新增花费
	Route::any('/admin/pay/add_pay_number','admin\PayController@add_pay_number');//新增广告编号
	Route::get('/admin/pay/spend_entry','admin\PayController@spend_entry');//未添加花费日期
	Route::get('/admin/pay/spend_show','admin\PayController@spend_show');//花费详情
	Route::post('/admin/pay/get_show_table','admin\PayController@get_show_table');//花费列表信息
	Route::any('/admin/pay/del_spend','admin\PayController@del_spend');//删除商品花费
    //产品相关
    Route::get('/admin/kind/index','admin\KindController@index');//产品首页
    Route::post('/admin/kind/get_table','admin\KindController@get_table');//产品列表
    Route::get('/admin/kind/delkind','admin\KindController@delkind');//删除产品
    Route::get('/admin/kind/show','admin\KindController@show');//产品详情
    Route::get('/admin/kind/upgoods_kind','admin\KindController@upgoods_kind');//修改产品
    Route::any('/admin/kind/post_update','admin\KindController@post_update');//修改产品
    Route::any('/admin/kind/addkind','admin\KindController@addkind');//新增产品

});

