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
}
