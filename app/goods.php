<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class goods extends Model
{
    protected $table = 'goods';
    protected $primaryKey ='goods_id';
    public $timestamps=false;
    public static function comment(){
    	return $this->hasMany('App\comment','com_goods_id','goods_id');
    }
    public static function get_ownid($admin_id){
    	$arr=self::where('goods_admin_id',$admin_id)->get(['goods_id'])->toArray();
    	$ids=[];
    	foreach($arr as $v => $k){
    		$ids[]=$k['goods_id'];
    	}
    	return $ids;
    }
}
