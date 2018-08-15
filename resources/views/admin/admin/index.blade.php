@extends('admin.father.css')
@section('content')
<div class="page-container">
		<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><!-- <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> --> <a href="javascript:;" onclick="location.href='/admin/url/goods_url'" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 域名绑定</a>&nbsp;&nbsp;&nbsp;
		<button type="submit" class="btn btn-success" style="border-radius: 8%;" id="outgoods" name=""><i class="Hui-iconfont">&#xe640;</i> 数据导出</button>
		<button type="button" class="btn btn-secondary radius" style="border-radius: 8%;" id="addadmin" name=""><i class="Hui-iconfont">&#xe61f;</i> 添加账户</button></span>
		 <span class="r">共有数据：<strong>{{$counts}}</strong> 条</span> </div>
		<br>
	
	<table class="table table-border table-bordered table-bg" id="admin_index_table">
		<thead>
			<tr>
				<th scope="col" colspan="10">账户列表</th>
			</tr>
			<tr class="text-c">
				<th width="40">ID</th>
				<th width="110">账户名</th>
				<th width="110">上次登录IP</th>
				<th width="70">上次登陆时间</th>
				<th width="70">登陆次数</th>
				<th width="70">所属角色</th>
				<th width="70">拥有单品数</th>
				<th width="70">下单数</th>
				<th width="70">是否超管</th>
				<th width="70">操作</th>
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
		$.tablesetting={
	"lengthMenu": [[5,10,20],[5,10,20]],
		"paging": true,
		"info":   true,	
		"searching": true,
		"ordering": true,
		"order": [[ 1, "desc" ]],
		"stateSave": false,
		"columnDefs": [{
		   "targets": [0,2,3,5,6,7,8,10,11],
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
		{'defaultContent':"","className":"td-manager"},
		{'data':'goods_cuxiao_name'},
		{'defaultContent':"","className":"td-manager"},
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
			var info='<a title="编辑" href="javascript:;" onclick="goods_update(\'商品编辑\',\'{{url("admin/goods/chgoods")}}?id='+data.goods_id+'\',\'2\',\'1400\',\'800\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></span></a><a title="删除" href="javascript:;" onclick="del_goods(\''+data.goods_id+'\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="删除"><i class="Hui-iconfont">&#xe609;</i></span></a>';
			if(data.url_type==0||data.url_type==null){
				var isroot='<span class="label label-default radius">×</span>';
				if(data.url_url!=null){
					info+='<a title="启用" href="javascript:;" onclick="goods_online(\''+data.url_url+'\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="启用"><i class="Hui-iconfont">&#xe601;</i></span></a>'
				}else{
					info+='<a title="域名绑定" href="{{url("admin/url/goods_url")}}"  class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="域名绑定"><i class="Hui-iconfont">&#xe601;</i></span></a>'
				}
				
			}else{
				var isroot='<span class="label label-success radius">√</span>';
				info+='<a title="停止" href="javascript:;" onclick="goods_close(\''+data.url_url+'\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="停止"><i class="Hui-iconfont">&#xe6e4;</i></span></a>'
			}
			if(data.bd_type==1){
				var bd_type='<span style="color:green;">正常单品</span>';
			}else if(data.bd_type==0){
				var bd_type='<span style="color:red;">未绑定</span>';
			}else if(data.bd_type==2){
				var bd_type='<span style="color:brown;">遮罩单品</span>';
			}
			var url='<a href="http://'+data.url_url+'" target="_blank" >'+data.url_url+'</a>';
			var checkbox='<input type="checkbox" name="" value="">';
			/*var info='<a title="编辑" href="javascript:;" onclick="member_edit(\'编辑\',\'member-add.html\',4,\'\',510)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="member_del(this,1)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>';*/
			$(row).find('td:eq(11)').html(info);
			$(row).find('td:eq(7)').html(isroot);
			$(row).find('td:eq(5)').html(url);
			$(row).find('td:eq(8)').html(bd_type);
			$(row).find('td:eq(0)').html(checkbox);
			$(row).addClass('text-c');
			/*var img="<img src='"+data.cover_img+"' alt='暂时没有图片' width='130' height='100'>";
			$(row).find('td:eq(5)').html(img);*/
			/*var video_btn='<input class="btn btn-success-outline radius" onClick="start_play('+data.lesson_id+')" type="button" value="播放视频">';
			$(row).find('td:eq(6)').html(video_btn);*/
		}
	}
	$('#addadmin').on('click',function(){
		layer_show('添加账户',"{{url('admin/admin/addadmin')}}",500,500);
	})
</script>
@endsection