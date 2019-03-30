@extends('storage.father.static')
@section('content')
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">设置我的资料</div>
                <div class="layui-card-body" pad15>

                    <form class="layui-form layui-form-pane " method="post" lay-filter="" action="">
                        {{csrf_field()}}
                        <div class="layui-form-item">
                            <label class="layui-form-label">仓库名称</label>
                            <div class="layui-input-inline"  style="width: 250px">
                                <input type="text" name="storage_name" value="{{$storage->storage_name}}" disabled class="layui-input">
                                <input type="text" style="display: none" name="storage_id" value="{{$storage->storage_id}}" disabled class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">订单编号</label>
                                <div class="layui-input-inline" style="width: 250px">
                                    <select name="order_id" lay-verify="required" lay-search="">
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
                                <input type="text" name="expiry_at" lay-verify="required" onkeyup="(this.v=function(){this.value=this.value.replace(/[^\d]/g,'');})" onblur="this.v();"  value="7" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item layui-form-text">
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
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        layui.config({
            base: '{{asset("/admin/layuiadmin/")}}/' //静态资源所在路径
        }).extend({
            index: 'lib/index' //主入口模块
        }).use(['index', 'set','admin'],function(){
            var form=layui.form
            var admin=layui.admin
            var $=layui.jquery
            form.on('submit',function(data){
                var index = layer.load();
                $.ajax({
                    url:"{{url('admin/storage/list/return_goods')}}",
                    type:'post',
                    data:data.field,
                    datatype:'json',
                    success:function(msg){
                        if(msg['err']==1){
                            layer.close(index);
                            layer.msg(msg.str,{
                                time: 2000 //2秒关闭（如果不配置，默认是3秒）
                            }, function(){
                                // parent.layui.admin.events.refresh();
                                window.parent.location.reload();
                            });
                        }else if(msg['err']==0){
                            layer.close(index);
                            layer.msg(msg.str);
                        }else{
                            layer.close(index);
                            layer.msg('修改失败！');
                        }
                    }
                })
                return false;
            })
        });

    </script>
@endsection