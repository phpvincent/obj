<?php

namespace App\Http\Controllers\admin\worker;

use App\storage;
use App\storage_check_data;
use App\storage_log;
use App\storage_log_data;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class WorkerController extends Controller
{
    public function index(){
        return view('worker.father.father');
    }
    public function homepage(){
        $today=Carbon::today()->toDateString().' 00:00:00';
        $yes=Carbon::yesterday()->toDateString().' 00:00:00';
        $order_count=\App\order::where([['is_del',0],['order_time','>',$today]])->count();
        $yse_order_count=\App\order::where([['is_del',0],['order_time','>',$yes]])->count();
        $t_out_today=\App\order::where([['order_type',3],['is_del',0],['order_time','>',$today]])->count();
        $y_out_today=\App\order::where([['order_type',3],['is_del',0],['order_time','>',$yes]])->count();
        $t_splite_count=\App\order::where([['order_type',4],['is_del',0],['order_time','>',$today]])->count();
        $y_splite_count=\App\order::where([['order_type',4],['is_del',0],['order_time','>',$yes]])->count();
        //
        $start = date("Y-m-d").' 00:00:00';
        $end  = date("Y-m-d",time()+86400).' 00:00:00';
        $storages_log_in = storage_log::whereBetween('created_at',[$start,$end])->where('storage_log_type',7)->where('storage_log_operate_type',0)->get();
        $storages_log_out = storage_log::whereBetween('created_at',[$start,$end])->where('storage_log_type',6)->where('storage_log_operate_type',2)->get();
        //获取仓库总个数
        $storage_num = storage::count();
        //仓库补货率
        $storage_lv = '0%';
        $storage_out_lv = '0%';
        if($storage_num > 0){
            $storage_ids = [];
            if(!$storages_log_in->isEmpty()){
                foreach ($storages_log_in as $item){
                    $storage_log_datas = storage_log_data::where('storage_log_primary_id',$item->storage_log_id)->get();
                    if(!$storage_log_datas->isEmpty()){
                        foreach ($storage_log_datas as $storage_log_data){
                            $storage_data = unserialize($storage_log_data->storage_log_data);
                            if(isset($storage_data['storage_id'])){
                                $storage_id = $storage_data['storage_id'];
                                if(!in_array($storage_id,$storage_ids)){
                                    array_push($storage_ids,$storage_data['storage_id']);
                                }
                            }
                        }
                    }
                }
            }
            $storage_out_ids = [];
            if(!$storages_log_out->isEmpty()){
                foreach ($storages_log_in as $item){
                    $storage_log_datas = storage_log_data::where('storage_log_primary_id',$item->storage_log_id)->get();
                    if(!$storage_log_datas->isEmpty()){
                        foreach ($storage_log_datas as $storage_log_data){
                            $storage_data = unserialize($storage_log_data->storage_log_data);
                            if(isset($storage_data['order_ids'])){
                                $storage_check_datas = storage_check_data::where('storage_check_data_order',$storage_data['order_ids'])->get();
                                if(!$storage_check_datas->isEmpty()){
                                    foreach ($storage_check_datas as $storage_check_data){
                                        if($storage_check_data->storage_abroad_id == '#'){
                                            $storage_check_data->storage_abroad_id = storage::where('is_local',1)->first()['storage_id'];
                                        }
                                        if(!in_array($storage_check_data->storage_abroad_id,$storage_out_ids)){
                                            array_push($storage_out_ids,$storage_check_data->storage_abroad_id);
                                        }
                                    }
                                }
                            }

                        }
                    }
                }
            }
            //补货率
            $storage_lv = sprintf("%.4f", count($storage_ids)/$storage_num)*100 .'%';
            //出货率
            $storage_out_lv = sprintf("%.4f", count($storage_out_ids)/$storage_num)*100 .'%';
        }
        
        return view('worker.index.index')->with(compact('storage_lv','storage_out_lv','order_count','yse_order_count','t_out_today','y_out_today','t_splite_count','y_splite_count'));
    }
    public function notallow(){
        return view('worker.notallow');
    }
    public function blade(Request $request){
        $type=$request->has('type')?$request->input('type'):'index.balde.php';
        \View::addExtension('html','php');
        return  view()->file(public_path().'/admin/layuiadmin/html/'.$type);
    }
    public function admin_info(Request $request)
    {
        return view('worker.admin.info');
    }
    /**
     * 修改个人信息
     */
    public function up_self(Request $request)
    {
        $data=$request->only('admin_show_name');
        $msg=\app\admin::where('admin_id',\Auth::user()->admin_id)->update($data);
        //$msg=\Auth::user()->update($data);
        $ip = $request->getClientIp();
        //添加补货单日志
        operation_log($ip,'修改个人信息,修改人：'.$request->input('admin_show_name'),json_encode($request->all()));
        if(!$msg){
            return response()->json(['err'=>0,'str'=>'个人信息修改失败！']);
        }
        return response()->json(['err'=>1,'str'=>'修改成功~']);
    }
    public function password(Request $request)
    {
        if($request->isMethod('get')){
            return view('storage.admin.password');
        }elseif($request->isMethod('post')){
            $data=$request->only('password');
            $data['password']=password_hash($data['password'],PASSWORD_BCRYPT);
            $msg=\app\admin::where('admin_id',\Auth::user()->admin_id)->update($data);
            $ip = $request->getClientIp();
            //添加补货单日志
            operation_log($ip,'修改个人密码,修改人：'.Auth::user()->admin_name,json_encode($request->all()));
            if(!$msg){
                return response()->json(['err'=>0,'str'=>'密码修改失败！']);
            }
            return response()->json(['err'=>1,'str'=>'修改成功~']);
        }
    }
    public function jsq(Request $request)
    {
        return view('storage.storage.jsq');
    }
}
