<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use DB;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct(){
       $this->middleware(function($request, $next) {
          if(Auth::check()){ 
              $rules=$this->getrules();
              view()->share('rules', $rules);
            }       
        return $next($request);
       });  
    }
    public function getrules(){
		if(Auth::user()->is_root=='1'){
    		$rules=DB::table('rule')->get();
    		return $rules;
    	}else{
           $rules=DB::table('admin')
           ->select('admin.*','rule.*')
           ->leftjoin('role','admin.admin_role_id','=','role.role_id')
           ->leftjoin('role_rule','role.role_id','=','role_rule.roleid')
           ->leftjoin('rule','role_rule.ruleid','=','rule.rule_id')
           ->where('admin.admin_id',Auth::user()->admin_id)
           ->get();
           return $rules;
    	}
    }
}
