@extends('admin.father.css')
@section('content')

<!-- <link rel="stylesheet" type="text/css" href="{{asset('/admin/static/fixedColumns.dataTables.min.css')}}" /> -->
<link rel="stylesheet" type="text/css" href="{{asset('/admin/static/jquery.dataTables.min.css')}}" />
<script type="text/javascript" src="{{asset('/admin/lib/jquery/jquery-3.3.1.js')}}"></script> 
<style>
 #order_index_table_wrapper .dataTables_scroll .dataTables_scrollHead table thead th{
	border-left: none;   
 }
</style>
<!-- 上面样式解决dataTable;border-left错开BUG -->
<div class="page-container">
		<div class="text-c"> 日期范围：
		<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d %H:%m:%s\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
		-
		<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d %H:%m:%s' })" id="datemax" class="input-text Wdate" style="width:120px;">

		<!-- <input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name=""> -->
		<button type="submit" class="btn btn-success" id="seavis1" name=""><i class="Hui-iconfont">&#xe665;</i> 搜记录</button><br><span style="color:red;">默认统计当日数据，如需查看其他日期请设定日期范围</span>
		&nbsp;&nbsp;&nbsp;<!-- <button type="submit" class="btn btn-success" style="border-radius: 8%;" id="outorder" name=""><i class="Hui-iconfont">&#xe640;</i> 数据导出</button> -->
	</div>
	
	<!-- <div style="margin:0px 45%;"><br/><a href="javascript:0;" id="getadmin" class="btn btn-primary radius"><i class="icon Hui-iconfont"></i> 筛选</a></div> --><br/>
	<!-- <div style="display: none" id="select-admin">
		
		<div class="row cl">
			<label class="form-label col-xs-1 col-sm-1">订单核审状态：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="order_type" id="order_type" class="select">
					<option value="#">所有</option>
					<option value="0">未核审</option>
					<option value="1">通过核审</option>
					<option value="2">拒绝核审</option>
					<option value="3">已发货</option>
					<option value="4">已签收</option>
					<option value="5">退货未退款</option>
					<option value="6">退货并已退款</option>
					<option value="7">未退货已退款</option>
					<option value="8">拒签</option>
				</select>
				</span>
			</div>
		</div>
		
	</div> -->
	
	<div class="cl pd-5 bg-1 bk-gray mt-20">  <span class="r">共有数据：<strong>{{$counts}}</strong> 条</span><br> </div>
	<table class="table table-border table-bordered table-bg" id="order_count_table">
		<thead>
			<tr>
				<th scope="col" colspan="9">订单统计</th>
			</tr>
			<tr class="text-c">
 				<th width="10%">单品id</th>
 				<th width="10%">单品展示名</th>
 				<th width="10%">单数</th>
 				<th width="10%">有效单数</th>
 				<th width="10%">销售额(元)</th>
				<th width="10%">货到付款单数</th>
				<th width="10%">在线支付单数</th>
				<th width="10%">所属人员</th>
				<th width="20%">单品发布时间</th>
			</tr>
		</thead>
		<tbody>
