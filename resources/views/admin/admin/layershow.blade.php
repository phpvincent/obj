@extends('admin.father.css')
@section('content')
<div class="page-container">
		<table class="table table-border table-bordered table-bg">
			<tr>
				<td>上次登陆ip</td>
				<td>@if($admin['admin_ip']!=null||$admin['admin_ip']!=''){{$admin['admin_ip']}}@else 首次登陆 @endif</td>
			</tr>
			<tr>
				<td>上次登陆时间</td>
				<td>@if($admin['admin_time']!=null||$admin['admin_time']!=''){{$admin['admin_time']}}@else 首次登陆 @endif</td>
			</tr>
			<tr>
				<td>账户名</td>
				<td>{{Auth::user()->admin_name}}</td>
			</tr>
			<tr>
				<td>所属角色</td>
				<td>@if($admin['is_root']!='1')超级管理员@else {{$admin->admin_role_id}} @endif</td>
			</tr>
			<tr>
				<td>名下单品数</td>
				<td>{{$admin_goods_count}}</td>
			</tr>
			<tr>
				<td>今日销售额</td>
				<td>{{$daysale}}</td>
			</tr>
		</table>
</div>
@endsection