<?php
/**
 * 获取余额提醒返回类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
include_once '/sdk/model/ReturnModel.php';
 class BalanceRemindInfoReturn extends ReturnModel {
	/**
	 * 账号
	 */
	public $loginName;
	/**
	 * 提醒开始时间
	 */
	public $startTime;
	/**
	 * 提醒金额
	 */
	public $remindBalance;
	/**
	 * 提醒结束时间
	 */
	public $endTime;
	public function __construct($jsonstr){
		$this->jsonstr=$jsonstr;
		$this->obj=json_decode($jsonstr);
		$this->code=$this->obj->code;
		$this->msg=$this->obj->msg;
		if($this->code==0){ 
			//成功
			$this->loginName=$this->obj->data->loginName;
			$this->startTime=$this->obj->data->startTime;
			$this->remindBalance=$this->obj->data->remindBalance;
			$this->endTime=$this->obj->data->endTime;
		}
	}
	
}
?>
