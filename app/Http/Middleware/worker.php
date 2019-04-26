<?php

namespace App\Http\Middleware;

use Closure;

class worker
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
        try{
            if(\Auth::user()->admin_worker!=1&&\Auth::user()->is_root!=1){
                return redirect('/admin/storage/notallow');
            }
        }catch(\Exception $e){
                return redirect('/admin/storage/notallow');
        }
        return $next($request);
    }
}
