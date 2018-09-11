@extends('admin.father.css')
@section('content')
<article class="page-container">
	<form class="form form-horizontal" id="form-url-chn"><input type="hidden" name="url_id" value="{{$url->url_id}}">
		
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>域名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$url->url_url}}" placeholder="" id="url_url" name="url_url">
			</div>
		</div>
		
	<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>状态：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="url_type" id="url_type" class="select">
				<option value="0" @if($url!=null && $url->url_type==0)selected='selected'@endif>关闭</option>
				<option value="1" @if($url!=null && $url->url_type==1)selected='selected'@endif>开启</option>
				</select>
				</span>
			 </div>
	</div>
	<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>遮罩等级：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="url_zz_level" id="url_zz_level" class="select">
				<option value="0" @if($url!=null && $url->url_zz_level==0)selected='selected'@endif>全部放行</option>
				<option value="1" @if($url!=null && $url->url_zz_level==1)selected='selected'@endif>屏蔽美国fb人员</option>
				<option value="2" @if($url!=null && $url->url_zz_level==2)selected='selected'@endif>屏蔽所有fb人员</option>
				<option value="3" @if($url!=null && $url->url_zz_level==3)selected='selected'@endif>屏蔽除台湾外所有人员</option>
				<option value="4" @if($url!=null && $url->url_zz_level==4)selected='selected'@endif>屏蔽所有人员</option>
				</select>
				</span>
			 </div>
	</div>
	<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>遮罩导向：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="url_zz_for" id="url_zz_for" class="select">
				<option value="0" @if($url!=null && $url->url_zz_for==0)selected='selected'@endif>遮罩页面</option>
				<option value="1" @if($url!=null && $url->url_zz_for==1)selected='selected'@endif>屏蔽页面</option>
				<option value="2" @if($url!=null && $url->url_zz_for==2)selected='selected'@endif>无法访问</option>
				</select>
				</span>
			 </div>
	</div>
	<br>
	<div class="row cl" style="border: 1px solid #ccc;width: 80%;margin:0px auto;">
		<label class="form-label col-xs-4 col-sm-3">正常单品：</label>
		  <div class ="radio-box">  <label class="" style="color:red;"><input type="radio" value="null" name="url_goods_id" id="url_goods_id" class="valid" />无</label>
		  	@if(Auth::user()->is_root=='1')
		  	@foreach(\App\goods::where('is_del','0')->get() as $key => $v)
		    <label class=""><input type="radio" value="{{$v->goods_id}}" name="url_goods_id" id="url_goods_id" class="valid" @if($url->url_goods_id==$v->goods_id) checked="checked" @endif />{{$v->goods_real_name}}</label>
	  		@endforeach
		  	@else
		    @foreach(\App\goods::where('is_del','0')
		      ->where(function($query){
		        $query->whereIn('goods_admin_id',\App\admin::get_group_ids(Auth::user()->admin_id));
		      })->get() as $key => $v)
		    <label class=""><input type="radio" value="{{$v->goods_id}}" name="url_goods_id" id="url_goods_id" class="valid" @if($url->url_goods_id==$v->goods_id) checked="checked" @endif />{{$v->goods_real_name}}</label>
		    @endforeach
		    @endif
		  </div> 
  	</div>
  	<br>
  	<div class="row cl" style="border: 1px solid #ccc;width: 80%;margin:0px auto;">
  		<label class="form-label col-xs-4 col-sm-3">遮罩单品：</label>
  		<div class =“radio-box”>  <label class="" style="color:red;"><input type="radio" value="null" name="url_zz_goods_id" id="url_zz_goods_id" class="valid" />无</label>
  		@if(Auth::user()->is_root=='1')
	 	@foreach(\App\goods::where('is_del','0')->get() as $key => $v)
	    	<label class=""><input type="radio" value="{{$v->goods_id}}" name="url_zz_goods_id" id="url_zz_goods_id" class="valid" @if($url->url_zz_goods_id==$v->goods_id) checked="checked" @endif />{{$v->goods_real_name}}</label>
	    @endforeach
	    @else
		@foreach(\App\goods::where('is_del','0')
	      ->where(function($query){
	        $query->whereIn('goods_admin_id',\App\admin::get_group_ids(Auth::user()->admin_id));
	      })->get() as $key => $v)
	    	<label class=""><input type="radio" value="{{$v->goods_id}}" name="url_zz_goods_id" id="url_zz_goods_id" class="valid" @if($url->url_zz_goods_id==$v->goods_id) checked="checked" @endif />{{$v->goods_real_name}}</label>
	  	@endforeach
	  	@endif
		</div> 
  	</div>
	{{csrf_field()}}
	
	<div class="row cl">
		<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
			<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
		</div>
	</div>
	</form>
</article>
@endsection
@section('js')
<script type="text/javascript">
	$(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});
	
	$("#form-url-chn").validate({
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
				url: "{{url('admin/url/ajaxup')}}" ,
				success: function(data){
					if(data.err==1){
						layer.msg('配置成功!',{icon:1,time:1000},function(){
							index = parent.layer.getFrameIndex(window.name);
								setTimeout("parent.layer.close(index);",2000);
	                        	window.parent.location.reload();
						});
					 }else{
					layer.msg(data.str,{icon:2,time:1000});
					 }
				},
                error: function(XmlHttpRequest, textStatus, errorThrown){
					layer.msg('error!',{icon:2,time:1000});
				}
			});
			/*var index = parent.layer.getFrameIndex(window.name);
			parent.$('.btn-refresh').click();
			parent.layer.close(index);*/
		}
	});
});
</script>
@endsection