<?php

namespace App\Http\Controllers\admin\worker;

use App\channel\Rediss;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MonitorController extends Controller
{
    /**
     * 网页监控
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        $redis = Rediss::getInstance();
        dd($redis->get("aa"));
        return view('worker.monitor.index');
    }
    /**
     * 配置设置
     */
    public function set(Request $request)
    {
    	if($request->isMethod('get')){
    		$worker_monitor=\App\worker_monitor::first();
    		if($worker_monitor==null){
    			$worker_monitor=['worker_monitor_start_time'=>'00:00:00','worker_monitor_stop_time'=>'23:59:59','worker_monitor_route_type'=>'0,1,2,3,4,5,6','worker_monitor_ip_type'=>'0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17'];
    		}else{
    			$worker_monitor=$worker_monitor->toArray();
    		}
    		return view('worker.monitor.set')->with(compact('worker_monitor'));
    	}elseif($request->isMethod('post')){
    		$data=$request->all();
    		if(explode(' ~ ', $data['laydate'])[0]==explode(' ~ ', $data['laydate'])[1]){
    			return response()->json(['err' => '0','str'=>'修改失败！时间范围非法！']);
    		}
    		$worker_monitor=\App\worker_monitor::first();
    		if($worker_monitor==null){
    			$worker_monitor=new \App\worker_monitor;
    		}
    		if(strtotime('2000-1-1 '.explode(' ~ ', $data['laydate'])[0])>strtotime('2000-1-1 '.explode(' ~ ', $data['laydate'])[1])){
    			$worker_monitor->worker_monitor_start_time=explode(' ~ ', $data['laydate'])[1];
    			$worker_monitor->worker_monitor_stop_time=explode(' ~ ', $data['laydate'])[0];
    		}
    		$worker_monitor->worker_monitor_route_type=implode(',', $data['worker_monitor_route_type']);
    		$worker_monitor->worker_monitor_ip_type=implode(',', $data['worker_monitor_ip_type']);
    		$msg=$worker_monitor->save();
    		if($msg){
            	return response()->json(['err' => '1', 'str' => '修改成功']);
    		}
    			return response()->json(['err' => '0','str'=>'修改失败！']);
    	}
    }
}
