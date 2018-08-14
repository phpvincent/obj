<?php

namespace App\Http\Middleware;

use Closure;

class checkbus
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
        $is_bus=\App\business::checkserver($request);
        if($is_bus=='notallow'){
            return redirect('index/fb');
        }elseif($is_bus==false){
            return $next($request);
        }else{
            $url=$_SERVER['SERVER_NAME'];
            $imgs=\App\business_img::get_img($url);
            /*view()->share('imgs',$imgs);*//*dd($imgs['bg']->first());*/
            return response()->view($is_bus,['imgs'=>$imgs]);
        }

        return $next($request);
    }
}
