<?php 
/**
 * 账户充值返回基础类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
include_once '/sdk/model/ReturnModel.php';
class RechargeAlipayReturn extends ReturnModel{
	/**
	 * 返回的html
	 */
	public $textHtml;
	public function __construct($jsonstr){
		$this->jsonstr=$jsonstr;
		$this->obj=json_decode($jsonstr);
		$this->code=$this->obj->code;
		$this->msg=$this->obj->msg;
		if($this->code==0){
			//成功
			$this->textHtml=$this->obj->data->textHtml;
		}
	}
}
?>
