<?php 
include_once '/sdk/model/ReturnModel.php';
include_once '/sdk/model/SmsBatchRecordBean.php';
/**
 * 批量发送记录返回类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
class SmsBatchRecordReturn extends ReturnModel {
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
	public $batchDtos;
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
			$this->totalElements=$this->obj->data->totalElements;
			$this->size=$this->obj->data->size;
			$this->totalPages=$this->obj->data->totalPages;
			$arr=$this->obj->data->batchDtos;
			$this->batchDtos=array();
			for($i=0;$i<sizeof($arr);$i++){
				$bean=new SmsBatchRecordBean();
				$bean->apiKey=$arr[$i]->apiKey;
				$bean->batchName=$arr[$i]->batchName;
				$bean->content=$arr[$i]->content;
				$bean->id=$arr[$i]->id;
				$bean->sendFailNum=$arr[$i]->sendFailNum;
				$bean->sendSuccessNum=$arr[$i]->sendSuccessNum;
				$bean->status=$arr[$i]->status;
				$bean->submitTime=$arr[$i]->submitTime;
				$bean->submitTimeDt=$arr[$i]->submitTimeDt;
				$bean->timing=$arr[$i]->timing;
				$bean->totalNum=$arr[$i]->totalNum;
				$bean->unSendNum=$arr[$i]->unSendNum;
				$bean->userBaseId=$arr[$i]->userBaseId;
				array_push($this->batchDtos,$bean);
			}
		}
	}
}
?>