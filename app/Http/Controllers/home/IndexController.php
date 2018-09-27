<?php

namespace App\Http\Controllers\home;

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
class IndexController extends Controller
{
    /** 前台首页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
/*       dd(getclientcity($request));*/
    	//获取该域名对应商品id
        if(\Session::get('test_id',0)!=0){
            $goods_id=\Session::get('test_id');
        }else{
                $goods_id=url::get_goods($request); 
        }
    	$imgs=img::where('img_goods_id',$goods_id)->orderBy('img_id','asc')->get(['img_url']);
    	$goods=goods::where('goods_id',$goods_id)->first();
    	$comment=comment::where(['com_goods_id'=>$goods_id,'com_isshow'=>'1'])->orderBy('com_order','desc')->get();
        foreach($comment as $v=> $key){
            $usename=mb_substr($key->com_name,0,1);
            $usename.='*';
            if(strlen($key->com_name)>2){
              $usename.=mb_substr($key->com_name,2);
            }
            $comment[$v]->com_name=$usename;
            $com_imgs=\App\com_img::where('com_primary_id',$key->com_id)->get();
            if(count($com_imgs)>0){
                 $comment[$v]->com_img=$com_imgs;
             }else{
                $comment[$v]->com_img=null;
             }
        }
    	$des_img=des::where('des_goods_id',$goods_id)->get();
    	$par_img=par::where('par_goods_id',$goods_id)->get();
    	$cuxiao=cuxiao::where('cuxiao_goods_id',$goods_id)->orderBy('cuxiao_id','asc')->first();
    	//获取倒计时计算为秒数
        $timer=$goods->goods_end;
        $parsed = date_parse($timer);
        $goods->goods_end=$parsed['hour'] * 3600+$parsed['minute'] * 60+$parsed['second'];

        //获取页面显示内容
        $goods_templet = \App\goods_templet::where('goods_id',$goods_id)->get();
        $templets = [];
        $center_nav = 0;  //中部导航显示个数
        if(!$goods_templet->isEmpty()){
            foreach ($goods_templet as $item)
            {
                if(isset($item->templet_has_show->templet_english_name)){
                    if($item->templet_has_show->templet_english_name == 'introduce'){
                        $center_nav++;
                    }
                    if($item->templet_has_show->templet_english_name == 'specifications'){
                        $center_nav++;
                    }
                    if($item->templet_has_show->templet_english_name == 'evaluate'){
                        $center_nav++;
                    }
                    array_push($templets,$item->templet_has_show->templet_english_name);
                }
            }
        }

        //模板渲染
        $blade_type=$goods->goods_blade_type;
        switch ($blade_type) {
            case '0':
            return view('home.index')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','templets','center_nav'));
                break;
            case '1':
            return view('home.index')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','templets','center_nav'));
                break;
            case '2':
            return view('home.zhongdong.zhongdong')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','templets','center_nav'));
                break;
            case '3':
            return view('home.MaLaiXiYa.mlxy')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','templets','center_nav'));
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
        //处理图片
        $img = \App\img::where('img_goods_id',$goods_id)->first();
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
    	$img=img::where('img_goods_id',$goods_id)->first();
    	$cuxiao=cuxiao::where('cuxiao_goods_id',$goods_id)->first();
        if($cuxiao!=null&&$cuxiao->cuxiao_type=='2'&&$cuxiao->cuxiao_config!=''&&$cuxiao->cuxiao_config!=null){
            $cuxiao_num=explode(',',$cuxiao->cuxiao_config)[0];
        }else{
            $cuxiao_num='null';
        }
        $goods_config=\DB::table('goods_config')
        ->select('goods_config.goods_config_type','goods_config.goods_config_id','goods_config.goods_config_msg','config_val.config_val_msg','config_val.config_val_img','config_val.config_val_id','config_val.config_type_id')
        ->leftjoin('config_val','goods_config.goods_config_id','config_val.config_type_id')
        ->where('goods_config.goods_primary_id',$goods_id)
        ->orderBy('config_val.config_val_id','asc')
        ->get();
        
        $goods_config_arr=[];
        foreach($goods_config as $k => $v){
            $goods_config_arr[$v->goods_config_id][]=$v;
        } /*dd($goods_config_arr);*/
        $goods_config_arr=(string)json_encode($goods_config_arr);
        $blade_type=$goods->goods_blade_type;
        if($blade_type==1){
            return view('home.buy2')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num'));
        }
        if($blade_type==2){
            return view('home.zhongdong.zdBuy')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num'));
        }
        if($blade_type==3){
            return view('home.MaLaiXiYa.mlxyBuy')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num'));
        }
    	return view('home.buy')->with(compact('goods','img','cuxiao','goods_config_arr','cuxiao_num'));
    }

