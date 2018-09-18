<table class="table table-border table-bordered table-bg">
		<thead>
			<tr>
				<th colspan="8" scope="col">浏览者统计</th>
			</tr>
			<tr class="text-c">
				<th>访问者类型</th>
				<th>今天</th>
				<th>一天前</th>
				<th>两天前</th>
				<th>三天前</th>
				<th>四天前</th>
				<th>五天前</th>
				<th>六天前</th>
			</tr>
		</thead>
		<tbody>
			<tr class="text-c">
				<td>全部人数</td>
				@foreach($allcount as $val)
				<td>{{$val}}</td>
				@endforeach
			</tr>
			<tr class="text-c">
				<td>下单人数</td>
				@foreach($yxcount as $val)
				<td>{{$val}}</td>
				@endforeach
			</tr>
		</tbody>
</table>
<div id="charthigh"></div>