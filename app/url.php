<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
class url extends Model
{
    protected $table = 'url';
    protected $primaryKey ='url_id';
    public static function is_use($url){
    	$all_use=self::where('url_type',$url)->first();
        if($all_use==null){dd($all_use);
            return false;
        }elseif($all_use['url_type']==0){
            //域名没有开启
            return false;
        }
        if($all_use['url_goods_id']==null&&$all_use['url_zz_goods_id']==null){
            //域名没有绑定单品
            return false;
        }
    	
        return true;
    }
    public static function get_goods(Request $request){
    	$url=$_SERVER['SERVER_NAME'];
        $level=self::where('url_url',$url)->first(['url_zz_level']);
        $url=self::where('url_url',$url)->first();
        $arr=getclientcity($request);
        switch ($level->url_zz_level) {
            case '0':
              $goods_id=$url->url_goods_id;
                break;
            case '1':
                if('美国'==$arr['region']||'美国'==$arr['country']||'美国'==$arr['city']){
                    if($arr['isp']=='脸书'||$arr['isp']=='facebook'){
                      $goods_id=$url->url_zz_goods_id;
                    }
                  }else{
                     $goods_id=$url->url_goods_id;
                  }
                break;
            case '2':
                if($arr['isp']=='脸书'){
                      $goods_id=$url->url_zz_goods_id;
                    }else{
                      $goods_id=$url->url_goods_id;
                    }
                break;
            case '3':
                if($arr['country']!='台湾省'&&$arr['region']!='台湾省'&&$arr['country']!='台湾'&&$arr['region']!='台湾'){
                    $goods_id=$url->url_zz_goods_id;
                }else{
                    $goods_id=$url->url_goods_id;
                }
                break;
            case '4':
                $goods_id=$url->url_zz_goods_id;
            break;
            default:
                break;
        };
        if($url->url_zz_goods_id==null){
            $goods_id=$url->url_goods_id;
        }
        if($url->url_goods_id==null){
            $goods_id=$url->url_zz_goods_id;
        }
    	return $goods_id;
    }
    public static function getlevel(){
        $url=$_SERVER['SERVER_NAME'];
        $level=self::where('url_url',$url)->first(['url_zz_level']);
        return $level->url_zz_level;
    }
    public static function getzzfor(){
        $url=$_SERVER['SERVER_NAME'];
        $for=self::where('url_url',$url)->first(['url_zz_for']);
        return $for->url_zz_for;
    }
    public static function get_zz_id(){
        $url=$_SERVER['SERVER_NAME'];
        $goods_zz_id=self::where('url_url',$url)->first();
        if($goods_zz_id==null||$goods_zz_id==''){
            //如果没有绑定遮罩单品，则自动返回正常单品的id
            return $goods_zz_id->url_goods_id;
        }
        return $goods_zz_id->url_zz_goods_id;
    }
    public static function get_id(){
        $url=$_SERVER['SERVER_NAME'];
        $goods_id=self::where('url_url',$url)->first();
        /*if(($goods_id==null||$goods_id=='')&&($goods_zz_id==null||$goods_zz_id=='')){
            return redirect('index/fb');
        }
        if($goods_id==null||$goods_id==''){
            return $goods_id->url_zz_goods_id;
        }
        return $goods_id->url_goods_id;*/
        if($goods_id==null){
            return false;
        }
        if($goods_id['url_goods_id']==null&&$goods_id['url_zz_goods_id']==null){
            return false;
        }
        if($goods_id['url_goods_id']!=null&&$goods_id['url_goods_id']>0){
            return $goods_id['url_goods_id'];
        }else{
            return $goods_id['url_zz_goods_id'];
        }
    }
}
