@extends('admin.father.css')
@section('content')
<article class="page-container">
	
	<form class="form form-horizontal" id="send_mail" action="{{url('admin/order/send_mail')}}" method="post">
	<input type="hidden" name="id" value="{{$order->order_id}}">
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱地址：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" value="{{$order->order_email}}" placeholder="" id="order_mail" name="order_mail">
		</div>
	</div>
	{{csrf_field()}}
	<div class="row cl">
		<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
			<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;补发&nbsp;&nbsp;">
		</div>
	</div>
	</form>
</article>
@endsection
@section('js')
<script type="text/javascript">
	$('#send_mail').submit(function(){
			var send_mail=$('#order_mail').val();
			if(isNull(send_mail)||send_mail.length>=20||send_mail.length<=3){
				layer.msg("请填写合法邮箱！");
				return false;
			}
			var indexs = layer.load(2, {shade: [0.15, '#393D49']})
			$('#send_mail').ajaxSubmit({
				type: 'post',
				url: "{{url('admin/order/send_mail')}}",
				success: function(data){
					layer.close(indexs);
					if(data.msg==0){
						layer.msg('邮件推送成功!',{time:2*1000},function() {
						//回调
							index = parent.layer.getFrameIndex(window.name);
							setTimeout("parent.layer.close(index);",100);
							parent.shuaxin(); 
						});
					}else{
						layer.msg(data.msg);
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