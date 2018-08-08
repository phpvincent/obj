@extends('admin.father.css')
@section('content')
<article class="page-container">
		<form class="form form-horizontal" id="form-url-update" enctype="multipart/form-data" action="{{url('admin/url/url_add')}}">
				{{csrf_field()}}
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>域名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder="" id="url_url" name="url_url">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>遮罩等级：</label>
			<div class="formControls col-xs-8 col-sm-9">
			 <span class="select-box">
				<select name="url_level" id="url_level" class="select">
					<option value="0" >全部放行</option>
					<option value="1" >屏蔽美国地区fb人员</option>
					<option value="2" >屏蔽所有fb人员</option>
					<option value="3" >屏蔽所有非台湾地区人员</option>
				</select>
			</span>
			 </div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>遮罩导向：</label>
			<div class="formControls col-xs-8 col-sm-9">
			 <span class="select-box">
				<select name="url_for" id="url_for" class="select">
					<option value="0" >遮罩页面</option>
					<option value="1" >屏蔽页面</option>
					<option value="2" >无法访问</option>
				</select>
			</span>
			 </div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">是否上线：</label>
			<div class="formControls col-xs-8 col-sm-9 skin-minimal">
				<div class="check-box">
					<input type="checkbox" id="is_online" name="is_online"  checked="checked"  value="1" >
					<label for="checkbox-pinglun">&nbsp;</label>
				</div>
			</div>
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
		$("#form-url-update").validate({
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
				url: "{{url('admin/url/url_add')}}",
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