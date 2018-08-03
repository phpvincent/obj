<?php
namespace App\channel;
use App\goods;
use App\cuxiao;
use App\special;
class cuxiaoSDK{
	public $goods;
	public $cuxiao;
	public $cuxiaos;
	public function __construct(goods $goods){
       $this->goods=$goods;
       $this->cuxiao=cuxiao::where('cuxiao_goods_id',$goods->goods_id)->first();
       $this->cuxiaos=cuxiao::where('cuxiao_goods_id',$goods->goods_id)->get();
	}
	public function getdiv(){
		    $type=$this->goods->goods_cuxiao_type;
		    $goods=$this->goods;
		    $cuxiao=$this->cuxiao;
		    $cuxiaos=$this->cuxiaos;
		    $special=special::where('special_goods_id',$goods->goods_id)->get();
		    switch ($type) {
		    	case '0':
		    		return view('ajax.ajaxreturn')->with(compact('goods','cuxiao'));
		    		break;
		    	case '3':
		    	    return view('ajax.ajaxreturn3')->with(compact('goods','cuxiaos','special'));
		    	    break;
		    	default:
		    		# code...
		    		break;
		    }
        	return view('ajax.ajaxreturn')->with(compact('goods','cuxiao'));
	}
	public function get_price($num){
		$type=$this->goods->goods_cuxiao_type;
		$goods=$this->goods;
           switch ($type) {
           	case '0':
           		$price=$num*$goods->real_price;
           		return $price;
           		break;
           	case '3':
           	     $cuxiao=cuxiao::where('cuxiao_goods_id',$goods->goods_id)->get();
           	     foreach($cuxiao as $v){
                     $msg=explode(',', $v->cuxiao_config);
                     if($num==$msg[0]){
                     	return $msg[1];
                     }
           	     }
           	     return false;
           	     break;
           	default:
           		return false;
           		break;
           }
	}

	public function get_uphtml(){
		$goods=$this->goods;
		switch ($goods->goods_cuxiao_type) {
			case '0':
				$html='<div class="row cl">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>分类栏目：</label>
				<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
					<select name="articlecolumn" class="select">
						<option value="0">全部栏目</option>
						<option value="1">新闻资讯</option>
						<option value="11">├行业动态</option>
						<option value="12">├行业资讯</option>
						<option value="13">├行业新闻</option>
					</select>
					</span> </div>
			</div>';
			return $html;
				break;
			case '1':
				$html='<div class="row cl">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>分类栏目：</label>
				<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
					<select name="articlecolumn" class="select">
						<option value="0">全部栏目</option>
						<option value="1">新闻资讯</option>
						<option value="11">├行业动态</option>
						<option value="12">├行业资讯</option>
						<option value="13">├行业新闻</option>
					</select>
					</span> </div>
			</div>';
			return $html;
			default:
				# code...
				break;
		}
	}
	public static function getcuxiaohtml($id){
		switch ($id) {
			case '0':
				$html='';
				return $html;
				break;
			case '1':
				$html='';
				return $html;
				break;
			case '2':
				$html='';
				return $html;
				break;
			case '3':
				$html='';
				return $html;
				break;
			
			default:
				# code...
				break;
		}
	}

}