<!-- 			<tr class="text-c">
				<td><input type="checkbox" value="1" name=""></td>
				<td>1</td>
				<td>admin</td>
				<td>13000000000</td>
				<td>admin@mail.com</td>
				<td>超级管理员</td>
				<td>2014-6-11 11:11:42</td>
				<td class="td-status"><span class="label label-success radius">已启用</span></td>
				<td class="td-manage"><a style="text-decoration:none" onClick="admin_stop(this,'10001')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a> <a title="编辑" href="javascript:;" onclick="admin_edit('管理员编辑','admin-add.html','1','800','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
			</tr> -->
		</tbody>
	</table>
</div>
<!-- <div style="width: 200px;height: 150px;position: absolute;margin-top:20px;z-index: 1000;top:0;right: 0;">
	<div>
		<div style="width: 20px;height: 20px;background-color:#FFE4E1;display: inline-block;"></div>
		<div style="display:inline;">ip重复</div>
	</div>
	<div>
		<div style="width: 20px;height: 20px;background-color:#CAE1FF;display: inline-block;"></div>
		<div style="display:inline;">姓名重复</div>
	</div>
	<div>
		<div style="width: 20px;height: 20px;background-color:#00cc66;display: inline-block;"></div>
		<div style="display:inline;">电话重复</div>
	</div>
	</div>
<div style="width: 200px;height: 150px;position: absolute;margin-top:20px;z-index: 1000;top:0;right: 200px;">
	<div>
		<div style="width: 20px;height: 20px;background-color:#d7dde4;display: inline-block;"></div>
		<div style="display:inline;">ip、姓名</div>
	</div>
	<div>
		<div style="width: 20px;height: 20px;background-color:#ff9900;display: inline-block;"></div>
		<div style="display:inline;">ip、电话重复</div>
	</div>
	<div>
		<div style="width: 20px;height: 20px;background-color:#FFE4C4;display: inline-block;"></div>
		<div style="display:inline;">姓名、电话重复</div>
	</div>
	<div>
		<div style="width: 20px;height: 20px;background-color:#FFFACD;display: inline-block;"></div>
		<div style="display:inline;">ip、姓名、电话重复</div>
	</div>
</div>
</div> -->
@endsection
@section('js')

<script type="text/javascript">
	$.tablesetting={
	"lengthMenu": [[20,30],[20,30]],//每页显示条数
		"paging": true,					//是否分页。
		"info":   true,					//页脚信息
		"searching": true,				//搜索
		"ordering": true,
		"order": [[ 2, "desc" ]],
		"stateSave": false,
		"columnDefs": [{
		   "targets": [0,1,3,4,5,6,7],
		   "orderable": false
		}],
	/*	scrollX:        true,
        scrollCollapse: true,
        fixedColumns:   {
            leftColumns: 3,
            rightColumns: 1
        },
        此处因列数没有那么多，不用添加滑动条
        */
		"processing": true,
		"serverSide": true,
		"ajax": {
		"data":{
			mintime:function(){return $('#datemin').val()},
			maxtime:function(){return $('#datemax').val()},
        },
		"url": "{{url('admin/order/count')}}",
		"type": "POST",
		'headers': { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
		},
		"columns": [
		{"data":'goods_id'},
		{"data":'goods_name'},
		{'data':'order_counts'},
		{'data':'order_real_counts'},
		{'data':'day_sales'},
		{'data':'order_hdfk_counts'},
		{'data':'order_zxzf_counts'},
		{'data':'admin_show_name'},
		{'data':'goods_up_time'},
		],
        //每行回调函数
       
        "createdRow":function(row,data,dataIndex){
			
			
		}
	}
 dataTable =$('#order_count_table').DataTable($.tablesetting);
$('#seavis1').on('click',function(){
	               			 $('#order_count_table').dataTable().fnClearTable(); 

})
function del_order(id){
		var msg =confirm("确定要删除此订单吗？");
		if(msg){
        		layer.msg('删除中');
        			$.ajax({
					url:"{{url('admin/order/delorder')}}",
					type:'get',
					data:{'id':id},
					datatype:'json',
					success:function(msg){
			           if(msg['err']==1){
			           	 layer.msg(msg.str);
			           	 /*$(".del"+id).prev("input").remove();
        				 $(".del"+id).val('已删除');*/
        				 /*dataTable.fnDestroy(false);
               			 dataTable = $("#goods_index_table").dataTable($.tablesetting);*/
               			 //搜索后跳转到第一页
               			 //dataTable.fnPageChange(0);
               			 $('#order_index_table').dataTable().fnClearTable(); 
			           }else if(msg['err']==0){
			           	 layer.msg(msg.str);
			           }else{
			           	 layer.msg('删除失败！');
			           }
					}
				})
        	}else{
                
        	}
	}
function order_returninfo(id){
	layer_show('订单信息','/admin/order/orderinfo?id='+id,500,300);
}
function goods_edit(title,url,type,w,h){
	layer_show(title,url,w,h);
}
function order_up(title,url,type,w,h){
	var b='';
	var a=$('input[type="checkbox"]:checked');
	if(a.length<=0){
		layer.msg('无选中项');
		return false;
	}
	for (var i = a.length - 1; i >= 0; i--) {
		if(a[i].value!=''&&a[i].value!=null){
					b+=a[i].value+',';
		}
	}
	url=url+'&id='+b;
	layer_show(title,url,w,h);
}
$('#outorder').on('click',function(){
	var mintime=$('#datemin').val();
	var maxtime=$('#datemax').val();
	if(mintime==''&&maxtime==''){
		layer.msg('请稍等');
     location.href='{{url("admin/order/outorder")}}';
	}else if(mintime==''||maxtime==''){
		layer.msg('请选择正确日期区间');
	}else{
		layer.msg('请稍等');
		location.href='{{url("admin/order/outorder")}}?min='+mintime+'&max='+maxtime;
	}
})
function pl_del(){
	var msg =confirm("确定要批量删除这些订单吗？");
	if(!msg){
		return false;
	}
	var b=[];
	var a=$('input[type="checkbox"]:checked');
	if(a.length<=0){
		layer.msg('无选中项');
		return false;
	}
	for (var i = a.length - 1; i >= 0; i--) {
		if(a[i].value!=''&&a[i].value!=null){
					b.push(a[i].value);
		}
	}
	layer.msg('删除中，请稍等!');
	$.ajax({
					url:"{{url('admin/order/delorder')}}",
					type:'get',
					data:{'id':b,'type':'all'},
					datatype:'json',
					success:function(msg){
			           if(msg['err']==1){
			           	 layer.msg(msg.str);
               			 $('#order_index_table').dataTable().fnClearTable(); 
			           }else if(msg['err']==0){
			           	 layer.msg(msg.str);
			           }else{
			           	 layer.msg('删除失败！');
			           }
					}
				})


}
function pl_update(){
	var msg =confirm("确定要批量核审这些订单吗？");
	if(!msg){
		return false;
	}
	var b=[];
	var a=$('input[type="checkbox"]:checked');
	if(a.length<=0){
		layer.msg('无选中项');
		return false;
	}
	for (var i = a.length - 1; i >= 0; i--) {
		if(a[i].value!=null){
					b.push(a[i].value);
		}
	}
	layer.msg('核审中，请稍等!');
	$.ajax({
					url:"{{url('admin/order/heshen')}}",
					type:'get',
					data:{'id':b,'type':'all'},
					datatype:'json',
					success:function(msg){
			           if(msg['err']==1){
			           	 layer.msg(msg.str);
               			 $('#order_index_table').dataTable().fnClearTable(); 
			           }else if(msg['err']==0){
			           	 layer.msg(msg.str);
			           }else{
			           	 layer.msg('核审失败！');
			           }
					}
				})


}
function goods_getaddr(title,url,type,w,h){
	layer_show(title,url,w,h);
}
$('#getadmin').on('click',function(){
	$('#select-admin').toggle(300);
})
$('#admin_name').on('change',function(){
	dataTable.ajax.reload();
	var args = dataTable.ajax.params();
})
$('#order_type').on('change',function(){
	dataTable.ajax.reload();
	
})
$('#order_repeat_ip').on('change',function(){
	dataTable.ajax.reload();
	
})
$('#order_repeat_name').on('change',function(){
	dataTable.ajax.reload();
})
$('#pay_type').on('change',function(){
     dataTable.ajax.reload();
})
//根据语言进行搜索
$('#languages').on('change',function(){
     dataTable.ajax.reload();
})
$('#order_repeat_tel').on('change',function(){
	dataTable.ajax.reload();
	
})
var allcheckedflag=true;
$("body").on("click",".allchecked",function(){
    if(allcheckedflag){
		$("div.DTFC_LeftWrapper :checkbox").prop("checked", true);
		allcheckedflag=false;
	}else{
		$("div.DTFC_LeftWrapper :checkbox").prop("checked", false);
		allcheckedflag=true;
	}
	
})
</script>

@endsection