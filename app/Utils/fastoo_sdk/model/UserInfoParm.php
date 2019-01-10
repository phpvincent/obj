<?php
/**
 * 设置账号信息参数类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
class UserInfoParm {
	/**
	 * 用户唯一标识
	 */
	public $apiKey;
	/**
	 * 开发者类型(1:公司，2:个人)
	 */
	public $userType;
	/**
	 * 公司名称（开发者类型为公司必传）
	 */
	public $company;
	/**
	 * 所属行业（开发者类型为公司必传）
	 */
	public $industry;
	/**
	 * 营业执照（开发者类型为公司必传）
	 */
	public $businessLicence;
	/**
	 * 营业执照照片名称（开发者类型为公司必传）
	 */
	public $businessLicenceImg;
	/**
	 * 真实姓名（开发者类型为个人必传）
	 */
	public $realName;
	/**
	 * 证件号码（开发者类型为个人必传）
	 */
	public $idcard;
	
	public function __construct($apiKey, $userType, $company, $industry, $businessLicence,
			$businessLicenceImg, $realName, $idcard) {
		$this->apiKey = $apiKey;
		$this->userType = $userType;
		$this->company = $company;
		$this->industry = $industry;
		$this->businessLicence = $businessLicence;
		$this->businessLicenceImg = $businessLicenceImg;
		$this->realName = $realName;
		$this->idcard = $idcard;
	}
}
?>
