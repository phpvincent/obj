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
      $admins=\App\admin::get_group($admin_id);
      $garr=order::get_group_order($admin_id);
      $counts=DB::table('order')
      ->where(function($query){
        $query->where('is_del','0');
      })
      ->whereIn('order_goods_id',$garr)
      ->count();
     return view('admin.order.index')->with(compact('counts','admins'));
     }else{
      $admins=\App\admin::get(); 
      $counts=order::where(function($query){
        $query->where('is_del','0');
      })->count();
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
          ->where(function($query){
            $query->where('is_del','0');
          })
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
            $garr=\App\goods::get_ownid($admin_id);
            $counts=DB::table('order')
            ->whereIn('order_goods_id',$garr)
            ->where(function($query){
              $query->where('is_del','0');
            })
            ->count();
             $newcount=DB::table('order')
            ->select('order.*','goods.goods_real_name','admin.admin_name')
            ->leftjoin('goods','order.order_goods_id','=','goods.goods_id')
            ->leftjoin('admin','order.order_admin_id','=','admin.admin_id')
            ->where(function($query)use($search){
                $query->where([['order.order_single_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_ip','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['goods.goods_real_name','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_cuxiao_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_send','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['admin.admin_name','like',"%$search%"],['order.is_del','=','0']]);
            })
            ->where(function($query)use($garr){
              $query->whereIn('order_goods_id',$garr);
            })
            ->count();
            $data=DB::table('order')
            ->select('order.*','goods.goods_real_name','admin.admin_name')
            ->leftjoin('goods','order.order_goods_id','=','goods.goods_id')
            ->leftjoin('admin','order.order_admin_id','=','admin.admin_id')
            ->where(function($query)use($search){
                $query->where([['order.order_single_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_ip','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['goods.goods_real_name','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_cuxiao_id','like',"%$search%"],['order.is_del','=','0']]);
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
            ->select('order.*','goods.goods_real_name','admin.admin_name')
            ->leftjoin('goods','order.order_goods_id','=','goods.goods_id')
            ->leftjoin('admin','order.order_admin_id','=','admin.admin_id')
            ->where(function($query)use($search){
                $query->where([['order.order_single_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_ip','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['goods.goods_real_name','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_cuxiao_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_send','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['admin.admin_name','like',"%$search%"],['order.is_del','=','0']]);
            })
            ->where(function($query)use($goods_search){
                if($goods_search!=0){
                   $garr=order::get_group_order($goods_search);
                $query->whereIn('order_goods_id',$garr);
                }
            })
            ->count();
            $data=DB::table('order')
            ->select('order.*','goods.goods_real_name','admin.admin_name')
            ->leftjoin('goods','order.order_goods_id','=','goods.goods_id')
            ->leftjoin('admin','order.order_admin_id','=','admin.admin_id')
           ->where(function($query)use($search){
                $query->where([['order.order_single_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_ip','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['goods.goods_real_name','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_cuxiao_id','like',"%$search%"],['order.is_del','=','0']]);
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
           //商品附带规格信息
	        foreach($data as $k => &$v){
	        $goods_currency_id= \App\goods::where('goods_id',$v->order_goods_id)->value('goods_currency_id');
	        $currency_type_name = \App\currency_type::where('currency_type_id',$goods_currency_id)->value('currency_type_name');
	        $v->order_price = $currency_type_name.' '.$v->order_price;
            $order_config=\App\order_config::where('order_primary_id',$v->order_id)->get();
            if($order_config->count()>0){
                $config_msg='';
                $i=0;
                foreach($order_config  as  $va){
                  $i++;
                  $config_msg.="第".$i."件：";
                  $orderarr=explode(',',$va['order_config']);
                  foreach($orderarr as $key => $val){
                    $conmsg=\App\config_val::where('config_val_id',$val)->first();
                    $config_msg.=$conmsg['config_val_msg'].'-';
                  }
                  $config_msg=rtrim($config_msg,'-');
                  $config_msg.='<br/>';
                }
                  $config_msg=rtrim($config_msg,'<br/>');
                  $data[$k]->config_msg=$config_msg;
              }else{
                $data[$k]->config_msg="暂无属性信息";
              }
          }
           //按照时间区间查找数据
            if(isset($timesearch)){
               if((strtotime(explode(';',$timesearch)[0])>100&&strtotime(explode(';',$timesearch)[1])>100)||strtotime($timesearch)>100){
               $newcount=0;
               $dataarr=[];
               /*$msg=[];*/
               foreach($data as $k=> $v){
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
    //获取订单信息
      $id=$request->input('id');
      $msg=order::where('order_id',$id)->first();
      $html=$msg->order_return;
      return $html;
   }
   public function heshen(Request $request){
    if($request->has('type')&&$request->input('type')=='all'){
      $id=explode(',',$request->input('id'));
      $orders=order::whereIn('order_id',$id)->get();
      $send_nums='';
      foreach($orders as $k => $v){
        if($v->order_send!=null&&$v->order_send!=''){
                  $send_nums.=$v->order_send.';';
        }else{
          $send_nums.='暂无;';
        }
      }
      $send_nums=rtrim($send_nums,';');
      return view('admin/order/heshenarr')->with(compact('orders','send_nums'));
    }else{
       //获取订单核审页面
      $id=$request->input('id');
      $order=order::where('order_id',$id)->first();
      $goods=\App\goods::where('goods_id',$order->order_goods_id)->first();
      return view('admin/order/heshen')->with(compact('order','goods'));
    }
   }
   public function order_arr_change(Request $request){
    //订单批量核审
     $data=$request->all();
     $msg=false;
     foreach ($data['order_ids'] as $key => $val) {
      $order=order::where('order_single_id',$val)->first();
       if($request->has('order_send')&&$request->input('order_send')!=null){ 
        if(count(explode(';', $data['order_send']))!=count($data['order_ids'])){
          //检查快递单号数目是否有错
            return response()->json(['err'=>0,'str'=>'快递单号数目错误']);
        }
        $admin=Auth::user()->admin_name;
        $date=date('Y-m-d h:i:s',time());
        $oldmsg=$order->order_return;
        $order_send_now=explode(';',$data['order_send'])[$key];
        if($order_send_now=='暂无'){
          $order_send_now=null;
        }
        $err=order::where('order_single_id',$val)->update(['order_type'=>$data['order_type_now'],'order_send'=>$order_send_now,'order_return'=>$oldmsg."<p style='text-align:center'>[".$date."] ".$admin."：".$data['order_return']."</p>",'order_return_time'=>$date,'order_admin_id'=>Auth::user()->admin_id]);
        if($err===false){
          $msg.=$val.',';
        }
       }else{
        $admin=Auth::user()->admin_name;
        $date=date('Y-m-d h:i:s',time());
        $oldmsg=$order->order_return;
        $err=order::where('order_single_id',$val)->update(['order_type'=>$data['order_type_now'],'order_return'=>$oldmsg."<p style='text-align:center'>[".$date."] ".$admin."：".$data['order_return']."</p>",'order_return_time'=>$date,'order_admin_id'=>Auth::user()->admin_id]);
        if($err===false){
          $msg.=$val.',';
        }
       }
     }
     if($msg!==false){
            return response()->json(['err'=>0,'str'=>rtrim($err,',').'号订单核审失败']);
          }else{
            return response()->json(['err'=>1,'str'=>'核审成功']);
          }
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
         if($request->has('type')&&$request->input('type')=='all'){
          $ids=$request->input('id');
          $err=null;
           foreach($ids as $k => $v){
            if($v==null){break;}
            $msg=order::where('order_id',$v)->update(['is_del'=>'1']);
            if(!$msg){
              $err.=$v.',';
            }
           }
           if($err!=null){
            return response()->json(['err'=>0,'str'=>rtrim($err,',').'号订单删除失败']);
           }else{
            return response()->json(['err'=>1,'str'=>'删除成功']);
           }
         }
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
   public function outorder(Request $request){
      $data=order::select('order.order_id','order.order_single_id','order.order_ip','goods.goods_real_name','cuxiao.cuxiao_msg','order.order_price','order.order_type','order.order_return','order.order_time','order.order_return_time','admin.admin_name','order.order_num','order.order_send','goods.goods_price','order.order_name','order.order_state','order.order_city','order.order_add','order.order_remark','order.order_tel')
           ->leftjoin('goods','order.order_goods_id','=','goods.goods_id')
           ->leftjoin('cuxiao','order.order_cuxiao_id','=','cuxiao.cuxiao_id')
           ->leftjoin('admin','order.order_admin_id','=','admin.admin_id')
           ->where(function($query){
            if(Auth::user()->is_root!='1'){
              $goods=\App\goods::get_ownid(Auth::user()->admin_id);
              $query->whereIn('goods_admin_id', $goods);
            }
           })
           ->where(function($query){
            $query->where('order.is_del','0');
           })
           ->where(function($query){
            $query->where('order.order_type','1');
           })
           ->where(function($query)use($request){
              if($request->has('min')&&$request->has('max')){
                $query->whereBetween('order.order_time',[$request->input('min'),$request->input('max')]);
              }
           })
           ->orderBy('order.order_time','desc')
           ->get()->toArray();
          $exdata=[];
           foreach($data as $k => $v){
            $exdata[$k]['order_time']=$v['order_time'];
            $exdata[$k]['goods_real_name']=$v['goods_real_name'];
            //尺寸信息
             $order_config=\App\order_config::where('order_primary_id',$v['order_id'])->get();
            if($order_config->count()>0){ 
                $config_msg='';
                $i=0;
                foreach($order_config  as  $va){
                  $i++;
                  $config_msg.="第".$i."件：";
                  $orderarr=explode(',',$va['order_config']);
                  foreach($orderarr as $key => $val){
                    $conmsg=\App\config_val::where('config_val_id',$val)->first();
                    $config_msg.=$conmsg['config_val_msg'].'-';
                  }
                  $config_msg=rtrim($config_msg,'-');
                  $config_msg.='<br/>';
                }
                  $config_msg=rtrim($config_msg,'<br/>');
                  $exdata[$k]['config_msg']=$config_msg;
              }else{
                $exdata[$k]['config_msg']="暂无属性信息";
              }
              $exdata[$k]['order_num']=$v['order_num'];
              $exdata[$k]['payof']='TWD';
              $exdata[$k]['goods_price']=$v['goods_price'];
              $exdata[$k]['order_price']=$v['order_price'];
              $exdata[$k]['name']=$v['order_name'];
              $exdata[$k]['tel']=$v['order_tel'];
              $exdata[$k]['area']=$v['order_state'].$v['order_city'].'('.$v['order_add'].')';
              $exdata[$k]['remark']=$v['order_remark'];
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
         $zdname=['下单时间','产品名称','型号/尺寸/颜色','数量','币种','销售单价','总金额','客户名字','客户电话','邮寄地址','备注'];
        out_excil($exdata,$zdname,'訂單信息记录表',$filename);
   }
}
