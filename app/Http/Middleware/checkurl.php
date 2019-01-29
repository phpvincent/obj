<?php

namespace App\Http\Middleware;

use Closure;
use App\url;
use App\vis;
use App\site;
use App\channel\domainCheck;
use DB;
use Illuminate\Support\Facades\Cookie;
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
    {
    //判断是否为预览操作
    $is_test=\Session::get('test_id',0);
    if($is_test!=0){
        view()->share('vis_id',0);
        return $next($request);
    }   
    //域名解析逻辑
        $url=$_SERVER['SERVER_NAME'];
        //将www二级域名去除
        if(substr($url,0,4)=='www.'){
            $url=substr($url, 4);
        } 
        //示例域名检测SDK
         $arr=getclientcity($request);
         $lan=getclientlan(); 
         try{
              $type=getclientype();
          }catch(\Exception $e){
              $type='unknow';
          }
          if(!isset($type)){
              $type='unknow';
          }
         $domainCheck=new domainCheck($url,$arr,$lan,$type); 
         //判断是否为站点访问
         $is_site=site::is_site($url);
         if($is_site){
           $site_id=site::get_id($url);
           $domainCheck->setParam(['site_id'=>$site_id]);
           $request->attributes->add(['is_site'=>true]);
           $request->attributes->add(['site_id'=>$site_id]);
         }else{
           $level=url::getlevel();
           $for=url::getzzfor();
           $goods_id=url::get_id();
            if(!$goods_id||$goods_id=='4'){
                return redirect('index/fb');
            } 
           $domainCheck->setParam(['level'=>$level,'for'=>$for,'goods_id'=>$goods_id]);
           $domainCheck->checkUrl($request);
           if($domainCheck->redirect_msg==3)   abort(404, 'nothing to show');
         }
         //记录访问信息
         $vis_id=$domainCheck->save_vis($request);
          view()->share('vis_id',$vis_id);
        //地区核审与ip核审
      $domainCheck->check_pb();
      //判断访问导向
       switch ($domainCheck->redirect_msg) {
         case 3:
           abort(404, 'nothing to show');
           break;
         case 4:
           return redirect('index/fb');
           break;
         default:
          return $next($request);
           break;
       }
/*        return $next($request);
*/    }
}

