@extends('admin.father.css')
@section('content')
<div class="cl pd-5 bg-1 bk-gray mt-20">@if(Auth::user()->is_root=='1') <span class="l"><!-- <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> --> <a href="javascript:;" onclick="location.href='/admin/goods/index';" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> @endif单品管理</a></span> <span class="r">共有数据：<strong>{{$counts}}</strong> 条</span> </div>
	<table class="table table-border table-bordered table-bg" id="comment_user_table">
		<thead>
			<tr>
				<th scope="col" colspan="11">评论管理</th>
			</tr>
			<tr class="text-c">
				<th width="40">ID</th>
				<th width="100">单品名</th>
				<th width="110">展示评论</th>
				<th width="20">客户评论</th>
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
		"order": [[ 0, "desc" ]],
		"stateSave": false,
		"columnDefs": [{
		   "targets": [1,2,3],
		   "orderable": false
		}],
		"processing": true,
		"serverSide": true,
		"ajax": {
		"url": "{{url('admin/comment/getindex')}}",
		"type": "POST",
		'headers': { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
		},
		"columns": [
		{"data":'goods_id'},
		{'data':'goods_name'},
		{'defaultContent':"","className":"td-manager"},
		{'defaultContent':"","className":"td-manager"},
/*		{'data':'course.profession.pro_name'},
		{'defaultContent':""},
		{'defaultContent':""},
		{'data':'created_at'},
		{'defaultContent':"","className":"td-manager"},*/
		],
		"createdRow":function(row,data,dataIndex){
			var oncount='<input class="btn btn-default radius" type="button" onclick="oncomment(\'展示评论\',\'/admin/comment/oncomment?id='+data.goods_id+'\',\'2\',\'1300\',\'900\')" value="'+data.oncount+'">';
			var usecount='<input class="btn btn-default radius" type="button" onclick="usercomment(\'客户评论\',\'/admin/comment/usercomment?id='+data.goods_id+'\',\'2\',\'1300\',\'900\')" value="'+data.usecount+'">';
			/*if(data.url_type==0){
				var isroot='<span class="label label-default radius">×</span>';
				info+='<a title="启用" href="javascript:;" onclick="goods_online(\''+data.goods_id+'\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe601;</i></a>';
			}else{
				var isroot='<span class="label label-success radius">√</span>';
				info+='<a title="下线" href="javascript:;" onclick="goods_close(\''+data.goods_id+'\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e4;</i></a>';
			}*/
			/*var checkbox='<input type="checkbox" name="" value="">';*/
			/*var info='<a title="编辑" href="javascript:;" onclick="member_edit(\'编辑\',\'member-add.html\',4,\'\',510)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="member_del(this,1)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>';*/
			$(row).find('td:eq(2)').html(oncount);
			$(row).find('td:eq(3)').html(usecount);
			$(row).addClass('text-c');
			/*var img="<img src='"+data.cover_img+"' alt='暂时没有图片' width='130' height='100'>";
			$(row).find('td:eq(5)').html(img);*/
			/*var video_btn='<input class="btn btn-success-outline radius" onClick="start_play('+data.lesson_id+')" type="button" value="播放视频">';
			$(row).find('td:eq(6)').html(video_btn);*/
		}
	}
 dataTable =$('#comment_user_table').DataTable($.tablesetting);
function oncomment(title,url,type,w,h){
	layer_show(title,url,w,h);
}
function usercomment(title,url,type,w,h){
	layer_show(title,url,w,h);
}
</script>
@endsection