<?php

namespace App\Http\Controllers\admin\storage;

use App\channel\skuSDK;
use App\goods_kind;
use App\kind_config;
use App\kind_val;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StorageAddController extends Controller
{
    public function add(Request $request)
    {
    	if($request->isMethod('get')){
    		return view('storage.add.add');
    	}elseif($request->isMethod('post')){

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

        }
    }

    public function get_goods_config(Request $request)
    {
        $id = $request->input('id','1');
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
            }

            $arr = ['code' => 0, "msg" => "获取数据成功", 'data' => $goods_kind_sku];
            return response()->json($arr);
        }else{
            return response()->json(['code' => 0, "msg" => "获取数据成功", 'data' => []]);
        }
    }
}
