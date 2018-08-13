@extends('admin.father.css')
@section('content')
<script type="text/javascript" src="{{asset('/admin/lib/hcharts/Highcharts/5.0.6/js/highcharts.js')}}"></script>
<script type="text/javascript" src="{{asset('/admin/lib/hcharts/Highcharts/5.0.6/js/modules/exporting.js')}}"></script>
<div style="margin:0px 45%;"><br/><a href="javascript:0;" id="hart" class="btn btn-primary radius"><i class="icon Hui-iconfont"></i> 选择单品</a></div><br/>
<div style="display: none" id="select-box">
	<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">品名：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="goods_name" id="goods_name" class="select">
					<option value="0">所有</option>
					@foreach($goods as $val)
					<option value="{{$val->goods_id}}" >{{$val->goods_name}}</option>
					@endforeach
				</select>
				</span> </div>
		</div>
</div>
<div id="ajaxtable">
	
</div>
@endsection
@section('js')
<script type="text/javascript">
	$(function(){
		get_ajaxtable(0);
	})
	function get_ajaxtable(id){
		$.ajax({
						url:"{{url('admin/vis/get_ajaxtable')}}",
						type:'post',
						data:{"id":id,"_token":"{{csrf_token()}}"},
						datatype:'json',
						success:function(msg){
							$('#ajaxtable').html(msg);
						}
				})
	}
</script>
@endsection