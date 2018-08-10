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
<div class="addcart-specs-title unfold"><span class="addcart-specs-title-name">第1件</span><span class="addcart-specs-arrow"></span><span class="addcart-specs-descript">（NT$<span id="realprice">{{$goods->goods_price}}</span>，已選【{{$cuxiao->cuxiao_msg}}】僅剩{{$goods->goods_num}}件）</span><span class="addcart-specs-status"></span></div>
<div class="addcart-quantity"><div class="addcart-quantity-content"><label class="addcart-quantity-title">数量:</label><span id="addcart-quantity-dec"> - </span><input type="text" name="specNumber" id="addcart-quantity-val" value="1" readonly=""><span id="addcart-quantity-inc"> + </span></div></div>
<div class="addcart-footer"><div class="addcart-footer-price"><span class="addcart-footer-number-total">总数量:<font>1</font>，含贈 <font>0</font>件</span><span class="addcart-footer-price-total">合計:<font>NT${{$goods->goods_price}}</font></span></div></div>
<script type="text/javascript">
	    var pricehtml=$('.addcart-footer-price-total').children('font:first');
		var price=pricehtml.html().replace(/[^0-9]/ig,"");
		var config_arr="{{$cuxiao->cuxiao_config}}".split(',');
		/*for (var i = config_arr.length/2; i > 0; i--) {
			 config_arr[i] = new Array();
			config_arr[i][0]=config_arr.splice(i*1, 1);
			config_arr[i][1]=config_arr.splice(i*2, 1);
		}*/
	$('#addcart-quantity-dec').bind('click',function(){
		var num=parseInt($(this).next().val());
		if(num<=1){
			return false;
		}
		$(this).next().val(num-1);
		$('.addcart-specs-title-name').html("第"+(num-1)+"件");
		$('.addcart-footer-number-total').children('font:first').html(num-1);
		$('.addcart-footer-number-total').children('font:first').html(num-1);
		num=num-1;
		var price=parseInt({{$goods->goods_price}});
		var end_price=price*num;
		if(num<config_arr[0]){
			var end_price=price*num;
			$('#realprice').html(end_price);
			pricehtml.html("NT$"+end_price+".00");
		}else{
			var jp=price*(parseInt(config_arr[0])-1);
			var jjp=0;
			var len=config_arr.length;
			for(var i = 0; i < config_arr.length/2; i++){
					/*if((i*2+2)<=(config_arr.length-1)&&num>parseInt(config_arr[i*2])&&num<=parseInt(config_arr[i*2+2])){console.log(num>parseInt(config_arr[i*2])&&num<=parseInt(config_arr[i*2+2]))
						jjp+=(parseInt(config_arr[i*2+2])-parseInt(config_arr[i*2]))*parseInt(config_arr[i*2+1]);
					}else if((i*2+2)>(config_arr.length-1)){
						jjp+=(price-parseInt(config_arr[i*2+1]))*(num-parseInt(config_arr[i*2])+1);console.log(jp+';'+parseInt(config_arr[i*2]))
					}*/
					if(num>=parseInt(config_arr[i*2])){
						if(num<parseInt(config_arr[i*2+2])){
							jjp+=(num-(parseInt(config_arr[i*2])-1))*(price-(parseInt(config_arr[i*2+1])));
							break;
						}else if(num>=parseInt(config_arr[i*2+2])){
							jjp+=(parseInt(config_arr[i*2+2])-parseInt(config_arr[i*2]))*(price-parseInt(config_arr[i*2+1]));
						}else{
							jjp+=(num-parseInt(config_arr[i*2])+1)*(price-parseInt(config_arr[i*2+1]));
						}
					}
				}
			/*	if(num>=parseInt(config_arr[i*2])){
					end_price=price*(parseInt(config_arr[i*2])-1)+(price-parseInt(config_arr[i*2+1]))*(num-parseInt(config_arr[0])+1);
				}*/
			 end_price=jp+jjp;console.log(end_price);
			$('#realprice').html(end_price);
			pricehtml.html("NT$"+end_price+".00");
		}
			
		/*if(num-1<=1){
			num=num-1;
			$('#realprice').html(price);
			pricehtml.html("NT$"+price+".00");
		}else{
			num=num-1;
			for (var i = 0; i <= config_arr.length; i--) {
				
			}
			$('#realprice').html(price+(price*(num-1)/2));
			pricehtml.html("NT$"+((num-1)*price/2+price)+".00");
		}*/
	})
	$('#addcart-quantity-inc').bind('click',function(){
		var num=parseInt($(this).prev().val());
		if(num>={{$goods->goods_num}}){
			layer.msg('库存不足！');
			return false;
		}
		$(this).prev().val(num+1);
		$('.addcart-specs-title-name').html("第"+(num+1)+"件");
		$('.addcart-footer-number-total').children('font:first').html(num+1);
	    $('.addcart-footer-number-total').children('font:first').html(num+1);
	    num=num+1;
	var price=parseInt({{$goods->goods_price}});
		var end_price=price*num;
		if(num<config_arr[0]){
			var end_price=price*num;
			$('#realprice').html(end_price);
			pricehtml.html("NT$"+end_price+".00");
		}else{
			var jp=price*(parseInt(config_arr[0])-1);
			var jjp=0;
			var len=config_arr.length;
			for(var i = 0; i < config_arr.length/2; i++){
					/*if((i*2+2)<=(config_arr.length-1)&&num>parseInt(config_arr[i*2])&&num<=parseInt(config_arr[i*2+2])){console.log(num>parseInt(config_arr[i*2])&&num<=parseInt(config_arr[i*2+2]))
						jjp+=(parseInt(config_arr[i*2+2])-parseInt(config_arr[i*2]))*parseInt(config_arr[i*2+1]);
					}else if((i*2+2)>(config_arr.length-1)){
						jjp+=(price-parseInt(config_arr[i*2+1]))*(num-parseInt(config_arr[i*2])+1);console.log(jp+';'+parseInt(config_arr[i*2]))
					}*/
					if(num>=parseInt(config_arr[i*2])){
						if(num<parseInt(config_arr[i*2+2])){
							jjp+=(num-(parseInt(config_arr[i*2])-1))*(price-(parseInt(config_arr[i*2+1])));
							break;
						}else if(num>=parseInt(config_arr[i*2+2])){
							jjp+=(parseInt(config_arr[i*2+2])-parseInt(config_arr[i*2]))*(price-parseInt(config_arr[i*2+1]));
						}else{
							jjp+=(num-parseInt(config_arr[i*2])+1)*(price-parseInt(config_arr[i*2+1]));
						}
					}
				}
			/*	if(num>=parseInt(config_arr[i*2])){
					end_price=price*(parseInt(config_arr[i*2])-1)+(price-parseInt(config_arr[i*2+1]))*(num-parseInt(config_arr[0])+1);
				}*/
				
			 end_price=jp+jjp;console.log(end_price);
			$('#realprice').html(end_price);
			pricehtml.html("NT$"+end_price+".00");
		}
			
		
	  /*  if(num+1<=1){
	    	num=num+1;
			$('#realprice').html(price);
			pricehtml.html("NT$"+price);
		}else{
			num=num+1;
			$('#realprice').html(price+(price*(num-1)/2));
			pricehtml.html("NT$"+((num-1)*price/2+price)+".00");
		}*/
	})

   
        
</script>
