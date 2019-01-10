<?php
/**
 * 模板返回类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
include_once '/sdk/model/ReturnModel.php';
include_once '/sdk/model/TemplateBean.php';
class TemplateReturn extends ReturnModel {
	/**
	 * 模板数据
	 */
	public $templatelist;
	/**
	 * 每页数据条数
	 */
	public $size;
	/**
	 * 总共有几页
	 */
	public $totalPages;
	/**
	 * 总共有几条
	 */
	public $totalElements;
	public function __construct($jsonstr){
		$this->jsonstr=$jsonstr;
		$this->obj=json_decode($jsonstr);
		$this->code=$this->obj->code;
		$this->msg=$this->obj->msg;
		if($this->code==0){
			//成功
			$this->totalElements=$this->obj->data->totalElements;
			$this->size=$this->obj->data->size;
			$this->totalPages=$this->obj->data->totalPages;
			$arr=$this->obj->data->userSmstemplates;
			$this->templatelist=array();
			for($i=0;$i<sizeof($arr);$i++){
				$bean=new TemplateBean();
				$bean->apiKey=$arr[$i]->apiKey;
				$bean->appUrl=$arr[$i]->appUrl;
				$bean->id=$arr[$i]->id;
				$bean->reason=$arr[$i]->reason;
				$bean->state=$arr[$i]->state;
				$bean->templateContent=$arr[$i]->templateContent;
				$bean->templateType=$arr[$i]->templateType;
				array_push($this->templatelist,$bean);
			}
		}
	}

}
?>