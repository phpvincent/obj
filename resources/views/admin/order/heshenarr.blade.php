@extends('admin.father.css')
@section('content')
<article class="page-container">
	
	<form class="form form-horizontal" id="order_type_change" action="{{url('admin/order/order_type_change')}}" method="post">
		@foreach($orders as $k => $v)
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">ID：{{$v->order_id}};订单号：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" value="{{$v->order_single_id}}" placeholder="" id="order_ids[]" name="order_ids[]" readonly="readonly" >
		</div>
	</div>
	@endforeach
	{{csrf_field()}}
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">状态选择：</label>
		<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
			<select class="select" name="order_type_now" size="1" id="order_type_select">
				<option value="0" >未核审</option>
				<option value="1" >通过核审</option>
				<option value="2" >拒绝核审</option>
				<option value="14" >问题订单</option>
			</select>
			</span> </div>
	</div>
	<div class="row cl" style="display: none;">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>快递单号(多个单号请用英文;隔开，保持顺序正确)：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<textarea name="order_send" cols="" rows="" id="order_send" class="textarea"  placeholder="请输入快递单号(多个单号请用英文;隔开，保持顺序正确)" dragonfly="true" >{{$send_nums}}</textarea>
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>核审信息记录：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<textarea name="order_return" cols="" rows="" id="order_return_textarea" class="textarea"  placeholder="请输入核审记录信息" dragonfly="true" ></textarea>
			<p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
		</div>
	</div>
	<div class="row cl">
		<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
			<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
		</div>
	</div>
	</form>
</article>
@endsection
@section('js')
<script type="text/javascript">
	$(function(){
			var order_type= $('#order_type_select').val();
			if(order_type>=3&&order_type!=14){
				$('#order_send').parent().parent().show();
			}
	})
		$('#order_type_select').bind('change',function(){
			var order_type= $(this).val();

			if(order_type>=3&&order_type!=14){
				$('#order_send').parent().parent().show();
			}else{
				$('#order_send').parent().parent().val('');
				$('#order_send').parent().parent().hide();
			}
		})
		$('#order_type_change').submit(function(){
			var order_type= $('#order_type_select').val();
			var order_send_val=$('#order_send').val();
			var is_send=!$("#order_send").is(":hidden");
			if(order_type>=3&&isNull(order_send_val)&&is_send){
				layer.msg("请填写快递单号！");
				return false;
			}
			if(order_type>=3&&is_send){
				if(order_send_val.length<8){
					layer.msg("订单编号长度不合法！");
					return false;
				}
			}
			if(isNull($('#order_return_textarea').val())){
				layer.msg("请填写核审记录");
				return false;
			}
			var indexs = layer.load(2, {shade: [0.15, '#393D49']})
			$('#order_type_change').ajaxSubmit({
				type: 'post',
				url: "{{url('admin/order/order_arr_change')}}",
				success: function(data){
					if(data.msg==0){
						layer.close(indexs);
						layer.msg('更改成功!',{time:2*1000},function() {
						//回调
							index = parent.layer.getFrameIndex(window.name);
							setTimeout("parent.layer.close(index);",100);
							parent.shuaxin();
							parent.fuxuan()
						});
					}else{
						layer.close(indexs);
                        layer.msg(data.str,{time:3*1000},function() {
                            //回调
                            index = parent.layer.getFrameIndex(window.name);
                            setTimeout("parent.layer.close(index);",100);
							parent.shuaxin();
							parent.fuxuan()
                        });
						// layer.msg(data.str);
					}
				},
                error: function(XmlHttpRequest, textStatus, errorThrown){
					layer.close(indexs);
					layer.msg('error!');
				}
			});
			return false;
			/*var index = parent.layer.getFrameIndex(window.name);
			parent.$('.btn-refresh').click();
			parent.layer.close(index);*/
		})
		function isNull(data){ 
			return (data == "" || data == undefined || data == null) ? true: false; 
		}
</script>
@endsection