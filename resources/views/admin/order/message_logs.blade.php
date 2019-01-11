@extends('admin.father.css')
@section('content')
<table class="table table-border table-bordered table-bg" id="order_index_table">
	<thead>
	<tr class="text-c">
		<th width="40">序号</th>
		<th width="50">IP</th>
		<th width="60">发送时间</th>
		<th width="60">电话号码</th>
		{{--<th width="60">订单Id</th>--}}
		<th width="60">发送状态</th>
		{{--<th width="30">备注信息</th>--}}
		<th width="80">短信内容</th>
		<th width="20">验证码</th>
	</tr>
	</thead>
	<tbody>
	@foreach($logs as $key=>$log)
		<tr>
			<td>{{$key + 1}}</td>
			<td>{{$log->message_ip}}</td>
			<td>{{$log->message_gettime}}</td>
			<td>{{$log->message_mobile_num}}</td>
{{--			<td>{{$log->message_order_id}}</td>--}}
			<td>@if($log->message_status == 0)发送成功@elseif($log->message_status == 1)发送失败@elseif($log->message_status == 2)接收成功@else接收失败@endif</td>
{{--			<td>{{$log->message_remark}}</td>--}}
			<td>{{$log->messaga_content}}</td>
			<td>{{$log->messaga_code}}</td>
		</tr>
		@endforeach
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
@endsection