@extends('admin.father.css')
@section('content')
<article class="page-container">
	<form class="form form-horizontal" id="form-goods-update" enctype="multipart/form-data" action="{{url('admin/goods/post_update')}}">
		{{csrf_field()}}
		<input type="hidden" name="goods_id" value="{{$goods->goods_id}}">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods->goods_name}}" placeholder="" id="goods_name" name="goods_name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>单品名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods->goods_real_name}}" placeholder="" id="goods_real_name" name="goods_real_name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品描述：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<textarea name="goods_msg" cols="" rows="" id="goods_msg" class="textarea"  placeholder="说点什么...最少输入10个字符" datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！" onKeyUp="$.Huitextarealength(this,200)">{{$goods->goods_msg}}</textarea>
				<p class="textarea-numberbar"><em class="textarea-length">0</em>/200</p>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品原价：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods->goods_real_price}}" placeholder="" id="goods_real_price" name="goods_real_price">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品定价：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods->goods_price}}" placeholder="" id="goods_price" name="goods_price">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品促销活动名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods->goods_cuxiao_name}}" placeholder="" id="goods_cuxiao_name" name="goods_cuxiao_name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>促销类型：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="goods_cuxiao_type" id="goods_cuxiao_type" class="select">
					<option value="0" @if($goods->goods_cuxiao_type=='0') selected="selected" @endif>单件销售</option>
					<option value="1" @if($goods->goods_cuxiao_type=='1') selected="selected"  @endif>买几送几</option>
					<option value="2" @if($goods->goods_cuxiao_type=='2') selected="selected"  @endif>满件优惠</option>
					<option value="3" @if($goods->goods_cuxiao_type=='3') selected="selected"  @endif>自定义套餐</option>
				</select>
				</span> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>模板类型：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="goods_blade_type" id="goods_blade_type" class="select">
					<option value="0" @if($goods->goods_blade_type=='0') selected="selected" @endif>0--正常模板</option>
					<option value="1" @if($goods->goods_blade_type=='1') selected="selected"  @endif>1--展示模板</option>
				</select>
				</span> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>单品类型：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="goods_type" id="goods_type" class="select">
					@foreach($type as $val)
					<option value="{{$val->goods_type_id}}" @if($goods->goods_type==$val->goods_type_id) selected="selected" @endif>{{$val->goods_type_name}}</option>
					@endforeach
				</select>
				</span> </div>
		</div>
		<div class="row cl"	id="cuxiaohtml">
			<!-- <div class="formControls col-xs-8 col-sm-9" >
			</div> -->
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">附带视频(仅限mp4/mpeg格式)：</label>
			<div class="formControls col-xs-8 col-sm-9">
				@if($goods->goods_video!=''||$goods->goods_video!=null)<video src="/{{$goods->goods_video}}"	controls="" preload="none" width="420" height="280"
		data-setup="{}"></video>@else 	<label class="form-label col-xs-4 col-sm-2">暂无数据</label>@endif
				<input type="file" id="goods_video" class="input-text" value="{{$goods->goods_video}}" placeholder="" id="goods_video" name="goods_video" accept="audio/mp4,video/mp4,video/mpeg,video/mpeg">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">是否附带视频:</label>
			<div class="formControls col-xs-8 col-sm-9 skin-minimal">
				<div class="check-box">
					是 <input type="radio" id="is_video" class="is_video" name="is_video" @if($goods->goods_video!=null) checked="checked" @endif value="1" >
					否 <input type="radio" id="is_video" class="is_video" name="is_video" @if($goods->goods_video==null) checked="checked" @endif value="0" >
					<label for="checkbox-pinglun">&nbsp;</label>
				</div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品库存：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods->goods_num}}" placeholder="" id="goods_num" name="goods_num">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品倒计时展示：</label>
			<div class="formControls col-xs-8 col-sm-9">
				时:<input type="text" style="width: 10%;" class="input-text" value="{{explode(':',$goods->goods_end)[0]}}" placeholder="" id="goods_end1" name="goods_end1">
				分:<input type="text" style="width: 10%;" class="input-text" value="{{explode(':',$goods->goods_end)[1]}}" placeholder="" id="goods_end2" name="goods_end2">
				秒:<input type="text" style="width: 10%;" class="input-text" value="{{explode(':',$goods->goods_end)[2]}}" placeholder="" id="goods_end3" name="goods_end3"><div style="border:2px dashed #ccc;">展示形式:<img src="/images/djs.png"></div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品评论数展示：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods->goods_comment_num}}" placeholder="" id="goods_comment_num" name="goods_comment_num">
				<div style="border:2px dashed #ccc;">展示形式:<img src="/images/comm.png"></div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品发布者：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods->admin_name}}" disabled placeholder="" id="admin_name" name="admin_name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>封面图：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<div class="uploader-thum-container">
					<input type="file" name="fm_imgs[]" width="420" height="280" multiple="multiple"	accept="image/png,image/gif,image/jpg,image/jpeg">
				</div>
			</div>
		</div>
	<!-- 	<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>对应域名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods->url}}"  placeholder="" id="url" name="url">
				正常单品:<input type="checkbox" id="is_zz" name="is_zz" @if($goods->is_zz=='0') checked="checked" @endif value="0" >
				遮罩单品:<input type="checkbox" id="is_zz" name="is_zz" @if($goods->is_zz=='1') checked="checked" @endif value="1" >
			</div>
		</div> -->
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">商品像素：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods->goods_pix}}" placeholder="" id="goods_pix" name="goods_pix">
			</div>
		</div>
	<!-- 	<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">是否上线：</label>
			<div class="formControls col-xs-8 col-sm-9 skin-minimal">
				<div class="check-box">
					<input type="checkbox" id="is_online" name="is_online" @if($goods->is_online=='1') checked="checked" @endif value="1" >
					<label for="checkbox-pinglun">&nbsp;</label>
				</div>
			</div>
		</div> -->
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品描述：</label>
			<div class="formControls col-xs-8 col-sm-9"> 
				<script id="editor1" type="text/plain" name='editor1' style="width:100%;height:400px;">{!!$goods->goods_des_html!!}</script> 
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品规格：</label>
			<div class="formControls col-xs-8 col-sm-9"> 
				<script id="editor2" type="text/plain" name='editor2' style="width:100%;height:400px;">{!!$goods->goods_type_html!!}</script> 
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
	
			get_cuxiao_html($('#goods_cuxiao_type').val());


	(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
		});

	});
	$('#goods_cuxiao_type').on('change',function(){
		var now=$(this).val();
		get_cuxiao_html(now);
	})
	
	function get_cuxiao_html(now){
			          $('#cuxiaohtml').html('<div  style="margin:0px aito;width:50%;float:right;"><img src="/images/loading.gif"> </div>');
		$.ajax({
					url:"{{url('admin/goods/getcuxiaohtml')}}",
					type:'get',
					data:{'id':now,'goods_id':"{{$goods->goods_id}}"},
					datatype:'json',
					success:function(msg){
			          $('#cuxiaohtml').html(msg);
					}
				})
	}
	
	//表单验证
	$("#form-goods-update").validate({
		rules:{
			goods_name:{
				required:true,
			},
			goods_real_name:{
				required:true,
			},
			goods_msg:{
				required:true,
			},
			goods_real_price:{
				required:true,
				number:true,
			},
			goods_price:{
				required:true,
				number:true,
			},
			goods_cuxiao_name:{
				required:true,
			},
			goods_num:{
				required:true,
				digits:true,
			},
			goods_end1:{
				required:true,
				digits:true,
			},
			goods_end2:{
				required:true,
				digits:true,
			},
			goods_end3:{
				required:true,
				digits:true,
			},
			goods_comment_num:{
				required:true,
				digits:true,
			},
			admin_name:{
				required:true,
			},
			url:{
				required:true,
			},
			commentdatemax:{
				required:true,
			},

		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			$(form).ajaxSubmit({
				type: 'post',
				url: "{{url('admin/goods/post_update')}}",
				success: function(data){
					if(data.err==1){
						layer.msg('更改成功!',{time:2*1000},function() {
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
	$('#goods_video').on('change',function(){
		$(this).prev().hide(1000);
	})
		 UE.getEditor('editor1');
		 UE.getEditor('editor2');
		function removeIframe(){
	var index = parent.layer.getFrameIndex(window.name);
	setTimeout(function(){parent.layer.close(index)}, 500); 
		}
		$('.is_video').on('click',function(){
			var val=$(this).val();
			if(val==0){
				$(this).parent().parent().parent().prev().hide(400);
			}else if(val==1){
				$(this).parent().parent().parent().prev().show(400);
			}
		})
</script>
@endsection