@extends('admin.father.css')
@section('content')
	<input class="btn radius btn-secondary" type="button" value="+新增优惠券" style="margin-left: 10%;" onclick="new_cheap('新增优惠券','/admin/goods/cheap/set?goods_id='+'{{$id}}','2','800','500')">
<table class="table table-border table-bordered table-bg" id="comment_user_table">
		<thead>
			<tr>
				<th scope="col" colspan="11">优惠卷列表</th>
			</tr>
			<tr class="text-c">
				<th width="20">ID</th>
				<th width="20">类型</th>
				<th width="20">添加者</th>
				<th width="30">参数</th>
				<th width="30">备注参数</th>
				<th width="40">添加时间</th>
				<th width="40">生效时间</th>
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
	function new_cheap(title,url,type,w,h){
		layer_show(title,url,w,h);
	}
	$.tablesetting={
	"lengthMenu": [[5,10,20],[5,10,20]],
		"paging": true,
		"info":   true,	
		"searching": true,
		"ordering": true,
		"order": [[ 5, "desc" ]],
		"stateSave": false,
		"columnDefs": [{
		   "targets": [1,2,3,4,7],
		   "orderable": false
		}],
		"processing": true,
		"serverSide": true,
		"ajax": {
		"url": "{{url('admin/goods/cheap/index')}}",
		"type": "POST",
		'data':{'id':{{$id}}},
		'headers': { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
		},
		"columns": [
		{"data":'goods_cheap_id'},
		{'defaultContent':"","className":"td-manager"},
		{'data':'admin_name'},
		{'data':'goods_cheap_msg'},
		{'data':'goods_cheap_remark'},
		{'data':'goods_cheap_time'},
		{'data':'goods_cheap_start_time'},
		{'defaultContent':"","className":"td-manager"},
/*		{'data':'course.profession.pro_name'},
		{'defaultContent':""},
		{'defaultContent':""},
		{'data':'created_at'},
		{'defaultContent':"","className":"td-manager"},*/
		],
		"createdRow":function(row,data,dataIndex){
			var info='<a title="删除" href="javascript:;" onclick="del_cheap(\''+data.goods_cheap_id+'\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe609;</i></a>';
			if(data.goods_cheap_type==0){
							var types='<span style="color:green;">现金卷</span>'
			}else if(data.goods_cheap_type==1){
							var types='<span style="color:brown;">折扣卷</span>'
			}else if(data.goods_cheap_type==2){
							var types='<span style="color:red;">减免卷</span>'
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
			$(row).find('td:eq(1)').html(types);
			$(row).find('td:eq(7)').html(info);
			$(row).addClass('text-c');
			/*var img="<img src='"+data.cover_img+"' alt='暂时没有图片' width='130' height='100'>";
			$(row).find('td:eq(5)').html(img);*/
			/*var video_btn='<input class="btn btn-success-outline radius" onClick="start_play('+data.lesson_id+')" type="button" value="播放视频">';
			$(row).find('td:eq(6)').html(video_btn);*/
		}
	
}
 dataTable =$('#comment_user_table').DataTable($.tablesetting);
 function del_cheap(id){
		var msg =confirm("确定要删除此优惠卷？");
		if(msg){
        		layer.msg('处理中');
        		$.ajax({
					url:"{{url('admin/goods/cheap/del')}}",
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
			           	 layer.msg('删除失败！');
			           }
					}
				})

		}else{

		}

}
// function new_cheap(title,url,type,w,h){
// 	layer_show(title,url,w,h);
// }

</script>
@endsection