<?php 

include_once __DIR__.'/../model/ReturnModel.php';
include_once __DIR__.'/../model/SendBatchSmsParm.php';
include_once __DIR__.'/../model/SendSingleSmsParm.php';
include_once __DIR__.'/URLConfig.php';
include_once __DIR__.'/../client/HttpPostClient.php';
/**
 * 发送短信Api
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
class SendSmsApi {
	/**
	 * 单条发送短信
	 * @param parm 参数
	 * @return
	 */
	public  static function QuickSendSingleSms($parm){
		$parmstr=array(
				"apiKey"=>$parm->apiKey,
				"countryEn"=>$parm->countryEn,
				"mobile"=>$parm->mobile,
				"isDomestic"=>$parm->isDomestic,
				"smscontent"=>$parm->smscontent,
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new ReturnModel($client->sendPost($url->QuickSendSingleSmsApiURL,$parmstr));
		return $bean;
	}
	/**
	 * 发送短信
	 * @param parm 参数
	 * @return
	 */
	public  static function Submit($apiKey, $da,$msg){
		$parmstr=array(
				"apikey"=>$apiKey,
				"da"=>$da,
				"msg"=>$msg
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new ReturnModel($client->sendPost($url->SubmitApiURL,$parmstr));
		return $bean;
	}
	/**
	 * 平台批量发送短信
	 * @param parm 参数
	 * @return
	 */
	public  static function QuickSendBatchSms($parm){
		$parmstr=array(
				"apiKey"=>$parm->apiKey,
				"selectApiKey"=>$parm->selectApiKey,
				"batchName"=>$parm->batchName,
				"das"=>$parm->das,
				"msg"=>$parm->msg,
				"timing"=>$parm->timing
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new ReturnModel($client->sendPost($url->QuickSendBatchSmsApiURL,$parmstr));
		return $bean;
	}
	/**
	 * 发送记录状态设置
	 * @param apiKey 用户唯一标识
	 * @param id  发送记录唯一标识
	 * @param status 发送状态(-1:取消，0:暂停，1:启动，2:已发送)
	 * @return
	 */
	public  static function BatchStatus($apiKey,$id,$status){
		$parmstr=array(
				"apiKey"=>$apiKey,
				"id"=>$id,
				"status"=>$status
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new ReturnModel($client->sendPost($url->SmsBatchStatusApiURL,$parmstr));
		return $bean;
	}
}
?>
