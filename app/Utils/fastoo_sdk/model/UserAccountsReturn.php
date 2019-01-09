<?php 
/**
 * 获取账号接口返回类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
include_once '/sdk/model/ReturnModel.php';
 class UserAccountsReturn extends ReturnModel{
	/**
	 * 所有账号信息
	 */
	public $userAccounts;
	public function __construct($jsonstr){
		$this->jsonstr=$jsonstr;
		$this->obj=json_decode($jsonstr);
		$this->code=$this->obj->code;
		$this->msg=$this->obj->msg;
		if($this->code==0){
			$arr=$this->obj->data->userAccounts;
			$this->userAccounts=array();
			for($i=0;$i<sizeof($arr);$i++){
				array_push($this->userAccounts,$arr[$i]->apiKey);
			}
		}
	}
}

?>