<?php 
/**
 * 发送记录基础类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
class SmsBatchRecordBean {
	/**
	 * apiKey
	 */
	public $apiKey;
	/**
	 * 
	 */
	public $batchName;
	/**
	 * 
	 */
	public $content;
	/**
	 * 
	 */
	public $id;
	/**
	 * 
	 */
	public $sendFailNum;
	/**
	 * 
	 */
	public $sendSuccessNum;
	/**
	 * 状态(1:启动,0:暂停,-1:取消,2:已发送)
	 */
	public $status;
	/**
	 * 
	 */
	public $submitTime;
	/**
	 * 
	 */
	public $submitTimeDt;
	/**
	 * 
	 */
	public $timing;
	/**
	 * 
	 */
	public $totalNum;
	/**
	 * 
	 */
	public $unSendNum;
	/**
	 * 
	 */
	public $userBaseId;
}
?>
