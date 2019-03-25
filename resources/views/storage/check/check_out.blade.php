@extends('storage.father.static')
@section('content')
 @if($storage_check_data==null||count($storage_check_data)<=0)
 	<blockquote class="layui-elem-quote">暂无数据</blockquote>
 @else
	@if($storage_check_data[0]->storage_check_data_type==1)
	<fieldset class="layui-elem-field">
        <legend>从海外仓拆分发货</legend>
        <div class="layui-field-box">
        	<blockquote class="layui-elem-quote">总数目：{{$storage_check_data[0]->storage_check_data_num}}</blockquote>
        	<blockquote class="layui-elem-quote">产品sku：{{$storage_check_data[0]->storage_check_data_sku}}</blockquote>
        	<blockquote class="layui-elem-quote">订单编号：{{\App\order::where('order_id',$storage_check_data[0]->storage_check_data_order)->first(['order_single_id'])['order_single_id']}}</blockquote>
        	<blockquote class="layui-elem-quote">校准单编号：{{\App\storage_check::where('storage_check_id',$storage_check_data[0]->storage_primary_id)->first(['storage_check_string'])['storage_check_string']}}</blockquote>
        	<blockquote class="layui-elem-quote" style="color:brown">仓库：{{\App\storage::where('storage_id',$storage_check_data[0]->storage_abroad_id)->first(['storage_name'])['storage_name']}}(海外仓)</blockquote>
					<a download="扣货信息表.xls" id="excelOut" href="#" style="height: 20px;width: 100%;display: block;"><div class="layui-inline" title="导出" lay-event="LAYTABLE_EXPORT" style="float: right;"><i class="layui-icon layui-icon-export"></i></div></a>
					<table class="layui-table"id="tableExcel" lay-filter="test">
			  <thead>
			  	<tr>
			  		<th rowspan="3">扣货信息</th>
			  	</tr>
			  	@foreach($storage_check_data as $k => $v)
				    <tr>
				      <td>订单id:{{$v->storage_check_info_order}}</td>
				      <td>订单编号:{{$v->storage_check_info_single}}</td>
				      <td>数量:{{$v->storage_check_info_num}}</td>
				      <td>属性sku:{{$v->storage_check_info_sku}}</td>
				    </tr>
			    @endforeach
			  </thead>
		  </table>
        </div>
      </fieldset>
    @elseif($storage_check_data[0]->storage_check_data_type==2)
    <fieldset class="layui-elem-field">
        <legend>从海外仓不拆分发货</legend>
        <div class="layui-field-box">
          <blockquote class="layui-elem-quote">总数目：{{$storage_check_data[0]->storage_check_data_num}}</blockquote>
        	<blockquote class="layui-elem-quote">产品sku：{{$storage_check_data[0]->storage_check_data_sku}}</blockquote>
        	<blockquote class="layui-elem-quote">订单编号：{{\App\order::where('order_id',$storage_check_data[0]->storage_check_data_order)->first(['order_single_id'])['order_single_id']}}</blockquote>
        	<blockquote class="layui-elem-quote">校准单编号：{{\App\storage_check::where('storage_check_id',$storage_check_data[0]->storage_primary_id)->first(['storage_check_string'])['storage_check_string']}}</blockquote>
        	<blockquote class="layui-elem-quote" style="color:brown">仓库：{{\App\storage::where('storage_id',$storage_check_data[0]->storage_abroad_id)->first(['storage_name'])['storage_name']}}(海外仓)</blockquote>
					<a download="扣货信息表.xls" id="excelOut" href="#" style="height: 20px;width: 100%;display: block;"><div class="layui-inline" title="导出" lay-event="LAYTABLE_EXPORT" style="float: right;"><i class="layui-icon layui-icon-export"></i></div></a> 
					<table class="layui-table"id="tableExcel" lay-filter="test">
			  <thead>
			  	<tr>
			  		<th rowspan="3">扣货信息</th>
			  	</tr>
			  	@foreach($storage_check_data as $k => $v)
				    <tr>
				      <td>订单id:{{$v->storage_check_info_order}}</td>
				      <td>订单编号:{{$v->storage_check_info_single}}</td>
				      <td>数量:{{$v->storage_check_info_num}}</td>
				      <td>属性sku:{{$v->storage_check_info_sku}}</td>
				    </tr>
			    @endforeach
			  </thead>
		  </table>
        </div>
      </fieldset>
   @elseif($storage_check_data[0]->storage_check_data_type==3)
	<fieldset class="layui-elem-field">
	    <legend>从本地仓发货</legend>
	    <div class="layui-field-box">
	      <blockquote class="layui-elem-quote">总数目：{{$storage_check_data[0]->storage_check_data_num}}</blockquote>
        	<blockquote class="layui-elem-quote">产品sku：{{$storage_check_data[0]->storage_check_data_sku}}</blockquote>
        	<blockquote class="layui-elem-quote">订单编号：{{\App\order::where('order_id',$storage_check_data[0]->storage_check_data_order)->first(['order_single_id'])['order_single_id']}}</blockquote>
        	<blockquote class="layui-elem-quote">校准单编号：{{\App\storage_check::where('storage_check_id',$storage_check_data[0]->storage_primary_id)->first(['storage_check_string'])['storage_check_string']}}</blockquote>
        	<blockquote class="layui-elem-quote" style="color:green">仓库：{{\App\storage::where('storage_id',$storage_check_data[0]->storage_abroad_id)->first(['storage_name'])['storage_name']}}(本地仓)</blockquote>
					<a download="扣货信息表.xls" id="excelOut" href="#" style="height: 20px;width: 100%;display: block;"><div class="layui-inline" title="导出" lay-event="LAYTABLE_EXPORT" style="float: right;"><i class="layui-icon layui-icon-export"></i></div></a>
				<table  id="tableExcel" class="layui-table" lay-filter="test">
			  <thead>
			  	<tr>
			  		<th rowspan="3">扣货信息</th>
			  	</tr>
			  	@foreach($storage_check_data as $k => $v)
				    <tr>
				      <td>订单id:本地仓</td>
				      <td>订单编号:本地仓</td>
				      <td>数量:{{$v->storage_check_info_num}}</td>
				      <td>属性sku:{{$v->storage_check_info_sku}}</td>
				    </tr>
			    @endforeach
			  </thead>
		  </table>
	    </div>
	  </fieldset>
  @endif
@endif
@endsection
@section('js')
<script>
window.onload = function () {
        tableToExcel('tableExcel', '下载模板')
    };
    //base64转码
    var base64 = function (s) {
        return window.btoa(unescape(encodeURIComponent(s)));
    };
    //替换table数据和worksheet名字
    var format = function (s, c) {
        return s.replace(/{(\w+)}/g,
            function (m, p) {
                return c[p];
            });
    }
    function tableToExcel(tableid, sheetName) {
        var uri = 'data:application/vnd.ms-excel;base64,';
        var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel"' +
            'xmlns="http://www.w3.org/TR/REC-html40"><meta charset="utf-8" /><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'
            + '<x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets>'
            + '</x:ExcelWorkbook></xml><![endif]-->' +
            '</head><body ><table class="excelTable">{table}</table></body></html>';
        if (!tableid.nodeType) tableid = document.getElementById(tableid);
        var ctx = {worksheet: sheetName || 'Worksheet', table: tableid.innerHTML};
        document.getElementById("excelOut").href = uri + base64(format(template, ctx));
    }

</script>
@endsection