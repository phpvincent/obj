@extends('admin.father.css')
@section('content')
<script type="text/javascript" src="{{asset('/admin/lib/hcharts/Highcharts/5.0.6/js/highcharts.js')}}"></script>
<script type="text/javascript" src="{{asset('/admin/lib/hcharts/Highcharts/5.0.6/js/modules/exporting.js')}}"></script>
<!-- 时间选择 -->
<div class="text-c"style="margin:10px 0;overflow: hidden" > 日期范围：
	<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd', maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d %H:%m:%s\'}',minDate:'%y-%M-#{%d-40} '})" id="datemin" class="input-text Wdate" style="width:120px;">
	-
	<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd', minDate:'#F{$dp.$D(\'datemin\')||\'%y-%M-#{%d-40}\'}',maxDate:'%y-%M-%d %H:%m:%s' })" id="datemax" class="input-text Wdate" style="width:120px;">
	<!-- <input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name=""> -->
	<button type="submit" class="btn btn-success" id="seavis1" name=""><i class="Hui-iconfont">&#xe665;</i> 搜记录</button>
	&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success" style="border-radius: 8%;" id="outorder" name=""><i class="Hui-iconfont">&#xe640;</i> 数据导出</button>
</div>
<!-- 单品 -->
<div id="select-box"style="margin:10px 0;overflow: hidden">
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2" style="text-align: right;">品名：</label>
		<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="goods_name" id="goods_name" class="select">
					<option value="0">所有</option>
					@foreach($goods as $val)
<<<<<<< HEAD
						<option value="{{$val->goods_id}}" >{{$val->goods_real_name}}</option>
=======
					<option value="{{$val->goods_id}}" >{{$val->goods_real_name}}</option>
>>>>>>> 757600c5d6f2ebfcc7a5d5785bdefef71543a914
					@endforeach
				</select>
				</span> </div>
	</div>
</div>
<!-- 账号 -->
<div id="select-box"style="margin:10px 0;overflow: hidden">
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2"style="text-align: right;">账号：</label>
		<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="user_name" id="user_name" class="select">
					<option value="0">所有</option>
					@foreach($admins as $val)
						<option value="{{$val->admin_id}}" >{{$val->admin_name}}</option>
					@endforeach
				</select>
				</span> </div>
	</div>
</div>
<style>
	.qiehuan span{
		display: inline-block;
		padding: 8px 16px;
		margin: 0 20px;
		cursor:pointer;
		border:1px solid #e5e5e5;
		border-radius: 8px;
		color: #999;
	}
</style>
<div class="qiehuan">
	<span class="a">分布图</span>
	<span>趋势图</span>
</div>
<div class="tu_1" style="width: 100%">
	<div id="container" style="width: 100%"></div>

</div>
<div class="tu_2" style="width: 100%">
	<div id="container_1" style="width: 100%"></div>

</div>

<br/>
<br/>
<br/>
<div id="ajaxtable" style="width: 100%;overflow-x: auto;">

</div>

