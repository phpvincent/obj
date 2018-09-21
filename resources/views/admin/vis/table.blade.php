<style type="text/css">
	table {
		border-collapse: collapse!important;

	}

	td {
		word-break: break-word!important;
		min-width: 130px!important;
	}
</style>
<table  class="table table-border table-bordered table-bg" >
		<thead >
			<tr  style="border-top: 1px solid #fff">
				<th style="background-color: #fff;border:1px solid #fff" scope="col">浏览者统计</th>
			</tr>
			<tr class="text-c">
				<th>访问者类型</th>
				@foreach($time as $item)
				<th>{{$item}}</th>
				@endforeach
			</tr>
		</thead>
		<tbody>
			<tr class="text-c">
				<td>购买转化</td>
				@foreach($data['buycountl'] as $val)
				<td>{{$val}}</td>
				@endforeach
			</tr>
			<tr class="text-c">
				<td>下单转化</td>
				@foreach($data['ordercountl'] as $val)
					<td>{{$val}}</td>
				@endforeach
			</tr>
			<tr class="text-c">
				<td>评论转化</td>
				@foreach($data['comcountl'] as $val)
					<td>{{$val}}</td>
				@endforeach
			</tr>
			<tr class="text-c">
				<td>浏览人数</td>
				@foreach($data['count'] as $val)
					<td>{{$val}}</td>
				@endforeach
			</tr>
			<tr class="text-c">
				<td>购买人数</td>
				@foreach($data['buycount'] as $val)
					<td>{{$val}}</td>
				@endforeach
			</tr>
			<tr class="text-c">
				<td>下单人数</td>
				@foreach($data['ordercount'] as $val)
					<td>{{$val}}</td>
				@endforeach
			</tr>
			<tr class="text-c">
				<td>评论人数</td>
				@foreach($data['comcount'] as $val)
					<td>{{$val}}</td>
				@endforeach
			</tr>
		</tbody>
</table>
<div id="charthigh"></div>