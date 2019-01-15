@extends('admin.father.css')
@section('content')
<article class="page-container">
	<form class="form form-horizontal" id="order_type_change" action="{{url('admin/order/send_message')}}" method="post">
	<input type="hidden" name="order_id" value="{{$order->order_id}}" >
	{{csrf_field()}}
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>手机号（一个）：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" name="order_tel" value="{{ $order->order_tel }}" id="order_tel" class="input-text valid"><span class="c-red">请检查手机号的格式是否正确</span>
			<span>
				<br>国际区号+移动号码，国际区号和移动号码前不必再加0（适用于全球所有国家）。
				<br>示例：美国国际区号是1 移动号码6194328911
				<br>正确格式：16194328911
				<br>错误格式：106194328911；016194328911
			</span>

		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>推送内容：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<textarea type="text" class="textarea"  cols="" rows="" value="" placeholder="" id="content" name="content" maxlength="134" dragonfly="true"></textarea>
			<p class="textarea-numberbar"><em class="textarea-length">0</em>/134</p>
			<span class="c-red">请将短信内容控制在一条以内</span>
			<span>
				 <br>计费标准：
				<br>国内短信：支持中英文，70个字符/条，长短信（＞70字符时）按照67个字符/条；
				<br>国际短信：英文：140个字符/条，长短信（＞140字符时）按照134个字符/条，英文短信中出现非ASCII编码字符，按照国内短信计费方式计费； 除英文以外的其他语言按照国内短信计费方式计费。
			</span>

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

		$('#order_type_change').submit(function(){
			var order_tel= $('#order_tel').val();
			var content=$('#content').val();
            var patt = /^\d+$/;
            var patt2 = /^0\d+$/;
			if (isNull(order_tel) || !patt.test(order_tel) || patt2.test(order_tel)) {
                layer.msg("手机号不合法！");
                return false;
			}
			// console.log(content.length);
			if(isNull(content) || content.length > 134) {
                layer.msg("推送内容长度不合法！");
                return false;
			}
			var indexs = layer.load(2, {shade: [0.15, '#393D49']})
			$('#order_type_change').ajaxSubmit({
				type: 'post',
				url: "{{url('admin/order/send_message')}}",
				success: function(data){
					layer.close(indexs);
					if(data.msg==0){
						layer.msg('发送成功!',{time:2*1000},function() {
						//回调
							index = parent.layer.getFrameIndex(window.name);
							setTimeout("parent.layer.close(index);",100);
							parent.shuaxin(); 
						});
					}else{
                        // layer.msg('发送失败,请检查电话号码格式是否正确!',{time:2*1000},function() {
                        //     //回调
                        //     index = parent.layer.getFrameIndex(window.name);
                        //     setTimeout("parent.layer.close(index);",100);
                        //     parent.shuaxin();
                        // });
						layer.msg('发送失败,请检查电话号码格式是否正确!')
                    }
				},
                error: function(XmlHttpRequest, textStatus, errorThrown){
					layer.close(indexs);
					layer.msg('error!');
				}
			});
			return false;
		})
		function isNull(data){ 
			return (data == "" || data == undefined || data == null) ? true: false; 
		}
</script>
@endsection