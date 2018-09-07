<style type="text/css">
	.chose_cart{
		background-color: red;
		color: white !important;
		border:1px dashed #ccc !important;
	}
	.unchose_cart{
		background-color: white;
		color: black !important;
		border:1px dashed #ccc !important;
	}
</style>
@foreach($special as $v)
	<div class="addcart-specs image-list"  mine_id='{{$v->special_id}}' style="display: none;" data-id="416515236" data-number="5" data-price="0" data-rule="6" data-gift="1" data-option="416515236#1"><div class="addcart-specs-title" >	<img style="width: 20%;height: 50%;" class="addcart-specs-title-image" src="{{ App\price::where('price_id',$v->special_price_id)->first()->price_img}}"><span class="addcart-specs-title-name">{{ App\price::where('price_id',$v->special_price_id)->first()->price_name}}</span><span class="addcart-specs-title-number">×{{$v->special_price_num}}</span><span class="addcart-specs-title-gift">贈品</span></div>
    </div>
@endforeach
<div class="addcart-specs-title unfold"><span class="addcart-specs-title-name">第1件</span><span class="addcart-specs-arrow"></span><span class="addcart-specs-descript">（NT$<span id="realprice">998</span>，已選 【<span id="sell_msg">{{$cuxiaos->first()->cuxiao_msg}}</span>】 僅剩{{$goods->goods_num}}件）</span><span class="addcart-specs-status"></span></div>
@foreach($cuxiaos as $k=> $v)
<div class="addcart-group-buttons"  style="display: block;" ><div class="addcart-float-buttons-block"  data-id="7022">
	<button cuxiao_id='{{$v->cuxiao_id}}' @if($k==0) class='chose_cart'@else class='unchose_cart' @endif type="button" num='{{explode(",",$v->cuxiao_config)[0]}}' price='{{explode(",",$v->cuxiao_config)[1]}}' type_name='{{$v->cuxiao_msg}}' cuxiao_special_id='{{$v->cuxiao_special_id}}' >{{$v->cuxiao_msg}}</button>
</div></div>
@endforeach
<div class="addcart-quantity"><div class="addcart-quantity-content"><label class="addcart-quantity-title">数量:</label><span id="addcart-quantity-dec"> - </span><input type="text" name="specNumber" id="addcart-quantity-val" value="{{explode(',',$cuxiaos->first()->cuxiao_config)[0]}}" readonly=""><span id="addcart-quantity-inc"> + </span></div></div>
<div class="addcart-footer"><div class="addcart-footer-price"><span class="addcart-footer-number-total">总数量:<font>{{explode(',',$cuxiaos->first()->cuxiao_config)[0]}}</font>，含贈 <font>0</font>件</span><span class="addcart-footer-price-total">合計:<font>NT${{explode(',',$cuxiaos->first()->cuxiao_config)[1]}}</font></span></div></div>
<script type="text/javascript">
        formnum+=1
		var formName="f"+formnum;
		addform(formName);
		//如果是这个页面默认是两组商品属性；上面代码多加一组属性；
	    var pricehtml=$('.addcart-footer-price-total').children('font:first');
		var price=pricehtml.html().replace(/[^0-9]/ig,"");
	$('#addcart-quantity-dec').bind('click',function(){
		layer.msg('此商品僅支持套餐購買');
		return false;
		var num=parseInt($(this).next().val());
		if(num<=1){
			return false;
		}
		$(this).next().val(num-1);
		$('.addcart-specs-title-name').html("第"+(num-1)+"件");
		$('.addcart-footer-number-total').children('font:first').html(num-1);
		$('#realprice').html((num-1)*price);
		pricehtml.html("NT$"+(num-1)*price);
	})
	$('#addcart-quantity-inc').bind('click',function(){

		layer.msg('此商品僅支持套餐購買');
		return false;
		var num=parseInt($(this).prev().val());
		if(num>={{$goods->goods_num}}){
			layer.msg('库存不足！');
			return false;
		}
		$(this).prev().val(num+1);
		$('.addcart-specs-title-name').html("第"+(num+1)+"件");
	    $('.addcart-footer-number-total').children('font:first').html(num+1);
	    $('#realprice').html((num+1)*price);
		pricehtml.html("NT$"+(num+1)*price);
	})
    $('.addcart-float-buttons-block').children('button').click(function(){    	
    	$('form').children('[name="cuxiao_id"]').val($(this).attr('cuxiao_id'));
    	var attr=$(this).attr('class');
    	var cuxiao_special_id=$(this).attr('cuxiao_special_id');
        $("[mine_id]").hide();
    	if(cuxiao_special_id>0){
    		$("[mine_id='"+cuxiao_special_id+"']").show();
    	}
    	if(attr=='chose_cart'){
    		layer.msg('已选择');
    	}else if(attr =='unchose_cart'){
    		$('.chose_cart').attr('class','unchose_cart');
    		$(this).attr('class','chose_cart');
            var num=$(this).attr('num');
            var price=$(this).attr('price');
            var cuxiao_msg=$(this).attr('type_name');
            $('#sell_msg').html(cuxiao_msg);
            $('#realprice').html(price);
            $('.addcart-footer-number-total').children('font:first').html(num);
            $('#addcart-quantity-val').val(num);
            pricehtml.html("NT$"+price);
			console.log(num);
			$("#goods_config_div").children("form").remove(); //如果选择套餐先删除说有属性，在根据有几件商品循环几组属性；
			formnum=0;
			for(var i=1;i<=num;i++){
				formnum+=1
		        var formName="f"+formnum;
		        addform(formName); //增加一组商品属性；
			}
    	}
    })
    $(function(){
    	$('form').children('[name="cuxiao_id"]').val({{$cuxiaos->first()->cuxiao_id}});
    })
   
        
</script>