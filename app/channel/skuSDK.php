<?php

namespace App\channel;

use App\kind_config;
use App\kind_val;
use App\goods_kind;

class skuSDK{
	//产品id
	public $kind_id;
	//产品类型id
	public $product_type_id;
	//产品受众编号
	public $user_type;
	//sku码
	protected $sku_code;	
	//是否为重用SKU码
	protected $is_replay=false;
	//错误提示
	protected $error;
	public function __construct($kind_id,$product_type_id,$user_type){
		$this->kind_id=$kind_id;
		$this->product_type_id=$product_type_id;
		$this->user_type=$user_type;
      /* $this->goods=$goods;
       $this->cuxiao=cuxiao::where('cuxiao_goods_id',$goods->goods_id)->orderBy('cuxiao_id','asc')->first();
       $this->cuxiaos=cuxiao::where('cuxiao_goods_id',$goods->goods_id)->orderBy('cuxiao_id','asc')->get();*/
	}
	/**
	 * 根据产品id设置sku吗
	 */
	public function set_sku()
	{	
		$num=$this->get_sku_first_to_forth();
		$this->set_sku_by_attr(); //  设置后六位
		if($num&&\App\goods_kind::select('goods_kind_sku')->where('goods_kind_id',$this->kind_id)->first()['goods_kind_sku']==null){
				if($this->is_replay){
						\App\sku_free::where('sku_free_msg',$num)->delete();
						goods_kind::where('goods_kind_id',$this->kind_id)->update(['goods_kind_sku'=>$num,'goods_kind_sku_status'=>'2']);
				}else{
						goods_kind::where('goods_kind_id',$this->kind_id)->update(['goods_kind_sku'=>$num,'goods_kind_sku_status'=>'0']);
				}
		}	
		if(\App\goods_kind::select('goods_kind_sku')->where('goods_kind_id',$this->kind_id)->first()['goods_kind_sku']==null)
		{	
			return false;
		}
		return \App\goods_kind::select('goods_kind_sku')->where('goods_kind_id',$this->kind_id)->first()['goods_kind_sku'];
	}
	/**
	 * 生成sku码1-4位数
	 * @return [int] [description]
	 */
	public function get_sku_first_to_forth()
	{	
		$free=$this->get_free_sku();
		if($free){
			$this->is_replay=true;
			$this->sku_code=$free;
			return $free;
		}
		$last_sku=goods_kind::select('goods_kind_sku')->where(function($query){
			$query->where('goods_product_id',$this->product_type_id);
			$query->where('goods_kind_id',"<>",$this->kind_id);
			$query->where('goods_kind_sku',"<>",'');
			$query->whereNotNull('goods_kind_sku');
			$query->where('goods_kind_sku_status',0);
		})->orderBy('goods_kind_time','desc')->orderBy('goods_kind_id','desc')->first();
		if($last_sku==null){
			$uper=1;
			$end_num=$this->product_type_id.'01';
			$end_num.=$this->user_type;
			while(goods_kind::where([['goods_kind_sku',$end_num],['goods_kind_sku_status','<>','1']])->first()!=null){
				$uper++;
				$end_num=$this->product_type_id.sprintf('%02d', $uper);
				$end_num.=$this->user_type;
			}
			$this->sku_code=$end_num;
			return $end_num;
		}
		$kind_sku=substr($last_sku->goods_kind_sku, 1,2);
		$first_sku=$last_sku=substr($last_sku->goods_kind_sku, 0,1);
		$last_sku=self::num_return($last_sku,false);
		$uper=self::num_return($kind_sku,false);
		$num=intval($last_sku/10);
		$yu=$last_sku%10;
		//dd($uper,$num,$yu);
		if($uper>=1295&&$num==2&&$yu<=5){
			$first_num=self::num_return(($num+1)*10+$yu);
			$second_third_num=self::num_return(1);
		}else if(($uper>=1295&&$num>=2&&$yu>5)||($uper>=1295&&$num>=3&&$yu<=5)||($num>3)){
			//品类下已经到达最大值且无法再递增品类sku值
			\Log::info('sku码饱和:uper:'.$uper.'num:'.$num.'yu:'.$yu);
			$this->error='产品sku已经饱和，请先释放已完全废用的产品sku码！！:uper:'.$uper.'num:'.$num.'yu:'.$yu.'first_sku:'.$first_sku;
			return false;
		}else if($uper>=1295&&$num<2){
			$first_num=self::num_return(($num+1)*10+$yu);
			$second_third_num=self::num_return(1);
		}else if($uper<1295&&$num<=3){
			$first_num=self::num_return($last_sku);
			$second_third_num=self::num_return($uper+1);
		}else{
			\Log::info('sku码算法错误:uper:'.$uper.'num:'.$num.'yu:'.$yu.'first_sku:'.$first_sku);
			$this->error='sku码算法错误,无法生成 ';
			return false;
		}
		if(strlen($second_third_num)<2){
			for ($i=0; $i < 2-strlen($second_third_num); $i++) { 
				$second_third_num='0'.$second_third_num;
			}
		}
		$end_num=(string)$first_num.$second_third_num;
		$end_num.=$this->user_type;
		$this->sku_code=$end_num;
		return $end_num;
	}
	/**
	 * 获取释放池中的SKU码
	 * @param  [int] $type_id [sku码对应种类]
	 * @return          [有就返回SKU码，无返回false]
	 */
	public function get_free_sku()
	{
		$product_type_id=$this->product_type_id;
		$free_sku=\App\sku_free::select('sku_free_msg')->where(function($query){
			$query->where('sku_free_type',$this->product_type_id);
		})
		->first();
		if($free_sku!=null){
			//$msg=\App\sku_free::where('sku_free_msg',$free_sku->sku_free_msg)->delete();
			//if($msg){
							return $free_sku['sku_free_msg'];
			/*}
			return false;*/
		}
		return false;
	}
	/**
	 * 根据sku码换取产品数据
	 * @param  [type] $sku [sku码]
	 * @return [\App\goods_kind]      [产品数据]
	 */
	public static function sku_to_kind($sku)
	{	
		if(strlen($sku)>=4){
			$sku=substr($sku, 0,4);
		}
		$goods_kind=\App\goods_kind::where('goods_kind_sku',$sku)->first();
		if($goods_kind==null){
			return false;
		}
		return $goods_kind;
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
     * 获取商品颜色SKU
     * @param $num //色系值
     * @param $goods_sku_color  //sku拼接参数 [70=>1,80=>2,....]
     * @return string
     */
	public static function get_color_sku($num,&$goods_sku_color)
    {
        $val = ' ';
        if(!empty($goods_sku_color)){
            foreach ($goods_sku_color as $key => &$value){
                if($num == $key){
                    if($num/10 >= 1){
                        $val = $num/10 .self::num_return($value);
                        $value--;
                    }else{
                        $val = 0 .self::num_return($value+1);
                        $value--;
                    }
                }
            }
        }
        return $val;
    }

	/**
	 * 十进制数转换成62进制
	 *
	 * @param integer $num
	 * @return string
	 */
	public static function to62($num) 
	{
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
	public static function from62($num) 
	{
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

	// 通过产品属性值id 获取sku码
	private function get_attr_sku_by_kind($kind_val_ids)
    {
        if(is_string($kind_val_ids)) {
            $kind_val_ids = explode(',', $kind_val_ids);
        }
        if(count($kind_val_ids) < 1){
            return ;
        }
        $sku = '';
        $kind_config_ids = $this->get_attr_sku_config_sort($this->kind_id);
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
    private  function get_attr_sku_config_sort()
    {
        $sku_ids = [];
        $kind_configs = kind_config::where('kind_primary_id', $this->kind_id)->orderBy('kind_config_id')->get();
        $config_count = count($kind_configs);
        $x45 = $this->has_attr('color',$kind_configs);
        if($x45){
            $sku_ids['x45'] = $x45;
        }
        $x67 = $this->has_attr('size',$kind_configs);
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

    // 设置sku码 后六位或后四位
	public function set_sku_by_attr()
    {
        $kind_configs = kind_config::where('kind_primary_id', $this->kind_id)->get();
        $x45 = $this->has_attr('color',$kind_configs);
        $count_config = count($kind_configs);
        if($count_config > 0) {
            foreach ($kind_configs as $kind_config){
                if($x45 == $kind_config->kind_config_id){
                    continue;
                }
                $vals = kind_val::where('kind_primary_id',$this->kind_id)->where('kind_type_id', $kind_config->kind_config_id)->orderBy('kind_val_id')->get();
                foreach ($vals as $val){
                    $this->set_sku_by_sort($val->kind_val_id);
                }
            }
        }
    }
    public function has_attr($attr_name,$kind_configs)
    {
        $is_has = false;
        switch ($attr_name){
            case 'color':
                $is_has = $this->has_color($kind_configs);
                break;
            case 'size':
                $is_has = $this->has_size($kind_configs);
                break;
            default:
                break;
        }
        return $is_has;
    }
    private function has_color($kind_configs)
    {
        foreach ($kind_configs as $kind_config) {
            if (strtolower($kind_config->kind_config_english_msg） == 'color') || in_array($kind_config->kind_config_msg, ['颜色', '顏色']) || strtolower($kind_config->kind_config_msg) == 'color') {
                return $kind_config->kind_config_id;
            }
        }
        return false;
    }
    private function has_size($kind_configs)
    {
        foreach ($kind_configs as $kind_config) {
            if (strtolower($kind_config->kind_config_english_msg） == 'size') || in_array($kind_config->kind_config_msg, ['尺寸', '尺码', '规格', '尺碼', '規格']) || strtolower($kind_config->kind_config_msg) == 'size') {
                return $kind_config->kind_config_id;
            }
        }
        return false;
    }
	public function get_msg_by_sku($sku,$kind_type_id)
    {
        $value = kind_val::where('kind_primary_id',$this->kind_id)->where('kind_type_id',$kind_type_id)->where('sku', $sku)->first();
        return $value->kind_val_msg;
    }
	public function set_sku_by_sort($kind_val_id)
    {
        $kind_val = kind_val::find($kind_val_id);
        $count = kind_val::where('kind_primary_id', $kind_val->kind_primary_id)->where('kind_type_id', $kind_val->kind_type_id)->where('kind_val_id','<', $kind_val->kind_val_id)->orderBy('kind_val_id')->count();
        $sku = self::num_return($count+1);
        $sku = strlen($sku) == 1 ? '0'.$sku: $sku;
        $kind_val->kind_val_sku = $sku;
        $kind_val->save();
        return $sku;
    }
	public function get_sku()
	{
		return $this->sku_code;
	}
	public function get_error()
	{
		if($this->error!=null){
			return $this->error;
		}else{
			return false;
		}
	}
}