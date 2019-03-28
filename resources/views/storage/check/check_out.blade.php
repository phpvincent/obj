@extends('storage.father.static')
@section('content')
<!-- <table border="1" class="layui-table"><tbody><tr><th style="width:70px;">下单时间</th><th style="width:70px;">订单编号</th><th style="width:70px;">客户名字</th><th style="width:70px;">客户电话</th><th style="width:70px;">详细地址</th><th style="width:70px;">地区</th><th style="width:70px;">城市</th><th style="width:70px;">邮寄地址</th><th style="width:70px;">邮政编码</th><th style="width:70px;">产品名称</th><th style="width:70px;">产品英文名称</th><th style="width:70px;">商品名</th><th style="width:70px;">币种</th><th style="width:70px;">总金额</th><th style="width:70px;">数量</th><th style="width:70px;">产品属性信息</th><th style="width:70px;">产品英文属性信息</th><th style="width:70px;">商品展示属性信息</th><th style="width:70px;">商品sku信息</th><th style="width:70px;">备注</th><th style="width:70px;">支付方式</th><th style="width:70px;">商品所属人</th></tr><tr style="height:50px;border-style:none;><th border=&quot;0&quot; style=" height:60px;width:270px;font-size:22px;'="" colspan="22"></tr><tr><td>2019-03-22 14:48:51</td><td>NR032214485178547819</td><td>1</td><td>1</td><td>宜蘭縣 宜蘭市 (1)</td><td>宜蘭縣</td><td>宜蘭市</td><td>1</td><td></td><td>豆豆鞋</td><td></td><td>狗皮膏</td><td>TWD</td><td>30.00</td><td>3</td><td><table border="1"><tbody><tr><td>2</td><td>灰色</td><td>36</td></tr><tr><td>1</td><td>黑色</td><td>40</td></tr></tbody></table></td><td>gray36,gray36,black40</td><td>灰色-36 ,灰色-36 ,黑色-40 </td><td><table border="1"><tbody><tr><td>1010100200</td><td><table><tbody><tr><td>#</td><td>2</td></tr></tbody></table></td></tr><tr><td>1010010600</td><td><table><tbody><tr><td>#</td><td>1</td></tr></tbody></table></td></tr></tbody></table></td><td>1</td><td>货到付款</td><td>Giannis Antetokounmpo</td></tr>
<tr><td>2019-03-20 19:26:56</td><td>NR032019265646298817</td><td>1</td><td>1</td><td>新北市 萬里區 (1)</td><td>新北市</td><td>萬里區</td><td>1</td><td></td><td>豆豆鞋</td><td></td><td>狗皮膏</td><td>TWD</td><td>30.00</td><td>3</td><td><table border="1"><tbody><tr><td>2</td><td>灰色</td><td>36</td></tr><tr><td>1</td><td>红色</td><td>37</td></tr></tbody></table></td><td>gray36,gray36,red37</td><td>灰色-36 ,灰色-36 ,红色-37 </td><td><table border="1"><tbody><tr><td>1010100200</td><td><table><tbody><tr><td>NR5224212321</td><td>2</td></tr></tbody></table></td></tr><tr><td>1010500300</td><td><table><tbody><tr><td>NR5224212321</td><td>1</td></tr></tbody></table></td></tr></tbody></table></td><td>1</td><td>货到付款</td><td>Giannis Antetokounmpo</td></tr>
<tr><td>2019-03-18 17:56:08</td><td>NR031817560850306530</td><td>1</td><td>1</td><td>屏東縣 屏東市 (1)</td><td>屏東縣</td><td>屏東市</td><td>1</td><td></td><td>豆豆鞋</td><td></td><td>狗皮膏</td><td>TWD</td><td>20.00</td><td>2</td><td><table border="1"><tbody><tr><td>2</td><td>灰色</td><td>36</td></tr></tbody></table></td><td>gray36,gray36</td><td>灰色-36 ,灰色-36 </td><td><table border="1"><tbody><tr><td>1010100200</td><td><table><tbody><tr><td>NR8641892312</td><td>1</td></tr><tr><td>NR5224212321</td><td>1</td></tr></tbody></table></td></tr></tbody></table></td><td>1</td><td>货到付款</td><td>Giannis Antetokounmpo</td></tr>
<tr><td>2019-03-18 17:34:46</td><td>NR031817344669481518</td><td>1</td><td>1</td><td>屏東縣 屏東市 (1)</td><td>屏東縣</td><td>屏東市</td><td>1</td><td></td><td>豆豆鞋</td><td></td><td>狗皮膏</td><td>TWD</td><td>30.00</td><td>8</td><td><table border="1"><tbody><tr><td>8</td><td>灰色</td><td>36</td></tr></tbody></table></td><td>gray36,gray36,gray36,gray36,gray36,gray36,gray36,gray36</td><td>灰色-36 ,灰色-36 ,灰色-36 ,灰色-36 ,灰色-36 ,灰色-36 ,灰色-36 ,灰色-36 </td><td><table border="1"><tbody><tr><td>1010100200</td><td><table><tbody><tr><td>#</td><td>6</td></tr></tbody></table></td></tr></tbody></table></td><td>1</td><td>货到付款</td><td>Giannis Antetokounmpo</td></tr>
</tbody></table> -->
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
			  		<th rowspan="{{$storage_check_data->count()+1}}">扣货信息</th>
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
			  		<th rowspan="{{$storage_check_data->count()+1}}">扣货信息</th>
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
			  		<th rowspan="{{$storage_check_data->count()+1}}">扣货信息</th>
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