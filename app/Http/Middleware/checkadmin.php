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
<<<<<<< HEAD
        $url=$_SERVER['SERVER_NAME'];
=======
	    $url=$_SERVER['SERVER_NAME'];
	    if($url=='localhost'){
		   return $next($request);
        }
        if($url!='52.14.183.239'||$url!='13.229.201.49'||$url!='127.0.0.1'){
            return $next($request);
        }
>>>>>>> 63f4836dd7bad6ef1e90ad5d67eb930e302acc06
        $msg=preg_match('/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $url);
        if(!$msg){
            return redirect('index/index');
        }
<<<<<<< HEAD
        if($url!='52.14.183.239'){
            return redirect('index/index');
        }
=======
        
>>>>>>> 63f4836dd7bad6ef1e90ad5d67eb930e302acc06
        $ip=$request->getClientIp();

        return $next($request);
    }
}
