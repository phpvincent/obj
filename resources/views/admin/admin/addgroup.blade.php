@extends('admin.father.css')
@section('content')
<article class="page-container">
	<form class="form form-horizontal" id="group-add" enctype="multipart/form-data" action="" method="post">
		
			{{csrf_field()}}
			
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>组名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder="" id="admin_group_name" name="admin_group_name">
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>分组属性：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="admin_group_rule" id="admin_group_rule" class="select">
						<option value="0">普通分组</option>
						<option value="1">特殊分组</option>
				</select>
				</span> </div>
		</div>

		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button  class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 提交</button>
				<!-- <button onClick="article_save();" class="btn btn-secondary radius" type="button"><i class="Hui-iconfont">&#xe632;</i> 保存草稿</button>
				<button onClick="removeIframe();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button> -->
			</div>
		</div>
	</form>
</article>
@endsection
@section('js')
<script type="text/javascript">
	$('#group-add').on('submit',function(){
var msg =confirm("确定要增加该组吗？");
			if(!msg){
				return false;
			}
			if($('#admin_group_name').val()==''||$('#admin_group_name').val()==null){
				layer.msg('组名不得为空！');
				return false;
			}

			$.ajax({
					url:"{{url('admin/admin/addgroup')}}",
					type:'post',
					data:$('#group-add').serialize(),
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