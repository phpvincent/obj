<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index(Request $request){

    	$hcoun=\App\order::where('order_type','0')->count();
    	view()->share('hcoun',$hcoun);
    	return view('admin.father.app')->with('hcoun',$hcoun);
    }
    public function welcome(){

    	return view('admin.index.index');
    }

}
