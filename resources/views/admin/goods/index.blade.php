@extends('admin.father.css')
@section('content')
<div class="page-container">
	<div class="text-c"> 日期范围：
		<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d %H:%m:%s\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
		-
		<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d %H:%m:%s' })" id="datemax" class="input-text Wdate" style="width:120px;">
		<!-- <input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name=""> -->
		<button type="submit" class="btn btn-success" id="seavis2" name=""><i class="Hui-iconfont">&#xe665;</i> 搜记录</button>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><!-- <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> --> @if(Auth::user()->is_root=='1')<a href="javascript:;" onclick="location.href='/admin/url/goods_url'" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 域名绑定</a>&nbsp;&nbsp;&nbsp;@endif
		<button type="submit" class="btn btn-success" style="border-radius: 8%;" id="outgoods" name=""><i class="Hui-iconfont">&#xe640;</i> 数据导出</button>
		<button type="button" class="btn btn-secondary radius" style="border-radius: 8%;" id="addgoods" name=""><i class="Hui-iconfont">&#xe61f;</i> 添加单品</button>
		<!-- <button type="button" class="btn btn-warning radius" style="border-radius: 8%;" id="addgoods_type" name=""><i class="Hui-iconfont">&#xe61f;</i> 添加单品种类</button> -->
		<!-- <button type="button" class="btn btn-primary-outline radius" style="border-radius: 8%;" id="addgoods_kind" name=""><i class="Hui-iconfont">&#xe61f;</i> 添加新产品</button> --></span> <span class="r">共有数据：<strong>{{$counts}}</strong> 条</span> </div>
		<br>
		<div style="width: 100%;">
			<div style="margin-bottom: 20px" class="row cl">
			<label class="form-label col-xs-1 col-sm-1">单品类型：</label>
			<div class="formControls col-xs-2 col-sm-2"> <span class="select-box">
				<select name="goods_type" id="goods_type" class="select">
					<option value="0">所有</option>
					@foreach($type as $val)
					<option value="{{$val->goods_type_id}}" >{{$val->goods_type_name}}</option>
					@endforeach
				</select>
				</span>
			</div>
			<label class="form-label col-xs-1 col-sm-1">核审状态：</label>
			<div class="formControls col-xs-2 col-sm-2"> <span class="select-box">
				<select name="check_type" id="check_type" class="select">
					<option value="#">所有</option>
					<option value="1">正常状态</option>
					<option value="0">等待核审状态</option>
					<option value="2">拒绝核审状态</option>
					<option value="@">保护期内</option>
					<option value="$">保护期已过</option>
				</select>
				</span>
			</div>
			<label class="form-label col-xs-1 col-sm-1">币种：</label>
			<div class="formControls col-xs-2 col-sm-2"> <span class="select-box">
				<select name="pay_type" id="pay_type" class="select">
					<option value="0">所有</option>
					@foreach(\App\currency_type::get() as $k => $v)
						<option value="{{$v->currency_type_id}}">{{$v->currency_type_name}}</option>
					@endforeach
				</select>
				</span>
			</div>
			<label class="form-label col-xs-1 col-sm-1">语种：</label>
				<div class="formControls col-xs-2 col-sm-2"> <span class="select-box">
						@if(Auth::user()->languages == 0)
						<select name="languages" id="languages" class="select">
							<option value="0">所有</option>
							@foreach($languages as $k => $v)
								<option value="{{$k}}">{{$v}}</option>
							@endforeach
						</select>
						@else
						<div><input readonly name="languages" id="languages" style="display: none" value="{{Auth::user()->languages}}" type="text">{{$languages[Auth::user()->languages]}}</div>
						@endif
				</span> </div>
				<br/></div>
			<div style="margin-bottom: 20px" class="row cl">
			<label class="form-label col-xs-1 col-sm-1">产品名称：</label>
			<div class="formControls col-xs-2 col-sm-2"> <span class="select-box">
						<select name="goods_kind" id="goods_kind" class="select">
							<option value="0">所有</option>
							@foreach($goods_kind as  $v)
								@if(isset($_GET['id']))
									<option @if($_GET['id'] == $v->goods_kind_id) selected @endif  value="{{$v->goods_kind_id}}">{{$v->goods_kind_name}}</option>
								@else
									<option  value="{{$v->goods_kind_id}}">{{$v->goods_kind_name}}</option>
								@endif
							@endforeach
						</select>
				</span> </div>
			<br/></div>

	<table class="table table-border table-bordered table-bg" id="goods_index_table">
		<thead>
			<tr>
				<th scope="col" colspan="14">单品列表</th>
			</tr>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="" value=""></th>
				<th width="40">ID</th>
				<th width="110">单品名</th>
				<th width="110">单品展示名</th>
				<th width="70">单品价格</th>
				<th width="100">绑定域名</th>
				<th width="130">促销信息</th>
				<th width="40">是否启用</th>

				<th width="100">发布时间</th>
				<th width="80">发布人</th>
				<th width="80">审核状态</th>
				<th width="80">保护期剩余</th>
				<th width="100">操作</th>
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

