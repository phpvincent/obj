<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class goods extends Model
{
    protected $table = 'goods';
    protected $primaryKey ='goods_id';
    public $timestamps=false;
    public function comment(){
    	return $this->hasMany('App\comment','com_goods_id','goods_id');
    }

    /**
     *  模型关联表(币种与商品关联)
     */
    public function currency_has_goods()
    {
        return $this->hasOne('App\currency_type', 'currency_type_id', 'goods_currency_id');
    }

    public static function get_ownid($admin_id){
        $admin_ids=\App\admin::get_group_ids($admin_id);
    	$arr=self::whereIn('goods_admin_id',$admin_ids)->get(['goods_id'])->toArray();
    	$ids=[];
    	foreach($arr as $v => $k){
    		$ids[]=$k['goods_id'];
    	}
    	return $ids;
    }
    public static function get_only_slef_id($admin_id){
        $arr=self::where([['goods_admin_id','=',$admin_id],['is_del','=','0'],['goods_id','<>','4']])->get(['goods_id'])->toArray();
        $ids=[];
        foreach($arr as $v => $k){
            $ids[]=$k['goods_id'];
        }
        return $ids;
    }
    public static function get_search_arr($search,$type=true){
        //使用搜索条件获取单品组
        $goods_ids=self::where('goods_name','like',"%$search%")->get(['goods_id'])->toArray();
        $goods_real_ids=self::where('goods_real_name','like',"%$search%")->get(['goods_id'])->toArray();
        $arr=array_merge($goods_ids,$goods_real_ids); 
        $re_arr=[];
            foreach($arr as $k => $v){
                $re_arr[]=$v;
            }
        if($type){
            return $re_arr;
        }else{
            return implode(',', $re_arr);
        }
    }
    public static function get_selfid($admin_id){
        $group=\App\admin::where('admin_id',$admin_id)->first()['admin_group'];
         if(\App\admin_group::where('admin_group_id',$group)->first()['admin_group_name']=='#全体人员#'){
            //全体人员组成员取得所有订单的id
            $admin_ids=self::get(['goods_id'])->toArray();
        }else{
            $admin_ids=self::where('goods_admin_id',$admin_id)->get(['goods_id'])->toArray();
        }
        $ids=[];
        foreach($admin_ids as $v => $k){
            $ids[]=$k['goods_id'];
        }
        return $ids;
    }

    /** 根据语言返回商品模板
     * @param $languages
     * @return array
     */
    public static function get_blade($languages)
    {
        switch ($languages) {
            case '1':
                $band = [0, 1];
                break;
            case '2':
                $band = [12, 14 ,16];
                break;
            case '3':
                $band = [3];
                break;
            case '4':
                $band = [4];
                break;
            case '5':
                $band = [5];
                break;
            case '6':
                $band = [6];
                break;
            case '7':
                $band = [7, 8, 9, 10, 2, 13, 15, 17];
                break;
            case '8':
                $band = [11];
                break;
            default:
                $band = false;
                break;
        }
        return $band;
    }

    /** 根据地区返回商品模板
     * @param $goods_blade_type
     * @return array
     */
    public static function get_area_blade($goods_blade_type)
    {
        switch ($goods_blade_type) {
            case '1':
                $band = [0, 1];
                break;
            case '2':
                $band = [2];
                break;
            case '3':
                $band = [3];
                break;
            case '4':
                $band = [4];
                break;
            case '5':
                $band = [5];
                break;
            case '6':
                $band = [6];
                break;
            case '7':
                $band = [7];
                break;
            case '8':
                $band = [8,9];
                break;
            case '9':
                $band = [10];
                break;
            case '10':
                $band = [11];
                break;
            case '11':
                $band = [12,13];
                break;  
            case '12':
                $band = [14,15];
                break;
            default:
                $band = false;
                break;
        }
        return $band;
    }

    public static function get_success_blade($goods){
        //根据商品类返回所属邮件页面模板
        $blade_id=$goods->goods_blade_type;
        switch ($blade_id) {
            case '0':
                $blade_name='home.TaiwanFan.sendmail';
                break;
            case '1':
                $blade_name='home.TaiwanJian.sendmail';
                break;
            case '2':
                $blade_name='home.zhongdong.sendmail';
                break;
            case '3':
                $blade_name='home.MaLaiXiYa.sendmail';
                break;
            case '4':
                $blade_name='home.TaiGuo.sendmail';
                break;
            case '5':
                $blade_name='home.RiBen.sendmail';
                break;
            case '6':
                $blade_name='home.YinDuNiXiYa.sendmail';
                break;
            case '7':
                $blade_name='home.FeiLvBin.sendmail';
                break;
            case '8':
                $blade_name='home.YingGuo.sendmail';
                break;
            case '9':
                $blade_name='home.googlePC.sendmail';
                break;
            case '10':
                $blade_name='home.MeiGuo.sendmail';
                break;
            case '11':
                $blade_name='home.YueNan.sendmail';
                break;
            case '12':
                 $blade_name='home.ShaTe.sendmail';
                 break;
            case '13':
                $blade_name='home.ShaTeEnglish.sendmail';
                break;
            case '14':
                $blade_name='home.KaTaEr.sendmail';
                break;  
            case '15':
                $blade_name='home.KaTaErEnglish.sendmail';
                break;
            case '16':
                $blade_name='home.ZD.sendmail';
                break;
            case '17':
                $blade_name='home.ZDEnglish.sendmail';
                break;
            default:
                $blade_name='home.YingGuo.sendmail';
                break;
        }
        return $blade_name;
    }
    public static function get_language($blade_type)
    {
        switch ($blade_type) {
            case 0:
                $lan='Chinese-fan';
                break;
            case 1:
                $lan='Chinese';
                break;
            case 2:
                $lan='English';
                break;
            case 3:
                $lan='English';
                break;
            case 4:
                $lan='Thai';
                $lan='English';
                break;
            case 5:
                $lan='Japan';
                $lan='English';
                break;
            case 6:
                $lan='Indonesia';
                break;
            case 7:
                $lan='English';
                break;
            case 8:
                $lan='English';
                break;
            case 9:
                $lan='English';
                break;
            case 10:
                $lan='English';
                break;
            case 11:
                $lan='Vietnam';
                $lan='English';
                break;
            case 12:
                $lan='Arab';
                break;
            case 13:
                $lan='English';
                break;
            case 14:
                $lan='Arab';
                break;
            case 15:
                $lan='English';
                break;
            case 16:
                $lan='Arab';
                break;
            case 17:
                $lan='English';
                break;
            default:
                 $lan='English';
                break;
        }
      return $lan;
    }
    /** 根据模板返回货币id
     * @param $goods_blade_id
     * @return array
     */
    public static function get_currency($goods_blade_id)
    {
        switch ($goods_blade_id) {
            case '0':
               return 1;
                break;
            case '1':
               return 1;
                break;
            case '2':
               return 3;
                break;
            case '3':
               return 4;
                break;
            case '4':
               return 6;
                break;
            case '5':
               return 5;
                break;
            case '6':
               return 10;
                break;
            case '7':
               return 7;
                break;
            case '8':
               return 8;
                break;
            case '9':
               return 8;
                break;
            case '10':
               return 2;
                break;
            case '11':
               return 11;
                break;
            case '12':
               return 12;
                break;
            case '13':
               return 12;
                break;
            case '14':
               return 13;
                break;
            case '15':
               return 13;
                break;
            case '16':
               return 2;
                break;
            case '17':
               return 2;
                break;
            default:
                return 2;
                break;
        }
    }

    /**
     * 根据模板地区，获取模板名称
     * @param $goods_blade_id
     * @return int
     */
    public static function get_blade_currency($goods_blade_id,$order_country = '')
    {
        switch ($goods_blade_id) {
            case '0':
            case '1':
                return '台湾地区';
            case '2':
                return '阿联酋地区';
            case '3':
                return '马来西亚地区';
            case '4':
                return '泰国地区';
            case '5':
                return '日本地区';
            case '6':
                return '印度尼西亚地区';
            case '7':
                return '菲律宾地区';
            case '8':
            case '9':
                return '英国地区';
            case '10':
                return '美国地区';
                break;
            case '11':
                return '越南地区';
                break;
            case '12':
            case '13':
                return '沙特地区';
            case '14':
            case '15':
                return '卡塔尔地区';
            case '16':
            case '17':
                 switch ($order_country){
                     case 'United Arab Emirates':
                         return '阿联酋地区';
                     case 'Saudi Arabia':
                         return '沙特阿拉伯地区';
                     case 'Qatar':
                         return '卡塔尔地区';
                     default:
                         return '中东地区';
                 }
            default:
                return '台湾地区';
        }
    }

    /**
     * 通过url 获取商品信息
     * @param $url
     * @return mixed
     */
    public static function url_get_goods_id($url){
        $search = '~^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?~i';
        preg_match_all($search, $url ,$rr);
        $arr['sites_name'] = "";
        $arr['goods_id'] = "";
        $arr['goods_name'] = "";
        $arr['route_name'] = "";
        $arr['area'] = "";
        //根据路由获取路由为站点，还是单品
        if(isset($rr[4][0])){
            $get_url = $rr[4][0];
            if(substr($get_url,0,4) == 'www.'){
                $get_url = substr($get_url,4);
            };
            $urls = url::where('url_url',$get_url)->first();
            if($urls && $urls->url_site_id){ //站点
                //站点名称
                $site = site::where('sites_id',$urls->url_site_id)->first();
                if($site){
                    $arr['sites_name'] = $site->sites_name;
                    $arr['area'] = goods::get_blade_currency($site->sites_blade_type);
                }
                if(preg_match("/\/activity\/\d+$/", $url)){
                    $len = strrpos($url,'activity');
                    $goods_id = substr($url,$len+9);
                    $arr['route_name'] = "站点列表页";
                    $arr['goods_id'] = $goods_id;
                    $arr['goods_name'] = goods::where('goods_id',$goods_id)->first()['goods_real_name'];
                }elseif (preg_match("/\/index\/site_goods\/\d+$/", $url)){
                    $len = strrpos($url,'site_goods');
                    $goods_id = substr($url,$len+11);
                    $arr['route_name'] = "商品落地页";
                    $arr['goods_id'] = $goods_id;
                    $arr['goods_name'] = goods::where('goods_id',$goods_id)->first()['goods_real_name'];
                }elseif(preg_match("/\/pay/", $url)){
                    $len = strrpos($url,'pay');
                    $goods_id = substr($url,$len+13);
                    $arr['goods_id'] = $goods_id;
                    $arr['goods_name'] = goods::where('goods_id',$goods_id)->first()['goods_real_name'];
                    $arr['route_name'] = "商品下单页";
                }elseif(preg_match("/\/endsuccess/", $url)){
                    $arr['route_name'] = "下单成功页";
                    $len = strrpos($url,'endsuccess');
                    $last_add = strrpos($url,'&');
                    $num = $last_add - $len - 27;
                    $goods_id = substr($url,$len+27,$num);
                    $arr['goods_id'] = $goods_id;
                    $arr['goods_name'] = goods::where('goods_id',$goods_id)->first()['goods_real_name'];
                }elseif(preg_match("/\/send/", $url)){
                    $len = strrpos($url,'send');
                    $goods_id = substr($url,$len+14);
                    $arr['goods_id'] = $goods_id;
                    $arr['goods_name'] = goods::where('goods_id',$goods_id)->first()['goods_real_name'];
                    $arr['route_name'] = "订单查询页";
                }else{
                    $arr['route_name'] = "站点首页";
                    $arr['goods_id'] = "";
                    $arr['goods_name'] = "";
                }
            }else if($urls && $urls->url_goods_id){ //单页 //TODO 有遮罩商品需要测试
                $arr['sites_name'] = '';
                $arr['goods_id'] = $urls->url_goods_id;
                $area = self::get_goods_type($urls->url_goods_id);
                $arr['goods_name'] = $area['goods_name'];
                $arr['area'] = $area['area'];
                if(preg_match("/\/pay/", $url)){
                    $arr['route_name'] = "商品下单页";
                }elseif(preg_match("/\/endsuccess/", $url)){
                    $arr['route_name'] = "下单成功页";
                }elseif(preg_match("/\/send/", $url)){
                    $arr['route_name'] = "订单查询页";
                }else{
                    $arr['route_name'] = "商品落地页";
                }

            }else if($urls && $urls->url_zz_goods_id){
                $arr['sites_name'] = '';
                $arr['goods_id'] = $urls->url_zz_goods_id;
                $area = self::get_goods_type($urls->url_zz_goods_id);
                $arr['goods_name'] = $area['goods_name'];
                $arr['area'] = $area['area'];
                if(preg_match("/\/pay/", $url)){
                    $arr['route_name'] = "商品下单页";
                }elseif(preg_match("/\/endsuccess/", $url)){
                    $arr['route_name'] = "下单成功页";
                }elseif(preg_match("/\/send/", $url)){
                    $arr['route_name'] = "订单查询页";
                }else{
                    $arr['route_name'] = "商品落地页";
                }
            }
        }
        return $arr;
    }

    /**
     * 获取商品地区、商品名称
     * @param $goods_id
     * @return mixed
     */
    private static function get_goods_type($goods_id)
    {
        $goods = goods::where('goods_id',$goods_id)->first();
        if($goods){
            $arra['goods_name'] = $goods->goods_real_name;
            $arra['area'] = goods::get_blade_currency($goods->goods_blade_type);
        }else{
            $arra['goods_name'] = '';
            $arra['area'] = '';
        }
        return $arra;
    }
}
