@extends('admin.father.css')
@section('content')

<!-- <link rel="stylesheet" type="text/css" href="{{asset('/admin/static/fixedColumns.dataTables.min.css')}}" /> -->
<link rel="stylesheet" type="text/css" href="{{asset('/admin/static/jquery.dataTables.min.css')}}" />
<script type="text/javascript" src="{{asset('/admin/lib/jquery/jquery-3.3.1.js')}}"></script> 
<style>
 #order_index_table_wrapper .dataTables_scroll .dataTables_scrollHead table thead th{
	border-left: none;   
 }
</style>
<!-- 上面样式解决dataTable;border-left错开BUG -->
<div class="page-container">
		<div class="text-c"> 日期范围：
		<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d %H:%m:%s\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
		-
		<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d %H:%m:%s' })" id="datemax" class="input-text Wdate" style="width:120px;">
		<!-- <input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name=""> -->
		<button type="submit" class="btn btn-success" id="seavis1" name=""><i class="Hui-iconfont">&#xe665;</i> 搜记录</button>
		&nbsp;&nbsp;&nbsp;
	</div>
	
	<div style="margin:0px 45%;"><br/><a href="javascript:0;" id="getadmin" class="btn btn-primary radius"><i class="icon Hui-iconfont"></i> 筛选</a></div><br/>
	<div style="display: none" id="select-admin">
		
		<div class="row cl">
			<label class="form-label col-xs-1 col-sm-1">导出时间类型：</label>
			<div class="formControls col-xs-2 col-sm-2"> <span class="select-box">
				<select name="order_time" id="order_time" class="select">
					<option value="0">订单创建时间</option>
					<option value="1">订单核审时间</option>
				</select>
			</span>
			</div>
			<label class="form-label col-xs-1 col-sm-1">订单核审状态：</label>
			<div class="formControls col-xs-2 col-sm-2"> <span class="select-box">
				<select name="order_type" id="order_type" class="select">
					<option value="#">所有</option>
					<option value="0">未核审</option>
					<option value="1">通过核审</option>
					<option value="2">拒绝核审</option>
					<option value="3">已发货</option>
					<option value="4">已签收</option>
					<option value="5">退货未退款</option>
					<option value="6">退货并已退款</option>
					<option value="7">未退货已退款</option>
					<option value="8">拒签</option>
					<option value="9">预支付</option>
					<option value="10">取消支付</option>
					<option value="11">支付成功</option>
					<option value="12">支付失败</option>
					<option value="13">支付成功但无paypal数据</option>
					<option value="14">问题订单</option>
				</select>
				</span>
			</div>
			<label class="form-label col-xs-1 col-sm-1">支付方式：</label>
			<div class="formControls col-xs-2 col-sm-2"> <span class="select-box">
				<select name="pay_type" id="pay_type" class="select">
					<option value="#">所有</option>
					<option value="0">货到付款</option>
					<option value="1">在线支付</option>
				</select>
			</span>
			</div>
		</div>
		<div class="row cl" style="margin-top: 20px;">
