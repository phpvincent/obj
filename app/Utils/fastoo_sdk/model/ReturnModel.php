<?php
/**
 * 返回模型的基础类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
class ReturnModel {
	/**
	 * 返回的json对象
	 */
	public  $obj;
	/**
	 * 返回编码
	 */
	public  $code;
	/**
	 * 返回信息
	 */
	public  $msg;
	/**
	 * 返回的json
	 */
	public  $jsonstr;
	public function __construct($jsonstr){
		$this->jsonstr=$jsonstr;
		$this->obj=json_decode($jsonstr);
		$this->code=$this->obj->code;
		$this->msg=$this->obj->msg;
	}
}
?>
