@extends('admin.father.css')
@section('content')
<div class="page-container">
	<div class="text-c"> 日期范围：
		<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d %H:%m:%s\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
		-
		<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d %H:%m:%s' })" id="datemax" class="input-text Wdate" style="width:120px;">
		<!-- <input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name=""> -->
		<button type="submit" class="btn btn-success" id="seavis2" name=""><i class="Hui-iconfont">&#xe665;</i> 搜记录</button>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><!-- <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> --> <a href="javascript:;" onclick="location.href='/admin/url/goods_url'" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 域名绑定</a>&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success" style="border-radius: 8%;" id="outgoods" name=""><i class="Hui-iconfont">&#xe640;</i> 数据导出</button></span> <span class="r">共有数据：<strong>{{$counts}}</strong> 条</span> </div>
	
	<table class="table table-border table-bordered table-bg" id="goods_index_table">
		<thead>
			<tr>
				<th scope="col" colspan="11">单品列表</th>
			</tr>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="" value=""></th>
				<th width="40">ID</th>
				<th width="100">单品名</th>
				<th width="110">单品小标题</th>
				<th width="20">单品价格</th>
				<th width="150">绑定域名</th>
				<th width="130">促销信息</th>
				<th width="20">是否启用</th>
				<th width="80">发布时间</th>
				<th width="80">发布人</th>
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
		"order": [[ 1, "desc" ]],
		"stateSave": false,
		"columnDefs": [{
		   "targets": [0,2,3,5,6,7,8],
		   "orderable": false
		}],
		"processing": true,
		"serverSide": true,
		"ajax": {
		"data":{
			mintime:function(){return $('#datemin').val()},
			maxtime:function(){return $('#datemax').val()},
		},
		"url": "{{url('admin/goods/get_table')}}",
		"type": "POST",
		'headers': { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
		},
		"columns": [
		{'defaultContent':"","className":"td-manager"},
		{"data":'goods_id'},
		{'data':'goods_name'},
		{'data':'goods_msg'},
		{'data':'goods_price'},
		{'data':'url_url'},
		{'data':'goods_cuxiao_name'},
		{'defaultContent':"","className":"td-manager"},
		{'data':'goods_up_time'},
		{'data':'admin_name'},
		{'defaultContent':"","className":"td-manager"},
/*		{'data':'course.profession.pro_name'},
		{'defaultContent':""},
		{'defaultContent':""},
		{'data':'created_at'},
		{'defaultContent':"","className":"td-manager"},*/
		],
		"createdRow":function(row,data,dataIndex){
			var info='<a title="编辑" href="javascript:;" onclick="goods_update(\'商品编辑\',\'{{url("admin/goods/chgoods")}}?id='+data.goods_id+'\',\'2\',\'1400\',\'800\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a><a title="删除" href="javascript:;" onclick="del_goods(\''+data.goods_id+'\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe609;</i></a>';
			if(data.url_type==0){
				var isroot='<span class="label label-default radius">×</span>';
				info+='<a title="启用" href="javascript:;" onclick="goods_online(\''+data.goods_id+'\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe601;</i></a>';
			}else{
				var isroot='<span class="label label-success radius">√</span>';
				info+='<a title="下线" href="javascript:;" onclick="goods_close(\''+data.goods_id+'\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e4;</i></a>';
			}
			var checkbox='<input type="checkbox" name="" value="">';
			/*var info='<a title="编辑" href="javascript:;" onclick="member_edit(\'编辑\',\'member-add.html\',4,\'\',510)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="member_del(this,1)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>';*/
			$(row).find('td:eq(10)').html(info);
			$(row).find('td:eq(7)').html(isroot);
			$(row).find('td:eq(0)').html(checkbox);
			$(row).addClass('text-c');
			/*var img="<img src='"+data.cover_img+"' alt='暂时没有图片' width='130' height='100'>";
			$(row).find('td:eq(5)').html(img);*/
			/*var video_btn='<input class="btn btn-success-outline radius" onClick="start_play('+data.lesson_id+')" type="button" value="播放视频">';
			$(row).find('td:eq(6)').html(video_btn);*/
		}
	}
 dataTable =$('#goods_index_table').DataTable($.tablesetting);
 $('#seavis2').on('click',function(){
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
function del_goods(id){
		var msg =confirm("确定要删除此商品吗？");
		if(msg){
        		layer.msg('删除中');
        			$.ajax({
					url:"{{url('admin/goods/delgoods')}}",
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
               			 $('#goods_index_table').dataTable().fnClearTable(); 
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
function goods_edit(id){
		var msg =confirm("确定要启用此商品吗？");
		if(msg){
        		layer.msg('启用中');
        		$.ajax({
					url:"{{url('admin/goods/online')}}",
					type:'get',
					data:{'id':id},
					datatype:'json',
					success:function(msg){
			           if(msg['err']==1){
			           	 layer.msg(msg.str);
			           	 $('#goods_index_table').dataTable().fnClearTable(); 
			           	 /*$(".del"+id).prev("input").remove();
        				 $(".del"+id).val('已删除');*/
			           }else if(msg['err']==0){
			           	 layer.msg(msg.str);
			           }else{
			           	 layer.msg('启动失败！');
			           }
					}
				})

		}else{

		}
}
function goods_close(id){
var msg =confirm("确定要下线此商品吗？");
		if(msg){
        		layer.msg('操作中');
        		$.ajax({
					url:"{{url('admin/goods/close')}}",
					type:'get',
					data:{'id':id},
					datatype:'json',
					success:function(msg){
			           if(msg['err']==1){
			           	 layer.msg(msg.str);
			           	 $('#goods_index_table').dataTable().fnClearTable(); 
			           	 /*$(".del"+id).prev("input").remove();
        				 $(".del"+id).val('已删除');*/
			           }else if(msg['err']==0){
			           	 layer.msg(msg.str);
			           }else{
			           	 layer.msg('下线失败！');
			           }
					}
				})

		}else{

		}
}
$('#outgoods').on('click',function(){
	location.href='{{url("admin/goods/outgoods")}}';
})
function goods_update(title,url,type,w,h){
	layer_show(title,url,w,h);
}
</script>
@endsection