@extends('admin.father.css')
@section('content')
<div class="page-container">
	<!-- <div class="cl pd-5 bg-1 bk-gray"> <span class="l"> <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> --> <a class="btn btn-primary radius" href="javascript:;" onclick="url_add('添加域名','{{url("admin/url/url_add")}}',100,400)"><i class="Hui-iconfont">&#xe600;</i> 添加域名</a> </span> <span class="r">共有数据：<strong>{{$counts}}</strong> 条</span> </div>
	<table class="table table-border table-bordered table-hover table-bg" id="url_goods">
		<thead>
			<tr>
				<th scope="col" colspan="6">域名分配</th>
			</tr>
			<tr class="text-c">
				<th width="40">ID</th>
				<th width="80">域名</th>
				<th width="200">正常单品</th>
				<th width="200">遮罩单品</th>
				<th width="40">状态</th>
				<th width="70">操作</th>
			</tr>
		</thead>
		
	</table>
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
		   "targets": [1,2,3,4,5],
		   "orderable": false
		}],
		"processing": true,
		"serverSide": true,
		"ajax": {
		"url": "{{url('admin/url/get_url')}}",
		"type": "POST",
		'headers': { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
		},
		"columns": [
		{"data":'url_id'},
		{'defaultContent':"","className":"td-manager"},
		{"data":'url_goods_id'},
		{"data":'url_zz_goods_id'},
		{'defaultContent':"","className":"td-manager"},
		{'defaultContent':"","className":"td-manager"},
/*		{'data':'course.profession.pro_name'},
		{'defaultContent':""},
		{'defaultContent':""},
		{'data':'created_at'},
		{'defaultContent':"","className":"td-manager"},*/
		],
		"createdRow":function(row,data,dataIndex){
			var info='<a title="配置域名" href="javascript:;" onclick="ch_url(\'配置域名\',\'/admin/url/churl?id='+data.url_id+'\',\'2\',\'800\',\'500\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe62e;</i></a>';
			if(data.url_type==0){
				var isroot='<span class="label label-default radius">×</span>';
				info+='<a title="开启" href="javascript:;" onclick="up_order(\''+data.url_id+'\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6dc;</i></a>';
			}else if(data.url_type==1){
				var isroot='<span class="label label-success radius">√</span>';
				info+='<a title="关闭" href="javascript:;" onclick="close_order(\''+data.url_id+'\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6de;</i></a>';
			}
			var url='<a href="http://'+data.url_url+'" target="_blank" >'+data.url_url+'</a>';
			/*var checkbox='<input type="checkbox" name="" value="">';*/
			/*var info='<a title="编辑" href="javascript:;" onclick="member_edit(\'编辑\',\'member-add.html\',4,\'\',510)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="member_del(this,1)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>';*/
			$(row).find('td:eq(5)').html(info);
			$(row).find('td:eq(4)').html(isroot);
			$(row).find('td:eq(1)').html(url);
			$(row).addClass('text-c');
			/*var img="<img src='"+data.cover_img+"' alt='暂时没有图片' width='130' height='100'>";
			$(row).find('td:eq(5)').html(img);*/
			/*var video_btn='<input class="btn btn-success-outline radius" onClick="start_play('+data.lesson_id+')" type="button" value="播放视频">';
			$(row).find('td:eq(6)').html(video_btn);*/
		}
	}
 dataTable =$('#url_goods').DataTable($.tablesetting);
function up_order(id){
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
			           	 $('#url_goods').dataTable().fnClearTable(); 
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
function close_order(id){
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
			           	 $('#url_goods').dataTable().fnClearTable(); 
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
function ch_url(title,url,type,w,h){
	layer_show(title,url,w,h);
}
function url_add(title,url,type,w,h){
	layer_show(title,url,w,h);
}
</script>
@endsection