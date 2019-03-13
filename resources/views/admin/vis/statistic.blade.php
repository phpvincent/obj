@extends('admin.father.css')
<link rel="stylesheet" type="text/css" href="{{asset('/css/addgoods.css')}}" />
@section('content')
<script type="text/javascript" src="{{asset('/admin/lib/hcharts/Highcharts/5.0.6/js/highcharts.js')}}"></script>
<script type="text/javascript" src="{{asset('/admin/lib/hcharts/Highcharts/5.0.6/js/modules/exporting.js')}}"></script>
<!-- 时间选择 -->
<div class="text-c row"  style="margin:10px 0;overflow: hidden;height: 160px;" >
	<!-- 单品 -->
	<div id="select-box" class="col-xs-4" style="margin:10px 0;">
		<div class="row cl">
			<label class="form-label col-xs-2" style="text-align: right;">品名：</label>
			<div class="formControls col-xs-5"> <span class="select-box">
			<select name="goods_name" id="goods_name" class="select">
				<option value="0">所有</option>
				@foreach($goods_type as $val)
					<option value="{{$val->goods_type_id}}" >{{$val->goods_type_name}}</option>
				@endforeach
			</select>
			</span>
			</div>
			<div class="formControls col-xs-4">
				<input type="text" class="input-text chanpin" placeholder=""autocomplete="off" id="goods_kind_name"  oninput="xiala()" name="goods_kind_name" value="">
				<input type="text" style="display: none;" class="input-text chanpin"autocomplete="off" id="goods_kind" name="goods_kind" value="">
				<!--  <button type="button" class="btn btn-primary-outline radius" style="border-radius: 8%;" id="addgoods_kind" name=""><i class="Hui-iconfont"></i> </button> -->
				<div class="box" style="display: none;padding-right: 0px;">
					<ul>
					</ul>
				</div>
			</div>
			<div class="col-xs-1" id="loading" style="display: none">
				<img src="{{asset('/images/loading.gif')}}" style="width: 30px;height: 30px" alt="">
			</div>
		</div>
	</div>

	<div class="col-xs-4" style="padding-top: 12px;">
		日期范围：
		<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd', maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d %H:%m:%s\'}',minDate:'%y-%M-#{%d-6} '})" id="datemin" class="input-text Wdate" style="width:120px;">
		-
		<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd', minDate:'#F{$dp.$D(\'datemin\')||\'%y-%M-#{%d-6}\'}',maxDate:'%y-%M-%d %H:%m:%s' })" id="datemax" class="input-text Wdate" style="width:120px;">
		<!-- <input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name=""> -->
		<button type="submit" class="btn btn-success" id="seavis1" name=""><i class="Hui-iconfont">&#xe665;</i> 搜记录</button>
	</div>
	{{--&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success" style="border-radius: 8%;" id="outorder" name=""><i class="Hui-iconfont">&#xe640;</i> 数据导出</button>--}}
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
	.tu_1,.tu_2 {
		width: 47%;
		display: inline-block;
	}
	@media screen and (max-width: 970px){
		.tu_1,.tu_2 {
		 width: 100%;
	}
	}
</style>
<!-- <div class="qiehuan">
	<span class="a">分布图</span>
	<span>趋势图</span>
</div> -->
<div class="tu_1">
	<div id="container" style="width: 100%"></div>

</div>
<div class="tu_2">
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
        // $('.qiehuan span.a').css('border','1px solid #5284ec');
	    // $('.tu_2').hide();
        zhuzhuangtu(0);
		get_zhexian(0);
        get_ajaxtable(0);
		// $('.qiehuan span').on('click',function () {
        //     $('.qiehuan span').css('border','1px solid #e5e5e5');
        //     $(this).css('border','1px solid #5284ec');

		// 		var a=$(this).text();
		// 		if(a=='分布图'){
        //             $('.tu_1').show();
        //             $('.tu_2').hide();
        //         }else {
        //             $('.tu_1').hide();
        //             $('.tu_2').show();
		// 		}
        // })
    });
	$('#hart').on('click',function(){
		$('#select-box').toggle(300);
	})
	$('#hart').on('click',function(){
		$('.text-c').toggle(300);
	})
	$('#goods_name').on('change',function(){
        $('#goods_kind').val("");
        $('#goods_kind_name').val("");
	});
	//搜记录
	$('#seavis1').on('click',function(){
		var datemin = $('#datemin').val();
		var datemax = $('#datemax').val();
		var goods_name = $('#goods_kind').val();
		var goods_kind_name = $('#goods_kind_name').val();
		var user_name = $('#user_name').val();
		var goods_names = $('#goods_name').val();
		if(goods_kind_name && !goods_name){
            layer.msg('您选择的品名不存在');
			return false;
		}
		if(goods_names && !goods_kind_name){
            layer.msg('品名必须填写完整');
            return false;
		}
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
		var indexs=layer.load(2, {shade: [0.15, '#393D49']});
        var data = {};
        data.mintime = datemin;
        data.maxtime = datemax;
        data.id = goods_name;
        data.user_id = user_name;
        data._token = "{{csrf_token()}}";
        if((!datemin && datemax) || (datemin && !datemax)){
            layer.msg('搜索时间不能只选择一个');
            layer.close(indexs);
            return ;
        }
		$.ajax({
				url:"{{url('admin/vis/statistic')}}",
				type:'post',
				data:data,
				datatype:'json',
				success:function(msg){
					layer.close(indexs);
				   var data=msg.data;
				   /*console.log(eval('('+msg[0]['data']+')'));*/

				   for (var i = msg.data.length - 1; i >= 0; i--) {
					var result=[];
					for(var s in data[i]['data']){
						result.push(Number((data[i]['data'][s]*100).toFixed(4)))
					}
					data[i]['data']=result;

				   }
				   var datacount = msg.datacount;
                    for (var i = msg.datacount.length - 1; i >= 0; i--) {
                        var result=[];
                        for(var s in datacount[i]['data']){
                            result.push(Number((datacount[i]['data'][s]).toFixed(4)))
                        }
                        datacount[i]['data']=result;

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
					series: datacount
				})
			},
		})
	}

	// 柱状图
	function zhuzhuangtu(datemin,datemax,goods_name,user_name) {
		{{--var indexs=layer.load(2, {shade: [0.15, '#393D49']});--}}
        {{--var data = {};--}}
        {{--data.mintime = datemin;--}}
        {{--data.maxtime = datemax;--}}
        {{--data.id = goods_name;--}}
        {{--data.user_id = user_name;--}}
        {{--data._token = "{{csrf_token()}}";--}}
        {{--$.ajax({--}}
            {{--url:"{{url('admin/vis/statistic')}}",--}}
            {{--type:'post',--}}
            {{--data:data,--}}
            {{--datatype:'json',--}}
            {{--success:function(msg){--}}
				{{--layer.close(indexs);--}}
                {{--var data=msg.datacount;--}}
                {{--/*console.log(eval('('+msg[0]['data']+')'));*/--}}

                {{--for (var i = msg.datacount.length - 1; i >= 0; i--) {--}}
                    {{--var result=[];--}}
                    {{--for(var s in data[i]['data']){--}}
                        {{--result.push(data[i]['data'][s])--}}
                    {{--}--}}
                    {{--data[i]['data']=result;--}}

                {{--}--}}

            {{--},--}}
        {{--})--}}
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
	// 搜索下拉框
	$(".chanpin").focus(function(){
		$('.box').show(400);
        var goods_name = $('#goods_name').val();
		var a=$('.chanpin').val();
		$.ajax({
			//请求方式
			type:'GET',
			url:'{{url("admin/vis/get_goods_name")}}?name='+a+'&goods_name='+goods_name,
			dataType:'json',
			data:{},
			success:function(data){
				xialaCheck =false;
				var str='';
				jQuery.each(data.data,function(key,value){

                        str+='<li data-id='+value.goods_id + '>' + value.goods_real_name + '</li>'

				}) 
				$('.box ul').html(str);
			},
			error:function(jqXHR){

			}
		});
	});
	function xiala(){
		$('#goods_kind').val('');
		$('.box ul').empty();
		$('.box').show(400);
		$('#loading').show();
        var goods_name = $('#goods_name').val();
        var a=$('.chanpin').val();
		$.ajax({
			//请求方式
			type:'GET',
			url:'{{url("admin/vis/get_goods_name")}}?name='+a+'&goods_name='+goods_name,
			dataType:'json',
			data:{},
			success:function(data){
				var str='';
				if(data.data.length !=0 ){
                    $('#loading').hide();
                    jQuery.each(data.data,function(key,value){

                            str+='<li data-id='+value.goods_id + '>' + value.goods_real_name + '</li>'

					}) 
					$('.box ul').html(str);
				}else{
					$('.box ul').html('<span >没有相应产品</span>');
				}
			},
			error:function(jqXHR){

			}
		});
	}
	
	$('.chanpin').on('blur',function(){
		 $('.box').hide(400);
	});
	function chanbingCheck(){
		var Check=true;
		var a=$('.chanpin').val();
        var goods_name = $('#goods_name').val();
        $.ajax({
			type:'GET',
			url:'{{url("admin/vis/get_goods_name")}}?name='+a+'&goods_name='+goods_name,
			dataType:'json',
			async:false,
			data:{},
			success:function(data){

				jQuery.each(data,function(key,value){ 
					if(a==value.goods_kind_name){
						Check=false;
					} 
				});
				if(Check){
					var target_top = $("#goods_kind_name").offset().top;
					// $("html,body").animate({scrollTop: target_top}, 1000);  //带滑动效果的跳转
					$("html,body").scrollTop(target_top);
					setTimeout('layer.alert("此产品不存在,请选择产品！");',1200); 
				}
			},
			error:function(jqXHR){

			}
		});
		if(Check){
			return false;
		}else{
			return true;
		}
	}
	$('body').on('mousedown','.box li',function(){

		$('.box').hide(400);
		var content=$(this).text();
		var content_id=$(this).attr('data-id');
		$('.chanpin').val(content);
		$('#goods_kind').val(content_id);
		$('.box ul').empty();
	})
</script>
@endsection