@extends('admin.father.css')
@section('content')
<article class="page-container">
	<br>
	<br>
	<br>
	<br>
		<form class="form form-horizontal" id="form-check-update" enctype="multipart/form-data" action="{{url('/admin/check/set')}}">
				{{csrf_field()}}
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">是否开启核审机制：</label>
			<div class="formControls col-xs-8 col-sm-9 skin-minimal">
				<div class="check-box">
					<input type="checkbox" id="goods_is_check" name="goods_is_check" @if($goods_check['goods_is_check']==0) checked="checked" @endif value="0" >是
					<label for="checkbox-pinglun">&nbsp;</label>
				</div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>保护期时长(秒)：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods_check['goods_check_second']}}" placeholder="" id="goods_check_second" name="goods_check_second">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>核审最高触发次数(次)：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods_check['goods_check_max']}}" placeholder="" id="goods_check_max" name="goods_check_max">
			</div>
			<span style="color:red;">超过核审次数的单品将无法修改!</span>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button  class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交</button>
				<!-- <button onClick="article_save();" class="btn btn-secondary radius" type="button"><i class="Hui-iconfont">&#xe632;</i> 保存草稿</button>
				<button onClick="removeIframe();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button> -->
			</div>
		</div>
	</form>
</article>
@endsection
@section('js')
	<script type="text/javascript">
		$("#form-check-update").validate({
		rules:{
			goods_check_second:{
				required:true,
				number:true,
			},
			goods_check_max:{
				required:true,
				number:true,
			},
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			$(form).ajaxSubmit({
				type: 'post',
				url: "{{url('/admin/check/set')}}",
				success: function(data){
					if(data.err==1){
						layer.msg('修改成功!',{time:2*1000});
					}else{
						layer.msg(data.str);
					}
				},
                error: function(XmlHttpRequest, textStatus, errorThrown){
					layer.msg('error!');
				}});
			var index = parent.layer.getFrameIndex(window.name);
			//parent.$('.btn-refresh').click();
			/*parent.layer.close(index);*/
		}
	});
	</script>
@endsection