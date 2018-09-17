@extends('admin.father.css')
@section('content')
<div class="page-container">
		<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><!-- <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> --> <a href="javascript:;" id="addrole"  class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 增加角色</a>&nbsp;&nbsp;&nbsp;
		<button type="submit" class="btn btn-success" style="border-radius: 8%;" id="outgoods" name="" onclick="location.href='{{url('/admin/admin/chrole')}}'"><i class="Hui-iconfont">&#xe640;</i> 权限分配</button>
		<button type="button" class="btn btn-secondary radius" style="border-radius: 8%;" id="addadmin" name=""><i class="Hui-iconfont">&#xe61f;</i> 添加账户</button>
		<button type="button" class="btn btn-primary radius" style="border-radius: 8%;" id="addgroup" name=""><i class="Hui-iconfont">&#xe61f;</i> 添加分组</button>
		
		</span>
		 <span class="r">共有数据：<strong>{{$counts}}</strong> 条</span> </div>
		<br>
	
	<table class="table table-border table-bordered table-bg" id="admin_index_table">
		<thead>
			<tr>
				<th scope="col" colspan="13">账户列表</th>
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
				<th width="70">今日销售额</th>
				<th width="70">是否超管</th>
				<th width="70">所属分组</th>
				<th width="70">是否启用</th>
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
		   "targets": [0,2,3,5,6,7,8,10,11,12],
		   "orderable": false
		}],
		"processing": true,
		"serverSide": true,
		"ajax": {
		"data":{
			mintime:function(){return $('#datemin').val()},
			maxtime:function(){return $('#datemax').val()},
		},
		"url": "{{url('admin/admin/get_table')}}",
		"type": "POST",
		'headers': { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
		},
		"columns": [
		{"data":'admin_id'},
		{'data':'admin_name'},
		{'data':'admin_ip'},
		{'data':'admin_time'},
		{'data':'admin_num'},
		{'data':'role_name'},
		{'data':'goods_num'},
		{'data':'orders_num'},
		{'data':'day_sale'},
		{'defaultContent':"","className":"td-manager"},
		{'data':'admin_group'},
		{'defaultContent':"","className":"td-manager"},
		{'defaultContent':"","className":"td-manager"},
/*		{'data':'course.profession.pro_name'},
		{'defaultContent':""},
		{'defaultContent':""},
		{'data':'created_at'},
		{'defaultContent':"","className":"td-manager"},*/
		],
		"createdRow":function(row,data,dataIndex){
            console.log(data);
            var info='<a title="编辑" href="javascript:;" onclick="admin_update(\'账户编辑\',\'{{url("admin/admin/upadmin")}}?id='+data.admin_id+'\',\'2\',\'500\',\'300\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></span></a><a title="删除" href="javascript:;" onclick="del_admin(\''+data.admin_id+'\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="删除"><i class="Hui-iconfont">&#xe609;</i></span></a>';
			if(data.is_root==0||data.is_root==null){
				var isroot='<span class="label label-default radius">×</span>';
				if(data.is_root!=null){
					info+='<a title="设为超管" href="javascript:;" onclick="ch_root(\''+data.admin_id+'\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="设为超管"><i class="Hui-iconfont">&#xe72c;</i></span></a>'
				}
			}else{
				var isroot='<span class="label label-success radius">√</span>';
				info+='<a title="取消超管" href="javascript:;" onclick="cl_root(\''+data.admin_id+'\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="取消超管"><i class="Hui-iconfont">&#xe6ba;</i></span></a>'
			}
			if(data.admin_use==1){
				var bd_type='<span style="color:green;">已启用</span>';
					info+='<a title="禁用" href="javascript:;" onclick="unuse(\''+data.admin_id+'\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="禁用"><i class="Hui-iconfont">&#xe6e4;</i></span></a>'
			}else if(data.admin_use==0){
				var bd_type='<span style="color:red;">已禁用</span>';
					info+='<a title="启用" href="javascript:;" onclick="opuse(\''+data.admin_id+'\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="启用"><i class="Hui-iconfont">&#xe601;</i></span></a>'
			}
			/*var info='<a title="编辑" href="javascript:;" onclick="member_edit(\'编辑\',\'member-add.html\',4,\'\',510)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="member_del(this,1)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>';*/
			$(row).find('td:eq(9)').html(isroot);
			$(row).find('td:eq(11)').html(bd_type);
			$(row).find('td:eq(12)').html(info);
			$(row).addClass('text-c');
			/*var img="<img src='"+data.cover_img+"' alt='暂时没有图片' width='130' height='100'>";
			$(row).find('td:eq(5)').html(img);*/
			/*var video_btn='<input class="btn btn-success-outline radius" onClick="start_play('+data.lesson_id+')" type="button" value="播放视频">';
			$(row).find('td:eq(6)').html(video_btn);*/
		
		}
	
		
		}
	dataTable=$('#admin_index_table').DataTable($.tablesetting);
		$('#addadmin').on('click',function(){
				layer_show('添加账户',"{{url('admin/admin/addadmin')}}",500,300);
		});
		$('#addgroup').on('click',function(){
				layer_show('添加分组',"{{url('admin/admin/addgroup')}}",500,200);
		});
		function del_admin(admin_id){
				var msg =confirm("确定要删除此账户？");
				if(msg){
		        		layer.msg('删除中');
		        			$.ajax({
							url:"{{url('admin/admin/deladmin')}}",
							type:'get',
							data:{'id':admin_id},
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
		               			 $('#admin_index_table').dataTable().fnClearTable(); 
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
		function ch_root(admin_id){
				var msg =confirm("确定要将此账户设置为超级管理员？");
				if(msg){
		        		layer.msg('更改中');
		        			$.ajax({
							url:"{{url('admin/admin/ch_root')}}",
							type:'get',
							data:{'id':admin_id},
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
		               			 $('#admin_index_table').dataTable().fnClearTable(); 
					           }else if(msg['err']==0){
					           	 layer.msg(msg.str);
					           }else{
					           	 layer.msg('更改失败！');
					           }
							}
						})
		        	}else{
		                
		        	}
		}
		function cl_root(admin_id){
				var msg =confirm("确定要将此账户设置为超级管理员？");
				if(msg){
		        		layer.msg('更改中');
		        			$.ajax({
							url:"{{url('admin/admin/cl_root')}}",
							type:'get',
							data:{'id':admin_id},
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
		               			 $('#admin_index_table').dataTable().fnClearTable(); 
					           }else if(msg['err']==0){
					           	 layer.msg(msg.str);
					           }else{
					           	 layer.msg('更改失败！');
					           }
							}
						})
		        	}else{
		                
		        	}
		}
		function unuse(admin_id){
				var msg =confirm("确定要禁用此账户？");
				if(msg){
		        		layer.msg('更改中');
		        			$.ajax({
							url:"{{url('admin/admin/unuse')}}",
							type:'get',
							data:{'id':admin_id},
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
		               			 $('#admin_index_table').dataTable().fnClearTable(); 
					           }else if(msg['err']==0){
					           	 layer.msg(msg.str);
					           }else{
					           	 layer.msg('更改失败！');
					           }
							}
						})
		        	}else{
		                
		        	}
		}
		function opuse(admin_id){
				var msg =confirm("确定要启用此账户？");
				if(msg){
		        		layer.msg('更改中');
		        			$.ajax({
							url:"{{url('admin/admin/opuse')}}",
							type:'get',
							data:{'id':admin_id},
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
		               			 $('#admin_index_table').dataTable().fnClearTable(); 
					           }else if(msg['err']==0){
					           	 layer.msg(msg.str);
					           }else{
					           	 layer.msg('更改失败！');
					           }
							}
						})
		        	}else{
		                
		        	}
		}
		function admin_update(title,url,type,w,h){
			layer_show(title,url,w,h);
		}
		$('#addrole').on('click',function(){
			layer_show('添加角色','/admin/admin/addrole',300,200);
		})
</script>
@endsection