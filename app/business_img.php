<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class business_img extends Model
{
    protected $table = 'business_img';
    protected $primaryKey ='business_img_id';
    public $timestamps=false;
    public static function get_img($url){
    	$data=\App\business::where('bus_url',$url)->first();
    	$id=$data->bus_id;
    	$fm=self::where([['business_img_type','=','fm'],['business_web_id','=',$id]])->orderBy('business_img_order','desc')->get();
    	$bg=self::where([['business_img_type','=','bg'],['business_web_id','=',$id]])->orderBy('business_img_order','desc')->get();
    	$goods=self::where([['business_img_type','=','goods'],['business_web_id','=',$id]])->orderBy('business_img_order','desc')->get();
    	$about=self::where([['business_img_type','=','about'],['business_web_id','=',$id]])->orderBy('business_img_order','desc')->get();
    	$arr=compact('fm','bg','goods','about');
    	return $arr;
    }
}
