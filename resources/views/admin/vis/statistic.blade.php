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
<div id="container"></div>
<div id="container-b"></div>
@endsection
@section('js')
<script type="text/javascript">
	$(function () {
		get_zhexian(0);
		getbin(0);
});
	$('#hart').on('click',function(){
		$('#select-box').show(300);
	})
	$('#goods_name').on('change',function(){
		var val=$(this).val();
		get_zhexian(val);
		getbin(val);
	})
	function get_zhexian(id){
				$.ajax({
						url:"{{url('admin/vis/statistic')}}",
						type:'post',
						data:{"id":id,"_token":"{{csrf_token()}}"},
						datatype:'json',
						success:function(msg){
				           var data=msg;
				           /*console.log(eval('('+msg[0]['data']+')'));*/
				           
				           for (var i = msg.length - 1; i >= 0; i--) {
				           	var result=[];
				           	for(var s in data[i]['data']){
				           		result.push(data[i]['data'][s]*100)
				           	}
				           	data[i]['data']=result;
				           	
				           }
				           Highcharts.chart('container', {
					        title: {
					            text: '七天内转化率数据统计',
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
					                text: '转化率 (%)'
					            },
					            plotLines: [{
					                value: 0,
					                width: 1,
					                color: '#000'
					            }],
					            max:100,
					            min:0,
					        },
					        tooltip: {
					            valueSuffix: '%'
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
	function getbin(id){
		$.ajax({
						url:"{{url('admin/vis/statistic_b')}}",
						type:'post',
						data:{"id":id,"_token":"{{csrf_token()}}"},
						datatype:'json',
						success:function(msg){
			/*				console.log(msg);*/
							var chart = {
					       plotBackgroundColor: null,
					       plotBorderWidth: null,
					       plotShadow: false
							   };
							   var title = {
							      text: '七天内分布'   
							   };      
							   var tooltip = {
							      pointFormat: '{series.name}: <b>{point.y}</b>'
							   };
							   var plotOptions = {
							      pie: {
							         allowPointSelect: true,
							         cursor: 'pointer',
							         dataLabels: {
							            enabled: true,
							            format: '<b>{point.name}</b>: {point.y} ',
							            style: {
							               color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
							            }
							         }
							      }
							   };
							   var series= [{
							      type: 'pie',
							      name: '人数',
							      data:msg,
							   }];     
							      
							   var json = {};   
							   json.chart = chart; 
							   json.title = title;     
							   json.tooltip = tooltip;  
							   json.series = series;
							   json.plotOptions = plotOptions;
							      Highcharts.chart('container-b',json);
						}
				});
		
		  // $('#container-b').highcharts(json);  
	}
</script>
@endsection