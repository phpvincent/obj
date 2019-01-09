<?php 
/**
 * 获取上月发送记录返回类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
include_once '/sdk/model/ReturnModel.php';
include_once '/sdk/model/SmsSendRecordBean.php';
class SmsExportReordReturn extends ReturnModel{
	/**
	 * 详细记录
	 */
	public $list;
	public function __construct($jsonstr){
		$this->jsonstr=$jsonstr;
		$this->obj=json_decode($jsonstr);
		$this->code=$this->obj->code;
		$this->msg=$this->obj->msg;
		if($this->code==0){
			$arr=$this->obj->data->list;
			$this->list=array();
			for($i=0;$i<sizeof($arr);$i++){
				$bean=new SmsSendRecordBean();
				$bean->apiKey=$arr[$i]->apiKey;
				$bean->countryCode=$arr[$i]->countryCode;
				$bean->destAddr=$arr[$i]->destAddr;
				$bean->drStatus=$arr[$i]->drStatus;
				$bean->feeCount=$arr[$i]->feeCount;
				$bean->msgContent=$arr[$i]->msgContent;
				$bean->mtStatus=$arr[$i]->mtStatus;
				$bean->price=$arr[$i]->price;
				$bean->submitTime=$arr[$i]->submitTime;
				array_push($this->list,$bean);
			}
		}
	}
}
?>
