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
        
    	$goods_id=url::get_goods();
       /* $arr=getclientcity($request);
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
        $vis->save();*/
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
    	return view('home.index')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao'));
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
    	return response()->json(array('status'=> $ans), 200);
    }
    public function pay(Request $request){
    	$goods_id=url::get_goods();
    	$goods=goods::where('goods_id',$goods_id)->first();
    	$img=img::where('img_goods_id',$goods_id)->first();
    	$cuxiao=cuxiao::where('cuxiao_goods_id',$goods_id)->first();
    	return view('home.buy')->with(compact('goods','img','cuxiao'));
    }
    public function gethtml(Request $request){
    	 $goods_id=$request->input('id');
    	 $goods=goods::where('goods_id',$goods_id)->first();
    	 $cuxiaoSDK=new cuxiaoSDK($goods);
    	 $htmlstr=$cuxiaoSDK->getdiv();
    	 return $htmlstr;
    }
    public function saveform(Request $request){
    	$ip=$request->getClientIp();
    	$order=new order();
    	$order->order_single_id='NR'.makeSingleOrder();
    	$order->order_ip=$ip;
    	$order->order_time=date('Y-m-d H:i:s',time());
    	$order_goods_id=url::get_goods();
    	if($order_goods_id==false){
          return response('error',200);
    	}
    	$order->order_goods_id=$order_goods_id;
    	$goods=goods::where('goods_id',$order_goods_id)->first();
    	$url=url::where('url_goods_id',$goods->goods_id)->first()->url_url;
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
    	if(!$msg){
    		return view('ajax.endfail')->with(['order'=>$order,'url'=>$url]);
    	}else{
    		return view('ajax.endsuccess')->with(['order'=>$order,'url'=>$url]);
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
}
