<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
class ManagerController extends Controller
{
    public function login(Request $request){
        if($request->isMethod('get')){
        	return view('admin.login.login');
        }elseif($request->isMethod('post')){
        	$validator=Validator::make($request->all(),[
	           "username"=>"required|min:2|max:16",
	           "password"=>"required|between:4,20",
	           "captcha"=>"required|size:4|captcha",
	         	]);
        	 if($validator->fails()){
	         	return redirect('/admin/login')->withErrors($validator)->withInput();
	         }

	        $username=$request->input('username');
	       	$password=$request->input('password');
	       	if(Auth::guard('check')->attempt(['admin_name'=>$username,'password'=>$password])){
	          $ip=$request->getClientIp();   
	          $time=date('Y-m-d H:i:s',time());
	          $admin=\App\admin::where('admin_name',$request->input('username'))->first();
	          if($admin->admin_use!='1'){
	          	return redirect('admin/login')
	       		->withErrors(["loginError"=>"此账户无法使用!请联系管理员!"])
	       		->withInput();
	          }
	          if($admin->admin_ip!=null){
	          	$cookie1=Cookie::forever('l_ip',$admin->admin_ip);
	          	$cookie2=Cookie::forever('l_time',$admin->admin_time);
	          	$cookie3=Cookie::forever('l_num',$admin->admin_num);
	          }else{
	          	$cookie1=Cookie::forever('l_ip','初次登陆');
	          	$cookie2=Cookie::forever('l_time','初次登陆');
	          	$cookie3=Cookie::forever('l_num','初次登陆');
	          }
	          $admin->admin_ip=$ip;
	          $admin->admin_time=$time;
	          $admin->admin_num=$admin->admin_num+1;
	          $admin->save();
	          Log::notice('['.$time.']'.$username.'账户登录于'.$ip);
	       		return redirect('/admin/index')->withCookie($cookie1)->withCookie($cookie2)->withCookie($cookie3);
	       	}else{
	       		return redirect('admin/login')
	       		->withErrors(["loginError"=>"用户名或密码错误!"])
	       		->withInput();
	       	};
        }
    }
}
