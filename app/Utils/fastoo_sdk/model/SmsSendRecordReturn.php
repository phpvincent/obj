<?php 
include_once '/sdk/model/ReturnModel.php';
include_once '/sdk/model/SmsSendRecordBean.php';

/**
 * 发送记录返回类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
class SmsSendRecordReturn extends ReturnModel {
	/**
	 * 查询的用户
	 */
	public $selectApiKey;
	/**
	 * 查询的发送开始时间
	 */
	public $createTimeEnd;
	/**
	 * 查询的发送结束时间
	 */
	public $createTimeStart;
	/**
	 * 查询的手机号码
	 */
	public $destAddr;
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
	 * 详细记录
	 */
	public $smsrecords;
	
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
			$this->selectApiKey=$this->obj->data->selectApiKey;
			$this->createTimeEnd=$this->obj->data->createTimeEnd;
			$this->createTimeStart=$this->obj->data->createTimeStart;
			$this->destAddr=$this->obj->data->destAddr;
			$arr=$this->obj->data->smsrecords;
			$this->smsrecords=array();
			for($i=0;$i<sizeof($arr);$i++){
				$bean=new SmsSendRecordBean();
				$bean->apiKey=$arr[$i]->apiKey;
				$bean->countryCode=$arr[$i]->countryCode;
				$bean->destAddr=$arr[$i]->destAddr;
				$bean->drErrorcode=$arr[$i]->drErrorcode;
				$bean->drStatus=$arr[$i]->drStatus;
				$bean->drStatuscode=$arr[$i]->drStatuscode;
				$bean->feeCount=$arr[$i]->feeCount;
				$bean->localMsgid=$arr[$i]->localMsgid;
				$bean->loginName=$arr[$i]->loginName;
				$bean->msgContent=$arr[$i]->msgContent;
				$bean->mtErrorcode=$arr[$i]->mtErrorcode;
				$bean->mtStatus=$arr[$i]->mtStatus;
				$bean->mtStatuscode=$arr[$i]->mtStatuscode;
				$bean->price=$arr[$i]->price;
				$bean->submitTime=$arr[$i]->submitTime;
				array_push($this->smsrecords,$bean);
			}
		}
	}
}
?>
