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
		@foreach($cuxiao as $key)
		
					<div>
					促销名:<input type="text" style="width: 10%;" class="input-text" value="{{$key->cuxiao_msg}}" placeholder="" id="cuxiao_msg" name="cuxiao_msg[{{$key->cuxiao_id}}]">
					件数:<input type="text" style="width: 10%;" class="input-text" value="{{explode(',',$key->cuxiao_config)[0]}}" placeholder="" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,'');}).call(this)" onblur="this.v();" id="cuxiao_num" name="cuxiao_num[{{$key->cuxiao_id}}]">
					价格:<input type="text" style="width: 10%;" class="input-text" value="{{explode(',',$key->cuxiao_config)[1]}}" placeholder="" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d*\.?\d{0,2})?.*$/,'$1');}).call(this)" onblur="this.v();" id="cuxiao_prize" name="cuxiao_prize[{{$key->cuxiao_id}}]">
					赠品:<select name="cuxiao_special[{{$key->cuxiao_id}}]" class="select slectchange"  style="width:30%;">
							<option value="0" >无</option>
								@foreach(\App\price::get() as $v)
							<option value="{{$v->price_id}}"';@if($v->price_id==$key->special_price_id) selected="selected" style="float:right;" @endif  >{{$v->price_name}}</option>
								@endforeach
						</select>
						<span class="deletes"><i class="Hui-iconfont"></i></span>
					</div>
		
		@endforeach
		@else
		<div>促销名:<input type="text" style="width: 10%;" class="input-text" value="" placeholder="" id="cuxiao_msg" name="new_cuxiao[0][msg]">件数:<input type="text" style="width: 10%;" class="input-text" value="" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,'');}).call(this)" onblur="this.v();" placeholder="" id="cuxiao_num" name="new_cuxiao[0][num]">价格:<input type="text" style="width: 10%;" class="input-text" value="" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d*\.?\d{0,2})?.*$/,'$1');}).call(this)" onblur="this.v();" placeholder="" id="goods_end2" name="new_cuxiao[0][price]">	赠品:<select name="new_cuxiao[][free]" class="select slectchange" style="width:30%;" ><option value="0" >无</option>@foreach(\App\price::get() as $v)<option value="{{$v->price_id}}">{{$v->price_name}}</option> @endforeach </select><span class="deletes"><i class="Hui-iconfont"></i></span></div>
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
					var html='<div>促销名:<input type="text" style="width: 10%;" class="input-text" value="" placeholder="" id="cuxiao_msg" name="new_cuxiao['+index+'][msg]">件数:<input type="text" style="width: 10%;" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,\'\');}).call(this)" onblur="this.v();" class="input-text" value="" placeholder="" id="cuxiao_num" name="new_cuxiao['+index+'][num]">价格:<input type="text" style="width: 10%;" onkeyup="(this.v=function(){this.value=this.value.replace(/^\\D*([0-9]\\d*\\.?\\d{0,2})?.*$/,\'$1\');}).call(this)" onblur="this.v();" class="input-text" value="" placeholder="" id="goods_end2" name="new_cuxiao['+index+'][price]">	赠品:<select name="new_cuxiao['+index+'][free]" class="select slectchange" style="width:30%;" ><option value="0" >无</option>@foreach(\App\price::get() as $v)<option value="{{$v->price_id}}">{{$v->price_name}}</option> @endforeach </select><span class="deletes"><i class="Hui-iconfont"></i></span></div>';
					$("#pzhtml").append(html);
					index+=1;
					})
	$('body').on("click",".deletes",function(){
		$(this).parent().remove();
	})
</script>
