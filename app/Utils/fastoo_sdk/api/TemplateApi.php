<?php 
include_once '/sdk/model/ReturnModel.php';
include_once '/sdk/model/TemplateReturn.php';
include_once '/sdk/api/URLConfig.php';
include_once '/sdk/client/HttpPostClient.php';
/**
 * 模板报备接口Api
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
class TemplateApi {
	/**
	 * 获取模板报备
	 * @param apiKey 用户唯一标识
	 * @param searchApiKey 账号
	 * @param keyword 模板内容
	 * @param pageNo 第几页（0表示第一页，以此类推）
	 * @return
	 */
	public  static function TemplateSearch($apiKey,$searchApiKey,$keyword,$pageNo ){
		$parmstr=array(
				"apiKey"=>$apiKey,
				"searchApiKey"=>$searchApiKey,
				"keyword"=>$keyword,
				"pageNo"=>$pageNo
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new TemplateReturn($client->sendPost($url->TemplateSearchURL,$parmstr));
		return $bean;
	}
	/**
	 * 添加/修改模板报备
	 * @param apiKey 用户唯一标识
	 * @param templateType 模板类型（1:验证码类，2:通知类，3:营销类）
	 * @param templateContent 模板内容
	 * @param selectApiKey 账号
	 * @param templateId 模板唯一标识（若值为空，为添加操作，否则就是修改操作）
	 * @param appUrl app地址（若模板类型为验证码类，值不能为空）
	 * @return
	 */
	public  static function TemplateSave($apiKey,$templateType,$templateContent,$selectApiKey,
			$templateId,$appUrl){
		$parmstr=array(
				"apiKey"=>$apiKey,
				"templateType"=>$templateType,
				"templateContent"=>$templateContent,
				"selectApiKey"=>$selectApiKey,
				"templateId"=>$templateId,
				"appUrl"=>$appUrl
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new ReturnModel($client->sendPost($url->TemplateSaveURL,$parmstr));
		return $bean;
	}
	/**
	 * 删除模板报备
	 * @param apiKey 用户唯一标识
	 * @param templateId 模板唯一标识
	 * @return
	 */
	public  static function TemplateDel($apiKey,$templateId){
		$parmstr=array(
				"apiKey"=>$apiKey,
				"templateId"=>$templateId
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new ReturnModel($client->sendPost($url->TemplateDelURL,$parmstr));
		return $bean;
	}
}
