@extends('admin.father.css')
@section('content')
	<input class="btn radius btn-secondary" type="button" value="+新增评论" style="margin-left: 10%;" onclick="newcomment('新增评论','/admin/comment/newcomment?id={{$id}}','2','800','500')">
<table class="table table-border table-bordered table-bg" id="comment_user_table">
		<thead>
			<tr>
				<th scope="col" colspan="11">评论管理</th>
			</tr>
			<tr class="text-c">
				<th width="40">ID</th>
				<th width="100">单品名</th>
				<th width="110">评论者姓名</th>
				<th width="20">评论者手机号</th>
				<th width="20">评论星级</th>
				<th width="20">评论信息</th>
				<th width="20">附带图片</th>
				<th width="20">评论时间</th>
				<th width="20">操作</th>
			</tr>
		</thead>
		<tbody>
			<img src="">
		</tbody>
</table>
@endsection
@section('js')
<script type="text/javascript">
	function newcomment(title,url,type,w,h){
		layer_show(title,url,w,h);
	}
	$.tablesetting={
	"lengthMenu": [[5,10,20],[5,10,20]],
		"paging": true,
		"info":   true,	
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"stateSave": false,
		"columnDefs": [{
		   "targets": [1,2,3,5,6,8],
		   "orderable": false
		}],
		"processing": true,
		"serverSide": true,
		"ajax": {
		"url": "{{url('admin/comment/geton')}}",
		"type": "POST",
		'data':{'id':{{$id}}},
		'headers': { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
		},
		"columns": [
		{"data":'com_id'},
		{'data':'goods_real_name'},
		{'data':'com_name'},
		{'data':'com_phone'},
		{'data':'com_star'},
		{'data':'com_msg'},
		{'defaultContent':"","className":"td-manager"},
		{'data':'com_time'},
		{'defaultContent':"","className":"td-manager"},
/*		{'data':'course.profession.pro_name'},
		{'defaultContent':""},
		{'defaultContent':""},
		{'data':'created_at'},
		{'defaultContent':"","className":"td-manager"},*/
		],
		"createdRow":function(row,data,dataIndex){
			var info='<a title="下线" href="javascript:;" onclick="del_oncom(\''+data.com_id+'\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe609;</i></a>';
			info+='<a title="修改" href="javascript:;" onclick="chncomment(\'修改评论\',\'/admin/comment/usecomment?id='+data.com_id+'\',\'2\',\'800\',\'500\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe62e;</i></a>';
			if(data.com_img!=''&&data.com_img!=null){
							var imgs='<img style="width:100px;height:135px;" src="'+data.com_img+'" alt="'+data.com_img+'"/>';
			}else{
							var imgs='暂无附图';
			}
			/*if(data.url_type==0){
				var isroot='<span class="label label-default radius">×</span>';
				info+='<a title="启用" href="javascript:;" onclick="goods_online(\''+data.goods_id+'\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe601;</i></a>';
			}else{
				var isroot='<span class="label label-success radius">√</span>';
				info+='<a title="下线" href="javascript:;" onclick="goods_close(\''+data.goods_id+'\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e4;</i></a>';
			}*/
			/*var checkbox='<input type="checkbox" name="" value="">';*/
			/*var info='<a title="编辑" href="javascript:;" onclick="member_edit(\'编辑\',\'member-add.html\',4,\'\',510)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="member_del(this,1)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>';*/
			$(row).find('td:eq(8)').html(info);
			$(row).find('td:eq(6)').html(imgs);
			$(row).addClass('text-c');
			/*var img="<img src='"+data.cover_img+"' alt='暂时没有图片' width='130' height='100'>";
			$(row).find('td:eq(5)').html(img);*/
			/*var video_btn='<input class="btn btn-success-outline radius" onClick="start_play('+data.lesson_id+')" type="button" value="播放视频">';
			$(row).find('td:eq(6)').html(video_btn);*/
		}
	
}
 dataTable =$('#comment_user_table').DataTable($.tablesetting);
 function del_oncom(id){
		var msg =confirm("确定要下线此评论吗？");
		if(msg){
        		layer.msg('下线中');
        		$.ajax({
					url:"{{url('admin/comment/downcom')}}",
					type:'get',
					data:{'id':id},
					datatype:'json',
					success:function(msg){
			           if(msg['err']==1){
			           	 layer.msg(msg.str);
			           	 $('#comment_user_table').dataTable().fnClearTable(); 
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
function chncomment(title,url,type,w,h){
	layer_show(title,url,w,h);
}

</script>
@endsection