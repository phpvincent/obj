<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class order extends Model
{
    protected $table = 'order';
    protected $primaryKey ='order_id';
    public $timestamps=false;

    /**
     *  模型关联表
     */
    public function currency_has_order()
    {
        return $this->hasOne('App\currency_type', 'currency_type_id', 'order_currency_id');
    }

    //获取账户所在组的所有订单
    public static function get_group_order($admin_id){
      $admin=\App\admin::where('admin_id',$admin_id)->first();
      if($admin['is_root']!='1'){
          $garr=[];
//	      $goodsarr=\App\goods::whereIn("goods_admin_id",\App\admin::get_group_ids($admin_id))->get(['goods_id'])->toArray();
	      $goodsarr=\App\goods::whereIn("goods_admin_id",admin::get_admins_id())->get(['goods_id'])->toArray();
	      foreach($goodsarr as $key => $v){
	        $garr[]=$v['goods_id'];
	      }
	      return $garr;
      }else{
      	return self::get();
     }
   }
   public static function get_sale_type($type=true){
    $arr=['1','3','4','11','13'];
    if($type){
          return ['1','3','4','11','13'];
        }else{
          return implode(',', $arr);
        }
   }

    /** 销售额度计算
     * @param $admin  管理员ID
     * @param $start_time 计算开始时间
     * @param $end_time   结束时间
     * @return int
     */
   public static function get_sale_total($admin_id,$start_time,$end_time)
   {
       $goods_ids = goods::where('goods_admin_id',$admin_id)->get();
       $total = 0;
       if(!$goods_ids->isEmpty()){
           foreach ($goods_ids as $goods)
           {
               $sale_num = order::whereBetween('order_time',[$start_time,$end_time])->where('order_goods_id',$goods->goods_id)->where(function($query){
                   $query->whereIn('order.order_type',self::get_sale_type());
               })->sum('order_price');
               $total += $sale_num * $goods->currency_has_goods->exchange_rate;
           }
       }
       //1.获取今天数据订单
//       $orders = order::select(DB::raw('SUM(order_price) as order_price'))->whereBetween('order_time',[$start_time,$end_time])->whereIn('order_goods_id',$goods_ids)->where(function($query){
//           $query->whereIn('order.order_type',self::get_sale_type());
//       })->first();
//       if($orders->order_price){
//           return $orders->order_price;
//       }else{
//           return 0;
//       }
       return $total;
   }
   public static function get_goods_total($goods_id,$start_time,$end_time)
   {  
       $total = 0;
       $goods=\App\goods::where('goods_id',$goods_id)->first();
       if($goods_id!=null){
               $sale_num = order::whereBetween('order_time',[$start_time,$end_time])->where('order_goods_id',$goods_id)->where(function($query){
                   $query->whereIn('order.order_type',self::get_sale_type());
               })->sum('order_price');
               $total += $sale_num * $goods->currency_has_goods->exchange_rate;
       }
       //1.获取今天数据订单
//       $orders = order::select(DB::raw('SUM(order_price) as order_price'))->whereBetween('order_time',[$start_time,$end_time])->whereIn('order_goods_id',$goods_ids)->where(function($query){
//           $query->whereIn('order.order_type',self::get_sale_type());
//       })->first();
//       if($orders->order_price){
//           return $orders->order_price;
//       }else{
//           return 0;
//       }
       return $total;
   }
}
