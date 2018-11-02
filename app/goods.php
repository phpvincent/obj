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

    /**
     *  模型关联表(币种与商品关联)
     */
    public function currency_has_goods()
    {
        return $this->hasOne('App\currency_type', 'currency_type_id', 'goods_currency_id');
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
    public static function get_selfid($admin_id){
        $group=\App\admin::where('admin_id',$admin_id)->first()['admin_group'];
         if(\App\admin_group::where('admin_group_id',$group)->first()['admin_group_name']=='#全体人员#'){
            //全体人员组成员取得所有订单的id
            $admin_ids=self::get(['goods_id'])->toArray();
        }else{
            $admin_ids=self::where('goods_admin_id',$admin_id)->get(['goods_id'])->toArray();
        }
        $ids=[];
        foreach($admin_ids as $v => $k){
            $ids[]=$k['goods_id'];
        }
        return $ids;
    }

    /** 根据语言返回商品模板
     * @param $languages
     * @return array
     */
    public static function get_blade($languages)
    {
        switch ($languages) {
            case '1':
                $band = [0, 1];
                break;
            case '2':
                $band = [2];
                break;
            case '3':
                $band = [3];
                break;
            case '4':
                $band = [4];
                break;
            case '5':
                $band = [5];
                break;
            case '6':
                $band = [6];
                break;
            case '7':
                $band = [7, 8, 9, 10];
                break;
            default:
                $band = false;
                break;
        }
        return $band;
    }
    public static function get_success_blade($goods){
        //根据商品类返回所属成功页面模板
        $blade_id=$goods->goods_blade_type;
        switch ($blade_id) {
            case '0':
                $blade_name='home.TaiwanFan.sendmail';
                break;
            case '1':
                $blade_name='home.TaiwanJian.sendmail';
                break;
            case '2':
                $blade_name='home.zhongdong.zdEndSuccess';
                break;
            case '3':
                $blade_name='home.MaLaiXiYa.mlxyEndSuccess';
                break;
            case '4':
                $blade_name='home.TaiGuo.taiguoEndSuccess';
                break;
            case '5':
                $blade_name='home.RiBen.ribenEndSuccess';
                break;
            case '6':
                $blade_name='home.YinDuNiXiYa.ydnxyEndSuccess';
                break;
            case '7':
                $blade_name='home.FeiLvBin.flbEndSuccess';
                break;
            case '8':
                $blade_name='home.YingGuo.ygEndSuccess';
                break;
            case '9':
                $blade_name='home.googlePC.endSuccess';
                break;
            case '10':
                $blade_name='home.MeiGuo.usEndSuccess';
                break;
            
            default:
                $blade_name='home.YingGuo.ygEndSuccess';
                break;
        }
        return $blade_name;
    }
}
