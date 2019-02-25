@extends('admin.father.css')
@section('content')
<script type="text/javascript">
	//跳转到商品列表页
        function  goods_info(url,num)
        {
            if(num == 0){
                layer.msg('该产品无商品绑定');
            }else{
                window.location.href = url;
            }
        }
</script>
<article class="page-container">
	<br>
	<br>
	<br>
	<br>
		<form class="form form-horizontal" id="form-check-update" enctype="multipart/form-data" action="">
				{{csrf_field()}}
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>请输入SKU码：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder="" id="goods_check_second" name="goods_check_second"><button  class="btn btn-primary radius" id="sku_but" type="button">检索</button>
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2" style="border:1px solid #000;border-radius: 20px;">
				<p id="html">
					暂无数据
				</p>
				<!-- <button onClick="article_save();" class="btn btn-secondary radius" type="button"><i class="Hui-iconfont">&#xe632;</i> 保存草稿</button>
				<button onClick="removeIframe();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button> -->
			</div>
		</div>
	</form>
</article>
@endsection
@section('js')
	<script type="text/javascript">
		$.ajaxSetup({
		     headers: {
		         'X-XSRF-TOKEN': $.cookie('XSRF-TOKEN')
		     }
		});
		$('#sku_but').click(function(){
			if($('#goods_check_second').val().length<4){
				alert('sku码不得少于四位');
				return false;
			}
			$('#html').html('<span style="color:green;">查询中......</span><img width="30px" src="/images/loading.gif"></img>');
			var sku=$('#goods_check_second').val();
			$.ajax({
			//请求方式
			type:'post',
			url:'{{url("admin/kind/sku_search")}}?sku='+sku,
			dataType:'html',
			data:{},
			success:function(data){
					$('#html').html(data);
			},
			error:function(jqXHR){
				$('#html').html('<span color="red">查询失败！</span>')
			}
			});
		})
	/*	$("#form-check-update").validate({
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
		}
	});*/
	</script>
@endsection