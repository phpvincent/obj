<?php

/**
 * 账户充值返回类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
include_once '/sdk/model/ReturnModel.php';
include_once '/sdk/model/RechargeBean.php';
class RechargeReturn extends ReturnModel {
	/**
	 * 每页数据条数
	 */
	public $size;
	/**
	 * 总共有几页
	 */
	public $totalPages;
	/**
	 * 总共有几条
	 */
	public $totalElements;
	/**
	 * 返回记录
	 */
	public $recharges;
	public function __construct($jsonstr){
		$this->jsonstr=$jsonstr;
		$this->obj=json_decode($jsonstr);
		$this->code=$this->obj->code;
		$this->msg=$this->obj->msg;
		if($this->code==0){
			//成功
			$this->totalElements=$this->obj->data->totalElements;
			$this->size=$this->obj->data->size;
			$this->totalPages=$this->obj->data->totalPages;
			$arr=$this->obj->data->recharges;
			$this->recharges=array();
			for($i=0;$i<sizeof($arr);$i++){
				$bean=new RechargeBean();
				$bean->createTime=$arr[$i]->createTime;
				$bean->id=$arr[$i]->id;
				$bean->rechargeNo=$arr[$i]->rechargeNo;
				$bean->status=$arr[$i]->status;
				$bean->totalPrice=$arr[$i]->totalPrice;
				$bean->tradeNo=$arr[$i]->tradeNo;
				array_push($this->recharges,$bean);
			}
		}
	}

}
?>
