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
                $search = '~^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?~i';
                $url = trim($key);
//                $url = "http://192.168.10.10/pay?goods_id=75";
//                $url = "http://192.168.10.10/activity/2";
//                $url = "http://192.168.10.10/index/site_goods/45";
//                $url = "http://192.168.10.10/endsuccess?type=1&goods_id=986&order_id=36322";
//                $url = "http://192.168.10.10/send?goods_id=98";
                preg_match_all($search, $url ,$rr);
                $arr['sites_name'] = "";
                $arr['goods_id'] = "";
                $arr['goods_name'] = "";
                $arr['route_name'] = "";
                $arr['area'] = "";
                //根据路由获取路由为站点，还是单品
                if(isset($rr[4][0])){
                    $get_url = $rr[4][0];
                    if(substr($get_url,0,4) == 'www.'){
                        $get_url = substr($get_url,4);
                    };
                    $urls = url::where('url_url',$get_url)->first();
                    if($urls && $urls->url_site_id){ //站点
                        //站点名称
                        $site = site::where('sites_id',$urls->url_site_id)->first();
                        if($site){
                            $arr['sites_name'] = $site->sites_name;
                            $arr['area'] = goods::get_blade_currency($site->sites_blade_type);
                        }
                        if(preg_match("/\/activity\/\d+$/", $url)){
                            $len = strrpos($url,'activity');
                            $goods_id = substr($url,$len+9);
                            $arr['route_name'] = "站点列表页";
                            $arr['goods_id'] = $goods_id;
                            $arr['goods_name'] = goods::where('goods_id',$goods_id)->first()['goods_real_name'];
                        }elseif (preg_match("/\/index\/site_goods\/\d+$/", $url)){
                            $len = strrpos($url,'site_goods');
                            $goods_id = substr($url,$len+11);
                            $arr['route_name'] = "商品落地页";
                            $arr['goods_id'] = $goods_id;
                            $arr['goods_name'] = goods::where('goods_id',$goods_id)->first()['goods_real_name'];
                        }elseif(preg_match("/\/pay/", $url)){
                            $len = strrpos($url,'pay');
                            $goods_id = substr($url,$len+13);
                            $arr['goods_id'] = $goods_id;
                            $arr['goods_name'] = goods::where('goods_id',$goods_id)->first()['goods_real_name'];
                            $arr['route_name'] = "商品下单页";
                        }elseif(preg_match("/\/endsuccess/", $url)){
                            $arr['route_name'] = "下单成功页";
                            $len = strrpos($url,'endsuccess');
                            $last_add = strrpos($url,'&');
                            $num = $last_add - $len - 27;
                            $goods_id = substr($url,$len+27,$num);
                            $arr['goods_id'] = $goods_id;
                            $arr['goods_name'] = goods::where('goods_id',$goods_id)->first()['goods_real_name'];
                        }elseif(preg_match("/\/send/", $url)){
                            $len = strrpos($url,'send');
                            $goods_id = substr($url,$len+14);
                            $arr['goods_id'] = $goods_id;
                            $arr['goods_name'] = goods::where('goods_id',$goods_id)->first()['goods_real_name'];
                            $arr['route_name'] = "订单查询页";
                        }else{
                            $arr['route_name'] = "站点首页";
                            $arr['goods_id'] = "";
                            $arr['goods_name'] = "";
                        }
                    }else if($urls && $urls->url_goods_id){ //单页 //TODO 有遮罩商品需要测试
                        $arr['sites_name'] = '';
                        $arr['goods_id'] = $urls->url_goods_id;
                        $area = $this->get_goods_type($urls->url_goods_id);
                        $arr['goods_name'] = $area['goods_name'];
                        $arr['area'] = $area['area'];
                        if(preg_match("/\/pay/", $url)){
                            $arr['route_name'] = "商品下单页";
                        }elseif(preg_match("/\/endsuccess/", $url)){
                            $arr['route_name'] = "下单成功页";
                        }elseif(preg_match("/\/send/", $url)){
                            $arr['route_name'] = "订单查询页";
                        }else{
                            $arr['route_name'] = "商品落地页";
                        }

                    }else if($urls && $urls->url_zz_goods_id){
                        $arr['sites_name'] = '';
                        $arr['goods_id'] = $urls->url_zz_goods_id;
                        $area = $this->get_goods_type($urls->url_zz_goods_id);
                        $arr['goods_name'] = $area['goods_name'];
                        $arr['area'] = $area['area'];
                        if(preg_match("/\/pay/", $url)){
                            $arr['route_name'] = "商品下单页";
                        }elseif(preg_match("/\/endsuccess/", $url)){
                            $arr['route_name'] = "下单成功页";
                        }elseif(preg_match("/\/send/", $url)){
                            $arr['route_name'] = "订单查询页";
                        }else{
                            $arr['route_name'] = "商品落地页";
                        }
                    }
                }

                $arr['route'] = $url;
                $arr['num'] = $value;
                $total_num += $value;
                array_push($routes,$arr);
            }
        }
        return response()->json(['code' => 0, "msg" => "获取数据成功",'num'=>$total_num,'count'=>$count, 'data' => $routes]);
    }

    /**
     * 获取商品地区、商品名称
     * @param $goods_id
     * @return mixed
     */
    private function get_goods_type($goods_id)
    {
        $goods = goods::where('goods_id',$goods_id)->first();
        if($goods){
            $arra['goods_name'] = $goods->goods_real_name;
            $arra['area'] = goods::get_blade_currency($goods->goods_blade_type);
        }else{
            $arra['goods_name'] = '';
            $arra['area'] = '';
        }
        return $arra;
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
}
