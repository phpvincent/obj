<?php

namespace App\Http\Controllers\admin\storage;

use App\goods_kind;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\storage_append;
use App\storage_append_data;
class StorageAddController extends Controller
{
    public function add(Request $request)
    {
    	if($request->isMethod('get')){
    		return view('storage.add.add');
    	}elseif($request->isMethod('post')){

    	}
    }

    /**
     * 新增补货单
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_goods(Request $request)
    {
        if($request->isMethod('get')){
            $product = goods_kind::all();
            return view('storage.add.add_goods')->with(compact('product'));
        }elseif($request->isMethod('post')){

        }
    }
}
