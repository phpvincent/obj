@extends('admin.father.css')
@section('content')
<article class="page-container">
	<form class="form form-horizontal" id="form-role-update" enctype="multipart/form-data" action="{{url('admin/admin/addrole')}}" method="post">
		{{csrf_field()}}
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>角色名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder="" id="role_name" name="role_name">
			</div>
		</div>
	
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button style="background-color: #009688;border-color: #009688;" class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交</button>
				<!-- <button onClick="article_save();" class="btn btn-secondary radius" type="button"><i class="Hui-iconfont">&#xe632;</i> 保存草稿</button>
				<button onClick="removeIframe();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button> -->
			</div>
		</div>
		
	</form>
</article>
@endsection
@section('js')
<script type="text/javascript">
	$("#form-role-update").validate({
		rules:{
			role_name:{
				required:true,
			},
			
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			$(form).ajaxSubmit({
				type: 'post',
				url: "{{url('admin/admin/addrole')}}",
				success: function(data){
					if(data.err==1){
						layer.msg('添加成功!',{time:2*1000},function() {
						//回调
							index = parent.layer.getFrameIndex(window.name);
							setTimeout("parent.layer.close(index);",2000);
                        	window.parent.location.reload();
						});
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