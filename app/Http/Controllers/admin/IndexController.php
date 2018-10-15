<?php

namespace App\Http\Controllers\admin;

use App\admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class IndexController extends Controller
{
    public function index(Request $request){
    	$data=getclientcity($request);
    	$hcoun=\App\order::where([['order_type','0'],['is_del','0']])
        ->where(function($query){
//            if(Auth::user()->is_root!='1'){
//                        $query->whereIn('order.order_goods_id',\App\goods::get_selfid(Auth::user()->admin_id));
//              }
                          $query->whereIn('order.order_goods_id',admin::get_goods_id());
        })
        ->count();
    	view()->share('hcoun',$hcoun);
    	return view('admin.father.app')->with(compact('data'));
    }
    public function welcome(Request $request){
    	$data=getclientcity($request);
    	return view('admin.index.index')->with(compact('data'));
    }

}
