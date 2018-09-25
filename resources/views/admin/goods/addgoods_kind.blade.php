@extends('admin.father.css')
@section('content')
<article class="page-container">
		<form class="form form-horizontal" id="form-goodskind-update" enctype="multipart/form-data" action="{{url('admin/goods/addgoods_kind')}}">
				{{csrf_field()}}
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">已有产品(所属单品数)：</label>
			<div class="formControls col-xs-8 col-sm-9">
			 <span class="select-box">
				<select name="goods_type_chose" id="goods_type_chose" class="select">
					@foreach($goods_kinds as $k => $v)
					<option>{{$v->goods_kind_name}}</option>
					@endforeach
				</select>
			</span>
			 </div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>新增产品：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder="" id="goods_kind_name" name="goods_kind_name">
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
		$("#form-goodskind-update").validate({
		rules:{
			goods_type_name:{
				required:true,
			},
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			$(form).ajaxSubmit({
				type: 'post',
				url: "{{url('admin/goods/addgoods_kind')}}",
				success: function(data){
					if(data.err==1){
						layer.msg('添加成功!',{time:2*1000},function() {
						//回调
							index = parent.layer.getFrameIndex(window.name);
							setTimeout("parent.layer.close(index);",200);
                        	
						});
					}else{
						layer.msg(data.msg);
					}
				},
                error: function(XmlHttpRequest, textStatus, errorThrown){
					layer.msg('error!');
				}});
			//var index1 = parent.layer.getFrameIndex(window.name);
			//parent.$('.btn-refresh').click();
			/*parent.layer.close(index);*/
		}
	});
	</script>
@endsection