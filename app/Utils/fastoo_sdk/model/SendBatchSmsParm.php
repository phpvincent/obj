<?php 
/**
 * 批量发送短信的参数类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
class SendBatchSmsParm {
	/**
	 * 用户唯一标识
	 */
	public $apiKey;
	/**
	 * 发送账号
	 */
	public $selectApiKey;
	/**
	 * 批次名称
	 */
	public $batchName;
	/**
	 * 号码（多个号码之间用逗号隔开）
	 */
	public $das;
	/**
	 * 短信内容
	 */
	public $msg;
	/**
	 * 发送时间（若为空则立即发送）
	 */
	public $timing;
	
	public function __construct($apiKey, $selectApiKey, $batchName, $das, $msg,$timing) {
		$this->apiKey = $apiKey;
		$this->selectApiKey = $selectApiKey;
		$this->batchName = $batchName;
		$this->das = $das;
		$this->msg = $msg;
		$this->timing = $timing;
	}
}
?>
