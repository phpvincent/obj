<?php 

include_once '/sdk/model/ReturnModel.php';
/**
 * 获取账号信息返回类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
class UserInfoReturn extends ReturnModel {
	/**
	 * 账户余额
	 */
	public $balance;
	/**
	 * /营业执照
	 */
	public $businessLicence;
	/**
	 * 营业执照照片名称
	 */
	public $businessLicenceImg;
	/**
	 * 公司名称
	 */
	public $company;
	/**
	 * 证件号码
	 */
	public $idcard;
	/**
	 * 所属行业
	 */
	public $industry;
	/**
	 * IP白名单保护(0:关闭，1:开启)
	 */
	public $ipEnable;
	/**
	 * 账号
	 */
	public $loginName;
	/**
	 * 真实姓名
	 */
	public $realName;
	/**
	 *开发者类型(1:公司，2:个人)
	 */
	public $userType;
	public function __construct($jsonstr){
		$this->jsonstr=$jsonstr;
		$this->obj=json_decode($jsonstr);
		$this->code=$this->obj->code;
		$this->msg=$this->obj->msg;
		if($this->code==0){
			//成功
			//成功
			$a=$this->obj->data->userInfo;
			$this->balance=$a->balance;
			$this->businessLicence=$a->businessLicence;
			$this->businessLicenceImg=$a->businessLicenceImg;
			$this->company=$a->company;
			$this->idcard=$a->idcard;
			$this->industry=$a->industry;
			$this->ipEnable=$a->ipEnable;
			$this->loginName=$a->loginName;
			$this->realName=$a->realName;
			$this->userType=$a->userType;
		}
	}
}
?>