function shuaxin(){
$("#goods_index_table").DataTable().draw(false);
}

	$.tablesetting={
	"lengthMenu": [[10,20],[10,20]],
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
			check_type:function(){return $('#check_type').val()},
			pay_type:function(){return $('#pay_type').val()},
            languages:function(){return $('#languages').val()},
            goods_kind:function(){return $('#goods_kind').val()},
		},
		"url": "{{url('admin/goods/get_table')}}",
		"type": "POST",
		'headers': { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
		},
		"columns": [
		{'defaultContent':"","className":"td-manager"},
		{"data":'goods_id'},
		{'data':'goods_real_name'},
		{'data':'goods_name'},
		{'data':'goods_price'},
		{'defaultContent':"","className":"td-manager"},
		{'data':'goods_cuxiao_name'},
		{'defaultContent':"","className":"td-manager"},

		{'data':'goods_up_time'},
		{'data':'admin_show_name'},
		{'defaultContent':"","className":"td-manager"},
		{'data':"less_time"},
		{'defaultContent':"","className":"td-manager"},
		],
		"createdRow":function(row,data,dataIndex){
			var info='<a title="预览" href="javascript:;" onclick="goods_show(\'商品预览\',\'{{url("admin/goods/show")}}?id='+data.goods_id+'\',\'2\',\'800\',\'800\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="预览"><i class="Hui-iconfont">&#xe64f;</i></span><a title="修改商品属性" href="javascript:;" onclick="goods_show(\'修改商品属性\',\'{{url("admin/goods/attr")}}?id='+data.goods_id+'\',\'2\',\'800\',\'800\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="修改商品属性"><i class="Hui-iconfont">&#xe61d;</i></span></a><a title="复制" href="javascript:;" onclick="goods_copy('+data.goods_id+')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="复制"><i class="Hui-iconfont Hui-iconfont-copy"></i></span></a><a title="编辑" href="javascript:;" onclick="goods_update(\'商品编辑\',\'{{url("admin/goods/chgoods")}}?id='+data.goods_id+'\',\'2\',\'1400\',\'800\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></span></a><a title="删除" href="javascript:;" onclick="del_goods(\''+data.goods_id+'\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="删除"><i class="Hui-iconfont">&#xe609;</i></span></a><a title="域名别名" href="javascript:;" onclick="goods_show(\'域名别名\',\'{{url("admin/goods/url/alias")}}?id='+data.goods_id+'\',\'2\',\'400\',\'200\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="域名别名"><i class="Hui-iconfont">&#xe63c;</i></span></a>';
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
			if(data.goods_site_status=='1'){
				   info+='<a title="更改为不显示在站点类目栏" href="javascript:;" onclick="site_status(\''+data.goods_id+'\',\'0\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="更改为不显示在站点类目栏"><i class="Hui-iconfont">&#xe6e0;</i></span></a>'
			}else{
				   info+='<a title="更改为显示在站点类目栏" href="javascript:;" onclick="site_status(\''+data.goods_id+'\',\'1\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="更改为显示在站点类目栏"><i class="Hui-iconfont">&#xe6e1;</i></span></a>'
			}
			if(data.bd_type==1){
				var bd_type='<span style="color:green;">正常单品</span>';
			}else if(data.bd_type==0){
				var bd_type='<span style="color:red;">未绑定</span>';
			}else if(data.bd_type==2){
				var bd_type='<span style="color:brown;">遮罩单品</span>';
			}
			var url='<a href="http://'+data.url_url+'" target="_blank" >'+data.url_url+'</a>';
			if(data.url_url==null){
				url='<span class="label label-default radius" style="color:red;">未绑定域名</span>';
			}
			var checkbox='<input type="checkbox" name="" value="">';
			var check='';
			if(data.goods_heshen==0){
				check='<span style="color:brown;">等待审核</span>';
			}else if(data.goods_heshen==1){
				check='<span style="color:green;">审核通过,正常投放</span>';
			}else if(data.goods_heshen==2){
				check='<span style="color:red;">审核失败!</span>';
			}
			$(row).find('td:eq(10)').html(check);
			$(row).find('td:eq(12)').html(info);
			$(row).find('td:eq(7)').html(isroot);
			$(row).find('td:eq(5)').html(url);
			$(row).find('td:eq(0)').html(checkbox);
			$(row).addClass('text-c');
		}
	}
 dataTable =$('#goods_index_table').DataTable($.tablesetting);
 $('#seavis2').on('click',function(){
	$('#goods_index_table').dataTable().fnClearTable();
});
 $('#check_type').on('change',function(){
	$('#goods_index_table').dataTable().fnClearTable();
 });
 $('#pay_type').on('change',function(){
	$('#goods_index_table').dataTable().fnClearTable();
 });
 $('#languages').on('change',function(){
	$('#goods_index_table').dataTable().fnClearTable();
 });
 $('#goods_kind').on('change',function(){
	$('#goods_index_table').dataTable().fnClearTable();
 });
