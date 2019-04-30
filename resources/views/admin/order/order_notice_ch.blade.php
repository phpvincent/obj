@extends('storage.father.static')
@section('content')
    <div class="layui-container">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-body" pad15>
                        <form class="layui-form layui-form-pane " method="post" lay-filter="formDemo" action="">
                        	<input type="hidden" name="id" value="{{$order_notice['order_notice_id']}}">
                            {{csrf_field()}}
                             <div class="layui-form-item">
                              <label class="layui-form-label">工作时间</label>
                              <div class="layui-input-inline">
                               <input type="text" class="layui-input" name="laydate" id="test-laydate" lay-verify="laydate" value="{{$order_notice['order_notice_start'].' ~ '.$order_notice['order_notice_end']}}" 
                                                   placeholder="工作时间">
                              </div>
                            </div>
                          <div class="layui-form-item">
                                <div class="layui-inline">
                                    <label class="layui-form-label">选择语种</label>
                                    <div class="layui-input-inline">
                                        <select name="order_notice_lan" id="order_notice_lan" lay-verify="required" lay-search="" lay-filter="goodsSelec">
                                        <option value="">请选择</option>
                                            @foreach($languages as $k => $item)
                                            <option value="{{$k}}" @if($order_notice['order_notice_lan']==$k) selected="selected" @endif >{{$item}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">通知电话</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="order_notice_phone" id="order_notice_phone" lay-verify="required" value="{{$order_notice['order_notice_phone']}}" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">备注</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="order_notice_remark" id="order_notice_remark" lay-verify="required" value="{{$order_notice['order_notice_remark']}}" autocomplete="off" class="layui-input">
                                </div>
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
                <div class="layui-card">
                <!-- <div class="layui-card-header">补货单</div>
                <div class="layui-card-body" pad15>
                   <form class="layui-form layui-form-pane goodsAppendForm" method="post" lay-filter="" action="">
                   <div class="layui-row">
                      <table class="layui-table goodsAppend">
                        <thead>
                          <tr>
                           <th>产品ID</th>
                            <th>产品名称</th>
                            <th>变种</th>
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
            </div> -->
        </div>
    </div>
 
   </script>
@endsection
@section('js')
    <script>
        layui.config({
            base: '{{asset("/admin/layuiadmin/")}}/' //静态资源所在路径
        }).extend({
            index: 'lib/index' //主入口模块
        }).use(['form','index', 'set', 'admin', 'laydate'],function(){
            var form=layui.form;
            //var laytpl = layui.laytpl;
            var admin=layui.admin;
            var $=layui.jquery;
            var layer = layui.layer;
            var laydate=layui.laydate;
            laydate.render({
              elem: '#test-laydate' //指定元素
              ,type:'time'
              ,range: '~' //或 range: '~' 来自定义分割字符
              ,theme: 'molv'
              ,calendar: true
            });

            //自定义验证规则
            form.verify({
                order_notice_lan: function (value) {
                    if (value==null || value==false) {
                        return '请选择语种';
                    }
                }
            });

          form.on('submit',function(data){
             var loading = layer.load();
             $.ajax({
                  url:"{{url('admin/order/order_notice/ch')}}",
                  type:'post',
                  data:data.field,
                  datatype:'json',
                  success:function(msg){
                         if(msg['err']==1){
                           layer.close(loading);
                           layer.msg(msg.str,{
                            time: 3000 //2秒关闭（如果不配置，默认是3秒）
                            }, function(){
                              parent.location.reload();
                              var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                parent.layer.close(index); //再执行关闭
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
@endsection