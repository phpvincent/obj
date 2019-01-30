<?php

namespace App\Http\Controllers\home;

use App\currency_type;
use App\site_active;
use App\site_class;
use App\site_img;
use App\url;
use App\goods;
use App\img;
use App\comment;
use App\des;
use App\par;
use App\cuxiao;
use App\order;
use App\vis;
use App\templet_show;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\site;
use App\site_actives;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    public function index(Request $request)
    {
        $site_id = $request->get('site_id');
        if ($site_id <= 0) {
            \Log::info($_SERVER['SERVER_NAME'] . '获取site_id失败,site_id:' . $site_id . 'ip:' . $request->getClientIp());
            return redirect('index/fb');
        }
        $site = site::where([['sites_id', $site_id], ['status', 0]])->first();
        $site->url = url::where('url_site_id', $site_id)->value('url_url');
        $cates = DB::table('site_class')->join('goods_type', 'site_goods_type_id', '=', 'goods_type_id', 'left')->where('site_is_show', 1)->where('site_site_id', $site_id)->get();
        $banners = site_img::where('site_site_id', $site_id)->get();
        $activitie1 = site_active::where('site_id', $site_id)->where('site_active_type', 1)->first();
        $activities = site_active::where('site_id', $site_id)->where('site_active_type', '>', 1)->orderBy('site_active_type', 'asc')->get();
        return view('home.ydzshome.index')->with(compact('site', 'cates', 'banners', 'activitie1', 'activities'));
    }

    public function activity(Request $request, $activity_id)
    {
        $site_id = $request->get('site_id');
        if ($site_id <= 0) {
            \Log::info($_SERVER['SERVER_NAME'] . '获取site_id失败,site_id:' . $site_id . 'ip:' . $request->getClientIp());
            return redirect('index/fb');
        }
        $site = site::where([['sites_id', $site_id], ['status', 0]])->first();
        $site->url = url::where('url_site_id', $site_id)->value('url_url');
        $cates = DB::table('site_class')->join('goods_type', 'site_goods_type_id', '=', 'goods_type_id', 'left')->where('site_is_show', 1)->where('site_site_id', $site_id)->get();
        $active_type = site_active::where('site_active_type', $activity_id)->where('site_id', $site_id)->value('site_active_id');
//        $products = DB::table('goods')->join('site_active_goods', 'goods_id', '=', 'site_good_id')->where('site_active_id', $active->site_active_id)->get();
        switch ($activity_id) {
            case 1:
                $position = '新品推荐';
                break;
            case 2:
                $position = '秒杀抢购';
                break;
            case 3:
                $position = '热卖推荐';
                break;
        }
        $type = 'activity';
        return view('home.ydzshome.products')->with(compact('site', 'cates', 'position', 'active_type', 'type'));
    }

    public function cate(Request $request, $cate_id)
    {
        $site_id = $request->get('site_id');
        if ($site_id <= 0) {
            \Log::info($_SERVER['SERVER_NAME'] . '获取site_id失败,site_id:' . $site_id . 'ip:' . $request->getClientIp());
            return redirect('index/fb');
        }
        $site = site::where([['sites_id', $site_id], ['status', 0]])->first();
        $site->url = url::where('url_site_id', $site_id)->value('url_url');
        $cates = DB::table('site_class')->join('goods_type', 'site_goods_type_id', '=', 'goods_type_id', 'left')->where('site_is_show', 1)->where('site_site_id', $site_id)->get();
		$type = 'cate';
		$active_type = $cate_id;
        $position = site_class::where('site_site_id', $site_id)->where('site_is_show', 1)->where('site_goods_type_id', $cate_id)->value('site_class_show_name');
        return view('home.ydzshome.products')->with(compact('site', 'cates', 'position', 'active_type', 'type'));
    }

    public function get_goods_by_cate(Request $request)
    {
        $page = $request->input('page');
        $limit = $request->input('limit', 6);
        $site_id = $request->get('site_id');
        $goods = \DB::table('goods')
            ->select('goods.goods_id','goods.goods_name', 'goods.goods_real_price', 'goods.goods_price','goods.goods_id','goods.goods_currency_id', 'img.img_url')
            ->leftjoin('img', 'goods.goods_id', 'img.img_goods_id')
            ->where('goods.is_del', 0)
            ->where('goods.goods_blade_type', $request->input('active_type'))
            ->offset($page)
            ->limit($limit)
            ->get();
        foreach($goods as $k => &$v){
            $v->img_url=img::where('img_goods_id',$v->goods_id)->first()['img_url'];
            $v->goods_url=$_SERVER['SERVER_NAME'].'/index/site_goods/'.$v->goods_id;
            $v->currency = currency_type::where('currency_type_id',goods_currency_id)->value('currency_type_name');
        }
        return json_encode($goods);
    }
    public function get_site_goods(Request $request)
    {
    	$page=$request->input('page');
    	$limit=$request->input('limit',6);
    	$site_id=$request->get('site_id');
    	$goods=\DB::table('site_actives')
    	->select('goods.goods_name','goods.goods_real_price','goods.goods_price','goods.goods_id','goods.goods_currency_id','site_actives.site_active_type','site_actives.site_active_id','site_actives.site_active_img','site_active_goods.sort')
    	->leftjoin('site_active_goods','site_actives.site_active_id','site_active_goods.site_active_id')
    	->leftjoin('goods','site_active_goods.site_good_id','goods.goods_id')
    	->where('site_actives.site_id',$site_id)
    	->where('goods.is_del',0)
    	->where(function($query)use($request){
    		if($request->has('active_type')){
    			$query->where('site_actives.site_active_type',$request->input('active_type'));
    		}
    	})
    	->orderBy('site_active_goods.sort','desc')
    	->offset($page)
	    ->limit($limit)
	    ->get();
        foreach($goods as $k => &$v){
            $v->img_url=img::where('img_goods_id',$v->goods_id)->first()['img_url'];
            $v->goods_url=$_SERVER['SERVER_NAME'].'/index/site_goods/'.$v->goods_id;
            $v->currency = currency_type::where('currency_type_id',goods_currency_id)->value('currency_type_name');
        }
	    return json_encode($goods);
    }

    public function goods(Request $request, $goods_id)
    {
        $site_id = $request->get('site_id');
        $site = site::where([['sites_id', $site_id], ['status', 0]])->first();
        $site->url = url::where('url_site_id', $site_id)->value('url_url');
        $cates = DB::table('site_class')->join('goods_type', 'site_goods_type_id', '=', 'goods_type_id', 'left')->where('site_is_show', 1)->where('site_site_id', $site_id)->get();
        $imgs = img::where('img_goods_id', $goods_id)->orderBy('img_id', 'asc')->get(['img_url']);
        $goods = goods::where('goods_id', $goods_id)->first();
        if ($goods == null) return view('home.ydzshome.404')->with(compact('site', 'cates'));
        $comment = comment::where(['com_goods_id' => $goods_id, 'com_isshow' => '1'])->orderBy('com_order', 'desc')->get();
        foreach ($comment as $v => $key) {
            /* $usename=mb_substr($key->com_name,0,1);
             $usename.='*';
             if(strlen($key->com_name)>2){
               $usename.=mb_substr($key->com_name,2);
             }
             $comment[$v]->com_name=$usename;*/
            $com_imgs = \App\com_img::where('com_primary_id', $key->com_id)->get();
            if (count($com_imgs) > 0) {
                $comment[$v]->com_img = $com_imgs;
            } else {
                $comment[$v]->com_img = null;
            }
            $comment[$v]->com_time = date('Y-m-d H:i:s', time() - rand(68400, 129600));
        }
        $des_img = des::where('des_goods_id', $goods_id)->get();
        $par_img = par::where('par_goods_id', $goods_id)->get();
        $cuxiao = cuxiao::where('cuxiao_goods_id', $goods_id)->orderBy('cuxiao_id', 'asc')->first();
        //获取倒计时计算为秒数
        $timer = $goods->goods_end;
        $parsed = date_parse($timer);
        $goods->goods_end = $parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second'];

        //获取页面显示内容(2018-10-31 修改代码)
        $goods_templet_ids = \App\goods_templet::where('goods_id', $goods_id)->pluck('templet_id')->toArray();
        $templets = templet_show::whereIn('templet_show_id', $goods_templet_ids)->pluck('templet_english_name')->toArray();
        $center_nav = count($templets);
//        $goods_templet = \App\goods_templet::where('goods_id',$goods_id)->get();
//        $templets = [];
//        $center_nav = 0;  //中部导航显示个数
//        if(!$goods_templet->isEmpty()){
//            foreach ($goods_templet as $item)
//            {
//                if(isset($item->templet_has_show->templet_english_name)){
//                    if($item->templet_has_show->templet_english_name == 'introduce'){
//                        $center_nav++;
//                    }
//                    if($item->templet_has_show->templet_english_name == 'specifications'){
//                        $center_nav++;
//                    }
//                    if($item->templet_has_show->templet_english_name == 'evaluate'){
//                        $center_nav++;
//                    }
//                    array_push($templets,$item->templet_has_show->templet_english_name);
//                }
//            }
//        }

        //模板渲染
        $blade_type = $goods->goods_blade_type;
        switch ($blade_type) {
            case '0':
                return view('home.TaiwanFan.index')->with(compact('imgs', 'goods', 'comment', 'des_img', 'par_img', 'cuxiao', 'templets', 'center_nav'));
                break;
            case '1':
                return view('home.TaiwanJian.index')->with(compact('imgs', 'goods', 'comment', 'des_img', 'par_img', 'cuxiao', 'templets', 'center_nav'));
                break;
            case '2':
                return view('home.zhongdong.zhongdong')->with(compact('imgs', 'goods', 'comment', 'des_img', 'par_img', 'cuxiao', 'templets', 'center_nav'));
                break;
            case '3':
                return view('home.MaLaiXiYa.mlxy')->with(compact('imgs', 'goods', 'comment', 'des_img', 'par_img', 'cuxiao', 'templets', 'center_nav'));
                break;
            case '4':
                return view('home.TaiGuo.taiguo')->with(compact('imgs', 'goods', 'comment', 'des_img', 'par_img', 'cuxiao', 'templets', 'center_nav'));
                break;
            case '5':
                return view('home.RiBen.riben')->with(compact('imgs', 'goods', 'comment', 'des_img', 'par_img', 'cuxiao', 'templets', 'center_nav'));
                break;
            case '6':
                return view('home.YinDuNiXiYa.ydnxy')->with(compact('imgs', 'goods', 'comment', 'des_img', 'par_img', 'cuxiao', 'templets', 'center_nav'));
                break;
            case '7':
                return view('home.FeiLvBin.flb')->with(compact('imgs', 'goods', 'comment', 'des_img', 'par_img', 'cuxiao', 'templets', 'center_nav'));
                break;
            case '8':
                return view('home.YingGuo.yg')->with(compact('imgs', 'goods', 'comment', 'des_img', 'par_img', 'cuxiao', 'templets', 'center_nav'));
                break;
            case '9':
                $user_type = get_user_new_type();
                if (in_array($user_type, ['Android', 'iPhone', 'iPad'])) {
                    return view('home.YingGuo.yg')->with(compact('imgs', 'goods', 'comment', 'des_img', 'par_img', 'cuxiao', 'templets', 'center_nav'));
                }
                return view('home.googlePC.index')->with(compact('imgs', 'goods', 'comment', 'des_img', 'par_img', 'cuxiao', 'templets', 'center_nav'));
                break;
            case '10':
                return view('home.MeiGuo.us')->with(compact('imgs', 'goods', 'comment', 'des_img', 'par_img', 'cuxiao', 'templets', 'center_nav'));
                break;
            case '11':
                return view('home.YueNan.yn')->with(compact('imgs', 'goods', 'comment', 'des_img', 'par_img', 'cuxiao', 'templets', 'center_nav'));
                break;
            case '12':
                return view('home.ShaTe.st')->with(compact('imgs', 'goods', 'comment', 'des_img', 'par_img', 'cuxiao', 'templets', 'center_nav'));
                break;
            case '13':
                return view('home.ShaTeEnglish.st')->with(compact('imgs', 'goods', 'comment', 'des_img', 'par_img', 'cuxiao', 'templets', 'center_nav'));
                break;
            case '14':
                return view('home.KaTaEr.kte')->with(compact('imgs', 'goods', 'comment', 'des_img', 'par_img', 'cuxiao', 'templets', 'center_nav'));
                break;
            case '15':
                return view('home.KaTaErEnglish.kte')->with(compact('imgs', 'goods', 'comment', 'des_img', 'par_img', 'cuxiao', 'templets', 'center_nav'));
                break;
            case '16':
                return view('home.ZD.zd')->with(compact('imgs', 'goods', 'comment', 'des_img', 'par_img', 'cuxiao', 'templets', 'center_nav'));
                break;
            case '17':
                return view('home.ZDEnglish.zd')->with(compact('imgs', 'goods', 'comment', 'des_img', 'par_img', 'cuxiao', 'templets', 'center_nav'));
                break;
            default:
                # code...
                break;
        }
    }
}
