@extends('admin.father.css')
@section('content')
<div class="page-container">
		<div class="text-c"> 日期范围：
		<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d %H:%m:%s\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
		-
		<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d %H:%m:%s' })" id="datemax" class="input-text Wdate" style="width:120px;">
		<!-- <input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name=""> -->
		<button type="submit" class="btn btn-success" id="seavis1" name=""><i class="Hui-iconfont">&#xe665;</i> 搜记录</button>
		&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success" style="border-radius: 8%;" id="outorder" name=""><i class="Hui-iconfont">&#xe640;</i> 数据导出</button>
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
	
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><!-- <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a href="javascript:;" onclick="admin_add('添加管理员','admin-add.html','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a> --></span> <span class="r">共有数据：<strong>{{$counts}}</strong> 条</span> </div>
	<table class="table table-border table-bordered table-bg" id="order_index_table">
		<thead>
			<tr>
				<th scope="col" colspan="14">订单列表</th>
			</tr>
			<tr class="text-c">
				<th width="40">ID</th>
				<th width="80">订单号</th>
				<th width="60">下单者ip</th>
				<th width="60">单品名</th>
				<th width="60">促销信息</th>
				<th width="60">属性信息</th>
				<th width="30">订单价格</th>
				<th width="30">订单状态</th>
				<th width="40">下单时间</th>
				<th width="40">核审时间</th>
				<th width="40">核审者</th>
				<th width="30">件数</th>
				<th width="60">快递单号</th>
				<th width="100">操作</th>
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
</div>
@endsection
@section('js')

<script type="text/javascript">
	$.tablesetting={
	"lengthMenu": [[5,10,20],[5,10,20]],
		"paging": true,
		"info":   true,	
		"searching": true,
		"ordering": true,
		"order": [[ 8, "desc" ]],
		"stateSave": false,
		"columnDefs": [{
		   "targets": [2,3,4,5,7,10,12],
		   "orderable": false
		}],
		"processing": true,
		"serverSide": true,
		"ajax": {
		"data":function(d){
			d.goods_search = $('#admin_name').val();
		},
		"url": "{{url('admin/order/get_table')}}",
		"type": "POST",
		'headers': { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
		},
		"columns": [
		{"data":'order_id'},
		{"data":'order_single_id'},
		{"data":'order_ip'},
		{'data':'goods_real_name'},
		{'data':'cuxiao_msg'},
		{'data':'config_msg'},
		{'data':'order_price'},
		{'defaultContent':"","className":"td-manager"},
		{'data':'order_time'},
		{'data':'order_return_time'},
		{'data':'admin_name'},
		{'data':'order_num'},
		{'data':'order_send'},
		{'defaultContent':"","className":"td-manager"},
/*		{'data':'course.profession.pro_name'},
		{'defaultContent':""},
		{'defaultContent':""},
		{'data':'created_at'},
		{'defaultContent':"","className":"td-manager"},*/
		],
		"createdRow":function(row,data,dataIndex){
			var info='<a title="地址" href="javascript:;" onclick="goods_getaddr(\'收货地址\',\'/admin/order/getaddr?id='+data.order_id+'\',\'2\',\'800\',\'500\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe643;</i></a><a title="更改状态" href="javascript:;" onclick="goods_edit(\'更改状态\',\'/admin/order/heshen?id='+data.order_id+'\',\'2\',\'800\',\'500\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a><a title="删除" href="javascript:;" onclick="del_order(\''+data.order_id+'\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe609;</i></a>';
			if(data.order_type==0){
				var isroot='<a href="#" onclick="" <span class="label label-success radius" style="color:#ccc;">未核审</span></a>';
			}else if(data.order_type==1){
				var isroot='<a href="javascript:;" onclick="order_returninfo('+data.order_id+')" <span class="label label-default radius" style="color:green;">核审通过</span></a>';
			}else if(data.order_type==2){
				var isroot='<a href="javascript:;" onclick="order_returninfo('+data.order_id+')" <span class="label label-default radius" style="color:red;">核审驳回</span></a>';
			}else if(data.order_type==3){
				var isroot='<a href="javascript:;" onclick="order_returninfo('+data.order_id+')" <span class="label label-default radius" style="color:brown;">已发货</span></a>';
			}else if(data.order_type==4){
				var isroot='<a href="javascript:;" onclick="order_returninfo('+data.order_id+')" <span class="label label-default radius" style="color:#6699ff;">已签收</span></a>';
			}else if(data.order_type==5){
				var isroot='<a href="javascript:;" onclick="order_returninfo('+data.order_id+')" <span class="label label-default radius" style="color:#red;">退货未退款</span></a>';
			}else if(data.order_type==6){
				var isroot='<a href="javascript:;" onclick="order_returninfo('+data.order_id+')" <span class="label label-default radius" style="color:#red;">退货并已退款</span></a>';
			}else if(data.order_type==7){
				var isroot='<a href="javascript:;" onclick="order_returninfo('+data.order_id+')" <span class="label label-default radius" style="color:#red;">未退货并已退款</span></a>';
			}else if(data.order_type==8){
				var isroot='<a href="javascript:;" onclick="order_returninfo('+data.order_id+')" <span class="label label-default radius" style="color:#red;">拒签</span></a>';
			}
			var checkbox='<input type="checkbox" name="" value="">';
			/*var info='<a title="编辑" href="javascript:;" onclick="member_edit(\'编辑\',\'member-add.html\',4,\'\',510)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="member_del(this,1)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>';*/
			$(row).find('td:eq(13)').html(info);
			$(row).find('td:eq(7)').html(isroot);
			/*$(row).find('td:eq(0)').html(checkbox);*/
			$(row).addClass('text-c');
			/*var img="<img src='"+data.cover_img+"' alt='暂时没有图片' width='130' height='100'>";
			$(row).find('td:eq(5)').html(img);*/
			/*var video_btn='<input class="btn btn-success-outline radius" onClick="start_play('+data.lesson_id+')" type="button" value="播放视频">';
			$(row).find('td:eq(6)').html(video_btn);*/
		}
	}
 dataTable =$('#order_index_table').DataTable($.tablesetting);
$('#seavis1').on('click',function(){
	var mintime=$('#datemin').val();
	var maxtime=$('#datemax').val();
	if(mintime==''&&maxtime==''){
      dataTable.search(this.value).draw();
      return false;
	}
	if(mintime==''||maxtime==''){
		layer.msg('时间区间错误！');
		return false;
	}
	dataTable.search(mintime+';'+maxtime).draw();
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
function goods_getaddr(title,url,type,w,h){
	layer_show(title,url,w,h);
}
$('#getadmin').on('click',function(){
	$('#select-admin').show(300);
})
$('#admin_name').on('change',function(){
	dataTable.ajax.reload();
	var args = dataTable.ajax.params();
           console.log("额外传到后台的参数值extra_search为："+args.goods_search);
})
</script>

@endsection