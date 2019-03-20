@extends('storage.father.static')
@section('content')
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card">
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
            var $ =layui.jquery;

            table.render({
                elem: '#test-table-cellEdit'
                ,url: '/admin/storage/list/storage_stock_show' //数据接口
                ,method:'post'
                ,headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
                ,where: {
                    goods_kind_id:{{$goods_kind_id}},
                    storage_append_id:{{$storage_append_id}},
                }
                ,cols: [[
                    {field:'goods_kind_name', title:'产品名称'}
                    ,{field:'goods_sku', title:'SKU'}
                    ,{field:'goods_attr', title:'属性值'}
                    ,{field:'num', title:'件数', style:'background-color: #1ddac9; color: #fff;', edit: 'text'}
                ]]
            })

            //监听单元格编辑
            table.on('edit(test-table-cellEdit)', function(obj){
                var value = obj.value //得到修改后的值
                    ,data = obj.data //得到所在行所有键值
                    ,field = obj.field; //得到字段
                //向服务端发送删除指令
                $.ajax({
                    url:"{{url('admin/storage/list/up_storage_stock')}}",
                    type:'post',
                    headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                    data:{id:data.goods_kind_id,storage_id:{{$storage_id}},four_sku:data.goods_kind_sku,last_sku:data.sku_attr,num:value},
                    datatype:'json',
                    success:function(msg){
                        if(msg['err']==1){
                            layer.msg(msg.str,{
                                time: 2000 //2秒关闭（如果不配置，默认是3秒）
                            }, function(){
                                if(value === ''){
                                    //执行重载
                                    table.reload('test-table-cellEdit',{
                                        where: {
                                            id:{{$id}},
                                            storage_id:{{$storage_id}},
                                        }
                                    });
                                }
                                // window.parent.location.reload();
                                // parent.layui.admin.events.refresh();
                            });
                        }else if(msg['err']==0){
                            layer.close(index);
                            layer.msg(msg.str);
                        }else{
                            layer.close(index);
                            layer.msg('删除失败！');
                        }
                    }
                });
            });

        });
    </script>
@endsection