@extends('storage.father.static')
@section('content')
    @if($storage_log==null||$storage_log==false)
        <blockquote class="layui-elem-quote"><span style="color: red;">暂无数据</span></blockquote>
    @else
        <fieldset class="layui-elem-field">
            <legend>商品入库操作</legend>
            <div class="layui-field-box">
                <blockquote class="layui-elem-quote">操作时间：{{$storage_log->created_at}}</blockquote>
                <blockquote class="layui-elem-quote">操作者：@if($storage_log->storage_log_admin_id!=0) {{\App\admin::where('admin_id',$storage_log->storage_log_admin_id)->first(['admin_show_name'])['admin_show_name']}} @else
                        系统 @endif</blockquote>
                <blockquote class="layui-elem-quote">操作性质：@if($storage_log->is_danger==1) <span style="color:red">危险操作</span> @else 普通操作 @endif</blockquote>
                <blockquote class="layui-elem-quote">具体操作：{{$storage_log_data['remarks']}}</blockquote>
                @if($storage_log_data['is_success']==0)
                    <blockquote class="layui-elem-quote">是否成功：<b><u><span style="color:red">操作失败</span></b></u></blockquote>
                @else
                    <blockquote class="layui-elem-quote">是否成功：<b><u><span style="color:green">操作成功</span></b></u></blockquote>
                @if(isset($storage_log_data['status']))
                    @if($storage_log_data['status']==1)
                        <blockquote class="layui-elem-quote">补货单id:{{$storage_log_data['order_id']}}</blockquote>
                        <blockquote class="layui-elem-quote">补货单编号:{{$storage_log_data['order_single']}}</blockquote>
                    @else
                        <blockquote class="layui-elem-quote">订单id:{{$storage_log_data['order_id']}}</blockquote>
                        <blockquote class="layui-elem-quote">订单编号:{{$storage_log_data['order_single']}}</blockquote>
                    @endif
                    @endif
                    <blockquote class="layui-elem-quote">仓库id:{{$storage_log_data['storage_id']}}</blockquote>
                    <blockquote class="layui-elem-quote">仓库名称:{{$storage_log_data['storage_name']}}</blockquote>
                    <button class="layui-btn"  onclick="parent.parent.layui.index.openTabsPage('/admin/storage/list/product_data', '仓库数据处理');" style="width: 100%">数据详情</button>
                @endif
            </div>
        </fieldset>
    @endif
@endsection
@section('js')
@endsection