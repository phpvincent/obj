<?php

namespace App\Http\Controllers\admin;

use App\goods;
use App\special;
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
	        	if(Auth::user()->is_root!='1'){
	        		$query->whereIn('vis_goods_id',\App\goods::get_ownid(Auth::user()->admin_id));
	        	}
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
	        	if(Auth::user()->is_root!='1'){
	        		$query->whereIn('vis_goods_id',\App\goods::get_ownid(Auth::user()->admin_id));
	        	}
	        })
	        ->count();
	        $newcount=DB::table('vis')
	        ->leftjoin('goods','goods.goods_id','vis.vis_goods_id')
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
	        		if(Auth::user()->is_root!='1'){
	        			$query->whereIn('vis.vis_goods_id',\App\goods::get_ownid(Auth::user()->admin_id));
	        			}
	        })
	        ->count();
	        $data=DB::table('vis')
	        ->select('vis.*','goods.goods_real_name')
	        ->leftjoin('goods','goods.goods_id','vis.vis_goods_id')
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
	        		if(Auth::user()->is_root!='1'){
	        			$query->whereIn('vis.vis_goods_id',\App\goods::get_ownid(Auth::user()->admin_id));
	        			}
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
    public function prea(){
    	$msg=\App\pb::first();
    	$msg->area=explode(';', $msg->pb_ziduan);
    	return view('admin.vis.prea')->with('msg',$msg);
    }
    public function chvis(Request $request){
    	if(substr($request->input('msg'),-1)==';'){
    		$inmsg=rtrim($request->input('msg'),';');
    	}else{
    		$inmsg=$request->input('msg');
    	}
       $msg=DB::table('pb')->where('pb_id',1)->update(['pb_ziduan'=>$inmsg]);
        if($msg){
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
   		$filename='访问记录'.date('Y-m-d h:i:s',time()).'.xls';
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

    /** 浏览统计
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
   public function statistic(Request $request){
   	if($request->isMethod('get')){
   		if(Auth::user()->is_root!='1'){
   		    $admin_id = Auth::user()->admin_id;
            $admins=\App\admin::where('admin_id',$admin_id)->get();
   			$goods=\App\goods::where([['goods_admin_id',Auth::user()->admin_id],['is_del','0']])->get();
   		}else{
            $admins=\App\admin::get();
            $goods=\App\goods::get();
   		}
   		return view('admin.vis.statistic')->with(compact('goods','admins'));
   	}elseif($request->isMethod('post')){
        //时间筛选（默认七天，按天）
        $start_time = $request->input('mintime');
        $end_time = $request->input('maxtime');
        $goods_id = $request->input('id');
        $user_id = $request->input('user_id');
        //判断是否为root用户
        if(Auth::user()->is_root!='1'){
            $user_id = 0;//非root不能通过用户筛选
            $goods_arr = goods::where('goods_admin_id',Auth::user()->admin_id)->pluck('goods_id')->toArray();
        }else{
            $goods_arr = goods::pluck('goods_id')->toArray();
        }
        $time = [];
        if((!$start_time || !$end_time) || strtotime($end_time)-strtotime($start_time) > 3600*24*3){
            //超过3天或者没有选择时间，所以转化率按照天计算
            if(!$start_time || !$end_time){ //没有选择时间
                $leng = 6;
                $use_end_time = time()-6*24*3600;
            }else{                          //选择时间超过7天
                $leng = intval((strtotime($end_time)-strtotime($start_time))/3600/24);
                $use_end_time =  strtotime($start_time);
            }
            for($i=0; $i <=$leng; $i++)
            {
                $day = 3600*24;
                $today = date('Y-m-d',$use_end_time+$i*$day);
                //获取用户访问量
                $count = \App\vis::visCount($today,$goods_id,$user_id,$goods_arr);
                //获取用户购买量
                $buycount = \App\vis::visBuyCount($today,$goods_id,$user_id,$goods_arr);
                $data1['name']='购买转化';
                if($count==0){
                    $data1['data'][$i]=0;
                }else{
                    $data1['data'][$i]=sprintf("%.6f",$buycount/$count);
                }
                $data4['name']='浏览量';
                $data4['data'][$i] = $count;
                $data5['name']='仅点击购买者';
                $data5['data'][$i] = $buycount;
                $time[] = $today;
            }
            for ($i=0; $i <=$leng; $i++) {
                $day = 3600*24;
                $today = date('Y-m-d',$use_end_time+$i*$day);
                //获取用户访问量
                $count = \App\vis::visCount($today,$goods_id,$user_id,$goods_arr);
                //获取用户下单量
                $ordercount = \App\vis::visOrderCount($today,$goods_id,$user_id,$goods_arr);
                $data2['name']='下单转化';
                if($count==0){
                    $data2['data'][$i]=0;
                }else{
                    $data2['data'][$i]=sprintf("%.6f",$ordercount/$count);
                }
                $data6['name']='点击购买并下单';
                $data6['data'][$i] = $ordercount;
            }
//            for ($i=0; $i <=$leng; $i++) {
//                $day = 3600*24;
//                $today = date('Y-m-d',$use_end_time+$i*$day);
//                //获取用户访问量
//                $count = \App\vis::visCount($today,$goods_id,$user_id,$goods_arr);
//                //获取用户评论量
//                $comcount = \App\vis::visComCount($today,$goods_id,$user_id,$goods_arr);
//                $data3['name']='评论转化';
//                if($count==0){
//                    $data3['data'][$i]=0;
//                }else{
//                    $data3['data'][$i]=sprintf("%.6f",$comcount/$count);
//                }
//                $data7['name']='评论者';
//                $data7['data'][$i] = $comcount;
//            }
        }else{
                $leng =intval((strtotime($end_time)-strtotime($start_time)) / 3600)+23;
                for($i=0; $i <=$leng ; $i++)
                {
                    $day = 3600;
                    $today = date('Y-m-d H',strtotime($start_time)+$i*$day);
                    if(strtotime($start_time)+$i*$day <= time() ){
                        //获取用户访问量
                        $count = \App\vis::visCount($today,$goods_id,$user_id,$goods_arr);
                        //获取用户购买量
                        $buycount = \App\vis::visBuyCount($today,$goods_id,$user_id,$goods_arr);
                        $data1['name']='购买转化';
                        if($count==0){
                            $data1['data'][$i]=0;
                        }else{
                            $data1['data'][$i]=sprintf("%.6f",$buycount/$count);
                        }
                        $data4['name']='浏览量';
                        $data4['data'][$i] = $count;
                        $data5['name']='仅点击购买者';
                        $data5['data'][$i] = $buycount;
                        $time[] = $today;
                    }

                }
                for ($i=0; $i <=$leng; $i++) {
                    $day = 3600;
                    $today = date('Y-m-d H',strtotime($end_time)+$i*$day);
                    if(strtotime($start_time)+$i*$day <= time() ) {
                        //获取用户访问量
                        $count = \App\vis::visCount($today,$goods_id,$user_id,$goods_arr);
                        //获取用户下单量
                        $ordercount = \App\vis::visOrderCount($today,$goods_id,$user_id,$goods_arr);
                        $data2['name']='下单转化';
                        if($count==0){
                            $data2['data'][$i]=0;
                        }else{
                            $data2['data'][$i]=sprintf("%.6f",$ordercount/$count);
                        }
                        $data6['name']='点击购买并下单';
                        $data6['data'][$i] = $ordercount;
                    }
                }
//                for ($i=0; $i <=$leng; $i++) {
//                    $day = 3600;
//                    $today = date('Y-m-d H', strtotime($end_time) + $i * $day);
//                    if (strtotime($start_time) + $i * $day <= time()) {
//                        //获取用户访问量
//                        $count = \App\vis::visCount($today, $goods_id, $user_id, $goods_arr);
//                        //获取用户评论量
//                        $comcount = \App\vis::visComCount($today, $goods_id, $user_id, $goods_arr);
//                        $data3['name'] = '评论转化';
//                        if ($count == 0) {
//                            $data3['data'][$i] = 0;
//                        } else {
//                            $data3['data'][$i] = sprintf("%.6f", $comcount / $count);
//                        }
//                        $data7['name'] = '评论者';
//                        $data7['data'][$i] = $comcount;
//                    }
//                }
        }
        //折线图
        $data[]=$data1;
        $data[]=$data2;
//        $data[]=$data3;
        //柱状图
        $datacount[]=$data4;
        $datacount[]=$data5;
        $datacount[]=$data6;
//        $datacount[]=$data7;
        return response()->json(['data'=>$data,'datacount'=>$datacount,'time'=>$time]);


//   		if($request->has('id')){
//   			$id=$request->input('id');
//   		}else{
//   			$id=0;
//   		}
//        if($id!=0){
//   				for ($i=0; $i <7 ; $i++) {
//   				$count=DB::select("select count(*) as counts from vis where DateDiff(vis.vis_time,now())=-$i and vis.vis_goods_id=$id");
//   				$count=$count[0]->counts;
//	   			$data1['name']='购买转化';
//	   			$buycount=DB::select("select count(*) as buycount from vis where DateDiff(vis.vis_time,now())=-$i and vis.vis_buytime is not null and vis.vis_goods_id=$id");
//	   			if($count==0){
//	   				$data1['data'][$i]=0;
//	   			}else{
//	   				$data1['data'][$i]=$buycount[0]->buycount/$count;
//	   			}
//
//	   		}
//	   		for ($i=0; $i <7 ; $i++) {
//	   			$count=DB::select("select count(*) as counts from vis where DateDiff(vis.vis_time,now())=-$i and vis.vis_goods_id=$id");
//	   			$count=$count[0]->counts;
//	   			$data2['name']='下单转化';
//	   			$ordercount=DB::select("select count(*) as ordercount from vis where DateDiff(vis.vis_time,now())=-$i and vis.vis_ordertime is not null and vis.vis_goods_id=$id");
//	   			if($count==0){
//	   				$data2['data'][$i]=0;
//	   			}else{
//	   				$data2['data'][$i]=$ordercount[0]->ordercount/$count;
//	   			}
//
//
//	   		}
//	   		for ($i=0; $i <7 ; $i++) {
//	   			$count=DB::select("select count(*) as counts from vis where DateDiff(vis.vis_time,now())=-$i and vis.vis_goods_id=$id");
//	   			$count=$count[0]->counts;
//	   			$data3['name']='评论转化';
//	   			$comcount=DB::select("select count(*) as comcount from vis where DateDiff(vis.vis_time,now())=-$i and vis.vis_comtime is not null and vis.vis_goods_id=$id");
//	   			if($count==0){
//	   				$data3['data'][$i]=0;
//	   			}else{
//	   				$data3['data'][$i]=$comcount[0]->comcount/$count;
//	   			}
//
//	   		}
//	   		$data[]=$data1;
//	   		$data[]=$data2;
//	   		$data[]=$data3;
//	   		 return response()->json($data);
//   		}else{
//   			//$count=DB::select("select count(*) from vis where DateDiff(dd,vis_time,getdate())={$i}");
//   			for ($i=0; $i <7 ; $i++) {
//   				$count=DB::select("select count(*) as counts from vis where DateDiff(vis.vis_time,now())=-$i");
//   				$count=$count[0]->counts;
//	   			$data1['name']='购买转化';
//	   			$buycount=DB::select("select count(*) as buycount from vis where DateDiff(vis.vis_time,now())=-$i and vis.vis_buytime is not null");
//	   			if($count==0){
//	   				$data1['data'][$i]=0;
//	   			}else{
//	   				$data1['data'][$i]=$buycount[0]->buycount/$count;
//	   			}
//
//	   		}
//	   		for ($i=0; $i <7 ; $i++) {
//	   			$count=DB::select("select count(*) as counts from vis where DateDiff(vis.vis_time,now())=-$i");
//	   			$count=$count[0]->counts;
//	   			$data2['name']='下单转化';
//	   			$ordercount=DB::select("select count(*) as ordercount from vis where DateDiff(vis.vis_time,now())=-$i and vis.vis_ordertime is not null");
//	   			if($count==0){
//	   				$data2['data'][$i]=0;
//	   			}else{
//	   				$data2['data'][$i]=$ordercount[0]->ordercount/$count;
//	   			}
//
//
//	   		}
//	   		for ($i=0; $i <7 ; $i++) {
//	   			$count=DB::select("select count(*) as counts from vis where DateDiff(vis.vis_time,now())=-$i");
//	   			$count=$count[0]->counts;
//	   			$data3['name']='评论转化';
//	   			$comcount=DB::select("select count(*) as comcount from vis where DateDiff(vis.vis_time,now())=-$i and vis.vis_comtime is not null");
//	   			if($count==0){
//	   				$data3['data'][$i]=0;
//	   			}else{
//	   				$data3['data'][$i]=$comcount[0]->comcount/$count;
//	   			}
//
//	   		}
//	   		$data[]=$data1;
//	   		$data[]=$data2;
//	   		$data[]=$data3;
//	   		 return response()->json($data);
//   		}
//
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
   		if(Auth::user()->is_root!='1'){
   			$goods=\App\goods::
   			where('goods_admin_id',Auth::user()->admin_id)
   			->where(function($query){
   				$query->where('is_del','0');
   			})
   			->get();
   		}else{
   			$goods=\App\goods::where('is_del','0')->get();
   		}
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
           //时间筛选（默认七天，按天）
           $start_time = $request->input('mintime');
           $end_time = $request->input('maxtime');
           $goods_id = $request->input('id');
           $user_id = $request->input('user_id');
           //判断是否为root用户
           if (Auth::user()->is_root != '1') {
               $user_id = 0;//非root不能通过用户筛选
               $goods_arr = goods::where('goods_admin_id', Auth::user()->admin_id)->pluck('goods_id')->toArray();
           } else {
               $goods_arr = goods::pluck('goods_id')->toArray();
           }
           $time = [];
           if ((!$start_time || !$end_time) || strtotime($end_time) - strtotime($start_time) > 3600 * 24 * 3) {
               //超过3天或者没有选择时间，所以转化率按照天计算
               if (!$start_time || !$end_time) { //没有选择时间
                   $leng = 6;
                   $use_end_time = time()-6*24*3600;
               } else {                          //选择时间超过7天
                   $leng = intval((strtotime($end_time) - strtotime($start_time)) / 3600 / 24);
                   $use_end_time =  strtotime($start_time);
               }
               $data['count'] = [];
               $data['buycount'] = [];
               $data['ordercount'] = [];
               $data['comcount'] = [];
           for ($i = 0; $i <= $leng; $i++) {
                   $day = 3600 * 24;
                   $today = date('Y-m-d', $use_end_time + $i * $day);
                   //获取用户访问量
                   $count = \App\vis::visCount($today, $goods_id, $user_id, $goods_arr);
                   //获取用户购买量
                   $buycount = \App\vis::visBuyCount($today, $goods_id, $user_id, $goods_arr);
                   if ($count == 0) {
                       $data['buycountl'][$i] = 0;
                   } else {
                       $data['buycountl'][$i] = (sprintf("%.6f", $buycount / $count)*100).'%';
                   }
                   $data['buycount'][] = $buycount;
                   $data['count'][] = $count;
                   //获取用户下单量
                   $ordercount = \App\vis::visOrderCount($today, $goods_id, $user_id, $goods_arr);
                   if ($count == 0) {
                       $data['ordercountl'][$i] = 0;
                   } else {
                       $data['ordercountl'][$i] = (sprintf("%.6f", $ordercount / $count)*100).'%';
                   }
                   $data['ordercount'][] = $ordercount;
//                   //获取用户评论量
//                   $comcount = \App\vis::visComCount($today, $goods_id, $user_id, $goods_arr);
//                   if ($count == 0) {
//                       $data['comcountl'][$i] = 0;
//                   } else {
//                       $data['comcountl'][$i] = sprintf("%.2f", $comcount / $count);
//                   }
//                   $data['comcount'][] = $comcount;
                   $time[] = $today;
               }
           } else {
               $leng = intval((strtotime($end_time) - strtotime($start_time)) / 3600)+23;
               for ($i = 0; $i <= $leng; $i++) {
                   $day = 3600;
                   $today = date('Y-m-d H', strtotime($start_time) + $i * $day);
                   if(strtotime($start_time)+$i*$day <= time() ) {
                       //获取用户访问量
                       $count = \App\vis::visCount($today, $goods_id, $user_id, $goods_arr);
                       //获取用户购买量
                       $buycount = \App\vis::visBuyCount($today, $goods_id, $user_id, $goods_arr);
                       if ($count == 0) {
                           $data['buycountl'][$i] = 0;
                       } else {
                           $data['buycountl'][$i] = (sprintf("%.6f", $buycount / $count)*100).'%';
                       }
                       $data['buycount'][] = $buycount;
                       $data['count'][] = $count;
                       //获取用户访问量
//                       $count = \App\vis::visCount($today, $goods_id, $user_id, $goods_arr);
                       //获取用户下单量
                       $ordercount = \App\vis::visOrderCount($today, $goods_id, $user_id, $goods_arr);
                       if ($count == 0) {
                           $data['ordercountl'][$i] = 0;
                       } else {
                           $data['ordercountl'][$i] = (sprintf("%.6f", $ordercount / $count)*100).'%';
                       }
                       $data['ordercount'][] = $ordercount;
                       //获取用户访问量
//                       $count = \App\vis::visCount($today, $goods_id, $user_id, $goods_arr);
                       //获取用户评论量
//                       $comcount = \App\vis::visComCount($today, $goods_id, $user_id, $goods_arr);
//                       if ($count == 0) {
//                           $data['comcountl'][$i] = 0;
//                       } else {
//                           $data['comcountl'][$i] = sprintf("%.2f", $comcount / $count);
//                       }
//                       $data['comcount'][] = $comcount;
                       $time[] = $today;
                   }
               }
           }
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
}
