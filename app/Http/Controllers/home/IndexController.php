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
use App\channel\cuxiaoSDK;
class IndexController extends Controller
{
    public function index(Request $request){
/*       dd(getclientcity($request));*/
    	//获取该域名对应商品id
        
    	$goods_id=url::get_goods($request);
    	$imgs=img::where('img_goods_id',$goods_id)->get(['img_url']);
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
        //dd($comment);
    	$des_img=des::where('des_goods_id',$goods_id)->get();
    	$par_img=par::where('par_goods_id',$goods_id)->get();
    	$cuxiao=cuxiao::where('cuxiao_goods_id',$goods_id)->first();
    	//获取倒计时计算为秒数
        $timer=$goods->goods_end;
        $parsed = date_parse($timer);
        $goods->goods_end=$parsed['hour'] * 3600+$parsed['minute'] * 60+$parsed['second'];
        //模板渲染
        $blade_type=$goods->goods_blade_type;
        switch ($blade_type) {
            case '0':
            return view('home.index')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao'));
                break;
            case '1':
            return view('home.index1')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao'));
                break;
            case '2':
            return view('home.index2')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao'));
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
    public function pay(Request $request){
        //下单界面
    	$goods_id=url::get_goods($request);
    	$goods=goods::where('goods_id',$goods_id)->first();
    	$img=img::where('img_goods_id',$goods_id)->first();
    	$cuxiao=cuxiao::where('cuxiao_goods_id',$goods_id)->first();
        $goods_config=\DB::table('goods_config')
        ->select('goods_config.goods_config_type','goods_config.goods_config_id','goods_config.goods_config_msg','config_val.config_val_msg','config_val.config_val_img','config_val.config_val_id','config_val.config_type_id')
        ->leftjoin('config_val','goods_config.goods_config_id','config_val.config_type_id')
        ->where('goods_config.goods_primary_id',$goods_id)
        ->get();
       
        $goods_config_arr=[];
        foreach($goods_config as $k => $v){
            $goods_config_arr[$v->goods_config_id][]=$v;
        } /*dd($goods_config_arr);*/
       /* $goods_config_arr=(string )json_encode($goods_config_arr);*/
    	return view('home.buy')->with(compact('goods','img','cuxiao','goods_config_arr'));
    }
    public function gethtml(Request $request){
    	 $goods_id=$request->input('id');
    	 $goods=goods::where('goods_id',$goods_id)->first();
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
        $order->order_num=$order_num;
         $order->order_remark=$request->input('notes');
        $order->order_name=$request->input('firstname');
        $order->order_tel=$request->input('telephone');
        /*$order->order_state=$request->input('state');*/
        $order->order_city=$request->input('city');
        $order->order_add=$request->input('address1');
        $order->order_email=$request->input('email');
        $msg=$order->save();
        if($msg){
                    return response()->json(['err'=>1,'str'=>'展示成功']);
        }else{
                    return response()->json(['err'=>0,'str'=>'展示失败']);
        }
    }
    public function saveform(Request $request){
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
        $goods=goods::where('goods_id',$order_goods_id)->first();
        // dd($goods);
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
    		return view('ajax.endfail')->with(['order'=>$order,'url'=>$url]);
    	}
    	$order->order_price=$price;
    	$order_num=$request->input('specNumber');
    	//判断商品数合法性
    	if($order_num<=0){
    		return view('ajax.endfail')->with(['order'=>$order,'url'=>$url]);
    	}
    	$order->order_num=$order_num;
    	$order->order_cuxiao_id=$request->input('cuxiao_id');
        $order->order_remark=$request->input('notes');
        $order->order_name=$request->input('firstname');
        $order->order_tel=$request->input('telephone');
        $order->order_state=$request->input('state');
        $order->order_city=$request->input('city');
        $order->order_add=$request->input('address1');
        $order->order_email=$request->input('email');
    	$msg=$order->save();
        
        if($request->has('goods_config')){
         $order_id=$order->order_id;
         $order_config=new \App\order_config;
         $ostr='';
         foreach($request->input('goods_config') as $v){
            $ostr.=$v[0].',';
         }
         $ostr= rtrim($ostr,',');
         $order_config->order_config=$ostr;
         $order_config->order_primary_id=$order_id;
         $order_config->save();
        }
    	if(!$msg){
    		return view('ajax.endfail')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);
    	}else{
    		return view('ajax.endsuccess')->with(['order'=>$order,'url'=>$url,'goods'=>$goods]);
    	}
    }
    public function send(){
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
        return view('home.sendmsg')->with(compact('order','goods'));
    }
    public function channelindex(){
        return view('view.index');
    }
    public function visfrom(Request $request){
    $id=$request->input('id');
    $from=$request->input('from');
    $vis=\App\vis::where('vis_id',$id)->first();
    $vis->vis_from=$from;
    $vis->vis_from=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:null;
    $vis->save();
   }
   public function settime(Request $request){
        $data=json_decode($request->input('data'));
        $id=$request->input('id');
        $vis=\App\vis::where('vis_id',$id)->first();
        
        $time=time()-strtotime(($vis->vis_time));
        if($vis->vis_staytime==null){
                    $vis->vis_staytime=$time;
        }else{
            $vis->vis_staytime=$time;
        }
        $vis->save();
   }
   public function setbuy(Request $request){
    $id=$request->input('id');
    $vis=\App\vis::where('vis_id',$id)->first();
    $time=$request->input('date');
 /*   $data=date('Y-m-d H:i:s',$time);*/
    $vis->vis_staytime=time()-strtotime(($vis->vis_time));
    $vis->vis_buytime=$time;
    $vis->save();
   }
   public function setorder(Request $request){
    $date=$request->input('date');
    $vis=\App\vis::where('vis_id',$request->input('id'))->first();
    $vis->vis_ordertime=$date;
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
