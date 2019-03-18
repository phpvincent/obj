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
    /**
     * 订单数据校准、扣货
     * @param  boolean $type [默认为校准，false为扣货操作]
     * @return [type]        [description]
     */
    public function check_order($type=true)
    {
        $orders=\App\order::where([['order_type',1],['is_del','0']])->get();
        //删除一天前的校准数据
        $ids=\App\storage_check::select('storage_check_id')->where('storage_check_time','<',date('Y-m-d H:i:s',time()-86400))->get()->toArray();
        \App\storage_check::whereIn('storage_check_id',$ids)->delete();
        \App\storage_check_data::whereIn('storage_primary_id',$ids)->delete();
        \App\storage_check_lack::whereIn('storage_check_lack_primary_id',$ids)->delete();
        //生成新的校准单
        $storage_check=new \App\storage_check;
        $storage_check->storage_check_time=date('Y-m-d H:i:s',time());
        $storage_check->storage_check_string=time().mt_rand(100000,999999);
        $storage_check->storage_check_admin=\Auth::user()->admin_id;
        $storage_check->storage_check_reload_time=date('Y-m-d H:i:s',time()+180);
        $storage_check->save();
        //如果为校准操作开启事务
        if($type)  DB::beginTransaction();
        //$storage_goods_abroad=\App\storage_goods_abroad::all();
        foreach($orders as $k => $v)
        {   
            //声明变量存放校准单数据
            $goods_check_data=[];
            //循环判断订单状态
            $goods_kind=\App\goods_kind::
            select('goods_kind_id','goods_product_id','goods_kind_user_type')
            ->where('goods_kind_id',\App\goods::select('goods_kind_id')->where('goods_id',$v->order_goods_id)->first()['goods_kind_id'])
            ->first();
            $goods_kind_id=$goods_kind->goods_kind_id;
            
            //实例化SKU复制SDK
            $skuSDK=new skuSDK($goods_kind_id,$goods_kind->goods_product_id,$goods_kind->goods_kind_user_type);
            $blade_type=\App\goods::select('goods_blade_type')->where('goods_id',$v->order_goods_id)->first()['goods_blade_type'];
            if($blade_type=='16'||$blade_type=='17'){
                switch ($v->order_country) {
                    case 'Saudi Arabia':
                        $blade_type=12;
                        break;
                    case 'United Arab Emirates':
                        $blade_type=2;
                        break;
                    case 'Qatar':
                        $blade_type=14;
                        break;
                    default:
                        $error = '中东地区未匹配';  
                        throw new \Exception($error);  
                        break;
                }
             }else{
                $blade_type=self::get_storage_area($blade_type);
             }
            //找到对应国外仓库
            $storage=\App\storage::where([['template_type_primary_id',$blade_type],['storage_status',1],['is_local',0]])->first();
            //证明没有对应海外仓
            if($storage==null) $orders->$k->is_forigen=false;
            //声明便令记录改订单是否可从国外仓发送状态
            $is_send=true;
            //获取订单配置信息数据
            $order_config=\App\order_config::select('order_primary_id','order_config')->where('order_primary_id',$v->order_id)->get()->toArray();
            //处理数据变更属性组加数目
            $new=[];
            $count=[];
            foreach($order_config as $key_s => $vall){
             if(in_array($vall, $new)){
               //dd(array_keys($new,$v)[0]);
               $count[array_keys($new,$vall)[0]]+=1;
             }else{
               $new[$key_s]=$vall;
               $count[$key_s]=1;
             }
            } 
            foreach($new as $kk => $vv){
                $new[$kk]['num']=$count[$kk];
            }
            $order_config=$new;
            unset($new,$count);
            //处理属性数据拼装产品属性id与SKU
            $is_new=true;//判断该单品是否配置新属性，如未配置新属性则无产品对应，SKU属性码为000000
            $is_out=true;//判断
            $is_forigen=true;//判断是否可以从海外仓发货
            foreach($order_config as $kkk => &$v_config){
                $goods_check_data[$kkk]['storage_check_data_order']=$v->order_id;
                $goods_check_data[$kkk]['storage_check_data_sku']=$goods_kind['goods_kind_sku'];
                $goods_check_data[$kkk]['storage_check_data_num']=$v_config['num'];
                $goods_check_data[$kkk]['storage_primary_id']=$storage_check->storage_check_id;
                $order_config_arr=explode(',', $v_config['order_config']);
                if(count($order_config_arr)<=0){
                    $v_config['sku']='000000';
                    continue;
                }
                foreach($order_config_arr as $kkkk => $v_config_arr)
                {
                    $config_val=\App\config_val::where([['config_val_id',$v_config_arr],['kind_val_id','>',0]])->first();
                    if($config_val==null){
                        //没有对应属性id信息
                        $is_new=false;
                        $v_config['kind_val_arr']=null;
                        break;
                    }
                    //向订单属性配置数据中增加对应产品属性的id
                    $v_config['kind_val_arr'][$kkkk]=$config_val['kind_val_id'];
                    $order_config_arr[$kkkk]=$config_val['kind_val_id'];
                }
                if(!$is_new){//属性未更新
                    $v_config['sku']='000000';
                    continue;
                }
                 //为订单属性分配属性SKU
                if(!isset($v_config['sku'])||$v_config['sku']!='000000'){
                     $sku=$skuSDK->get_all_sku($order_config_arr);
                     $v_config['sku']=substr($sku,4);
                }

                /////////////////////////////////////////////////////
                //sku获取逻辑完成,开始处理订单
                //1.判断订单状态（是否从海外仓发货）
                $is_split=$storage->is_split;
                $storage_id=$storage->storage_id;
                $order_config_sku=$v_config['sku'];//改属性SKU码
                $goods_check_data[$kkk]['storage_check_data_sixsku']=$order_config_sku;
                if($is_split=='1'){
                    //当海外仓允许拆分时
                    //1.判断海外仓中对应产品的对应属性的货物数目是否足够
                    $max_num=\App\storage_goods_abroad::select(\DB::raw('SUM(num) as num'))
                            ->where(function($query)use($order_config_sku,$storage_id,$goods_kind_id){
                                $query->where('sku_data', $order_config_sku);
                                $query->where('storage_primary_id', $storage_id);
                                $query->where('goods_kind_id', $goods_kind_id);
                                $query->where('expiry_at','>',date('Y-m-d H:i:s',time()));
                            })
                            ->first();
                    if($max_num['num']<$v_config['num']){
                        //海外仓对应属性的货物数目总和不足这条属性信息的数目，无法从海外仓发货
                        $is_forigen=false;
                        break;
                    }
                    //循环扣除货物
                    $goods_check_data[$kkk]['storage_abroad_id']=$storage_id;
                    $storage_goods_abroad=\App\storage_goods_abroad::select('order_id','order_single','sku','sku_data','goods_kind_id','num')
                            ->where(function($query)use($order_config_sku,$storage_id,$goods_kind_id){
                                $query->where('sku_data', $order_config_sku);
                                $query->where('storage_primary_id', $storage_id);
                                $query->where('goods_kind_id', $goods_kind_id);
                                $query->where('expiry_at','>',date('Y-m-d H:i:s',time()));
                            })
                            ->get();
                    $need_num=$v_config['num'];//当前所需货物数目
                    foreach($storage_goods_abroad as $k_abroad=>$v_abroad){
                        if($need_num<=0) break;
                        $need_num=$need_num-$v_abroad->num;
                        //记录被扣货订单、被扣货数目、被扣货sku
                        $goods_check_data[$kkk]['storage_from'][$k_abroad]['order_id']=$v_abroad['order_id'];
                        $goods_check_data[$kkk]['storage_from'][$k_abroad]['order_single']=$v_abroad['order_single'];
                        $goods_check_data[$kkk]['storage_from'][$k_abroad]['sku_data']=$v_abroad->sku_data;
                        if($need_num<=0){
                            //已扣除完毕，跳出循环
                             $goods_check_data[$kkk]['storage_from'][$k_abroad]['num']=$need_num+$v_abroad->num;
                             $v_abroad->update(['num'=>$v_abroad->num-$need_num]);
                             break;
                        }else{
                             $goods_check_data[$kkk]['storage_from'][$k_abroad]['num']=$v_abroad->num;
                             $v_abroad->update(['num'=>0]);
                        }
                    }

                }else{
                    //当海外仓不允许拆分时
                    $storage_goods_abroad=\App\storage_goods_abroad::where(function($query)use($order_config_sku,$storage_id,$goods_kind_id){
                                            $query->where('sku_data', $order_config_sku);
                                            $query->where('storage_primary_id', $storage_id);
                                            $query->where('goods_kind_id', $goods_kind_id);
                                            $query->where('expiry_at','>',date('Y-m-d H:i:s',time()));
                                        })
                                        ->groupBy($order_id)
                                        ->get();
                }

            }dd($goods_check_data);
            dd($order_config);
            //为每一个数据配置属性sku以便与库存中SKU比对
           /* $is_new=true;
            $is_out=true;
            foreach($order_config as $kkk => &$v_config){
                $order_config_arr=explode(',', $v_config['order_config']);
                if(count($order_config_arr)<=0){
                    $v_config['sku']='000000';
                    continue;
                }
                foreach($order_config_arr as $kkkk => $v_configv)
                {
                    $config_val=\App\config_val::where([['config_val_id',$v_configv],['kind_val_id','>',0]])->first();
                    if($config_val==null){
                        //没有配置新属性
                        $is_new=false;
                        $v_config['kind_val_arr']=null;
                        break;
                    }
                    //向订单属性配置数据中增加对应产品属性的id
                    $v_config['kind_val_arr'][$kkkk]=$config_val['kind_val_id'];
                    $order_config_arr[$kkkk]=$config_val['kind_val_id'];
                }
                if(!$is_new){
                    $v_config['sku']='000000';
                    continue;
                }
                $sku=$skuSDK->get_all_sku($order_config_arr);
                $v_config['sku']=substr($sku,4);
                //获取对应SKU码的仓储数据
                $storage_id=$storage->storage_id;
                $order_config_sku=$order_config[$kkk]['sku'];
                if($storage->is_split!='1'){
                    //当仓库为不可拆分类型时
                    $max_num_data=\App\storage_goods_abroad::select('num')
                                    ->where(function($query)use($storage_id,$order_config_sku){
                                        $query->where('sku_data', $order_config_sku);
                                        $query->where('storage_primary_id', $storage_id);
                                        $query->where('expiry_at','>',date('Y-m-d H:i:s',time()));
                                    })
                                    ->orderBy('num','desc')
                                    ->first();
                    if($max_num_data['num']<$v_config['num']){
                        //海外仓中没有足够数量的单个订单以供给此订单，无法从海外仓发单，结束循环并标记订单状态为国内仓发单
                        $orders->$k->is_forigen=false;
                        break;
                    }
                }
                $storage_goods_abroad_data=\App\storage_goods_abroad::select('storage_goods_abroad.*','sum(num) as num')
                                            ->where(function($query)use($storage_id,$order_config_sku){
                                                $query->where('sku_data', $order_config_sku);
                                                $query->where('storage_primary_id', $storage_id);
                                                $query->where('expiry_at','>',date('Y-m-d H:i:s',time()));
                                            })
                                            ->orderBy('expiry_at','asc')
                                            ->get();dd($storage_goods_abroad_data);
                //开始校准海外仓数据
                //\DB::beginTransaction();
                foreach($storage_goods_abroad as $keys => $vals){

                }
                //$storage_goods_abroad=\App\storage_goods_abroad;
                $is_order=true;
            }*/
            unset($skuSDK);
            //记录订单状态
            if($is_forigen){
                //国外仓发货
                $v->type='1';
            }else{
                if($is_less){
                    //本地仓缺货
                    $v->type='3';
                }else{
                    //本地仓发货
                    $v->type='2';
                }
            }
            
        }
        if($type) \DB::rollback();
    }
    /**
     * 根据订单所属单品模板地区获取订单所属仓库地区
     * @param  \Illuminate\Database\Eloquent\Collection $blade_type [description]
     * @return [type]                                               [description]
     */
    private static function get_storage_area( $type)
    {
        $arr=[
            0=>0,
            1=>0,
            2=>2,
            3=>3,
            4=>4,
            5=>5,
            6=>6,
            7=>7,
            8=>8,
            9=>10,
            10=>10,
            11=>11,
            12=>12,
            13=>12,
            14=>14,
            15=>14
        ];
        return $arr[$type];
    }
}
