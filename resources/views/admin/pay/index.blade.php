@extends('admin.father.css')
@section('content')
<div class="page-container">
		<div class="text-c"> 日期范围：
		<input type="text" onfocus="WdatePicker({onpicking:function(dq){selectDatediff(dq.cal.getNewDateStr());},specialDates:['2018-09-21','2018-09-23','2018-09-26','2018-09-27'], dateFmt:'yyyy-MM-dd HH:mm:ss', maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d %H:%m:%s\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
		-
		<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d %H:%m:%s' })" id="datemax" class="input-text Wdate" style="width:120px;">
		<button type="submit" class="btn btn-success" id="seavis1" name=""><i class="Hui-iconfont">&#xe665;</i> 搜记录</button>
		<button type="submit" class="btn btn-success" style="border-radius: 8%;" id="outorder" name=""><i class="Hui-iconfont">&#xe640;</i> 数据导出</button>
	</div>
	
	<div style="margin:0px 45%;"><br/><a href="javascript:0;" id="getadmin" class="btn btn-primary radius"><i class="icon Hui-iconfont"></i> 选择账户</a></div><br/>
	<div style="display: none" id="select-admin">
		<div class="row cl">
				<label class="form-label col-xs-4 col-sm-2">账户名：</label>
				<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
					<select name="admin_name" id="admin_name" class="select">
						<option value="0">所有</option>
						@foreach($admins as $val)
						<option value="{{$val->admin_id}}" >{{$val->admin_name}}</option>
						@endforeach
					</select>
					</span> </div>
			</div>
	</div>

	<a style="margin-bottom: 10px;margin-left: 5px" href="javascript:;" onclick="pl_del()" class="btn btn-warning radius"><i class="Hui-iconfont">&#xe645;</i> 导入花费</a>
	<table class="table table-border table-bordered table-bg" id="pay_index_table">
		<thead>
			<tr>
				<th scope="col" colspan="15">订单列表</th>
			</tr>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="" value=""></th>
				<th width="30">ID</th>
				<th width="30">单品名</th>
				<th width="60">花费总额（元）</th>
				<th width="60">销售总额（元）</th>
				<th width="50">录入状态</th>
				<th width="50">操作</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>
</div>
@endsection
@section('js')

<script type="text/javascript">
function selectDatediff(a){
	console.log(a)
}
	$.tablesetting={
	"lengthMenu": [[5,10,20],[5,10,20]],
		"paging": true,
		"info":   true,	
		"searching": true,
		"ordering": true,
		"order": [[ 1, "desc" ]],
		"stateSave": false,
		"columnDefs": [{
		   "targets": [0,2,3,4,5],
		   "orderable": false
		}],
		"processing": true,
		"serverSide": true,
		"ajax": {
		"data":{
			spend_search:function(){return $('#admin_name').val()},
			mintime:function(){return $('#datemin').val()},
			maxtime:function(){return $('#datemax').val()},
		},
		"url": "{{url('admin/pay/get_table')}}",
		"type": "POST",
		'headers': { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
		},
		"columns": [
		{'defaultContent':"","className":"td-manager"},
		{"data":'goods_id'},
		{"data":'goods_real_name'},
		{"data":'goods_spend_money'},
		{"data":'goods_money'},
        // {'defaultContent':"","className":"td-manager"},
        {"data":'goods_status'},
		{'defaultContent':"","className":"td-manager"},
		],
		"createdRow":function(row,data,dataIndex){
			var info='<a title="预览详情" href="javascript:;" onclick="goods_getaddr(\'预览详情\',\'{{url("admin/pay/spend_show")}}?id='+data.goods_id+'\',\'2\',\'800\',\'800\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="预览详情"><i class="Hui-iconfont">&#xe64f;</i></span></a><a title="新增花费" href="javascript:;" onclick="goods_getaddr(\'新增花费\',\'/admin/pay/add_spend?id='+data.goods_id+'\',\'2\',\'800\',\'500\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="新增花费"><i class="Hui-iconfont">&#xe61f;</i></span></a><a title="新增广告编号" href="javascript:;" onclick="goods_getaddr(\'新增广告编号\',\'/admin/pay/add_pay_number?id='+data.goods_id+'\',\'2\',\'800\',\'500\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="新增广告编号"><i class="Hui-iconfont">&#xe600;</i></span></a><a title="删除花费" href="javascript:;" onclick="del_order(\''+data.goods_id+'\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="删除"><i class="Hui-iconfont">&#xe609;</i></span></a>';
			var checkbox='<input type="checkbox" name="" value="'+data.goods_id+'">';
			$(row).find('td:eq(0)').html(checkbox);
			$(row).find('td:eq(6)').html(info);
			$(row).addClass('text-c');
		}
	}
 dataTable =$('#pay_index_table').DataTable($.tablesetting);
 $('#seavis1').on('click',function(){
 $('#pay_index_table').dataTable().fnClearTable();
})

// 删除商品花费
function del_order(id){
		var msg =confirm("确定要删除此商品花费信息吗？");
		if(msg){
        		layer.msg('删除中');
        			$.ajax({
					url:"{{url('admin/pay/del_spend')}}",
					type:'get',
					data:{'id':id},
					datatype:'json',
					success:function(msg){
			           if(msg['err']==1){
			           	 layer.msg(msg.str);
               			 $('#pay_index_table').dataTable().fnClearTable(); 
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

//操作按钮函数
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
</script>

@endsection