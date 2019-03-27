<?php

namespace App\Http\Controllers\home;

use App\channel\sendMessage;
use App\channel\skuSDK;
use App\currency_type;
use App\goods_kind;
use App\kind_config;
use App\kind_val;
use App\special;
use App\templet_show;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\goods;
use App\img;
use App\url;
use App\comment;
use App\des;
use App\par;
use App\cuxiao;
use App\order;
use App\vis;
use DB;
use App\channel\cuxiaoSDK;
use App\message;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Jobs\SendHerbEmail;
class IndexController extends Controller
{
    protected $provider;
    /** 构造方法，初始化参数
     * IndexController constructor.
     */
    public function __construct() {
        $this->provider = new ExpressCheckout();
    }
    public function site(Request $request)
    {
        return view('view.fb');
    }
    /** 前台首页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        /*       dd(getclientcity($request));*/
    	//获取该域名对应商品id
        if($request->get('is_site')==true){
            $SiteController=new SiteController;
            return $SiteController->index($request);
            //return redirect()->action('home\SiteController@index');
        }
        if(\Session::get('test_id',0)!=0){
            $goods_id=\Session::get('test_id');
        }else{
                $goods_id=url::get_goods($request); 
        }
    	$imgs=img::where('img_goods_id',$goods_id)->orderBy('img_id','asc')->get(['img_url']);
    	$goods=goods::where('goods_id',$goods_id)->first();
    	$comment=comment::where(['com_goods_id'=>$goods_id,'com_isshow'=>'1'])->orderBy('com_order','desc')->get();
        foreach($comment as $v=> $key){
           /* $usename=mb_substr($key->com_name,0,1);
            $usename.='*';
            if(strlen($key->com_name)>2){
              $usename.=mb_substr($key->com_name,2);
            }
            $comment[$v]->com_name=$usename;*/
            $com_imgs=\App\com_img::where('com_primary_id',$key->com_id)->get();
            if(count($com_imgs)>0){
                 $comment[$v]->com_img=$com_imgs;
             }else{
                $comment[$v]->com_img=null;
             }
//            $comment[$v]->com_time=date('Y-m-d H:i:s',time()-rand(68400,129600));
        }
    	$des_img=des::where('des_goods_id',$goods_id)->get();
    	$par_img=par::where('par_goods_id',$goods_id)->get();
    	$cuxiao=cuxiao::where('cuxiao_goods_id',$goods_id)->orderBy('cuxiao_id','asc')->first();
    	//获取倒计时计算为秒数
        $timer=$goods->goods_end;
        $parsed = date_parse($timer);
        $goods->goods_end=$parsed['hour'] * 3600+$parsed['minute'] * 60+$parsed['second'];

        //获取页面显示内容(2018-10-31 修改代码)
        $goods_templet_ids = \App\goods_templet::where('goods_id',$goods_id)->pluck('templet_id')->toArray();
        $templets = templet_show::whereIn('templet_show_id',$goods_templet_ids)->pluck('templet_english_name')->toArray();
        $center_nav = count($templets);
//        $goods_templet = \App\goods_templet::where('goods_id',$goods_id)->get();
//        $templets = [];
//        $center_nav = 0;  //中部导航显示个数
//        if(!$goods_templet->isEmpty()){
//            foreach ($goods_templet as $item)
//            {
//                if(isset($item->templet_has_show->templet_english_name)){
//                    if($item->templet_has_show->templet_english_name == 'introduce'){
//                        $center_nav++;
//                    }
//                    if($item->templet_has_show->templet_english_name == 'specifications'){
//                        $center_nav++;
//                    }
//                    if($item->templet_has_show->templet_english_name == 'evaluate'){
//                        $center_nav++;
//                    }
//                    array_push($templets,$item->templet_has_show->templet_english_name);
//                }
//            }
//        }

