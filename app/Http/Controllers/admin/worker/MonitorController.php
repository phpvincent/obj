<?php

namespace App\Http\Controllers\admin\worker;

use App\channel\IpLocation;
use App\channel\Rediss;
use App\goods;
use App\site;
use App\url;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MonitorController extends Controller
{
    protected $redis;

    /**
     * 构造方法
     * MonitorController constructor.
     */
    public function __construct()
    {
        $this->redis = Rediss::getInstance();
    }

    /**
     * 网页监控
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        return view('worker.monitor.index');
    }


    /**
     * 获取访问数据列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_table(Request $request)
    {
        $data =  $this->redis->hGetAll('routes');
        $routes = [];
        $count = count($data);
        //地区
        //总数
        $total_num = 0;
        if($count != 0){
            foreach ($data as $key=>$value){
                $url = trim($key);
                $arr = goods::url_get_goods_id($url);
                $arr['route'] = $url;
                $arr['num'] = $value;
                $total_num += $value;
                array_push($routes,$arr);
            }
        }
        return response()->json(['code' => 0, "msg" => "获取数据成功",'num'=>$total_num,'count'=>$count, 'data' => $routes]);
    }

    /**
     * 正在浏览网页的用户IP
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ip_list(Request $request)
    {
        $route = $request->input('route');
        $ip_data = $this->redis->hGet('routes_ips',$route);
        $ip_list = explode(',',$ip_data);
        $data = [];
        $ip_city = new IpLocation();
        if(count($ip_list) > 0){
           foreach ($ip_list as $value){
               if($value){
                   $arr['ip'] = $value;
                   $location = $ip_city->getlocation($value);
                   if(!empty($location) && isset($location['province'])){
                       $arr['city'] = $location['province'];
                   }else{
                       $arr['city'] = "";
                   }
                   array_push($data,$arr);
               }
           }
        }
        $count = count($data);
        return response()->json(['code' => 0, "msg" => "获取数据成功",'count'=>$count, 'data' => $data]);
    }

    /**
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function ip_info(Request $request)
    {
        $ip = $request->input('ip');
        $ip_data = $this->redis->hGet('route_ip_msg',$ip);
        $ip_list = json_decode($ip_data,true);
        return response()->json(['code' => 0, "msg" => "获取数据成功", 'data' => $ip_list]);
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
    		if(strtotime('2000-1-1 '.explode(' ~ ', $data['laydate'])[0])<strtotime('2000-1-1 '.explode(' ~ ', $data['laydate'])[1])){
    			$worker_monitor->worker_monitor_start_time=explode(' ~ ', $data['laydate'])[0];
    			$worker_monitor->worker_monitor_stop_time=explode(' ~ ', $data['laydate'])[1];
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

    /**
     * 监控台
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function console_board(Request $request)
    {
        $data = [];
        if($this->redis->exists('today_time')){
            $today_data = $this->redis->hGetAll('today_time');
            if(!empty($today_data)){
                foreach ($today_data as $key => $value){
                    if($page_data = json_decode($value,true)){
                        $url = trim($key);
                        $arr = goods::url_get_goods_id("http://192.168.10.10/index/site_goods/45");
                        $arr['count'] = $page_data['count'];
                        $arr['stay_time'] = $page_data['time'];
                        $arr['url'] = $url;
                        $arr['time'] = $page_data['date'];
                        array_push($data,$arr);
                    }
                }
            }
        }
        return view('worker.monitor.console_board')->with(compact('data'));
    }
}
