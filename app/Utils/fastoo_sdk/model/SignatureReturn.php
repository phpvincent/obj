<?php 
include_once '/sdk/model/ReturnModel.php';
include_once '/sdk/model/SignatureBean.php';
/**
 * 获取设备报备返回类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */

class SignatureReturn extends ReturnModel {
	/**
	 * 返回签名报备列表
	 */
	public $SignatureList;
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
			$arr=$this->obj->data->userSignatures;
			$this->SignatureList=array();
			for($i=0;$i<sizeof($arr);$i++){
				$bean=new SignatureBean();
				$bean->apiKey=$arr[$i]->apiKey;
				$bean->signApplyTime=$arr[$i]->signApplyTime;
				$bean->signAuditTime=$arr[$i]->signAuditTime;
				$bean->signName=$arr[$i]->signName;
				$bean->signStatus=$arr[$i]->signStatus;
				array_push($this->SignatureList,$bean);
			}
		}
	}
}
?>
