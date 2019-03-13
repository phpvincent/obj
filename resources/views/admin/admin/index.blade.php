@extends('storage.father.static')
@section('content')
<div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-header">管理员列表</div>
                    <div class="layui-row">
					    <button class="layui-btn layui-btn-sm" style="margin-left: 15px" id="addrole"><i class="layui-icon">&#xe654;</i>添加角色</button>
						<button class="layui-btn layui-btn-sm" id="outgoods" onclick="location.href='{{url('/admin/admin/chrole')}}'"><i class="layui-icon">&#xe672;</i>权限分配</button>
						<button class="layui-btn layui-btn-sm" id="addadmin"><i class="layui-icon">&#xe66f;</i>添加账户</button>
						<button class="layui-btn layui-btn-sm" id="addgroup"><i class="layui-icon">&#xe613;</i>添加分组</button>
						<div style="float: right; margin-right: 10px"><span class="r">共有数据：<strong>{{$counts}}</strong> 条</span></div>
					</div>
					<div class="layui-row">
                      <div class="layui-form layui-card-header layuiadmin-card-header-auto">
					    <div class="layui-form-item">

                           <div class="layui-inline" @if(Auth::user()->is_root!='1') style="display: none" @endif id="select-admin">
                           <label class="layui-form-label">分组:</label>
                           <div class="layui-input-block" style="width: 200px">
                             <select name="group_name" id="group_name" lay-verify="required">
							 <option value="0">所有</option>
						          @foreach(\App\admin_group::get() as $val)
						          <option value="{{$val->admin_group_id}}" >{{$val->admin_group_name}}</option>
						          @endforeach
                             </select>
                           </div>
						   </div>
						   <div class="layui-inline">
						      <label>从当前数据中检索:</label>
						   </div>
						   <div class="layui-inline">
						      <input class="layui-input" name="id" id="table-seach" autocomplete="off">
						   </div>
						   <div class="layui-inline">
						      <button class="layui-btn" id="reload">搜索</button>
						   </div>

                         </div>
					  </div> 
					</div>
                    <div class="layui-card-body">
					    <table class="" id="admin_index_table" lay-filter="admin_index_tables"></table>
					</div>
				</div>
			</div>
		</div>
</div>

