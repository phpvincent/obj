<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class site extends Model
{
    public $table = 'sites';
    protected $primaryKey ='sites_id';

    public static function is_site($url)
    {
    	$url=url::where([['url_url',$url],['url_site_id','>',0],['url_type',1]])->first();
    	if($url==null){
    		return false;
    	}
    	if(site::where('sites_id',$url->url_site_id)->first()['status']==1) return false;
    	return true;
    }
    public static function get_id($url)
    {
    	$url=url::where([['url_url',$url],['url_site_id','>',0],['url_type',1]])->first();
    	if($url==null){
    		return false;
    	}
    	return $url['url_site_id'];
    }
    public static function get_search_arr($search,$type=true)
    {
        $arr=self::where('sites_name','like',"%".$search."%")->get(['sites_id'])->toArray();
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
}
