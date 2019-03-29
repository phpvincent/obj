<?php

namespace App\Http\Controllers\admin\storage;

use App\admin;
use App\channel\skuSDK;
use App\goods_kind;
use App\kind_config;
use App\kind_val;
use App\storage;
use App\storage_append_data;
use App\storage_goods_local;
use App\storage_log;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\storage_append;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StorageAddController extends Controller
{
    /**
     * 采购单列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function add(Request $request)
    {
    	if($request->isMethod('get')){
    		return view('storage.add.add');
    	}elseif($request->isMethod('post')){
            $page = $request->input('page', 1);
            $limit = $request->input('limit', 10);
            $search = trim($request->input('search'));
            $storage_status = $request->input('storage_status');
            //排序参数
            $field = $request->input('field', 'storage_append_id'); //排序字段
            $dsc = $request->input('order', 'desc'); //排序顺序
            $start = ($page - 1) * $limit;
            $time = $request->input('time');
            $count = storage_append::where(function ($query)use ($time,$search,$storage_status){
                if($time){
                    $start_time = substr($time,0,19);
                    $end_time = substr($time,-19);
                    $query->wherebetween('storage_append_time',[$start_time,$end_time]);
                }
                if($search){
                    $query->where('storage_append_single','like',"%".$search."%");
                }
                if($storage_status != '#'){
                    $query->where('storage_append_status',$storage_status);
                }
            })->count();
            $storage_append  = storage_append::where(function ($query)use ($time,$search,$storage_status){
                    if($time){
                        $start_time = substr($time,0,19);
                        $end_time = substr($time,-19);
                        $query->wherebetween('storage_append_time',[$start_time,$end_time]);
                    }
                    if($search){
                        $query->where('storage_append_single','like',"%".$search."%");
                    }
                    if($storage_status != '#'){
                        $query->where('storage_append_status',$storage_status);
                    }
                })
                ->orderBy($field, $dsc)
                ->offset($start)
                ->limit($limit)
                ->get();
            if(!$storage_append->isEmpty()){
                foreach ($storage_append as &$item){
                    $item->storage_append_admin = admin::where('admin_id',$item->storage_append_admin_id)->first()['admin_show_name'];
                    $item->storage_append_status = $item->storage_append_status == '0' ? '未入仓库' : ($item->storage_append_status == '1' ? '已入库' : '补货取消');
                }
            }
            return response()->json(['code' => 0, "msg" => "获取数据成功",'count'=>$count, 'data' => $storage_append]);
        }
    }

    /**
     * 新增补货单
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_goods(Request $request)
    {
        if($request->isMethod('get')){
            $product = goods_kind::all();
            return view('storage.add.add_goods')->with(compact('product'));
        }elseif($request->isMethod('post')){
            $datas = $request->all();
            $goods_attr = json_decode($request->input('goods_attr'),true);
            if(empty($goods_attr)){
                return response()->json(['err' => '0', 'msg' => '请选择采购商品']);
            }
            $validator = Validator::make($request->all(), [
                "storage_append_single" => "required|unique:storage_append,storage_append_single",
                "goods_kind" => "required",
            ],[
                "storage_append_single.required" => "补货单号不能为空",
                "goods_kind.required" => "补货单商品不能为空",
                "storage_append_single.unique" => "补货单号不能重复",
            ]);
            if ($validator->fails()) {
                return response()->json(['err' => '0', 'msg' => $validator->errors()->first()]);
            }
            $admin_id = Auth::user()->admin_id;
            $storage_log = ['storage_log_type'=>1,'storage_log_operate_type'=>0,'storage_log_admin_id'=>$admin_id,'is_danger'=>0];
            $storage_append = new storage_append();
            $storage_append->storage_append_time = $request->input('storage_append_time');
            $storage_append->storage_append_admin_id = $admin_id;
            $storage_append->storage_append_single = $request->input('storage_append_single');
            $storage_append->storage_append_status = 0;
            $storage_append->storage_append_msg = $request->input('storage_append_msg');
            $data  = $storage_append->save();
            if(!$data){
                $datass = ['storage_append_id'=>$storage_append->storage_append_id,'storage_append_single'=>$request->input('storage_append_single'),'remarks'=>'添加补货单','is_success'=>0];
                storage_log::insert_log($storage_log,serialize($datass));
                return response()->json(['err' => '0', 'msg' => '添加补货单失败']);
            }
            $data_array = [];
            foreach ($goods_attr as $item){
                $arr['storage_append_data_sku'] = substr($item['goods_sku'],0,4);
                $arr['storage_append_data_status'] = 2;
                $arr['storage_append_id'] = $storage_append->storage_append_id;
                $arr['storage_append_data_num'] = $item['num'];
                $arr['storage_append_data_sku_attr'] = substr($item['goods_sku'],-6);
                $arr['storage_append_kind_id'] = $item['goods_kind_id'];
                array_push($data_array,$arr);
            }

            $storage_append_data = DB::table('storage_append_data')->insert($data_array);
            $ip = $request->getClientIp();
            //添加补货单日志
            operation_log($ip,'添加补货单成功,补货单号：'.$request->input('storage_append_single'),json_encode($datas));
            if($storage_append_data){
                $datass = ['storage_append_id'=>$storage_append->storage_append_id,'storage_append_single'=>$request->input('storage_append_single'),'remarks'=>'添加补货单','is_success'=>1];
                storage_log::insert_log($storage_log,serialize($datass));
                return response()->json(['err' => '1', 'msg' => '添加补货单成功']);
            }
            $datass = ['storage_append_id'=>$storage_append->storage_append_id,'storage_append_single'=>$request->input('storage_append_single'),'remarks'=>'添加补货单','is_success'=>0];
            storage_log::insert_log($storage_log,serialize($datass));
            return response()->json(['err' => '0', 'msg' => '添加补货单失败']);
        }
    }

    /**
     * 编辑采购单数据
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function up_storage_append(Request $request)
    {
        if($request->isMethod('get')){
            $storage_append_id = $request->input('storage_append_id');
            $storage_appends = storage_append::where('storage_append_id',$storage_append_id)->first();
            if($storage_appends){
                $product = goods_kind::all();
                $storage_append_data = storage_append_data::where('storage_append_id',$storage_append_id)->orderBy('storage_append_kind_id')->get();
                if(!$storage_append_data->isEmpty()){
                    foreach ($storage_append_data as &$storage_append){
                        $goods_kind = goods_kind::where('goods_kind_id',$storage_append->storage_append_kind_id)->first();
                        $skuSDK = new skuSDK($storage_append->storage_append_kind_id,$goods_kind->goods_product_id,$goods_kind->goods_kind_user_type);
                        $storage_append->goods_sku = $storage_append->storage_append_data_sku.$storage_append->storage_append_data_sku_attr;
                        $storage_append->goods_kind_name = goods_kind::where('goods_kind_id',$storage_append->storage_append_kind_id)->first()['goods_kind_name'];
                        $current_attrs = $skuSDK->get_attr_by_sku($storage_append->storage_append_data_sku_attr);
                        $str = '';
                        foreach ($current_attrs as $attr) {
                            if($attr){
                                $str .= $attr->kind_val_msg .',';
                            }
                        }
                        $storage_append->storage_append_data_attr= rtrim($str,',');
                    }
                }
                return view('storage.add.edit_storage_append')->with(compact('product','storage_append_id','storage_append_data','storage_appends'));
            }
        }elseif($request->isMethod('post')){
            $datas = $request->all();
            $goods_attr = json_decode($request->input('goods_attr'),true);
            if(empty($goods_attr)){
                return response()->json(['err' => '0', 'msg' => '请选择补货商品']);
            }
            $validator = Validator::make($request->all(), [
                "storage_append_single" => "required",
            ],[
                "storage_append_single.required" => "补货单号不能为空",
            ]);
            if ($validator->fails()) {
                return response()->json(['err' => '0', 'msg' => $validator->errors()->first()]);
            }
            $storage_append_id = $request->input('storage_append_id');
            $storage_append  = storage_append::where('storage_append_id',$storage_append_id)->first();
            if(!$storage_append){
                return response()->json(['err' => '0', 'msg' => '编辑补货单失败']);
            }
            if($storage_append->storage_append_status == 1 || $storage_append->storage_append_status == 2){
                return response()->json(['err' => '0', 'msg' => '补货单已商品已入仓或采购单取消，无法修改']);
            }
            $storage_append->storage_append_single = $request->input('storage_append_single');
            $storage_append->storage_append_status = 0;
            $storage_append->storage_append_msg = $request->input('storage_append_msg');
            $data  = $storage_append->save();
            $admin_id = Auth::user()->admin_id;
            $storage_log = ['storage_log_type'=>1,'storage_log_operate_type'=>2,'storage_log_admin_id'=>$admin_id,'is_danger'=>1];
            if(!$data){
                $datass = ['storage_append_id'=>$storage_append_id,'storage_append_single'=>$storage_append->storage_append_single,'remarks'=>'编辑补货单','is_success'=>0];
                storage_log::insert_log($storage_log,serialize($datass));
                return response()->json(['err' => '0', 'msg' => '编辑补货单失败']);
            }
            $ip = $request->getClientIp();
            //添加补货单日志
            operation_log($ip,'编辑补货单,补货单号：'.$request->input('storage_append_single'),json_encode($datas));
            $last_id = array_column($goods_attr, 'storage_append_data_id');
            $last_ids = storage_append_data::where('storage_append_id',$storage_append_id)->pluck('storage_append_data_id')->toArray();
            $ids = array_diff($last_ids,$last_id);
            storage_append_data::whereIn('storage_append_data_id',$ids)->delete();
            foreach ($goods_attr as $item){
                if(isset($item['storage_append_data_id'])){
                    $storage_append_data = storage_append_data::where('storage_append_data_id',$item['storage_append_data_id'])->first();
                }else{
                    $storage_append_data  = new storage_append_data();
                }
                $storage_append_data->storage_append_data_sku = substr($item['goods_sku'],0,4);
                $storage_append_data->storage_append_data_status = 2;
                $storage_append_data->storage_append_id = $storage_append_id;
                $storage_append_data->storage_append_data_num = $item['num'];
                $storage_append_data->storage_append_data_sku_attr = substr($item['goods_sku'],-6);
                $storage_append_data->storage_append_kind_id = $item['goods_kind_id'];
                $storage_append_datas = $storage_append_data->save();
                if(!$storage_append_datas){
                    $datass = ['storage_append_id'=>$storage_append_id,'storage_append_single'=>$storage_append->storage_append_single,'remarks'=>'编辑补货单','is_success'=>0];
                    $storage_log_data = storage_log::insert_log($storage_log,serialize($datass));
                    if(!$storage_log_data) return response()->json(['err' => '0', 'msg' => '编辑补货单失败']);
                    return response()->json(['err' => '0', 'msg' => '编辑补货单失败']);
                }
            }
            $datass = ['storage_append_id'=>$storage_append_id,'storage_append_single'=>$storage_append->storage_append_single,'remarks'=>'编辑补货单','is_success'=>1];
            storage_log::insert_log($storage_log,serialize($datass));
            return response()->json(['err' => '1', 'msg' => '编辑补货单成功']);
        }
    }

    /**
     * 获取商品的商品属性
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_goods_config(Request $request)
    {
        $id = $request->input('id');
        $goods_kind = goods_kind::where('goods_kind_id',$id)->first();
        if($goods_kind){

            //根据产品ID获取产品属性值
            $kind_configs =  kind_config::where('kind_primary_id',$id)->get();
            $goods_kind_sku = [];
            if(!$kind_configs->isEmpty()){
                $array = [];
                foreach ($kind_configs as $kind_config)
                {
                    $arr = kind_val::where('kind_type_id',$kind_config->kind_config_id)->pluck('kind_val_id')->toArray();
                    array_push($array,$arr);
                }

                $skus = descartes($array);
                $skuSDK = new skuSDK($id,$goods_kind->goods_product_id,$goods_kind->goods_kind_user_type);
                //获取完整的sku
                foreach ($skus as $sku){
                    $all_sku = $skuSDK->get_all_sku((string)$sku);
                    $current_attrs = $skuSDK->get_attr_by_sku(substr($all_sku,-6));
                    $str = '';
                    foreach ($current_attrs as $attr) {
                        if($attr){
                            $str .= $attr->kind_val_msg .',';
                        }
                    }
                    $arry['goods_kind_id'] = $goods_kind->goods_kind_id;
                    $arry['goods_attr'] = rtrim($str,',');
                    $arry['goods_sku'] = $all_sku;
                    $arry['goods_kind_name'] = $goods_kind->goods_kind_name;
                    array_push($goods_kind_sku,$arry);
                }
            }else{
                $ary['goods_kind_id'] = $goods_kind->goods_kind_id;
                $ary['goods_attr'] = '';
                $ary['goods_sku'] = $goods_kind->goods_kind_sku.'000000';
                $ary['goods_kind_name'] = $goods_kind->goods_kind_name;
                array_push($goods_kind_sku,$ary);
            }

            return response()->json(['code' => 0, "msg" => "获取数据成功", 'data' => $goods_kind_sku]);
        }else{
            return response()->json(['code' => 0, "msg" => "获取数据成功", 'data' => []]);
        }
    }

    /**
     * 查看采购单数据
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function show_goods_kind(Request $request)
    {
        if($request->isMethod('get')){
            $id = $request->input('storage_append_id');
            return view('storage.add.show_goods_kind')->with(compact('id'));
        }elseif($request->isMethod('post')){
            $id = $request->input('storage_append_id');
            $storage_append = storage_append::where('storage_append_id',$id)->first();
            if($storage_append){
                $storage_append_datas = storage_append_data::join('storage_append','storage_append_data.storage_append_id','=','storage_append.storage_append_id')
                    ->join('goods_kind','goods_kind.goods_kind_id','=','storage_append_data.storage_append_kind_id')
                    ->select(DB::Raw('SUM(storage_append_data_num) AS num'),'goods_kind.goods_kind_name','storage_append_data.storage_append_kind_id')
                    ->where('storage_append.storage_append_id',$id)
                    ->groupBy('storage_append_kind_id')
                    ->get();
                if(!$storage_append_datas->isEmpty()){
                    foreach ($storage_append_datas as &$storage_append_data){
                        $storage_append_data->storage_append_time = $storage_append->storage_append_time;//采购时间
                        $storage_append_data->storage_append_end_time = $storage_append->storage_append_end_time;//确认进仓时间
                        $storage_append_data->storage_append_admin = admin::where('admin_id',$storage_append->storage_append_admin_id)->first()['admin_show_name'];;//补货人
                        $storage_append_data->storage_append_single = $storage_append->storage_append_single;//补货单号
                        $storage_append_data->storage_append_msg = $storage_append->storage_append_msg;//补货备注
                        $storage_append_data->storage_append_id = $storage_append->storage_append_id;//补货单ID
                        $storage_append_data->storage_append_status = $storage_append->storage_append_status == '0' ? '未入仓库' : ($storage_append->storage_append_status == '1' ? '已入库' : '补货取消');//补货单状态
                    }
                }
                return response()->json(['code' => 0, "msg" => "获取数据成功", 'data' => $storage_append_datas]);
            }else{
                return response()->json(['code' => 0, "msg" => "获取数据成功", 'data' => []]);
            }
        }
    }

    /**
     * 删除采购单商品(已删除)
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function append_goods_del(Request $request)
    {
        $storage_append_id = $request->input('storage_append_id');
        $goods_kind_id = $request->input('goods_kind_id');
        $storage_append =  storage_append::where('storage_append_id',$storage_append_id)->first();
        if($storage_append && $storage_append->storage_append_end_time){
            return response()->json(['code' => 0, "msg" => "商品已到仓库，不能删除"]);
        }
        //TODO 删除最后一个商品，删除采购单 2019-03-21
        $storage_append_data = storage_append_data::where('storage_append_id',$storage_append_id)->where('storage_append_kind_id',$goods_kind_id)->delete();
        $ip = $request->getClientIp();
        //添加补货单日志
        operation_log($ip,'删除补货单商品,补货单号：'.$storage_append->storage_append_single);
        if($storage_append_data){
            return response()->json(['code' => 1, "msg" => "删除数据成功"]);
        }
        return response()->json(['code' => 0, "msg" => "删除数据失败"]);
    }

    /**
     * 获取采购单数据
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function append_goods_edit(Request $request)
    {
        if($request->isMethod('get')){
            $storage_append_id = $request->input('storage_append_id');
            $goods_kind_id = $request->input('goods_kind_id');
            return view('storage.add.edit')->with(compact('storage_append_id','goods_kind_id'));
        }elseif($request->isMethod('post')){
            $storage_append_id = $request->input('storage_append_id');
            $goods_kind_id = $request->input('goods_kind_id');
            $goods_kind = goods_kind::where('goods_kind_id',$goods_kind_id)->first();
            $storage_append_datas = storage_append_data::where('storage_append_id',$storage_append_id)->where('storage_append_kind_id',$goods_kind_id)->get();
            if(!$storage_append_datas->isEmpty() && $goods_kind){
                $skuSDK = new skuSDK($goods_kind_id,$goods_kind->goods_product_id,$goods_kind->goods_kind_user_type);
                foreach ($storage_append_datas as &$storage_append_data){
                    $storage_append_data->goods_kind_name = goods_kind::where('goods_kind_id',$storage_append_data->storage_append_kind_id)->first()['goods_kind_name'];
                    $current_attrs = $skuSDK->get_attr_by_sku($storage_append_data->storage_append_data_sku_attr);
                    $str = '';
                    foreach ($current_attrs as $attr) {
                        $str .= $attr->kind_val_msg .',';
                    }
                    $storage_append_data->goods_attr = rtrim($str,',');
                    $storage_append_data->goods_sku = $storage_append_data->storage_append_data_sku.$storage_append_data->storage_append_data_sku_attr;
                }
                return response()->json(['code' => 0, "msg" => "获取数据成功", 'data' => $storage_append_datas]);
            }
            return response()->json(['code' => 0, "msg" => "获取数据成功", 'data' => []]);
        }
    }

    /**
     * 修改采购单数量
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function append_goods_num(Request $request)
    {
        $num = $request->input('num');
        if(!trim($num)){
            $num = 0;
        }
        $admin_id = Auth::user()->admin_id;
        $storage_append_data_id = $request->input('storage_append_data_id');
        $data = storage_append_data::where('storage_append_data_id',$storage_append_data_id)->update(['storage_append_data_num'=>$num]);
        $ip = $request->getClientIp();
        $storage_log = ['storage_log_type'=>1,'storage_log_operate_type'=>2,'storage_log_admin_id'=>$admin_id,'is_danger'=>0];
        //添加补货单日志
        operation_log($ip,'修改补货单商品数量,补货单产品数据ID：'.$storage_append_data_id);
        $storage_append_datas = storage_append_data::where('storage_append_data_id',$storage_append_data_id)->first();
        if($data){
            $datas = ['storage_append_data_id'=>$storage_append_data_id,'storage_append_single'=>$storage_append_datas->storage_append_single,'storage_append_id'=>$storage_append_datas->storage_append_id,'remarks'=>'修改补货单商品数量','is_success'=>1];
            $storage_log_data = storage_log::insert_log($storage_log,serialize($datas));
            if(!$storage_log_data) return response()->json(['err' => '0', 'msg' => '修改数据失败']);
            return response()->json(['err' => 1, "msg" => "修改数据成功"]);
        }
        $datas = ['storage_append_data_id'=>$storage_append_data_id,'storage_append_single'=>$storage_append_datas->storage_append_single,'storage_append_id'=>$storage_append_datas->storage_append_id,'remarks'=>'修改补货单商品数量','is_success'=>0];
        $storage_log_data = storage_log::insert_log($storage_log,serialize($datas));
        if(!$storage_log_data) return response()->json(['err' => '0', 'msg' => '修改数据失败']);
        return response()->json(['err' => 0, "msg" => "修改数据失败"]);
    }

    /**
     * 补货单入库
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function append_goods_over(Request $request)
    {
        $storage_append_id = $request->input('storage_append_id');
        $storage_append = storage_append::where('storage_append_id',$storage_append_id)->update(['storage_append_status'=>'1','storage_append_end_time'=>date('Y-m-d H:i:s')]);
        if(!$storage_append)         return response()->json(['err' => 0, "msg" => "补货单入库失败"]);
        $storage_append_data = storage_append_data::where('storage_append_id',$storage_append_id)->update(['storage_append_data_status'=>'1','storage_append_data_time'=>date('Y-m-d H:i:s')]);
        if(!$storage_append_data)         return response()->json(['err' => 0, "msg" => "补货单入库失败"]);
        //补货单商品补到货到本地仓库
        $storage_append_datas = storage_append_data::where('storage_append_id',$storage_append_id)->get();
        //获取本地仓库
        $storage = storage::where('is_local',1)->first();
        $ip = $request->getClientIp();
        $admin_id = Auth::user()->admin_id;
        $storage_append_single = storage_append::where('storage_append_id',$storage_append_id)->first()['storage_append_single'];
        //添加补货单日志
        $storage_log = ['storage_log_type'=>7,'storage_log_operate_type'=>0,'storage_log_admin_id'=>$admin_id,'is_danger'=>0];
        operation_log($ip,'补货单数据入库,补货单号：'.$storage_append_single);
        foreach ($storage_append_datas as $item){
            $storage_goods_local = storage_goods_local::where('sku',$item->storage_append_data_sku)
                ->where('storage_primary_id',$storage->storage_id)
                ->where('sku_attr',$item->storage_append_data_sku_attr)
                ->first();
            if(!$storage_goods_local){
                $storage_goods_local = new storage_goods_local();
                $storage_goods_local->num = $item->storage_append_data_num;
                $storage_goods_local->sku = $item->storage_append_data_sku;
                $storage_goods_local->storage_primary_id = $storage->storage_id;
                $storage_goods_local->sku_attr = $item->storage_append_data_sku_attr;
                $storage_goods_local->goods_kind_id = $item->storage_append_kind_id;
                $storage_goods_local->save();
            }else{
                $storage_num_data['num'] = $storage_goods_local->num + $item->storage_append_data_num;
                $storage_goods_local = DB::table('storage_goods_local')->where('sku',$item->storage_append_data_sku)
                    ->where('storage_primary_id',$storage->storage_id)
                    ->where('sku_attr',$item->storage_append_data_sku_attr)->update($storage_num_data);
            }
            if(!$storage_goods_local){
                $data = ['order_id'=>$storage_append_id,'order_single'=>$storage_append_single,'status'=>1,'remarks'=>'补货单入库','storage_id'=>$storage->storage_id,'storage_name'=>$storage->storage_name,'is_success'=>0];
                storage_log::insert_log($storage_log,serialize($data));
                return response()->json(['err' => 0, "msg" => "补货单入库失败"]);
            }
        }
        $data = ['order_id'=>$storage_append_id,'order_single'=>$storage_append_single,'status'=>1,'remarks'=>'补货单入库','storage_id'=>$storage->storage_id,'storage_name'=>$storage->storage_name,'is_success'=>1];
        //记录补货日志
        $storage_log_data = storage_log::insert_log($storage_log,serialize($data));
        if(!$storage_log_data) return response()->json(['err' => '0', 'msg' => '补货单入库失败']);
        return response()->json(['err' => 1, "msg" => "补货单入库成功"]);
    }

    /**
     * 补货单取消
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function cancel_storage_append(Request $request)
    {
        if ($request->isMethod('get')) {
            $storage_append_id = $request->input('storage_append_id');
            $storage_append_single = storage_append::where('storage_append_id', $storage_append_id)->first()['storage_append_single'];
            if ($storage_append_single) {
                return view('storage.add.cancel')->with(compact('storage_append_id', 'goods_kind_id', 'storage_append_single'));
            }
        } else {
            $storage_append_id = $request->input('storage_append_id');
            $storage_append_return = $request->input('remarks');
            $validator = Validator::make($request->all(), [
                "remarks" => "required",
            ], [
                "remarks.required" => "补货单取消信息不能为空",
            ]);
            if ($validator->fails()) {
                return response()->json(['err' => '0', 'msg' => $validator->errors()->first()]);
            }
            $ip = $request->getClientIp();
            //补货单取消日志
            operation_log($ip, '补货单取消,补货单ID：' . $storage_append_id);
            $admin_id = Auth::user()->admin_id;
            $storage_log = ['storage_log_type'=>1,'storage_log_operate_type'=>1,'storage_log_admin_id'=>$admin_id,'is_danger'=>1];
            $storage_append = storage_append::where('storage_append_id', $storage_append_id)->update(['storage_append_status' => '2', 'storage_append_return' => $storage_append_return]);
            $storage_append_data = storage_append_data::where('storage_append_id', $storage_append_id)->update(['storage_append_data_status' => '2']);
            if ($storage_append && $storage_append_data) {
                $datas = ['storage_append_id'=>$storage_append_id,'storage_append_single'=>$storage_append->storage_append_single,'remarks'=>'补货单取消','is_success'=>1];
                $storage_log_data = storage_log::insert_log($storage_log,serialize($datas));
                if(!$storage_log_data) return response()->json(['err' => '0', 'msg' => '补货单取消失败']);
                return response()->json(['err' => 1, "msg" => "补货单取消成功"]);
            }
            $datas = ['storage_append_id'=>$storage_append_id,'storage_append_single'=>$storage_append->storage_append_single,'remarks'=>'补货单取消','is_success'=>0];
            storage_log::insert_log($storage_log,serialize($datas));
            return response()->json(['err' => 0, "msg" => "补货单取消失败"]);
        }
    }

    /**
     * 获取正在运货中的所有补货单
     */
    public function get_add_num(Request $request)
    {
        $append=\App\storage_append::where('storage_append_status','0')->count();
        return $append;
    }
}
