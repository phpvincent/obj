@extends('admin.father.css')
@section('content')
<table class="table table-border table-bordered table-bg">
		<thead>
			<tr>
				<th colspan="7" scope="col">收货信息</th>
			</tr>
			<tr class="text-c">
				<th>选项</th>
				<th>信息</th>
			</tr>
		</thead>
		<tbody>
			<tr class="text-c">
				<td>收货人</td>
				<td>{!!$order->order_name==''?"<span style='color:red'>没有填写</span>":$order->order_name!!}</td>
			</tr>
			<tr class="text-c">
				<td>收货电话</td>
				<td>{!!$order->order_tel==''?"<span style='color:red'>没有填写</span>":$order->order_tel!!}</td>
			</tr>
			<tr class="text-c">
				<td>邮箱</td>
				<td>{!!$order->order_email==''?"<span style='color:red'>没有填写</span>":$order->order_email!!}</td>
			</tr>
			<tr class="text-c">
				<td>村镇</td>
				<td>{!!$order->order_village==''?"<span style='color:red'>没有填写</span>":$order->order_village!!}</td>
			</tr>
			<tr class="text-c">
				<td>城市</td>
				<td>{!!$order->order_city==''?"<span style='color:red'>没有填写</span>":$order->order_city!!}</td>
			</tr>
			<tr class="text-c">
				<td>地区</td>
				<td>{!!$order->order_state==''?"<span style='color:red'>没有填写</span>":$order->order_state!!}</td>
			</tr>
			
			<tr class="text-c">
				<td>详细信息</td>
				<td>{!!$order->order_add==''?"<span style='color:red'>没有填写</span>":$order->order_add!!}</td>
			</tr>
			<tr class="text-c">
				<td>买家留言</td>
				<td>{!!$order->order_remark==''?"<span style='color:red'>没有填写</span>":$order->order_remark!!}</td>
			</tr>
		</tbody>
</table>
@endsection
@section('js')
@endsection