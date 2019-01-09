<?php 

/**
 * APIKey--Api
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
include_once '/sdk/model/ReturnModel.php';
include_once '/sdk/model/ApiKeyReturn.php';
include_once '/sdk/api/URLConfig.php';
include_once '/sdk/client/HttpPostClient.php';
class ApiKeysApi {
	/**
	 * 获取APIKey
	 * @param apiKey
	 * @param searchApiKey
	 * @return
	 */
	public static function ApiKeysSearch($apiKey,$searchApiKey){
		$parmstr=array(
				"apiKey"=>$apiKey,
				"searchApiKey"=>$searchApiKey
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new ApiKeyReturn($client->sendPost($url->APIKeySearchURL,$parmstr));
		return $bean;
	}
	/**
	 * 添加APIKey
	 * @param apiKey 用户唯一标识
	 * @return
	 */
	public static function ApiKeysAdd($apiKey){
		$parmstr=array(
				"apiKey"=>$apiKey
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new ReturnModel($client->sendPost($url->APIKeyAddURL,$parmstr));
		return $bean;
	}
	/**
	 * 修改APIKey
	 * @param apiKey 用户唯一标识
	 * @param userAccountId apiKey唯一标识
	 * @param drUrl DR路径
	 * @return
	 */
	public static function ApiKeysSaveDr($apiKey,$userAccountId,$drUrl){
		$parmstr=array(
				"apiKey"=>$apiKey,
				"userAccountId"=>$userAccountId,
				"drUrl"=>$drUrl
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new ReturnModel($client->sendPost($url->APIKeyUpdateURL,$parmstr));
		return $bean;
	}
	/**
	 * 删除 APIKey
	 * @param apiKey 用户唯一标识
	 * @param userAccountId apiKey唯一标识
	 * @return
	 */
	public static function ApiKeysDel($apiKey,$userAccountId){
		$parmstr=array(
				"apiKey"=>$apiKey,
				"userAccountId"=>$userAccountId
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new ReturnModel($client->sendPost($url->APIKeyDelURL,$parmstr));
		return $bean;
	}
	
}
?>
