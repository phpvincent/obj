<?php

namespace App\Http\Controllers\Admin;

use App\currency_type;
use App\order;
use App\spend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayController extends Controller
{
    public function index(Request $request)
    {
    	if(Auth::user()->is_root=='1'){
    		$admins=\App\admin::get();
    	}else{
    		$admins=\App\admin::whereIn('admin_id',\App\admin::get_group_ids(Auth::user()->admin_id))->get();
    	}
    	$counts=$admins->count();
    	return view('admin.pay.index')->with(compact('admins','counts'));
    }

    /** 获取话费列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_table(Request $request){
        $info=$request->all();
        $cm=$info['order'][0]['column'];
        $dsc=$info['order'][0]['dir'];
        $order=$info['columns']["$cm"]['data'];
        $draw=$info['draw'];
        $start=$info['start'];
        $len=$info['length'];
        $search=trim($info['search']['value']);

        //获取账户名
        $goods_search=$request->has('spend_search')?$request->input('spend_search'):0;
        $admin_id = Auth::user()->admin_id;

        //花费总条数
        $counts=DB::table('goods')
            ->where(function($query)use($admin_id){
                if(Auth::user()->is_root!='1'){
                    $query->where('goods_admin_id',$admin_id);
                }
            })
            ->count();

        if(Auth::user()->is_root!='1'){//非root 用户
            //获取自己名下的花费
            $newcount=DB::table('goods')
                ->where('is_del','0')
                ->where('goods_heshen','1')
                ->where('goods_admin_id',$admin_id)
                ->leftjoin('spend','spend.spend_goods_id','=','goods.goods_id')
                ->where(function($query)use($search){
                    //1.搜索单品名称
                    $query->where([['goods.goods_real_name','like',"%$search%"]]);
                    //2.搜索id
                    $query->orWhere([['goods.goods_id','like',"%$search%"]]);
                })
                ->where(function($query)use($request){//根据时间筛选
                    if($request->input('mintime')!=null&&$request->input('maxtime')==null){
                        $query->where('spend.spend_time','>',$request->input('mintime'));
                    }elseif($request->input('maxtime')!=null&&$request->input('mintime')==null){
                        $query->where('spend.spend_time','<',$request->input('maxtime'));
                    }elseif($request->input('maxtime')!=null&&$request->input('mintime')!=null){
                        $query->whereBetween('spend.spend_time',[$request->input('mintime'),$request->input('maxtime')]);
                    }
                })->count();

            //获取商品ID
            $data = DB::table('goods')
                ->where('is_del','0')
                ->where('goods_heshen','1')
                ->where('goods_admin_id',$admin_id)
                ->select('goods_id','goods_real_name','goods_up_time')
                ->where(function($query)use($search){
                    //1.搜索单品名称
                    $query->where([['goods_real_name','like',"%$search%"]]);
                    //2.搜索id
                    $query->orWhere([['goods_id','like',"%$search%"]]);
                })
                ->orderBy($order,$dsc)
                ->offset($start)
                ->limit($len)
                ->get();
            if(!$data->isEmpty()){
                foreach ($data as &$item)
                {
                    //计算单品花费总额
                    $all_goods_money = spend::where('spend_goods_id',$item->goods_id)
                        ->where(function($query)use($request){//根据时间筛选
                            if($request->input('mintime')!=null&&$request->input('maxtime')==null){
                                $query->where('spend.spend_time','>',$request->input('mintime'));
                            }elseif($request->input('maxtime')!=null&&$request->input('mintime')==null){
                                $query->where('spend.spend_time','<',$request->input('maxtime'));
                            }elseif($request->input('maxtime')!=null&&$request->input('mintime')!=null){
                                $query->whereBetween('spend.spend_time',[$request->input('mintime'),$request->input('maxtime')]);
                            }
                        })->get();
                    $goods_spend_money = 0;
                    if(!$all_goods_money->isEmpty()){
                        foreach ($all_goods_money as $val)
                        {
                            $goods_spend_money += $val->spend_money * $val->currency_has_spend->exchange_rate;
                        }
                    }
                    $item->goods_spend_money = $goods_spend_money;
                    //计算单品销售总额
                    $item->goods_money = order::where('order_goods_id',$item->goods_id)->sum('order_price');
                    //商品录入状态（如果从审核通过开始就需要有花费记录，花费记录只记录两日前的花费，如果商品审核通过，没有产生花费，也需要记录花费，为0元）
                    $start_time = strtotime(date('Y-m-d',time()-3600*24).'00:00:00');
                    $end_time = strtotime(date('Y-m-d',strtotime($item->goods_up_time)).'00:00:00');
                    if($start_time > $end_time){
                        $item->goods_status = 1;
                        $length = ($end_time-$start_time)/24*3600;
                        for($i=0; $i<$length; $i++)
                        {
                            $dates = date('Y-m-d',strtotime($item->goods_up_time));
                            if(!spend::where('spend_goods_id',$item->goods_id)->where('spend_time',$dates)->first()){
                                $item->goods_status = 0;
                                break;
                            }
                        }
                    }else{
                        $item->goods_status = 1;
                    }
                }
            }
//            $counts=DB::table('spend')
//                ->where('spend_admin_id',$admin_id)
//                ->count();
//
//            $newcount=DB::table('spend')
//                ->select('spend.*','goods.goods_real_name','goods.goods_id','admin.admin_name')
//                ->leftjoin('goods','spend.spend_goods_id','=','goods.goods_id')
//                ->leftjoin('admin','spend.spend_admin_id','=','admin.admin_id')
//                ->where('spend.spend_admin_id',$admin_id)
//                ->where(function($query)use($search){
//                    //1.搜索单品名称
//                    $query->where([['goods.goods_real_name','like',"%$search%"]]);
//                    //2.搜索品台
//                    $query->orWhere([['spend.spend_platform','like',"%$search%"]]);
//                    //3.搜索id
//                    $query->orWhere([['spend.spend_id','like',"%$search%"]]);
//                    //4.搜索管理员名称
//                    $query->orWhere([['admin.admin_name','like',"%$search%"]]);
//                })
//                ->where(function($query)use($request){//根据时间筛选
//                    if($request->input('mintime')!=null&&$request->input('maxtime')==null){
//                        $query->where('spend.spend_time','>',$request->input('mintime'));
//                    }elseif($request->input('maxtime')!=null&&$request->input('mintime')==null){
//                        $query->where('spend.spend_time','<',$request->input('maxtime'));
//                    }elseif($request->input('maxtime')!=null&&$request->input('mintime')!=null){
//                        $query->whereBetween('spend.spend_time',[$request->input('mintime'),$request->input('maxtime')]);
//                    }
//                })
//                ->count();
//
//            //列表数据
//            $data=DB::table('spend')
//                ->select('spend.*','goods.goods_real_name','goods.goods_id','admin.admin_name')
//                ->leftjoin('goods','spend.spend_goods_id','=','goods.goods_id')
//                ->leftjoin('admin','spend.spend_admin_id','=','admin.admin_id')
//                ->where('spend.spend_admin_id',$admin_id)
//                ->where(function($query)use($search){
//                    //1.搜索单品名称
//                    $query->where([['goods.goods_real_name','like',"%$search%"]]);
//                    //2.搜索品台
//                    $query->orWhere([['spend.spend_platform','like',"%$search%"]]);
//                    //3.搜索id
//                    $query->orWhere([['spend.spend_id','like',"%$search%"]]);
//                    //4.搜索管理员名称
//                    $query->orWhere([['admin.admin_name','like',"%$search%"]]);
//                })
//                ->where(function($query)use($request){//根据时间筛选
//                    if($request->input('mintime')!=null&&$request->input('maxtime')==null){
//                        $query->where('spend.spend_time','>',$request->input('mintime'));
//                    }elseif($request->input('maxtime')!=null&&$request->input('mintime')==null){
//                        $query->where('spend.spend_time','<',$request->input('maxtime'));
//                    }elseif($request->input('maxtime')!=null&&$request->input('mintime')!=null){
//                        $query->whereBetween('spend.spend_time',[$request->input('mintime'),$request->input('maxtime')]);
//                    }
//                })
////                ->where(function($query)use($goods_search){//筛选具体管理员（非root用户只能查看自己花费）
////                    if($goods_search){
////                        $query->where('spend.spend_admin_id',$goods_search);
////                    }
////                })
//                ->orderBy($order,$dsc)
//                ->offset($start)
//                ->limit($len)
//                ->get();

        }else{ //root用户
            //获取总条数
            $newcount=DB::table('goods')
                ->where('is_del','0')
                ->where('goods_heshen','1')
                ->leftjoin('spend','spend.spend_goods_id','=','goods.goods_id')
                ->where(function($query)use($search){
                    //1.搜索单品名称
                    $query->where([['goods.goods_real_name','like',"%$search%"]]);
                    //2.搜索id
                    $query->orWhere([['goods.goods_id','like',"%$search%"]]);
                })
                ->where(function($query)use($goods_search){//筛选具体管理员（非root用户只能查看自己花费）
                    if($goods_search){
                        $query->where('goods.goods_admin_id',$goods_search);
                    }
                })
                ->where(function($query)use($request){//根据时间筛选
                    if($request->input('mintime')!=null&&$request->input('maxtime')==null){
                        $query->where('spend.spend_time','>',$request->input('mintime'));
                    }elseif($request->input('maxtime')!=null&&$request->input('mintime')==null){
                        $query->where('spend.spend_time','<',$request->input('maxtime'));
                    }elseif($request->input('maxtime')!=null&&$request->input('mintime')!=null){
                        $query->whereBetween('spend.spend_time',[$request->input('mintime'),$request->input('maxtime')]);
                    }
                })->count();

            //获取商品ID
            $data = DB::table('goods')
                ->where('is_del','0')
                ->where('goods_heshen','1')
                ->select('goods_id','goods_real_name','goods_up_time')
                ->where(function($query)use($search){
                    //1.搜索单品名称
                    $query->where([['goods_real_name','like',"%$search%"]]);
                    //2.搜索id
                    $query->orWhere([['goods_id','like',"%$search%"]]);
                })
                ->where(function($query)use($goods_search){//筛选具体管理员（非root用户只能查看自己花费）
                    if($goods_search){
                        $query->where('goods.goods_admin_id',$goods_search);
                    }
                })
                ->orderBy($order,$dsc)
                ->offset($start)
                ->limit($len)
                ->get();
            if(!$data->isEmpty()){
                foreach ($data as &$item)
                {
                    //计算单品花费总额
                    $all_goods_money = spend::where('spend_goods_id',$item->goods_id)
                        ->where(function($query)use($request){//根据时间筛选
                            if($request->input('mintime')!=null&&$request->input('maxtime')==null){
                                $query->where('spend.spend_time','>',$request->input('mintime'));
                            }elseif($request->input('maxtime')!=null&&$request->input('mintime')==null){
                                $query->where('spend.spend_time','<',$request->input('maxtime'));
                            }elseif($request->input('maxtime')!=null&&$request->input('mintime')!=null){
                                $query->whereBetween('spend.spend_time',[$request->input('mintime'),$request->input('maxtime')]);
                            }
                        })->get();
                    $goods_spend_money = 0;
                    if(!$all_goods_money->isEmpty()){
                        foreach ($all_goods_money as $val)
                        {
                            $goods_spend_money += $val->spend_money * $val->currency_has_spend->exchange_rate;
                        }
                    }
                    $item->goods_spend_money = $goods_spend_money;
                    //计算单品销售总额
                    $item->goods_money = order::where('order_goods_id',$item->goods_id)->sum('order_price');
                    //商品录入状态（如果从审核通过开始就需要有花费记录，花费记录只记录两日前的花费，如果商品审核通过，没有产生花费，也需要记录花费，为0元）
                    $start_time = strtotime(date('Y-m-d',time()-3600*24).'00:00:00');
                    $end_time = strtotime(date('Y-m-d',strtotime($item->goods_up_time)).'00:00:00');
                    if($start_time > $end_time){
                        $item->goods_status = 1;
                        $length = ($end_time-$start_time)/24*3600;
                        for($i=0; $i<$length; $i++)
                        {
                            $dates = date('Y-m-d',strtotime($item->goods_up_time));
                            if(!spend::where('spend_goods_id',$item->goods_id)->where('spend_time',$dates)->first()){
                                $item->goods_status = 0;
                                break;
                            }
                        }
                    }else{
                        $item->goods_status = 1;
                    }
                }
            }
        }
        $arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>$data];
        return response()->json($arr);
}
      public function add_pay_layer(Request $request)
      {
          if($request->isMethod('get'))
          {//弹出层
            return view('admin.pay.add_pay_layer');
          }elseif($request->isMethod('post'))
          {

          }
      }
}
