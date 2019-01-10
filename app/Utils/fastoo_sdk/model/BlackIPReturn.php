<?php 
/**
 * 黑名单返回类
 * @author lb
 * @version 1.0
 * @date 2017-08-31
 */
include_once '/sdk/model/ReturnModel.php';
include_once '/sdk/model/BlackIPBean.php';
class BlackIPReturn  extends ReturnModel{
	/**
	 * 返回白名单对象
	 */
	public $userIplists;
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
			$arr=$this->obj->data->blackList;
			$this->userIplists=array();
			for($i=0;$i<sizeof($arr);$i++){
				$bean=new BlackIPBean();
				$bean->createTime=$arr[$i]->createTime;
				$bean->id=$arr[$i]->id;
				$bean->phone=$arr[$i]->phone;
				$bean->userName=$arr[$i]->userName;
				array_push($this->userIplists,$bean);
			}
		}
	}
}
?>

