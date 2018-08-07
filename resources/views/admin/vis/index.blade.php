@extends('admin.father.css')
@section('content')
<div class="page-container">
	<div class="text-c"> 日期范围：
		<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d %H:%m:%s\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
		-
		<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d %H:%m:%s' })" id="datemax" class="input-text Wdate" style="width:120px;">
		<!-- <input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name=""> -->
		<button type="submit" class="btn btn-success" id="seavis" name=""><i class="Hui-iconfont">&#xe665;</i> 搜记录</button>&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success" style="border-radius: 8%;" id="outvis" name=""><i class="Hui-iconfont">&#xe640;</i> 数据导出</button>
			<div class="mt-20 skin-minimal">
		  <div class="radio-box">
		    <input type="radio" id="radio-pb" class='radio-pb' name="ispb" value="0" checked="checked">
		    <label for="radio-1">未屏蔽</label>
		  </div>
		  <div class="radio-box">
		    <input type="radio" id="radio-pb" class='radio-pb' name="ispb" value="1">
		    <label for="radio-2">已屏蔽</label>
  </div>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><!-- <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a href="javascript:;" onclick="admin_add('添加管理员','admin-add.html','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a> --></span> <span class="r">共有数据：<strong>{{$counts}}</strong> 条</span> </div>
	<table class="table table-border table-bordered table-bg" id="vis_index_table">
		<thead>
			<tr>
				<th scope="col" colspan="14">访问记录</th>
			</tr>
			<tr class="text-c">
				<th width="40">ID</th>
				<th width="80">ip</th>
				<th width="60">国家</th>
				<th width="60">州/省</th>
				<th width="60">市/区</th>
				<th width="30">县/镇</th>
				<th width="30">网络来源</th>
				<th width="40">设备类型</th>
				<th width="40">访问时间</th>
				<th width="40">语言</th>
				<th width="60">访问单品</th>
				<th width="60">访问url</th>
				<th width="30">是否屏蔽</th>
				<th width="60">操作</th>
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
	"lengthMenu": [[10,20],[10,20]],
		"paging": true,
		"info":   true,	
		"searching": true,
		"ordering": true,
		"order": [[ 8, "desc" ]],
		"stateSave": false,
		"columnDefs": [{
		   "targets": [1,2,3,4,5,7,9,10,11,12],
		   "orderable": false
		}],
		"processing": true,
		"serverSide": true,
		"ajax": {
		"url": "{{url('admin/vis/getindex')}}",
		"type": "POST",
		"data":{
			mintime:function(){return $('#datemin').val()},
			maxtime:function(){return $('#datemax').val()},
			ispb:function(){return $('input[name="ispb"]:checked').val()},
		},
		'headers': { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
		},
		"columns": [
		{"data":'vis_id'},
		{"data":'vis_ip'},
		{"data":'vis_country'},
		{'data':'vis_region'},
		{'data':'vis_city'},
		{'data':'vis_county'},
		{'data':'vis_isp'},
		{'data':'vis_type'},
		{'data':'vis_time'},
		{'data':'vis_lan'},
		{'data':'goods_name'},
		{'defaultContent':"","className":"td-manager"},
		{'defaultContent':"","className":"td-manager"},
		{'defaultContent':"","className":"td-manager"},
/*		{'data':'course.profession.pro_name'},
		{'defaultContent':""},
		{'defaultContent':""},
		{'data':'created_at'},
		{'defaultContent':"","className":"td-manager"},*/
		],
		
		"createdRow":function(row,data,dataIndex){
			var info='<a title="删除" href="javascript:;" onclick="del_vis(\''+data.vis_id+'\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe609;</i></a>';
			if(data.vis_isback==0||data.vis_isback==''){
				var isroot='<span class="label label-success radius">未屏蔽</span>';
				info+='<a title="屏蔽" href="javascript:;"  onclick="pb_vis(\''+data.vis_id+'\')" class="ml-5" style="text-decoration:none"><i style="size:20px;" class="Hui-iconfont">&#xe60e;</i></a>';
			}else if(data.vis_isback==1){
				var isroot='<span class="label label-default radius">已屏蔽</span>';
				info+='<a title="解除屏蔽" href="javascript:;"  onclick="back_vis(\''+data.vis_id+'\')" class="ml-5" style="text-decoration:none"><i style="size:20px;" class="Hui-iconfont">&#xe605;</i></a>';
			}
			var url='<a href="http://'+data.vis_url+'" style="margin:0px auto;" target="view_window" >'+data.vis_url+'</a>';
			/*var info='<a title="编辑" href="javascript:;" onclick="member_edit(\'编辑\',\'member-add.html\',4,\'\',510)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="member_del(this,1)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>';*/
			$(row).find('td:eq(13)').html(info);
			$(row).find('td:eq(12)').html(isroot);
			$(row).find('td:eq(11)').html(url);
			$(row).addClass('text-c');
			/*var img="<img src='"+data.cover_img+"' alt='暂时没有图片' width='130' height='100'>";
			$(row).find('td:eq(5)').html(img);*/
			/*var video_btn='<input class="btn btn-success-outline radius" onClick="start_play('+data.lesson_id+')" type="button" value="播放视频">';
			$(row).find('td:eq(6)').html(video_btn);*/
		}
	}
 dataTable =$('#vis_index_table').DataTable($.tablesetting);
$('#seavis').on('click',function(){
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
$('.radio-pb').on('click',function(){
/*dataTable.destroy();*/
/* dataTable =$('#vis_index_table').DataTable($.tablesetting);
		dataTable.ajax.url( "{{url('admin/vis/getindex')}}?ispb="+$('input[name="ispb"]:checked').val()).load();*/
	dataTable.draw();
})
function del_vis(id){
		var msg =confirm("确定要删除此访问记录吗？");
		if(msg){
        		layer.msg('删除中');
        			$.ajax({
					url:"{{url('admin/vis/delvis')}}",
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
               			 $('#vis_index_table').dataTable().fnClearTable(); 
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
function pb_vis(id){
		var msg =confirm("确定要屏蔽此ip吗？");
		if(msg){
        		layer.msg('屏蔽中');
        			$.ajax({
					url:"{{url('admin/vis/pbvis')}}",
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
               			 $('#vis_index_table').dataTable().fnClearTable(); 
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
function back_vis(id){
		var msg =confirm("确定要解封此ip吗？");
		if(msg){
        		layer.msg('解除中');
        			$.ajax({
					url:"{{url('admin/vis/backvis')}}",
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
               			 $('#vis_index_table').dataTable().fnClearTable(); 
			           }else if(msg['err']==0){
			           	 layer.msg(msg.str);
			           }else{
			           	 layer.msg('解封失败！');
			           }
					}
				})
        	}else{
                
        	}
	}
$('#outvis').on('click',function(){
	location.href='{{url("admin/vis/outvis")}}';
})
function goods_getaddr(title,url,type,w,h){
	layer_show(title,url,w,h);
}
</script>
@endsection