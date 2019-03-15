<?php

namespace App\Http\Controllers\admin\storage;

use App\channel\skuSDK;
use App\storage_goods_abroad;
use App\storage_goods_local;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\storage;
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
		   $page = $request->input('page',1);
           $limit = $request->input('limit',10);
           $start = ($page-1)*$limit;
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
            if ($data) {
                return response()->json(['err' => '1', 'msg' => '修改仓库信息成功']);
            }
            return response()->json(['err' => '0', 'msg' => '修改仓库信息失败']);
        }
    }

    public function del_storage(Request $request)
    {
    	$msg=storage::where('storage_id',$request->input('id',0))->update(['storage_status'=>0]);
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
            } else { //海外仓库
                $products = storage_goods_abroad::join('goods_kind', 'goods_kind.goods_kind_id', '=', 'storage_goods_abroad.goods_kind_id')
                    ->select('goods_kind.*', DB::Raw('SUM(num) AS num'))
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
            }
        }else{
            $products = [];
        }
        $arr = ['code' => 0, "msg" => "获取数据成功", 'data' => $products];
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

            if($storage_goods){
                return response()->json(['err'=>1,'str'=>'删除产品成功！']);
            }else{
                return response()->json(['err'=>0,'str'=>'删除产品失败！']);
            }
        }else{
            return response()->json(['err'=>0,'str'=>'抱歉，删除库存产品不存在或已删除！']);
        }
    }
}
