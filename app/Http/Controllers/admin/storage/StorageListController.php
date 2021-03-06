<?php

namespace App\Http\Controllers\admin\storage;

use App\channel\skuSDK;
use App\goods;
use App\goods_kind;
use App\order_config;
use App\storage_check_data;
use App\storage_goods_abroad;
use App\storage_goods_local;
use App\storage_log;
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
        return response()->json(['code'=>0,'msg'=>'获取数据成功','count'=>$count,'data'=>$data]);
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
            if($request->input('is_local') == 1){
                $template_type = storage::where('is_local',$request->input('is_local'))->first();
            }else{
                $template_type = storage::where('template_type_primary_id',$request->input('template_id'))->first();
            }
            if($template_type){
                return response()->json(['err' => '0', 'msg' => '每个地区只能存在一个仓库，请更换地区或联系管理员']);
            }
            $storage = new storage();
            $storage->admin_id = Auth::user()->admin_id; //仓库创建人
            $storage->is_local = $request->input('is_local');
            $storage->is_split = $request->input('is_split');
            $storage->template_type_primary_id = $request->input('template_id');
            $storage->storage_name = $request->input('storage_name');
            $data = $storage->save();
            $ip = $request->getClientIp();
            $storage_log = ['storage_log_type'=>3,'storage_log_operate_type'=>0,'storage_log_admin_id'=>Auth::user()->admin_id,'is_danger'=>0];
            //添加补货单日志
            operation_log($ip,'新增仓库,仓库名称：'.$request->input('storage_name'),json_encode($request->all()));
            if ($data) {
                $datass = ['storage_id'=>$storage->storage_id,'storage_name'=>$request->input('storage_name'),'remarks'=>'新增仓库','is_success'=>1];
                storage_log::insert_log($storage_log,serialize($datass));
                return response()->json(['err' => '1', 'msg' => '新增仓库成功']);
            }
            $datass = ['storage_id'=>$storage->storage_id,'storage_name'=>$request->input('storage_name'),'remarks'=>'新增仓库','is_success'=>0];
            storage_log::insert_log($storage_log,serialize($datass));
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
            $storage_log = ['storage_log_type'=>3,'storage_log_operate_type'=>2,'storage_log_admin_id'=>Auth::user()->admin_id,'is_danger'=>0];
            //添加补货单日志
            operation_log($ip,'编辑仓库,仓库名称：'.$request->input('storage_name'),json_encode($request->all()));
            if ($data) {
                $datass = ['storage_id'=>$storage->storage_id,'storage_name'=>$request->input('storage_name'),'remarks'=>'编辑仓库','is_success'=>1];
                storage_log::insert_log($storage_log,serialize($datass));
                return response()->json(['err' => '1', 'msg' => '修改仓库信息成功']);
            }
            $datass = ['storage_id'=>$storage->storage_id,'storage_name'=>$request->input('storage_name'),'remarks'=>'编辑仓库','is_success'=>0];
            storage_log::insert_log($storage_log,serialize($datass));
            return response()->json(['err' => '0', 'msg' => '修改仓库信息失败']);
        }
    }

    public function del_storage(Request $request)
    {
    	$msg=storage::where('storage_id',$request->input('id',0))->update(['storage_status'=>0]);
        $ip = $request->getClientIp();
        $storage_log = ['storage_log_type'=>3,'storage_log_operate_type'=>1,'storage_log_admin_id'=>Auth::user()->admin_id,'is_danger'=>1];
        //添加补货单日志
        operation_log($ip,'禁用仓库,仓库ID：'.$request->input('id',0));
    	if($msg){
            $datass = ['storage_id'=>$request->input('id',0),'storage_name'=>storage::where('storage_id',$request->input('id',0))->first()['storage_name'],'remarks'=>'禁用仓库','is_success'=>1];
            storage_log::insert_log($storage_log,serialize($datass));
    		\Log::notice($request->getClientIp().'禁用了仓库:'.$request->input('id'));
    		return response()->json(['err'=>1,'str'=>'仓库禁用成功！']);
    	}
        $datass = ['storage_id'=>$request->input('id',0),'storage_name'=>storage::where('storage_id',$request->input('id',0))->first()['storage_name'],'remarks'=>'禁用仓库','is_success'=>0];
        storage_log::insert_log($storage_log,serialize($datass));
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

        $id = $request->input('id', storage::where('is_local', 1)->first()['storage_id']);
        $storage = storage::where('storage_id', $id)->first();
        $count = 0;
        if (!$storage) return response()->json(['code' => 0, "msg" => "获取数据成功", 'count' => $count, 'data' => []]);
        if ($request->input('storage_status') == 0) { //真实库存
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
                    $products_count = storage_goods_local::join('goods_kind', 'goods_kind.goods_kind_id', '=', 'storage_goods_local.goods_kind_id')
                        ->select('goods_kind.*', DB::Raw('SUM(num) AS num'))
                        ->where(function ($query) use ($request,$search){
                            if($search){
                                $query->where('goods_kind.goods_kind_name','like','%'.$search.'%');
                            }
                        })
                        ->where('storage_goods_local.storage_primary_id', $id)
                        ->groupBy('goods_kind.goods_kind_id')
                        ->get();
                    $count = count($products_count);
            } else { //海外仓库
                $products = storage_goods_abroad::join('goods_kind', 'goods_kind.goods_kind_id', '=', 'storage_goods_abroad.goods_kind_id')
                    ->where(function ($query) use ($request,$search){
                        if($search){
                            $query->where('goods_kind.goods_kind_name','like','%'.$search.'%');
                        }
                    })
                    ->select('goods_kind.*', DB::Raw('SUM(num) AS num'))
                    ->where('storage_goods_abroad.storage_primary_id', $id)
                    ->groupBy('goods_kind.goods_kind_id')
                    ->orderBy($field, $dsc)
                    ->offset($start)
                    ->limit($limit)
                    ->get();
                $products_count = storage_goods_abroad::join('goods_kind', 'goods_kind.goods_kind_id', '=', 'storage_goods_abroad.goods_kind_id')
                    ->where(function ($query) use ($request,$search){
                        if($search){
                            $query->where('goods_kind.goods_kind_name','like','%'.$search.'%');
                        }
                    })
                    ->select('goods_kind.*', DB::Raw('SUM(num) AS num'))
                    ->where('storage_goods_abroad.storage_primary_id', $id)
                    ->groupBy('goods_kind.goods_kind_id')
                    ->get();
                $count = count($products_count);
            }
        }else{ //预扣货
            if ($storage->is_local == 1) { //本地仓库
                    $products = order::join('goods', 'goods.goods_id', '=', 'order.order_goods_id')
                        ->join('storage_check_data','storage_check_data.storage_check_data_order','=','order.order_id')
                        ->join('goods_kind', 'goods_kind.goods_kind_id', '=', 'goods.goods_kind_id')
                        ->select('goods_kind.*', DB::Raw('SUM(order_num) AS num'))
                        ->where('storage_check_data.storage_abroad_id','#')
                        ->where('order.order_type', '3')
                        ->groupBy('goods_kind.goods_kind_id')
                        ->orderBy($field, $dsc)
                        ->offset($start)
                        ->limit($limit)
                        ->get();
                    $counts = order::join('goods', 'goods.goods_id', '=', 'order.order_goods_id')
                        ->join('storage_check_data','storage_check_data.storage_check_data_order','=','order.order_id')
                        ->join('goods_kind', 'goods_kind.goods_kind_id', '=', 'goods.goods_kind_id')
                        ->select('goods_kind.goods_kind_id', DB::Raw('SUM(order_num) AS num'))
                        ->where('storage_check_data.storage_abroad_id','#')
                        ->where('order.order_type', '3')
                        ->groupBy('goods_kind.goods_kind_id')
                        ->get();
                    $count = count($counts);
            }else{ //海外仓
                $products = order::join('goods', 'goods.goods_id', '=', 'order.order_goods_id')
                    ->join('storage_check_data','storage_check_data.storage_check_data_order','=','order.order_id')
                    ->join('goods_kind', 'goods_kind.goods_kind_id', '=', 'goods.goods_kind_id')
                    ->select('goods_kind.*', DB::Raw('SUM(order_num) AS num'))
                    ->where('storage_check_data.storage_abroad_id',$id)
                    ->where('order.order_type', '3')
                    ->groupBy('goods_kind.goods_kind_id')
                    ->orderBy($field, $dsc)
                    ->offset($start)
                    ->limit($limit)
                    ->get();
                $counts = order::join('goods', 'goods.goods_id', '=', 'order.order_goods_id')
                    ->join('storage_check_data','storage_check_data.storage_check_data_order','=','order.order_id')
                    ->join('goods_kind', 'goods_kind.goods_kind_id', '=', 'goods.goods_kind_id')
                    ->select('goods_kind.goods_kind_id', DB::Raw('SUM(order_num) AS num'))
                    ->where('storage_check_data.storage_abroad_id',$id)
                    ->where('order.order_type', '3')
                    ->groupBy('goods_kind.goods_kind_id')
                    ->get();
                $count = count($counts);
            }
        }
