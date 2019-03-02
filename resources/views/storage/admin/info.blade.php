@extends('storage.father.static')
@section('content')
<!DOCTYPE html>
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">设置我的资料</div>
          <div class="layui-card-body" pad15>
            
            <div class="layui-form layui-form-pane "  lay-filter="">
              <div class="layui-form-item" >
                <label class="layui-form-label">我的角色</label>
                <div class="layui-input-inline" >
                  <select name="role" lay-verify="">
                  	@foreach(\App\role::get() as $k => $v)
                    <option value="{{$v->role_id}}" @if(Auth::user()->admin_role_id==$v->role_id) selected @else disabled @endif>{{$v->role_name}}</option>
                    @endforeach
                  </select> 
                </div>
                <div class="layui-form-mid layui-word-aux">当前角色不可更改为其它角色</div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">用户名</label>
                <div class="layui-input-inline">
                  <input type="text" name="admin_name" value="{{Auth::user()->admin_name}}" disabled class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">不可修改。一般用于后台登入名</div>
              </div>
               <div class="layui-form-item">
                <label class="layui-form-label">上次登陆时间</label>
                <div class="layui-input-inline">
                  <input type="text" name="admin_time" value="{{Auth::user()->admin_time}}" disabled class="layui-input">
                </div>
              </div>
               <div class="layui-form-item">
                <label class="layui-form-label">上次登陆ip</label>
                <div class="layui-input-inline">
                  <input type="text" name="admin_ip" value="{{Auth::user()->admin_ip}}" disabled class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">真实姓名</label>
                <div class="layui-input-inline">
                  <input type="text" name="admin_real_name"  value="{{Auth::user()->admin_real_name}}" lay-verify="required" autocomplete="off" placeholder="请输入真实姓名" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item" >
                <label class="layui-form-label">名下单品数</label>
                <div class="layui-input-inline">
                  <input type="text" name="goods_count" disabled value="{{\App\goods::where([['goods_admin_id',Auth::user()->admin_id],['is_del','0']])->count()}}"  autocomplete="off" placeholder="" class="layui-input">
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
                  <button class="layui-btn" lay-submit lay-filter="setmyinfo">确认修改</button>
                  <button type="reset" class="layui-btn layui-btn-primary">重新填写</button>
                </div>
              </div>
            </div>
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
  }).use(['index', 'set','form'],function(){
    var form=layui.form
    var $=layui.jquery
  });
  
  </script>
@endsection