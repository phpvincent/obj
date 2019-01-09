<?php 
/**
 * 发送记录参数类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
class SmsSendRecordParm {
	/**
	 * 用户唯一标识
	 */
	public $apiKey;
	/**
	 * 账号
	 */
	public $selectApiKey;
	/**
	 * 发送开始时间
	 */
	public $createTimeStart;
	/**
	 * 发送结束时间
	 */
	public $createTimeEnd;
	/**
	 * 手机号码
	 */
	public $destAddr;
	/**
	 * 第几页（0表示第一页，以此类推）
	 */
	public $pageNo;
	
	public function __construct($apiKey, $selectApiKey, $createTimeStart, $createTimeEnd,$destAddr, $pageNo) {
		$this->apiKey = $apiKey;
		$this->selectApiKey = $selectApiKey;
		$this->createTimeStart = $createTimeStart;
		$this->createTimeEnd = $createTimeEnd;
		$this->destAddr = $destAddr;
		$this->pageNo = $pageNo;
	}
}
?>
