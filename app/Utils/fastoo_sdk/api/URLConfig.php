<?php 
/**
 * 访问路径统一配置
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
 class URLConfig {
	/**
	 * 用户-获取用户信息
	 */
	public  $GetUserApiURL="http://api.fastoo.cn/v1/user/get.json";
	/**
	 * 获取短信/语音价格
	 */
	public  $GetQuotedPriceApiURL="http://api.fastoo.cn/v1/sys/getQuotedPrice.json";
	/**
	 * 获取账号ApiURL
	 */
	public  $GetUserAccountsApiURL="http://api.fastoo.cn/v1/admin/getUserAccounts.json";
	/**
	 * 查询金额ApiURL
	 */
	public  $GetUserBalanceApiURL="http://api.fastoo.cn/v1/admin/getUserBalance.json";
	/**
	 * 发送短信（单条）
	 */
	public  $QuickSendSingleSmsApiURL="http://api.fastoo.cn/v1/admin/quickSendSingleSms.json";
	/**
	 *发送短信
	 */
	public  $SubmitApiURL="http://api.fastoo.cn/v1/submit.json";
	/**
	 *DR报告接口
	 */
	public  $DRURL="***";
	/**
	 *获取签名报备接口
	 */
	public  $SignatureSearchURL="http://api.fastoo.cn/v1/admin/signature.json";
	/**
	 *添加/修改签名报备接口
	 */
	public  $SignatureSaveURL="http://api.fastoo.cn/v1/admin/signature/save.json";
	/**
	 *添加/修改签名报备接口
	 */
	public  $SignatureDelURL="http://api.fastoo.cn/v1/admin/signature/del.json";
	/**
	 *获取模板报备接口
	 */
	public  $TemplateSearchURL="http://api.fastoo.cn/v1/admin/template.json";
	/**
	 *添加/修改模板报备接口
	 */
	public  $TemplateSaveURL="http://api.fastoo.cn/v1/admin/template/save.json";
	/**
	 *删除模板报备接口
	 */
	public  $TemplateDelURL="http://api.fastoo.cn/v1/admin/template/del.json";
	/**
	 *获取APIKey接口
	 */
	public  $APIKeySearchURL="http://api.fastoo.cn/v1/admin/apiKeys.json";
	/**
	 *添加APIKey接口
	 */
	public  $APIKeyAddURL="http://api.fastoo.cn/v1/admin/apiKeys/save.json";
	/**
	 *修改APIKey接口
	 */
	public  $APIKeyUpdateURL="http://api.fastoo.cn/v1/admin/apiKeys/saveDr.json";
	
	/**
	 *删除APIKey接口
	 */
	public  $APIKeyDelURL="http://api.fastoo.cn/v1/admin/apiKeys/del.json";
	/**
	 * 批量发送短信ApiURL
	 */
	public  $QuickSendBatchSmsApiURL="http://api.fastoo.cn/v1/admin/batch/submit.json";
	/**
	 *获取获取发送记录ApiURL
	 */
	public  $SmsRecordsApiURL="http://api.fastoo.cn/v1/admin/records.json";
	/**
	 * 批量发送短信ApiURL
	 */
	public  $SmsBatchRecordsApiURL="http://api.fastoo.cn/v1/admin/batch.json";
	/**
	 * 发送记录状态设置ApiURL
	 */
	public  $SmsBatchStatusApiURL="http://api.fastoo.cn/v1/admin/batch/status.json";
	/**
	 * 发送记录状态设置ApiURL
	 */
	public  $SmsExportRecordsApiURL="http://api.fastoo.cn/v1/admin/records/export.json";
	/**
	 *账户充值 ApiURL
	 */
	public  $RechargeAlipayApiURL="http://api.fastoo.cn/v1/admin/recharge/alipay.json";
	/**
	 *获取充值记录ApiURL
	 */
	public  $RechargeSearchApiURL="http://api.fastoo.cn/v1/admin/recharge.json";
	/**
	 *获取余额提醒ApiURL
	 */
	public  $GetBalanceRemindInfoApiURL="http://api.fastoo.cn/v1/admin/getBalanceRemindInfo.json";
	/**
	 *获取余额提醒ApiURL
	 */
	public  $SetBalanceRemindApiURL="http://api.fastoo.cn/v1/admin/setBalanceRemind.json";
	/**
	 * 获取IP白名单ApiURL
	 */
	public  $WhiteIPSearchApiURL="http://api.fastoo.cn/v1/admin/iplist.json";
	/**
	 * 添加/修改IP白名单ApiURL
	 */
	public  $WhiteIPSaveApiURL="http://api.fastoo.cn/v1/admin/iplist/save.json";

	/**
	 * 删除IP白名单ApiURL
	 */
	public  $WhiteIPDelApiURL="http://api.fastoo.cn/v1/admin/iplist/del.json";
	/**
	 * 设置IP白名单保护ApiURL
	 */
	public  $WhiteIPSwitchApiURL="http://api.fastoo.cn/v1/admin/iplist/switch.json";
	/**
	 * 获取IP白名单ApiURL
	 */
	public  $BlackIPSearchApiURL="http://api.fastoo.cn/v1/admin/blacklist.json";
	/**
	 * 添加/修改黑名单ApiURL
	 */
	public  $BlackIPSaveApiURL="http://api.fastoo.cn/v1/admin/blacklist/save.json";

	/**
	 * 删除IP黑名单ApiURL
	 */
	public  $BlackIPDelApiURL="http://api.fastoo.cn/v1/admin/blacklist/del.json";
	/**
	 * 获取账号信息ApiURL
	 */
	public  $GetUserInfoApiURL="http://api.fastoo.cn/v1/admin/getUserInfo.json";
	/**
	 * 设置账号信息ApiURL
	 */
	public  $UpdateInfoApiURL="http://api.fastoo.cn/v1/admin/user/updateinfo.json";
	/**
	 * 修改密码ApiURL
	 */
	public  $ChangePWDApiURL="http://api.fastoo.cn/v1/admin/user/changepwd.json";


}
?>
