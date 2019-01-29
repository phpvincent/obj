<?php

namespace App\Http\Controllers\home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\site;
class SiteController extends Controller
{
    public function index(Request $request)
    {
    	dd('?');
    	$site_id=$request->get('site_id');
    	if($site_id<=0){
    		\Log::info($_SERVER['SERVER_NAME'].'获取site_id失败,site_id:'.$site_id.'ip:'.$request->getClientIp());
    		 return redirect('index/fb');
    	}
    	$site=site::where([['sites_id',$site_id],['status',0]])->first();
    	return view('home.site.index')->with(compact('site'));
    }
}