<!-- 			<label class="form-label col-xs-1 col-sm-1">ip重复：</label>
			<div class="formControls col-xs-2 col-sm-2"> <span class="select-box">
					<select name="order_repeat_ip" id="order_repeat_ip" class="select">
						<option value="0">无</option>
						<option value="1">ip</option>s
					</select>
					</span>
			</div> -->
			<label class="form-label col-xs-1 col-sm-1">姓名重复：</label>
			<div class="formControls col-xs-2 col-sm-2"> <span class="select-box">
					<select name="order_repeat_name" id="order_repeat_name" class="select">
						<option value="0">无</option>
						<option value="1">姓名</option>
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
			</span>
			</div>
			<label class="form-label col-xs-1 col-sm-1">地区：</label>
			<div class="formControls col-xs-2 col-sm-2">
				<span class="select-box">
					<select name="goods_blade_type" id="goods_blade_type" class="select">
						<option value="0">所有</option>
						<option value="1">台湾</option>
						<option value="2">阿联酋</option>
						<option value="3">马来西亚</option>
						<option value="4">泰国</option>
						<option value="5">日本</option>
						<option value="6">印度尼西亚</option>
						<option value="7">菲律宾</option>
						<option value="8">英国</option>
						<option value="9">美国</option>
						<option value="10">越南</option>
						<option value="11">沙特</option>
						<option value="12">卡塔尔</option>
						<option value="13">科威特</option>
					</select>
				</span>
			</div>

			<!-- <label class="form-label col-xs-1 col-sm-1">手机号重复：</label>
			<div class="formControls col-xs-2 col-sm-2"> <span class="select-box">
					<select name="order_repeat_tel" id="order_repeat_tel" class="select">
						<option value="0">无</option>
						<option value="1">手机号</option>
					</select>
					</span> </div> -->
		</div>
	</div>
	

	<table class="table table-border table-bordered table-bg" id="order_index_table">
		<thead>
			<tr>
				<th scope="col" colspan="17">订单列表</th>
			</tr>
			<tr class="text-c">
				<th width="25"><input type="checkbox" class="allchecked" name="" value=""></th>
				<th width="40">ID</th>
				<th width="80">订单号</th>
 				<th width="60">单品名</th>
				<th width="60">收货人</th>
				<th width="30">订单价格</th>
				<th width="30">订单状态</th>
				<th width="40">下单时间</th>
				<th width="60">留言</th>
				<th width="30">件数</th>
				<th width="60">快递单号</th>
				<th width="60">促销信息</th>
				<th width="60">属性信息</th>
				<th width="60">sku信息</th>
				<th width="40">核审时间</th>
				<th width="40">核审者</th>
				<th width="100">客服备注</th>
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
<!-- <div style="width: 200px;height: 150px;position: absolute;margin-top:20px;z-index: 1000;top:0;right: 0;">
	<div>
		<div style="width: 20px;height: 20px;background-color:#FFE4E1;display: inline-block;"></div>
		<div style="display:inline;">ip重复</div>
	</div>
	<div>
		<div style="width: 20px;height: 20px;background-color:#CAE1FF;display: inline-block;"></div>
		<div style="display:inline;">姓名重复</div>
	</div>
	<div>
		<div style="width: 20px;height: 20px;background-color:#00cc66;display: inline-block;"></div>
		<div style="display:inline;">电话重复</div>
	</div>
	</div>
<div style="width: 200px;height: 150px;position: absolute;margin-top:20px;z-index: 1000;top:0;right: 200px;">
	<div>
		<div style="width: 20px;height: 20px;background-color:#d7dde4;display: inline-block;"></div>
		<div style="display:inline;">ip、姓名</div>
	</div>
	<div>
		<div style="width: 20px;height: 20px;background-color:#ff9900;display: inline-block;"></div>
		<div style="display:inline;">ip、电话重复</div>
	</div>
	<div>
		<div style="width: 20px;height: 20px;background-color:#FFE4C4;display: inline-block;"></div>
		<div style="display:inline;">姓名、电话重复</div>
	</div>
	<div>
		<div style="width: 20px;height: 20px;background-color:#FFFACD;display: inline-block;"></div>
		<div style="display:inline;">ip、姓名、电话重复</div>
	</div>
</div> -->
</div>
@endsection
@section('js')

