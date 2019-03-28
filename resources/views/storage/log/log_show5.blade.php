@extends('storage.father.static')
@section('content')
	@if($storage_log==null||$storage_log==false)
		<blockquote class="layui-elem-quote"><span style="color: red;">暂无数据</span></blockquote>
	@else
		<fieldset class="layui-elem-field">
        <legend>@if($storage_log->storage_log_operate_type==3) 订单扣货单导出操作 @else <span style="color:red;"><b>订单扣货操作</b></span> @endif</legend>
        <div class="layui-field-box">
        	<blockquote class="layui-elem-quote">操作时间：{{$storage_log->created_at}}</blockquote>
        	<blockquote class="layui-elem-quote">操作者：@if($storage_log->storage_log_admin_id!=0) {{\App\admin::where('admin_id',$storage_log->storage_log_admin_id)->first(['admin_show_name'])['admin_show_name']}} @else 
        	系统 @endif</blockquote>
        	<blockquote class="layui-elem-quote">操作性质：@if($storage_log->is_danger==1) <span style="color:red">危险操作</span> @else 普通操作 @endif</blockquote>
        	@if($storage_log_data['is_success']==0)
        	<blockquote class="layui-elem-quote"><span style="color:red">操作失败</span></blockquote>
        	@else
        	  @if($storage_log->storage_log_operate_type==0)
	        	<blockquote class="layui-elem-quote"><span style="color:green">操作成功</span></blockquote>
	        	<blockquote class="layui-elem-quote">出货单id:{{$storage_log_data['storage_check_id']}}</blockquote>
	        	<blockquote class="layui-elem-quote">出货单编号:{{$storage_log_data['storage_check_string']}}</blockquote>
	        	 <button class="layui-btn"  onclick="parent.parent.layui.index.openTabsPage('/admin/storage/check/list', '出货记录');" style="width: 100%">数据详情</button>
	          @elseif($storage_log->storage_log_operate_type==3)
	            <blockquote class="layui-elem-quote"><span style="color:green">操作成功</span></blockquote>
	        	<blockquote class="layui-elem-quote">被导出出货单id:{{$storage_log_data['storage_check_id']}}</blockquote>
	        	<blockquote class="layui-elem-quote">被导出出货单编号:{{\App\storage_check::where('storage_check_id',$storage_log_data['storage_check_id'])->first(['storage_check_string'])['storage_check_string']}}</blockquote>
	        	 <button class="layui-btn"  onclick="parent.parent.layui.index.openTabsPage('/admin/storage/check/list', '出货记录');" style="width: 100%">数据详情</button>
	          @endif
        	@endif
        </div>
      </fieldset>
	@endif
@endsection
@section('js')
@endsection