<?php
namespace App\channel;
use App\goods;
use App\cuxiao;
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
}