<?php 
include_once '/sdk/model/ReturnModel.php';
include_once '/sdk/model/WhiteIPBean.php';
/**
 * 白名单返回类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
class WhiteIPReturn  extends ReturnModel{
	/**
	 * 返回白名单对象
	 */
	public  $userIplists;
	public function __construct($jsonstr){
		$this->jsonstr=$jsonstr;
		$this->obj=json_decode($jsonstr);
		$this->code=$this->obj->code;
		$this->msg=$this->obj->msg;
		if($this->code==0){
			//成功
			$arr=$this->obj->data->userIplists;
			$this->userIplists=array();
			for($i=0;$i<sizeof($arr);$i++){
				$bean=new WhiteIPBean();
				$bean->createTime=$arr[$i]->createTime;
				$bean->id=$arr[$i]->id;
				$bean->ip=$arr[$i]->ip;
				$bean->remark=$arr[$i]->remark;
				array_push($this->userIplists,$bean);
			}
		}
	}
}
?>