@endsection
@section('js')
<script>
    layui.config({
        base: '/admin/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'table', 'laytpl', 'laydate', 'layer'], function () {
        var table = layui.table,
            admin = layui.admin,
			layer = layui.layer,
			$ = layui.$;

		$('#addrole').on('click',function(){
          layer.open({
            type: 2, 
			title: '添加角色',
            content: "/admin/admin/addrole" //这里content是一个普通的String
          });
		});
		$('#addadmin').on('click',function(){
          layer.open({
            type: 2, 
			title: '添加账户',
			area: ['500px', '500px'],
            content: "{{url('admin/admin/addadmin')}}" //这里content是一个普通的String
          });
		});
		$('#addgroup').on('click',function(){
          layer.open({
            type: 2, 
			title: '添加分组',
			area: ['500px', '250px'],
            content: "{{url('admin/admin/addgroup')}}" //这里content是一个普通的String
          });
		});

		var tableObj = table.render({
                        elem: '#admin_index_table'
                        , url: "{{url('admin/admin/get_table')}}"
                        , method: 'post'
                        , headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
                        , cols: [[
                            {field: 'admin_id', width: 70, title: 'ID', sort: true}
                            , {field: 'admin_name', width: 110, title: '账户名'}
                            , {field: 'admin_show_name', width: 110, title: '所有人'}
                            , {field: 'admin_ip', width: 110, title: '上次登录IP', align: 'center'}
                            , {field: 'admin_time', minWidth: 180, title: '上次登陆时间'}
                            , {field: 'admin_num', width: 100, align: 'center', title: '登陆次数'}
							, {field: 'role_name', width: 110, title: '所属角色'}
							, {field: 'goods_num', width: 110, title: '拥有单品数'}
							, {field: 'orders_num', width: 110, title: '下单数'}
							, {field: 'day_sale', minWidth: 140, title: '今日销售额(￥)'}
							, {field: 'is_root', width: 100, title: '是否超管' ,  templet: function(d){
								if(d.is_root==0||d.is_root==null){
			                    	var isroot='<span class="label label-default radius">×</span>';
			                    }else{ var isroot='<span class="label label-success radius">√</span>';}
								return isroot
							}}
							, {field: 'admin_group', width: 110, title: '所属分组'}
							, {field: 'admin_use', width: 100, title: '是否启用', templet: function(d){
								if(d.admin_use==1){
			                    	var bd_type='<span style="color:green;">已启用</span>';
			                    }else if(d.admin_use==0){
			                    	var bd_type='<span style="color:red;">已禁用</span>';
			                    }
								return bd_type
							}}
                            , {field: 'goods_kind_volume', fixed: 'right', width: 150, align: 'center', title: '操作', templet: function(d){
								var info='<a title="编辑" href="javascript:;" lay-event="admin_update" class="ml-5" style="text-decoration:none"><button class="layui-btn layui-btn-xs" title="编辑"><i class="layui-icon">&#xe642;</i></button></a><a title="删除" href="javascript:;" lay-event="del" class="ml-5" style="text-decoration:none"><button class="layui-btn layui-btn-danger layui-btn-xs" title="删除"><i class="layui-icon">&#xe640;</i></button></a>';
			                    if(d.is_root==0||d.is_root==null){
			                    	var isroot='<span class="label label-default radius">×</span>';
			                    	if(d.is_root!=null){
			                    		info+='<a title="设为超管" href="javascript:;" lay-event="ch_root" class="ml-5" style="text-decoration:none"><button class="layui-btn layui-btn-normal layui-btn-xs" title="设为超管"><i class="layui-icon">&#xe672;</i></button></a>'
			                    	}
			                    }else{
			                    	var isroot='<span class="label label-success radius">√</span>';
			                    	info+='<a title="取消超管" href="javascript:;" lay-event="cl_root" class="ml-5" style="text-decoration:none"><button class="layui-btn layui-btn-normal layui-btn-xs" title="取消超管"><i class="layui-icon">&#xe672;</i></button></a>'
			                    }
			                    if(d.admin_use==1){
			                    	var bd_type='<span style="color:green;">已启用</span>';
			                    		info+='<a title="禁用" href="javascript:;" lay-event="unuse" class="ml-5" style="text-decoration:none"><button class="layui-btn layui-btn-normal layui-btn-xs" title="禁用"><i class="layui-icon">&#xe643;</i></button></a>'
			                    }else if(d.admin_use==0){
			                    	var bd_type='<span style="color:red;">已禁用</span>';
			                    		info+='<a title="启用" href="javascript:;" lay-event="opuse" class="ml-5" style="text-decoration:none"><button class="layui-btn layui-btn-normal layui-btn-xs" title="启用"><i class="layui-icon">&#xe643;</i></button></a>'
			                    }
								return info
							}}
                        ]]
                        , page: true
                    });
		function reload() {
		   tableObj.reload({
               page: {
                   curr: 1 //重新从第 1 页开始
               }
               , where: {
                   search: $('#table-seach').val(),
                   product_type_id: $('#group_name').val()
               }
           });
		}
        // 点击搜索
		$('#reload').on('click',function(){ reload() })

		//监听工具条（操作动作）
		table.on('tool(admin_index_tables)', function (obj) {
           var data = obj.data; console.log(obj)
		   if (obj.event === 'admin_update') {
			   layer.open({
               type: 2, 
			   title: '账户编辑',
			   area: ['500px', '500px'],
               content: "{{url('admin/admin/upadmin')}}?id=" + data.admin_id //这里content是一个普通的String
               })
		   } else if (obj.event === 'del') {
			  var msg =confirm("确定要删除此账户？");
		  		if(msg){
		          		layer.msg('删除中');
		          			$.ajax({
		  					url:"{{url('admin/admin/deladmin')}}",
		  					type:'get',
		  					data:{'id':data.admin_id},
		  					datatype:'json',
		  					success:function(msg){
		  			           if(msg['err']==1){
		  			           	 layer.msg(msg.str);
		                 			 reload();
		  			           }else if(msg['err']==0){
		  			           	 layer.msg(msg.str);
		  			           }else{
		  			           	 layer.msg('删除失败！');
		  			           }
		  					}
		  				})
		          	}
		   } else if (obj.event ==='ch_root') {
			var msg =confirm("确定要将此账户设置为超级管理员？");
				if(msg){
		        		layer.msg('更改中');
		        			$.ajax({
							url:"{{url('admin/admin/ch_root')}}",
							type:'get',
							data:{'id':data.admin_id},
							datatype:'json',
							success:function(msg){
					           if(msg['err']==1){
					           	 layer.msg(msg.str);
		               			 reload();
					           }else if(msg['err']==0){
					           	 layer.msg(msg.str);
					           }else{
					           	 layer.msg('更改失败！');
					           }
							}
						})
		        	}
		   } else if (obj.event ==='cl_root') {
			var msg =confirm("确定要将此账户设置为超级管理员？");
				if(msg){
		        		layer.msg('更改中');
		        			$.ajax({
							url:"{{url('admin/admin/cl_root')}}",
							type:'get',
							data:{'id':data.admin_id},
							datatype:'json',
							success:function(msg){
					           if(msg['err']==1){
					           	 layer.msg(msg.str);
		               			 reload();
					           }else if(msg['err']==0){
					           	 layer.msg(msg.str);
					           }else{
					           	 layer.msg('更改失败！');
					           }
							}
						})
		        	}
		   } else if (obj.event ==='unuse') {
			var msg =confirm("确定要禁用此账户？");
				if(msg){
		        		layer.msg('更改中');
		        			$.ajax({
							url:"{{url('admin/admin/unuse')}}",
							type:'get',
							data:{'id':data.admin_id},
							datatype:'json',
							success:function(msg){
					           if(msg['err']==1){
					           	 layer.msg(msg.str);
									reload();
					           }else if(msg['err']==0){
					           	 layer.msg(msg.str);
					           }else{
					           	 layer.msg('更改失败！');
					           }
							}
						})
		        	}
		   } else if (obj.event ==='opuse') {
			var msg =confirm("确定要启用此账户？");
				if(msg){
		        		layer.msg('更改中');
		        			$.ajax({
							url:"{{url('admin/admin/opuse')}}",
							type:'get',
							data:{'id':data.admin_id},
							datatype:'json',
							success:function(msg){
					           if(msg['err']==1){
					           	 layer.msg(msg.str);
									reload();
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
		})

	})
</script>

@endsection