<script type="text/javascript">
	$.tablesetting={
	"lengthMenu": [[10,20],[10,20]],//每页显示条数
		"paging": true,					//是否分页。
		"info":   true,					//页脚信息
		"searching": true,				//搜索
		"ordering": true,
		"order": [[ 7, "desc" ]],
		"stateSave": false,
		"columnDefs": [{
		   "targets": [0,2,3,4,6,8,10,11,12,13,15,16],
		   "orderable": false
		}],
	/*	scrollX:        true,
        scrollCollapse: true,
        fixedColumns:   {
            leftColumns: 3,
            rightColumns: 1
        },
        此处因列数没有那么多，不用添加滑动条
        */
		"processing": true,
		"serverSide": true,
		"ajax": {
		"data":{
			order_repeat_name:function(){return $('#order_repeat_name').val()},
			mintime:function(){return $('#datemin').val()},
			maxtime:function(){return $('#datemax').val()},
			order_type:function(){return $('#order_type').val()},
            pay_type:function(){return $('#pay_type').val()},
            languages:function(){return $('#languages').val()},
            goods_blade_type:function(){return $('#goods_blade_type').val()},
            order_time:function (){return $('#order_time').val()},
        },
		"url": "{{url('admin/order/get_table')}}",
		"type": "POST",
		'headers': { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
		},
		"columns": [
		{'defaultContent':"","className":"td-manager"},
		{"data":'order_id'},
		{"data":'order_single_id'},
		{'data':'goods_real_name'},
		{'data':'order_name'},
		{'data':'order_price'},
		{'defaultContent':"","className":"td-manager"},
		{'data':'order_time'},
		{'data':'order_remark'},
		{'data':'order_num'},
		{'data':'order_send'},
		{'data':'order_cuxiao_id'},
		{'data':'config_msg'},
        {'data':'goods_sku'},
        {'data':'order_return_time'},
		{'data':'admin_show_name'},
        {'data':'order_service_remarks'},
		],
        //每行回调函数
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            //改行满足的条件
			/*if(aData.order_repeat_field){
				if(aData.order_repeat_field.length == 1 && aData.order_repeat_field[0] == '1'){
                        //设置满足条件行的背景颜色
                        $(nRow).css("background", "#FFE4E1");
				}
                if(aData.order_repeat_field.length == 1 && aData.order_repeat_field[0] == '2'){
                    	//     //设置满足条件行的背景颜色
                        $(nRow).css("background", "#CAE1FF");
                }
                if(aData.order_repeat_field.length == 1 && aData.order_repeat_field[0] == '3'){
                    //     //设置满足条件行的背景颜色
                        $(nRow).css("background", "#00cc66");
                }
                if(aData.order_repeat_field.length == 3){
                    //     //设置满足条件行的背景颜色
                    $(nRow).css("background", "#FFFACD");
                    $('.dataTable td.sorting_1').removeClass('sorting_1');
                }
                if(aData.order_repeat_field.length == 2 && aData.order_repeat_field.indexOf('1')>=0 &&  aData.order_repeat_field.indexOf('2')>=0){
                    //     //设置满足条件行的背景颜色
                    $(nRow).css("background", "#d7dde4");
                }
                if(aData.order_repeat_field.length == 2 && aData.order_repeat_field.indexOf('1')>=0 &&  aData.order_repeat_field.indexOf('3')>=0){
                    //     //设置满足条件行的背景颜色
                    $(nRow).css("background", "#ff9900");
                }*/
/*                console.log("======================");
                console.log(aData.order_repeat_field.length);
                console.log(aData.order_repeat_field.indexOf('3'));
                console.log(aData.order_repeat_field.indexOf('2'));
                console.log(aData.order_repeat_field);
                console.log("=======================");*/
              /*  if(aData.order_repeat_field.length == 2 && aData.order_repeat_field.indexOf('2')>=0 &&  aData.order_repeat_field.indexOf('3')>=0){
                    //     //设置满足条件行的背景颜色
                    $(nRow).css("background", "#FFE4C4");
                }
			}*/
        },
        "createdRow":function(row,data,dataIndex){
			if(data.order_type==0){
				var isroot='<a href="#" onclick="" <span class="label label-success radius" style="color:#ccc;">未核审</span></a>';
			}else if(data.order_type==1){
				var isroot='<a href="javascript:;" onclick="order_returninfo('+data.order_id+')" <span class="label label-default radius" style="color:green;">核审通过</span></a>';
			}else if(data.order_type==2){
				var isroot='<a href="javascript:;" onclick="order_returninfo('+data.order_id+')" <span class="label label-default radius" style="color:red;">核审驳回</span></a>';
			}else if(data.order_type==3){
				var isroot='<a href="javascript:;" onclick="order_returninfo('+data.order_id+')" <span class="label label-default radius" style="color:brown;">已发货</span></a>';
			}else if(data.order_type==4){
				var isroot='<a href="javascript:;" onclick="order_returninfo('+data.order_id+')" <span class="label label-default radius" style="color:#6699ff;">已签收</span></a>';
			}else if(data.order_type==5){
				var isroot='<a href="javascript:;" onclick="order_returninfo('+data.order_id+')" <span class="label label-default radius" style="color:#red;">退货未退款</span></a>';
			}else if(data.order_type==6){
				var isroot='<a href="javascript:;" onclick="order_returninfo('+data.order_id+')" <span class="label label-default radius" style="color:#red;">退货并已退款</span></a>';
			}else if(data.order_type==7){
				var isroot='<a href="javascript:;" onclick="order_returninfo('+data.order_id+')" <span class="label label-default radius" style="color:#red;">未退货并已退款</span></a>';
			}else if(data.order_type==8){
				var isroot='<a href="javascript:;" onclick="order_returninfo('+data.order_id+')" <span class="label label-default radius" style="color:#red;">拒签</span></a>';
			}else if(data.order_type==9){
				var isroot='<a href="javascript:;"  <span class="label label-default radius" style="color:black;background-color:#ccc;">预支付</span></a>';
			}else if(data.order_type==10){
				var isroot='<a href="javascript:;"  <span class="label label-default radius" style="color:black;background-color:#ccc;">取消支付</span></a>';
			}else if(data.order_type==11){
				var isroot='<a href="javascript:;"  <span class="label label-default radius" style="color:black;background-color:#ccc;">支付成功</span></a>';
			}else if(data.order_type==12){
				var isroot='<a href="javascript:;"  <span class="label label-default radius" style="color:black;background-color:#ccc;">支付失败</span></a>';
			}else if(data.order_type==13){
				var isroot='<a href="javascript:;"  <span class="label label-default radius" style="color:black;background-color:#ccc;">支付成功但无paypal数据</span></a>';
			}else if(data.order_type==14){
				var isroot='<a href="javascript:;" 	onclick="order_returninfo('+data.order_id+')" <span class="label label-default radius" style="color:red;">问题订单</span></a>';
			}
			if(data.order_pay_type.indexOf("1")!=-1){
				isroot+='<a href="javascript:;" onclick="" <span class="label label-default radius" style="color:black;background-color:white;">在线支付</span></a>';
			}
			var checkbox='<input type="checkbox" name="" value="'+data.order_id+'">';
			$(row).find('td:eq(0)').html(checkbox);
			/*var info='<a title="编辑" href="javascript:;" onclick="member_edit(\'编辑\',\'member-add.html\',4,\'\',510)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="member_del(this,1)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>';*/
			$(row).find('td:eq(6)').html(isroot);
/*			$(row).find('td:eq(16)').html(data.order_state+'-'+data.order_city);*/
			/*$(row).find('td:eq(0)').html(checkbox);*/
			$(row).addClass('text-c');
			/*var img="<img src='"+data.cover_img+"' alt='暂时没有图片' width='130' height='100'>";
			$(row).find('td:eq(5)').html(img);*/
			/*var video_btn='<input class="btn btn-success-outline radius" onClick="start_play('+data.lesson_id+')" type="button" value="播放视频">';
			$(row).find('td:eq(6)').html(video_btn);*/
		}
	}
 dataTable =$('#order_index_table').DataTable($.tablesetting);
