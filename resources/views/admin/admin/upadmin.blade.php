@extends('admin.father.css')
@section('content')
<article class="page-container">
	<form class="form form-horizontal" id="form-admin-update" enctype="multipart/form-data" action="{{url('admin/admin/upadmin')}}" method="post">
		{{csrf_field()}}
		<input type="hidden" name="admin_id" value="{{$admin->admin_id}}">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>账户名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$admin->admin_name}}" placeholder="" id="admin_name" name="admin_name" @if(\Auth::user()->is_root!='1') readonly=readonly @endif>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>账户密码：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="password" class="input-text" value="" placeholder="请输入新密码" id="password" name="password">
			</div>
		</div>
		
		<div class="row cl" @if(\Auth::user()->is_root!='1') style="display:none;" @endif>
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>所属分组：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="admin_group_id" id="admin_group_id" class="select">
					@foreach(\App\admin_group::get() as $v)
					<option value="{{$v->admin_group_id}}" @if($admin->admin_group==$v->admin_group_id) selected='selected' @endif>{{$v->admin_group_name}}</option>
					@endforeach
				</select>
				</span> </div>
		</div>
		
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>所属角色：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				
					 @if(\Auth::user()->is_root!='1')
						<input type="text" class="input-text" value="{{\App\role::where('role_id',$admin->admin_role_id)->first()['role_name']}}" placeholder="" id="" name="" readonly="readonly">
						<input type="hidden" name="role_id" value="{{$admin->admin_role_id}}">
					 @else
					 <select name="role_id" id="role_id" class="select">
						 <option value="0">超级管理员</option>
						@foreach(\App\role::get() as $key => $v)
							<option value="{{$v->role_id}}" @if($v->role_id==$admin->admin_role_id) selected="selected" @endif>{{$v->role_name}}</option>
						@endforeach	
						</select>
					 @endif
				</span>
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
	$("#form-admin-update").validate({
		rules:{
			admin_name:{
				required:true,
				rangelength:[4,15]
			},
			
			role_id:{
				required:true,
			}
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			$(form).ajaxSubmit({
				type: 'post',
				url: "{{url('admin/admin/upadmin')}}",
				
				success: function(data){
					if(data.err==1){
						layer.msg('修改成功!',{time:2*1000},function() {
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