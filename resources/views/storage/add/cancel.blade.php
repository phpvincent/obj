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
                            <label class="layui-form-label">补货单号</label>
                            <div class="layui-input-inline">
                                <input type="text" name="storage_append_single" value="{{$storage_append_single}}" lay-verify="required" disabled class="layui-input">
                                <input type="text" style="display: none" name="storage_append_id" readonly value="{{$storage_append_id}}" lay-verify="required" disabled class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">不可修改。一般用于后台登入名</div>
                        </div>
                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label">取消信息记录</label>
                            <div class="layui-input-block">
                                <textarea name="remarks" lay-verify="required" placeholder="请输入内容" class="layui-textarea"></textarea>
                            </div>
                        </div>
                        <!--  <div class="layui-form-item">
                           <label class="layui-form-label">头像</label>
                           <div class="layui-input-inline">
                             <input name="avatar" lay-verify="required" id="LAY_avatarSrc" placeholder="图片地址" value="http://cdn.layui.com/avatar/168.jpg" class="layui-input">
                           </div>
                           <div class="layui-input-inline layui-btn-container" style="width: auto;">
                             <button type="button" class="layui-btn layui-btn-primary" id="LAY_avatarUpload">
                               <i class="layui-icon">&#xe67c;</i>上传图片
                             </button>
                             <button class="layui-btn layui-btn-primary" layadmin-event="avartatPreview">查看图片</button >
                           </div>
                        </div> -->
                        <!--    <div class="layui-form-item">
                             <label class="layui-form-label">手机</label>
                             <div class="layui-input-inline">
                               <input type="text" name="cellphone" value="" lay-verify="phone" autocomplete="off" class="layui-input">
                             </div>
                           </div>
                           <div class="layui-form-item">
                             <label class="layui-form-label">邮箱</label>
                             <div class="layui-input-inline">
                               <input type="text" name="email" value="" lay-verify="email" autocomplete="off" class="layui-input">
                             </div>
                           </div>
                           <div class="layui-form-item layui-form-text">
                             <label class="layui-form-label">备注</label>
                             <div class="layui-input-block">
                               <textarea name="remarks" placeholder="请输入内容" class="layui-textarea"></textarea>
                             </div>
                           </div> -->
                        <!--  <div class="layui-form-item">
                          <label class="layui-form-label">输入框</label>
                          <div class="layui-input-block">
                            <input type="text" name="" placeholder="请输入" lay-verify='required' autocomplete="off" class="layui-input">
                          </div>
                        </div>
                        <div class="layui-form-item">
                          <label class="layui-form-label">下拉选择框</label>
                          <div class="layui-input-block">
                            <select name="interest" lay-filter="aihao">
                              <option value="0">写作</option>
                              <option value="1">阅读</option>
                            </select>
                          </div>
                        </div>
                        <div class="layui-form-item">
                          <label class="layui-form-label">复选框</label>
                          <div class="layui-input-block">
                            <input type="checkbox" name="like[write]" title="写作">
                            <input type="checkbox" name="like[read]" title="阅读">
                          </div>
                        </div>
                        <div class="layui-form-item">
                          <label class="layui-form-label">开关关</label>
                          <div class="layui-input-block">
                            <input type="checkbox" lay-skin="switch">
                          </div>
                        </div>
                        <div class="layui-form-item">
                          <label class="layui-form-label">开关开</label>
                          <div class="layui-input-block">
                            <input type="checkbox" checked lay-skin="switch">
                          </div>
                        </div>
                        <div class="layui-form-item">
                          <label class="layui-form-label">单选框</label>
                          <div class="layui-input-block">
                            <input type="radio" name="sex" value="0" title="男">
                            <input type="radio" name="sex" value="1" title="女" checked>
                          </div>
                        </div>
                        <div class="layui-form-item layui-form-text">
                          <label class="layui-form-label">请填写描述</label>
                          <div class="layui-input-block">
                            <textarea placeholder="请输入内容" class="layui-textarea"></textarea>
                          </div>
                        </div> -->
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
            form.verify({
                admin_show_name: function(value, item){ //value：表单的值、item：表单的DOM对象
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
                    url:"{{url('admin/storage/add/cancel_storage_append')}}",
                    type:'post',
                    data:data.field,
                    datatype:'json',
                    success:function(msg){
                        if(msg['err']==1){
                            layer.close(index);
                            layer.msg(msg.str,{
                                time: 2000 //2秒关闭（如果不配置，默认是3秒）
                            }, function(){
                                parent.layui.admin.events.refresh();
                            });
                            /*admin.popupRight({
                             id:'test',
                             success:function(){
                               layui.view(this.id).render("system/more")
                             }
                            })*/
                            //window.location.reload();
                            //admin.events.closeThisTabs()
                            //admin.events.closeAllTabs()
                            //admin.events.refresh()
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