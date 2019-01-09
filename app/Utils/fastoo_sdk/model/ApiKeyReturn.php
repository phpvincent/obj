<?php
/**
 * APIKey返回类类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
include_once '/sdk/model/ReturnModel.php';
include_once '/sdk/model/ApiKeyBean.php';
class ApiKeyReturn extends ReturnModel{ 
	

	/**
	 * 返回API Key列表
	 */
	public $APIKeyList;
	/**
	 * 
	 * @param unknown $jsonstr
	 */
	public function __construct($jsonstr){
		$this->jsonstr=$jsonstr;
		$this->obj=json_decode($jsonstr);
		$this->code=$this->obj->code;
		$this->msg=$this->obj->msg;
		if($this->code==0){
			$arr=$this->obj->data->userApiKeys;
			$this->APIKeyList=array();
			for($i=0;$i<sizeof($arr);$i++){
				$bean=new ApiKeyBean();
				$bean->apiKey=$arr[$i]->apiKey;
				$bean->drUrl=$arr[$i]->drUrl;
				$bean->id=$arr[$i]->id;
				array_push($this->APIKeyList,$bean);
			}
		}
	}
}
?>
