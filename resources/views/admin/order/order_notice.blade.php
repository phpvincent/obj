@extends('admin.father.css')
@section('content')
<div class="page-container">
	<input class="btn radius btn-secondary" type="button" value="+新增订单通知" style="margin-left: 10%;" onclick="new_notice('新增订单通知','/admin/order/order_notice/add','2','800','500')">
	<div class="row cl" style="margin-top: 20px;">
			<label class="form-label col-xs-1 col-sm-1">语种：</label>
			<div class="formControls col-xs-2 col-sm-2"> <span class="select-box">
				<select name="languages" id="languages" class="select">
							<option value="0">所有</option>
							@foreach($languages as $k => $v)
								<option value="{{$k}}">{{$v}}</option>
							@endforeach
				</select>
			</span>
			</div>
	</div>
<table class="table table-border table-bordered table-bg" id="comment_user_table">
		<thead>
			<tr>
				<th scope="col" colspan="11">配置信息</th>
			</tr>
			<tr class="text-c">
				<th width="20">id</th>
				<th width="20">语种</th>
				<th width="20">通知手机号</th>
				<th width="30">状态</th>
				<th width="40">工作时间</th>
				<th width="30">上次分配任务时间</th>
				<th width="40">分配任务次数</th>
				<th width="40">完成任务次数</th>
				<th width="20">操作</th>
			</tr>
		</thead>
		<tbody>
			<img src="">
		</tbody>
</table>
</div>
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
		"order": [[ 0, "desc" ]],
		"stateSave": false,
		"columnDefs": [{
		   "targets": [1,2,3,4,8],
		   "orderable": false
		}],
		"processing": true,
		"serverSide": true,
		"ajax": {
		"url": "{{url('admin/order/order_notice')}}",
		"type": "POST",
		'headers': { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
		"data":{
			order_notice_lan:function(){return $('#languages').val()},
		}
		},
		
		"columns": [
		{"data":'order_notice_id'},
		{'defaultContent':"","className":"td-manager"},
		{'data':'order_notice_phone'},
		{'defaultContent':"","className":"td-manager"},
		{'defaultContent':"","className":"td-manager"},
		{'data':'order_notice_time'},
		{'data':'order_notice_num'},
		{'data':'order_notice_end_num'},
		{'defaultContent':"","className":"td-manager"},
/*		{'data':'course.profession.pro_name'},
		{'defaultContent':""},
		{'defaultContent':""},
		{'data':'created_at'},
		{'defaultContent':"","className":"td-manager"},*/
		],
		"createdRow":function(row,data,dataIndex){
			var info='<a title="编辑" href="javascript:;" onclick="change_no(\'修改订单通知\',\'/admin/order/order_notice/ch?id='+data.order_notice_id+'\',\'2\',\'800\',\'500\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="编辑"><i class="Hui-iconfont">&#xe61d;</i></span></a>';
			if(data.order_notice_status==1){
				info+='<a title="禁用" href="javascript:;" onclick="ch_notice(\''+data.order_notice_id+'\',\''+0+'\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="禁用"><i class="Hui-iconfont">&#xe6de;</i></span></a>'
			}else if(data.order_notice_status==0){
				info+='<a title="启用" href="javascript:;" onclick="ch_notice(\''+data.order_notice_id+'\',\''+1+'\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="启用"><i class="Hui-iconfont">&#xe6dc;</i></span></a>'
			}
			var time=data.order_notice_start+' ~ '+data.order_notice_end;
			var status=''
			if(data.order_notice_status==1){
				status+='<span style="color:green">已启用</span>'
			}else if(data.order_notice_status==0){
				status+='<span style="color:red">已禁用</span>'
			}
			var lan=''
				if(data.order_notice_lan==1){
					 lan+='中文'
				}else if(data.order_notice_lan==2){
					 lan+='阿拉伯语'
				}else if(data.order_notice_lan==3){
					 lan+='马来语'
				}else if(data.order_notice_lan==4){
					 lan+='泰语'
				}else if(data.order_notice_lan==5){
					 lan+='日语'
				}else if(data.order_notice_lan==6){
					 lan+='印尼语'
				}else if(data.order_notice_lan==7){
					 lan+='英语'
				}else if(data.order_notice_lan==8){
					lan+='越南语'
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
			$(row).find('td:eq(1)').html(lan);
			$(row).find('td:eq(4)').html(time);
			$(row).find('td:eq(8)').html(info);
			$(row).find('td:eq(3)').html(status);
			$(row).addClass('text-c');
			/*var img="<img src='"+data.cover_img+"' alt='暂时没有图片' width='130' height='100'>";
			$(row).find('td:eq(5)').html(img);*/
			/*var video_btn='<input class="btn btn-success-outline radius" onClick="start_play('+data.lesson_id+')" type="button" value="播放视频">';
			$(row).find('td:eq(6)').html(video_btn);*/
		}
	
}
 dataTable =$('#comment_user_table').DataTable($.tablesetting);
 function ch_notice(id,status){
		var msg =confirm("确定更改状态？");
		if(msg){
        		layer.msg('处理中');
        		$.ajax({
					url:"{{url('admin/order/ch_notice')}}",
					type:'get',
					data:{'id':id,'status':status},
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
			           	 layer.msg('更改失败！');
			           }
					}
				})

		}else{

		}

}
$('#languages').on('change',function(){
	dataTable.ajax.reload();
});
function new_notice(title,url,type,w,h){
	layer_show(title,url,w,h);
}
function change_no(title,url,type,w,h){
	layer_show(title,url,w,h);
}

</script>
@endsection