<?php 
/**
 *获取短信/语音价格基础类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */

include '/sdk/model/ReturnModel.php';
class QuotedPriceReturn extends ReturnModel {
	/**
	 * 语音价格
	 */
	public $vtprice;
	/**
	 * 短信价格
	 */
	public $mtprice;
	public function __construct($jsonstr){
		$this->jsonstr=$jsonstr;
		$this->obj=json_decode($jsonstr);
		$this->code=$this->obj->code;
		$this->msg=$this->obj->msg;
		if($this->code==0){
			//成功
			$this->vtprice=$this->obj->data->vtprice;
			$this->mtprice=$this->obj->data->mtprice;
			
		}
	}
}
?>
