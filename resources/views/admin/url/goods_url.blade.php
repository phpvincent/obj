@extends('admin.father.css')
@section('content')
<div class="page-container">
	<!-- <div class="cl pd-5 bg-1 bk-gray"> <span class="l"> <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> --> <a class="btn btn-primary radius" href="javascript:;" onclick="url_add('添加域名','{{url("admin/url/url_add")}}',100,400)"><i class="Hui-iconfont">&#xe600;</i> 添加域名</a> </span>
		<button type="button" class="btn btn-secondary radius" style="border-radius: 8%;" id="add_account" name=""><i class="Hui-iconfont"></i> 添加广告账户</button>
		<button type="button" class="btn btn-secondary radius" style="border-radius: 8%;" id="update_account" name=""><i class="Hui-iconfont">&#xe60c;</i> 修改广告账户</button>
		<div style="margin:0px 45%;"><br/><a href="javascript:0;" id="geturl_type" class="btn btn-primary radius"><i class="icon Hui-iconfont"></i> 筛选</a></div><br/>

		<div class="row cl" style="margin-top: 20px;display: none;" id="change_type">
			<label class="form-label col-xs-1 col-sm-1">FB标记：</label>
			<div class="formControls col-xs-2 col-sm-2"> <span class="select-box">
					<select name="url_flag_fb" id="url_flag_fb" class="select">
						<option value="0">无</option>
						<option value="1">FB标记</option>s
					</select>
					</span>
			</div>
			<label class="form-label col-xs-1 col-sm-1">Google标记：</label>
			<div class="formControls col-xs-2 col-sm-2"> <span class="select-box">
					<select name="url_flag_google" id="url_flag_google" class="select">
						<option value="0">无</option>
						<option value="1">Google标记</option>
					</select>
					</span>
			</div>
			<label class="form-label col-xs-1 col-sm-1">YaHoo标记：</label>
			<div class="formControls col-xs-2 col-sm-2"> <span class="select-box">
					<select name="url_flag_yahoo" id="url_flag_yahoo" class="select">
						<option value="0">无</option>
						<option value="1">YaHoo标记</option>
					</select>
					</span> </div>
			<label class="form-label col-xs-1 col-sm-1">绑定状态：</label>
			<div class="formControls col-xs-2 col-sm-2"> <span class="select-box">
					<select name="bind_status" id="bind_status" class="select">
						<option value="0">无</option>
						<option value="1">仅绑定商品</option>
						<option value="2">仅绑定遮罩</option>
						<option value="3">绑定遮罩和商品</option>
						<option value="4">未绑定域名</option>
					</select>
					</span> </div>
		</div>
	 <span class="r">共有数据：<strong>{{$counts}}</strong> 条</span> </div>
	<table class="table table-border table-bordered table-hover table-bg" id="url_goods">
		<thead>
			<tr>
				<th scope="col" colspan="7">域名分配</th>
			</tr>
			<tr class="text-c">
				<th width="40">ID</th>
				<th width="80">域名</th>
				<th width="200">正常单品</th>
				<th width="200">遮罩单品</th>
				<th width="40">状态</th>
				<th width="80">标记</th>
				<th width="70">操作</th>
			</tr>
		</thead>
		
	</table>
</div>
@endsection
@section('js')
<script type="text/javascript">
	$.tablesetting={
	"lengthMenu": [[10,20,30],[10,20,30]],
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
		"data":{
			url_flag_fb:function(){return $('#url_flag_fb').val()},
			url_flag_google:function(){return $('#url_flag_google').val()},
			url_flag_yahoo:function(){return $('#url_flag_yahoo').val()},
            bind_status:function(){return $('#bind_status').val()},
		},
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
			if(data.url_flag[0]!=null&&data.url_flag[0]!=''){
				var flag='<span style="color:red">已被';
				if(isInArray(data.url_flag,'0')){
					flag+=' [FB] ';
				}
				if(isInArray(data.url_flag,'1')){
					flag+=' [Yahoo] ';
				}
				if(isInArray(data.url_flag,'2')){
					flag+=' [Google] ';
				}
				flag+='标记</span><br/><button id="clear_flag"  class="btn btn-default" onclick="clear_flag('+data.url_id+')"><i class="Hui-iconfont">&#xe72a;</i></button>';
			}else{
				var flag='<span style="color:green">正常</span>';
			}
			/*var checkbox='<input type="checkbox" name="" value="">';*/
			/*var info='<a title="编辑" href="javascript:;" onclick="member_edit(\'编辑\',\'member-add.html\',4,\'\',510)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="member_del(this,1)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>';*/
			$(row).find('td:eq(6)').html(info);
			$(row).find('td:eq(5)').html(flag);
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
 function isInArray(arr,value){
    for(var i = 0; i < arr.length; i++){
        if(value === arr[i]){
            return true;
        }
    }
    return false;
}
$('#url_flag_google').on('click',function(){
	               			 $('#url_goods').dataTable().fnClearTable(); 

})
$('#url_flag_fb').on('click',function(){
	               			 $('#url_goods').dataTable().fnClearTable(); 

})
$('#url_flag_yahoo').on('click',function(){
	               			 $('#url_goods').dataTable().fnClearTable(); 

})
$('#bind_status').on('click',function(){
	               			 $('#url_goods').dataTable().fnClearTable();

})
function clear_flag(id){
	var msg =confirm("确定要清除此域名上的标记？");
	if(msg){
		layer.msg('清除中');
        		$.ajax({
					url:"{{url('admin/url/clear_flag')}}",
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
			           	 layer.msg('清除失败！');
			           }
					}
		})
	}
}
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
$('#add_account').click(function(){
	layer_show('广告账户添加','{{url("admin/url/add_account")}}',500,300);
})
$('#update_account').click(function(){
	layer_show('广告账户修改','{{url("admin/url/update_account")}}',600,500);
})
$('#geturl_type').on('click',function(){
	$('#change_type').toggle(200);
})
</script>
@endsection