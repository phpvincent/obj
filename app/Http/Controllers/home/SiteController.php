<?php

namespace App\Http\Controllers\home;

use App\site_class;
use App\url;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\site;
class SiteController extends Controller
{
    public function index(Request $request)
    {
    	$site_id=$request->get('site_id');
    	if($site_id<=0){
    		\Log::info($_SERVER['SERVER_NAME'].'获取site_id失败,site_id:'.$site_id.'ip:'.$request->getClientIp());
    		 return redirect('index/fb');
    	}
    	$site=site::where([['sites_id',$site_id],['status',0]])->first();
    	$site->url = url::where('url_site_id', $site_id)->value('url_url');
    	$cates = site_class::where('site_site_id', $site_id)->orderBy('site_class_sort')->get();
    	return view('home.ydzshome.index')->with(compact('site','cates'));
    }

}
