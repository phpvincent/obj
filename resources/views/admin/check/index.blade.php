@extends('admin.father.css')
@section('content')
<div class="page-container">
	   
			<div class="mt-20 skin-minimal" style="margin:0px auto;width: 50%;">
				<span>状态分辨：</span>
		  <div class="radio-box">
		    <input type="radio" id="radio-pb" class='radio-pb' name="ischeck" value="0" checked="checked">
		    <label for="radio-1">所有</label>
		  </div>
		  <div class="radio-box">
		    <input type="radio" id="radio-pb" class='radio-pb' name="ischeck" value="1">
		    <label for="radio-2">驳回核审</label>
  		 </div>
		  <div class="radio-box">
			<input type="radio" id="radio-pb" class='radio-pb' name="ischeck" value="2">
			<label for="radio-2" style="color: red;">已被屏蔽</label>
		  </div>
		
  @if(\Auth::user()->is_root=='1)
  <div style="margin:0px 45%;"><br/><a href="javascript:0;" id="getvis" class="btn btn-primary radius"><i class="icon Hui-iconfont"></i>过滤</a></div><br/>
	<div style="display: none" id="select-admin">
		<div class="row cl">
				<label class="form-label col-xs-4 col-sm-2">账户组：</label>
				<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
					<select name="admin_check" id="admin_check" class="select">
						<option value="0">所有</option>
						@foreach(\App\admin_group::all() as $k => $v)
						<option value="{{$v->admin_group_id}}">{{$v->admin_group_name}}</option>
						@endforeach
					</select>
					</span> </div>
			</div>

	</div>
	</div>
	@else
	<div style="display: none" id="select-admin">
		<div class="row cl">
				<label class="form-label col-xs-4 col-sm-2">账户组：</label>
				<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
					<select name="admin_check" id="admin_check" class="select">
						<option value="{{\Auth::user()->admin_group}}" selected="selected"></option>
						
					</select>
					</span> </div>
			</div>
	</div>
	@endif
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><!-- <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a href="javascript:;" onclick="admin_add('添加管理员','admin-add.html','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a> --></span> <span class="r">共有数据：<strong>{{$counts}}</strong> 条</span> </div>
	<table class="table table-border table-bordered table-bg" id="check_index_table">
		<thead>
			<tr>
				<th scope="col" colspan="15">审核统计</th>
			</tr>
			<tr class="text-c">
				<th width="40">ID</th>
				<th width="80">单品名</th>
				<th width="60">发布者</th>
				<th width="40">绑定域名</th>
				<th width="60">触发审核时间</th>
				<th width="30">今日触发次数</th>
				<th width="40">剩余保护时间</th>
				<th width="30">核审状态</th>
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
		"order": [[ 4, "desc" ]],
		"stateSave": false,
		"columnDefs": [{
		   "targets": [1,2,3,6,7],
		   "orderable": false
		}],
		"processing": true,
		"serverSide": true,
		"ajax": {
		"url": "{{url('admin/check/getcheck')}}",
		"type": "POST",
		"data":{
			ischeck:function(){return $('input[name="ischeck"]:checked').val()},
			chvis:function(){return $('#admin_check').val()},
		},
		'headers': { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
		},
		"columns": [
		{"data":'goods_id'},
		{"data":'goods_real_name'},
		{"data":'admin_name'},
		{'defaultContent':"","className":"td-manager"},
		{'data':'goods_check_time'},
		{'data':'goods_check_num'},
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
			var info='<a title="预览" href="javascript:;" onclick="goods_show(\'商品预览\',\'{{url("admin/goods/show")}}?id='+data.goods_id+'\',\'2\',\'1400\',\'800\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="预览"><i class="Hui-iconfont">&#xe64f;</i></span></a><a title="编辑" href="javascript:;" onclick="goods_update(\'商品编辑\',\'{{url("admin/goods/chgoods")}}?id='+data.goods_id+'&recheck=1\',\'2\',\'1400\',\'800\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></span></a><a title="通过核审" href="javascript:;" onclick="go_go('+data.goods_id+')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="通过核审"><i class="Hui-iconfont">&#xe6e1;</i></span></a><a title="拒绝核审" href="javascript:;" onclick="no_go('+data.goods_id+')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="拒绝核审"><i class="Hui-iconfont" style="color:red;">&#xe6dd;</i></span></a><a title="重置保护时间" href="javascript:;" onclick="re_go('+data.goods_id+')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="重置保护时间"><i class="Hui-iconfont" style="color:green;">&#xe66b;</i></span></a>';
			if(data.url_url!=null){
							var url='<a href="http://'+data.url_url+'" style="margin:0px auto;" target="view_window" >'+data.url_url+'</a>';
			}else{
							var url='暂未绑定域名';
			}
			if(data.goods_heshen==0){
				var heshen='等待核审';
			}else if(data.goods_heshen==2){
				var heshen='已拒绝核审';
			}else{
				var heshen=data.goods_heshen;
			}
			if(typeof(data.less_time)=='number'){
				if(data.less_time>-300){
					$(row).find('td:eq(6)').html("<span style='color:red' >"+Math.abs(data.less_time)+'秒</span>');
				}else{
					$(row).find('td:eq(6)').html("<span style='color:green' >"+Math.abs(data.less_time)+'秒</span>');
				}
			}else{
				$(row).find('td:eq(6)').html(data.less_time);
			}
			/*var info='<a title="编辑" href="javascript:;" onclick="member_edit(\'编辑\',\'member-add.html\',4,\'\',510)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="member_del(this,1)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>';*/
			$(row).find('td:eq(7)').html(heshen);
			$(row).find('td:eq(8)').html(info);
			$(row).find('td:eq(3)').html(url);
			$(row).addClass('text-c');
			/*var img="<img src='"+data.cover_img+"' alt='暂时没有图片' width='130' height='100'>";
			$(row).find('td:eq(5)').html(img);*/
			/*var video_btn='<input class="btn btn-success-outline radius" onClick="start_play('+data.lesson_id+')" type="button" value="播放视频">';
			$(row).find('td:eq(6)').html(video_btn);*/
		}
	}
 dataTable =$('#check_index_table').DataTable($.tablesetting);
$('#seavis').on('click',function(){
	dataTable.draw();
})
$('#getvis').on('click',function(){
	$('#select-admin').show(300);
})
$('.radio-pb').on('click',function(){
/*dataTable.destroy();*/
/* dataTable =$('#check_index_table').DataTable($.tablesetting);
		dataTable.ajax.url( "{{url('admin/vis/getindex')}}?ispb="+$('input[name="ispb"]:checked').val()).load();*/
	dataTable.draw();
})
$('#admin_check').on('change',function(){
	dataTable.ajax.reload();
	
})
function re_go(id){
	var msg =confirm("确定要将次单品保护时间重置为1800秒？");
		if(msg){
        		layer.msg('修改中');
        			$.ajax({
					url:"{{url('admin/check/re_check')}}",
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
               			 $('#check_index_table').dataTable().fnClearTable(); 
			           }else if(msg['err']==0){
			           	 layer.msg(msg.str);
			           }else{
			           	 layer.msg('修改失败！');
			           }
					}
				})
        	}else{
                
        	}
	}
function goods_show(title,url,type,w,h){
	layer_show(title,url,w,h);
}
function go_go(id){
		var msg =confirm("确定要通过此核审？");
		if(msg){
        		layer.msg('修改中');
        			$.ajax({
					url:"{{url('admin/check/go_check')}}",
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
               			 $('#check_index_table').dataTable().fnClearTable(); 
			           }else if(msg['err']==0){
			           	 layer.msg(msg.str);
			           }else{
			           	 layer.msg('修改失败！');
			           }
					}
				})
        	}else{
                
        	}
	}
function no_go(id){
		var msg =confirm("拒绝核审后单品有30分钟保护期，请联系单品发布人员，确定？");
		if(msg){
        		layer.msg('修改中');
        			$.ajax({
					url:"{{url('admin/check/no_check')}}",
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
               			 $('#check_index_table').dataTable().fnClearTable(); 
			           }else if(msg['err']==0){
			           	 layer.msg(msg.str);
			           }else{
			           	 layer.msg('修改失败！');
			           }
					}
				})
        	}else{
                
        	}
	}
function goods_update(title,url,type,w,h){
	layer_show(title,url,w,h);
}
</script>
@endsection