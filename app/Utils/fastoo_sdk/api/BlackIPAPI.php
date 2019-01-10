<?php 
include_once '/sdk/model/ReturnModel.php';
include_once '/sdk/model/BlackIPReturn.php';
include_once '/sdk/api/URLConfig.php';
include_once '/sdk/client/HttpPostClient.php';
/**
 * 黑名单
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
class BlackIPAPI {
	/**
	 * 获取IP黑名单
	 * @param apiKey 用户唯一标识
	 * @param keyword 用户名或手机号码
	 * @return
	 */
	public static function BlackIPSearch($apiKey,$keyword){
		$parmstr=array(
				"apiKey"=>$apiKey,
				"keyword"=>$keyword
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new BlackIPReturn($client->sendPost($url->BlackIPSearchApiURL,$parmstr));
		return $bean;
	}
	/**
	 * 添加/修改IP黑名单
	 * @param apiKey 用户唯一标识
	 * @param phone 手机号码
	 * @param userName 用户名
	 * @param blacklistId 黑名单唯一标识（若值为空，为添加操作，否则就是修改操作）
	 * @return
	 */
	public static function BlackIPSave($apiKey,$phone,$userName,$blacklistId){
		$parmstr=array(
				"apiKey"=>$apiKey,
				"phone"=>$phone,
				"userName"=>$userName,
				"blacklistId"=>$blacklistId
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new ReturnModel($client->sendPost($url->BlackIPSaveApiURL,$parmstr));
		return $bean;
	}
	/**
	 *  删除IP黑名单
	 * @param apiKey 用户唯一标识
	 * @param blacklistId 黑名单唯一标识
	 * @return
	 */
	public static function BlackIPDel($apiKey,$blacklistId){
		$parmstr=array(
				"apiKey"=>$apiKey,
				"blacklistId"=>$blacklistId
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new ReturnModel($client->sendPost($url->BlackIPDelApiURL,$parmstr));
		return $bean;
	}
}
?>

