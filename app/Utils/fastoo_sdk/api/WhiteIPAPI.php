<?php 
include_once '/sdk/model/ReturnModel.php';
include_once '/sdk/model/WhiteIPReturn.php';
include_once '/sdk/api/URLConfig.php';
include_once '/sdk/client/HttpPostClient.php';

/**
 * 白名单
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
class WhiteIPAPI {
	/**
	 * 获取IP白名单
	 * @param apiKey
	 * @param ip
	 * @return
	 */
	public static function WhiteIPSearch($apiKey,$ip){
		$parmstr=array(
				"apiKey"=>$apiKey,
				"ip"=>$ip
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new WhiteIPReturn($client->sendPost($url->WhiteIPSearchApiURL,$parmstr));
		return $bean;
	}
	/**
	 * 添加/修改IP白名单
	 * @param apiKey 用户唯一标识
	 * @param ip ip地址（若该ip已存在，保存后会修改该ip对应的数据，并不会新增数据）
	 * @param remark 备注
	 * @return
	 */
	public  static function WhiteIPSave($apiKey,$ip,$remark){
		$parmstr=array(
				"apiKey"=>$apiKey,
				"ip"=>$ip,
				"remark"=>$remark
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new ReturnModel($client->sendPost($url->WhiteIPSaveApiURL,$parmstr));
		return $bean;
	}
	/**
	 *  删除IP白名单
	 * @param apiKey 用户唯一标识
	 * @param delid 白名单唯一标识
	 * @return
	 */
	public  static function WhiteIPDel($apiKey,$delid){
		$parmstr=array(
				"apiKey"=>$apiKey,
				"delid"=>$delid
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new ReturnModel($client->sendPost($url->WhiteIPDelApiURL,$parmstr));
		return $bean;
	}
	/**
	 * 设置IP白名单保护
	 * @param apiKey 用户唯一标识
	 * @param on 关闭/开启白名单保护(0:关闭，1:开启)
	 * @return
	 */
	public  static function WhiteIPSwitch($apiKey,$on){
		$parmstr=array(
				"apiKey"=>$apiKey,
				"on"=>$on
		);
		$url=new URLConfig();
		$client=new HttpPostClient();
		$bean=new ReturnModel($client->sendPost($url->WhiteIPSwitchApiURL,$parmstr));
		return $bean;
	}
}
?>
