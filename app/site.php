<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class site extends Model
{
    public static function is_site($url)
    {
    	$url=url::where([['url_url',$url],['url_site_id','>',0],['url_type',1]])->first();
    	if($url==null){
    		return false;
    	}
    	if(site::where('sites_id',$url->url_site_id)->first()['status']==0) return false;
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
}
