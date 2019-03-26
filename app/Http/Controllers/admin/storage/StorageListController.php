<?php

namespace App\Http\Controllers\admin\storage;

use App\channel\skuSDK;
use App\goods;
use App\storage_goods_abroad;
use App\storage_goods_local;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\storage;
use App\order;
use App\config_val;
use App\kind_val;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Validator;

use Illuminate\Support\Facades\Auth;
class StorageListController extends Controller
{
    public function list(Request $request)
    {
    	return view('storage.storage.list');
    }
    public function list_data(Request $request)
    {
    	$page = $request->input('page',1);
        $limit = $request->input('limit',10);
        $start = ($page-1)*$limit;
         //排序参数
        $field = $request->input('field','check_at'); //排序字段
        $dsc = $request->input('order','desc'); //排序顺序
		if($request->has('page')&&$request->has('limit')){
		    	$data=storage::select('storage.*','admin.admin_show_name')
		    	->leftjoin('admin','storage.admin_id','admin.admin_id')
		    	->where('storage.storage_status',1)
                ->where(function($query)use($request){
                    $this->set_query($query,$request);
                })
		    	->offset($start)
		    	->limit($limit)
		    	->orderBy($field, $dsc)
		    	->get();
    		}else{
		        $data=storage::select('storage.*','admin.admin_show_name')
		    	->leftjoin('admin','storage.admin_id','admin.admin_id')
		    	->where('storage.storage_status',1)
                ->where(function($query)use($request){
                    $this->set_query($query,$request);
                })
		    	->orderBy($field, $dsc)
		    	->get();
    		}
        $count=storage::select('storage.*','admin.admin_show_name')
                ->leftjoin('admin','storage.admin_id','admin.admin_id')
                ->where('storage.storage_status',1)
                ->where(function($query)use($request){
                   $this->set_query($query,$request);
                })
                ->count();
    	return json_encode(['code'=>0,'msg'=>'','count'=>$count,'data'=>$data]);
    }

