<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
use Validator;
use Illuminate\Support\Facades\Auth;
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
	          Log::notice($username.'账户登录于'.$ip);
	       		return redirect('/admin/index');
	       	}else{
	       		return redirect('admin/login')
	       		->withErrors(["loginError"=>"用户名或密码错误!"])
	       		->withInput();
	       	};
        }
    }
}
