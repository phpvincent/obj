<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
class StorageController extends Controller
{
    public function index(){
    	return view('storage.father.father');
    }
    public function homepage(){
       
    	return view('storage.index.index');
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
