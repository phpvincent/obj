<?php 
/**
 * 批量发送记录基础类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
 class SmsSendRecordBean {
	/**
	 * apiKey
	 */
	public $apiKey;
	/**
	 * 
	 */
	public $countryCode;
	/**
	 * 
	 */
	public $destAddr;
	/**
	 * 
	 */
	public $drErrorcode;
	/**
	 * 报告状态（0:无报告，1:成功，2:失败）
	 */
	public $drStatus;
	/**
	 * 
	 */
	public $drStatuscode;
	/**
	 * 
	 */
	public $feeCount;
	/**
	 * 
	 */
	public $localMsgid;
	/**
	 * 
	 */
	public $loginName;
	/**
	 * 
	 */
	public $msgContent;
	/**
	 * 
	 */
	public $mtErrorcode;
	/**
	 * 发送状态（0:未发送，1:成功，2:失败）
	 */
	public $mtStatus;
	/**
	 * 
	 */
	public $mtStatuscode;
	/**
	 * 
	 */
	public $price;
	/**
	 * 
	 */
	public $submitTime;
}
?>
