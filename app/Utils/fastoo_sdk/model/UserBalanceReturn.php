<?php 
/**
 * 查询余额接口返回类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
include_once '/sdk/model/ReturnModel.php';
class UserBalanceReturn extends ReturnModel {
	/**
	 * 余额
	 */
	public $balance;
	/**
	 * 初始化
	 * @param jsonstr
	 */
	public function __construct($jsonstr){
		$this->jsonstr=$jsonstr;
		$this->obj=json_decode($jsonstr);
		$this->code=$this->obj->code;
		$this->msg=$this->obj->msg;
		if($this->code==0){
			//成功
			$this->balance=$this->obj->data->balance;
		}
	}
}
?>
