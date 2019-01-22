@extends('admin.father.css')
@section('content')
	<table class="table table-border table-bordered table-bg">
		<thead>
		<tr>
			<th colspan="7" scope="col">下单信息</th>
		</tr>
		<tr class="text-c">
			<th>选项</th>
			<th>信息</th>
		</tr>
		</thead>
		<tbody>
		<tr class="text-c">
			<td>下单人</td>
			<td>@if(isset($order['firstname'])){{ $order['firstname'] }} {{ $order['lastname'] }}@endif</td>
		</tr>
		<tr class="text-c">
			<td>收货电话</td>
			<td>@if(isset($order['telephone'])){{ $order['telephone'] }}@endif</td>
		</tr>
		<tr class="text-c">
			<td>邮箱</td>
			<td>@if(isset($order['email'])){{ $order['email'] }}@endif</td>
		</tr>
		<tr class="text-c">
			<td>村镇</td>
			<td>@if(isset($order['village'])){{ $order['village'] }}@endif</td>
		</tr>
		<tr class="text-c">
			<td>城市</td>
			<td>@if(isset($order['city'])){{ $order['city'] }}@endif</td>
		</tr>
		<tr class="text-c">
			<td>地区</td>
			<td>@if(isset($order['state'])){{ $order['state'] }}@endif</td>
		</tr>
		<tr class="text-c">
			<td>详细信息</td>
			<td>@if(isset($order['address1'])){{ $order['address1'] }}@endif @if(isset($order['address2'])){{ $order['address2'] }}@endif</td>
		</tr>
		<tr class="text-c">
			<td>单品名</td>
			<td>@if(isset($goods->goods_name))<a href="http://{{ $goods->goods_url }}" target="_blank">{{ $goods->goods_name }}</a>@endif</td>
		</tr>
		<tr class="text-c">
			<td>数量</td>
			<td>@if(isset($order['specNumber'])){{ $order['specNumber'] }}@endif</td>
		</tr>
		<tr class="text-c">
			<td>金额</td>
			<td>@if(isset($order['currency_code'])){{ $order['currency_code'] }}@endif @if(isset($order['amount'])){{ $order['amount'] }}@endif</td>
		</tr>
		<tr class="text-c">
			<td>单品属性</td>
			<td>@if(isset($goods->goods_attrs))
				@foreach($goods->goods_attrs as $attr)
					{{ $attr }} <br>
					@endforeach
				@endif</td>
		</tr>
		<tr class="text-c">
			<td>买家留言</td>
			<td>@if(isset($order['notes'])){{ $order['notes'] }}@endif</td>
		</tr>
		</tbody>
	</table>
@endsection
@section('js')
@endsection