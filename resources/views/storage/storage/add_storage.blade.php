@extends('storage.father.static')
@section('content')
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body" pad15>
                    <form class="layui-form layui-form-pane " method="post" lay-filter="" action="">
                        {{csrf_field()}}
                        <div class="layui-form-item">
                            <label class="layui-form-label">仓库名称</label>
                            <div class="layui-input-inline">
                                <input type="text" name="storage_name" lay-verify="required|storage_name" value="" class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">仓库名称唯一且不可修改。</div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">仓库地址</label>
                            <div class="layui-input-block">
                                <input type="radio" lay-filter="is_local" name="is_local" value="1" title="本地仓">
                                <input type="radio" lay-filter="is_local" name="is_local" value="0" title="海外仓" checked>
                            </div>
                        </div>
                        <div class="layui-form-item item-model-hide">
                            <div class="layui-inline">
                                <label class="layui-form-label">仓库模板</label>
                                <div class="layui-input-inline">
                                    <select name="template_id" lay-verify="required">
                                        <option value="0" >台湾</option>
                                        <option value="2">阿联酋</option>
                                        <option value="3">马来西亚</option>
                                        <option value="4">泰国</option>
                                        <option value="5">日本</option>
                                        <option value="6">印度尼西亚</option>
                                        <option value="7">菲律宾</option>
                                        <option value="8">英国</option>
                                        <option value="10">美国</option>
                                        <option value="11">越南</option>
                                        <option value="12">沙特阿拉伯</option>
                                        <option value="14">卡塔尔</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="layui-form-item  item-model-hide">
                            <label class="layui-form-label">订单可拆分</label>
                            <div class="layui-input-block">
                                <input type="radio" name="is_split" value="0" title="可拆分">
                                <input type="radio" name="is_split" value="1" title="不可拆分" checked>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button class="layui-btn" lay-submit lay-filter="">确认提交</button>
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
        }).use(['form','index', 'set','admin'],function(){
            var form=layui.form;

            var admin=layui.admin;
            var $=layui.jquery;

            var addressID = $("input[name='is_local']:checked").val();
            if(addressID === '1'){
                $('.item-model-hide').addClass('layui-hide');
            }

            form.on('radio(is_local)', function () {
                var addressID = $("input[name='is_local']:checked").val();
                if(addressID === '1'){
                    $('.item-model-hide').addClass('layui-hide');
                }else{
                    $('.item-model-hide').removeClass('layui-hide');
                }
            });

            form.verify({
                storage_name: function(value, item){ //value：表单的值、item：表单的DOM对象
                    if(!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\s·]+$").test(value)){
                        return '真实姓名不能有特殊字符';
                    }
                    if(/(^\_)|(\__)|(\_+$)/.test(value)){
                        return '真实姓名首尾不能出现下划线\'_\'';
                    }
                    if(/^\d+\d+\d$/.test(value)){
                        return '真实姓名不能全为数字';
                    }
                }
            });
            form.on('submit',function(data){
                var index = layer.load();
                $.ajax({
                    url:"{{url('admin/storage/list/add_storage')}}",
                    type:'post',
                    data:data.field,
                    datatype:'json',
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
            })
        });

    </script>
@endsection