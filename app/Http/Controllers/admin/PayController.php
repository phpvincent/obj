<?php

namespace App\Http\Controllers\Admin;

use App\ad_info;
use App\currency_type;
use App\goods;
use App\order;
use App\spend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayController extends Controller
{
    /** 花费首页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
                    $item->goods_spend_money = sprintf("%.2f",$goods_spend_money);
                    //计算单品销售总额
                    $item->goods_money = sprintf("%.2f",order::where('order_goods_id',$item->goods_id)->sum('order_price'));
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
                    $item->goods_spend_money =  sprintf("%.2f",$goods_spend_money);
                    //计算单品销售总额
                    $item->goods_money = sprintf("%.2f",order::where('order_goods_id',$item->goods_id)->sum('order_price'));
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

    /** 添加商品花费
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
      public function add_spend(Request $request)
      {
          if($request->isMethod('get'))
          {//弹出层
              $currency_type  = currency_type::all();
              $id = $request->input('id');//商品ID
              return view('admin.pay.add_pay_layer')->with(compact('currency_type','id'));
          }elseif($request->isMethod('post'))
          {
              $data = $request->except('_token');
              $spend = new spend();
              $spend->spend_goods_id = $data['spend_goods_id'];
              $spend->spend_time = $data['create_time'];
              $spend->spend_currency_id = $data['spend_currency_id'];
              $spend->spend_money = $data['spend_money'];
              $spend->spend_platform = $data['spend_platform'];
              $spend->spend_admin_id = goods::where('goods_id',$data['spend_goods_id'])->value('goods_admin_id');
              $spend->create_time = date('Y-m-d H:i:s');
              $spend->is_impload = '1';
              $spend_save = $spend->save();
              if($spend_save){
                  return response()->json(['err'=>'1','msg'=>'新增花费成功']);
              }
              return response()->json(['err'=>'0','msg'=>'新增花费失败']);
          }
      }

    /**
     * 添加广告编号
     */
    public function add_pay_number(Request $request)
    {
        if($request->isMethod('get'))
        {//弹出层
            $currency_type  = currency_type::all();
            $id = $request->input('id');//商品ID
            return view('admin.pay.add_pay_number')->with(compact('currency_type','id'));
        }elseif($request->isMethod('post'))
        {
            $data = $request->except('_token');
            $pay_number = ad_info::insert($data);
            if($pay_number){
                return response()->json(['err'=>'1','msg'=>'新增广告编号成功']);
            }
            return response()->json(['err'=>'0','msg'=>'新增广告编号失败']);
        }
    }


    /** 花费上传查询
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function spend_entry(Request $request)
    {
        //判断是否上传付费
        $id = $request->input('id');//商品ID
        $goods = goods::where('goods_id',$id)->first();
        if(!$goods){
            return response()->json(['err'=>'0','msg'=>'商品未找到']);
        }
        $goods_up_time = substr($goods->goods_up_time,0,10);
        $stamp = strtotime($goods->goods_up_time);//录入商品时间戳
        $startTime = date('Y-m-d',$stamp);
        $time = strtotime($startTime.' 00:00:00');//花费开始时间
        $newtime = strtotime(date('Y-m-d').' 00:00:00');//今天时间
        //1. 花费必须两天以前才可以添加
        $day = ($newtime-$time)/3600/24;
        $spend_entry = [];//存储未录入花费时间
        if($day >= 2){
            for ($i = 0; $i <= $day-2; $i++)
            {
                $spendTime = date('Y-m-d',$stamp + 3600*24*$i);
                $isEntry = spend::where('spend_goods_id',$id)->where('spend_time',$spendTime)->first();
                if(!$isEntry){
                    array_push($spend_entry,$spendTime);
                }
            }
        }

        return response()->json(['err'=>'1','spend_entry'=>$spend_entry,'goods_up_time'=>$goods_up_time,'msg'=>'查询成功']);
    }

    public function spend_show(Request $request)
    {
        $id = $request->input('id');//商品id
        return view('admin.pay.spend_show')->with(compact('id'));
    }

    public function get_show_table(Request $request){
        $id = $request->input('id');
        $time = $request->input('time');
        $spends = spend::where('spend_goods_id',$id)->where('spend_time',$time)->get();
        if(!$spends->isEmpty()){
            $spends = $spends->toArray();
            foreach ($spends as &$item)
            {
                $item['is_impload']  = $item['is_impload'] == 1 ? "手动" : "导入";
                switch ($item['spend_platform']){
                    case '1':
                        $item['spend_platform'] = '雅虎';
                        break;
                    case '2':
                        $item['spend_platform'] = '谷歌';
                        break;
                    case '3':
                        $item['spend_platform'] = 'FB';
                        break;
                }
                $item['spend_currency'] = currency_type::where('currency_type_id',$item['spend_currency_id'])->value('currency_type_name');
            }
        }
        return response()->json($spends);
    }
    /** 删除商品花费
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
      public function del_spend(Request $request)
      {
          return response()->json(['err'=>1,'str'=>'删除成功']);
      }
}
