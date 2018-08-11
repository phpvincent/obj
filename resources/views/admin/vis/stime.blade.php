@extends('admin.father.css')
@section('content')
<article class="page-container">
	<table class="table table-border table-bordered table-bg">
		<thead>
			<tr>
				<th colspan="7" scope="col">信息统计</th>
			</tr>
			<tr class="text-c">
				<th>ID</th>
				<th>访问时间</th>
				<th>点击购买时间</th>
				<th>提交订单时间</th>
				<th>页面停留时间</th>
				<th>发布评论时间</th>
			</tr>
		</thead>
				<tbody>
			<tr class="text-c">
				<td>{{$vis->vis_id}}</td>
				<td>{{$vis->vis_time}}</td>
				<td>{{$vis->vis_buytime==null?"未点击购买":$vis->vis_buytime}}</td>
				<td>{{$vis->vis_ordertime==null?"未下单":$vis->vis_ordertime}}</td>
				<td>{{$vis->vis_staytime==null?"非常规退出，无法获取":$vis->vis_staytime.'秒'}}</td>
				<td>{{$vis->vis_comtime==null?"没有评论":$vis->vis_comtime.'秒'}}</td>
			</tr>
		</tbody>
	</table>
</article>
@endsection
@section('js')
@endsection