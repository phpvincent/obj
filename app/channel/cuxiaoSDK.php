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
	public static function getcuxiaohtml($id,$goods_id){
		$goods=\App\goods::where('goods_id',$goods_id)->first();
		$cuxiao=\App\cuxiao::where('cuxiao_goods_id',$goods_id)->get();
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
				foreach($cuxiao as $key){
					$html.='
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>套餐配置：</label>';
					$data=explode(',', $key->cuxiao_config);
				$html.='
				<div class="formControls col-xs-8 col-sm-9">
					件数:<input type="text" style="width: 10%;" class="input-text" value="'.$data[1].'" placeholder="" id="cuxiao_num" name="cuxiao_num">
					价格:<input type="text" style="width: 10%;" class="input-text" value="'.$data[0].'" placeholder="" id="goods_end2" name="goods_end2">';
					if($key->cuxiao_special_id){
						$special=\App\special::where('special_id',$key->cuxiao_special_id)->first();
						$price=\App\price::where('price_id',$special->special_price_id)->first();
						$html.='赠品:<select name="articlecolumn" class="select">';
						foreach(\App\price::get() as $v){
									$html.='<option value="0"';if($v->price_id==$special->special_price_id){ $html.='selected="selected" style="float:right;"';}$html.=' >'.$v->price_name.'</option>';
						}

						$html.='</select>';
					}
					
					$html.='
				</div>';
				}
				return $html;
				break;
			
			default:
				# code...
				break;
		}
	}

}