@extends('admin.father.css')
@section('content')
<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" id="addrole"  class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 增加角色</a></span></div>
<form id="chroles" action="{{url('admin/admin/checkbox')}}" method="post">
	{{csrf_field()}}
<div class="row cl">
	
		<br>
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="role_id" id="role_id" class="select">
					@foreach(\App\role::get() as $key =>$v)
					<option value="{{$v->role_id}}">{{$v->role_name}}</option>
					@endforeach
				</select>
				</span> </div>
			</div>
		<br>
			<label class="form-label col-xs-4 col-sm-3">拥有权限：</label>
			<div class="formControls col-xs-8 col-sm-9" id="chrole">
				<img src="/images/loading.gif">
			</div>
		</div>

		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3" style="margin-left: 50%;"><br>
				<button type="submit" class="btn btn-success radius" id="admin-role-save" name="admin-role-save"><i class="icon-ok"></i> 确定</button>
			</div>
		</div>
		</form>
@endsection
@section('js')
<script type="text/javascript">
	$(function(){
		var val=$('#role_id').val();
		ajaxrole(val);

	
	$("#chroles").validate({
		rules:{
			roleName:{
				required:true,
			},
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			$(form).ajaxSubmit({
				type: 'post',
				url: "{{url('admin/admin/checkbox')}}",
				success: function(data){
					if(data.err==1){
						layer.msg('分配成功!',{time:2*1000},function() {
						//回调
							
                        	window.location.reload();
						});
					}else{
						layer.msg(data.str);
					}
				},
                error: function(XmlHttpRequest, textStatus, errorThrown){
					layer.msg('error!');
				}});
			var index = parent.layer.getFrameIndex(window.name);
			parent.layer.close(index);
		}
	});
$('#role_id').on('change',function(){

		var val=$(this).val();
		ajaxrole(val);
	})
		function ajaxrole(role_id){
			 $('#chrole').html('<img src="/images/loading.gif">');
			$.ajax({
					url:"{{url('admin/admin/chrole')}}",
					type:'post',
					data:{'id':role_id,'_token':'{{csrf_token()}}'},
					datatype:'json',
					success:function(msg){
			          $('#chrole').html(msg);
					}
				})
	
	}
});
	$('#addrole').on('click',function(){
			layer_show('添加角色','/admin/admin/addrole',300,200);
		})

</script>
@endsection