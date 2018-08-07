<?php

namespace App\Http\Middleware;

use Closure;
use App\url;
use App\vis;
use DB;
class checkurl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   //存储访问者信息

        $goods_id=url::get_goods();
        $arr=getclientcity($request);
        $type=getclientype();
        $lan=getclientlan();
        $vis=new vis;
        $vis->vis_ip=$arr['ip'];
        $vis->vis_country=$arr['country'];
        $vis->vis_region=$arr['region'];
        $vis->vis_city=$arr['city'];
        $vis->vis_county=$arr['county'];
        $vis->vis_isp=$arr['isp'];
        $vis->vis_type=$type;
        $vis->vis_lan=$lan;
        $vis->vis_time=date('Y-m-d H:i:s',time());
        $vis->vis_goods_id=$goods_id;
        $vis->vis_url=$_SERVER['SERVER_NAME'];
        $vis->save();  
         if($goods_id=='4'){
            return redirect('index/fb');
        }                       
        //地区核审
        $area=explode(';', DB::table('pb')->first()->pb_ziduan);
        if(in_array($arr['region'], $area)||in_array($arr['country'],$area)||in_array($arr['city'],$area)){
            return redirect('index/index');
        }
        //ip核审
        $notallow=vis::where([['vis_ip','=',$arr['ip']],['vis_isback','=','1']])->first();
        if($notallow!=null){
            return redirect('index/index');
        }
        $url=$_SERVER['SERVER_NAME'];
        $is_use=url::is_use($url);
        if($is_use){
          return $next($request);
        }else{
          return redirect('index/index');
        }
        return $next($request);
    }
}

