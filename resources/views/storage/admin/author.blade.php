@extends('storage.father.static')
@section('content')
<!DOCTYPE html>
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">权限设置</div>
          <div class="layui-card-body">
          <button class="layui-btn addRole">添加角色</button>
            <form class="layui-form layui-form-pane " method="post" lay-filter="" action="">
              laofan laofan laofan laofan laofan laofan laofan laofan laofan
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
    $(".addRole").on("click", addRole);

     function addRole () {
       layer.open({
         title: '添加角色',
         content: '<div class="layui-form-item"><label class="layui-form-label">用户名</label><div class="layui-input-inline"><input type="text" name="admin_name" value="" class="layui-input"></div></div>',
         yes: function(index, layero){
           console.log(layero.find('input').val())
         }
       });
    }
  });
  
  </script>
@endsection