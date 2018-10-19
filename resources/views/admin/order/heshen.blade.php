@extends('admin.father.css')
@section('content')
<article class="page-container">
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>单品名：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" value="{{$goods->goods_name}}" placeholder="" id="adminName" name="adminName" disabled="disabled">
		</div>
	</div>
	<form class="form form-horizontal" id="order_type_change" action="{{url('admin/order/order_type_change')}}" method="post">
	<input type="hidden" name="id" value="{{$order->order_id}}">
	{{csrf_field()}}
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">状态选择：</label>
		<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
			<select class="select" name="order_type_now" size="1" id="order_type_select">
				<option value="0" @if($order->order_type==0) selected @endif >未核审</option>
				<option style="display: {{$order->order_type == 9 ? 'none' : 'block'}}" value="1" @if($order->order_type==1) selected @endif >通过核审</option>
				<option value="2" @if($order->order_type==2) selected @endif >拒绝核审</option>
				<option style="display: {{$order->order_type == 9 ? 'none' : 'block'}}" value="3" @if($order->order_type==3) selected @endif >已发货</option>
				<option style="display: {{$order->order_type == 9 ? 'none' : 'block'}}" value="4" @if($order->order_type==4) selected @endif >已签收</option>
				<option style="display: {{$order->order_type == 9 ? 'none' : 'block'}}" value="5" @if($order->order_type==5) selected @endif >退货未退款</option>
				<option style="display: {{$order->order_type == 9 ? 'none' : 'block'}}" value="6" @if($order->order_type==6) selected @endif >退货并已退款</option>
				<option style="display: {{$order->order_type == 9 ? 'none' : 'block'}}" value="7" @if($order->order_type==7) selected @endif >未退货已退款</option>
				<option style="display: {{$order->order_type == 9 ? 'none' : 'block'}}" value="14" @if($order->order_type==14) selected @endif >问题订单</option>
				<option style="display: {{$order->order_type == 9 ? 'none' : 'block'}}" value="8" @if($order->order_type==8) selected @endif ><span style='color:red;'>拒签</span></option>
			</select>
			</span> </div>
	</div>
	<div class="row cl" style="display: none;">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>快递单号：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" value="{{$order->order_send}}" placeholder="" id="order_send" name="order_send">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">核审信息记录：</label>
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
			if(order_type>=3&&isNull(order_send_val)){
				layer.msg("请填写快递单号！");
				return false;
			}
			if(order_type>=3){
				if(order_send_val.length<8||order_send_val.length>35){
					layer.msg("订单编号长度不合法！");
					return false;
				}
			}
			if(isNull($('#order_return_textarea').val())){
				layer.msg("请填写核审记录");
				return false;
			}
			$('#order_type_change').ajaxSubmit({
				type: 'post',
				url: "{{url('admin/order/order_type_change')}}",
				success: function(data){
					if(data.msg==0){
						layer.msg('更改成功!',{time:2*1000},function() {
						//回调
							index = parent.layer.getFrameIndex(window.name);
							setTimeout("parent.layer.close(index);",2000);
                        	window.parent.location.reload();
						});
					}else{
						layer.msg('更改失败!');
					}
				},
                error: function(XmlHttpRequest, textStatus, errorThrown){
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