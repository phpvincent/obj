<?php

namespace App\Http\Middleware;

use Closure;

class storage
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
        if(\Auth::user()->admin_storage!=1){
            return redirect('/admin/storage/notallow');
        }
        return $next($request);
    }
}
