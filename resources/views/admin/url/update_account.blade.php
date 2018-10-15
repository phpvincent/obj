@extends('admin.father.css')
@section('content')
<article class="page-container">
		<form class="form form-horizontal" id="form-ad_account-update" enctype="multipart/form-data" action="{{url('admin/url/update_account')}}">
				{{csrf_field()}}
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">选择账户</label>
			<div class="formControls col-xs-8 col-sm-9">
			 <span class="select-box">
				<select name="ad_account_id" id="ad_account_id" class="select">
					@foreach(\App\ad_account::all() as $k => $v)
					<option value="{{$v->ad_account_id}}" >{{$v->ad_account_name}}</option>
					@endforeach
				</select>
			</span>
			 </div>
		</div>
		<br>
		<hr>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>账户名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder="" id="ad_account_name" name="ad_account_name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>账户所属平台:</label>
			<div class="formControls col-xs-8 col-sm-9">
			 <span class="select-box">
				<select name="ad_account_belong" id="ad_account_belong" class="select">
					<option value="0" >fb</option>
					<option value="1" >Yahoo</option>
					<option value="2" >Google</option>
				</select>
			</span>
			 </div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>账户状态：</label>
			<div class="formControls col-xs-8 col-sm-9">
			 <span class="select-box">
				<select name="ad_account_type" id="ad_account_type" class="select">
					<option value="0" >正常运营</option>
					<option value="1" >被封禁</option>
				</select>
			</span>
			 </div>
		</div>
		<div style="text-align: center;color:red;">更改账户状态为被封禁将会导致其名下域名被标记！</div>
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
		$("#form-ad_account-update").validate({
		rules:{
			ad_account_name:{
				required:true,
			},
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			$(form).ajaxSubmit({
				type: 'post',
				url: "{{url('admin/url/update_account')}}",
				success: function(data){
					if(data.err==1){
						layer.msg(data.str,{time:2*1000},function() {
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
		$('#ad_account_id').on('change',function(){
			id=$(this).val();
			get_msg(id);
		})
		$(function(){
			id=$('#ad_account_id').val();
			get_msg(id);
		})
	function get_msg(id){
		$.ajax({
					url:"{{url('admin/url/ajax_account')}}",
					type:'post',
					data:{'id':id,'_token':'{{csrf_token()}}'},
					datatype:'json',
					success:function(msg){
			           if(msg.err==0){
			           	layer.msg(msg.data);
			           }else{
			           	data=msg.data;
			           	$('#ad_account_name').val(data.ad_account_name);
			           	$('#ad_account_belong').find('[value="'+data.ad_account_belong+'"]').attr('selected',true);
			           	$('#ad_account_belong').find('[value!="'+data.ad_account_belong+'"]').attr('selected',false);
			           	$('#ad_account_type').find('[value="'+data.ad_account_type+'"]').attr('selected',true);
			           	$('#ad_account_type').find('[value!="'+data.ad_account_type+'"]').attr('selected',false);
			           }
					}
			})
	}
	</script>
@endsection