        //模板渲染
        $blade_type=$goods->goods_blade_type;
        switch ($blade_type) {
            case '0':
            return view('home.TaiwanFan.index')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','templets','center_nav'));
                break;
            case '1':
            return view('home.TaiwanJian.index')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','templets','center_nav'));
                break;
            case '2':
            return view('home.zhongdong.zhongdong')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','templets','center_nav'));
                break;
            case '3':
            return  view('home.MaLaiXiYa.mlxy')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','templets','center_nav'));
            break;
            case '4':
            return view('home.TaiGuo.taiguo')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','templets','center_nav'));
            break;
            case '5':
            return view('home.RiBen.riben')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','templets','center_nav'));
            break;
            case '6':
            return view('home.YinDuNiXiYa.ydnxy')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','templets','center_nav'));
            break;
            case '7':
            return view('home.FeiLvBin.flb')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','templets','center_nav'));
            break;
            case '8':
            return view('home.YingGuo.yg')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','templets','center_nav'));
            break;
            case '9':
            $user_type=get_user_new_type();
            if(in_array($user_type,['Android','iPhone','iPad'])){
            return view('home.YingGuo.yg')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','templets','center_nav'));
            }
            return view('home.googlePC.index')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','templets','center_nav'));
            break;
            case '10':
            return view('home.MeiGuo.us')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','templets','center_nav'));
            break;
            case '11':
            return view('home.YueNan.yn')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','templets','center_nav'));
            break;
            case '12':
            return view('home.ShaTe.st')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','templets','center_nav'));
            break;
            case '13':
            return view('home.ShaTeEnglish.st')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','templets','center_nav'));
            break;
            case '14':
            return view('home.KaTaEr.kte')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','templets','center_nav'));
            break;
            case '15':
            return view('home.KaTaErEnglish.kte')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','templets','center_nav'));
            break;
            case '16':
            return view('home.ZD.zd')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','templets','center_nav'));
            break;
            case '17':
            return view('home.ZDEnglish.zd')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','templets','center_nav'));
            break;
            default:
                # code...
                break;
        }

    }
    public function fb(Request $request){
        //屏蔽站点
        $goods_id='4';
        $arr=getclientcity($request);
        $type=getclientype();
        $lan=getclientlan();
        $vis=new vis;
        $vis->vis_ip=$arr['ip'];
        $vis->vis_country=$arr['country'];
        $vis->vis_region=$arr['region'];
        $vis->vis_city=$arr['city'];
        $vis->vis_county=$arr['county'];
        $vis->vis_isp=$arr['isp'];
        $vis->vis_type=$type;
        $vis->vis_lan=$lan;
        $vis->vis_time=date('Y-m-d H:i:s',time());
        $vis->vis_goods_id=$goods_id;
        $vis->vis_url=$_SERVER['SERVER_NAME'];
        $vis->save();  
        return view('view.fb');
    }
    public function comment(Request $request){
    	//接收评论数据
    	$comment=new comment;
    	$comment->com_name=$request->input('name');
    	$comment->com_phone=$request->input('phone');
    	$comment->com_star=$request->input('level');
    	$comment->com_goods_id=$request->input('goods_id');
    	$comment->com_msg=$request->input('content');
    	$comment->com_time=date('Y-m-d H:i:s',time());
    	$comment->com_isuser='1';
    	$comment->com_isshow='0';
    	$ans=$comment->save();
        $vis_id=$request->input('vis_id');
        $vis=\App\vis::where('vis_id',$vis_id)->first();
        $vis->vis_comtime=date('Y-m-d H:i:s',time());
        $vis->save();
    	return response()->json(array('status'=> $ans), 200);
    }

    /** 下单界面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pay(Request $request){
        //下单界面
        //判断是否为预览操作
        if(\Session::get('test_id',0)!=0){
            $goods_id=\Session::get('test_id');
        }else{
           $goods_id=url::get_goods($request);
        }
    	$goods=goods::where('goods_id',$goods_id)->first();
        if($goods==null){
            return view('home.ydzshome.405');
        }
        //处理图片
        $img = \App\img::where('img_goods_id',$goods_id)->orderBy('img_id','asc')->first();
        $str = $goods->goods_des_html;
        $imgpreg = "/<img src=\"(.+?)\" (.*?)>/";
        preg_match($imgpreg,$str,$imgs);
        $mycount=count($imgs)-2;
        if($img){
            $goods->img = $img->img_url;
        }else if(count($imgs)>0){
            $goods->img = $imgs[$mycount];
        }else{
            $goods->img = '';
        }
        //获取产品页首页地址
        $now_url=$_SERVER['SERVER_NAME'];
        //将www二级域名去除
        if(substr($now_url,0,4)=='www.'){
            $now_url=substr($now_url, 4);
        } 
        $is_site=\App\Site::is_site($now_url);
        if($is_site){
            $home_url=$now_url.'/index/site_goods/'.$goods_id;
        }else{
            $home_url=$now_url;
        }
        //支持支付方式
        $goods->goods_pay_type = explode(',',$goods->goods_pay_type);
        $img=img::where('img_goods_id',$goods_id)->first();
    	$cuxiao=cuxiao::where('cuxiao_goods_id',$goods_id)->first();
        if($cuxiao!=null&&$cuxiao->cuxiao_type=='2'&&$cuxiao->cuxiao_config!=''&&$cuxiao->cuxiao_config!=null){
            $cuxiao_num=explode(',',$cuxiao->cuxiao_config)[0];
        }else{
            $cuxiao_num='null';
        }
        $goods_config=\DB::table('goods_config')
        ->select('goods_config.goods_config_type','goods_config.goods_config_id','goods_config.goods_config_msg','goods_config.goods_config_order','config_val.config_diff_price','config_val.config_val_msg','config_val.config_val_img','config_val.config_val_id','config_val.config_type_id','config_val.config_isshow')
        ->leftjoin('config_val','goods_config.goods_config_id','config_val.config_type_id')
        ->where(function($query)use($goods_id){
            $query->where('goods_config.goods_primary_id',$goods_id);
            $query->where('config_val.config_isshow','0');
        })
        ->where(function($query)use($goods){
            if($goods->goods_is_update=='1'){
                $query->where('goods_config.kind_config_id','>','0');
            }
        })
        ->orderBy('goods_config.goods_config_order','desc')
        ->orderBy('config_val.kind_val_id','asc')
        ->get();
        /*$kkk=\DB::table('goods_config')
        ->select('goods_config.goods_config_id','goods_config.goods_config_order')
        ->leftjoin('config_val','goods_config.goods_config_id','config_val.config_type_id')
        ->where(function($query)use($goods_id){
            $query->where('goods_config.goods_primary_id',$goods_id);
            $query->where('config_val.config_isshow','0');
        })
        ->where(function($query)use($goods){
            if($goods->goods_is_update=='1'){
                $query->where('goods_config.kind_config_id','>','0');
            }
        })
        ->orderBy('goods_config.goods_config_order','desc')
        ->get()->toArray();*/
        $sort=[];
        foreach($goods_config as $k => $v)
        {   
            $sort['id'.$v->goods_config_id][]=$v;
            //$sort[$v->goods_config_id]['sort']=$v->goods_config_order;
        }
        /*$order_sort = array_column($sort, 'sort');
        array_multisort($order_sort,SORT_DESC,$sort);
        foreach($sort as $k => $v){
            unset($sort[$k]['sort']);
        }*/
        /*$goods_config_arr=[];
        foreach($sort as $k => $v){
            $goods_config_arr['sort'.$v[0]->goods_config_id]=$v;
        }*/
        $goods_config_arr=(string)json_encode($sort);
        $blade_type=$goods->goods_blade_type;
        if($blade_type==0){
            return view('home.TaiwanFan.buy')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num','home_url'));
        }
        if($blade_type==1){
            return view('home.TaiwanJian.buy')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num','home_url'));
        }
        if($blade_type==2){
            return view('home.zhongdong.zdBuy')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num','home_url'));
        }
        if($blade_type==3){
            return view('home.MaLaiXiYa.mlxyBuy')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num','home_url'));
        }
        if($blade_type==4){
            return view('home.TaiGuo.taiguoBuy')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num','home_url'));
        }
        if($blade_type==5){
            return view('home.RiBen.ribenBuy')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num','home_url'));
        }
        if($blade_type==6){
            return view('home.YinDuNiXiYa.ydnxyBuy')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num','home_url'));
        }
        if($blade_type==7){
            return view('home.FeiLvBin.flbBuy')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num','home_url'));
        }
        if($blade_type==8){
            return view('home.YingGuo.ygBuy')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num','home_url'));
        }
        if($blade_type==9){
             $user_type=get_user_new_type();
            if(in_array($user_type,['Android','iPhone','iPad'])){
            return view('home.YingGuo.ygBuy')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num','home_url'));
            }
            return view('home.googlePC.buy')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num','home_url'));
        }
        if($blade_type==10){
            return view('home.MeiGuo.usBuy')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num','home_url'));
        }
        if($blade_type==11){
            return view('home.YueNan.ynBuy')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num','home_url'));
        }
        if($blade_type==12){
            return view('home.ShaTe.stBuy')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num','home_url'));
        }
        if($blade_type==13){
            return view('home.ShaTeEnglish.stBuy')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num','home_url'));
        }
        if($blade_type==14){
            return view('home.KaTaEr.kteBuy')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num','home_url'));
        }
        if($blade_type==15){
            return view('home.KaTaErEnglish.kteBuy')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num','home_url'));
        }
        if($blade_type==16){
            return view('home.ZD.zdBuy')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num','home_url'));
        }
        if($blade_type==17){
            return view('home.ZDEnglish.zdBuy')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num','home_url'));
        }
    	return view('home.TaiwanFan.buy')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num','home_url'));
    }

    /** 前台活动模板
     * @param Request $request
     * @return cuxiaoSDK
     */
    public function gethtml(Request $request){
        if(!$request->has('id')){
             $ip=$request->getClientIp(); 
             $time=date('Y-m-d H:i:s',time());
             \Log::notice('['.$time.']'.$ip.'获取get方式获取html并无id携带，gethtml获取失败!');
                return response()->json(['err'=>0,'str'=>'请求参数错误']);
        }
        $goods_id=$request->input('id');
        $goods=goods::where('goods_id',$goods_id)->first();
        if($goods->goods_blade_type == 0||$goods->goods_blade_type == 1||$goods->goods_blade_type == 2||$goods->goods_blade_type==3||$goods->goods_blade_type==4||$goods->goods_blade_type==5||$goods->goods_blade_type==6||$goods->goods_blade_type == 7||$goods->goods_blade_type == 8||$goods->goods_blade_type == 9||$goods->goods_blade_type == 10||$goods->goods_blade_type == 11||$goods->goods_blade_type == 12||$goods->goods_blade_type == 13||$goods->goods_blade_type == 14||$goods->goods_blade_type == 15||$goods->goods_blade_type == 16||$goods->goods_blade_type == 17){
            $cuxiao = \App\cuxiao::where('cuxiao_goods_id',$goods_id)->orderBy('cuxiao_id','asc')->get();
            $special = \App\special::where('special_goods_id',$goods_id)->get();
            if(!$special->isEmpty()){
                foreach($special as &$item)
                {
                    $special_good = \App\price::where('price_id',$item->special_price_id)->first();
                    if($special_good){
                        $item->price_img = $special_good->price_img;
                        $item->price_name = $special_good->price_name;
                    }
                }
            }
            if(!$cuxiao->isEmpty()){
                return response()->json(['err'=>1,'str'=>'获取成功','cuxiao'=>$cuxiao,'goods'=>$goods,'special'=>$special]);
            }else{
                return response()->json(['err'=>0,'str'=>'暂无数据','goods'=>$goods]);
            }
        }
        $cuxiaoSDK=new cuxiaoSDK($goods);
        $htmlstr=$cuxiaoSDK->getdiv();
        return $htmlstr;
    }
    public function savetestform(Request $request){
        $ip=$request->getClientIp();
        \Log::notice('ip:'.$ip.json_encode($request->all()).'savetestform');
        $order=new order();
        $order->order_single_id='NR'.makeSingleOrder();
        $order->order_ip=$ip;
        if($request->has('order_country')) $order->order_country=$request->input('order_country');
        $order->order_time=date('Y-m-d H:i:s',time());
        $order_goods_id=url::get_goods($request);
        if($order_goods_id==false){
          return response('order id miss',200);
        }
        $order->order_goods_id=$order_goods_id;
        /*$goods=goods::where('goods_id',$order_goods_id)->first();*/
        $url=url::where('url_goods_id',$order_goods_id)->first()['url_url'];
        if($url==null){
          return response('url error',200);
        }
        $price=0;
        $order->order_price=$price;
        $order_num=0;
        if(!$request->has('notes')||!$request->has('telephone')||!$request->has('city')||!$request->has('email')){
                    return response()->json(['err'=>0,'str'=>'信息填寫不完整！']);
        }
        $order->order_num=$order_num;
        $order->order_cuxiao_id="<span style='color:red;'>屏蔽页面表单</span>";
         $order->order_remark=$request->input('notes');
        $order->order_name=$request->input('firstname');
        $order->order_tel=$request->input('telephone');
        /*$order->order_state=$request->input('state');*/
        $order->order_city=$request->input('city');
        $order->order_add=$request->input('address1');
        $order->order_email=$request->input('email');
        //$msg=$order->save();
        if($msg){
                    return response()->json(['err'=>1,'str'=>'提交成功']);
        }else{
                    return response()->json(['err'=>0,'str'=>'提交失败']);
        }
    }

    /** 订单保存接口
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveform(Request $request){
        //判断是否为预览中的测试下单
        if(\Session::get('test_id',0)!=0){
            $goods_id=\Session::get('test_id');
            $order_id=0;
            return  response()->json(['err'=>1,'url'=>"/endsuccess?type=1&goods_id=$goods_id&order_id=$order_id"]);
        }
        //验证数量合法性
        if($request->input('specNumber')<=0||(int)$request->input('specNumber')!=$request->input('specNumber')){
           \Log::notice('ip:'.$request->getClientIp().'下单时商品数目非法url:'.$_SERVER['SERVER_NAME'].'num:'.$request->input('specNumber'));
          return response()->json(['err'=>0,'url'=>'/endfail?type=0']);
        }

    	$ip=$request->getClientIp();
    	$order=new order();
        if($request->has('order_country')) $order->order_country=$request->input('order_country');
    	$order->order_single_id='NR'.makeSingleOrder();
    	$order->order_ip=$ip;
    	$order->order_time=date('Y-m-d H:i:s',time());
        $order_goods_id=url::get_goods($request);
    	if($order_goods_id==false){
            \Log::notice('ip:'.$request->getClientIp().'下单时找不到url对应goods_id:'.$_SERVER['SERVER_NAME']);
          return response()->json(['err'=>0,'url'=>'/endfail?type=0']);
    	}
    	$order->order_goods_id=$order_goods_id;
        $goods=goods::where('goods_id',$order_goods_id)->first();
//        $order->order_goods_url= url::where('url_goods_id',$order_goods_id)->value('url_url');
        $url = url::get_site_url($_SERVER['SERVER_NAME'],$order_goods_id);
        if(!$url){
            \Log::notice('ip:'.$request->getClientIp().'下单时url对象为空，下单失败！goods_id:'.$goods->goods_id);
            return response()->json(['err'=>0,'url'=>'/endfail?type=0']);
        }
        $order->order_goods_url= $url;
        $order->order_goods_admin_id= $goods->goods_admin_id;

//        $urls=url::where('url_goods_id',$goods->goods_id)->first();
        if($request->input('messaga_code')) {
            $tel = preg_replace('/\D/','',$request->input('telephone'));  //去掉除数字外的全部其他字符
            $tel = message::AreaCode($goods->goods_blade_type,$tel);
            //是否获取手机验证码是否正确
            $messages = Message::where('message_mobile_num', $tel)->orderBy('message_id', 'desc')->first();
            if($request->input('messaga_code') != 'suibian'){
                if (!$messages) {
                    return response()->json(['err' => 2, 'url' => '验证码获取失败']);
                }
                //判断手机验证码是否正确
                if ($messages->messaga_code != $request->input('messaga_code')) {
                    return response()->json(['err' => 2, 'url' => '验证码填写错误']);
                }
                //判断验证码是否过期
                if (time() - strtotime($messages->message_gettime) > 300) {
                    return response()->json(['err' => 2, 'url' => '验证码已过期，请重新获取']);
                }
            }
        }
//        if($urls==null){
//            $url=url::where('url_zz_goods_id',$goods->goods_id)->first()->url_url;
//        }else{
//            $url=$urls->url_url;
//        }
//        if($url==null){
//            \Log::notice('ip:'.$request->getClientIp().'下单时url对象为空，下单失败！goods_id:'.$goods->goods_id);
//          return response()->json(['err'=>0,'url'=>'/endfail?type=0']);
//        }
    	$cuxiaoSDK=new cuxiaoSDK($goods);
    	$price=$cuxiaoSDK->get_price($request->input('specNumber'),$request->input('cuxiao_id'));
        if($request->has('goodsAtt')&&$request->input('goodsAtt')){
            $price=$cuxiaoSDK->get_diff_price($request->input('goodsAtt'),$price);
        }
        //判断金额合法性
    	if($price==false||$price<=0){
            \Log::notice('ip:'.$request->getClientIp().'下单时金额非法goods_id:'.$goods->goods_id.'price:'.$price.'num:'.$request->input('specNumber'));
          return response()->json(['err'=>0,'url'=>'/endfail?type=0']);
    	}
        $order_Array = [];
    	//设置订单是否出现姓名，ip，手机号码重复(更改日期2018-09-18)=========================================================
        //ip
        $goods_ip = \App\order::where('order_ip',$ip)->get();
        if(!$goods_ip->isEmpty()){
            array_push($order_Array,'1');
            foreach ($goods_ip as $item)
            {
                if($item->order_repeat_field){
                    $pos = strpos($item->order_repeat_field, ',');
                    $order_repeat_field  = substr($item->order_repeat_field,$pos-1);
                    $order_repeat = explode(',',$order_repeat_field);
                    if(!in_array('1',$order_repeat)){
                        array_push($order_repeat,'1');
                        sort($order_repeat);
                        $order_repeat_array = implode($order_repeat);
                        $item->order_repeat_field = trim($order_repeat_array);
                        $item->save();
                    }
                }else{
                    $item->order_repeat_field = '1';
                    $item->save();
                }
            }
        }

        //姓名
        $orders_name = \App\order::where('order_name',$request->input('firstname'))->get();
        if(!$orders_name->isEmpty()){
            array_push($order_Array,'2');
            foreach ($orders_name as $item)
            {
                if($item->order_repeat_field){
                    $pos = strpos($item->order_repeat_field, ',');
                    $order_repeat_field  = substr($item->order_repeat_field,$pos-1);
                    $order_repeat = explode(',',$order_repeat_field);
                    if(!in_array('2',$order_repeat)){
                        array_push($order_repeat,'2');
                        sort($order_repeat);
                        $order_repeat_array = implode(',',$order_repeat);
                        $item->order_repeat_field = trim($order_repeat_array);
                        $item->save();
                    }
                }else{
                    $item->order_repeat_field = '2';
                    $item->save();
                }
            }
        }

        //手机号
        $orders_tel = \App\order::where('order_tel',preg_replace('/\D/','',$request->input('telephone')))->get();
        if(!$orders_tel->isEmpty()){
            array_push($order_Array,'3');
            foreach ($orders_tel as $item)
            {
                if($item->order_repeat_field){
                    $pos = strpos($item->order_repeat_field, ',');
                    $order_repeat_field  = substr($item->order_repeat_field,$pos-1);
                    $order_repeat = explode(',',$order_repeat_field);
                    if(!in_array('3',$order_repeat)){
                        array_push($order_repeat,'3');
                        sort($order_repeat);
                        $order_repeat_array = implode(',',$order_repeat);
                        $item->order_repeat_field = trim($order_repeat_array);
                        $item->save();
                    }
                }else{
                    $item->order_repeat_field = '3';
                    $item->save();
                }
            }
        }

        if(!empty($order_Array)){
            sort($order_Array);
            $order_Array = implode(',',$order_Array);
            $order->order_repeat_field=$order_Array;
        }
        //==============================================================================================================
    	//币种 以及  汇率
    	$order->order_currency_id=$goods->goods_currency_id;
    	$order->order_price=$price;
    	$order_num=$request->input('specNumber');
    	//判断商品数合法性
    	if($order_num<=0){
                        \Log::notice('ip:'.$request->getClientIp().'下单时件数错误，下单失败！goods_id:'.$goods->goods_id.'num:'.$order_num);
          return response()->json(['err'=>0,'url'=>'/endfail?type=0']);
    	}
    	$order->order_num=$order_num;
        $cuxiao_msg=\App\cuxiao::where('cuxiao_id',$request->input('cuxiao_id'))->first();
        if($cuxiao_msg){
            $cuxiao_id = $cuxiao_msg->cuxiao_msg;
            $order->order_price_id=special::where('special_id',$cuxiao_msg->cuxiao_special_id)->value('special_price_id');
        }else{
            $cuxiao_id = "暂无促销信息";
        }
    	$order->order_cuxiao_id=$cuxiao_id;
        $order->order_remark=$request->input('notes');
        $order->order_name=$request->input('firstname');
        $order->order_tel=preg_replace('/\D/','',$request->input('telephone'));
        $order->order_state=$request->has('state')?$request->input('state'):'暂无信息';
        $order->order_city=$request->has('city')?$request->input('city'):'暂无信息';
        $order->order_add=$request->input('address1');
        $order->order_zip=$request->input('zip');
        $order->order_village=$request->input('order_village');
        $order->order_country=$request->input('order_country'); //订单所属国家（中东集成模板） 2018-12-27添加
        //邮箱尾部认证
        $email = str_replace(' ','',$request->input('email'));
        $pos = strrpos($email,'.');
        if($email){
            $prefix = substr($email,0,$pos+1);
            $c = substr($email,$pos+1,1);
            $o = substr($email,$pos+2,1);
            $m = substr($email,strlen($email)-1);
            if(($c == 'c' && $m == 'm') || ($c == 'c' && $o == 'o') || ($o == 'o' && $m == 'm')){
                $order->order_email= $prefix.'com';
            }else{
                $order->order_email= $email;
            }
        }
//        $order->order_email=str_replace(' ','',$request->input('email'));
        $order->order_isemail='0';
        $msg=$order->save();

        //==========================================
        if($request->input('messaga_code')) {
            //修改验证码订单ID
            $messages->message_order_id = $order->order_id;
            $messages->save();
        }
        //==========================================

        if($request->has('goodsAtt')){
         $order_id=$order->order_id;
          $arrs=[];
         foreach($request->input('goodsAtt') as $val){
        // $ostr='';
             foreach($val as $key=> $v){
                if(isset($arrs[$key])){
                      $arrs[$key].=$v.',';
                  }else{
                    $arrs[$key]=$v.',';
                  }
              
             }
            /* $ostr= rtrim($ostr,',');
             $order_config->order_config=$ostr;
             $order_config->order_primary_id=$order_id;
             $order_config->save();*/
         }
             foreach($arrs as $k => $v){
                $arrs[$k]=rtrim($v,',');
                  $order_config=new \App\order_config;
                  $order_config->order_config=$arrs[$k];
                 $order_config->order_primary_id=$order_id;
                 $order_config->save();
            }
        }
        
    	if(!$msg){
          \Log::notice('ip:'.$request->getClientIp().'订单存储失败order:'.json_encode($order));
          return response()->json(['err'=>0,'url'=>'/endfail?type=0']);
    	}else{
            $goods_id=$goods->goods_id;
            $order_id=$order->order_id;
        return response()->json(['err'=>1,'url'=>"/endsuccess?type=1&goods_id=$goods_id&order_id=$order_id"]);
            //return view('ajax.endsuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);
    	}
    }
    /**
    * 下单失败
    */
    public function endfail(Request $request){
        return view('home.zhongdong.zdEndFail');    
    }

    public function endsuccess(Request $request){
        $data=$request->all();
        if($request->has('type')&&$request->input('type')=='0'){
            return view('ajax.endfail');
        }
        if(!$request->has('goods_id')||!$request->has('order_id')){
            return view('ajax.endfail');
        }
        $goods=\App\goods::where("goods_id",$request->goods_id)->first();
        if($request->order_id!=0){
             $order=\App\order::where("order_id",$request->order_id)->first();
             if($order==null){
                return view('home.MeiGuo.usEndFail');
             }
             if($order['order_isfirst']==1){
                $order['order_isfirst']='0';
                $order->save();  
                $order['pix_event']=true;//首次展示，触发像素成功结算事件
                //首次展示，触发邮件推送
                if(filter_var($order->order_email,FILTER_VALIDATE_EMAIL)!=false){
                    //推送到发送邮件队列
                            if(config('queue')['default']!='sync'){
                                  try{$emailsend=SendHerbEmail::dispatch($order);}catch(\Exception $e){\Log::notice(json_encode($e));};
                            }else{
                                \Log::notice('队列驱动为同步驱动，取消发送邮件');
                            }
                            \App\order::where('order_id',$request->order_id)->update(['order_isemail'=>'1']);
                            \Log::notice($order['order_email']."是合法邮箱，推送至队列中");
                }else{
                    //邮件不合法,不发送
                            \App\order::where('order_id',$request->order_id)->update(['order_isemail'=>'0']);
                             \Log::notice($order['order_email']."不是合法邮箱，取消推送至队列中");
                }
             }else{
                $order['pix_event']=false;//非首次展示，不触发像素事件
             }
        }else{
            $order=new \App\order;
            $order->order_price='test';
            $order->order_single_id='NR000000000000000';
        }
        $url = url::get_site_url($_SERVER['SERVER_NAME'],$goods->goods_id);
        if(!$url){
          return response()->json(['err'=>0,'url'=>'/endfail?type=0']);
        }
//        $urls=url::where('url_goods_id',$goods->goods_id)->first();
//        if($urls==null){
//            $url=url::where('url_zz_goods_id',$goods->goods_id)->first();
//            $url=isset($url['url_url'])?$url['url_url']:'#';
//        }else{
//            $url=$urls->url_url;
//        }
//        if($url==null){
//          return response()->json(['err'=>0,'url'=>'/endfail?type=0']);
//        }
        if($goods->goods_blade_type == 0){
            return view('home.TaiwanFan.endsuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);            
        }
        if($goods->goods_blade_type == 1){
            return view('home.TaiwanJian.endsuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);            
        }
        if($goods->goods_blade_type == 2){
            return view('home.zhongdong.zdEndSuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);            
        }
        if($goods->goods_blade_type == 3){
            return view('home.MaLaiXiYa.mlxyEndSuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);            
        }
        if($goods->goods_blade_type == 4){
            return view('home.TaiGuo.taiguoEndSuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);            
        }
        if($goods->goods_blade_type == 5){
            return view('home.RiBen.ribenEndSuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);            
        }
        if($goods->goods_blade_type == 6){
            return view('home.YinDuNiXiYa.ydnxyEndSuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);
        }
        if($goods->goods_blade_type == 7){
            return view('home.FeiLvBin.flbEndSuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);
        }
        if($goods->goods_blade_type == 8){
            return view('home.YingGuo.ygEndSuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);
        }
        if($goods->goods_blade_type == 9){
             $user_type=get_user_new_type();
            if(in_array($user_type,['Android','iPhone','iPad'])){
            return view('home.YingGuo.ygEndSuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);
            }
            return view('home.googlePC.endSuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);
        }
        
        if($goods->goods_blade_type == 10){
            return view('home.MeiGuo.usEndSuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);
        }
        if($goods->goods_blade_type == 11){
            return view('home.YueNan.ynEndSuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);
        }
        if($goods->goods_blade_type == 12){
            return view('home.ShaTe.stEndsuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);
        }
        if($goods->goods_blade_type == 13){
            return view('home.ShaTeEnglish.stEndSuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);
        }
        if($goods->goods_blade_type == 14){
            return view('home.KaTaEr.kteEndsuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);
        }
        if($goods->goods_blade_type == 15){
            return view('home.KaTaErEnglish.kteEndsuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);
        }
        if($goods->goods_blade_type == 16){
            return view('home.ZD.zdEndsuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);
        }
        if($goods->goods_blade_type == 17){
            return view('home.ZDEnglish.zdEndsuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);
        }
        return view('home.TaiwanJian.endsuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);
    }
   /* public function orderSuccess(Request $request){
        $order=\App\order::where('order_id',$request->input('order_id'))->first();
        $goods=\App\goods::where('goods_id',$order->order_goods_id)->first();
        if(!$order){
            return view('ajax.endfail')->with(['order'=>$order,'goods'=>$goods]);
        }else{
            return view('ajax.endsuccess')->with(['order'=>$order,'goods'=>$goods]);
        }
    }*/
    public function send(Request $request){
        if($request->has('goods_id')){
            $goods_blade_type = \App\goods::where('goods_id',$request->input('goods_id'))->value('goods_blade_type');
            if($goods_blade_type == 0){
                return view('home.TaiwanFan.send');                
            }
            if($goods_blade_type == 1){
                return view('home.TaiwanJian.send');                
            }
            if($goods_blade_type == 2){
                return view('home.zhongdong.zhSend');                
            }
            if($goods_blade_type == 3){
                return view('home.MaLaiXiYa.mlxySend');                
            }
            if($goods_blade_type == 4){
                return view('home.TaiGuo.taiguoSend');                
            }
            if($goods_blade_type == 5){
                return view('home.RiBen.ribenSend');                
            }
            if($goods_blade_type == 6){
                return view('home.YinDuNiXiYa.ydnxySend');
            }
            if($goods_blade_type == 7){
                return view('home.FeiLvBin.flbSend');
            }
            if($goods_blade_type == 8){
                return view('home.YingGuo.ygSend');
            }
            if($goods_blade_type == 9){
                $user_type=get_user_new_type();
                if(in_array($user_type,['Android','iPhone','iPad'])){
                return view('home.YingGuo.ygSend');
                }
                return view('home.YingGuo.ygSend');
            }
            if($goods_blade_type == 10){
                return view('home.MeiGuo.usSend');
            }
            if($goods_blade_type == 11){
                return view('home.YueNan.ynSend');
            }
            if($goods_blade_type == 12){
                return view('home.ShaTe.stSend');
            }
            if($goods_blade_type == 13){
                return view('home.ShaTeEnglish.stSend');
            }
            if($goods_blade_type == 14){
                return view('home.KaTaEr.kteSend');
            }
            if($goods_blade_type == 15){
                return view('home.KaTaErEnglish.kteSend');
            }
            if($goods_blade_type == 16){
                return view('home.ZD.zdSend');
            }
            if($goods_blade_type == 17){
                return view('home.ZDEnglish.zdSend');
            }
        }
        return view('home.TaiwanFan.send');
    }

    public function getsendmsg(Request $request){
        $msg = $request->input('msg');
        if(substr($msg,0,2) != 'NR'){
            $msg = 'NR'.$msg;
        }
        $order=\App\order::where('order_single_id',$msg)->first();
        if($order==null||$order==false){
            /*dd($order);*/
            return json_encode(false);
        }
        $goods=\App\goods::where('goods_id',$order->order_goods_id)->first();
        if($goods==null||$goods==null){
            return json_encode(false);
        }
        if($goods->goods_blade_type == 0){
            return view('home.TaiwanFan.sendmsg')->with(compact('order','goods'));
        }
        if($goods->goods_blade_type == 1){
            return view('home.TaiwanJian.sendmsg')->with(compact('order','goods'));
        }
        if($goods->goods_blade_type == 2){
            return view('home.zhongdong.zdSendmsg')->with(compact('order','goods'));
        }
        if($goods->goods_blade_type == 3){
            return view('home.MaLaiXiYa.mlxySendmsg')->with(compact('order','goods'));
        }
        if($goods->goods_blade_type == 4){
            return view('home.TaiGuo.taiguoSendmsg')->with(compact('order','goods'));
        }
        if($goods->goods_blade_type == 5){
            return view('home.RiBen.ribenSendmsg')->with(compact('order','goods'));
        }
        if($goods->goods_blade_type == 6){
            return view('home.YinDuNiXiYa.ydnxySendmsg')->with(compact('order','goods'));
        }
        if($goods->goods_blade_type == 7){
            return view('home.FeiLvBin.flbSendmsg')->with(compact('order','goods'));
        }
        if($goods->goods_blade_type == 8){
            return view('home.YingGuo.ygSendmsg')->with(compact('order','goods'));
        }
        if($goods->goods_blade_type == 9){
             $user_type=get_user_new_type();
             if(in_array($user_type,['Android','iPhone','iPad'])){
            return view('home.YingGuo.ygSendmsg')->with(compact('order','goods'));
                }
            return view('home.googlePC.sendmsg')->with(compact('order','goods'));
        }
        if($goods->goods_blade_type == 10){
            return view('home.MeiGuo.usSendmsg')->with(compact('order','goods'));
        }
        if($goods->goods_blade_type == 11){
            return view('home.YueNan.ynSendmsg')->with(compact('order','goods'));
        }
        if($goods->goods_blade_type == 12){
            return view('home.ShaTe.stSendmsg')->with(compact('order','goods'));
        }
        if($goods->goods_blade_type == 13){
            return view('home.ShaTeEnglish.stSendmsg')->with(compact('order','goods'));
        }
        if($goods->goods_blade_type == 14){
            return view('home.KaTaEr.kteSendmsg')->with(compact('order','goods'));
        }
        if($goods->goods_blade_type == 15){
            return view('home.KaTaErEnglish.kteSendmsg')->with(compact('order','goods'));
        }
        if($goods->goods_blade_type == 16){
            return view('home.ZD.zdSendmsg')->with(compact('order','goods'));
        }
        if($goods->goods_blade_type == 17){
            return view('home.ZDEnglish.zdSendmsg')->with(compact('order','goods'));
        }
        return view('home.TaiwanFan.sendmsg')->with(compact('order','goods'));
    }
    public function channelindex(){
        return view('view.index');
    }
    public function visfrom(Request $request){
        if($request->input('id')==0){
            return response('test',200);
        }
    $id=$request->input('id');
    $from=$request->input('from');
    $vis=\App\vis::where('vis_id',$id)->first();
    if($vis==null){
        return;
    }
    $vis->vis_from=$from;
    $vis->vis_from=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:null;
    $vis->save();
   }
   public function settime(Request $request){
        if($request->input('id')==0){
            return response('test',200);
        }
        try{
             $data=json_decode($request->input('data'));
        }catch(\Exception $e){
            \Log::notice('settime方法出现错误，传来数据为：'.json_encode($request->input('data')).'错误为：'.json_encode($e));
        }
        $id=$request->input('id');
        $vis=\App\vis::where('vis_id',$id)->first();
        if($vis==null||$vis==false){
            return;
        }
        if(is_array($vis)){
         $time=time()-strtotime(($vis['vis_time']));
        }else{
         $time=time()-strtotime(($vis->vis_time));
        }
        if($vis->vis_staytime==0){
                    $vis->vis_staytime=$time;
        }else{
            $vis->vis_staytime=$time;
        }
        $vis->save();
   }
   public function setbuy(Request $request){
        if($request->input('id')==0){
            return response('test',200);
        }
    $id=$request->input('id');
    if($id==null){
        return false;
    }
    $vis=\App\vis::where('vis_id',$id)->first();
    if($vis==null){
        return false;
    }
    try{
            $time=$request->input('date');
    }catch(\Exception $e){
        $change=time();
    }
    $change=strtotime($time);
    $time=date('Y-m-d H:i:s',$change);
 /*   $data=date('Y-m-d H:i:s',$time);*/
    $vis->vis_staytime=time()-strtotime(($vis->vis_time));
    $vis->vis_buytime=$time;
    $vis->save();
   }
   public function setorder(Request $request){
        if($request->input('id')==0){
            return response('test',200);
        }
    $date=$request->input('date');
     $change=strtotime($date);
    $date=date('Y-m-d H:i:s',$change);
    $vis=\App\vis::where('vis_id',$request->input('id'))->first();
    if($vis==null){
        \Log::notice($request->input('id').'-vis为null');
        die;
    }
    $vis->vis_ordertime=$date;
    $vis->vis_staytime=time()-strtotime(($vis->vis_time));
    $vis->save();
   }
   //企业站提交表单
   public function busform(Request $request){
    $data=$request->all();
    $business_form=new \App\business_form;
    $business_form->business_form_url=$_SERVER['SERVER_NAME'];
    $business_form->business_form_email=$data['email'];
    $business_form->business_form_msg=$data['message'];
    $business_form->business_form_phone=$data['phone'];
    $business_form->business_form_username=$data['name'];
    $business_form->save();
   }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
   public function paypal_pay(Request $request){
        //判断是否为预览中的测试下单
       if(\Session::get('test_id',0)!=0){

           return  response()->json(['err'=>0,'url'=>"/pay"]);
       }
       $ip=$request->getClientIp();
       $order=new order();
       if($request->has('order_country')) $order->order_country=$request->input('order_country');
       $order->order_single_id='NR'.makeSingleOrder();
       $order->order_ip=$ip;
       $order->order_time=date('Y-m-d H:i:s',time());
       $order_goods_id=url::get_goods($request);
       if($order_goods_id==false){
           return response()->json(['err'=>0,'url'=>'/endfail?type=0']);
       }
       $order->order_goods_id=$order_goods_id;
       $goods=goods::where('goods_id',$order_goods_id)->first();
       $url = url::get_site_url($_SERVER['SERVER_NAME'],$order_goods_id);
       if(!$url){
        \Log::notice('ip:'.$request->getClientIp().'下单时非法url:'.$_SERVER['SERVER_NAME'].'num:'.$request->input('specNumber'));
          return response()->json(['err'=>0,'url'=>'/endfail?type=0']);
       }
//       $urls=url::where('url_goods_id',$order_goods_id)->first();
//       if($urls==null){
//           $url=url::where('url_zz_goods_id',$goods->goods_id)->first()->url_url;
//       }else{
//           $url=$urls->url_url;
//       }
//       if($url==null){
//        \Log::notice('ip:'.$request->getClientIp().'下单时非法url:'.$_SERVER['SERVER_NAME'].'num:'.$request->input('specNumber'));
//          return response()->json(['err'=>0,'url'=>'/endfail?type=0']);
//       }
       $order->order_goods_url= $url;
       $order->order_goods_admin_id= $goods->goods_admin_id;
       $cuxiaoSDK=new cuxiaoSDK($goods);
       $price=$cuxiaoSDK->get_price($request->input('specNumber'),$request->input('cuxiao_id'));
       if($request->has('goodsAtt')&&$request->input('goodsAtt')){
            $price=$cuxiaoSDK->get_diff_price($request->input('goodsAtt'),$price);
        }
       //判断金额合法性
       if($price==false||$price<=0){
           \Log::notice('ip:'.$request->getClientIp().'下单时商品金额非法price:'.$price.'num:'.$request->input('specNumber').'goods_id'.$order_goods_id);
           return response()->json(['err'=>0,'url'=>'/endfail?type=0']);
       }

       if($request->input('messaga_code')) {
           $tel = $request->input('telephone');
           $tel = message::AreaCode($goods->goods_blade_type,$tel);
           //是否获取手机验证码是否正确
           $messages = Message::where('message_mobile_num', $tel)->orderBy('message_id', 'desc')->first();
           if($request->input('messaga_code') != 'suibian'){
               if (!$messages) {
                   return response()->json(['err' => 2, 'url' => '验证码获取失败']);
               }
               //判断手机验证码是否正确
               if ($messages->messaga_code != $request->input('messaga_code')) {
                   return response()->json(['err' => 2, 'url' => '验证码填写错误']);
               }
               //判断验证码是否过期
               if (time() - strtotime($messages->message_gettime) > 300) {
                   return response()->json(['err' => 2, 'url' => '验证码已过期，请重新获取']);
               }
           }
       }

       $order_Array = [];
       //设置订单是否出现姓名，ip，手机号码重复(更改日期2018-09-18)=========================================================
       //ip
       $goods_ip = \App\order::where('order_ip',$ip)->get();
       if(!$goods_ip->isEmpty()){
           array_push($order_Array,'1');
           foreach ($goods_ip as $item)
           {
               if($item->order_repeat_field){
                   $order_repeat = explode(',',$item->order_repeat_field);
                   if(!in_array('1',$order_repeat)){
                       array_push($order_repeat,'1');
                       $order_repeat_array = implode($order_repeat);
                       $item->order_repeat_field = trim($order_repeat_array);
                       $item->save();
                   }
               }else{
                   $item->order_repeat_field = '1';
                   $item->save();
               }
           }
       }

       //姓名
       $orders_name = \App\order::where('order_name',$request->input('firstname'))->get();
       if(!$orders_name->isEmpty()){
           array_push($order_Array,'2');
           foreach ($orders_name as $item)
           {
               if($item->order_repeat_field){
                   $order_repeat = explode(',',$item->order_repeat_field);
                   if(!in_array('2',$order_repeat)){
                       array_push($order_repeat,'2');
                       $order_repeat_array = implode(',',$order_repeat);
                       $item->order_repeat_field = trim($order_repeat_array);
                       $item->save();
                   }
               }else{
                   $item->order_repeat_field = '2';
                   $item->save();
               }
           }
       }

       //手机号
       $orders_tel = \App\order::where('order_tel',$request->input('telephone'))->get();
       if(!$orders_tel->isEmpty()){
           array_push($order_Array,'3');
           foreach ($orders_tel as $item)
           {
               if($item->order_repeat_field){
                   $order_repeat = explode(',',$item->order_repeat_field);
                   if(!in_array('3',$order_repeat)){
                       array_push($order_repeat,'3');
                       $order_repeat_array = implode(',',$order_repeat);
                       $item->order_repeat_field = trim($order_repeat_array);
                       $item->save();
                   }
               }else{
                   $item->order_repeat_field = '3';
                   $item->save();
               }
           }
       }

       if(!empty($order_Array)){
           sort($order_Array);
           $order_Array = implode(',',$order_Array);
           $order->order_repeat_field=$order_Array;
       }
       //币种 以及  汇率
       $order->order_currency_id=$goods->goods_currency_id;
       $order->order_price=$price;
       $order_num=$request->input('specNumber');
       //判断商品数合法性
       if($order_num<=0){
           \Log::notice('ip:'.$request->getClientIp().'下单时商品数目非法num:'.$request->input('specNumber').'goods_id'.$order_goods_id);
           return response()->json(['err'=>0,'url'=>'/endfail?type=0']);
       }
       $order->order_type= 9;//付费状态
       $order->order_pay_type= 1;//paypal在线支付
       $order->order_num=$order_num;
       $cuxiao_msg=\App\cuxiao::where('cuxiao_id',$request->input('cuxiao_id'))->first();
       if($cuxiao_msg){
           $cuxiao_id = $cuxiao_msg->cuxiao_msg;
           $order->order_price_id=special::where('special_id',$cuxiao_msg->cuxiao_special_id)->value('special_price_id');
       }else{
           $cuxiao_id = "暂无促销信息";
       }
       $order->order_cuxiao_id=$cuxiao_id;
//       $cuxiao_msg=\App\cuxiao::where('cuxiao_id',$request->input('cuxiao_id'))->first();
//       $cuxiao_msg=$cuxiao_msg!=null?$cuxiao_msg->cuxiao_msg:"暂无促销信息";
//       $order->order_cuxiao_id=$cuxiao_msg;
       $order->order_remark=$request->input('notes');
       $order->order_name=$request->input('firstname');
       $order->order_tel=$request->input('telephone');
       $order->order_state=$request->has('state')?$request->input('state'):'暂无信息';
       $order->order_city=$request->has('city')?$request->input('city'):'暂无信息';
       $order->order_add=$request->input('address1');
       $order->order_zip=$request->input('zip');
       $order->order_village=$request->input('order_village');
       $order->order_country=$request->input('order_country'); //订单所属国家（中东集成模板） 2018-12-27添加
//       $order->order_email=str_replace(' ','',$request->input('email'));
       //邮箱尾部认证 2018-12-29
       $email = str_replace(' ','',$request->input('email'));
       $pos = strrpos($email,'.');
       if($email){
           $prefix = substr($email,0,$pos+1);
           $c = substr($email,$pos+1,1);
           $o = substr($email,$pos+2,1);
           $m = substr($email,strlen($email)-1);
           if(($c == 'c' && $m == 'm') || ($c == 'c' && $o == 'o') || ($o == 'o' && $m == 'm')){
               $order->order_email= $prefix.'com';
           }else{
               $order->order_email= $email;
           }
       }
       $msg=$order->save();

       //==========================================
       //修改验证码订单ID
       if($request->input('messaga_code')){
           $messages->message_order_id = $order->order_id;
           $messages->save();
       }
       //==========================================
       if($request->has('goodsAtt')){
           $order_id=$order->order_id;
           $arrs=[];
           foreach($request->input('goodsAtt') as $val){
               foreach($val as $key=> $v){
                   if(isset($arrs[$key])){
                       $arrs[$key].=$v.',';
                   }else{
                       $arrs[$key]=$v.',';
                   }
               }
           }
           foreach($arrs as $k => $v){
               $arrs[$k]=rtrim($v,',');
               $order_config=new \App\order_config;
               $order_config->order_config=$arrs[$k];
               $order_config->order_primary_id=$order_id;
               $order_config->save();
           }
       }
       $link=$this->paypal($order->order_id);
       if($link===false){
           \Log::notice('ip:'.$request->getClientIp().'下单时paypal返回错误price:'.$price.'num:'.$request->input('specNumber').'goods_id'.$order_goods_id.'url:'.$_SERVER['SERVER_NAME']);
        return response()->json(['err'=>0,'msg'=>'paypal fail']);
       }
       return response()->json(['err'=>1,'url'=>$link]);
   }

    /**
     * paypal支付
     * @param $order_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
   private function paypal($order_id)
   {
           $data = $this->getCart($order_id);
           $recurring  = false;
           // TODO 解决币种问题
           $currency = currency_type::where('currency_type_id',order::where('order_id',$order_id)->value('order_currency_id'))->first();

           if(!in_array($currency->currency_english_name,currency_type::$CURRENCY_TYPE)){
               $this->provider->setCurrency('USD')->setExpressCheckout($data);
           }else{
               $this->provider->setCurrency($currency->currency_english_name)->setExpressCheckout($data);
           }

           // send a request to paypal
           // paypal should respond with an array of data
           // the array should contain a link to paypal's payment system
           $response = $this->provider->setExpressCheckout($data, $recurring);
           // if there is no link redirect back with error message
           if (!$response['paypal_link']) {
            \App\order::where('order_id',$order_id)->delete();
          return false;
               //return redirect('/pay')->with(['code' => 'danger', 'message' => 'Something went wrong with PayPal']);
               // For the actual error message dump out $response and see what's in there
           }

       return $response['paypal_link'];

   }

    /**
     * 拼接订单参数
     * @param $order_id
     * @return mixed
     */
   private function getCart($order_id)
   {
       $order = order::where('order_id',$order_id)->first();
       $currency = currency_type::where('currency_type_id',order::where('order_id',$order_id)->value('order_currency_id'))->first();
       $data['items'] = [
           [
               'name' => goods::where('goods_id',$order->order_goods_id)->value('goods_real_name'),
               'price' =>$order->order_price,
               'qty' => 1,
           ],
       ];
       // return url is the url where PayPal returns after user confirmed the payment
       $data['return_url'] = url('/expressCheckoutSuccess');
       // every invoice id must be unique, else you'll get an error from paypal
       $data['invoice_id'] = config('paypal.invoice_prefix') . '_' . $order_id;
       $data['invoice_description'] = "Order #" . $order_id . " Invoice";
       $data['cancel_url'] = url('/paypal_send?order_id='.$order_id);
       // total is calculated by multiplying price with quantity of all cart items and then adding them up
       // in this case total is 20 because Product 1 costs 10 (price 10 * quantity 1) and Product 2 costs 10 (price 5 * quantity 2)
       $data['total'] = $order->order_price;
       if(!in_array($currency->currency_english_name,currency_type::$CURRENCY_TYPE)){
           $data['total'] = sprintf('%.2f',$order->order_price*$currency->exchange_rate*0.1456);
           $data['items'] = [
               [
                   'name' => goods::where('goods_id',$order->order_goods_id)->value('goods_real_name'),
                   'price' =>sprintf('%.2f',$order->order_price*$currency->exchange_rate*0.1456),
                   'qty' => 1,
               ],
           ];
       }
       return $data;
   }

    /**
     * 放弃订单
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
   public function paypal_send()
   {
       $order_id = $_GET['order_id'];
       $msg=\App\order::where('order_id',$order_id)->first()['order_type'];
       if($msg!='11'&&$msg!='13'){
        $order = order::where('order_id', $order_id)->delete();
         return redirect('/pay');
       }else{
          return redirect('/pay');
       }
       /*$order = order::where('order_id', $order_id)->delete();
       if ($order) {
           return redirect('/pay');
       }*/
   }

    /**
     * 订单paypal支付成功
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
   public function expressCheckoutSuccess(Request $request)
   {
        $token = $request->get('token');
        $PayerID = $request->get('PayerID');//支付者paypalid
        $response = $this->provider->getExpressCheckoutDetails($token);//解析回调数据
        if (!in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            $invoice_id = explode('_', $response['INVNUM'])[1];
            try{
                 $order=\App\order::where('order_id',$invoice_id)->update(['order_type'=>'12']);
                }catch(Exception $e){
                }
            return redirect('/endfail')->with(['type' =>'0']);
        }
        $invoice_id = explode('_', $response['INVNUM'])[1];//获取数据库订单表中订单号
        $cart = $this->getCart($invoice_id);//获取发起请求时组装的参数
        //设置币种
        $currency = currency_type::where('currency_type_id',order::where('order_id',$invoice_id)->value('order_currency_id'))->first();
        if(!in_array($currency->currency_english_name,currency_type::$CURRENCY_TYPE)){
            $this->provider->setCurrency('USD')->setExpressCheckout($cart);
        }else{
            $this->provider->setCurrency($currency->currency_english_name)->setExpressCheckout($cart);
        }   
        //二次验证回调数据
        $payment_status = $this->provider->doExpressCheckoutPayment($cart, $token, $PayerID);
        if (!in_array(strtoupper($payment_status['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            $invoice_id = explode('_', $response['INVNUM'])[1];
            try{
                 $order=\App\order::where('order_id',$invoice_id)->update(['order_type'=>'12']);
                }catch(Exception $e){
                     \Log::notice("[".date('Y-m-d H:i:s',time())."]".$invoice_id."号订单修改状态为(支付失败)操作失败".$e);
                }
            return redirect('/endfail?type=0');
        }
        $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];//payal反馈订单状态码
        $order = \App\order::where('order_id',$invoice_id)->first();//获取系统中订单信息
        $paypal=new \App\paypal();//记录paypal信息
        $paypal->paypal_paymentstatus=$status;
        $paypal->paypal_corre_id=$response['CORRELATIONID'];
        $paypal->paypal_token=$token;
        $paypal->paypal_amount=$response['AMT'];
        $paypal->paypal_currency=$response['CURRENCYCODE'];
        $paypal->paypal_time=$response['TIMESTAMP'];
        $paypal->paypal_status=$response['ACK'];
        $paypal->paypal_payer_id=$PayerID;
        $paypal->paypal_email=$response['EMAIL'];
        $paypal->paypal_firstname=$response['FIRSTNAME'];
        $paypal->paypal_lastname=$response['LASTNAME'];
        $paypal->paypal_order_id=$invoice_id;
        $paypal->paypal_desc=$response['DESC'];
        try{
              $msg=$paypal->save();
          }catch(\Exception $e){
            \Log::notice("[".date('Y-m-d H:i:s',time())."]".$invoice_id."号订单支付回调信息存储失败".$e);
          }
        if($msg){
            $order->order_type='11';
            if($order->is_del=='1'){
                \Log::notice("[".date('Y-m-d H:i:s',time())."]".$order->order_id."号订单取消删除并修改为支付成功状态！");
                $order->is_del='0';
            }
            $order->save();
            $goods_id=$order->order_goods_id;
            $order_id=$order->order_id;
            return redirect("/endsuccess?type=1&goods_id={$goods_id}&order_id={$order_id}");
        }else{
            $order->order_type='13';
            if($order->is_del=='1'){
                \Log::notice("[".date('Y-m-d H:i:s',time())."]".$order->order_id."号订单取消删除并修改为支付成功状态！但支付数据存储失败");
                $order->is_del='0';
            }
            $order->save();
            $goods_id=$order->order_goods_id;
            $order_id=$order->order_id;
            return redirect("/endsuccess?type=1&goods_id={$goods_id}&order_id={$order_id}");
        }
   }
    /**
     * 发送短信
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
   public function sendMessages(Request $request)
   {
       $count=\App\message::where(function($query)use($request){
            $query->where('message_mobile_num',$request->input('telephone'));
            $query->where('message_status',0);
            $query->where('message_gettime','>',date('Y-m-d H:i:s',time()-1800));
       })->count();
       if($count>=5){
            \Log::notice($request->input('telephone').'尝试发送短信次数过多，拒绝响应');
           return response()->json(['err'=>0,'url'=>'Too many attempts']);
       }
       $num = rand(100000, 999999); //验证码
       $blade_id=goods::find(url::get_goods($request))->goods_blade_type;
       $text=sendMessage::send_text($blade_id,$num);
       $phone = $request->input('telephone');
       $data_info = sendMessage::send($request,$phone,$text,$num);
       if($data_info['code'] == 0){
           return response()->json(['err'=>1,'url'=>'success']);
       }else{
           return response()->json(['err'=>0,'url'=>'fail']);
//           return response()->json(['err'=>0,'url'=>$data_info['msg']]);
       }
   }

    /**
     * 测试2019-02-20
     * @return \Illuminate\Http\JsonResponse
     */
   public function get_color_data()
   {
        //1.获取所有产品
        $goods_kinds = goods_kind::pluck('goods_kind_id')->toArray();
        //2.根据产品找到属性名为颜色的属性
       $str_true = '';
       $str_false = '';
       foreach ($goods_kinds as $goods_kind){
           $kind_config = kind_config::where('kind_primary_id',$goods_kind)->get();
           if(!$kind_config->isEmpty()){
                foreach ($kind_config as $item){
                    if (strtolower($item->kind_config_english_msg） == 'color') || in_array($item->kind_config_msg, ['颜色', '顏色']) || strtolower($item->kind_config_msg) == 'color') {
                        //3.获取颜色产品属性sku并填充到数据库
                        $kind_type_ids = kind_val::where('kind_type_id',$item->kind_config_id)->get();
                        $goods_config_color = [];
                        if(!$kind_type_ids->isEmpty()){
                            foreach ($kind_type_ids as $kind_val){
                                $kind_val_msg = $kind_val->kind_val_msg;
                                $kind_val_msg_num = strlen($kind_val_msg);
                                if(!$kind_val_msg){
                                    $num = '00';
                                }else{
                                    $num = '90';
                                    for($i = 0; $i < $kind_val_msg_num; $i += 3){
                                        $font = substr($kind_val_msg,$i,3);
                                            switch ($font){
                                                case '黑':
                                                    $num = '01';
                                                    break;
                                                case '灰':
                                                    $num = '10';
                                                    break;
                                                case '蓝':
                                                    $num = '20';
                                                    break;
                                                case '绿':
                                                    $num = '30';
                                                    break;
                                                case '棕':
                                                    $num = '40';
                                                    break;
                                                case '红':
                                                    $num = '50';
                                                    break;
                                                case '紫':
                                                    $num = '60';
                                                    break;
                                                case '黄':
                                                    $num = '70';
                                                    break;
                                                case '白':
                                                    $num = '80';
                                                    break;
                                                default:
                                            }
//                                        }
                                    }
                                }
                                array_push($goods_config_color,$num);
                                $ac=array_count_values($goods_config_color);
                                if(!trim($kind_val->kind_val_sku)){
                                    $kind_val->kind_val_sku = $num/10 < 1 ? '0' .skuSDK::num_return($ac[$num])  : $num/10 .skuSDK::num_return($ac[$num]-1);
                                    $bool = $kind_val->save();
                                    if($bool){
                                        $str_true .= $kind_val->kind_val_id.'=======';
                                    }else{
                                        $str_false .= $kind_val->kind_val_id.'=======';
                                    }
                                }
                            }
                        }
                    }
                }
           }
       }
       return response()->json(['成功'=>$str_true,'失败'=>$str_false]);
   }

}
