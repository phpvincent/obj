<?php
include_once '/sdk/model/ReturnModel.php';
include_once '/sdk/model/SignatureReturn.php';
include_once '/sdk/api/URLConfig.php';
include_once '/sdk/client/HttpPostClient.php';
/**
 * 签名报备接口Api
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
class SignatureApi {
	/**
	 * 获取签名报备查询
	 * @param apiKey  用户唯一标识
	 * @param signName 签名
	 * @return
	 */
	public  static function SignatureSearch($apiKey,$signName ){
		$parmstr=array(
				"apiKey"=>$apiKey,
				"signName"=>$signName
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new SignatureReturn($client->sendPost($url->SignatureSearchURL,$parmstr));
		return $bean;
	}
	/**
	 * 添加/修改签名报备
	 * @param apiKey 用户唯一标识
	 * @param selectApiKey 账号（若该账号已存在，保存后会修改该账号对应的数据，并不会新增数据）
	 * @param signName 签名
	 * @return
	 */
	public  static function SignatureSave($apiKey,$selectApiKey,$signName ){
		$parmstr=array(
				"apiKey"=>$apiKey,
				"selectApiKey"=>$selectApiKey,
				"signName"=>$signName
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new ReturnModel($client->sendPost($url->SignatureSaveURL,$parmstr));
		return $bean;
	}
	/**
	 * 删除签名报备
	 * @param apiKey 用户唯一标识
	 * @param selectApiKey 账号（若该账号已存在，保存后会修改该账号对应的数据，并不会新增数据）
	 * @return
	 */
	public  static function SignatureDel($apiKey,$selectApiKey){
		$parmstr=array(
				"apiKey"=>$apiKey,
				"selectApiKey"=>$selectApiKey
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new ReturnModel($client->sendPost($url->SignatureDelURL,$parmstr));
		return $bean;
	}
}
?>
