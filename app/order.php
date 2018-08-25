<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $table = 'order';
    protected $primaryKey ='order_id';
    public $timestamps=false;
    //获取账户所在组的所有订单
    public static function get_group_order($admin_id){
      $admin=\App\admin::where('admin_id',$admin_id)->first();
      if($admin['is_root']!='1'){
          $garr=[];
	      $goodsarr=\App\goods::whereIn("goods_admin_id",\App\admin::get_group_ids($admin_id))->get(['goods_id'])->toArray();
	      foreach($goodsarr as $key => $v){
	        $garr[]=$v['goods_id'];
	      }
	      return $garr;
      }else{
      	return self::get();
     }
   }
}
