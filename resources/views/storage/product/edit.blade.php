@extends('storage.father.static')
@section('content')
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">开启单元格编辑</div>
                <div class="layui-card-body">
                    <table class="layui-hide" id="test-table-cellEdit" lay-filter="test-table-cellEdit"></table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        var that = this;
        layui.config({
            base: '{{asset("/admin/layuiadmin/")}}/' //静态资源所在路径
        }).extend({
            index: 'lib/index' //主入口模块
        }).use(['index', 'table'], function(){
            var table = layui.table;

            table.render({
                elem: '#test-table-cellEdit'
                ,url: layui.setter.base + 'json/table/demo.js'
                ,cols: [[
                    {type:'checkbox'}
                    ,{field:'id', title:'ID', width:80, sort: true}
                    ,{field:'username', title:'用户名', width:120, sort: true, edit: 'text'}
                    ,{field:'email', title:'邮箱', edit: 'text', minWidth: 150}
                    ,{field:'sex', title:'性别', width:80, edit: 'text'}
                    ,{field:'city', title:'城市', edit: 'text', minWidth: 100}
                    ,{field:'experience', title:'积分', sort: true, edit: 'text'}
                ]]
            })

            //监听单元格编辑
            table.on('edit(test-table-cellEdit)', function(obj){
                var value = obj.value //得到修改后的值
                    ,data = obj.data //得到所在行所有键值
                    ,field = obj.field; //得到字段
                layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value, {
                    offset: '15px'
                });
            });

        });
    </script>
@endsection