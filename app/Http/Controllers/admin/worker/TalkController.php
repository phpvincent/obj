<?php

namespace App\Http\Controllers\admin\worker;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TalkController extends Controller
{
    public function index(Request $request)
    {
    	return view('worker.talk.index');
    }
    public function msg_log(Request $request)
    {
    	$admin_id=$request->input('admin_id');
    	return view('worker.talk.msg_log')->with(compact('admin_id'));
    }
}
