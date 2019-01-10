<?php
include_once '/sdk/api/URLConfig.php';
include_once '/sdk/client/HttpPostClient.php';
include_once '/sdk/model/UserGetReturn.php';
include_once '/sdk/model/UserAccountsReturn.php';
include_once '/sdk/model/UserBalanceReturn.php';
include_once '/sdk/model/UserInfoReturn.php';
include_once '/sdk/model/UserInfoParm.php';


/**
 * 获取账号Api
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
class UserManageApi {
	/**
	 * 用户-获取用户信息Api
	 * @param apiKey
	 * @return UserAccountsReturn 返回账号
	 */
	public static function GetUser($loginName,$password){
		$parmstr=array(
				"loginName"=>$loginName,
				"password"=>$password
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new UserGetReturn($client->sendPost($url->GetUserApiURL,$parmstr));
		return $bean;
	}
	/**
	 * 调用获取账号Api
	 * @param apiKey
	 * @return UserAccountsReturn 返回账号
	 */
	public static function GetUserAccounts($apiKey){
		$parmstr=array(
				"apiKey"=>$apiKey
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new UserAccountsReturn($client->sendPost($url->GetUserAccountsApiURL,$parmstr));
		return $bean;
	}
	/**
	 *  查询余额Api
	 * @param apiKey
	 * @return UserBalanceReturn 返回账号
	 */
	public static function GetUserBalance($apiKey){
		$parmstr=array(
				"apiKey"=>$apiKey
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new UserBalanceReturn($client->sendPost($url->GetUserBalanceApiURL,$parmstr));
		return $bean;
	}
	/**
	 * 设置账号信息
	 * @param parm
	 * @return
	 */
	public static function UpdateUserInfo($parm){
		$parmstr=array(
				"apiKey"=>$parm->apiKey,
				"userType"=>$parm->userType,
				"company"=>$parm->company,
				"industry"=>$parm->industry,
				"businessLicence"=>$parm->businessLicence,
				"businessLicenceImg"=>$parm->businessLicenceImg,
				"realName"=>$parm->realName,
				"idcard"=>$parm->idcard,
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new ReturnModel($client->sendPost($url->UpdateInfoApiURL,$parmstr));
		return $bean;
	}
	/**
	 * 修改密码
	 * @param apiKey 用户唯一标识
	 * @param oldpwd 原密码
	 * @param newpwd 新密码
	 * @return
	 */
	public static function ChangePWD($apiKey,$oldpwd,$newpwd){
		$parmstr=array(
				"apiKey"=>$apiKey,
				"oldpwd"=>$oldpwd,
				"newpwd"=>$newpwd
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new ReturnModel($client->sendPost($url->ChangePWDApiURL,$parmstr));
		return $bean;
	}
}
?>
