<?php
/**
 * 获取用户信息返回类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
include_once '/sdk/model/ReturnModel.php';
class UserGetReturn extends ReturnModel{
	/**
	 * 登录账号
	 */
	public  $loginName;
	/**
	 * 用户信息
	 */
	public  $apiKeyList;
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
			$this->loginName=$this->obj->data->loginName;
			$arr=$this->obj->data->accounts;
			$this->apiKeyList=array();
			for($i=0;$i<sizeof($arr);$i++){
				array_push($this->apiKeyList,$arr[$i]->apiKey);
			}
		}
	}
}
?>
