<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use Log;
use App\goods;
use App\url;
use App\channel\cuxiaoSDK;
class GoodsController extends Controller
{
   public function index(){
   	  $counts=goods::count();
   	  return view('admin.goods.index')->with('counts',$counts);
   }
   public function get_table(Request $request){
   	$info=$request->all();
        	$cm=$info['order'][0]['column'];
	        $dsc=$info['order'][0]['dir'];
	        $order=$info['columns']["$cm"]['data'];
	        $draw=$info['draw'];
	        $start=$info['start'];
	        $len=$info['length'];
	        $search=trim($info['search']['value']);
	        $counts=DB::table('goods')
	        ->count();
	         if(strtotime(explode(';',$search)[0])>100&&strtotime(explode(';',$search)[1])>100){
            $timesearch=$search;
            $search='';
            $newlen=$len;
            $len=$counts;
           }
	        $newcount=DB::table('goods')
	        ->select('goods.*','url.url_url','url.url_type','admin.admin_name')
	        ->leftjoin('url','goods.goods_id','=','url.url_goods_id')
	        ->leftjoin('admin','goods.goods_admin_id','=','admin.admin_id')
	        ->where([['goods.goods_name','like',"%$search%"],['goods.is_del','=','0']])
	        ->orWhere([['goods.goods_real_name','like',"%$search%"],['goods.is_del','=','0']])
	        ->orWhere([['goods.goods_msg','like',"%$search%"],['goods.is_del','=','0']])
	        ->orWhere([['url.url_url','like',"%$search%"],['goods.is_del','=','0']])
	        ->orWhere([['admin.admin_name','like',"%$search%"],['goods.is_del','=','0']])
	        ->count();
	        $data=DB::table('goods')
	        ->select('goods.*','url.url_url','url.url_type','admin.admin_name')
	        ->leftjoin('url','goods.goods_id','=','url.url_goods_id')
	        ->leftjoin('admin','goods.goods_admin_id','=','admin.admin_id')
	        ->where([['goods.goods_name','like',"%$search%"],['goods.is_del','=','0']])
	        ->orWhere([['goods.goods_real_name','like',"%$search%"],['goods.is_del','=','0']])
	        ->orWhere([['goods.goods_msg','like',"%$search%"],['goods.is_del','=','0']])
	        ->orWhere([['url.url_url','like',"%$search%"],['goods.is_del','=','0']])
	        ->orWhere([['admin.admin_name','like',"%$search%"],['goods.is_del','=','0']])
	        ->orderBy($order,$dsc)
	        ->offset($start)
	        ->limit($len)
	        ->get();
	          if(isset($timesearch)){
               if((strtotime(explode(';',$timesearch)[0])>100&&strtotime(explode(';',$timesearch)[1])>100)||strtotime($timesearch)>100){
               $newcount=0;
               $dataarr=[];
               /*$msg=[];*/
               foreach($data as $k=> $v){/*dd(explode(';',$timesearch),$v->goods_up_time);dd(strtotime($v->goods_up_time),strtotime(explode(';',$timesearch)[1]),strtotime(explode(';',$timesearch)[0]));*/
            /* $msg[$k]['name']=$v->vis_ip;
               $msg[$k]['end']=(strtotime($v->goods_up_time)>=strtotime(explode(';',$timesearch)[0])&&strtotime($v->goods_up_time)<=strtotime(explode(';',$timesearch)[1]))||strtotime($v->goods_up_time)==strtotime($timesearch);
               $msg[$k]['time']=(strtotime($v->goods_up_time));
               $msg[$k]['aes']=strtotime(explode(';',$timesearch)[0]).'-'.strtotime(explode(';',$timesearch)[1]);*/
                  if((strtotime($v->goods_up_time)>=strtotime(explode(';',$timesearch)[0])&&strtotime($v->goods_up_time)<=strtotime(explode(';',$timesearch)[1]))||strtotime($v->goods_up_time)==strtotime($timesearch)){
                     $newcount+=1;
                     $dataarr[]=$v;
                     }
               }
               $arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>array_slice($dataarr,$start,$newlen)];
                   return response()->json($arr);
               }
           }
	        $arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>$data];
	        return response()->json($arr);
   }
   public function delgoods(Request $request){
         $goods=goods::where('goods_id',$request->input('id'))->first();
         $goods->is_del='1';
         if($goods->save()){
	   	    	return response()->json(['err'=>1,'str'=>'删除成功']);
         }else{
	   	    	return response()->json(['err'=>0,'str'=>'删除失败']);
         }
   }
   public function online(Request $request){
         $url=url::where('url_goods_id',$request->input('id'))->first();
         $url->url_type='1';
         if($url->save()){
	   	    	return response()->json(['err'=>1,'str'=>'启动成功']);
         }else{
	   	    	return response()->json(['err'=>0,'str'=>'启动失败']);
         }
   }
   public function close(Request $request){
         $url=url::where('url_goods_id',$request->input('id'))->first();
         $url->url_type='0';
         if($url->save()){
	   	    	return response()->json(['err'=>1,'str'=>'下线成功']);
         }else{
	   	    	return response()->json(['err'=>0,'str'=>'下线失败']);
         }
   }
   public function outgoods(Request $request){
   		$data=goods::select('goods.goods_id','goods.goods_name','goods.goods_msg','goods.goods_video','goods.goods_real_price','goods.goods_price','goods.goods_num','goods.goods_end','goods.goods_comment_num','goods.goods_real_name','goods.goods_cuxiao_name','admin.admin_name','goods_online_time')
	        ->leftjoin('url','goods.goods_id','=','url.url_goods_id')
	        ->leftjoin('admin','goods.goods_admin_id','=','admin.admin_id')
	        ->where('goods.is_del','0')
			->orderBy('goods.goods_up_time','desc')
			->get()->toArray();
   		$filename='商品信息'.date('Y-m-d h:i:s',time()).'.xls';
   		$zdname=['商品id','商品名','商品描述','商品视频地址','商品单价','商品现价','商品库存','倒计时','评论数','单品名','促销信息','所属人员','发布时间'];
        out_excil($data,$zdname,'单品信息记录表',$filename);
   }
   public function chgoods(Request $request){
   	 	$id=$request->input('id');
   	 	$goods=goods::where('goods_id',$id)->first();
   	 	$cxSDK=new cuxiaoSDK($goods);
   	 	$cuxiao_html=$cxSDK->get_uphtml();
   	 	return view('admin.goods.update')->with(compact('goods','cuxiao_html'));
   }
}
/*	$dataResult = array();      //todo:导出数据（自行设置） 

$headTitle = "XX保险公司 优惠券赠送记录"; 

$title = "优惠券记录"; 

$headtitle= "<tr style='height:50px;border-style:none;><th border=\"0\" style='height:60px;width:270px;font-size:22px;' colspan='11' >{$headTitle}</th></tr>"; 

$titlename = "<tr> 

               <th style='width:70px;' >合作商户</th> 

               <th style='width:70px;' >会员卡号</th> 

               <th style='width:70px;'>车主姓名</th> 

               <th style='width:150px;'>手机号</th> 

               <th style='width:70px;'>车牌号</th> 

               <th style='width:100px;'>优惠券类型</th> 

               <th style='width:70px;'>优惠券名称</th> 

               <th style='width:70px;'>优惠券面值</th> 

               <th style='width:70px;'>优惠券数量</th> 

               <th style='width:70px;'>赠送时间</th> 

               <th style='width:90px;'>截至有效期</th> 

           </tr>"; 

           $filename = $title.".xls"; 

       $this->excelData($dataResult,$titlename,$headtitle,$filename); */

