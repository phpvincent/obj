<style>
	.deletes{
		font-size:18px;
		display: inline-block;
    	padding-left: 10px;
		cursor:pointer;
	}
</style>
	<div style="margin:0px auto;border: 1px dashed #000;border-radius: 3%; width: 73%;margin-left:18%; " id="pzhtml">
		<input type="button" class="btn btn-default" value="增加配置项" id="addpz" style="margin-left:18%;" />
		<label class="form-label col-xs-4 col-sm-2"> </label>
		@if($cuxiao!=null)
							<br/>促销名:<input type="text" style="width: 20%;" class="input-text"  value="{{$cuxiao->cuxiao_msg}}" placeholder="" id="cuxiao_msg" name="cuxiao_msg">
		@foreach($cuxiao->cuxiao_config as $val => $key)
		
					<div>
						购满件数:<input type="text" style="width: 10%;" class="input-text" value="{{$key['num']}}" placeholder="" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,'');}).call(this)" onblur="this.v();" id="cuxiao_num" name="cuxiao_num[{{$val}}]">
						减免价格:<input type="text" style="width: 10%;" class="input-text" value="{{$key['price']}}" placeholder="" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,'');}).call(this)" onblur="this.v();" id="cuxiao_prize" name="cuxiao_prize[{{$val}}]">
						<span class="deletes"><i class="Hui-iconfont"></i></span>
					</div>
				
		
		
		@endforeach
		@else
							<br/>促销名:<input type="text" style="width: 20%;" class="input-text"  value="" placeholder="" id="cuxiao_msg" name="cuxiao_msg">
							
							<div>
							购满件数:<input type="text" style="width: 10%;" class="input-text" value="" placeholder="" id="cuxiao_num" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,'');}).call(this)" onblur="this.v();" name="new_cuxiao[0][num]">
							减免价格:<input type="text" style="width: 10%;" class="input-text" value="" placeholder="" id="cuxiao_prize" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,'');}).call(this)" onblur="this.v();" name="new_cuxiao[0][price]">
							<span class="deletes"><i class="Hui-iconfont"></i></span>
							</div>
		@endif
	</div>


<script type="text/javascript">
	$('#addpz').on('click',function(){

	})
	$('.slectchange').on('change',function(){
					if($(this).val()!=0){
						$(this).next().removeAttr("disabled");
					}else if($(this).val()==0){
						$(this).next().attr('disabled','true');
					}
				})
	var index=1;
	$("#addpz").on("click",function(){
		var html='<div>购满件数:<input type="text" style="width: 10%;" class="input-text" value="" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,\'\');}).call(this)" onblur="this.v();" placeholder="" id="cuxiao_num" name="new_cuxiao['+index+'][num]">减免价格:<input type="text" style="width: 10%;" class="input-text" value="" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,\'\');}).call(this)" onblur="this.v();" placeholder="" id="goods_end2" name="new_cuxiao['+index+'][price]"><span class="deletes"><i class="Hui-iconfont"></i></span></div>';
		$("#pzhtml").append(html);
		index+=1;
	});
	$('body').on("click",".deletes",function(){
		$(this).parent().remove();
	})
</script>
