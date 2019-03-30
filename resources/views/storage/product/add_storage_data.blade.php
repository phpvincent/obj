@extends('storage.father.static')
@section('content')
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-header">设置我的资料</div>
                    <div class="layui-card-body" pad15>

                        <form class="layui-form layui-form-pane " method="post" lay-filter="form1" action="">
                            {{csrf_field()}}
                            <div class="layui-form-item">
                                <label class="layui-form-label">仓库名称</label>
                                <div class="layui-input-inline"  style="width: 250px">
                                    <input type="text" name="storage_name" id="storage_name" value="{{$storage->storage_name}}" disabled class="layui-input">
                                    <input type="text" style="display: none" name="storage_id" id="storage_id" value="{{$storage->storage_id}}" disabled class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">订单编号</label>
                                <div class="layui-input-inline" style="width: 250px">
                                    <select id="order_id" name="order_id" lay-verify="required" lay-filter="order_id" lay-search="">
                                        @foreach($orders as $k => $v)
                                            <option value="{{$k}}">{{$v}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">运单号</label>
                                <div class="layui-input-inline" style="width: 250px">
                                    <input type="text" name="express_delivery" value="" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">有效期</label>
                                <div class="layui-input-inline" style="width: 250px">
                                    <input type="text" name="expiry_at" id="expiry_at" lay-verify="required" onkeyup="(this.v=function(){this.value=this.value.replace(/[^\d]/g,'');})" onblur="this.v();"  value="7" class="layui-input">
                                </div>
                            </div>
                            <!-- <div class="layui-form-item layui-form-text">
                                <label class="layui-form-label">退货备注</label>
                                <div class="layui-input-block">
                                    <textarea placeholder="请输入内容" lay-verify="required" name="remarks" class="layui-textarea"></textarea>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <button class="layui-btn" lay-submit lay-filter="">确认修改</button>
                                    <button type="reset" class="layui-btn layui-btn-primary">重新填写</button>
                                </div>
                            </div> -->
                        </form>
                    </div>
                </div>
                <div class="layui-card">
                    <div class="layui-card-header">补货单</div>
                    <div class="layui-card-body" pad15>
                        <form class="layui-form layui-form-pane goodsAppendForm" method="post" lay-filter="" action="">
                            <div class="layui-row">
                                <table class="layui-table goodsAppend">
                                    <thead>
                                    <tr>
                                        <th>产品ID</th>
                                        <th>产品名称</th>
                                        <th>属性</th>
                                        <th>SKU</th>
                                        <th>数量</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div class="layui-row">
                                <div class="layui-form-item">
                                    <div class="layui-input-block">
                                        <button style="float: right;" class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script id="goodsAppend" type="text/html">
            <tr>
                <td>
                    <input type="hidden" readonly name="goods_kind_id" value="@{{d.goods_kind_id}}" class="layui-input">
                    <span>@{{d.goods_kind_id}}</span>
                </td>
                <td>
                    <input type="hidden" readonly name="goods_kind_name" value="@{{d.goods_kind_name}}" class="layui-input">
                    <span>@{{d.goods_kind_name}}</span>
                </td>
                <td>
                    <input type="hidden" readonly name="goods_attr" value="@{{d.goods_attr}}" class="layui-input">
                    <span>@{{d.goods_attr}}</span>
                </td>
                <td>
                    <input type="hidden" readonly name="goods_sku" value="@{{d.goods_sku}}" class="layui-input">
                    <span>@{{d.goods_sku}}</span>
                </td>
                <td>
                    <input type="text" name="num" value="@{{d.num}}" placeholder="请输入数量" class="layui-input" lay-verify="required">
                </td>
                <td>
                    <span class="layui-btn layui-btn-xs layui-btn-danger removeGoodsAppend"><i class="layui-icon">&#xe640;</i></span>
                </td>
            </tr>
        </script>
@endsection
@section('js')
    <script>
        layui.config({
            base: '{{asset("/admin/layuiadmin/")}}/' //静态资源所在路径
        }).extend({
            index: 'lib/index' //主入口模块
        }).use(['index', 'set','admin', 'laytpl'],function(){
            var form=layui.form
            var admin=layui.admin
            var $=layui.jquery
            var laytpl = layui.laytpl
            // form.on('submit',function(data){
            //     var index = layer.load();
            //     $.ajax({
            //         url:"{{url('admin/storage/list/add_storage_data')}}",
            //         type:'post',
            //         data:data.field,
            //         datatype:'json',
            //         success:function(msg){
            //             if(msg['err']==1){
            //                 layer.close(index);
            //                 layer.msg(msg.str,{
            //                     time: 2000 //2秒关闭（如果不配置，默认是3秒）
            //                 }, function(){
            //                     parent.layui.admin.events.refresh();
            //                 });
            //             }else if(msg['err']==0){
            //                 layer.close(index);
            //                 layer.msg(msg.str);
            //             }else{
            //                 layer.close(index);
            //                 layer.msg('修改失败！');
            //             }
            //         }
            //     })
            //     return false;
            // })
            init();
            function init () {
                $.ajax({
                    url:"/admin/storage/list/get_order_info",
                    type:'get',
                    data: {order_id: $('#order_id').val()},
                    // datatype:'json',
                    success:function(msg){
                      $.each(msg.data, function (index, value) { 
                        var getTpl = goodsAppend.innerHTML
                            laytpl(getTpl).render(value, function(string){
                                $('.goodsAppend tbody').append(string)
                            });
                      });
                    }
                })
            }

            form.on('select(order_id)', function(data){
              init()
            })
            // 表格提交
            form.on('submit(formDemo)', function(data){
                        if($('#storage_name').val()===''){
                            layer.msg('<i class="layui-icon layui-icon-face-cry" style="font-size: 30px; color: #FF5722;"></i> 请填写采购单号' ,{offset: '100px'})
                            return false
                        }
                        if($('#order_id').val()===''){
                            layer.msg('<i class="layui-icon layui-icon-face-cry" style="font-size: 30px; color: #FF5722;"></i> 请选择采购时间' ,{offset: '100px'})
                            return false
                        }
                        if($('#expiry_at').val()===''){
                            layer.msg('<i class="layui-icon layui-icon-face-cry" style="font-size: 30px; color: #FF5722;"></i> 请选择采购时间' ,{offset: '100px'})
                            return false
                        }

                        var data = $(data.form).serializeArray();
                        var obj = {};
                        var arr = [];
                        for(var i=0; i<data.length; i++){
                            if(data[i].name === 'num'){
                                obj[data[i].name] = data[i].value
                                arr.push(obj)
                                obj = {};
                            } else{
                                obj[data[i].name] = data[i].value
                            }
                        }
                        var index = layer.load();
                        console.log('dd', arr)
                         $.ajax({
                             url:"/admin/storage/list/add_storage_data",
                             type:'post',
                             data:{goods_attr:JSON.stringify(arr),order_id:$('#order_id').val(),express_delivery:$('#express_delivery').val(),expiry_at:$('#expiry_at').val(),storage_id:$('#storage_id').val()},
                             datatype:'json',
                             headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                             success:function(msg){
                                 if(msg['err']==1){
                                     layer.close(index);
                                     layer.msg(msg.msg,{
                                         time: 2000 //2秒关闭（如果不配置，默认是3秒）
                                     }, function(){
                                         // parent.layui.admin.events.refresh();
                                         window.parent.location.reload();
                                     });
                                 }else if(msg['err']==0){
                                     layer.close(index);
                                     layer.msg(msg.msg);
                                 }else{
                                     layer.close(index);
                                     layer.msg('新增失败！');
                                 }
                             }
                         });
                        return false;
                    });
            // 表格里面的删除按钮
            $(document).on("click",".removeGoodsAppend",function () {
                $(this).parent().parent().remove()
            })
        });

    </script>
@endsection