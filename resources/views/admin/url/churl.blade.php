@extends('admin.father.css')
@section('content')
<article class="page-container">
	<form class="form form-horizontal" id="form-urlgoods-add">
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">角色：</label>
		<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
			<select class="select" name="url_type" size="1">
				<option value="0" @if(!$url==null&&$url->url_type==0)selected='selected'@endif>关闭</option>
				<option value="1" @if(!$url==null&&$url->url_type==1)selected='selected'@endif>开启</option>
			</select>
			</span> </div>
	</div>
	<input type="hidden" name="id" value="{{$goods->goods_id}}">
	{{csrf_field()}}
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>域名：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" @if(!$url==null)value="{{$url->url_url}}"@endif placeholder="输入完整域名:xxxx.com" name="url_url" id="url_url">
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
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});
	
	$("#form-urlgoods-add").validate({
		rules:{
			url_url:{
				required:true,
			},
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			$(form).ajaxSubmit({
				type: 'post',
				url: "{{url('admin/url/ajaxup')}}" ,
				success: function(data){
					if(data){
					layer.msg('添加成功!',{icon:1,time:1000});
					 }else{
					layer.msg('添加失败!',{icon:2,time:1000});
					 }
				},
                error: function(XmlHttpRequest, textStatus, errorThrown){
					layer.msg('error!',{icon:2,time:1000});
				}
			});
			/*var index = parent.layer.getFrameIndex(window.name);
			parent.$('.btn-refresh').click();
			parent.layer.close(index);*/
		}
	});
});
</script>
@endsection