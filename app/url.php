<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class url extends Model
{
    protected $table = 'url';
    protected $primaryKey ='url_id';
    public static function is_use($url){
    	$all_use=self::where('url_type','1')->get(['url_url']);
    	foreach($all_use as $val){
    		if($url==$val->url_url){
    			return true;
    		}
    	}
        return false;
    }
    public static function get_goods(){
    	$url=$_SERVER['SERVER_NAME'];
    	$goods_id=self::where('url_url',$url)->first(['url_goods_id']);
        if($goods_id==null){
           return false;
        }
    	if($goods_id->count()<=0){
           return false;
    	}
    	return $goods_id->url_goods_id;
    }
}