    /**
     * 新增仓库
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_storage(Request $request)
    {
        //新增仓库
        if ($request->isMethod('get')) {
            return view('storage.storage.add_storage');
        } else if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                "storage_name" => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(['err' => '0', 'msg' => $validator->errors()->first()]);
            }
            $storages = storage::where('storage_name',$request->input('storage_name'))->first();
            if($storages){
                return response()->json(['err' => '0', 'msg' => '仓库已存在，请更换仓库名称']);
            }
            $storage = new storage();
            $storage->admin_id = Auth::user()->admin_id; //仓库创建人
            $storage->is_local = $request->input('is_local');
            $storage->is_split = $request->input('is_split');
            $storage->template_type_primary_id = $request->input('template_id');
            $storage->storage_name = $request->input('storage_name');
            $data = $storage->save();
            $ip = $request->getClientIp();
            //添加补货单日志
            operation_log($ip,'新增仓库,仓库名称：'.$request->input('storage_name'),json_encode($request->all()));
            if ($data) {
                return response()->json(['err' => '1', 'msg' => '新增仓库成功']);
            }
            return response()->json(['err' => '0', 'msg' => '新增仓库失败']);
        }
    }

    /**
     * 修改仓库信息
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function up_storage(Request $request){
        //修改仓库信息
        if ($request->isMethod('get')) {
            $id = $request->input('id');
            $storage = storage::where('storage_id',$id)->first();
            if($storage){
                return view('storage.storage.up_storage')->with(compact('storage'));
            }
        } else if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                "storage_name" => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(['err' => '0', 'msg' => $validator->errors()->first()]);
            }
            $storage = storage::where('storage_id',$request->input('id'))->first();
            if(!$storage){
                return response()->json(['err' => '0', 'msg' => '修改仓库信息失败']);
            }
            $storage->is_local = $request->input('is_local');
            $storage->is_split = $request->input('is_split');
            $storage->template_type_primary_id = $request->input('template_id');
            $storage->storage_name = $request->input('storage_name');
            $data = $storage->save();
            $ip = $request->getClientIp();
            //添加补货单日志
            operation_log($ip,'编辑仓库,仓库名称：'.$request->input('storage_name'),json_encode($request->all()));
            if ($data) {
                return response()->json(['err' => '1', 'msg' => '修改仓库信息成功']);
            }
            return response()->json(['err' => '0', 'msg' => '修改仓库信息失败']);
        }
    }

    public function del_storage(Request $request)
    {
    	$msg=storage::where('storage_id',$request->input('id',0))->update(['storage_status'=>0]);
        $ip = $request->getClientIp();
        //添加补货单日志
        operation_log($ip,'禁用仓库,仓库ID：'.$request->input('id',0));
    	if($msg){
    		\Log::notice($request->getClientIp().'禁用了仓库:'.$request->input('id'));
    		return response()->json(['err'=>1,'str'=>'仓库禁用成功！']);
    	}
    	return response()->json(['err'=>0,'str'=>'仓库禁用失败！']);
    }

    /**
     * 仓库数据
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function product_data(Request $request){
        $id = $request->input('id');//仓库ID，如果没有默认本地仓库
        if(!$id){
            $id = storage::where('is_local',1)->first()['storage_id'];
        }
        $stos = storage::all();
        return view('storage.product.index')->with(compact('id','stos'));
    }

    /**
     * 仓库数据列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_table(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $search = trim($request->input('search'));
        //排序参数
        $field = $request->input('field', 'goods_kind_id'); //排序字段
        $dsc = $request->input('order', 'desc'); //排序顺序
        $start = ($page - 1) * $limit;

        $id = $request->input('id', storage::where('is_local',1)->first()['storage_id']);
        $storage = storage::where('storage_id', $id)->first();
        $count = 0;
        if ($storage) {
            if ($storage->is_local == 1) { //本地仓库
                $products = storage_goods_local::join('goods_kind', 'goods_kind.goods_kind_id', '=', 'storage_goods_local.goods_kind_id')
                    ->select('goods_kind.*', DB::Raw('SUM(num) AS num'))
                    ->where(function ($query) use ($request,$search){
                        if($search){
                            $query->where('goods_kind.goods_kind_name','like','%'.$search.'%');
                        }
                    })
                    ->where('storage_goods_local.storage_primary_id', $id)
                    ->groupBy('goods_kind.goods_kind_id')
                    ->orderBy($field, $dsc)
                    ->offset($start)
                    ->limit($limit)
                    ->get();
                $count =  storage_goods_local::join('goods_kind', 'goods_kind.goods_kind_id', '=', 'storage_goods_local.goods_kind_id')
                    ->where(function ($query) use ($request,$search){
                        if($search){
                            $query->where('goods_kind.goods_kind_name','like','%'.$search.'%');
                        }
                    })
                    ->where('storage_goods_local.storage_primary_id', $id)
                    ->groupBy('goods_kind.goods_kind_id')
                    ->count();
            } else { //海外仓库
                $products = storage_goods_abroad::join('goods_kind', 'goods_kind.goods_kind_id', '=', 'storage_goods_abroad.goods_kind_id')
                    ->where(function ($query) use ($request,$search){
                        if($search){
                            $query->where('goods_kind.goods_kind_name','like','%'.$search.'%');
                        }
                    })
                    ->where('storage_goods_abroad.storage_primary_id', $id)
                    ->groupBy('goods_kind.goods_kind_id')
                    ->orderBy($field, $dsc)
                    ->offset($start)
                    ->limit($limit)
                    ->get();
                $count = storage_goods_abroad::join('goods_kind', 'goods_kind.goods_kind_id', '=', 'storage_goods_abroad.goods_kind_id')
                    ->select('goods_kind.*', DB::Raw('SUM(num) AS num'))
                    ->where(function ($query) use ($request,$search){
                        if($search){
                            $query->where('goods_kind.goods_kind_name','like','%'.$search.'%');
                        }
                    })
                    ->where('storage_goods_abroad.storage_primary_id', $id)
                    ->groupBy('goods_kind.goods_kind_id')
                    ->count();
            }
        }else{
            $products = [];
        }
        $arr = ['code' => 0, "msg" => "获取数据成功",'count'=>$count, 'data' => $products];
        return response()->json($arr);
    }

    /**
     * 为构建语句设置搜索条件
     * @param QueryBuilder $query   [语句构建对象]
     * @param Request      $request [description]
     */
    public function set_query(QueryBuilder $query,Request $request)
    {  
         if($request->input('start')!=null){
                $query->whereBetween('created_at',[explode(' - ',$request->input('start'))[0],explode(' - ',$request->input('start'))[1]]);
            }
            if($request->input('out')!=null){
                $query->whereBetween('check_at',[explode(' - ',$request->input('out'))[0],explode(' - ',$request->input('out'))[1]]);
            }
            if($request->input('storage_type')!='#'){
                $query->where('is_local',$request->input('storage_type'));
            }
              if($request->input('search')!=null){
                $query->where('storage.storage_name','like',"%".$request->input('search')."%");
                $query->orWhere('admin.admin_show_name','like',"%".$request->input('search')."%");
            }
    }
    /**
     * 仓库数据小表
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function product_data_smail(Request $request)
    {
        if($request->isMethod('get')){
            $storage_id=$request->input('storage_id',Storage::first()->storage_id);
            $storage=storage::where('storage_id',$storage_id)->first();
            return view('storage.storage.smail_data')->with(compact('storage_id','storage'));
        }else if($request->isMethod('post')){
            $search = $request->input('search');
            //排序参数
            $field = $request->input('field', 'num'); //排序字段
            $dsc = $request->input('order', 'desc'); //排序顺序
            $id = $request->input('id', storage::where('is_local',1)->first()['storage_id']);
            $storage = storage::where('storage_id', $id)->first();
            if ($storage) {
                if ($storage->is_local == 1) { //本地仓库
                    $products = storage_goods_local::join('goods_kind', 'goods_kind.goods_kind_id', '=', 'storage_goods_local.goods_kind_id')
                        ->select('goods_kind.*', DB::Raw('SUM(num) AS num'))
                        ->where('storage_goods_local.storage_primary_id', $id)
                        ->where(function($query)use($search){
                            if($search!=null){
                                $query->where('goods_kind.goods_kind_name','like','%'.$search.'%');
                            }
                        })
                        ->groupBy('goods_kind.goods_kind_id')
                        ->orderBy($field, $dsc)
                        ->get();
                } else { //海外仓库
                    $products = storage_goods_abroad::join('goods_kind', 'goods_kind.goods_kind_id', '=', 'storage_goods_abroad.goods_kind_id')
                        ->select('goods_kind.*', DB::Raw('SUM(num) AS num'))
                        ->where('storage_goods_abroad.storage_primary_id', $id)
                        ->where(function($query)use($search){
                            if($search!=null){
                                $query->where('goods_kind.goods_kind_name','like','%'.$search.'%');
                            }
                        })
                        ->groupBy('goods_kind.goods_kind_id')
                        ->orderBy($field, $dsc)
                        ->get();
                }
            }
            $arr = ['code' => 0, "msg" => "获取数据成功", 'data' => $products];
            return response()->json($arr);
        }
    }

    /**
     * 编辑产品库存
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function up_storage_stock(Request $request)
    {
        if($request->isMethod('get')){
            $id = $request->input('id');//产品ID
            $storage_id = $request->input('storage_id');//库存ID
            return view('storage.product.edit')->with(compact('id','storage_id'));
        }else{
            $storage_id = $request->input('storage_id');//仓库ID
            $num = $request->input('num');//产品数量
            if(!trim($num)){
                $num = 0;
            }
            $four_sku = $request->input('four_sku');
            $last_sku = $request->input('last_sku');
            $storage = storage::where('storage_id', $storage_id)->first();
            if ($storage) {
                if ($storage->is_local == 1) { //本地仓库
                    $products = storage_goods_local::where('sku',$four_sku)
                        ->where('sku_attr',$last_sku)
                        ->where('storage_primary_id', $storage_id)
                        ->update(['num'=>$num]);
                } else { //海外仓库
                    $products = storage_goods_abroad::where('sku',$four_sku)
                        ->where('sku_data',$last_sku)
                        ->where('storage_primary_id', $storage_id)
                        ->update(['num'=>$num]);
                }
                $ip = $request->getClientIp();
                //添加补货单日志
                operation_log($ip,'编辑产品库存数量,仓库名称：'.$storage->storage_name);
                if($products){
                    return response()->json(['err'=>1,'str'=>'修改产品成功！']);
                }else{
                    return response()->json(['err'=>0,'str'=>'修改产品失败！']);
                }
            }else{
                return response()->json(['err'=>0,'str'=>'修改产品数据不存在！']);
            }

        }
    }

    /**
     * 产品库存详情
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storage_stock_show(Request $request)
    {
            $storage_id = $request->input('storage_id');//库存ID
            $id = $request->input('id');//产品ID
            $storage = storage::where('storage_id',$storage_id)->first();
            if($storage){
                if($storage->is_local == 1){
                    $storage_goods = storage_goods_local::join('goods_kind', 'goods_kind.goods_kind_id', '=', 'storage_goods_local.goods_kind_id')
                        ->select('goods_kind.*', 'storage_goods_local.sku', 'storage_goods_local.sku_attr', 'storage_goods_local.num')
                        ->where('storage_primary_id',$storage_id)
                        ->where('storage_goods_local.goods_kind_id',$id)
                        ->get();
                }else{
                    $storage_goods = storage_goods_abroad::join('goods_kind', 'goods_kind.goods_kind_id', '=', 'storage_goods_abroad.goods_kind_id')
                        ->select('goods_kind.*', 'storage_goods_abroad.sku', 'storage_goods_abroad.sku_data as sku_attr', 'storage_goods_abroad.num')
                        ->where('storage_primary_id',$storage_id)
                        ->where('storage_goods_abroad.goods_kind_id',$id)
                        ->get();
                }
                if(!$storage_goods->isEmpty()){
                    $storage_goods = $storage_goods->toArray();
                    foreach ($storage_goods as &$storage_good){
                        $storage_good['goods_sku'] = $storage_good['sku'].$storage_good['sku_attr'];
                        $skuSDK = new skuSDK($storage_good['goods_kind_id'],$storage_good['goods_product_id'],$storage_good['goods_kind_user_type']);
                        $current_attrs = $skuSDK->get_attr_by_sku($storage_good['sku_attr']);
                        $str = '';
                        foreach ($current_attrs as $attr) {
                            $str .= $attr->kind_val_msg .',';
                        }
                        $storage_good['goods_attr'] = rtrim($str,',');
                    }
                }
                $arr = ['code' => 0, "msg" => "获取数据成功", 'data' => $storage_goods];
                return response()->json($arr);
            }else {
                return response()->json(['code' => 0, "msg" => "获取数据成功", 'data' => []]);
            }
    }

    /**
     * 删除产品库存
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function del_storage_stock(Request $request)
    {
        $storage_id = $request->input('storage_id');//库存ID
        $id = $request->input('id');//产品ID
        $storage = storage::where('storage_id',$storage_id)->first();
        if($storage){
            if($storage->is_local == 1){
                $storage_goods = storage_goods_local::where('storage_primary_id',$storage_id)->where('goods_kind_id',$id)->delete();
            }else{
                $storage_goods = storage_goods_abroad::where('storage_primary_id',$storage_id)->where('goods_kind_id',$id)->delete();
            }
            $ip = $request->getClientIp();
            //添加补货单日志
            operation_log($ip,'删除仓库中产品,仓库名称：'.$storage->storage_name);
            if($storage_goods){
                return response()->json(['err'=>1,'str'=>'删除产品成功！']);
            }else{
                return response()->json(['err'=>0,'str'=>'删除产品失败！']);
            }
        }else{
            return response()->json(['err'=>0,'str'=>'抱歉，删除库存产品不存在或已删除！']);
        }
    }
    public function check(Request $request)
    {
        return view('storage.check.check_order');
    }
    public function order_data(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $search = trim($request->input('search'));
        $goods_blade_type=self::get_area($request->input('goods_blade_type'));
        //排序参数
        $field = $request->input('field', 'order_return_time'); //排序字段
        $dsc = $request->input('order', 'desc'); //排序顺序
        $start = ($page - 1) * $limit;
        $orders = order::select('order.order_id','order.order_country', 'order.order_single_id','order.order_type','order.order_return_time','order.order_num','order.order_pay_type','admin.admin_show_name','goods.goods_blade_type')
            ->leftjoin('goods','order.order_goods_id','goods.goods_id')
            ->leftjoin('admin','order.order_admin_id','admin.admin_id')
            ->where(function ($query) use ($request,$search,$goods_blade_type){
                if($search){
                    $query->where('order.order_id','like','%'.$search.'%');
                    $query->orWhere('order.order_single_id','like','%'.$search.'%');
                    $query->orWhere('admin.admin_show_name','like','%'.$search.'%');
                }
                if($request->has('start')&&$request->input('start')!=null){
                    $query->whereBetween('order_return_time',[explode(' - ',$request->input('start'))[0],explode(' - ',$request->input('start'))[1]]);
                }
                if($goods_blade_type!='#'){
                    $query->whereIn('goods.goods_blade_type',$goods_blade_type);
                }
                if($request->has('order_select_type')&&$request->input('order_select_type')!='#'){
                    $query->where('order.order_type',$request->input('order_select_type'));
                }
            })
            ->where(function($query){
                $query->where('order.order_type',1);
                $query->orWhere('order.order_type',3);
            })
            ->where('order.is_del','0')
            ->orderBy($field, $dsc)
            ->offset($start)
            ->limit($limit)
            ->get();
        $count=order::select('order.order_id', 'order.order_single_id','order.order_type','order.order_return_time','order.order_num','order.order_pay_type','admin.admin_show_name','goods.goods_blade_type')
            ->leftjoin('goods','order.order_goods_id','goods.goods_id')
            ->leftjoin('admin','order.order_admin_id','admin.admin_id')
            ->where(function ($query) use ($request,$search,$goods_blade_type){
                if($search){
                    $query->where('order.order_id','like','%'.$search.'%');
                    $query->orWhere('order.order_single_id','like','%'.$search.'%');
                    $query->orWhere('admin.admin_show_name','like','%'.$search.'%');
                }
                if($request->has('start')&&$request->input('start')!=null){
                    $query->whereBetween('order_return_time',[explode(' - ',$request->input('start'))[0],explode(' - ',$request->input('start'))[1]]);
                }
                if($goods_blade_type!='#'){
                    $query->whereIn('goods.goods_blade_type',$goods_blade_type);
                }
                if($request->has('order_select_type')&&$request->input('order_select_type')!='#'){
                    $query->where('order.order_type',$request->input('order_select_type'));
                }
            })
            ->where(function($query){
                $query->where('order.order_type',1);
                $query->orWhere('order.order_type',3);
            })
            ->where('order.is_del','0')
            ->count();
        if($count > 0){
            foreach ($orders as &$order){
                $order->goods_blade_type = goods::get_blade_currency($order->goods_blade_type,$order->order_country);
                $order->is_local = $order->is_local === 1 ? '本地仓库' : '海外仓库';
                $order->order_type = $order->order_type == 1 ? '待扣货': '待出仓';
                $order->order_pay_type = $order->order_pay_type == 0 ? '货到付款' : 'paypal支付';
            }
        }

        $arr = ['code' => 0, "msg" => "获取数据成功",'count'=>$count ,'data' => $orders];
        return response()->json($arr);
    }
    //获取订单地区id
    private static function get_area($blade_id)
    {
        $blade_arr=[
            '#'=>'#',
            1=>['0','1'],
            2=>['2'],
            3=>['3'],
            4=>['4'],
            5=>['5'],
            6=>['6'],
            7=>['7'],
            8=>['8'],
            9=>['9','10'],
            11=>['11'],
            12=>['12','13'],
            14=>['14','15'],
            16=>['16','17']
        ];
        return $blade_arr[$blade_id];
    }
    public function back_order(Request $request)
    {
        $id=$request->input('id');
        $order_msg=\App\order::select('order_return')->where('order_id',$id)->first();
        if($order_msg==null){
           return response()->json(['err' => 0, 'str' => '订单检索失败！']);
        }
        $admin=Auth::user()->admin_name;
        $date=date('Y-m-d H:i:s',time());
        $err=\App\order::where('order_id',$id)->update(['order_type'=>5,'order_return'=>$order_msg['order_return']."<p style='text-align:center'>[".$date."] ".$admin."："."供应驳回"."</p>",'order_return_time'=>$date,'order_admin_id'=>Auth::user()->admin_id]);
        if(!$err){
           return response()->json(['err' => 0, 'str' => '订单驳回失败！']);
        }
        return response()->json(['err' => 1, 'str' => '订单驳回成功！']);
    }

    public function check_order(){
        //$msg=$this->storage_center(false);
        $storage_check=\App\storage_check::orderBy('storage_check_time','desc')->first();
        return view('storage.check.check_order_data')->with(compact('storage_check'));
    }
    //订单扣货信息
    public function check_out(Request $request){
        $id=$request->input('id');
/*        $storage_check_id=\App\storage_check::where('storage_check.storage_check_id',)
*/        $storage_check_data=\App\storage_check::select('storage_check_data.*','storage_check_info.*')
                            ->leftjoin('storage_check_data','storage_check.storage_check_id','storage_check_data.storage_primary_id')
                            ->leftjoin('storage_check_info','storage_check_data.storage_check_data_id','storage_check_info.storage_check_data_id')
                            ->where('storage_check.storage_check_is_out','1')
                            ->whereIn('storage_check_data.storage_check_data_type',['1','2','3'])
                            ->where('storage_check_data.storage_check_data_order',$id)
                            ->get();
        return view('storage.check.check_out')->with(compact('storage_check_data'));
    }
    public function get_check_data(Request $request)
    {   
        $storage_check_id=$request->input('storage_check_id',\App\storage_check::orderBy('storage_check_time','desc')->first(['storage_check_id'])['storage_check_id']);
        $storage_check_data_type=$request->input('storage_check_data_type','#');
        $search = trim($request->input('search'));
        //排序参数
        $field = $request->input('field', 'storage_check_data_order'); //排序字段
        $dsc = $request->input('order', 'desc'); //排序顺序
        //$start = ($page - 1) * $limit;
        $storage_check_data = \App\storage_check_data::select('storage_check_data.*','goods_kind.goods_kind_name','storage.storage_name')
            ->leftjoin('goods_kind','storage_check_data.storage_check_data_sku','goods_kind.goods_kind_sku')
            ->leftjoin('storage','storage_check_data.storage_abroad_id','storage.storage_id')
            ->where(function ($query) use ($search,$storage_check_data_type){
                if($search){
                    $query->where('storage_check_data.storage_check_data_order','like','%'.$search.'%');
                    $query->orWhere('storage_check_data_sku.storage_check_data_sku','like','%'.$search.'%');
                    $query->orWhere('goods_kind.goods_kind_name','like','%'.$search.'%');
                    $query->orWhere('storage.storage_name','like','%'.$search.'%');
                }
                if($storage_check_data_type!='#'){
                    $query->where('storage_check_data.storage_check_data_type',$storage_check_data_type);
                }
            })
            ->where(function($query)use($storage_check_id){
                $query->where('storage_check_data.storage_primary_id',$storage_check_id);
            })
            ->orderBy($field, $dsc)
            ->get();
        $count=\App\storage_check_data::select('storage_check_data.*','goods_kind.goods_kind_name','storage.storage_name')
            ->leftjoin('goods_kind','storage_check_data.storage_check_data_sku','goods_kind.goods_kind_sku')
            ->leftjoin('storage','storage_check_data.storage_abroad_id','storage.storage_id')
            ->where(function ($query) use ($search,$storage_check_data_type){
                if($search){
                    $query->where('storage_check_data.storage_check_data_order','like','%'.$search.'%');
                    $query->orWhere('storage_check_data_sku.storage_check_data_sku','like','%'.$search.'%');
                    $query->orWhere('goods_kind.goods_kind_name','like','%'.$search.'%');
                    $query->orWhere('storage.storage_name','like','%'.$search.'%');
                }
                if($storage_check_data_type!='#'){
                    $query->where('storage_check_data.storage_check_data_type',$storage_check_data_type);
                }
            })
            ->where(function($query)use($storage_check_id){
                $query->where('storage_check_data.storage_primary_id',$storage_check_id);
            })
            ->count();
        if($count > 0){
            foreach ($storage_check_data as &$data){
               if($data->storage_check_data_type==1){
                $data->storage_check_data_type='从海外仓拆分发货';
                $data->storage_name='<span style="color:brown;">'.$data->storage_name.'</span>';
               }elseif($data->storage_check_data_type==2){
                $data->storage_check_data_type='从海外仓不拆分发货';
                $data->storage_name='<span style="color:brown;">'.$data->storage_name.'</span>';
               }elseif($data->storage_check_data_type==3){
                $data->storage_check_data_type='从本地仓发货';
                $data->storage_name='<span style="color:green;">本地仓</span>';
               }elseif($data->storage_check_data_type==4){
                $data->storage_check_data_type='缺货';
                $data->storage_name='<span style="color:red;">缺货</span>';
               }
            }
        }
        $arr = ['code' => 0, "msg" => "获取数据成功",'count'=>$count ,'data' => $storage_check_data];
        return response()->json($arr);
    }
    /**
     * 校准仓储数据
     * @return [type] [description]
     */
    public function reload_storage_check(Request $request){
        //数据校准
        $msg=\App\storage_check::storage_center(true,\Auth::user()->admin_id);
        $ip = $request->getClientIp();
        //添加补货单日志
        operation_log($ip,'进行订单数据校准操作');
        if(!$msg){
           return response()->json(['err' => 0, 'str' => '数据校准失败！系统出现错误或校准操作正在进行中']);
        }
        return response()->json(['err' => 1, 'str' => '数据校准成功！']);
    }
    /**
     * 仓储扣货
     * @return [type] [description]
     */
    public function storage_out(Request $request){
        //数据校准
        $msg=\App\storage_check::storage_center(false,\Auth::user()->admin_id);
        $ip = $request->getClientIp();
        //添加补货单日志
        operation_log($ip,'进行仓库数据扣货操作');
        if(!$msg){
           return response()->json(['err' => 0, 'str' => '订单扣货失败！系统出现错误或扣货操作正在进行中']);
        }
        return response()->json(['err' => 1, 'str' => '订单扣货成功！']);
    }
    /**
     * 数据校准记录
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function check_list(Request $request)
    {
        return view('storage.check.check_list');
    }
    /**
     * 校准数据记录数据接口
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function check_list_data(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $search = trim($request->input('search'));
        $storage_check_is_out=$request->input('storage_check_is_out','#');
        //排序参数
        $field = $request->input('field', 'storage_check_time'); //排序字段
        $dsc = $request->input('order', 'desc'); //排序顺序
        $start = ($page - 1) * $limit;
        $storage_check = \App\storage_check::select('storage_check.*','admin.admin_show_name')
            ->leftjoin('admin','storage_check.storage_check_admin','admin.admin_id')
            ->where(function ($query) use ($request,$search,$storage_check_is_out){
                if($search){
                    $query->where('storage_check.storage_check_id','like','%'.$search.'%');
                    $query->orWhere('storage_check.storage_check_string','like','%'.$search.'%');
                    $query->orWhere('storage_check.storage_check_admin','like','%'.$search.'%');
                }
                if($request->has('start')&&$request->input('start')!=null){
                    $query->whereBetween('storage_check_time',[explode(' - ',$request->input('start'))[0],explode(' - ',$request->input('start'))[1]]);
                }
                if($storage_check_is_out!='#'){
                    $query->where('storage_check.storage_check_is_out',$storage_check_is_out);
                }
                if($request->has('storage_check_type')&&$request->input('storage_check_type')!='#'){
                    $query->where('srorage_cehck.storage_check_type',$request->input('storage_check_type'));
                }
            })
            ->orderBy($field, $dsc)
            ->offset($start)
            ->limit($limit)
            ->get();
        $count=\App\storage_check::select('storage_check.*','admin.admin_show_name')
            ->leftjoin('admin','storage_check.storage_check_admin','admin.admin_id')
            ->where(function ($query) use ($request,$search,$storage_check_is_out){
                if($search){
                    $query->where('storage_check.storage_check_id','like','%'.$search.'%');
                    $query->orWhere('storage_check.storage_check_string','like','%'.$search.'%');
                    $query->orWhere('storage_check.storage_check_admin','like','%'.$search.'%');
                }
                if($request->has('start')&&$request->input('start')!=null){
                    $query->whereBetween('storage_check_time',[explode(' - ',$request->input('start'))[0],explode(' - ',$request->input('start'))[1]]);
                }
                if($storage_check_is_out!='#'){
                    $query->where('storage_check.storage_check_is_out',$storage_check_is_out);
                }
                if($request->has('storage_check_type')&&$request->input('storage_check_type')!='#'){
                    $query->where('srorage_cehck.storage_check_type',$request->input('storage_check_type'));
                }
            })
            ->count();
        if($count > 0){
            foreach ($storage_check as &$v){
                if($v->storage_check_admin==0||$v->storage_check_admin==null){
                    $v->storage_stock_admin='系统发起';
                }
                if($v->storage_check_type==0){
                    $v->storage_check_type='系统定时校对';
                }else{
                     $v->storage_check_type='人工发起校对';
                }
                if($v->storage_check_is_out==0){
                    $v->storage_check_is_out='数据校对';
                }else{
                    $v->storage_check_is_out='<span style="color:red;">仓储扣货</span>';
                }
            }
        }

        $arr = ['code' => 0, "msg" => "获取数据成功",'count'=>$count ,'data' => $storage_check];
        return response()->json($arr);
    }
    /**
     * 校准记录详细数据接口
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function check_list_data_info(Request $request)
    {
        $storage_check_id=$request->input('storage_check_id',\App\storage_check::orderBy('storage_check_time','desc')->first(['storage_check_id'])['storage_check_id']);
        $storage_check_data_type=$request->input('storage_check_data_type','#');
        $search = trim($request->input('search'));
        //排序参数
        $field = $request->input('field', 'storage_check_data_order'); //排序字段
        $dsc = $request->input('order', 'desc'); //排序顺序
        //$start = ($page - 1) * $limit;
        $storage_check_data = \App\storage_check_data::select('storage_check_data.*','goods_kind.goods_kind_name','storage.storage_name')
            ->leftjoin('goods_kind','storage_check_data.storage_check_data_sku','goods_kind.goods_kind_sku')
            ->leftjoin('storage','storage_check_data.storage_abroad_id','storage.storage_id')
            ->where(function ($query) use ($search,$storage_check_data_type){
                if($search){
                    $query->where('storage_check_data.storage_check_data_order','like','%'.$search.'%');
                    $query->orWhere('storage_check_data_sku.storage_check_data_sku','like','%'.$search.'%');
                    $query->orWhere('goods_kind.goods_kind_name','like','%'.$search.'%');
                    $query->orWhere('storage.storage_name','like','%'.$search.'%');
                }
                if($storage_check_data_type!='#'){
                    $query->where('storage_check_data.storage_check_data_type',$storage_check_data_type);
                }
            })
            ->where(function($query)use($storage_check_id){
                $query->where('storage_check_data.storage_primary_id',$storage_check_id);
            })
            ->orderBy($field, $dsc)
            ->get();
        $count=\App\storage_check_data::select('storage_check_data.*','goods_kind.goods_kind_name','storage.storage_name')
            ->leftjoin('goods_kind','storage_check_data.storage_check_data_sku','goods_kind.goods_kind_sku')
            ->leftjoin('storage','storage_check_data.storage_abroad_id','storage.storage_id')
            ->where(function ($query) use ($search,$storage_check_data_type){
                if($search){
                    $query->where('storage_check_data.storage_check_data_order','like','%'.$search.'%');
                    $query->orWhere('storage_check_data_sku.storage_check_data_sku','like','%'.$search.'%');
                    $query->orWhere('goods_kind.goods_kind_name','like','%'.$search.'%');
                    $query->orWhere('storage.storage_name','like','%'.$search.'%');
                }
                if($storage_check_data_type!='#'){
                    $query->where('storage_check_data.storage_check_data_type',$storage_check_data_type);
                }
            })
            ->where(function($query)use($storage_check_id){
                $query->where('storage_check_data.storage_primary_id',$storage_check_id);
            })
            ->count();
        if($count > 0){
            foreach ($storage_check_data as &$data){
               if($data->storage_check_data_type==1){
                $data->storage_check_data_type='从海外仓拆分发货';
                $data->storage_name='<span style="color:brown;">'.$data->storage_name.'</span>';
               }elseif($data->storage_check_data_type==2){
                $data->storage_check_data_type='从海外仓不拆分发货';
                $data->storage_name='<span style="color:brown;">'.$data->storage_name.'</span>';
               }elseif($data->storage_check_data_type==3){
                $data->storage_check_data_type='从本地仓发货';
                $data->storage_name='<span style="color:green;">本地仓</span>';
               }elseif($data->storage_check_data_type==4){
                $data->storage_check_data_type='缺货';
                $data->storage_name='<span style="color:red;">缺货</span>';
               }
            }
        }
        $arr = ['code' => 0, "msg" => "获取数据成功",'count'=>$count ,'data' => $storage_check_data];
        return response()->json($arr);
    }
    /**
     * 校准记录详细数据下单个订单扣货信息接口
     */
    public function check_order_info(Request $request)
    {
        $storage_check_id=$request->input('storage_check_id');
        $order_id=$request->input('order_id');
        $storage_check_data=\App\storage_check::select('storage_check_data.*','storage_check_info.*')
                            ->leftjoin('storage_check_data','storage_check.storage_check_id','storage_check_data.storage_primary_id')
                            ->leftjoin('storage_check_info','storage_check_data.storage_check_data_id','storage_check_info.storage_check_data_id')
                            ->where('storage_check.storage_check_id',$storage_check_id)
                            ->whereIn('storage_check_data.storage_check_data_type',['1','2','3'])
                            ->where('storage_check_data.storage_check_data_order',$order_id)
                            ->get();
        return response()->json($storage_check_data);
        //return view('storage.check.check_out')->with(compact('storage_check_data'));
    }
    /**
     * 货物出库视图
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function storage_split(Request $request)
    {
        return view('storage.check.storage_split');
    }
}
