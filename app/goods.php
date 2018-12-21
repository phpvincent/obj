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
    public static function get_only_slef_id($admin_id){
        $arr=self::where([['goods_admin_id','=',$admin_id],['is_del','=','0'],['goods_id','<>','4']])->get(['goods_id'])->toArray();
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
                $band = [12, 14];
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
                $band = [7, 8, 9, 10, 2, 13, 15];
                break;
            case '8':
                $band = [11];
                break;
            default:
                $band = false;
                break;
        }
        return $band;
    }

    /** 根据地区返回商品模板
     * @param $goods_blade_type
     * @return array
     */
    public static function get_area_blade($goods_blade_type)
    {
        switch ($goods_blade_type) {
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
                $band = [7];
                break;
            case '8':
                $band = [8,9];
                break;
            case '9':
                $band = [10];
                break;
            case '10':
                $band = [11];
                break;
            case '11':
                $band = [12,13];
                break;  
            case '12':
                $band = [14,15];
                break;    
            default:
                $band = false;
                break;
        }
        return $band;
    }

    public static function get_success_blade($goods){
        //根据商品类返回所属邮件页面模板
        $blade_id=$goods->goods_blade_type;
        switch ($blade_id) {
            case '0':
                $blade_name='home.TaiwanFan.sendmail';
                break;
            case '1':
                $blade_name='home.TaiwanJian.sendmail';
                break;
            case '2':
                $blade_name='home.zhongdong.sendmail';
                break;
            case '3':
                $blade_name='home.MaLaiXiYa.sendmail';
                break;
            case '4':
                $blade_name='home.TaiGuo.sendmail';
                break;
            case '5':
                $blade_name='home.RiBen.sendmail';
                break;
            case '6':
                $blade_name='home.YinDuNiXiYa.sendmail';
                break;
            case '7':
                $blade_name='home.FeiLvBin.sendmail';
                break;
            case '8':
                $blade_name='home.YingGuo.sendmail';
                break;
            case '9':
                $blade_name='home.googlePC.sendmail';
                break;
            case '10':
                $blade_name='home.MeiGuo.sendmail';
                break;
            case '11':
                $blade_name='home.YueNan.sendmail';
                break;
            case '12':
                 $blade_name='home.ShaTe.sendmail';
                 break;
            case '13':
                $blade_name='home.ShaTeEnglish.sendmail';
                break;
            case '14':
                $blade_name='home.KaTaEr.sendmail';
                break;  
            case '14':
                $blade_name='home.KaTaErEnglish.sendmail';
                break;   
            default:
                $blade_name='home.YingGuo.sendmail';
                break;
        }
        return $blade_name;
    }
}
