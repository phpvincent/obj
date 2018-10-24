@extends('admin.father.css')
@section('content')
@if($paypal==null)
<div class="page-container">
		<table class="table table-border table-bordered table-bg">
			<tr>
				<td style="text-align: center;color: red;">暂无对应支付信息记录</td>
			</tr>
		</table>
</div>
@else
<div class="page-container">
		<table class="table table-border table-bordered table-bg">
			<tr>
				<td>paypal订单号</td>
				<td>{{$paypal['paypal_corre_id']}}</td>
			</tr>
			<!-- <tr>
				<td>paypal返回金额(实际支付)</td>
				<td>{{$paypal['paypal_amount']}}</td>
			</tr> -->
			<tr>
				<td>币种</td>
				<td>{{$paypal['paypal_currency']}}</td>
			</tr>
			<tr>
				<td>paypal支付时间</td>
				<td>{{$paypal['paypal_time']}}</td>
			</tr>
			<tr>
				<td>支付者paypal Id</td>
				<td>{{$paypal['paypal_payer_id']}}</td>
			</tr>
			<tr>
				<td>支付者邮箱</td>
				<td>{{$paypal['paypal_email']}}</td>
			</tr>
			<tr>
				<td>支付者名字</td>
				<td>{{$paypal['paypal_firstname']}}</td>
			</tr>
			<tr>
				<td>支付者姓</td>
				<td>{{$paypal['paypal_lastname']}}</td>
			</tr>
			<tr>
				<td>对应系统订单id</td>
				<td>{{$paypal['paypal_order_id']}}</td>
			</tr>
			<tr>
				<td>paypal描述</td>
				<td>{{$paypal['paypal_desc']}}</td>
			<tr>
				<td>paypal_paymentstatus状态码</td>
				<td>{{$paypal['paypal_paymentstatus']}}</td>
			<tr>
				<td>paypal返回状态码</td>
				<td>{{$paypal['paypal_status']}}</td>
			<tr>
				<td>paypal-token</td>
				<td>{{$paypal['paypal_token']}}</td>
			</tr>
		</table>
</div>
@endif
@endsection