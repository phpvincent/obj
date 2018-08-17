<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\admin;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
    public function index(){
    	
    	$counts=admin::count();
    	return view('admin.admin.index')->with(compact('counts'));
    }
    public function addadmin(Request $request){
    	if($request->isMethod('get')){
    		$roles=\App\role::get();
    		return view('admin.admin.addadmin')->with(compact('roles'));
    	}elseif($request->isMethod('post')){
    		$data=$request->all();
    		$admin=new admin();
    		$admin->admin_name=$data['admin_name'];
    		$admin->password=password_hash($data['password'], PASSWORD_BCRYPT);
    		if($data['admin_role_id']==0){
    			$admin->is_root='1';
    			$admin->admin_role_id='1';
    		}else{
    			$admin->admin_role_id=$data['admin_role_id'];
    		}
    		$msg=$admin->save();
    		if($msg){
    			 $ip=$request->getClientIp(); 
    			$time=date('Y-m-d H:i:s',time());
    			\Log::notice("【".$ip."】".Auth::user()->admin_name."于【".$time."]添加了".$data['admin_name'].'-'.\App\role::where('role_id',$data['admin_role_id'])->first()['role_name']."账户");
                    return response()->json(['err'=>1,'str'=>'添加成功']);
	        }else{
	                    return response()->json(['err'=>0,'str'=>'添加失败']);
	        }
    	}
    	
    }
    public function get_table(Request $request){
    	
    }
}
