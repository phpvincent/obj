<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class PayController extends Controller
{
    public function index(Request $request)
    {
    	if(Auth::user()->is_root=='1'){
    		$admins=\App\admin::get();
    	}else{
    		$admins=\App\admin::whereIn('admin_id',\App\admin::get_group_ids(Auth::user()->admin_id))->get();
    	}
    	$counts=$admins->count();
    	return view('admin.pay.index')->with(compact('admins','counts'));
    }
}
