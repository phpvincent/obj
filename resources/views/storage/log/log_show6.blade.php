@extends('storage.father.static')
@section('content')
	@if($storage_log==null||$storage_log==false)
		<blockquote class="layui-elem-quote"><span style="color: red;">暂无数据</span></blockquote>
	@else
		<fieldset class="layui-elem-field">
        <legend><span style="color: red;"><b>订单出仓操作</b></span></legend>
        <div class="layui-field-box">
        	<blockquote class="layui-elem-quote">出货时间：{{$storage_log->created_at}}</blockquote>
        	<blockquote class="layui-elem-quote">出货者：@if($storage_log->storage_log_admin_id!=0) {{\App\admin::where('admin_id',$storage_log->storage_log_admin_id)->first(['admin_show_name'])['admin_show_name']}} @else 
        	系统 @endif</blockquote>
        	<blockquote class="layui-elem-quote">操作性质：@if($storage_log->is_danger==1) <span style="color:red">危险操作</span> @else 普通操作 @endif</blockquote>
        	@if($storage_log_data['is_success']==0)
        	<blockquote class="layui-elem-quote"><span style="color:red">操作失败</span></blockquote>
        	@else
        	<blockquote class="layui-elem-quote"><span style="color:green">操作成功</span></blockquote>
		        <table class="layui-table"id="tableExcel" lay-filter="test">
					  <thead>
					  	<tr>
					  		<th>被出库订单id</th>
					  		<th>被出库订单编号</th>
					  	</tr>
					  </thead>
					  	@foreach($storage_log_data['order_ids'] as $k => $v)
						    <tr>
						      <td>订单id:{{$v}}</td>
						      <td>订单编号:{{\App\order::where('order_id',$v)->first(['order_single_id'])['order_single_id']}}</td>
						    </tr>
					    @endforeach
					  
		         </table>
        	@endif
        </div>
      </fieldset>
	@endif
@endsection
@section('js')
@endsection