<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index(Request $request){
    	$data=getclientcity($request);
    	$hcoun=\App\order::where([['order_type','0'],['is_del','0']])->count();
    	view()->share('hcoun',$hcoun);
    	return view('admin.father.app')->with(compact('data'));
    }
    public function welcome(Request $request){
    	$data=getclientcity($request);
    	return view('admin.index.index')->with(compact('data'));
    }

}
