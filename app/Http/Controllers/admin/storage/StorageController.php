<?php

namespace App\Http\Controllers\admin\storage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class StorageController extends Controller
{
    public function index(){
    	return view('storage.father.father');
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
    	return view('storage.index.index')->with(compact('order_count','yse_order_count','t_out_today','y_out_today','t_splite_count','y_splite_count'));
    }
    public function notallow(){
    	return view('storage.notallow');
    }
    public function blade(Request $request){
    	$type=$request->has('type')?$request->input('type'):'index.balde.php';
    	\View::addExtension('html','php');
		return  view()->file(public_path().'/admin/layuiadmin/html/'.$type);
    }
    public function admin_info(Request $request)
    {
    	return view('storage.admin.info');
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