function del_goods(id){
		var msg =confirm("确定要删除此商品吗？");
		if(msg){
        		layer.msg('删除中');
        			$.ajax({
					url:"{{url('admin/goods/delgoods')}}",
					type:'get',
					data:{'id':id},
					datatype:'json',
					success:function(msg){
			           if(msg['err']==1){
			           	 layer.msg(msg.str);
               			 $('#goods_index_table').dataTable().fnClearTable();
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
function goods_online(id){
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
			           	 $('#goods_index_table').dataTable().fnClearTable();
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
function goods_copy(id) {
    layer_show('复制单品','{{url("/admin/goods/only_name")}}?id='+id,400,300);
}
function goods_close(id){
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
			           	 $('#goods_index_table').dataTable().fnClearTable();
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
$('#outgoods').on('click',function(){
	location.href='{{url("admin/goods/outgoods")}}';
})
$('#addgoods').on('click',function(){
	layer_show('新品添加','{{url("admin/goods/addgoods")}}',1400,800);
})
$('#addgoods_type').on('click',function(){
	layer_show('种类添加','{{url("admin/goods/addgoods_type")}}',400,300);
})
$('#addgoods_kind').on('click',function(){
	layer_show('产品添加','{{url("admin/kind/addkind")}}',600,500);
})
function goods_update(title,url,type,w,h){
			@if(\App\goods_check::first()['goods_is_check']==0)
				var msg =confirm("确定要修改此商品吗？将触发核审机制！");
			@else
				var msg =confirm("确定要修改此商品吗？");
			@endif
		if(msg){
				layer_show(title,url,w,h);
		}
}
function goods_show(title,url,type,w,h){
	layer_show(title,url,w,h);
}
function site_status(id,status){
	if(status==1){
		var msg =confirm("确定要在站点类目中显示？");
	}else if(status==0){
		var msg =confirm("确定要在站点类目中隐藏？");
	}else{
		alert('参数错误！');
		return false;
	}
		if(msg){
        		layer.msg('操作中');
        		$.ajax({
					url:"{{url('admin/sites/change_stauts')}}",
					type:'get',
					data:{'id':id,'status':status},
					datatype:'json',
					success:function(msg){
			           if(msg['err']==1){
			           	 layer.msg(msg.str);
			           	 $('#goods_index_table').dataTable().fnClearTable();
			           	 /*$(".del"+id).prev("input").remove();
        				 $(".del"+id).val('已删除');*/
			           }else if(msg['err']==0){
			           	 layer.msg(msg.str);
			           }else{
			           	 layer.msg('更新失败！');
			           }
					}
				})

		}else{

		}
}
$('#goods_type').on('change',function(){
	var goods_type=$(this).val();
	/*var arr1=new Array();
	 arr1['goods_type']=goods_type;console.log(arr1);
	arr1=JSON.stringify( arr1 );*/
	var arr="{\"goods_type\":\""+goods_type+"\"}";
	dataTable.search(arr).draw();
})
</script>
@endsection