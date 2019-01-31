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
        $activitie1 = site_active::where('site_id', $site_id)->where('site_active_type', 2)->first();
        $activities = site_active::where('site_id', $site_id)->whereIn('site_active_type',[1,3])->orderBy('site_active_type', 'asc')->get();
        $hot_search = $this->hot_search_goods($site->site_fire_word);
        return view('home.ydzshome.index')->with(compact('site', 'cates', 'banners', 'activitie1', 'activities', 'hot_search'));
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
//        $active_type = site_active::where('site_active_type', $activity_id)->where('site_id', $site_id)->value('site_active_id');
//        $products = DB::table('goods')->join('site_active_goods', 'goods_id', '=', 'site_good_id')->where('site_active_id', $active->site_active_id)->get();
        $active_type = $activity_id;
        $language = goods::get_language($site->sites_blade_type);
        switch ($activity_id) {
            case 1:
                $position = config("language.index.new.{$language}");
                break;
            case 2:
                $position = config("language.index.seckill.{$language}");
                break;
            case 3:
                $position = config("language.index.hot.{$language}");
                break;
        }
        $type = 'activity';
        $hot_search = $this->hot_search_goods($site->site_fire_word);
        return view('home.ydzshome.products')->with(compact('site', 'cates', 'position', 'active_type', 'type', 'hot_search'));
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
        $hot_search = $this->hot_search_goods($site->site_fire_word);
        return view('home.ydzshome.products')->with(compact('site', 'cates', 'position', 'active_type', 'type', 'hot_search'));
    }

    public function search(Request $request)
    {
        $site_id = $request->get('site_id');
        if ($site_id <= 0) {
            \Log::info($_SERVER['SERVER_NAME'] . '获取site_id失败,site_id:' . $site_id . 'ip:' . $request->getClientIp());
            return redirect('index/fb');
        }
        $site = site::where([['sites_id', $site_id], ['status', 0]])->first();
        $site->url = url::where('url_site_id', $site_id)->value('url_url');
        $cates = DB::table('site_class')->join('goods_type', 'site_goods_type_id', '=', 'goods_type_id', 'left')->where('site_is_show', 1)->where('site_site_id', $site_id)->get();
        $type = 'search';
        $q = $request->input('q');
        $active_type = $q;
        $language = goods::get_language($site->sites_blade_type);
        $position =  config("language.index.seckill.{$language}") . ':' . $q;
        $hot_search = $this->hot_search_goods($site->site_fire_word);
        return view('home.ydzshome.products')->with(compact('site', 'cates', 'position', 'active_type', 'type', 'hot_search'));
    }

    public function get_goods_by_search(Request $request)
    {
        $page = $request->input('page',1);
        $limit = $request->input('limit', 6);
        $q = $request->input('q');
        $goods = \DB::table('goods')
            ->select('goods.goods_id', 'goods.goods_name', 'goods.goods_real_price', 'goods.goods_price', 'goods.goods_id', 'goods.goods_currency_id', 'img.img_url')
            ->leftjoin('img', 'goods.goods_id', 'img.img_goods_id')
            ->leftjoin('goods_kind', 'goods_kind.goods_kind_id', 'goods.goods_kind_id')
            ->where('goods.is_del', 0)
            ->where(function ($query) use ($q) {
                $query->where('goods.goods_name', 'like', '%' . $q . '%')
                    ->orWhere('goods.goods_real_name', 'like', '%' . $q . '%')
                    ->orWhere('goods_kind.goods_kind_name', 'like', '%' . $q . '%')
                    ->orWhere('goods_kind.goods_kind_english_name', 'like', '%' . $q . '%');
            })
            ->offset(($page-1) * $limit)
            ->limit($limit)
            ->get();
        foreach ($goods as $k => &$v) {
            $img_url = img::where('img_goods_id', $v->goods_id)->first()['img_url'];
            if(!$img_url){
               $img_url = $_SERVER['SERVER_NAME'] . '/img/site_img/cb-404.png';
            }else{
                if(stripos($_SERVER['SERVER_NAME'],$img_url) === false) {
                    $img_url = $_SERVER['SERVER_NAME'] . '/' .img::where('img_goods_id', $v->goods_id)->first()['img_url'];
                }
            }
            $v->img_url = $img_url;
            $v->goods_url = $_SERVER['SERVER_NAME'] . '/index/site_goods/' . $v->goods_id;
            $v->currency = currency_type::where('currency_type_id', $v->goods_currency_id)->value('currency_type_name');
        }
        return json_encode($goods);
    }

    public function get_goods_by_cate(Request $request)
    {
        $page = $request->input('page',1);
        $limit = $request->input('limit', 6);
        $goods = \DB::table('goods')
            ->select('goods.goods_id', 'goods.goods_name', 'goods.goods_real_price', 'goods.goods_price', 'goods.goods_id', 'goods.goods_currency_id', 'img.img_url')
            ->leftjoin('img', 'goods.goods_id', 'img.img_goods_id')
            ->where('goods.is_del', 0)
            ->where('goods.goods_blade_type', $request->input('active_type'))
            ->offset(($page-1) * $limit)
            ->limit($limit)
            ->get();
        foreach ($goods as $k => &$v) {
            $img_url = img::where('img_goods_id', $v->goods_id)->first()['img_url'];
            if(!$img_url){
                $img_url = $_SERVER['SERVER_NAME'] . '/img/site_img/cb-404.png';
            }else{
                if(stripos($_SERVER['SERVER_NAME'],$img_url) === false) {
                    $img_url = $_SERVER['SERVER_NAME'] . '/' .img::where('img_goods_id', $v->goods_id)->first()['img_url'];
                }
            }
            $v->img_url = $img_url;
            $v->goods_url = $_SERVER['SERVER_NAME'] . '/index/site_goods/' . $v->goods_id;
            $v->currency = currency_type::where('currency_type_id', $v->goods_currency_id)->value('currency_type_name');
        }
        return json_encode($goods);
    }

    public function get_site_goods(Request $request)
    {
        $page = $request->input('page',1);
        $limit = $request->input('limit', 6);
        $site_id = $request->get('site_id');
        $goods = \DB::table('site_actives')
            ->select('goods.goods_name', 'goods.goods_real_price', 'goods.goods_price', 'goods.goods_id', 'goods.goods_currency_id', 'site_actives.site_active_type', 'site_actives.site_active_id', 'site_actives.site_active_img', 'site_active_goods.sort')
            ->leftjoin('site_active_goods', 'site_actives.site_active_id', 'site_active_goods.site_active_id')
            ->leftjoin('goods', 'site_active_goods.site_good_id', 'goods.goods_id')
            ->where('site_actives.site_id', $site_id)
            ->where('goods.is_del', 0)
            ->where(function ($query) use ($request) {
                if ($request->has('active_type')) {
                    $query->where('site_actives.site_active_type', $request->input('active_type'));
                }
            })
            ->orderBy('site_active_goods.sort', 'desc')
            ->offset(($page-1) * $limit)
            ->limit($limit)
            ->get();
        foreach ($goods as $k => &$v) {
            $img_url = img::where('img_goods_id', $v->goods_id)->first()['img_url'];
            if(!$img_url){
                $img_url = $_SERVER['SERVER_NAME'] . '/img/site_img/cb-404.png';
            }else{
                if(stripos($_SERVER['SERVER_NAME'],$img_url) === false) {
                    $img_url = $_SERVER['SERVER_NAME'] . '/' .img::where('img_goods_id', $v->goods_id)->first()['img_url'];
                }
            }
            $v->img_url = $img_url;
            $v->goods_url = $_SERVER['SERVER_NAME'] . '/index/site_goods/' . $v->goods_id;
            $v->currency = currency_type::where('currency_type_id', $v->goods_currency_id)->value('currency_type_name');
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
        foreach($imgs as $k => $v){

        }
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

    private function hot_search_goods($keyword)
    {
//        if (in_array($goods_blade_type, [8, 9, 10, 13, 15, 17])) { //英语
//            $left_goods = ['sleeve dress', 'running shoes'];
//            $right_goods = ['Trendy Backpack'];
//        } elseif (in_array($goods_blade_type, [0])) { // 繁体中文
//            $left_goods = ['平底沙滩鞋', '萬能轉換插頭'];
//            $right_goods = ['车载电热杯', '大碼彈力顯瘦牛仔褲'];
//        } elseif (in_array($goods_blade_type, [16])) { // 阿语
//            $left_goods = ['POLO', 'الشحن لسيارة'];
//            $right_goods = ['حذاء يدوي لين مريح', 'الشحن لسيارة'];
//        } elseif (in_array($goods_blade_type, [3])) { // 马来
//            $left_goods = ['dress', 'Men cowhide leather'];
//            $right_goods = ['Roll Up Piano'];
//        } elseif (in_array($goods_blade_type, [4])) { // 泰语
//            $left_goods = ['Micro Current', 'เสื้อกันแดด'];
//            $right_goods = ['รองเท้าลำลองรุ่นผู้ชาย สไตล์อังกฤษ'];
//        } elseif (in_array($goods_blade_type, [5])) { // 日语
//            $left_goods = ['レギンス'];
//            $right_goods = ['大判ストール チェック柄'];
//        } elseif (in_array($goods_blade_type, [6])) { // 印尼
//            $left_goods = ['Kasur lipat'];
//            $right_goods = ['Sepatu rajutan pria'];
//        } elseif (in_array($goods_blade_type, [11])) { // 越南
//            $left_goods = [''];
//            $right_goods = [''];
//        } else {
//            $left_goods = [''];
//            $right_goods = [''];
//        }
        $keyworks = explode(';', $keyword);
        $chunk_result = array_chunk($keyworks, 2);
        return ['left' => $chunk_result[0], 'right' => count($chunk_result) > 1 ? $chunk_result[1] : ''];
    }

    public function get_footer(Request $request, $type)
    {
        $site_id = $request->get('site_id');
        $site = site::where([['sites_id', $site_id], ['status', 0]])->first();
        if ($site == null) return view('home.ydzshome.405');
        if (!in_array($type, ['about', 'shipping', 'return', 'privacy'])) {
            return view('home.ydzshome.405');
        }
        $site->url = url::where('url_site_id', $site_id)->value('url_url');
        $cates = DB::table('site_class')->join('goods_type', 'site_goods_type_id', '=', 'goods_type_id', 'left')->where('site_is_show', 1)->where('site_site_id', $site_id)->get();
        $hot_search = $this->hot_search_goods($site->site_fire_word);
        return view('home.ydzshome.menus')->with(compact('site', 'cates', 'type','hot_search'));
    }
}
