<?php

namespace App\Http\Controllers\home;

use App\site_class;
use App\url;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\site;
use App\site_actives;
use Illuminate\Support\Facades\DB;
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
    	$cates = DB::table('site_classes')->join('goods_type', 'site_goods_type_id', '=', 'goods_type_id', 'left')->where('site_is_show',1)->where('site_site_id', $site_id)->get();
    	return view('home.ydzshome.index')->with(compact('site','cates'));
    }
    public function get_site_goods(Request $request)
    {
    	$page=$request->input('page');
    	$limit=$request->input('limit',6);
    	$site_id=$request->get('site_id');
    	$goods=\DB::table('site_actives')
    	->select('goods.goods_name','goods.goods_real_price','goods.goods_price','img.img_url','site_actives.site_active_type','site_actives.site_active_id','site_actives.site_active_img','site_active_goods.sort')
    	->leftjoin('site_active_goods','site_actives.site_active_id','site_active_goods.site_active_id')
    	->leftjoin('goods','site_active_goods.site_good_id','goods.goods_id')
    	->leftjoin('img','goods.goods_id','img.img_goods_id')
    	->where('site_actives.site_id',$site_id)
    	->where(function($query)use($request){
    		if($request->has('active_type')){
    			$query->where('site_active_goods.site_active_id',$request->input('active_type'));
    		}
    	})
    	->orderBy('site_active_goods.sort','desc')
    	->offset($page)
	    ->limit($limit)
	    ->get();
	    return json_encode($goods);
    }
}
