<?php 
/**
 * 发送短信的参数类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
class SendSingleSmsParm {
	/**
	 *  用户唯一标识
	 */
	public $apiKey;
	/**
	 * 国家唯一标识
	 */
	public $countryEn;
	/**
	 * 号码
	 */
	public $mobile;
	/**
	 * 国内/国际短信标识（domestic表示国内，其他值表示国际）
	 */
	public $isDomestic;
	/**
	 * 短信内容（若标识是domestic，默认短信内容只能是【Fastoo】您的验证码是1824，该字段填写的内容无效果）
	 */
	public $smscontent;
	
	public  function __construct($apiKey, $countryEn, $mobile, $isDomestic,$smscontent) {
		$this->apiKey = $apiKey;
		$this->countryEn = $countryEn;
		$this->mobile = $mobile;
		$this->isDomestic = $isDomestic;
		$this->smscontent = $smscontent;
	}
}
?>
