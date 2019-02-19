<?php
namespace App\channel;
use App\goods;
use App\cuxiao;
use App\kind_config;
use App\kind_val;
use App\special;
use Illuminate\Http\Request;
class skuSDK{
	public $goods;
	public $cuxiao;
	public $cuxiaos;
	public function __construct(){
      /* $this->goods=$goods;
       $this->cuxiao=cuxiao::where('cuxiao_goods_id',$goods->goods_id)->orderBy('cuxiao_id','asc')->first();
       $this->cuxiaos=cuxiao::where('cuxiao_goods_id',$goods->goods_id)->orderBy('cuxiao_id','asc')->get();*/
	}
	/**
	 * 10-36进制转换
	 * @num  [int]  $num  [要转换的值]
	 * @type  boolean $type [转换类型]
	 * @return [int]        [数值]
	 */
	public static function num_return(String $num,$type=true)
	{
		if($type){
			return base_convert($num,10,36);
		}else if(!$type){
			return base_convert($num,36,10);
		}
	}
	/**
	 * 十进制数转换成62进制
	 *
	 * @param integer $num
	 * @return string
	 */
	public static function to62($num) {
	  $to = 62;
	  $dict = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	  $ret = '';
	  do {
	    $ret = $dict[bcmod($num, $to)] . $ret; //bcmod取得高精确度数字的余数。
	    $num = bcdiv($num, $to);  //bcdiv将二个高精确度数字相除。
	  } while ($num > 0);
	  return $ret;
	}
	/**
	 * 62进制数转换成十进制数
	 *
	 * @param string $num
	 * @return string
	 */
	public static function from62($num) {
	  $from = 62;
	  $num = strval($num);
	  $dict = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	  $len = strlen($num);
	  $dec = 0;
	  for($i = 0; $i < $len; $i++) {
	    $pos = strpos($dict, $num[$i]);
	    $dec = bcadd(bcmul(bcpow($from, $len - $i - 1), $pos), $dec);
	  }
	  return $dec;
	}

