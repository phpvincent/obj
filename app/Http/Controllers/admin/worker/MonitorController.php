<?php

namespace App\Http\Controllers\admin\worker;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class MonitorController extends Controller
{
    /**
     * 网页监控
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        Redis::set('aa','100');
        dd(Redis::get('aa'));
        return view('worker.monitor.index');
    }
}
