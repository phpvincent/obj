<?php 


/**
 * 设备报备基础类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
class SignatureBean {
	/**
	 * 账号
	 */
	public $apiKey;
	/**
	 * 申请时间
	 */
	public $signApplyTime;
	/**
	 * 审核时间
	 */
	public $signAuditTime;
	/**
	 * 签名
	 */
	public $signName;
	/**
	 * 审核状态（0:未审核，1:通过）
	 */
	public $signStatus;
}
?>