	public static function get_attr_sku_by_kind($kind_id, $kind_val_ids)
    {
        if(is_string($kind_val_ids)) {
            $kind_val_ids = explode(',', $kind_val_ids);
        }
        if(count($kind_val_ids) < 1){
            return ;
        }
        $sku = '';
        $kind_config_ids = self::get_attr_sku_config_sort($kind_id);
        $kind_vals = kind_val::whereIn('kind_val_id', $kind_val_ids)->pluck('kind_val_sku', 'kind_type_id')->toArray();
        foreach ($kind_config_ids as $kind_config_id){
            if($kind_config_id) {
                $sku .= $kind_vals[$kind_config_id];
            }else{
                $sku .= '00';
            }
        }
        return $sku;
    }
    // 获取sku各位置对应的属性名
    private static function get_attr_sku_config_sort($kind_id)
    {
        $sku_ids = [];
        $kind_configs = kind_config::where('kind_primary_id', $kind_id)->orderBy('kind_config_id')->get();
        $config_count = count($kind_configs);
        $x45 = self::has_attr('color',$kind_configs);
        if($x45){
            $sku_ids['x45'] = $x45;
        }
        $x67 = self::has_attr('size',$kind_configs);
        if($x67){
            $sku_ids['x67'] = $x67;
        }
        $kind_config_ids = array_column($kind_configs->toArray(), 'kind_config_id');
        $sku_ids['x89'] =  array_values(array_diff($kind_config_ids, $sku_ids));
        switch ($config_count){
            case 3: //三组属性
                if(count($sku_ids['x89']) == 3){ //颜色 尺寸都不存在
                    $sku_ids['x45'] = $sku_ids['x89'][0];
                    $sku_ids['x67'] = $sku_ids['x89'][1];
                    $sku_ids['x89'] = $sku_ids['x89'][2];
                }elseif (count($sku_ids['x89']) == 2){  // 存在颜色或者尺寸
                    if(isset($sku_ids['x45'])) {
                        $sku_ids['x67'] = $sku_ids['x89'][0];
                    }else{
                        $sku_ids['x45'] = $sku_ids['x89'][0];
                    }
                    $sku_ids['x89'] = $sku_ids['x89'][1];
                }else{  // 颜色 尺寸均存在
                    $sku_ids['x89'] = $sku_ids['x89'][0];
                }
                break;
            case 2: //两组属性
                if(count($sku_ids['x89']) == 2){ // 颜色 尺寸均不存在
                    $sku_ids['x45'] = 0;
                    $sku_ids['x67'] = $sku_ids['x89'][0];
                    $sku_ids['x89'] = $sku_ids['x89'][1];
                }elseif (count($sku_ids['x89']) == 1){ // 存在颜色或者尺寸
                    if(isset($sku_ids['x45'])) {
                        $sku_ids['x67'] = 0;
                    }else{
                        $sku_ids['x45'] = 0;
                    }
                    $sku_ids['x89'] = $sku_ids['x89'][0];
                }else{ // 颜色 尺寸均存在
                    $sku_ids['x89'] = 0;
                }
                break;
            case 1: // 一组属性
                if(count($sku_ids['x89']) == 1) {
                    $sku_ids['x45'] = 0;
                    $sku_ids['x67'] = 0;
                    $sku_ids['x89'] = $sku_ids['x89'][0];
                }
                break;
            default :
                break;
        }
        ksort($sku_ids);
        return $sku_ids;
    }
	public static function set_sku_by_attr($kind_id)
    {
        $kind_configs = kind_config::where('kind_primary_id', $kind_id)->get();
        $x45 = self::has_attr('color',$kind_configs);
        $count_config = count($kind_configs);
        if($count_config > 0) {
            foreach ($kind_configs as $kind_config){
                if($x45 == $kind_config->kind_config_id){
                    continue;
                }
                $vals = kind_val::where('kind_primary_id',$kind_id)->where('kind_type_id', $kind_config->kind_config_id)->orderBy('kind_val_id')->get();
                foreach ($vals as $val){
                    self::set_sku_by_sort($val->kind_val_id);
                }
            }
        }
    }
    public static function has_attr($attr_name,$kind_configs)
    {
        $is_has = false;
        switch ($attr_name){
            case 'color':
                $is_has = self::has_color($kind_configs);
                break;
            case 'size':
                $is_has = self::has_size($kind_configs);
                break;
            default:
                break;
        }
        return $is_has;
    }
    private static function has_color($kind_configs)
    {
        foreach ($kind_configs as $kind_config) {
            if (strtolower($kind_config->kind_config_english_msg） == 'color') || in_array($kind_config->kind_config_msg, ['颜色', '顏色']) || strtolower($kind_config->kind_config_msg) == 'color') {
                return $kind_config->kind_config_id;
            }
        }
        return false;
    }
    private static function has_size($kind_configs)
    {
        foreach ($kind_configs as $kind_config) {
            if (strtolower($kind_config->kind_config_english_msg） == 'size') || in_array($kind_config->kind_config_msg, ['尺寸', '尺码', '规格', '尺碼', '規格']) || strtolower($kind_config->kind_config_msg) == 'size') {
                return $kind_config->kind_config_id;
            }
        }
        return false;
    }
	public static function get_msg_by_sku($sku,$kind_type_id,$kind_id)
    {
        $value = kind_val::where('kind_primary_id',$kind_id)->where('kind_type_id',$kind_type_id)->where('sku', $sku)->first();
        return $value->kind_val_msg;
    }
	public static function set_sku_by_sort($kind_val_id)
    {
        $kind_val = kind_val::find($kind_val_id);
        $count = kind_val::where('kind_primary_id', $kind_val->kind_primary_id)->where('kind_type_id', $kind_val->kind_type_id)->where('kind_val_id','<', $kind_val->kind_val_id)->orderBy('kind_val_id')->count();
        $sku = self::num_return($count+1);
        $sku = strlen($sku) == 1 ? '0'.$sku: $sku;
        $kind_val->kind_val_sku = $sku;
        $kind_val->save();
        return $sku;
    }
}