$('#seavis1').on('click',function(){
	               			 $('#order_index_table').dataTable().fnClearTable(); 

})
function del_order(id){
		var msg =confirm("确定要删除此订单吗？");
		if(msg){
        		layer.msg('删除中');
        			$.ajax({
					url:"{{url('admin/order/delorder')}}",
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
               			 $('#order_index_table').dataTable().fnClearTable(); 
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
function order_returninfo(id){
	layer_show('订单信息','/admin/order/orderinfo?id='+id,500,300);
}
function goods_edit(title,url,type,w,h){
	layer_show(title,url,w,h);
}
function order_up(title,url,type,w,h){
	var b='';
	var a=$('input[type="checkbox"]:checked');
	if(a.length<=0){
		layer.msg('无选中项');
		return false;
	}
	for (var i = a.length - 1; i >= 0; i--) {
		if(a[i].value!=''&&a[i].value!=null){
					b+=a[i].value+',';
		}
	}
	url=url+'&id='+b;
	layer_show(title,url,w,h);
}
$('#outorder').on('click',function(){
	var mintime=$('#datemin').val();
	var maxtime=$('#datemax').val();
	if(mintime==''&&maxtime==''){
		layer.msg('请稍等');
     location.href='{{url("admin/order/outorder")}}';
	}else if(mintime==''||maxtime==''){
		layer.msg('请选择正确日期区间');
	}else{
		layer.msg('请稍等');
		location.href='{{url("admin/order/outorder")}}?min='+mintime+'&max='+maxtime;
	}
})
function pl_del(){
	var msg =confirm("确定要批量删除这些订单吗？");
	if(!msg){
		return false;
	}
	var b=[];
	var a=$('input[type="checkbox"]:checked');
	if(a.length<=0){
		layer.msg('无选中项');
		return false;
	}
	for (var i = a.length - 1; i >= 0; i--) {
		if(a[i].value!=''&&a[i].value!=null){
					b.push(a[i].value);
		}
	}
	layer.msg('删除中，请稍等!');
	$.ajax({
					url:"{{url('admin/order/delorder')}}",
					type:'get',
					data:{'id':b,'type':'all'},
					datatype:'json',
					success:function(msg){
			           if(msg['err']==1){
			           	 layer.msg(msg.str);
               			 $('#order_index_table').dataTable().fnClearTable(); 
			           }else if(msg['err']==0){
			           	 layer.msg(msg.str);
			           }else{
			           	 layer.msg('删除失败！');
			           }
					}
				})


}
function pl_update(){
	var msg =confirm("确定要批量核审这些订单吗？");
	if(!msg){
		return false;
	}
	var b=[];
	var a=$('input[type="checkbox"]:checked');
	if(a.length<=0){
		layer.msg('无选中项');
		return false;
	}
	for (var i = a.length - 1; i >= 0; i--) {
		if(a[i].value!=null){
					b.push(a[i].value);
		}
	}
	layer.msg('核审中，请稍等!');
	$.ajax({
					url:"{{url('admin/order/heshen')}}",
					type:'get',
					data:{'id':b,'type':'all'},
					datatype:'json',
					success:function(msg){
			           if(msg['err']==1){
			           	 layer.msg(msg.str);
               			 $('#order_index_table').dataTable().fnClearTable(); 
			           }else if(msg['err']==0){
			           	 layer.msg(msg.str);
			           }else{
			           	 layer.msg('核审失败！');
			           }
					}
				})


}
function goods_getaddr(title,url,type,w,h){
	layer_show(title,url,w,h);
}
$('#getadmin').on('click',function(){
	$('#select-admin').toggle(300);
})
$('#admin_name').on('change',function(){
	dataTable.ajax.reload();
	var args = dataTable.ajax.params();
})
$('#order_type').on('change',function(){
	dataTable.ajax.reload();
	
})
$('#order_repeat_ip').on('change',function(){
	dataTable.ajax.reload();
	
})
$('#order_repeat_name').on('change',function(){
	dataTable.ajax.reload();
})
$('#pay_type').on('change',function(){
     dataTable.ajax.reload();
})
//根据语言进行搜索
$('#languages').on('change',function(){
     dataTable.ajax.reload();
});
//根据语言进行搜索
$('#goods_blade_type').on('change',function(){
     dataTable.ajax.reload();
});
$('#order_repeat_tel').on('change',function(){
	dataTable.ajax.reload();
	
})
var allcheckedflag=true;
$("body").on("click",".allchecked",function(){
    if(allcheckedflag){
		$("div.DTFC_LeftWrapper :checkbox").prop("checked", true);
		allcheckedflag=false;
	}else{
		$("div.DTFC_LeftWrapper :checkbox").prop("checked", false);
		allcheckedflag=true;
	}
	
})
</script>

@endsection