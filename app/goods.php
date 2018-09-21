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

    public static function get_ownid($admin_id){
        $admin_ids=\App\admin::get_group_ids($admin_id);
    	$arr=self::whereIn('goods_admin_id',$admin_ids)->get(['goods_id'])->toArray();
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
}
