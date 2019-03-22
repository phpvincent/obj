@extends('storage.father.static')
@section('content')
 @if($storage_check_data==null||count($storage_check_data)<=0)
 	<blockquote class="layui-elem-quote">暂无数据</blockquote>
 @else
	@if($storage_check_data[0]->storage_check_data_type==1)
	<fieldset class="layui-elem-field">
        <legend>从海外仓拆分发货</legend>
        <div class="layui-field-box">
        	<blockquote class="layui-elem-quote">总数目：{{$storage_check_data[0]->storage_check_data_num}}</blockquote>
        	<blockquote class="layui-elem-quote">产品sku：{{$storage_check_data[0]->storage_check_data_sku}}</blockquote>
        	<blockquote class="layui-elem-quote">订单编号：{{\App\order::where('order_id',$storage_check_data[0]->storage_check_data_order)->first(['order_single_id'])['order_single_id']}}</blockquote>
        	<blockquote class="layui-elem-quote">校准单编号：{{\App\storage_check::where('storage_check_id',$storage_check_data[0]->storage_primary_id)->first(['storage_check_string'])['storage_check_string']}}</blockquote>
        	<blockquote class="layui-elem-quote" style="color:brown">仓库：{{\App\storage::where('storage_id',$storage_check_data[0]->storage_abroad_id)->first(['storage_name'])['storage_name']}}(海外仓)</blockquote>
          <table class="layui-table" lay-filter="test">
			  <thead>
			  	<tr>
			  		<th rowspan="3">扣货信息</th>
			  	</tr>
			  	@foreach($storage_check_data as $k => $v)
				    <tr>
				      <td>订单id:{{$v->storage_check_info_order}}</td>
				      <td>订单编号:{{$v->storage_check_info_single}}</td>
				      <td>数量:{{$v->storage_check_info_num}}</td>
				      <td>属性sku:{{$v->storage_check_info_sku}}</td>
				    </tr>
			    @endforeach
			  </thead>
		  </table>
        </div>
      </fieldset>
    @elseif($storage_check_data[0]->storage_check_data_type==2)
    <fieldset class="layui-elem-field">
        <legend>从海外仓不拆分发货</legend>
        <div class="layui-field-box">
          <blockquote class="layui-elem-quote">总数目：{{$storage_check_data[0]->storage_check_data_num}}</blockquote>
        	<blockquote class="layui-elem-quote">产品sku：{{$storage_check_data[0]->storage_check_data_sku}}</blockquote>
        	<blockquote class="layui-elem-quote">订单编号：{{\App\order::where('order_id',$storage_check_data[0]->storage_check_data_order)->first(['order_single_id'])['order_single_id']}}</blockquote>
        	<blockquote class="layui-elem-quote">校准单编号：{{\App\storage_check::where('storage_check_id',$storage_check_data[0]->storage_primary_id)->first(['storage_check_string'])['storage_check_string']}}</blockquote>
        	<blockquote class="layui-elem-quote" style="color:brown">仓库：{{\App\storage::where('storage_id',$storage_check_data[0]->storage_abroad_id)->first(['storage_name'])['storage_name']}}(海外仓)</blockquote>
        	 <table class="layui-table" lay-filter="test">
			  <thead>
			  	<tr>
			  		<th rowspan="3">扣货信息</th>
			  	</tr>
			  	@foreach($storage_check_data as $k => $v)
				    <tr>
				      <td>订单id:{{$v->storage_check_info_order}}</td>
				      <td>订单编号:{{$v->storage_check_info_single}}</td>
				      <td>数量:{{$v->storage_check_info_num}}</td>
				      <td>属性sku:{{$v->storage_check_info_sku}}</td>
				    </tr>
			    @endforeach
			  </thead>
		  </table>
        </div>
      </fieldset>
   @elseif($storage_check_data[0]->storage_check_data_type==3)
	<fieldset class="layui-elem-field">
	    <legend>从本地仓发货</legend>
	    <div class="layui-field-box">
	      <blockquote class="layui-elem-quote">总数目：{{$storage_check_data[0]->storage_check_data_num}}</blockquote>
        	<blockquote class="layui-elem-quote">产品sku：{{$storage_check_data[0]->storage_check_data_sku}}</blockquote>
        	<blockquote class="layui-elem-quote">订单编号：{{\App\order::where('order_id',$storage_check_data[0]->storage_check_data_order)->first(['order_single_id'])['order_single_id']}}</blockquote>
        	<blockquote class="layui-elem-quote">校准单编号：{{\App\storage_check::where('storage_check_id',$storage_check_data[0]->storage_primary_id)->first(['storage_check_string'])['storage_check_string']}}</blockquote>
        	<blockquote class="layui-elem-quote" style="color:green">仓库：{{\App\storage::where('storage_id',$storage_check_data[0]->storage_abroad_id)->first(['storage_name'])['storage_name']}}(本地仓)</blockquote>
        	 <table class="layui-table" lay-filter="test">
			  <thead>
			  	<tr>
			  		<th rowspan="3">扣货信息</th>
			  	</tr>
			  	@foreach($storage_check_data as $k => $v)
				    <tr>
				      <td>订单id:本地仓</td>
				      <td>订单编号:本地仓</td>
				      <td>数量:{{$v->storage_check_info_num}}</td>
				      <td>属性sku:{{$v->storage_check_info_sku}}</td>
				    </tr>
			    @endforeach
			  </thead>
		  </table>
	    </div>
	  </fieldset>
  @endif
@endif
@endsection
@section('js')
@endsection