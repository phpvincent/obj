@extends('storage.father.static')
@section('content')
    <div class="layui-fluid">
        <div class="layui-card">
            <!-- 搜索控件 -->
            <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label">补货时间：</label>
                                <div class="layui-input-inline">
                                    <input type="text" class="layui-input" id="test-laydate-out"
                                           placeholder="日期范围">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-inline test-table-reload-btn">
                        <label>从当前数据中检索:</label>
                        <div class="layui-inline">
                            <input class="layui-input" name="id" id="test-table-demoReload" autocomplete="off">
                        </div>
                        <button class="layui-btn" data-type="reload">搜索</button>
                    </div>
                </div>
            </div>
            <!-- 表格元素 -->
            <div class="layui-card-body">
                <table id="storagelist" lay-filter='button-listen'></table>
            </div>

        </div>
    </div>
    <script type="text/html" id="use_button">
        <button class="layui-btn layui-btn-primary layui-btn-sm" style="border-radius: 0;">
            <b style="color:green;"
               onclick="goods_show('新建补货单','{{url("admin/storage/add/add_goods")}}',2,600,510)">新建补货单</b>
        </button>
    </script>
    <script type="text/html" id='is_local'>
        <div>
            @{{# if(d.is_local==1){ }}
            <span style='color:green'>本地仓</span>
            @{{# }else{ }}
            <span style='color:brown'>海外仓</span>
            @{{# } }}
        </div>
    </script>
    <script type="text/html" id="button" >
        <a class="layui-btn layui-btn-xs" lay-event="detail">查看</a>
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    </script>
@endsection
@section('js')
    <script>
        var that = this;
        layui.config({
            base: '{{asset("/admin/layuiadmin/")}}/' //静态资源所在路径
        }).extend({
            index: 'lib/index' //主入口模块
        }).use(['index','admin', 'table','laydate'],function(){
            var table = layui.table;
            var laydate = layui.laydate;
            var $ =layui.jquery;
            var options={
                elem: '#storagelist'
                ,url: '/admin/storage/add'//数据接口
                ,page: true //开启分页
                ,toolbar:'#use_button'
                ,method:'post'
                ,headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
                ,text: {
                    none: '暂无仓库数据'
                }
                ,autoSort:false
                ,initSort: {
                    field: 'check_at' //排序字段，对应 cols 设定的各字段名
                    ,type: 'desc' //排序方式  asc: 升序、desc: 降序、null: 默认排序
                }
                ,where: {
                    search:$('#test-table-demoReload').val(),
                    time:$('#test-laydate-out').val()
                }
                ,cols: [[ //表头
                    {field: 'storage_append_id', title: 'ID', sort: true, fixed: 'left'}
                    ,{field: 'storage_append_single', title: '采购单号'}
                    ,{field: 'storage_append_admin', title: '补货人'}
                    ,{field: 'storage_append_status', title: '状态'}
                    ,{field: 'storage_append_time', title: '采购时间'}
                    ,{field: 'storage_append_msg', title: '采购单备注'}
                    ,{ title: '操作',templet:'#button'}
                ]]
            };

        });
    </script>
@endsection