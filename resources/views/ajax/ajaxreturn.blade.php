<div class="addcart-specs-title unfold"><span class="addcart-specs-title-name">第1件</span><span class="addcart-specs-arrow"></span><span class="addcart-specs-descript">（{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}<span id="realprice">{{$goods->goods_price}}</span>僅剩{{$goods->goods_num}}件）</span><span class="addcart-specs-status"></span></div>
<div class="addcart-quantity"><div class="addcart-quantity-content"><label class="addcart-quantity-title">数量:</label><span id="addcart-quantity-dec"> - </span><input type="text" name="specNumber" id="addcart-quantity-val" value="1" readonly=""><span id="addcart-quantity-inc"> + </span></div></div>
<div class="addcart-footer"><div class="addcart-footer-price"><span class="addcart-footer-number-total">总数量:<font>1</font>，含贈 <font>0</font>件</span><span class="addcart-footer-price-total">合計:<font>{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}{{$goods->goods_price}}</font></span></div></div>
<script type="text/javascript">
	    var pricehtml=$('.addcart-footer-price-total').children('font:first');
		var price=pricehtml.html().replace(/[^0-9]/ig,"")/100;
	$('#addcart-quantity-dec').bind('click',function(){
		removeform(); // 删除一组商品属性
		var num=parseInt($(this).next().val());
		if(num<=1){
			return false;
		}
		$(this).next().val(num-1);
		$('.addcart-specs-title-name').html("第"+(num-1)+"件");
		$('.addcart-footer-number-total').children('font:first').html(num-1);
		$('#realprice').html((num-1)*price+".00");
		pricehtml.html("{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}"+(num-1)*price+'.00');
	})
	$('#addcart-quantity-inc').bind('click',function(){
		formnum+=1
		var formName="f"+formnum;
		addform(formName); //增加一组商品属性；
		var num=parseInt($(this).prev().val());
		if(num>={{$goods->goods_num}}){
			layer.msg('库存不足！');
			return false;
		}
		$(this).prev().val(num+1);
		$('.addcart-specs-title-name').html("第"+(num+1)+"件");
	    $('.addcart-footer-number-total').children('font:first').html(num+1);
	    $('#realprice').html((num+1)*price+".00");
		pricehtml.html("{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}"+(num+1)*price+'.00');
	})

   
        
</script>
