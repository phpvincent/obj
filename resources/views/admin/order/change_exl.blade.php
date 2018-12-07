@extends('admin.father.css')
@section('content')
<div>
	
	<img id="img" src="/images/excil.jpg" style="display: none;">
</div>
<form action="{{url('admin/order/change_exl')}}" method="post" 	enctype="multipart/form-data">
	{{csrf_field()}}
	<div style="width: 100%;margin: 0px auto;text-align: center;margin-top: 150px;"><input class="btn btn-default showimg" type="button" value="示例"><br>
		<br><span class="btn-upload form-group">
		  上传制式表格：<input class="input-text upload-url radius" type="text" name="uploadfile-1" id="uploadfile-1" readonly><a href="javascript:void();" class="btn btn-primary radius"> 上传</a>
		  <input type="file" multiple name="excil" class="input-file" accept=".csv,.xls">
		</span>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>导出后文件名：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" value="change" placeholder="" id="excil_name" name="excil_name">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">地区：</label>
		<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" >
			<select class="select" name="goods_blade_type" size="1" id="goods_blade_type">
						<option value="0">台湾</option>
						<option value="2">中东</option>
						<option value="6">印度尼西亚</option>
						<option value="7">菲律宾</option>
					</select>
					</span> </div>
			</div>
	<div class="row cl" style="">
		<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3"><br><br><i class="icon Hui-iconfont"></i>
			<input class="btn btn-default radius" type="submit" value="&nbsp;&nbsp;转换&nbsp;&nbsp;">
		</div>
	</div>
	</div>
	
</form>
@endsection
@section('js')
<script type="text/javascript">
	$('.showimg').click(function(){
		layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '516px',
		  skin: 'layui-layer-nobg', //没有背景色
		  shadeClose: true,
		  content: $('#img')
		});
	})
	
</script>
@endsection