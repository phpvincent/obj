<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vis extends Model
{
    protected $table = 'vis';
    protected $primaryKey ='vis_id';
    public $timestamps=false;

    /** 获取某段时间的访问量
     * @param $today
     * @param $goods_id
     * @param $user_id
     * @return mixed
     */
    public static function visCount($today,$goods_id,$user_id,$goods_arr)
    {
        $count =  \App\vis::where('vis_time','like',$today.'%')
            ->whereIn('vis_goods_id',$goods_arr)
            ->where(function($query)use($goods_id){
                if($goods_id){
                    $query->where('vis_goods_id',$goods_id);
                }
            })->where(function($query)use($user_id){
                $goods_ids = \App\goods::where('goods_admin_id',$user_id)->pluck('goods_id')->toArray();
                if($user_id){
                    $query->whereIn('vis_goods_id',$goods_ids);
                }
            })->count();
        return $count;
    }

    /** 获取某段时间的购买量
     * @param $today
     * @param $goods_id
     * @param $user_id
     * @return mixed
     */
    public static function visBuyCount($today,$goods_id,$user_id,$goods_arr)
    {
        $count =  \App\vis::where('vis_buytime','like',$today.'%')
            ->whereIn('vis_goods_id',$goods_arr)
            ->where(function($query)use($goods_id){
                if($goods_id){
                    $query->where('vis_goods_id',$goods_id);
                }
            })->where(function($query)use($user_id){
                $goods_ids = \App\goods::where('goods_admin_id',$user_id)->pluck('goods_id')->toArray();
                if($user_id){
                    $query->whereIn('vis_goods_id',$goods_ids);
                }
            })->count();
        return $count;
    }

    /** 获取某段时间的下单量
     * @param $today
     * @param $goods_id
     * @param $user_id
     * @return mixed
     */
    public static function visOrderCount($today,$goods_id,$user_id,$goods_arr)
    {
        $count =  \App\vis::where('vis_ordertime','like',$today.'%')
            ->whereIn('vis_goods_id',$goods_arr)
            ->where(function($query)use($goods_id){
                if($goods_id){
                    $query->where('vis_goods_id',$goods_id);
                }
            })->where(function($query)use($user_id){
                $goods_ids = \App\goods::where('goods_admin_id',$user_id)->pluck('goods_id')->toArray();
                if($user_id){
                    $query->whereIn('vis_goods_id',$goods_ids);
                }
            })->count();
        return $count;
    }

    /** 获取某段时间的评论量
     * @param $today
     * @param $goods_id
     * @param $user_id
     * @return mixed
     */
    public static function visComCount($today,$goods_id,$user_id,$goods_arr)
    {
        $count =  \App\vis::where('vis_comtime','like',$today.'%')
            ->whereIn('vis_goods_id',$goods_arr)
            ->where(function($query)use($goods_id){
                if($goods_id){
                    $query->where('vis_goods_id',$goods_id);
                }
            })->where(function($query)use($user_id){
                $goods_ids = \App\goods::where('goods_admin_id',$user_id)->pluck('goods_id')->toArray();
                if($user_id){
                    $query->whereIn('vis_goods_id',$goods_ids);
                }
            })->count();
        return $count;
    }
}
