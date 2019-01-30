<?php

namespace App\Http\Controllers\admin;

use App\admin;
use App\goods;
use App\goods_type;
use App\order;
use App\special;
use App\spend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\vis;
use DB;
use Illuminate\Support\Facades\Auth;
class VisController extends Controller
{
    public function index(){
    	$counts=DB::table('vis')
	         ->where(function($query){
//	        	if(Auth::user()->is_root!='1'){
//	        		$query->whereIn('vis_goods_id',\App\goods::get_ownid(Auth::user()->admin_id));
//	        	}
              		$query->whereIn('vis_goods_id',admin::get_goods_id());
              		$query->orWhere('vis.vis_goods_id',0);
             })
	        ->count();
    	return view('admin.vis.index')->with('counts',$counts);
    }
    public function getindex(Request $request){
    		$info=$request->all();
        	$cm=$info['order'][0]['column'];
	        $dsc=$info['order'][0]['dir'];
	        $order=$info['columns']["$cm"]['data'];
	        $draw=$info['draw'];
	        $start=$info['start'];
	        $len=$info['length'];
	        $search=trim($info['search']['value']);
	        $counts=DB::table('vis')
	         ->where(function($query){
//	        	if(Auth::user()->is_root!='1'){
//	        		$query->whereIn('vis_goods_id',\App\goods::get_ownid(Auth::user()->admin_id));
//	        	}
	        		$query->whereIn('vis_goods_id',admin::get_goods_id());
	        		$query->orWhere('vis.vis_goods_id',0);
             })
	        ->count();
	        $newcount=DB::table('vis')
	        ->leftjoin('goods','goods.goods_id','vis.vis_goods_id')
	        ->leftjoin('sites','sites.sites_id','vis.vis_site_id')
	        ->where(function($query)use($search){
	        		 $query->where('goods.goods_name','like',"%$search%");
				        $query->orWhere('vis.vis_ip','like',"%$search%");
				        $query->orWhere('vis.vis_city','like',"%$search%");
				        $query->orWhere('vis.vis_country','like',"%$search%");
				        $query->orWhere('vis.vis_county','like',"%$search%");
				        $query->orWhere('vis.vis_lan','like',"%$search%");
				        $query->orWhere('vis.vis_isp','like',"%$search%");
				        $query->orWhere('vis.vis_region','like',"%$search%");
				        $query->orWhere('vis.vis_type','like',"%$search%");
				        $query->orWhere('vis.vis_url','like',"%$search%");
				        $query->orWhere('goods.goods_real_name','like',"%$search%");
				        $query->orWhere('sites.sites_name','like',"%$search%");
	        })
	        ->where(function($query)use($info){
	        	//ip是否屏蔽
	        	if(isset($info['ispb'])&&$info['ispb']=='1'){
	        		$query->where('vis.vis_isback','1');
	        	}
	        })
	        ->where(function($query)use($request){
	        	if($request->input('mintime')!=null&&$request->input('maxtime')==null){
	        		$query->where('vis.vis_time','>',$request->input('mintime'));
	        	}elseif($request->input('maxtime')!=null&&$request->input('mintime')==null){
	        		$query->where('vis.vis_time','<',$request->input('maxtime'));
	        	}elseif($request->input('maxtime')!=null&&$request->input('mintime')!=null){
	        		 $query->whereBetween('vis.vis_time',[$request->input('mintime'),$request->input('maxtime')]);
	        	}
	        })
	        ->where(function($query)use($request){
	        	//类型筛选
	        	switch($request->input('chvis')){
	        		case '0':
	        			break;
	        		case '1':
	        		$query->where('vis.vis_buytime','>','0');
	        			break;
	        		case '2':
	        		$query->where('vis.vis_ordertime','>','0');
	        			break;
	        		case '3':
	        		$query->where('vis.vis_comtime','>','0');
	        			break;
	        		default:
	        			break;
	        	}
	        })
	        ->where(function($query){
//	        		if(Auth::user()->is_root!='1'){
//	        			$query->whereIn('vis.vis_goods_id',\App\goods::get_ownid(Auth::user()->admin_id));
//	        			}
                $query->whereIn('vis.vis_goods_id',admin::get_goods_id());
                $query->orWhere('vis.vis_goods_id',0);
            })
	        ->count();
	        $data=DB::table('vis')
	        ->select('vis.*','goods.goods_real_name','sites.sites_name')
	        ->leftjoin('goods','goods.goods_id','vis.vis_goods_id')
	        ->leftjoin('sites','sites.sites_id','vis.vis_site_id')
	        ->where(function($query)use($search){
	        	 	 $query->where('goods.goods_name','like',"%$search%");
				        $query->orWhere('vis.vis_ip','like',"%$search%");
				        $query->orWhere('vis.vis_city','like',"%$search%");
				        $query->orWhere('vis.vis_country','like',"%$search%");
				        $query->orWhere('vis.vis_county','like',"%$search%");
				        $query->orWhere('vis.vis_lan','like',"%$search%");
				        $query->orWhere('vis.vis_isp','like',"%$search%");
				        $query->orWhere('vis.vis_region','like',"%$search%");
				        $query->orWhere('vis.vis_type','like',"%$search%");
				        $query->orWhere('vis.vis_url','like',"%$search%");
				        $query->orWhere('goods.goods_real_name','like',"%$search%");
	        })
	        ->where(function($query)use($info){
	        	//ip是否屏蔽
	        	if(isset($info['ispb'])&&$info['ispb']=='1'){
	        		$query->where('vis.vis_isback','1');
	        	}
	        })
	        ->where(function($query)use($request){
	        	if($request->input('mintime')!=null&&$request->input('maxtime')==null){
	        		$query->where('vis.vis_time','>',$request->input('mintime'));
	        	}elseif($request->input('maxtime')!=null&&$request->input('mintime')==null){
	        		$query->where('vis.vis_time','<',$request->input('maxtime'));
	        	}elseif($request->input('maxtime')!=null&&$request->input('mintime')!=null){
	        		 $query->whereBetween('vis.vis_time',[$request->input('mintime'),$request->input('maxtime')]);
	        	}
	        })
	        ->where(function($query)use($request){
	        	switch($request->input('chvis')){
	        		case '0':
	        			break;
	        		case '1':
	        		$query->where('vis.vis_buytime','>','0');
	        			break;
	        		case '2':
	        		$query->where('vis.vis_ordertime','>','0');
	        			break;
	        		case '3':
	        		$query->where('vis.vis_comtime','>','0');
	        			break;
	        		default:
	        			break;
	        	}
	        })
	        ->where(function($query){
//	        		if(Auth::user()->is_root!='1'){
//	        			$query->whereIn('vis.vis_goods_id',\App\goods::get_ownid(Auth::user()->admin_id));
//	        			}
                $query->whereIn('vis.vis_goods_id',admin::get_goods_id());
                $query->orWhere('vis.vis_goods_id',0);
            })
	        ->orderBy($order,$dsc)
	        ->offset($start)
	        ->limit($len)
	        ->get();
	        $arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>$data];
	        return response()->json($arr);
    }
    public function delvis(Request $request){
    	$msg=vis::where('vis_id',$request->input('id'))->delete();
    	if($msg){
	   	    	return response()->json(['err'=>1,'str'=>'删除成功']);
	   	}else{
		   	    	return response()->json(['err'=>0,'str'=>'删除失败']);
	   	}
    }
    public function pbvis(Request $request){
    	$msg=vis::where('vis_id',$request->input('id'))->first();
    	$msg->vis_isback='1';
    	if($msg->save()){
	   	    	return response()->json(['err'=>1,'str'=>'屏蔽成功']);
	   	}else{
		   	    	return response()->json(['err'=>0,'str'=>'屏蔽失败']);
	   	}
    }
    public function backvis(Request $request){
    	$msg=vis::where('vis_id',$request->input('id'))->first();
    	$msg->vis_isback='1';
    	if($msg->save()){
	   	    	return response()->json(['err'=>1,'str'=>'解封成功']);
	   	}else{
		   	    	return response()->json(['err'=>0,'str'=>'解封失败']);
	   	}
    }

    /** 区域屏蔽页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function prea(){
    	$msg=\App\pb::first();
    	$msg->area=explode(';', $msg->pb_ziduan);
    	return view('admin.vis.prea')->with('msg',$msg);
    }

    /** 区域屏蔽
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function chvis(Request $request){
    	if(substr($request->input('msg'),-1)==';'){
    		$inmsg=rtrim($request->input('msg'),';');
    	}else{
    		$inmsg=$request->input('msg');
    	}
       $msg=DB::table('pb')->where('pb_id',1)->update(['pb_ziduan'=>$inmsg]);
        if($msg){
            $ip = $request->getClientIp();
            //加log日志
            operation_log($ip,'修改区域屏蔽,屏蔽区域：'.$inmsg);
	   	    	return response()->json(['err'=>1,'str'=>'修改成功']);
	   	}else{
		   	    return response()->json(['err'=>0,'str'=>'修改失败']);
	   	}
    }
   public function outvis(Request $request){
   	//数据导出
   	$search=$request->input('search');
   		$data=vis::select('vis.vis_id','vis.vis_ip','vis.vis_country','vis.vis_region','vis.vis_city','vis.vis_county','vis.vis_isp','vis.vis_type','vis.vis_time','vis.vis_lan','vis.vis_isback','goods.goods_name','vis.vis_url','vis_from','vis_buytime','vis_ordertime','vis_staytime','vis_comtime')
			   ->leftjoin('goods','goods.goods_id','vis.vis_goods_id')
			   ->where(function($query){
			   	if(Auth::user()->is_root!='1'){
	        			$query->whereIn('vis.vis_goods_id',\App\goods::get_ownid(Auth::user()->admin_id));
	        			}
			   })
			   ->where(function($query)use($request){
	        	if($request->input('mintime')!=null&&$request->input('maxtime')==null){
	        		$query->where('vis.vis_time','>',$request->input('mintime'));
	        	}elseif($request->input('maxtime')!=null&&$request->input('mintime')==null){
	        		$query->where('vis.vis_time','<',$request->input('maxtime'));
	        	}elseif($request->input('maxtime')!=null&&$request->input('mintime')!=null){
	        		 $query->whereBetween('vis.vis_time',[$request->input('mintime'),$request->input('maxtime')]);
	        	}
	        	})
				->where(function($query)use($request){
		        	//类型筛选
		        	switch($request->input('chvis')){
		        		case '0':
		        			break;
		        		case '1':
		        		$query->where('vis.vis_buytime','>','0');
		        			break;
		        		case '2':
		        		$query->where('vis.vis_ordertime','>','0');
		        			break;
		        		case '3':
		        		$query->where('vis.vis_comtime','>','0');
		        			break;
		        		default:
		        			break;
		        	}
		        })
		        ->where(function($query)use($search){
	        	 	 $query->where('goods.goods_name','like',"%$search%");
				        $query->orWhere('vis.vis_ip','like',"%$search%");
				        $query->orWhere('vis.vis_city','like',"%$search%");
				        $query->orWhere('vis.vis_country','like',"%$search%");
				        $query->orWhere('vis.vis_county','like',"%$search%");
				        $query->orWhere('vis.vis_lan','like',"%$search%");
				        $query->orWhere('vis.vis_isp','like',"%$search%");
				        $query->orWhere('vis.vis_region','like',"%$search%");
				        $query->orWhere('vis.vis_type','like',"%$search%");
				        $query->orWhere('vis.vis_url','like',"%$search%");
				        $query->orWhere('goods.goods_real_name','like',"%$search%");
	        	})
		        ->where(function($query)use($request){
	        	//ip是否屏蔽
	        	if($request->has('ispb')&&$request->input('ispb')=='1'){
	        		$query->where('vis.vis_isback','1');
	        	}
	        	})
				->orderBy('vis.vis_time','desc')
				->limit(1500)->get()->toArray();
   		$filename='访问记录'.date('Y-m-d H:i:s',time()).'.xls';
   		$zdname=['记录id','访问者ip','访问者国家','访问者省份/州','访问者城市/地区','访问者县区/镇','访问者网络源','访问者设备类型','访问时间','访问者语言','是否封禁该ip','单品名','访问域名','访问来源','购买时间','下单时间','停留时间','评论时间'];
   		foreach($data as $k => $v){
   			if($v['vis_isback']=='0'){
   				$data[$k]['vis_isback']='没有封禁';
   			}elseif($v['vis_isback']=='0'){
   				$data[$k]['vis_isback']='已封禁';
   			}
   			if($v['goods_name']==''||$v['goods_name']==null){
   				$data[$k]['goods_name']='通过ip访问';
   			}
   		}
        out_excil($data,$zdname,'访问记录表',$filename);
   }
   public function stime(Request $request){
   	$id=$request->input('id');
   	$vis=vis::where('vis_id',$id)->first();
   	return view('admin.vis.stime')->with(compact('vis'));
   }

    /**
     * 模糊搜索商品名称
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
   public function get_goods_name(Request $request)
   {
        $goods_type_id = $request->input('goods_name');
        $keyword = $request->input('name');
        $goods = \App\goods::join('goods_type','goods_type','=','goods_type_id')
                            ->whereIn('goods.goods_id',admin::get_goods_id())
                            ->where(function($query)use($keyword){
                                if($keyword){
                                    $query->where('goods.goods_real_name','like',"%$keyword%");
                                }
                            })
                            ->where(function($query)use($goods_type_id){
                                if($goods_type_id){
                                    $query->where('goods_type.goods_type_id',$goods_type_id);
                                }
                            })
                            ->where(function($query)use($request){
                                if($request->has('goods_blade_type')){
                                    $query->where('goods.goods_blade_type',$request->input('goods_blade_type'));
                                }
                            })
                            ->get();
        if($goods->isEmpty()){
            return response()->json(['status'=>1,'data'=>$goods,'str'=>'所选产品不存在']);
        }
       return response()->json(['status'=>0,'data'=>$goods,'str'=>'获取成功']);
   }
    /** 浏览统计
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
   public function statistic(Request $request){
   	if($request->isMethod('get')){
           $admins=\App\admin::whereIn('admin_id',admin::get_admins_id())->get();
           $goods=\App\goods::whereIn('goods_id',admin::get_goods_id())->get();
           $goods_type = goods_type::all();
        return view('admin.vis.statistic')->with(compact('goods','admins','goods_type'));
   	}elseif($request->isMethod('post')){
        //时间筛选（默认七天，按天）
        $start_time = $request->input('mintime');
        $end_time = $request->input('maxtime');
        $goods_id = $request->input('id');
            if($start_time && $end_time){
                $start_time = date('Y-m-d',strtotime($start_time)).' 00:00:00';
                $end_time = date('Y-m-d',strtotime($end_time)+24*3600).' 00:00:00';
            }else{
                $start_time = date('Y-m-d',time()-6*24*3600).' 00:00:00';
                $end_time = date('Y-m-d',time()+24*3600).' 00:00:00';
            }
            $count = \App\vis::visCount($start_time,$end_time,$goods_id);
            return response()->json($count);
   	}
   }
   public function statistic_b(Request $request){
	   	$id=$request->input('id');
	   	if($id==0){
	   		//$counts=DB::select("select count(*) as counts from vis where 0>=DateDiff(vis.vis_time,now())>-7");
	   		$ordercount=DB::select("select count(*) as ordercount from vis where 0>= DateDiff(vis.vis_time,now())>-7 and vis.vis_ordertime is not null");
	   		$buycount=DB::select("select count(*) as buycount from vis where 0>= DateDiff(vis.vis_time,now())>-7 and vis.vis_buytime is not null and vis.vis_comtime is null and vis.vis_ordertime is null");
	   		$comcount=DB::select("select count(*) as comcount from vis where 0>= DateDiff(vis.vis_time,now())>-7 and vis.vis_comtime is not null");
	   		$llcount=DB::select("select count(*) as llcount from vis where 0>= DateDiff(vis.vis_time,now())>-7 and vis.vis_comtime is null and vis.vis_ordertime is null and vis.vis_buytime is null");
	   		$order[]='点击购买并下单者';
	   		$order[]=$ordercount[0]->ordercount;
	   		$buy[]='仅点击购买者';
	   		$buy[]=$buycount[0]->buycount;
	   		$com[]='评论者';
	   		$com[]=$comcount[0]->comcount;
	   		$ii[]='仅浏览者';
	   		$ii[]=$llcount[0]->llcount;
	   		$arr=[];
	   		$arr[]=$order;
	   		$arr[]=$buy;
	   		$arr[]=$ii;
	   		$arr[]=$com;
	   		 return response()->json($arr);
	   	}else{
	   		//$counts=DB::select("select count(*) as counts from vis where 0>= DateDiff(vis.vis_time,now())>-7 and vis_goods_id=$id");
	   		$ordercount=DB::select("select count(*) as ordercount from vis where 0>= DateDiff(vis.vis_time,now())>-7 and vis.vis_ordertime is not null and vis_goods_id=$id");
	   		$buycount=DB::select("select count(*) as buycount from vis where 0>= DateDiff(vis.vis_time,now())>-7 and vis.vis_buytime is not null and vis_goods_id=$id and vis.vis_comtime is null and vis.vis_ordertime is null");
	   		$comcount=DB::select("select count(*) as comcount from vis where 0>= DateDiff(vis.vis_time,now())>-7 and vis.vis_comtime is not null and vis_goods_id=$id");
	   		$llcount=DB::select("select count(*) as llcount from vis where 0>= DateDiff(vis.vis_time,now())>-7 and vis.vis_comtime is null and vis.vis_ordertime is null and vis.vis_buytime is null and vis_goods_id=$id");
	   		$order[]='点击购买并下单者';
	   		$order[]=$ordercount[0]->ordercount;
	   		$buy[]='仅点击购买者';
	   		$buy[]=$buycount[0]->buycount;
	   		$com[]='评论者';
	   		$com[]=$comcount[0]->comcount;
	   		$ii[]='仅浏览者';
	   		$ii[]=$llcount[0]->llcount;
	   		$arr=[];
	   		$arr[]=$order;
	   		$arr[]=$buy;
	   		$arr[]=$ii;
	   		$arr[]=$com;
	   		 return response()->json($arr);
	   	}
   }
   public function ll(Request $request){
   	if($request->isMethod('get')){
//   		if(Auth::user()->is_root!='1'){
//   			$goods=\App\goods::
//   			where('goods_admin_id',Auth::user()->admin_id)
//   			->where(function($query){
//   				$query->where('is_del','0');
//   			})
//   			->get();
//   		}else{
//   			$goods=\App\goods::where('is_del','0')->get();
//   		}
        $goods=\App\goods::whereIn('goods_admin_id',admin::get_admins_id())->where('is_del','0')->get();

        return view('admin.vis.ll')->with(compact('goods'));
   	}else{

   	}
   }

    /** 返回数据浏览量，下单量，评论量，订单转化率，订单评论转化率信息
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
   public function get_table(Request $request)
   {
//           //时间筛选（默认七天，按天）
//           $start_time = $request->input('mintime');
//           $end_time = $request->input('maxtime');
//           $goods_id = $request->input('id');
//           if (Auth::user()->is_root != '1') {
//               $user_id = 0;//非root不能通过用户筛选
//           }
//           $goods_arr = admin::get_goods_id();
//           $time = [];
//           if ((!$start_time || !$end_time) || strtotime($end_time) - strtotime($start_time) > 3600 * 24 * 3) {
//               //超过3天或者没有选择时间，所以转化率按照天计算
//               if (!$start_time || !$end_time) { //没有选择时间
//                   $leng = 6;
//                   $use_end_time = time()-6*24*3600;
//               } else {                          //选择时间超过7天
//                   $leng = intval((strtotime($end_time) - strtotime($start_time)) / 3600 / 24);
//                   $use_end_time =  strtotime($start_time);
//               }
//               $data['count'] = [];
//               $data['buycount'] = [];
//               $data['ordercount'] = [];
//               $data['comcount'] = [];
//           for ($i = 0; $i <= $leng; $i++) {
//                   $day = 3600 * 24;
//                   $today = date('Y-m-d', $use_end_time + $i * $day);
//                   //获取用户访问量
//                   $count = \App\vis::visCount($today, $goods_id, $user_id, $goods_arr);
//                   //获取用户购买量
//                   $buycount = \App\vis::visBuyCount($today, $goods_id, $user_id, $goods_arr);
//                   if ($count == 0) {
//                       $data['buycountl'][$i] = 0;
//                   } else {
//                       $data['buycountl'][$i] = (sprintf("%.6f", $buycount / $count)*100).'%';
//                   }
//                   $data['buycount'][] = $buycount;
//                   $data['count'][] = $count;
//                   //获取用户下单量
//                   $ordercount = \App\vis::visOrderCount($today, $goods_id, $user_id, $goods_arr);
//                   if ($count == 0) {
//                       $data['ordercountl'][$i] = 0;
//                   } else {
//                       $data['ordercountl'][$i] = (sprintf("%.6f", $ordercount / $count)*100).'%';
//                   }
//                   $data['ordercount'][] = $ordercount;
//                   $time[] = $today;
//               }
//           } else {
//               $leng = intval((strtotime($end_time) - strtotime($start_time)) / 3600)+23;
//               for ($i = 0; $i <= $leng; $i++) {
//                   $day = 3600;
//                   $today = date('Y-m-d H', strtotime($start_time) + $i * $day);
//                   if(strtotime($start_time)+$i*$day <= time() ) {
//                       //获取用户访问量
//                       $count = \App\vis::visCount($today, $goods_id, $user_id, $goods_arr);
//                       //获取用户购买量
//                       $buycount = \App\vis::visBuyCount($today, $goods_id, $user_id, $goods_arr);
//                       if ($count == 0) {
//                           $data['buycountl'][$i] = 0;
//                       } else {
//                           $data['buycountl'][$i] = (sprintf("%.6f", $buycount / $count)*100).'%';
//                       }
//                       $data['buycount'][] = $buycount;
//                       $data['count'][] = $count;
//                       //获取用户下单量
//                       $ordercount = \App\vis::visOrderCount($today, $goods_id, $user_id, $goods_arr);
//                       if ($count == 0) {
//                           $data['ordercountl'][$i] = 0;
//                       } else {
//                           $data['ordercountl'][$i] = (sprintf("%.6f", $ordercount / $count)*100).'%';
//                       }
//                       $data['ordercount'][] = $ordercount;
//                       $time[] = $today;
//                   }
//               }
//           }
       //时间筛选（默认七天，按天）
       $start_time = $request->input('mintime');
       $end_time = $request->input('maxtime');
       $goods_id = $request->input('id');
       if($start_time && $end_time){
           $start_time = date('Y-m-d',strtotime($start_time)).' 00:00:00';
           $end_time = date('Y-m-d',strtotime($end_time)+24*3600).' 00:00:00';
       }else{
           $start_time = date('Y-m-d',time()-6*24*3600).' 00:00:00';
           $end_time = date('Y-m-d',time()+24*3600).' 00:00:00';
       }
//       $start_time = date('Y-m-d',strtotime($start_time)).' 00:00:00';
//       $end_time = date('Y-m-d',strtotime($end_time)+24*3600).' 00:00:00';
       $count = \App\vis::visCount($start_time,$end_time,$goods_id);
       foreach ($count['data'] as $item)
       {
           if($item['name']=='购买转化率'){
               foreach ($item['data'] as &$item_data)
               {
                   if($item_data == 0){
                       $item_data = 0;
                   }else{
                       $item_data = sprintf('%.4f',$item_data*100).'%';
                   }
               }
               $data['buycountl'] = $item['data'];
           }
           if($item['name']=='下单转化率'){
               foreach ($item['data'] as &$item_data)
               {
                   if($item_data == 0){
                       $item_data = 0;
                   }else{
                       $item_data = sprintf('%.4f',$item_data*100).'%';
                   }
               }
               $data['ordercountl'] = $item['data'];
           }
           if($item['name']=='相对转化率'){
               foreach ($item['data'] as &$item_data)
               {
                   if($item_data == 0){
                       $item_data = 0;
                   }else{
                       $item_data = sprintf('%.4f',$item_data*100).'%';
                   }
               }
               $data['relatcountl'] = $item['data'];
           }
       }
       foreach ($count['datacount'] as $item)
       {
           if($item['name'] == '浏览量'){
               $data['count'] = $item['data'];
           }
           if($item['name'] == '购买量'){
               $data['buycount'] = $item['data'];
           }
           if($item['name'] == '下单量'){
               $data['ordercount'] = $item['data'];
           }
       }
       $time = $count['time'];
       return view('admin.vis.table')->with(compact('data','time'));
   }

   public function get_ajaxtable(Request $request){
   	 $id=$request->input('id');	
   	 $arr=[];
   	 if($id==0){
   	 	$allcount=[];
   	 	$yxcount=[];
   	 	for ($i=0; $i <7 ; $i++) { 
   	 	   $counts=DB::select("select count(*) as counts from vis where  DateDiff(vis.vis_time,now())=-$i");
   	 	   $allcount[]=$counts[0]->counts;
   	 		$yxcounts=DB::select("select count(*) as yxcounts from vis where  DateDiff(vis.vis_time,now())=-$i and vis_ordertime > 0");
   	 		$yxcount[]=$yxcounts[0]->yxcounts;
   	 	}
   	 }else{
   	 	$allcount=[];
   	 	$yxcount=[];
   	 	for ($i=0; $i <7 ; $i++) { 
   	 	   $counts=DB::select("select count(*) as counts from vis where  DateDiff(vis.vis_time,now())=-$i and vis_goods_id=$id");
   	 	   $allcount[]=$counts[0]->counts;
   	 		$yxcounts=DB::select("select count(*) as yxcounts from vis where  DateDiff(vis.vis_time,now())=-$i and vis_ordertime > 0 and vis_goods_id=$id");
   	 		$yxcount[]=$yxcounts[0]->yxcounts;
   	 	}
   	 }
   	 return view('admin.vis.ajaxtable')->with(compact('allcount','yxcount'));
   }
   public function get_zxtu(Request $request){
   	$id=$request->input('id');
   	if($id!=0){
   			//$vis=\App\vis::where('vis_goods_id',$id)->get();
   				for ($i=0; $i <7 ; $i++) { 
   				$count=DB::select("select count(*) as counts from vis where DateDiff(vis.vis_time,now())=-$i and vis.vis_goods_id=$id");
   				$count=$count[0]->counts;
	   			$data1['name']='浏览人数';
	   			$data1['data'][$i]=$count;
	   		}	
	   		for ($i=0; $i <7 ; $i++) { 
	   			$count=DB::select("select count(*) as counts from vis where DateDiff(vis.vis_time,now())=-$i and vis_buytime >0 and vis.vis_goods_id=$id");
	   			$count=$count[0]->counts;
	   			$data2['name']='加购人数';
	   			$data2['data'][$i]=$count;	
	   		}
	   	
	   		$data[]=$data1;
	   		$data[]=$data2;
	   		$msg['data']=$data;
	   		$allcc=DB::select("select count(*) as counts from vis where 0>=DateDiff(vis.vis_time,now())>-7 and vis.vis_goods_id=$id");
	   		$msg['max']=$allcc[0]->counts;
	   		 return response()->json($msg);
   		}else{
   			//$vis=\App\vis::where('vis_goods_id',$id)->get();
   			for ($i=0; $i <7 ; $i++) { 
   				$count=DB::select("select count(*) as counts from vis where DateDiff(vis.vis_time,now())=-$i");
   				$count=$count[0]->counts;
	   			$data1['name']='浏览人数';
	   			$data1['data'][$i]=$count;
	   		}	
	   		for ($i=0; $i <7 ; $i++) { 
	   			$count=DB::select("select count(*) as counts from vis where DateDiff(vis.vis_time,now())=-$i and  vis_buytime >0 ");
	   			$count=$count[0]->counts;
	   			$data2['name']='加购人数';
	   			$data2['data'][$i]=$count;	
	   		}
	   		$data[]=$data1;
	   		$data[]=$data2;
	   		$msg['data']=$data;
	   		$allcc=DB::select("select count(*) as counts from vis where 0>=DateDiff(vis.vis_time,now())>-7");
	   		$msg['max']=max($data1['data']);
	   		 return response()->json($msg);
   		}
   		
   	
   }

    /** 花费统计
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
   public function pay_money(Request $request)
   {
       if($request->isMethod('get')) {
           $goods = \App\goods::whereIn('goods_admin_id', admin::get_admins_id())->where('is_del', '0')->get();
           $admins = admin::whereIn('admin_id', admin::get_admins_id())->get();
           return view('admin.vis.pay_money')->with(compact('goods', 'admins'));
       }elseif($request->isMethod('post')){
           //时间筛选（默认七天，按天）
           $start_time = $request->input('mintime');
           $end_time = $request->input('maxtime');
           $goods_id = $request->input('id');
           $user_id = $request->input('user_id');
           $time = [];
           //选择时间超过7天
           if(!$start_time || !$end_time){ //没有选择时间
               $leng = 6;
               $use_end_time = time()-8*24*3600;
           }else{                          //选择时间超过7天
               $leng = intval((strtotime($end_time)-strtotime($start_time))/3600/24);
               $use_end_time =  strtotime($start_time);
           }
           $admin_ids = admin::get_admins_id();
           for($i=0; $i <=$leng; $i++)
           {
               $day = 3600*24;
               $today = date('Y-m-d',$use_end_time+$i*$day);
               //获取管理员花费金额
               $count = spend::whereIn('spend_admin_id',$admin_ids)
                   ->where('spend_time','like','%'.$today.'%')
                   ->where(function ($query)use($user_id,$goods_id){
                       if($user_id){
                           $query->where('spend_admin_id',$user_id);
                       }
                       if($goods_id){
                           $query->where('spend_goods_id',$goods_id);
                       }
                   })
                   ->sum('spend_money');
               $data1['name']='花费金额';
               $data1['data'][$i] = $count;
               $time[] = $today;
           }
           //折线图
           $data[]=$data1;
           //柱状图
           $datacount[]=$data1;
           return response()->json(['data'=>$data,'datacount'=>$datacount,'time'=>$time]);
       }
   }

    /** 获取花费数据
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
   public function pay_table(Request $request)
   {
       //时间筛选（默认七天，按天）
       $start_time = $request->input('mintime');
       $end_time = $request->input('maxtime');
       $goods_id = $request->input('id');
       $user_id = $request->input('user_id');
       $time = [];
       //选择时间超过7天
       if(!$start_time || !$end_time){ //没有选择时间
           $leng = 6;
           $use_end_time = time()-8*24*3600;
       }else{                          //选择时间超过7天
           $leng = intval((strtotime($end_time)-strtotime($start_time))/3600/24);
           $use_end_time =  strtotime($start_time);
       }
       $admin_ids = admin::get_admins_id();
       for($i=0; $i <=$leng; $i++)
       {
           $day = 3600*24;
           $today = date('Y-m-d',$use_end_time+$i*$day);
           //获取管理员花费金额
           $count = spend::whereIn('spend_admin_id',$admin_ids)
               ->where('spend_time','like','%'.$today.'%')
               ->where(function ($query)use($user_id,$goods_id){
                   if($user_id){
                       $query->where('spend_admin_id',$user_id);
                   }
                   if($goods_id){
                       $query->where('spend_goods_id',$goods_id);
                   }
               })
               ->sum('spend_money');
           $data1[] = $count;
           $time[] = $today;
       }
       //table
       $data['pay']=$data1;
       return view('admin.vis.pay_table')->with(compact('data','time'));
   }

   public function get_ajaxtop(Request $request)
   {
       //时间筛选（默认七天，按天）
       $start_time = $request->input('mintime');
       $end_time = $request->input('maxtime');
       //选择时间超过7天
       if(!$start_time || !$end_time){ //没有选择时间
           $start_time = date('Y-m-d',time()-8*24*3600).' 00:00:00';
           $end_time = date('Y-m-d',time()-2*24*3600).' 00:00:00';
       }else{                          //选择时间超过7天
           $start_time = date('Y-m-d',strtotime($start_time)).' 00:00:00';
           $end_time = date('Y-m-d',strtotime($end_time)).' 00:00:00';
       }

       $array = [];
       $admins = admin::whereIn('admin_id',admin::get_admins_id())->get();
       //计算商品销售额度
       foreach ($admins as $admin)
       {
           $sale_total = order::get_sale_total($admin->admin_id,$start_time,$end_time);
           $arr['admin_name'] = $admin->admin_name;
           $arr['sale_total'] = $sale_total;
           array_push($array,$arr);
       }
//       //计算用户花费额度(不可以直接用，需要算汇率转换人民币)
//       if(!$admins->isEmpty()){
//           foreach ($admins as $item)
//           {
//               $spend = spend::select(DB::raw('SUM(spend_money) as spend_money'))->whereBetween('spend_time',[$start_time,$end_time])->where('spend_admin_id',$item->admin_id)->first();
//               $arr['admin_name'] = $item->admin_name;
//               if($spend){
//                   $arr['spend_money'] = $spend->spend_money ? $spend->spend_money : 0;
//               }
//               array_push($array,$arr);
//           }
//       }
       //组内成员按照销售额排序
       if(!empty($array)){
           $sort = array_column($array, 'sale_total');
           array_multisort($sort, SORT_DESC, $array);
           //获取销售额前10的数据
           $array = array_slice($array,0,10);
       }
       //table
       return view('admin.vis.ajaxtop')->with(compact('array'));
    }
}
