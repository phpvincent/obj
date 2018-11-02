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
					<option value="{{$val->goods_id}}" >{{$val->goods_real_name}}</option>
					@endforeach
				</select>
				</span> </div>
		</div>
</div>
<div id="ajaxtable">
	
</div>
<br>
<hr>
<div id="highchart"></div>
@endsection
@section('js')
<script type="text/javascript">
	$(function(){
		get_ajaxtable(0);
		get_zxtu(0);
	})
	$('#goods_name').on('change',function(){
		var val=$(this).val();
		get_ajaxtable(val);
		get_zxtu(val);
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
	$('#hart').on('click',function(){
		$('#select-box').toggle(300);
	})
	function get_zxtu(id){
			$.ajax({
						url:"{{url('admin/vis/get_zxtu')}}",
						type:'post',
						data:{"id":id,"_token":"{{csrf_token()}}"},
						datatype:'json',
						success:function(msg){
				           var data=msg['data'];
				           /*console.log(eval('('+msg[0]['data']+')'));*/
				           
				           for (var i = data.length - 1; i >= 0; i--) {
				           	var result=[];
				           	for(var s in data[i]['data']){
				           		result.push(data[i]['data'][s])
				           	}
				           	data[i]['data']=result;
				           	
				           }
				           Highcharts.chart('highchart', {
					        title: {
					            text: '七天内浏览记录',
					            x: -20 //center
					        },
					        subtitle: {
					            text: 'Source: phpvincent',
					            x: -20
					        },
					        xAxis: {
					            categories: ['今日', '一天前', '两天前', '三天前', '四天前', '五天前','六天前', '七天前']
					        },
					        yAxis: {
					            title: {
					                text: '人数'
					            },
					            plotLines: [{
					                value: 0,
					                width: 1,
					                color: '#000'
					            }],
					            max:msg['max'],
					            min:0,
					        },
					        tooltip: {
					            valueSuffix: ''
					        },
					        legend: {
					            layout: 'vertical',
					            align: 'right',
					            verticalAlign: 'middle',
					            borderWidth: 0
					        },
					        series: data,
					    });
					},
			})
	}
</script>
@endsection