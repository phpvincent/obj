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

   public static function get_order_status($order_type)
   {
        switch ($order_type){
            case '0':
                return '未核审';
            case '1':
                return '通过核审';
            case '2':
                return '拒绝核审';
            case '3':
                return '已扣货';
            case '4':
                return '已出仓';
            case '5':
                return '供应驳回';
            case '6':
                return '退货并已退款';
            case '7':
                return '未退货已退款';
            case '8':
                return '拒签';
            case '9':
                return '在线支付预付款';
            case '10':
                return '在线支付取消付款';
            case '11':
                return '在线支付付款成功';
            case '12':
                return '在线支付付款失败';
            case '13':
                return '支付成功但paypal反馈数据存储失败14';
            case '14':
                return '问题订单';
        }
   }

   public static function order_pay_types($goods_blade_type,$order_pay_type)
   {
        $order_pay_types = "貨到付款";
        switch($goods_blade_type){
            case "0":
                $order_pay_types = $order_pay_type == 0 ? '貨到付款': '線上支付';
                return $order_pay_types;
            case "1":
                $order_pay_types = $order_pay_type == 0 ? '货到付款': '在线支付';
                break;
            case "2" :
            case "3" :
            case "7" :
            case "8" :
            case "9" :
            case "10":
            case "13":
            case "15":
            case "17":
                $order_pay_types = $order_pay_type == 0 ? 'Cash on Delivery': 'Online payment';
                break;
            case "4": //泰国模板（旧版）
                $order_pay_types = $order_pay_type == 0 ? 'Cash on Delivery': 'Online payment';
                break;
            case "5" : //日本模板（旧版）
                $order_pay_types = $order_pay_type == 0 ? 'Cash on Delivery': 'Online payment';
                break;
            case "6" : //印度尼西亚
                $order_pay_types = $order_pay_type == 0 ? 'COD(Bayar di tempat)': 'pesan online';
                break;
            case "11" : //越南
                $order_pay_types = $order_pay_type == 0 ? 'Cash on Delivery': 'Online payment';
                break;
            case "12" : 
            case "14" :
            case "16" :
                $order_pay_types = $order_pay_type == 0 ? 'الدفع عند التسليم': 'الدفع عبر الإنترنت';
                break;

                
        }
        return $order_pay_types;
   }
}
