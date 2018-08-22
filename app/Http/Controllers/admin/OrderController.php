<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\order;
use DB;
use Illuminate\Support\Facades\Auth;
class OrderController extends Controller
{
   public function index(){
         $admin_id=Auth::user()->admin_id;
     if(Auth::user()->is_root!='1'){
      $admins=[];
      $garr=[];
      $goodsarr=\App\goods::where("goods_admin_id",'=',$admin_id)->get(['goods_id'])->toArray();
      foreach($goodsarr as $key => $v){
        $garr[]=$v['goods_id'];
      }
      $counts=DB::table('order')
      ->whereIn('order_goods_id',$garr)
      ->count();
     return view('admin.order.index')->with(compact('counts','admins'));
     }else{
      $admins=\App\admin::get(); 
      $counts=order::count();
     return view('admin.order.index')->with(compact('counts','admins'));
     }
    
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
	        $counts=DB::table('order')
	        ->count();
            if(@strtotime(explode(';',$search)[0])>100&&@strtotime(explode(';',$search)[1])>100){
            $timesearch=$search;
            $search='';
            $newlen=$len;
            $len=$counts;
           }
           
         //获取自己名下的单
           $admin_id=Auth::user()->admin_id;
           if(Auth::user()->is_root!='1'){

            $garr=[];
            $goodsarr=\App\goods::where("goods_admin_id",'=',$admin_id)->get(['goods_id'])->toArray();
            foreach($goodsarr as $key => $v){
              $garr[]=$v['goods_id'];
            }
            $counts=DB::table('order')
            ->whereIn('order_goods_id',$garr)
            ->count();
             $newcount=DB::table('order')
            ->select('order.*','goods.goods_real_name','cuxiao.cuxiao_msg','admin.admin_name')
            ->leftjoin('goods','order.order_goods_id','=','goods.goods_id')
            ->leftjoin('cuxiao','order.order_cuxiao_id','=','cuxiao.cuxiao_id')
            ->leftjoin('admin','order.order_admin_id','=','admin.admin_id')
            ->where(function($query)use($search){
                $query->where([['order.order_single_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_ip','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['goods.goods_real_name','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['cuxiao.cuxiao_msg','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_send','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['admin.admin_name','like',"%$search%"],['order.is_del','=','0']]);
            })
            ->where(function($query)use($garr){
              $query->whereIn('order_goods_id',$garr);
            })
            ->count();
            $data=DB::table('order')
            ->select('order.*','goods.goods_real_name','cuxiao.cuxiao_msg','admin.admin_name')
            ->leftjoin('goods','order.order_goods_id','=','goods.goods_id')
            ->leftjoin('cuxiao','order.order_cuxiao_id','=','cuxiao.cuxiao_id')
            ->leftjoin('admin','order.order_admin_id','=','admin.admin_id')
            ->where(function($query)use($search){
                $query->where([['order.order_single_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_ip','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['goods.goods_real_name','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['cuxiao.cuxiao_msg','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_send','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['admin.admin_name','like',"%$search%"],['order.is_del','=','0']]);
            })
            ->where(function($query)use($garr){
              $query->whereIn('order_goods_id',$garr);
            })
            ->orderBy($order,$dsc)
            ->offset($start)
            ->limit($len)
            ->get();
           }else{
            //获取账户名
           $goods_search=$request->has('goods_search')?$request->input('goods_search'):0;
            /*$wheresql=['order_goods_id','>',0];*/
            $newcount=DB::table('order')
            ->select('order.*','goods.goods_real_name','cuxiao.cuxiao_msg','admin.admin_name')
            ->leftjoin('goods','order.order_goods_id','=','goods.goods_id')
            ->leftjoin('cuxiao','order.order_cuxiao_id','=','cuxiao.cuxiao_id')
            ->leftjoin('admin','order.order_admin_id','=','admin.admin_id')
            ->where(function($query)use($search){
                $query->where([['order.order_single_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_ip','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['goods.goods_real_name','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['cuxiao.cuxiao_msg','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_send','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['admin.admin_name','like',"%$search%"],['order.is_del','=','0']]);
            })
            ->where(function($query)use($goods_search){
              if($goods_search!=0){
                $garr=[];
              $goodsarr=\App\goods::where("goods_admin_id",'=',$goods_search)->get(['goods_id'])->toArray();
              foreach($goodsarr as $key => $v){
                $garr[]=$v['goods_id'];
              }
                $query->whereIn('order_goods_id',$garr);
              }
            })
            ->count();
            $data=DB::table('order')
            ->select('order.*','goods.goods_real_name','cuxiao.cuxiao_msg','admin.admin_name')
            ->leftjoin('goods','order.order_goods_id','=','goods.goods_id')
            ->leftjoin('cuxiao','order.order_cuxiao_id','=','cuxiao.cuxiao_id')
            ->leftjoin('admin','order.order_admin_id','=','admin.admin_id')
           ->where(function($query)use($search){
                $query->where([['order.order_single_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_ip','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['goods.goods_real_name','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['cuxiao.cuxiao_msg','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_send','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['admin.admin_name','like',"%$search%"],['order.is_del','=','0']]);
            })
           ->where(function($query)use($goods_search){
            if($goods_search!=0){
              $garr=[];
              $goodsarr=\App\goods::where("goods_admin_id",'=',$goods_search)->get(['goods_id'])->toArray();
              foreach($goodsarr as $key => $v){
                $garr[]=$v['goods_id'];
              }
              $query->whereIn('order_goods_id',$garr);
            }
           })
            ->orderBy($order,$dsc)
            ->offset($start)
            ->limit($len)
            ->get();
           }
	        
        
           //按照时间区间查找数据
            if(isset($timesearch)){
               if((strtotime(explode(';',$timesearch)[0])>100&&strtotime(explode(';',$timesearch)[1])>100)||strtotime($timesearch)>100){
               $newcount=0;
               $dataarr=[];
               /*$msg=[];*/
               foreach($data as $k=> $v){/*dd(explode(';',$timesearch),$v->order_time);dd(strtotime($v->order_time),strtotime(explode(';',$timesearch)[1]),strtotime(explode(';',$timesearch)[0]));*/
            /* $msg[$k]['name']=$v->vis_ip;
               $msg[$k]['end']=(strtotime($v->order_time)>=strtotime(explode(';',$timesearch)[0])&&strtotime($v->order_time)<=strtotime(explode(';',$timesearch)[1]))||strtotime($v->order_time)==strtotime($timesearch);
               $msg[$k]['time']=(strtotime($v->order_time));
               $msg[$k]['aes']=strtotime(explode(';',$timesearch)[0]).'-'.strtotime(explode(';',$timesearch)[1]);*/
                  if((strtotime($v->order_time)>=strtotime(explode(';',$timesearch)[0])&&strtotime($v->order_time)<=strtotime(explode(';',$timesearch)[1]))||strtotime($v->order_time)==strtotime($timesearch)){
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
   public function orderinfo(Request $request){
      $id=$request->input('id');
      $msg=order::where('order_id',$id)->first();
      $html=$msg->order_return;
      return $html;
   }
   public function heshen(Request $request){
      $id=$request->input('id');
      $order=order::where('order_id',$id)->first();
      $goods=\App\goods::where('goods_id',$order->order_goods_id)->first();
      return view('admin/order/heshen')->with(compact('order','goods'));
   }
   public function order_type_change(Request $request){
   	  $data=$request->all();
   	  $order=order::where('order_id',$data['id'])->first();
   	  $oldmsg=$order->order_return;
   	  $date=date('Y-m-d h:i:s',time());
   	  $admin=Auth::user()->admin_name;
   	  $htmlnow=$oldmsg."<p style='text-align:center'>[".$date."] ".$admin."：".$data['order_return']."</p>";
   	  $order->order_type=$data['order_type_now'];
   	  $order->order_return= $htmlnow;
   	  $order->order_send=$data['order_send'];
   	  $order->order_return_time=$date;
        $order->order_admin_id=Auth::user()->admin_id;
   	  $msg=$order->save();
   	  if($msg){
   	  	    $arr=['msg'=>0];
	        return response()->json($arr);
   	  }else{
   	  		$arr=['msg'=>'err'];
	        return response()->json($arr);
   	  }
   }
   public function delorder(Request $request){
   	     $order=order::where('order_id',$request->input('id'))->first();
         $order->is_del='1';
         if($order->save()){
	   	    	return response()->json(['err'=>1,'str'=>'删除成功']);
         }else{
	   	    	return response()->json(['err'=>0,'str'=>'删除失败']);
         }
   }
   public function getaddr(Request $request){
   	     $id=$request->input('id');
   	     $order=order::where('order_id',$id)->first();
         return view('admin.order.addr')->with(compact('order'));
   	     
   }
   public function outorder(){
      $data=order::select('order.order_id','order.order_single_id','order.order_ip','goods.goods_real_name','cuxiao.cuxiao_msg','order.order_price','order.order_type','order.order_return','order.order_time','order.order_return_time','admin.admin_name','order.order_num','order.order_send')
           ->leftjoin('goods','order.order_goods_id','=','goods.goods_id')
           ->leftjoin('cuxiao','order.order_cuxiao_id','=','cuxiao.cuxiao_id')
           ->leftjoin('admin','order.order_admin_id','=','admin.admin_id')
           ->where(function($query){
            if(Auth::user()->is_root!='1'){
              $goods=\App\goods::get_ownid(Auth::user()->admin_id);
              $query->whereIn('goods_admin_id', $goods);
            }
           })
           ->orderBy('order.order_time','desc')
           ->get()->toArray();
           foreach($data as $k => $v){
            switch ($v['order_type']) {
               case '0':
                 $data[$k]['order_type']='<span class="label label-success radius" style="color:#ccc;">未核审</span>';
                  break;
               case '1':
                 $data[$k]['order_type']='<span class="label label-default radius" style="color:green;">核审通过</span>';
                 break;
               case '2':
                 $data[$k]['order_type']=' <span class="label label-default radius" style="color:red;">核审驳回</span>';
                 break;
               case '3':
                 $data[$k]['order_type']=' <span class="label label-default radius" style="color:brown;">已发货</span>';
                 break;
               case '4':
                 $data[$k]['order_type']=' <span class="label label-default radius" style="color:#6699ff;">已签收</span>';
                 break;
               case '5':
                 $data[$k]['order_type']=' <span class="label label-default radius" style="color:#red;">退货未退款</span>';
                 break;
               case '6':
                 $data[$k]['order_type']=' <span class="label label-default radius" style="color:#red;">退货并已退款</span>';
                 break;
               case '7':
                 $data[$k]['order_type']=' <span class="label label-default radius" style="color:#red;">未退货并已退款</span>';
                 break;
               case '8':
                 $data[$k]['order_type']=' <span class="label label-default radius" style="color:#red;">拒签</span>';
                 break;
               default:
                  $data[$k]['order_type']=' <span class="label label-default radius" style="color:red;">数据错误！</span>';
                  break;
            }
           }
         $filename='订单记录'.date('Y-m-d h:i:s',time()).'.xls';
         $zdname=['订单id','订单编号','下单者ip','单品名','促销信息','订单价格','订单类型','反馈信息','下单时间','反馈时间','核审人员','商品件数','快递单号'];
        out_excil($data,$zdname,'单品信息记录表',$filename);
   }
}
