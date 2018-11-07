<?php

namespace App\Http\Controllers\admin;

use App\admin;
use App\goods;
use App\goods_kind;
use App\kind_config;
use App\kind_val;
use App\order;
use App\special;
use App\spend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\vis;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class KindController extends Controller
{
    /** 列表页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $counts=DB::table('goods_kind')
            ->count();
        return view('admin.kind.index')->with('counts',$counts);
    }

    /** 产品列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_table(Request $request)
    {
        $info=$request->all();
        $cm=$info['order'][0]['column'];
        $dsc=$info['order'][0]['dir'];
        $order=$info['columns']["$cm"]['data'];
        $draw=$info['draw'];
        $start=$info['start'];
        $len=$info['length'];
        $search=trim($info['search']['value']);
        $counts = goods_kind::count();
        //产品个数
        $newcount = goods_kind::where(function($query)use($search){
            $query->where('goods_kind_name','like',"%$search%");
        })->count();
        //产品信息
        $data = goods_kind::where(function($query)use($search){
            $query->where('goods_kind_name','like',"%$search%");
        })
        ->orderBy($order,$dsc)
        ->offset($start)
        ->limit($len)
        ->get();
        if(!$data->isEmpty()){
            foreach ($data as &$item)
            {
                $item->num = goods::where('goods_kind_id',$item->goods_kind_id)->where('is_del','0')->count();
            }
        }
        $arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>$data];
        return response()->json($arr);
    }

    /** 新增产品
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function addkind(Request $request)
    {
        //新增产品
        if($request->isMethod('get')){
            $id = $request->input('id') ? $request->input('id') : 0;
            $goods_kinds=\App\goods_kind::get();
            foreach($goods_kinds as $k => $v){
                $goods_kinds[$k]->goods_kind_name=$v->goods_kind_name.'('.goods::where('goods_kind_id',$v->goods_kind_id)->count().')';
            }
            return view('admin.kind.addkind')->with(compact('goods_kinds','id'));
        }elseif($request->isMethod('post')){
            //新增产品属性名、属性值
            //1.验证字段是否漏填
            $goods_config_name = $request->input('goods_config_name');
            $data_null = false; //判断产品是否只有一个属性，并且为空，属性为空为true；
            if($goods_config_name){
                foreach ($goods_config_name as $item)
                {
                    if(count($goods_config_name) == 1){
                        if(!$item['goods_config_name']){
                            foreach ($item['msg'] as $val){
                                if(!$val['goods_config']){
                                    $data_null = true;
                                }
                            }
                        }
                    }
                    if($data_null == false){
                        if(!isset($item['goods_config_name']) || !$item['goods_config_name'] || !isset($item['msg']) || empty($item['msg'])){
                            return response()->json(['err' => '0', 'msg' => '产品属性名或者属性值不能为空!']);
                        }
                        foreach ($item['msg'] as $val){
                            if(!isset($val['goods_config']) || !$val['goods_config']){
                                return response()->json(['err' => '0', 'msg' => '产品属性值不能为空!']);
                            }
                        }
                    }
                }
            }
            if(!$request->has('goods_kind_name')||$request->input('goods_kind_name')==''||$request->input('goods_kind_name')==null){
                return response()->json(['err' => '0', 'msg' => '信息错误!']);
            }

            //2.验证产品名是否重复
            $goods_kind_name = $request->input('goods_kind_name');
            $goods_kind = goods_kind::where('goods_kind_name',$goods_kind_name)->first();
            if($goods_kind){
                return response()->json(['err' => '0', 'msg' => '产品名称已存在，添加失败!']);
            }

            //3.新增产品
            $goods_kind=new \App\goods_kind;
            $goods_kind->goods_kind_name=$goods_kind_name;
            $goods_kind->goods_buy_url=$request->input('goods_buy_url');
            $goods_kind->goods_buy_msg=$request->input('goods_buy_msg');
            $goods_kind->goods_kind_admin=Auth::user()->admin_id;
            $goods_kind->goods_kind_time=date("Y-m-d H:i:s",time());
            $msg=$goods_kind->save();
            $kind_primary_id = $goods_kind->goods_kind_id;
            if($msg && !$data_null && $goods_config_name){
                //添加产品属性和产品属性值
                foreach ($goods_config_name as $item)
                {
                    $kind_config = new kind_config();
                    $kind_config->kind_config_msg = $item['goods_config_name'];
                    $kind_config->kind_primary_id = $kind_primary_id;
                    $kind_config_bool = $kind_config->save();
                    $kind_config_id = $kind_config->kind_config_id;
                    //新增属性值
                    if($kind_config_bool){
                        foreach ($item['msg'] as $value)
                        {
                            $kind_val = new kind_val();
                            $kind_val->kind_val_msg = $value['goods_config'];
                            $kind_val->kind_primary_id = $kind_primary_id;
                            $kind_val->kind_type_id = $kind_config_id;
                            $kind_val->save();
                        }
                    }

                }
            }
            if($msg){
                $ip = $request->getClientIp();
                //加log日志
                operation_log($ip,'新增产品成功,产品名称：'.$goods_kind_name);
                return response()->json(['err' => '1', 'msg' => '添加成功!']);
            }else{
                return response()->json(['err' => '0', 'msg' => '添加失败!']);
            }
        }
    }


    /** 修改产品页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function upgoods_kind(Request $request)
    {
        $goods_kinds_id = $request->input('id');
        $goods_kinds = goods_kind::where('goods_kind_id',$goods_kinds_id)->value('goods_kind_name');
        return view('admin.kind.upgoods_kind')->with(compact('goods_kinds_id','goods_kinds'));
    }

    /** 修改产品属性与规格
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function post_update(Request $request)
    {
        if($request->isMethod('get')) {
            $goods_kinds_id = $request->input('id');
            $goods_kinds = goods_kind::where('goods_kind_id',$goods_kinds_id)->first();
//            if(!$goods_kinds){
//                return view('admin.kind.kind_config_val')->with(compact('goods_kinds','goods_config'));
//            }
            $goods_config=\App\kind_config::where('kind_primary_id',$goods_kinds_id)->get();
            if($goods_config!=null){
                foreach($goods_config as $k => $v){
                    $arr=\App\kind_val::where('kind_type_id',$v->kind_config_id)->orderBy('kind_val_id','asc')->get()->toArray();
                    $goods_config[$k]->config_msg=$arr;
                }
            }
            return view('admin.kind.kind_config_val')->with(compact('goods_kinds','goods_config'));
        }else if($request->isMethod('post')){
            //修改产品信息
            $kind_primary_id = $request->input('goods_kind_id');
            $goods_kind = goods_kind::where('goods_kind_id',$kind_primary_id)->first();
            $goods_kind->goods_buy_url = $request->input('goods_buy_url');
            $goods_kind->goods_buy_msg = $request->input('goods_buy_msg');
            $goods_kind->goods_kind_admin = Auth::user()->admin_id;
            $goods_kind->save();

            //1.验证字段是否漏填
            $goods_config_name = $request->input('goods_config_name');
            $data_null = false; //判断产品是否只有一个属性，并且为空，属性为空为true；
            if($goods_config_name){
                foreach ($goods_config_name as $item)
                {
                    if(count($goods_config_name) == 1){
                        if(!$item['goods_config_name']){
                            foreach ($item['msg'] as $val){
                                if(!$val['goods_config']){
                                    $data_null = true;
                                }
                            }
                        }
                    }
                    if($data_null == false) {
                        if (!isset($item['goods_config_name']) || !$item['goods_config_name'] || !isset($item['msg']) || empty($item['msg'])) {
                            return response()->json(['err' => '0', 'msg' => '产品属性名或者属性值不能为空!']);
                        }
                        foreach ($item['msg'] as $val) {
                            if (!isset($val['goods_config']) || !$val['goods_config']) {
                                return response()->json(['err' => '0', 'msg' => '产品属性值不能为空!']);
                            }
                        }
                    }
                }
            }
            if(!$data_null && $goods_config_name){ //产品属性不为空
                //添加产品属性和产品属性值
                foreach ($goods_config_name as $item)
                {
                    if(isset($item['id'])){
                        $kind_config = kind_config::where('kind_config_id',$item['id'])->first();
                    }else{
                        $kind_config = new kind_config();
                    }
                    $kind_config->kind_config_msg = $item['goods_config_name'];
                    $kind_config->kind_primary_id = $kind_primary_id;
                    $kind_config_bool = $kind_config->save();
                    $kind_config_id = $kind_config->kind_config_id;
                    //新增属性值
                    if($kind_config_bool){
                        foreach ($item['msg'] as $value)
                        {
                            if(isset($value['id'])){
                                $kind_val = kind_val::where('kind_val_id',$value['id'])->first();
                            }else{
                                $kind_val = new kind_val();
                            }
                            $kind_val->kind_val_msg = $value['goods_config'];
                            $kind_val->kind_primary_id = $kind_primary_id;
                            $kind_val->kind_type_id = $kind_config_id;
                            $kind_val->save();
                        }
                    }
                }
            }
            $ip = $request->getClientIp();
            //加log日志
            operation_log($ip,$goods_kind->goods_kind_name.'产品修改成功');
            return response()->json(['err' => '1', 'msg' => '产品属性修改成功!']);
        }
    }

    /** 删除产品
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delkind(Request $request)
    {
        $id = $request->input('id');
        $goods_kinds = goods_kind::where('goods_kind_id',$id)->first();
        if(!$goods_kinds){
            return response()->json(['err' => '0', 'str' => '产品不存在!']);
        }
        $goods = goods::where('goods_kind_id',$id)->get();
        if(!$goods->isEmpty()){
            return response()->json(['err' => '0', 'str' => '该产品名称已绑定商品，不可删除!']);
        }
        $goods_kind = goods_kind::where('goods_kind_id',$id)->delete();
        if($goods_kind){
            $ip = $request->getClientIp();
            //加log日志
            operation_log($ip,$goods_kinds->goods_kind_name.'产品删除成功');
            return response()->json(['err' => '1', 'str' => '删除成功!']);
        }else{
            return response()->json(['err' => '0', 'str' => '删除失败!']);
        }
    }

    /** 产品属性详情
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        $goods_kinds_id = $request->input('id');
        $goods_config=\App\kind_config::where('kind_primary_id',$goods_kinds_id)->get();
        if($goods_config!=null){
            foreach($goods_config as $k => $v){
                $arr=\App\kind_val::where('kind_type_id',$v->kind_config_id)->orderBy('kind_val_id','asc')->get()->toArray();
                $goods_config[$k]->config_msg=$arr;
            }
        }
        return view('admin.kind.show')->with(compact('goods_config'));
    }

}