@endsection
@section('js')
<script type="text/javascript">
	$(function () {
        $('.qiehuan span.a').css('border','1px solid #5284ec');
	    $('.tu_2').hide();
        zhuzhuangtu(0);
		get_zhexian(0);
        get_ajaxtable(0);
		$('.qiehuan span').on('click',function () {
            $('.qiehuan span').css('border','1px solid #e5e5e5');
            $(this).css('border','1px solid #5284ec');

				var a=$(this).text();
				if(a=='分布图'){

                    $('.tu_1').show();
                    $('.tu_2').hide();

                }else {
                    $('.tu_1').hide();
                    $('.tu_2').show();
				}
        })
    });
	$('#hart').on('click',function(){
		$('#select-box').toggle(300);
	})
	$('#hart').on('click',function(){
		$('.text-c').toggle(300);
	})
	$('#goods_name').on('change',function(){
        var datemin = $('#datemin').val();
        var datemax = $('#datemax').val();
        var goods_name = $('#goods_name').val();
        var user_name = $('#user_name').val();
		get_zhexian(datemin,datemax,goods_name,user_name);
        get_ajaxtable(datemin,datemax,goods_name,user_name);
        zhuzhuangtu(datemin,datemax,goods_name,user_name);
	});
	$('#seavis1').on('click',function(){
		var datemin = $('#datemin').val();
		var datemax = $('#datemax').val();
		var goods_name = $('#goods_name').val();
		var user_name = $('#user_name').val();
		get_zhexian(datemin,datemax,goods_name,user_name);
        get_ajaxtable(datemin,datemax,goods_name,user_name);
        zhuzhuangtu(datemin,datemax,goods_name,user_name);
	});
	$('#user_name').on('change',function(){
        var datemin = $('#datemin').val();
        var datemax = $('#datemax').val();
        var goods_name = $('#goods_name').val();
        var user_name = $('#user_name').val();
		get_zhexian(datemin,datemax,goods_name,user_name);
        get_ajaxtable(datemin,datemax,goods_name,user_name);
        zhuzhuangtu(datemin,datemax,goods_name,user_name);
	});
    function get_ajaxtable(datemin,datemax,goods_name,user_name){
        var data = {};
        data.mintime = datemin;
        data.maxtime = datemax;
        data.id = goods_name;
        data.user_id = user_name;
        data._token = "{{csrf_token()}}";
        $.ajax({
            url:"{{url('admin/vis/get_table')}}",
            type:'post',
            data:data,
            datatype:'json',
            success:function(msg){
                $('#ajaxtable').html(msg);
            }
        })
    }
	function get_zhexian(datemin,datemax,goods_name,user_name){
        var data = {};
        data.mintime = datemin;
        data.maxtime = datemax;
        data.id = goods_name;
        data.user_id = user_name;
        data._token = "{{csrf_token()}}";
		$.ajax({
				url:"{{url('admin/vis/statistic')}}",
				type:'post',
				data:data,
				datatype:'json',
				success:function(msg){
				   var data=msg.data;
				   /*console.log(eval('('+msg[0]['data']+')'));*/

				   for (var i = msg.data.length - 1; i >= 0; i--) {
					var result=[];
					for(var s in data[i]['data']){
						result.push(data[i]['data'][s]*100)
					}
					data[i]['data']=result;

				   }
				   Highcharts.chart('container', {
					title: {
						text: '浏览状态趋势图',
						x: -20 //center
					},
				   lang: {
					   printChart: '打印图表',
					   downloadPNG: '下载JPEG 图片',
					   downloadJPEG: '下载JPEG文档',
					   downloadPDF: '下载PDF 文件',
					   downloadSVG: '下载SVG 矢量图'
				   },
					subtitle: {
						text: 'Source: phpvincent',
						x: -20
					},
				   credits: {
					   text: '一代宗师海外事业部'
				   },
					xAxis: {
						categories: msg.time
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

	// 柱状图
	function zhuzhuangtu(datemin,datemax,goods_name,user_name) {
        var data = {};
        data.mintime = datemin;
        data.maxtime = datemax;
        data.id = goods_name;
        data.user_id = user_name;
        data._token = "{{csrf_token()}}";
        $.ajax({
            url:"{{url('admin/vis/statistic')}}",
            type:'post',
            data:data,
            datatype:'json',
            success:function(msg){
                var data=msg.datacount;
                /*console.log(eval('('+msg[0]['data']+')'));*/

                for (var i = msg.datacount.length - 1; i >= 0; i--) {
                    var result=[];
                    for(var s in data[i]['data']){
                        result.push(data[i]['data'][s]*100)
                    }
                    data[i]['data']=result;

                }
                Highcharts.chart('container_1',{
                    chart: {
                        type: 'column'
                    },
                    lang: {
                        printChart: '打印图表',
                        downloadPNG: '下载JPEG 图片',
                        downloadJPEG: '下载JPEG文档',
                        downloadPDF: '下载PDF 文件',
                        downloadSVG: '下载SVG 矢量图'
                    },
                    credits: {
                        text: '一代宗师海外事业部'
                    },
                    title: {
                                text: '浏览状态分布图'
                             },
                    xAxis: {
                        categories: msg.time
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: '次数'
                        },
                        labels: {
                            formatter: function () {
                                return this.value;
                            }
                        },
                        opposite: false //反转
                    },
                    legend: { //是否显示底注
                        enabled: true
                    },
                    tooltip: {
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: data
                })
            },
        })
    }
	{{--function getbin(id){--}}
		{{--$.ajax({--}}
						{{--url:"{{url('admin/vis/statistic_b')}}",--}}
						{{--type:'post',--}}
						{{--data:{"id":id,"_token":"{{csrf_token()}}"},--}}
						{{--datatype:'json',--}}
						{{--success:function(msg){--}}
			{{--/*				console.log(msg);*/--}}
							{{--var chart = {--}}
					       {{--plotBackgroundColor: null,--}}
					       {{--plotBorderWidth: null,--}}
					       {{--plotShadow: false--}}
							   {{--};--}}
							   {{--var title = {--}}
							      {{--text: '七天内分布'--}}
							   {{--};--}}
							   {{--var tooltip = {--}}
							      {{--pointFormat: '{series.name}: <b>{point.y}</b>'--}}
							   {{--};--}}
							   {{--var plotOptions = {--}}
							      {{--pie: {--}}
							         {{--allowPointSelect: true,--}}
							         {{--cursor: 'pointer',--}}
							         {{--dataLabels: {--}}
							            {{--enabled: true,--}}
							            {{--format: '<b>{point.name}</b>: {point.y} ',--}}
							            {{--style: {--}}
							               {{--color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'--}}
							            {{--}--}}
							         {{--}--}}
							      {{--}--}}
							   {{--};--}}
							   {{--var series= [{--}}
							      {{--type: 'pie',--}}
							      {{--name: '人数',--}}
							      {{--data:msg,--}}
							   {{--}];--}}

							   {{--var json = {};--}}
							   {{--json.chart = chart;--}}
							   {{--json.title = title;--}}
							   {{--json.tooltip = tooltip;--}}
							   {{--json.series = series;--}}
							   {{--json.plotOptions = plotOptions;--}}
							      {{--Highcharts.chart('container-b',json);--}}
						{{--}--}}
				{{--});--}}

		  {{--// $('#container-b').highcharts(json);--}}
	{{--}--}}
</script>
@endsection