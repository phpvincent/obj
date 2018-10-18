@extends('admin.father.css')
@section('content')
<article class="page-container">
	<form class="form form-horizontal" id="admin-add" enctype="multipart/form-data" action="" method="post">
		<div class="row cl">
			{{csrf_field()}}
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>所属角色：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="admin_role_id" id="admin_role_id" class="select">
					@foreach($roles as $v)
					<option value="{{$v->role_id}}">{{$v->role_name}}</option>
					@endforeach
					<option  value="0" >超级管理员</option>
				</select>
				</span> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>所属分组：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="admin_group_id" id="admin_group_id" class="select">
					@foreach(\App\admin_group::get() as $v)
						<option attr="{{$v->admin_group_rule}}" value="{{$v->admin_group_id}}">{{$v->admin_group_name}}</option>
					@endforeach
				</select>
				</span> </div>
		</div>
		<div class="row cl shuju_1" style="display: none">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>查看数据权限：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="admin_data_rule1" class="select admin_data_rule">
						<option value="0">仅查看自己</option>
						<option value="1">查看自己与本组</option>
				</select>
				</span> </div>
		</div>
		<div class="row cl shuju_0">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>查看数据权限：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="admin_data_rule0" class="select admin_data_rule">
						<option value="0">仅查看自己</option>
						<option value="1">查看自己与本组</option>
						<option value="2">查看全体成员</option>
						<option value="3">root</option>
				</select>
				</span> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>用户名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder="" id="admin_name" name="admin_name">
				<input type="text" class="input-text" style="display: none;" value="" placeholder="" id="attr" name="attr">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>密码：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="password" class="input-text" value="" placeholder="" id="password" name="password">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>显示完整订单：</label>
			<div class="formControls col-xs-8 col-sm-9 skin-minimal">
				<div class="check-box">
					是 <input type="radio" id="admin_is_order" checked name="admin_is_order" value="1">
					否 <input type="radio" id="admin_is_order" name="admin_is_order" value="0">
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
    var a =$("#admin_group_id  option:first").attr('attr');
    $('#attr').val(a);
    if(a==1){
        $('.shuju_1').show();
        $('.shuju_0').hide();
    }else {
        $('.shuju_0').show();
        $('.shuju_1').hide();
    }
    $("#admin_group_id").on('change',function(){
        Jurisdiction();
	});
    function Jurisdiction(){
        var a =$("#admin_group_id  option:selected").attr('attr');
        $('#attr').val(a);
        if(a==1){
            $('.shuju_1').show();
            $('.shuju_0').hide();
        }else {
            $('.shuju_0').show();
            $('.shuju_1').hide();
        }
	}



	$('#admin-add').on('submit',function(){
		if($('#admin_role_id').val()=='0'){
			var msg =confirm("确定要增加超级管理员账户吗？");
			if(!msg){
				return false;
			}
		}
		
			if($('#admin_name').val()==''||$('#admin_name').val()==null){
				layer.msg('账户名不得为空！');
				return false;
			}
			if($('#password').val()==''||$('#password').val()==null){
				layer.msg('密码不得为空！');
				return false;
			}
			if($('#password').val().length<6){
				layer.msg('密码长度必须为6位以上！');
				return false;
			}
			if($('#admin_name').val().length<6){
				layer.msg('账户长度必须为6位以上！');
				return false;
			}
			$.ajax({
					url:"{{url('admin/admin/addadmin')}}",
					type:'post',
					data:$('#admin-add').serialize(),
					datatype:'json',
					success:function(msg){
			         if(msg['err']==1){
						layer.msg('添加成功!',{time:2*1000},function() {
						//回调
							index = parent.layer.getFrameIndex(window.name);
							setTimeout("parent.layer.close(index);",2000);
                        	window.parent.location.reload();
						});
			           }else if(msg['err']==0){
			           	 layer.msg(msg.str);
			           }else{
			           	 layer.msg('添加失败！');
			           }
					}
				})
			return false;
	})
</script>
@endsection