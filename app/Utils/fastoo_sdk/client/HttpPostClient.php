<?php
/**
 * post客户端
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
 class HttpPostClient {
	/**
	 * 向指定 URL 发送POST方法的请求
	 *
	 * @param url 发送请求的 URL
	 * @param param 请求参数，请求参数应该是 name1=value1&name2=value2 的形式。
	 * @return 所代表远程资源的响应结果
	 */
 	
	public static function SendPost($url,$param) {
		$postdata = http_build_query($param);  
		$options = array( 
				'http' => array(  
						'method' => 'POST',
						'header' => 'Content-type:application/x-www-form-urlencoded',
						'content' => $postdata,
						'timeout' => 15 * 60 // 超时时间（单位:s）     
						)   
				
		);
		$context = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
// 		$str="'"+$result+"'";
		return $result;
	} 
}
?>