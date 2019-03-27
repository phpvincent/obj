@extends('storage.father.static')
@section('content')
    {{--列表插入图片--}}
    <script type="text/html" id="test-table-switchTpl">
        <img src="/@{{ d.goods_kind_img }}" onclick="show_kind_img('产品图片','/@{{d.goods_kind_img}}')" width="50px" alt="产品图片" >
    </script>
    {{--产品重量--}}
    <script type="text/html" id="test-table-weight">
        @{{ parseFloat(d.goods_buy_weight) }}kg
    </script>
    <div class="layui-fluid">
        <div class="layui-card">
            <!-- 搜索控件 -->
            <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                <div class="layui-form-item">
                    {{--<div class="layui-inline">--}}
                        {{--<div class="layui-form-item">--}}
                            {{--<div class="layui-inline">--}}
                                {{--<label class="layui-form-label">入库时间：</label>--}}
                                {{--<div class="layui-input-inline">--}}
                                    {{--<input type="text" class="layui-input" id="test-laydate-out"--}}
                                           {{--placeholder="日期范围">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="layui-inline">
                        <label class="layui-form-label">选择仓库</label>
                        <div class="layui-input-block">
                            <select name="storage_addr" id="storage_addr" lay-verify="required">
                                @foreach($stos as $item)
                                <option @if($item->storage_id == $id) selected @endif value="{{$item->storage_id}}">{{$item->storage_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">库存状态</label>
                        <div class="layui-input-block">
                            <select name="storage_status" id="storage_status" lay-verify="required">
                                <option value="0">真实库存</option>
                                <option value="1">预扣货</option>
                            </select>
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
    <script type="text/html" id="test-table-operate-barDemo" >
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
@endsection
@section('js')
    <script>
        var that = this;
        layui.config({
            base: '{{asset("/admin/layuiadmin/")}}/' //静态资源所在路径
        }).extend({
            index: 'lib/index' //主入口模块
        }).use(['index','admin', 'table'],function(){
            var table = layui.table;
            var $ =layui.jquery;
            table.render({
                elem: '#storagelist'
                ,height: 312
                ,url: '/admin/storage/list/get_table' //数据接口
                ,page: true //开启分页
                ,method:'post'
                ,headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
                ,text: {
                    none: '暂无仓库数据'
                }
                ,where: {
                    id:$('#storage_addr').val(),
                    search:$('#test-table-demoReload').val(),
                    storage_status:$('#storage_status').val()
                }
                ,cols: [[ //表头
                    {field: 'goods_kind_id', title: 'ID', sort: true, fixed: 'left'}
                    ,{field: 'goods_kind_name', title: '仓库名'}
                    ,{field: 'goods_kind_img', title: '产品图片',templet:'#test-table-switchTpl'}
                    ,{field: 'goods_kind_english_name', title: '产品英文名称',templet:'#is_local'}
                    ,{field: 'goods_kind_volume', title: '产品体积',}
                    ,{width: 100,align:'center',title: '产品重量',templet: '#test-table-weight'}
                    ,{field: 'num',width: 100,align:'center',title: '库存'}
                    ,{width:150, align:'center', title: '操作', toolbar: '#test-table-operate-barDemo'}
                ]]
            });

            //搜索刷新数据
            var active = {
                reload: function(){
                    //执行重载
                    table.reload('storagelist',{
                        page: {
                            curr: 1 //重新从第 1 页开始
                        }
                        ,where: {
                            search:$('#test-table-demoReload').val(),
                            id:$('#storage_addr').val(),
                            storage_status:$('#storage_status').val()
                        }
                    });
                }
            };

            //触发搜索事件
            $('.test-table-reload-btn .layui-btn').on('click', function () {
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });

            //table事件监听
            table.on("tool(button-listen)",function(obj){
                var data = obj.data; //获得当前行数据
                var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
                var tr = obj.tr; //获得当前行 tr 的DOM对象
                if(layEvent=='edit'){
                    //修改产品
                    that.goods_show('修改产品库存', '{{url("admin/storage/list/up_storage_stock")}}?id=' + data.goods_kind_id + '&storage_id='+ $('#storage_addr').val(), 2, 600, 510);
                }else{
                    layer.confirm('真的删除行么', function(index){
                        layer.close(index);
                        //向服务端发送删除指令
                        $.ajax({
                            url:"{{url('admin/storage/list/del_storage_stock')}}",
                            type:'get',
                            data:{id:data.goods_kind_id,storage_id:$('#storage_addr').val()},
                            datatype:'json',
                            success:function(msg){
                                if(msg['err']==1){
                                    layer.close(index);
                                    layer.msg(msg.str,{
                                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                                    }, function(){
                                        // parent.layui.admin.events.refresh();
                                        obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
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
            })

            //model 模态框
            goods_show=function goods_show(title,url,type,w,h){
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
                                search:$('#test-table-demoReload').val(),
                                id:$('#storage_addr').val(),
                                storage_status:$('#storage_status').val()
                            }
                        });
                    }
                });
            }
        });


    </script>
@endsection