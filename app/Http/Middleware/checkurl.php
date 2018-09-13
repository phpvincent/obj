<?php

namespace App\Http\Middleware;

use Closure;
use App\url;
use App\vis;
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
    //判断是否有此域名是否正在使用
        $url=$_SERVER['SERVER_NAME'];
         $is_use=url::is_use($url);
        if(!$is_use){
         return redirect('index/fb');
        }
        $is_zz=false;
        $arr=getclientcity($request);
        $type=getclientype();
        $lan=getclientlan(); 
        $level=url::getlevel();
        $for=url::getzzfor();
        switch ($level) {
            case '0':
               $is_zz=false;
                break;
            case '1':
                if(strpos($arr['region'],"美国")!==false||strpos($arr['country'],"美国")!==false||strpos($arr['city'],"美国")!==false||strpos($arr['region'],"USA")!==false||strpos($arr['country'],"USA")!==false||strpos($arr['city'],"USA")!==false){
                    if(strpos($arr['isp'],"脸书")!==false||strpos($arr['isp'],"facebook")!==false||strpos($arr['isp'],"Facebook")!==false){
                      $is_zz=true;
                    }
                  }
                break;
            case '2':
                if(strpos($arr['isp'],"脸书")!==false||strpos($arr['isp'],"facebook")!==false||strpos($arr['isp'],"Facebook")!==false){
                      $is_zz=true;
                    }
                break;
            case '3':
                if($arr['country']!='台湾省'&&$arr['region']!='台湾省'&&$arr['country']!='台湾'&&$arr['region']!='台湾'){
                     $is_zz=true;
                }
                 if(strpos($arr['isp'],"脸书")!==false||strpos($arr['isp'],"facebook")!==false||strpos($arr['isp'],"Facebook")!==false){
                      $is_zz=true;
                    }
                break;
            case '4':
                $is_zz=true;
            break;
            default:
               
                break;
        }
        $goods_id=url::get_id();
         //检测核审机制是否开启
        if(\App\goods_check::first()['goods_is_check']==0){
        //检测单品是否触发核审并已超过保护期
            $goods=\App\goods::where('goods_id',$goods_id)->first();
            if($goods['goods_heshen']!='1'){
                $goods_check_time=$goods['goods_check_time'];
                 $second=\App\goods_check::first()['goods_check_second'];
                    $less_time=time()-strtotime($goods->goods_check_time)-$second;
                      if($less_time>0){
                          //已经超过保护期,除河南区域内全部屏蔽
                         if(strpos($arr['region'],"河南")!==false||strpos($arr['country'],"河南")!==false||strpos($arr['city'],"河南")!==false){

                         }else{
                             return redirect('index/fb');
                         }
                      }
            }
        }
        if($is_zz){
            switch ($for) {
                case '0':
                //遮罩机制被触发,将goods_id更改为此域名下遮罩单品的id
                   $goods_id=url::get_zz_id();
                    break;
                case '1':
                    return redirect('index/fb');
                    break;
                case '2':
                    return back();
                    break;
                default:
                    break;
            }
        }
        if(!isset($_COOKIE['isr_vis'])){
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
            $vis->vis_from=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:null;
            $vis->save();  
            setcookie('isr_vis',$vis->vis_id,time()+600);
        }else{
            $vis=\App\vis::where('vis_id',$_COOKIE['isr_vis'])->first();
        }
          view()->share('vis_id',$vis->vis_id);
         if($goods_id=='4'){
            return redirect('index/fb');
        }      
        
        //地区核审
        $area=explode(';', DB::table('pb')->first()->pb_ziduan);
        if($area[0]!=null){
            foreach($area as $key => $v){
                if($v==''||$v==null){
                    break;
                }
                if($arr['region']!=''&&$arr['region']!=null&&strpos($arr['region'],$v)!==false){
                                        return redirect('index/fb');
                }
                if($arr['country']!=''&&$arr['country']!=null&&strpos($arr['country'],$v)!==false){
                                        return redirect('index/fb');
                }
                if($arr['area']!=''&&$arr['area']!=null&&strpos($arr['area'],$v)!==false){
                                        return redirect('index/fb');
                }
                /*if(strpos($arr['region'],$v)!==false||strpos($arr['country'],$v)!==false||strpos($arr['city'],$v)!==false||strpos($arr['area'],$v)!==false){
                    return redirect('index/fb');
                }*/
            }
        } 
        /*if($area[0]!=null&&(in_array($arr['region'], $area)||in_array($arr['country'],$area)||in_array($arr['city'],$area)||in_array($arr['region']."省", $area)||in_array($arr['country'].'国',$area)||in_array($arr['city'].'市',$area))){
            return redirect('index/fb');
        }*/
        //ip核审
        $notallow=vis::where([['vis_ip','=',$arr['ip']],['vis_isback','=','1']])->first();
        if($notallow!=null){
            return redirect('index/fb');
        }
        
        //未上线域名不允许访问
       
        return $next($request);
    }
}

