<?php
include_once '/sdk/client/HttpPostClient.php';
include_once '/sdk/model/QuotedPriceReturn.php';
include_once '/sdk/api/URLConfig.php';

/**
 * 获取短信/语音价格
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
class GetQuotedPriceAPI {
	/**
	 * 获取短信/语音价格
	 * @param country 国家唯一标识
	 * @return
	 */
	public static function GetQuotedPrice($country){
		$parmstr=array(
				"country"=>$country
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new QuotedPriceReturn($client->sendPost($url->GetQuotedPriceApiURL,$parmstr));
		return $bean;
	}
}
?>