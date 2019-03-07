@extends('storage.father.static')
@section('content')
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">修改密码</div>
          <div class="layui-card-body" pad15>
            <form class="layui-form" lay-filter="">
            	{{csrf_field()}}
              <div class="layui-form-item">
                <label class="layui-form-label">当前密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="oldPassword" value="{{Auth::user()->password}}" lay-verify="required" lay-verType="tips" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">新密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="password" lay-verify="pass" lay-verType="tips" autocomplete="off" id="LAY_password" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">6到16个字符</div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">确认新密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="repassword" lay-verify="repass" lay-verType="tips" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <div class="layui-input-block">
                  <button class="layui-btn" lay-submit lay-filter="setmypass">确认修改</button>
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
  }).use(['index','form'],function(){
  	var form=layui.form;
  	var $=layui.jquery;
  		form.verify({
        pass: function(value, item){ //value：表单的值、item：表单的DOM对象
          if(16<value.length||value.length<6){
            return '密码长度在6到16个字符之间！';
          }
        },
      });   
  		form.on('submit',function(data){
  			 var loading = layer.load();
         $.ajax({
              url:"{{url('admin/storage/password')}}",
              type:'post',
              data:data.field,
              datatype:'json',
              success:function(msg){
                     if(msg['err']==1){
                       layer.close(loading);
                       layer.msg(msg.str,{
                        time: 3000 //2秒关闭（如果不配置，默认是3秒）
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
                      layer.close(loading);   
                       layer.msg(msg.str);
                     }else{
                      layer.close(loading);   
                       layer.msg('修改失败！');
                     }
              }
            })
         return false;
  		})
  });
  </script>
</body>
</html>
@endsection