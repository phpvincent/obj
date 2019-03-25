@extends('storage.father.static')
@section('content')
    <div class="layui-fluid">
        <div class="layui-card">
            <!-- 表格元素 -->
            <div class="layui-card-body">
                <table id="storagelist" lay-filter='button-listen'></table>
            </div>

        </div>
    </div>
    <script type="text/html" id="button" >
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        {{--<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>--}}
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
                ,url: '/admin/storage/add/show_goods_kind'//数据接口
                ,page: true //开启分页
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
                    storage_append_id:{{$id}}
                }
                ,cols: [[ //表头
                    {field: 'storage_append_single', title: '采购单号'}
                    ,{field: 'goods_kind_name', title: '产品名称'}
                    ,{field: 'num', title: '产品件数'}
                    ,{field: 'storage_append_admin', title: '补货人'}
                    ,{field: 'storage_append_status', title: '状态'}
                    ,{field: 'storage_append_time', title: '采购时间'}
                    ,{field: 'storage_append_end_time', title: '进仓时间'}
                    ,{field: 'storage_append_msg', title: '采购单备注'}
                    ,{ title: '操作',templet:'#button'}
                ]]
            };
            //表格初始化
            table.render(options);

            //table事件监听
            table.on("tool(button-listen)",function(obj){
                var data = obj.data; //获得当前行数据
                var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
                var tr = obj.tr; //获得当前行 tr 的DOM对象
                if(layEvent=='edit'){
                    //修改产品
                    that.goods_show('修改产品属性', '{{url("admin/storage/add/append_goods_edit")}}?storage_append_id=' + data.storage_append_id + '&goods_kind_id=' + data.storage_append_kind_id, 2, 600, 510);
                }else{
                    layer.confirm('真的删除行么', function(index){
                        layer.close(index);
                        //向服务端发送删除指令
                        $.ajax({
                            url:"{{url('admin/storage/add/append_goods_del')}}",
                            type:'get',
                            data:{storage_append_id:data.storage_append_id,goods_kind_id:data.storage_append_kind_id},
                            datatype:'json',
                            success:function(msg){
                                if(msg['err']==1){
                                    layer.close(index);
                                    layer.msg(msg.str,{
                                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                                    }, function(){
                                        obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
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
                }
            });

            //model 模态框
            goods_show=function goods_show(title,url,type,w,h){
                if( layui.device().android||layui.device().ios){
                    layer.open({
                        skin: 'layui-layer-nobg', //没有背景色
                        type: type,
                        title: title,
                        area: [375, 667],
                        fixed: false, //不固定
                        maxmin: true,
                        content: url,
                        end: function (){
                            //执行重载
                            table.reload('storagelist',{
                                page: {
                                    curr: 1 //重新从第 1 页开始
                                }
                                ,where: {
                                    storage_append_id:{{$id}}
                                }
                            });
                        }
                    });
                }else{
                    layer.open({
                        skin: 'layui-layer-nobg', //没有背景色
                        type: type,
                        title: title,
                        area: [w, h],
                        fixed: false, //不固定
                        maxmin: true,
                        content: url,
                        end: function (){
                            //执行重载
                            table.reload('storagelist',{
                                page: {
                                    curr: 1 //重新从第 1 页开始
                                }
                                ,where: {
                                    storage_append_id:{{$id}}
                                }
                            });
                        }
                    });
                }
            }
        });
    </script>
@endsection