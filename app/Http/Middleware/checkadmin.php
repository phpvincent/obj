<?php

namespace App\Http\Middleware;

use Closure;

class checkadmin
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


	    $url=$_SERVER['SERVER_NAME'];
	    if($url=='localhost'){
		   return $next($request);
        }
        if($url!='52.14.183.239'||$url!='13.229.201.49'||$url!='127.0.0.1'){
            return $next($request);
        }

        $msg=preg_match('/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $url);
        if(!$msg){
            return redirect('index/index');
        }        

        $ip=$request->getClientIp();

        return $next($request);
    }
}