    /** 前台活动模板
     * @param Request $request
     * @return cuxiaoSDK
     */
    public function gethtml(Request $request){
        $goods_id=$request->input('id');
        $goods=goods::where('goods_id',$goods_id)->first();
        if($goods->goods_blade_type == 2||$goods->goods_blade_type==3){ 
            $cuxiao = \App\cuxiao::where('cuxiao_goods_id',$goods_id)->get();
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
        $order=new order();
        $order->order_single_id='NR'.makeSingleOrder();
        $order->order_ip=$ip;
        $order->order_time=date('Y-m-d H:i:s',time());
        $order_goods_id=url::get_goods($request);
        if($order_goods_id==false){
          return response('error',200);
        }
        $order->order_goods_id=$order_goods_id;
        /*$goods=goods::where('goods_id',$order_goods_id)->first();*/
        $url=url::where('url_goods_id',$order_goods_id)->first()->url_url;
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
        $msg=$order->save();
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
    	$ip=$request->getClientIp();
    	$order=new order();
    	$order->order_single_id='NR'.makeSingleOrder();
    	$order->order_ip=$ip;
    	$order->order_time=date('Y-m-d H:i:s',time());
        $order_goods_id=url::get_goods($request);
    	if($order_goods_id==false){
          return response()->json(['err'=>0,'url'=>'/endfail?type=0']);
    	}
    	$order->order_goods_id=$order_goods_id;
        $goods=goods::where('goods_id',$order_goods_id)->first();
//         dd($goods);
    	$urls=url::where('url_goods_id',$goods->goods_id)->first();
        if($urls==null){
            $url=url::where('url_zz_goods_id',$goods->goods_id)->first()->url_url;
        }else{
            $url=$urls->url_url;
        }
        if($url==null){
            return false;
        }
    	$cuxiaoSDK=new cuxiaoSDK($goods);
    	$price=$cuxiaoSDK->get_price($request->input('specNumber'));

        //判断金额合法性
    	if($price==false||$price<=0){
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
        //==============================================================================================================
    	//币种 以及  汇率
    	$order->order_currency_id=$goods->goods_currency_id;
    	$order->order_price=$price;
    	$order_num=$request->input('specNumber');
    	//判断商品数合法性
    	if($order_num<=0){
          return response()->json(['err'=>0,'url'=>'/endfail?type=0']);
    	}
    	$order->order_num=$order_num;
    	$cuxiao_msg=\App\cuxiao::where('cuxiao_id',$request->input('cuxiao_id'))->first();
    	$cuxiao_msg=$cuxiao_msg!=null?$cuxiao_msg->cuxiao_msg:"暂无促销信息";
    	$order->order_cuxiao_id=$cuxiao_msg;
        $order->order_remark=$request->input('notes');
        $order->order_name=$request->input('firstname');
        $order->order_tel=$request->input('telephone');
        $order->order_state=$request->has('state')?$request->input('state'):'暂无信息';
        $order->order_city=$request->has('city')?$request->input('city'):'暂无信息';
        $order->order_add=$request->input('address1');
        $order->order_email=$request->input('email');
        $msg=$order->save();
        if($request->has('goodsAtt')){
         $order_id=$order->order_id;
          $arrs=[];
         foreach($request->input('goodsAtt') as $val){
             $ostr='';
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
        return view('home.zhongdong.zdEndfail');    
    }

    public function endsuccess(Request $request){
        $data=$request->all();
        if($request->has('type')&&$request->input('type')=='0'){
            return view('ajax.endfail');
        }
        $goods=\App\goods::where("goods_id",$request->goods_id)->first();
        if($request->order_id!=0){
             $order=\App\order::where("order_id",$request->order_id)->first();
        }else{
            $order=new \App\order;
            $order->order_price='test';
            $order->order_single_id='NR000000000000000';
        }
        $urls=url::where('url_goods_id',$goods->goods_id)->first();
        if($urls==null){
            $url=url::where('url_zz_goods_id',$goods->goods_id)->first();
            $url=isset($url['url_url'])?$url['url_url']:'#';
        }else{
            $url=$urls->url_url;
        }
        if($url==null){
            return false;
        }
        if($goods->goods_blade_type == 2){
            return view('home.zhongdong.zdEndSuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);            
        }
        if($goods->goods_blade_type == 3){
            return view('home.MaLaiXiYa.mlxyEndSuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);            
        }
        return view('ajax.endsuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);
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
            if($goods_blade_type == 2){
                return view('home.zhongdong.zhSend');                
            }
        }
        return view('home.send');
    }

    public function getsendmsg(Request $request){
        $order=\App\order::where('order_single_id',$request->input('msg'))->first();
        if($order==null||$order==false){
            /*dd($order);*/
            return json_encode(false);
        }
        $goods=\App\goods::where('goods_id',$order->order_goods_id)->first();
        if($goods==null||$goods==null){
            return json_encode(false);
        }
        if($goods->goods_blade_type == 2){
            return view('home.zhongdong.zdSendmsg')->with(compact('order','goods'));
        }
        return view('home.sendmsg')->with(compact('order','goods'));
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
    $vis->vis_from=$from;
    $vis->vis_from=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:null;
    $vis->save();
   }
   public function settime(Request $request){
        if($request->input('id')==0){
            return response('test',200);
        }
        $data=json_decode($request->input('data'));
        $id=$request->input('id');
        $vis=\App\vis::where('vis_id',$id)->first();
        
        $time=time()-strtotime(($vis->vis_time));
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
    $vis=\App\vis::where('vis_id',$id)->first();
    $time=$request->input('date');
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
    $vis=\App\vis::where('vis_id',$request->input('id'))->first();
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
}
