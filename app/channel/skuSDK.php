<?php
namespace App\channel;
use App\goods_kind;
use App\product_type;
use App\special;
use Illuminate\Http\Request;
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
	public $error;
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
		if($num){
				if($this->is_replay){
						goods_kind::where('goods_kind_id',$this->kind_id)->update(['goods_kind_sku'=>$num,'goods_kind_sku_status'=>'2']);
				}else{
						goods_kind::where('goods_kind_id',$this->kind_id)->update(['goods_kind_sku'=>$num,'goods_kind_sku_status'=>'0']);
				}
			return $num;
		}
		return false;
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
			$query->where('goods_kind_sku_status',0);
		})->orderBy('goods_kind_time','desc')->first();
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
			$msg=\App\sku_free::where('sku_free_msg',$free_sku->sku_free_msg)->delete();
			if($msg){
							return $free_sku['sku_free_msg'];
			}
			return false;
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
	public function get_sku()
	{
		return $this->sku_code;
	}
}