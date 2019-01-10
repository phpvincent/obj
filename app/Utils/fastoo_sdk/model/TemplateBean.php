<?php 
/**
 * 模板基础类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
class TemplateBean {
	/**
	 * 账号
	 */
	public $apiKey;
	/**
	 * app地址
	 */
	public $appUrl;
	/**
	 * 申请时间
	 */
	public $applyTime;
	/**
	 * 审核时间
	 */
	public $auditTime;
	/**
	 * 模板唯一标识
	 */
	public $id;
	/**
	 * 原因
	 */
	public $reason;
	/**
	 * 状态（0:未审核，1;通过）
	 */
	public $state;
	/**
	 * 模板内容
	 */
	public $templateContent;
	/**
	 * 模板类型（1:验证码类，2:通知类，3:营销类）
	 */	
	public $templateType;
	
}
?>