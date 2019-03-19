<?php

namespace App\Http\Controllers\admin\storage;

use App\admin;
use App\channel\skuSDK;
use App\goods_kind;
use App\kind_config;
use App\kind_val;
use App\storage_append_data;
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
            //排序参数
            $field = $request->input('field', 'storage_append_id'); //排序字段
            $dsc = $request->input('order', 'desc'); //排序顺序
            $start = ($page - 1) * $limit;
            $time = $request->input('time');
            $count = storage_append::where(function ($query)use ($time,$search){
                if($time){
                    $start_time = substr($time,0,19);
                    $end_time = substr($time,-19);
                    $query->wherebetween('storage_append_time',[$start_time,$end_time]);
                }
                if($search){
                    $query->where('storage_append_single','like',"%".$search."%");
                }
            })->count();
            $storage_append  = storage_append::where(function ($query)use ($time,$search){
                    if($time){
                        $start_time = substr($time,0,19);
                        $end_time = substr($time,-19);
                        $query->wherebetween('storage_append_time',[$start_time,$end_time]);
                    }
                    if($search){
                        $query->where('storage_append_single','like',"%".$search."%");
                    }
                })
                ->orderBy($field, $dsc)
                ->offset($start)
                ->limit($limit)
                ->get();
            if(!$storage_append->isEmpty()){
                foreach ($storage_append as &$item){
                    $item->storage_append_admin = admin::where('admin_id',$item->storage_append_admin_id)->first()['admin_show_name'];
                    $item->storage_append_status = $item->storage_append_status == '0' ? '未补充到仓库' : ($item->storage_append_status == '1' ? '补充到仓库' : '补货取消');
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
            $goods_attr = json_decode($request->input('goods_attr'),true);
            if(empty($goods_attr)){
                return response()->json(['err' => '0', 'msg' => '请选择采购商品']);
            }
            $validator = Validator::make($request->all(), [
                "storage_append_single" => "required|unique:storage_append,storage_append_single",
                "goods_kind" => "required",
            ],[
                "storage_append_single.required" => "采购单号不能为空",
                "goods_kind.required" => "采购单商品不能为空",
                "storage_append_single.unique" => "采购单号不能重复",
            ]);
            if ($validator->fails()) {
                return response()->json(['err' => '0', 'msg' => $validator->errors()->first()]);
            }

            $storage_append = new storage_append();
            $storage_append->storage_append_time = $request->input('time');
            $storage_append->storage_append_admin_id = Auth::user()->id;
            $storage_append->storage_append_single = $request->input('storage_append_single');
            $storage_append->storage_append_status = 0;
            $storage_append->storage_append_msg = $request->input('storage_append_msg');
            $data  = $storage_append->save();
            if(!$data){
                return response()->json(['err' => '0', 'msg' => '添加采购单失败']);
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
            if($storage_append_data){
                return response()->json(['err' => '1', 'msg' => '添加采购单成功']);
            }
            return response()->json(['err' => '0', 'msg' => '添加采购单失败']);
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
                    $all_sku = $skuSDK->get_all_sku($sku);
                    $current_attrs = $skuSDK->get_attr_by_sku(substr($all_sku,-6));
                    $str = '';
                    foreach ($current_attrs as $attr) {
                        $str .= $attr->kind_val_msg .',';
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

            $arr = ['code' => 0, "msg" => "获取数据成功", 'data' => $goods_kind_sku];
            return response()->json($arr);
        }else{
            return response()->json(['code' => 0, "msg" => "获取数据成功", 'data' => []]);
        }
    }
}