//            if(!$products->isEmpty()){ //仓库数据不为空  仓库数据+预发货订单数据
//                foreach ($products as &$product){
//                    $goods_ids = goods::where('goods_kind_id',$product->goods_kind_id)->pluck('goods_id')->toArray();
//                    $orders = order::select(DB::Raw('SUM(order_num) AS num'))->whereIn('order_goods_id',$goods_ids)->where('order_type','3')->get();
//                    if($orders){
//                        $product->num += $orders[0]->num;
//                    }
//                }
//            }
            //TODO 选择出库仓库
//            if($count <= 0){ //仓库数据为空
//                $products = order::join('goods','goods.goods_id','=','order.order_goods_id')
//                    ->join('goods_kind','goods_kind.goods_kind_id','=','goods.goods_kind_id')
//                    ->select('goods_kind.*',DB::Raw('SUM(order_num) AS num'))
//                    ->where('order.order_type','3')
//                    ->groupBy('goods_kind.goods_kind_id')
//                    ->orderBy($field, $dsc)
//                    ->offset($start)
//                    ->limit($limit)
//                    ->get();
//                $counts =  order::join('goods','goods.goods_id','=','order.order_goods_id')
//                    ->leftjoin('goods_kind','goods_kind.goods_kind_id','=','goods.goods_kind_id')
//                    ->select('goods_kind.goods_kind_id',DB::Raw('SUM(order_num) AS num'))
//                    ->where('order.order_type','3')
//                    ->groupBy('goods_kind.goods_kind_id')
//                    ->get();
//                $count = count($counts);
//            }
        return response()->json(['code' => 0, "msg" => "获取数据成功",'count'=>$count, 'data' => $products]);
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
                $storage_log = ['storage_log_type'=>2,'storage_log_operate_type'=>2,'storage_log_admin_id'=>Auth::user()->admin_id,'is_danger'=>1];

                //添加补货单日志
                operation_log($ip,'编辑产品库存数量,仓库名称：'.$storage->storage_name);
                $goods_kind = goods_kind::where('goods_kind_sku',$four_sku)->first();
                if($products){
                    $data = ['remarks'=>'编辑产品库存数量','goods_id'=>$goods_kind->goods_kind_id,'goods_kind_name'=>$goods_kind->goods_kind_name,'storage_id'=>$storage_id,'storage_name'=>$storage->storage_name,'is_success'=>1];
                    //记录补货日志
                    $storage_log_data = storage_log::insert_log($storage_log,serialize($data));
                    if(!$storage_log_data) return response()->json(['err' => '0', 'msg' => '订单退货失败']);
                    return response()->json(['err'=>1,'str'=>'修改产品成功！']);
                }else{
                    $data = ['remarks'=>'编辑产品库存数量','goods_id'=>$goods_kind->goods_kind_id,'goods_kind_name'=>$goods_kind->goods_kind_name,'storage_id'=>$storage_id,'storage_name'=>$storage->storage_name,'is_success'=>0];
                    //记录补货日志
                    $storage_log_data = storage_log::insert_log($storage_log,serialize($data));
                    if(!$storage_log_data) return response()->json(['err' => '0', 'msg' => '订单退货失败']);
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
                        if($storage_good['sku_attr'] != '000000'){
                            $skuSDK = new skuSDK($storage_good['goods_kind_id'],$storage_good['goods_product_id'],$storage_good['goods_kind_user_type']);
                            $current_attrs = $skuSDK->get_attr_by_sku($storage_good['sku_attr']);
                            $str = '';
                            if(count($current_attrs) > 0){
                                foreach ($current_attrs as $attr) {
                                    if($attr){
                                        $str .= $attr->kind_val_msg .',';
                                    }
                                }
                            }
                            $storage_good['goods_attr'] = rtrim($str,',');
                        }else{
                            $storage_good['goods_attr'] = '';
                        }

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
            $storage_log = ['storage_log_type'=>2,'storage_log_operate_type'=>1,'storage_log_admin_id'=>Auth::user()->admin_id,'is_danger'=>1];
            $ip = $request->getClientIp();
            //添加补货单日志
            operation_log($ip,'删除仓库中产品,仓库名称：'.$storage->storage_name);
            $goods_kind = goods_kind::where('goods_kind_id',$id)->first();
            if($storage_goods){
                $data = ['remarks'=>'删除仓库中产品','goods_id'=>$id,'goods_kind_name'=>$goods_kind->goods_kind_name,'storage_id'=>$storage_id,'storage_name'=>$storage->storage_name,'is_success'=>1];
                //记录补货日志
                $storage_log_data = storage_log::insert_log($storage_log,serialize($data));
                if(!$storage_log_data) return response()->json(['err' => '0', 'msg' => '订单退货失败']);
                return response()->json(['err'=>1,'str'=>'删除产品成功！']);
            }else{
                $data = ['remarks'=>'删除仓库中产品','goods_id'=>$id,'goods_kind_name'=>$goods_kind->goods_kind_name,'storage_id'=>$storage_id,'storage_name'=>$storage->storage_name,'is_success'=>1];
                //记录补货日志
                storage_log::insert_log($storage_log,serialize($data));
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
            ->where('order.order_time','>','2019-4-1 00:00:00')
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
            ->where('order.order_time','>','2019-4-1 00:00:00')
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
        $order_msg=\App\order::select('order_return')->where([['order_id',$id],['order_time','>','2019-4-1 00:00:00']])->first();
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
                    $query->where('storage_check.storage_check_type',$request->input('storage_check_type'));
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
                    $query->where('storage_check.storage_check_type',$request->input('storage_check_type'));
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

        $storage_check_data=\App\storage_check_data::where([['storage_primary_id',$storage_check_id],['storage_check_data_order',$order_id]])->first();
        $storage_check_string=\App\storage_check::where('storage_check_id',$storage_check_data->storage_primary_id)->first(['storage_check_string'])['storage_check_string'];
        $storage_check_data_id=$storage_check_data->storage_check_data_id;
        $storage_check_info=\App\storage_check_info::where('storage_check_data_id',$storage_check_data_id)->get();
        if($storage_check_data->storage_abroad_id=='#'||$storage_check_data->storage_abroad_id==null){
            if($storage_check_data->storage_check_data_type=='4'){
                $storage_name='<span style="color:red;">缺货</span>';
            }elseif($storage_check_data->storage_check_data_type=='3'){
                $storage_name=\App\storage::where([['storage_status','1'],['is_local','1']])->first(['storage_name'])['storage_name'];
            }
        }else{
                $storage_name=\App\storage::where('storage_id',$storage_check_data->storage_abroad_id)->first(['storage_name'])['storage_name'];
        }
        $storage_check_data_num=$storage_check_data->storage_check_data_num;
        $storage_check_data_sku=$storage_check_data->storage_check_data_sku;
        $storage_check_data_order=$storage_check_data->storage_check_data_order;
        foreach($storage_check_info as $k =>&$v){
            $v->storage_name=$storage_name;
            $v->storage_check_string=$storage_check_string;
            $v->storage_check_data_num=$storage_check_data_num;
            $v->storage_check_data_sku=$storage_check_data_sku;
            $v->storage_check_data_order=$storage_check_data_order;
        }
        return response()->json($storage_check_info);
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
    /**
     * 货物出仓接口
     */
    public function out_data(Request $request){
        if($request->isMethod('get')){
            $page = $request->input('page', 1);
            $limit = $request->input('limit', 10);
            $order_blade_type=$request->input('order_blade_type','#');
            $search = trim($request->input('out_search'));
            //排序参数
            $field = $request->input('field', 'order_id'); //排序字段
            $dsc = $request->input('order', 'desc'); //排序顺序
            $start = ($page - 1) * $limit;
            $orders = \App\order::select('order.order_id','order.order_single_id','goods.goods_blade_type','goods_kind.goods_kind_name','goods_kind.goods_kind_sku','order.order_country')
                ->leftjoin('goods','order.order_goods_id','goods.goods_id')
                ->leftjoin('goods_kind','goods.goods_kind_id','goods_kind.goods_kind_id')
                ->where(function ($query) use ($search,$order_blade_type){
                    if($search){
                        $query->where('goods_kind.goods_kind_name','like','%'.$search.'%');
                        $query->where('goods_kind.goods_kind_sku','like','%'.$search.'%');
                        $query->orWhere('order.order_id','like','%'.$search.'%');
                        $query->orWhere('order.order_single_id','like','%'.$search.'%');
                    }
                    if($order_blade_type!='#'){
                        $query->where('goods.goods_blade_type',$order_blade_type);
                    }
                })
                ->where('order.order_type','3')
                ->where('order.is_del','0')
                ->where('order.order_time','>','2019-4-1 00:00:00')
                ->orderBy($field, $dsc)
                ->offset($start)
                ->limit($limit)
                ->get();
            $count=\App\order::select('order.order_id','order.order_single_id','goods.goods_blade_type','goods_kind.goods_kind_name','goods_kind.goods_kind_sku')
                ->leftjoin('goods','order.order_goods_id','goods.goods_id')
                ->leftjoin('goods_kind','goods.goods_kind_id','goods_kind.goods_kind_id')
                ->where(function ($query) use ($search,$order_blade_type){
                    if($search){
                        $query->where('goods_kind.goods_kind_name','like','%'.$search.'%');
                        $query->where('goods_kind.goods_kind_sku','like','%'.$search.'%');
                        $query->orWhere('order.order_id','like','%'.$search.'%');
                        $query->orWhere('order.order_single_id','like','%'.$search.'%');
                    }
                    if($order_blade_type!='#'){
                        $query->where('goods.goods_blade_type',$order_blade_type);
                    }
                })
                ->where('order.order_type','3')
                ->where('order.is_del','0')
                ->where('order.order_time','>','2019-4-1 00:00:00')
                ->count();
            if($count > 0){
                foreach ($orders as &$data){
                  $data->goods_blade_type=\App\goods::get_blade_currency($data->goods_blade_type,$data->order_country);
                }
            }
            $arr = ['code' => 0, "msg" => "获取数据成功",'count'=>$count ,'data' => $orders];
            return response()->json($arr);
        }elseif($request->isMethod('post')){
            if($request->input('ids',null)!=null){
                $msg=true;
                try{
                    foreach($request->input('ids') as $k => $v){
                        $order=\App\order::where([['order_id',$v],['order.order_time','>','2019-4-1 00:00:00']])->first();
                        //更新库存出仓时间
                        $storage_id=\App\storage_check::get_area_by_goods_id($order->order_goods_id,false);
                        \App\storage::where([['storage_id',$storage_id],['storage_status',1]])->update(['check_at'=>date('Y-m-d H:i:s')]);
                         
                        $order->order_type='4';
                        $order->order_return=$order->order_return."<p style='text-align:center'>[".date('Y-m-d H:i:s')."] ".\Auth::user()->admin_name."：订单出仓</p>";
                        $order->save();
                    }
                }catch(\Exception $e){
                    $msg=false;
                }
                //$msg=\App\order::whereIn('order_id',$request->input('ids'))->update(['order_type'=>'4']);
                $ip = $request->getClientIp();
                //添加补货单日志
                operation_log($ip,'进行订单出库操作');
                
            }

            if(!isset($msg)||$msg==false){
                //增加操作记录日志
                $arr=['storage_log_type'=>6,'storage_log_operate_type'=>2,'is_danger'=>1,'storage_log_admin_id'=>\Auth::user()->admin_id];
                $data=['is_success'=>0];
                \App\storage_log::insert_log($arr,serialize($data));
                  return response()->json(['err' => 0, 'str' => '订单出库失败！']);
            }
             //增加操作记录日志
                $arr=['storage_log_type'=>6,'storage_log_operate_type'=>2,'is_danger'=>1,'storage_log_admin_id'=>\Auth::user()->admin_id];
                $data=['is_success'=>1,'order_ids'=>$request->input('ids')];
                \App\storage_log::insert_log($arr,serialize($data));
            return response()->json(['err' => 1, 'str' => '订单出库成功！']);
        }
    }
    /**
     * 缺货数据接口
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function data_less(Request $request)
    {
            $page = $request->input('page', 1);
            $limit = $request->input('limit', 10);
            $storage_check_id=$request->input('storage_check_id');
            $search = trim($request->input('search'));
            //排序参数
            $field = $request->input('field', 'storage_check_lack_num'); //排序字段
            $dsc = $request->input('order', 'desc'); //排序顺序
            $start = ($page - 1) * $limit;
            $less=\App\storage_check_lack::select('storage_check_lack.*','goods_kind.goods_kind_name')
                 ->leftjoin('goods_kind','storage_check_lack.storage_check_lack_sku','goods_kind.goods_kind_sku')
                 ->where(function($query)use($search){
                    if($search!=null){
                    $query->where('goods_kind.goods_kind_id','like','%'.$search.'%');
                    $query->where('goods_kind.goods_kind_name','like','%'.$search.'%');
                    $query->where('storage_check_lack.storage_check_lack_six_sku','like','%'.$search.'%');
                    $query->where('storage_check_lack.storage_check_lack_sku','like','%'.$search.'%');
                    }
                 })
                 ->where('storage_check_lack.storage_check_lack_primary_id',$storage_check_id)
                 ->get();
            $count=\App\storage_check_lack::select('storage_check_lack.*','goods_kind.goods_kind_name')
                 ->leftjoin('goods_kind','storage_check_lack.storage_check_lack_sku','goods_kind.goods_kind_sku')
                 ->where(function($query)use($search){
                    if($search!=null){
                    $query->where('goods_kind.goods_kind_id','like','%'.$search.'%');
                    $query->where('goods_kind.goods_kind_name','like','%'.$search.'%');
                    $query->where('storage_check_lack.storage_check_lack_six_sku','like','%'.$search.'%');
                    $query->where('storage_check_lack.storage_check_lack_sku','like','%'.$search.'%');
                    }
                 })
                 ->where('storage_check_lack.storage_check_lack_primary_id',$storage_check_id)
                 ->count();
           /* if($count > 0){
                foreach ($orders as &$data){
                  $data->goods_blade_type=\App\goods::get_blade_currency($data->goods_blade_type,$data->order_country);
                }
            }*/
            $arr = ['code' => 0, "msg" => "获取数据成功",'count'=>$count ,'data' => $less];
            return response()->json($arr);
    }
    /**
     * 缺货单导出
     */
    public function data_out(Request $request)
    {
        $storage_check_id=$request->input('storage_check_id',\App\storage_check::select('storage_check_id')->where('storage_check_is_out','1')->orderBy('storage_check_time','desc')->first()['storage_check_id']);
        //增加操作记录日志
        $arr=['storage_log_type'=>5,'storage_log_operate_type'=>3,'is_danger'=>0,'storage_log_admin_id'=>\Auth::user()->admin_id];
        $data=['is_success'=>1,'storage_check_id'=>$storage_check_id];
        \App\storage_log::insert_log($arr,serialize($data));
        //订单导出
        return \App\storage::order_out($storage_check_id);
    }

    /**
     * 订单退货
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function return_goods(Request $request)
    {
        if($request->isMethod('get')){
            $orders = order::where('is_del','0')->where(function ($query){
                $query->where('order_type','1');
                $query->orWhere('order_type','3');
                $query->orWhere('order_type','4');
            })->pluck('order_single_id','order_id')->toArray();
            $storage = storage::where('storage_id',$request->input('id'))->first();
            if($storage){
                return view('storage.storage.return_goods')->with(compact('storage','orders'));
            }
        }else{
            $data = $request->all();
            $order = order::where('order_id',$data['order_id'])->first();
            if($order->order_type){
                $oldmsg = $order->order_return;
                $date = date('Y-m-d H:i:s',time());
                $admin = Auth::user()->admin_name;
                $htmlnow = $oldmsg."<p style='text-align:center'>[".$date."] ".$admin."：".$data['remarks']."</p>";
                $order->order_type = 6;
                $order->order_return = $htmlnow;
                $order_data = $order->save();
                if($order_data) return response()->json(['err' => 1, 'str' => '订单退货成功！']);
                return response()->json(['err' => 0, 'str' => '订单退货失败！']);
            }
            $goods_kind_id = goods::where('goods_kind_id',$order->order_goods_id)->first()['goods_kind_id'];
            $goods_kind = goods_kind::where('goods_kind_id',$goods_kind_id)->first();
            if($express_delivery = trim($data['express_delivery'])){
                $order->order_send = $express_delivery;
            }
            $order_configs = order_config::where('order_primary_id',$data['order_id'])->get();
            $expiry_at = date('Y-m-d H:i:s',time()+$data['expiry_at']*3600*24);
            if($order_configs->isEmpty()){
                $storage_goods_array = ['storage_primary_id'=>$data['storage_id'],'num'=>$order->order_num,'sku'=>$goods_kind->goods_kind_sku,'sku_data'=>'000000','goods_kind_id'=>$goods_kind_id,'order_id'=>$data['order_id'],'expiry_at'=>$expiry_at,'express_delivery'=>$order->order_send];
                $storage_goods_abroad = DB::table('storage_goods_abroad')->insert($storage_goods_array);
                if(!$storage_goods_abroad) return response()->json(['err' => 0, 'str' => '订单退货失败！']);
            }else{
                $order_data_array = []; //存储每个sku的个数
                $order_configs_arr = [];
                foreach ($order_configs as $order_config){
                    if(in_array($order_config->order_config,$order_configs_arr)){
                        $order_data_array['$order_config->order_config']++;
                    }else{
                        $order_data_array['$order_config->order_config'] = 1;
                    }
                }
                foreach ($order_configs as $order_config){
                    $order_config_datas = explode(',',$order_config->order_config);
                    $config_val_str = '';
                    foreach ($order_config_datas as $order_config_data){
                        $config_val_str .=  config_val::where('config_val_id',$order_config_data)->first()['kind_val_id'];
                    }
                    $skuSDK = new skuSDK($goods_kind_id,$goods_kind->goods_product_id,$goods_kind->goods_kind_user_type);
                    $current_attrs = $skuSDK->get_all_sku($config_val_str); //获取后六位sku
                    $storage_goods_array = ['storage_primary_id'=>$data['storage_id'],'order_single'=>$order->order_single_id,'num'=>$order_data_array['$order_config->order_config'],'sku'=>$goods_kind->goods_kind_sku,'sku_data'=>substr($current_attrs,-6),'goods_kind_id'=>$goods_kind_id,'order_id'=>$data['order_id'],'expiry_at'=>$expiry_at,'express_delivery'=>$order->order_send];
                    $storage_goods_abroad = DB::table('storage_goods_abroad')->insert($storage_goods_array);
                    if(!$storage_goods_abroad) return response()->json(['err' => 0, 'str' => '订单退货失败！']);
                }
            }

            $oldmsg = $order->order_return;
            $date = date('Y-m-d H:i:s',time());
            $admin = Auth::user()->admin_name;
            $htmlnow = $oldmsg."<p style='text-align:center'>[".$date."] ".$admin."：".$data['remarks']."</p>";
            $order->order_type = 6;
            $order->order_return = $htmlnow;
            $order_data = $order->save();
            $storage_log = ['storage_log_type'=>7,'storage_log_operate_type'=>0,'storage_log_admin_id'=>Auth::user()->admin_id,'is_danger'=>0];
            //记录补货日志
            if(!$order_data) {
                $data = ['order_id'=>$data['order_id'],'order_single'=>$order->order_single_id,'status'=>2,'remarks'=>'订单退货','storage_id'=>$data['storage_id'],'storage_name'=>storage::where('storage_id',$data['storage_id'])->first()['storage_name'],'is_success'=>0];
                //记录补货日志
                storage_log::insert_log($storage_log,serialize($data));
                return response()->json(['err' => 0, 'str' => '订单退货失败！']);
            }
            $data = ['order_id'=>$data['order_id'],'order_single'=>$order->order_single_id,'status'=>2,'remarks'=>'订单退货','storage_id'=>$data['storage_id'],'storage_name'=>storage::where('storage_id',$data['storage_id'])->first()['storage_name'],'is_success'=>1];
            //记录补货日志
            $storage_log_data = storage_log::insert_log($storage_log,serialize($data));
            if(!$storage_log_data) return response()->json(['err' => '0', 'msg' => '订单退货失败']);
            return response()->json(['err' => 1, 'str' => '订单退货成功！']);
        }
    }
    public function home_table(Request $request)
    {
            $page = $request->input('page', 1);
            $limit = $request->input('limit', 10);
            //排序参数
            $field = $request->input('field', 'sum'); //排序字段
            $dsc = $request->input('order', 'desc'); //排序顺序
            $start = ($page - 1) * $limit;
           /*  $products = storage_goods_local::join('goods_kind', 'goods_kind.goods_kind_id', '=', 'storage_goods_local.goods_kind_id')
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
                        ->get();*/
            $data=\App\storage_check_data::join('storage_check','storage_check.storage_check_id','storage_check_data.storage_primary_id')
                 ->select('storage_check.*',DB::Raw('SUM(storage_check_data.storage_check_data_num) AS sum'))
                 ->where(function($query){
                    $query->where('storage_check.storage_check_is_out','1');
                    $query->where('storage_check_data.storage_check_data_type','<>','4');
                 })
                 ->groupBy('storage_check.storage_check_id')
                 ->orderBy($field, $dsc)
                 ->offset($start)
                 ->limit($limit)
                 ->get();
            $count=\App\storage_check_data::join('storage_check','storage_check.storage_check_id','storage_check_data.storage_primary_id')
                 ->select('storage_check.*',DB::Raw('SUM(storage_check_data.storage_check_data_num) AS sum'))
                 ->where(function($query){
                    $query->where('storage_check.storage_check_is_out','1');
                    $query->where('storage_check_data.storage_check_data_type','<>','4');
                 })
                 ->groupBy('storage_check.storage_check_id')
                 ->count();
           /* if($count > 0){
                foreach ($orders as &$data){
                  $data->goods_blade_type=\App\goods::get_blade_currency($data->goods_blade_type,$data->order_country);
                }
            }*/
            $arr = ['code' => 0, "msg" => "获取数据成功",'count'=>$count ,'data' => $data];
            return response()->json($arr);
    }

    /**
     * 新增仓库数据
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function add_storage_data(Request $request)
    {
        if($request->isMethod('get')){
            $storage = storage::where('storage_id',$request->input('storage_id'))->first();
            if($storage->is_local == 1){
                $product = goods_kind::all();
                return view('storage.product.add_storage_data_local')->with(compact('product','storage'));
            }else{
                $orders = order::where(function ($query){
                    $query->where('order_type','1');
                    $query->orWhere('order_type','3');
                    $query->orWhere('order_type','4');
                })->pluck('order_single_id','order_id')->toArray();
                return view('storage.product.add_storage_data')->with(compact('orders','storage'));
            }
        }else{
            //海外仓补货入库
            //TODO 商品个数不能超过填写个数
            $goods_attr = json_decode($request->input('goods_attr'),true);
            if(empty($goods_attr)){
                return response()->json(['err' => '0', 'msg' => '请选择采购商品']);
            }
            $order_id = $request->input('order_id');
            if(!$order_id){
                return response()->json(['err' => '0', 'msg' => '请选择订单数据']);
            }
            $admin_id = Auth::user()->admin_id;
            $storage_log = ['storage_log_type'=>7,'storage_log_operate_type'=>0,'storage_log_admin_id'=>$admin_id,'is_danger'=>1];
            //仓库ID、订单ID、运单号、有效期
            $storage_id = $request->input('storage_id');
            $express_delivery = $request->input('express_delivery');
            $expiry_at = $request->input('expiry_at');
            $order = order::where('order_id',$order_id)->first();
            $data_array = [];
            foreach ($goods_attr as $item){
                $sku = substr($item['goods_sku'],0,4);
                $sku_attr = substr($item['goods_sku'],-6);
                    $arr['num'] = $item['num'];
                    $arr['storage_primary_id'] = $storage_id;
                    $arr['order_id'] = $order_id;
                    $arr['sku'] = $sku;
                    $arr['express_delivery'] = $express_delivery;
                    $arr['expiry_at'] =  date('Y-m-d H:i:s',time()+$expiry_at*3600*24);
                    $arr['sku_data'] = $sku_attr;
                    $arr['goods_kind_id'] = $item['goods_kind_id'];
                    array_push($data_array,$arr);
            }
            $storage_goods_abroad_data = storage_goods_abroad::insert($data_array);
            $oldmsg = $order->order_return;
            $date = date('Y-m-d H:i:s',time());
            $admin = Auth::user()->admin_name;
            $htmlnow = $oldmsg."<p style='text-align:center'>[".$date."] ".$admin."：添加海外仓数据"."</p>";
            $order->order_type = 6;
            $order->order_return = $htmlnow;
            $order_data = $order->save();
            if(!$storage_goods_abroad_data || !$order_data){
                $datass = ['order_id'=>$order_id,'order_single'=>$order->order_single_i,'status'=>0,'remarks'=>'添加海外仓数据','storage_id'=>$storage_id,'storage_name'=>storage::where('storage_id',$storage_id)->first()['storage_name'],'is_success'=>0];
                storage_log::insert_log($storage_log,serialize($datass));
                return response()->json(['err' => '0', 'msg' => '添加海外仓数据失败']);
            }
            $datass = ['order_id'=>$order_id,'order_single'=>$order->order_single_id,'status'=>0,'remarks'=>'添加海外仓数据','storage_id'=>$storage_id,'storage_name'=>storage::where('storage_id',$storage_id)->first()['storage_name'],'is_success'=>1];
            storage_log::insert_log($storage_log,serialize($datass));
            return response()->json(['err' => '1', 'msg' => '添加海外仓数据成功']);
        }
    }


    /**
     * 添加本地仓数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add_storage_data_local(Request $request)
    {
        $datas = $request->all();
        $goods_attr = json_decode($request->input('goods_attr'),true);
        if(empty($goods_attr)){
            return response()->json(['err' => '0', 'msg' => '请选择采购商品']);
        }

        $admin_id = Auth::user()->admin_id;
        $storage_log = ['storage_log_type'=>7,'storage_log_operate_type'=>0,'storage_log_admin_id'=>$admin_id,'is_danger'=>0];
        try {
            DB::beginTransaction();
            foreach ($goods_attr as $item){
                $sku = substr($item['goods_sku'],0,4);
                $goods_kind = goods_kind::where('goods_kind_sku',$sku)->first();
                if(!$goods_kind){
                    throw new \Exception('产品SKU不存在，请检查数据！');
    //                return response()->json(['err' => '0', 'msg' => '产品SKU不存在，请检查数据']);
                }
                $goods_kind_id = isset($item['goods_kind_id']) ? $item['goods_kind_id'] : $goods_kind->goods_kind_id;
                $sku_attr = substr($item['goods_sku'],-6);
                $storage_goods_local = storage_goods_local::where('storage_primary_id',$datas['storage_id'])->where('sku',$sku)->where('sku_attr',$sku_attr)->first();
                if(!$storage_goods_local){
                    $storage_goods_local = new storage_goods_local();
                    $storage_goods_local->num = $item['num'];
                    $storage_goods_local->sku = substr($item['goods_sku'],0,4);
                    $storage_goods_local->sku_attr = substr($item['goods_sku'],-6);
                    $storage_goods_local->goods_kind_id = $goods_kind_id;
                    $storage_goods_local->storage_primary_id = $datas['storage_id'];
                    $storage_goods_local_data  = $storage_goods_local->save();
                }else{
                   $num = $storage_goods_local->num + $item['num'];
                   $storage_goods_local_data = storage_goods_local::where('storage_primary_id',$datas['storage_id'])->where('sku',$sku)->where('sku_attr',$sku_attr)->update(['num'=>$num]);
                }
                if(!$storage_goods_local_data){
                    $datass = ['storage_append_id'=>'','storage_append_single'=>'','remarks'=>'添加本地仓数据','storage_id'=>$datas['storage_id'],'storage_name'=>storage::where('storage_id',$datas['storage_id'])->first()['storage_name'],'is_success'=>0];
                    storage_log::insert_log($storage_log,serialize($datass));
                    throw new \Exception('添加本地仓数据失败！');
    //                return response()->json(['err' => '0', 'msg' => '添加本地仓数据失败']);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            // 回滚事务
            DB::rollBack();
            return response()->json(['err' => '0', 'msg' => $e->getMessage()]);
//            return code_response(20007,$e->getMessage());
        }

        $ip = $request->getClientIp();
        //添加补货单日志
        operation_log($ip,'添加本地仓数据',json_encode($datas));

        $datass = ['storage_append_id'=>'','storage_append_single'=>'','remarks'=>'添加本地仓数据','storage_id'=>$datas['storage_id'],'storage_name'=>storage::where('storage_id',$datas['storage_id'])->first()['storage_name'],'is_success'=>1];
        storage_log::insert_log($storage_log,serialize($datass));
        return response()->json(['err' => '1', 'msg' => '添加本地仓数据成功']);
    }

    /**
     * 获取订单信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_order_info(Request $request)
    {
        $order_id  = $request->input('order_id');
        $order = order::where('order_id',$order_id)->first();
        $order_configs = order_config::where('order_primary_id',$order_id)->get();
        $data = [];
        if(!$order_configs->isEmpty()){
            $sku_kind_all = [];
            $order_configs = $order_configs->toArray();
            $counts = array_count_values(array_column($order_configs,'order_config'));
            foreach ($order_configs as $order_config){
                if(!in_array($order_config['order_config'],$sku_kind_all)){
                    array_push($sku_kind_all,$order_config['order_config']);
                    $order_ids = explode(',',$order_config['order_config']);
                    $str = '';
                    $str_name = '';
                    $goods_kind_id = '';
                    $goods_kind_name = '';
                    $all_sku = '';
                    if(!empty($order_ids)){
                        foreach ($order_ids as $id){
                            $kind_val_id = config_val::where('config_val_id',$id)->first()['kind_val_id'];
                            $kind_val = kind_val::where('kind_val_id',$kind_val_id)->first();
                            if($kind_val){
                                $goods_kind_id = $kind_val->kind_primary_id;
                                $str_name .= $kind_val->kind_val_msg.',';
                            }
                            $str .= $kind_val_id . ',';
                        }
                    }
                    $goods_kind = goods_kind::where('goods_kind_id',$goods_kind_id)->first();
                    if($goods_kind){
                        $goods_kind_name = $goods_kind->goods_kind_name;
                        $skuSDK = new skuSDK($goods_kind_id,$goods_kind->goods_product_id,$goods_kind->goods_kind_user_type);
                        $all_sku = $skuSDK->get_all_sku(rtrim($str,','));
                    }
                    $arr['goods_attr'] = $str_name;
                    $arr['goods_kind_id'] = $goods_kind_id;
                    $arr['goods_kind_name'] = $goods_kind_name;
                    $arr['goods_sku'] = $all_sku;
                    $arr['num'] = $counts[$order_config['order_config']];
                    array_push($data,$arr);
                }
            }
        }else{
            if($order){
                $goods = goods::where('goods_id',$order->order_goods_id)->first();
                $goods_kind = goods_kind::where('goods_kind_id',$goods->goods_kind_id)->first();
                if($goods_kind){
                    $arr['goods_attr'] = '';
                    $arr['goods_kind_id'] = $goods_kind->goods_kind_id;
                    $arr['goods_kind_name'] = $goods_kind->goods_kind_name;
                    $arr['goods_sku'] = $goods_kind->goods_kind_sku.'000000';
                    $arr['num'] = $order->order_num;
                    array_push($data,$arr);
                }
            }
        }
        $arr = ['code' => 1, "msg" => "获取数据成功",'data' => $data];
        return response()->json($arr);
    }

    /**
     * 添加海外仓数据（没有订单）
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function no_order_info(Request $request){
        if($request->isMethod('get')){
            $id = $request->input('storage_id');
            $storage = storage::where('storage_id',$id)->first();
            $product = goods_kind::all();
            $order_single = 'NR'.makeSingleOrder();
            if($storage){
                return view('storage.product.no_order_info')->with(compact('storage','product','order_single'));
            }
        }else{
            $order_single = $request->input('order_single');
            $goods_attr = json_decode($request->input('goods_attr'),true);
            $storage_id = $request->input('storage_id');
            $expiry_at = $request->input('expiry_at');
            if(empty($goods_attr)){
                return response()->json(['err' => '0', 'msg' => '请选择添加仓库商品']);
            }
            $order = order::where('order_single_id',$order_single)->first();
            if($order){
                return response()->json(['err' => '0', 'msg' => '订单编号已存在，不可通过此形式添加']);
            }
            $storage = storage::where('storage_id',$storage_id)->first();
            if(!$storage){
                return response()->json(['err' => '0', 'msg' => '仓库不存在']);
            }
            $admin_id = Auth::user()->admin_id;
            $order_id = "B".time();
            $data_array = [];
            foreach ($goods_attr as $item){
                if($item['num'] > 0){
                    $arr['sku'] = substr($item['goods_sku'],0,4);
                    $arr['storage_primary_id'] = $storage_id;
                    $arr['order_id'] = $order_id;
                    $arr['num'] = $item['num'];
                    $arr['sku_data'] = substr($item['goods_sku'],-6);
                    $arr['express_delivery'] = $request->input('express_delivery');
                    $arr['expiry_at'] = date('Y-m-d H:i:s',time()+$expiry_at*3600*24);
                    $arr['goods_kind_id'] = $item['goods_kind_id'];
                    $arr['order_single'] = $order_single;
                    array_push($data_array,$arr);
                }
            }
            $storage_log = ['storage_log_type'=>7,'storage_log_operate_type'=>0,'storage_log_admin_id'=>$admin_id,'is_danger'=>1];
            $storage_goods_abroad = DB::table('storage_goods_abroad')->insert($data_array);
            $ip = $request->getClientIp();
            operation_log($ip,'添加本地仓数据',json_encode($request->all()));
            if($storage_goods_abroad){
                $datass = ['order_id'=>$order_id,'order_single'=>$order_single,'status'=>0,'remarks'=>'添加本地仓数据','storage_id'=>$storage_id,'storage_name'=>$storage->storage_name,'is_success'=>1];
                storage_log::insert_log($storage_log,serialize($datass));
                return response()->json(['code' => 1, "msg" => "添加数据成功"]);
            }
            $datass = ['order_id'=>$order_id,'order_single'=>$order_single,'status'=>0,'remarks'=>'添加本地仓数据','storage_id'=>$storage_id,'storage_name'=>$storage->storage_name,'is_success'=>0];
            storage_log::insert_log($storage_log,serialize($datass));
            return response()->json(['code' => 0, "msg" => "添加数据失败"]);
        }
    }
}
