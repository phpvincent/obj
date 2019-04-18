@extends('worker.father.static')
@section('content')
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">追踪配置</div>
          <div class="layui-card-body" pad15>
            <form class="layui-form" lay-filter="" method="post">
            	{{csrf_field()}}
              <div class="layui-form-item">
                <label class="layui-form-label">追踪时间</label>
                <div class="layui-input-inline">
                 <input type="text" class="layui-input" name="laydate" id="test-laydate" lay-verify="laydate" value="{{$worker_monitor['worker_monitor_start_time'].' ~ '.$worker_monitor['worker_monitor_stop_time']}}" 
                                     placeholder="追踪时间范围">
                </div>
              </div>
              <div class="layui-form-item flag" style="">
              	 <label class="layui-form-label">追踪页面</label>
                            <div class="layui-inline">
                                    <div class="goodsCheckbox">
                                      <input type="checkbox" name="worker_monitor_route_type[]" title="站点首页" value="0" lay-filter="monitorRouteCheck" @if(in_array(0,explode(",",$worker_monitor['worker_monitor_route_type']))) checked="checked" @endif>
                                      <div class="layui-unselect layui-form-checkbox"><span>站点首页</span><i class="layui-icon layui-icon-ok"></i></div>  
                                  	</div>
                            </div>
                            <div class="layui-inline">
                                    <div class="goodsCheckbox">
                                      <input type="checkbox" name="worker_monitor_route_type[]" title="站点列表页" value="1" lay-filter="monitorRouteCheck" @if(in_array(1,explode(",",$worker_monitor['worker_monitor_route_type']))) checked="checked" @endif>
                                      <div class="layui-unselect layui-form-checkbox"><span>站点列表页</span><i class="layui-icon layui-icon-ok"></i></div>  
                                  	</div>
                            </div>
                            <div class="layui-inline">
                                    <div class="goodsCheckbox">
                                      <input type="checkbox" name="worker_monitor_route_type[]" title="站点帮助页" value="2" lay-filter="monitorRouteCheck" @if(in_array(2,explode(",",$worker_monitor['worker_monitor_route_type']))) checked="checked" @endif>
                                      <div class="layui-unselect layui-form-checkbox"><span>站点帮助页</span><i class="layui-icon layui-icon-ok"></i></div>  
                                  	</div>
                            </div>
                            <div class="layui-inline">
                                    <div class="goodsCheckbox">
                                      <input type="checkbox" name="worker_monitor_route_type[]" title="单品首页" value="3" lay-filter="monitorRouteCheck" @if(in_array(3,explode(",",$worker_monitor['worker_monitor_route_type']))) checked="checked" @endif>
                                      <div class="layui-unselect layui-form-checkbox"><span>单品首页</span><i class="layui-icon layui-icon-ok"></i></div>  
                                  	</div>
                            </div>
                            <div class="layui-inline">
                                    <div class="goodsCheckbox">
                                      <input type="checkbox" name="worker_monitor_route_type[]" title="单品下单页" value="4" lay-filter="monitorRouteCheck" @if(in_array(4,explode(",",$worker_monitor['worker_monitor_route_type']))) checked="checked" @endif>
                                      <div class="layui-unselect layui-form-checkbox"><span>单品下单页</span><i class="layui-icon layui-icon-ok"></i></div>  
                                  	</div>
                            </div>
                            <div class="layui-inline">
                                    <div class="goodsCheckbox">
                                      <input type="checkbox" name="worker_monitor_route_type[]" title="单品订单检索页" value="5" lay-filter="monitorRouteCheck" @if(in_array(5,explode(",",$worker_monitor['worker_monitor_route_type']))) checked="checked" @endif>
                                      <div class="layui-unselect layui-form-checkbox"><span>单品订单检索页</span><i class="layui-icon layui-icon-ok"></i></div>  
                                  	</div>
                            </div>
                            <div class="layui-inline">
                                    <div class="goodsCheckbox">
                                      <input type="checkbox" name="worker_monitor_route_type[]" title="单品结算成功页" value="6" lay-filter="monitorRouteCheck" @if(in_array(6,explode(",",$worker_monitor['worker_monitor_route_type']))) checked="checked" @endif>
                                      <div class="layui-unselect layui-form-checkbox"><span>单品结算成功页</span><i class="layui-icon layui-icon-ok"></i></div>  
                                  	</div>
                            </div>
                            
              </div>
             <div class="layui-form-item flag" style="">
               	 <label class="layui-form-label">追踪IP地区</label>
               	 			<div class="layui-inline">
                                    <div class="goodsCheckbox">
                                      <input type="checkbox" name="worker_monitor_ip_type[]" title="台湾" value="0" lay-filter="monitorRouteCheck" @if(in_array(0,explode(",",$worker_monitor['worker_monitor_ip_type']))) checked="checked" @endif>
                                      <div class="layui-unselect layui-form-checkbox"><span>台湾</span><i class="layui-icon layui-icon-ok"></i></div>  
                                  	</div>
                            </div>
                            <div class="layui-inline">
                                    <div class="goodsCheckbox">
                                      <input type="checkbox" name="worker_monitor_ip_type[]" title="菲律宾" value="7" lay-filter="monitorRouteCheck" @if(in_array(7,explode(",",$worker_monitor['worker_monitor_ip_type']))) checked="checked" @endif>
                                      <div class="layui-unselect layui-form-checkbox"><span>菲律宾</span><i class="layui-icon layui-icon-ok"></i></div>  
                                  	</div>
                            </div>
                            <div class="layui-inline">
                                    <div class="goodsCheckbox">
                                      <input type="checkbox" name="worker_monitor_ip_type[]" title="印度尼西亚" value="6" lay-filter="monitorRouteCheck" @if(in_array(6,explode(",",$worker_monitor['worker_monitor_ip_type']))) checked="checked" @endif>
                                      <div class="layui-unselect layui-form-checkbox"><span>印度尼西亚</span><i class="layui-icon layui-icon-ok"></i></div>  
                                  	</div>
                            </div>
                            <div class="layui-inline">
                                    <div class="goodsCheckbox">
                                      <input type="checkbox" name="worker_monitor_ip_type[]" title="阿联酋" value="2" lay-filter="monitorRouteCheck" @if(in_array(2,explode(",",$worker_monitor['worker_monitor_ip_type']))) checked="checked" @endif>
                                      <div class="layui-unselect layui-form-checkbox"><span>阿联酋</span><i class="layui-icon layui-icon-ok"></i></div>  
                                  	</div>
                            </div>
                            <div class="layui-inline">
                                    <div class="goodsCheckbox">
                                      <input type="checkbox" name="worker_monitor_ip_type[]" title="沙特" value="12" lay-filter="monitorRouteCheck" @if(in_array(12,explode(",",$worker_monitor['worker_monitor_ip_type']))) checked="checked" @endif>
                                      <div class="layui-unselect layui-form-checkbox"><span>沙特</span><i class="layui-icon layui-icon-ok"></i></div>  
                                  	</div>
                            </div>
                            <div class="layui-inline">
                                    <div class="goodsCheckbox">
                                      <input type="checkbox" name="worker_monitor_ip_type[]" title="卡塔尔" value="14" lay-filter="monitorRouteCheck" @if(in_array(14,explode(",",$worker_monitor['worker_monitor_ip_type']))) checked="checked" @endif>
                                      <div class="layui-unselect layui-form-checkbox"><span>卡塔尔</span><i class="layui-icon layui-icon-ok"></i></div>  
                                  	</div>
                            </div>
                            <div class="layui-inline">
                                    <div class="goodsCheckbox">
                                      <input type="checkbox" name="worker_monitor_ip_type[]" title="美国" value="10" lay-filter="monitorRouteCheck" @if(in_array(10,explode(",",$worker_monitor['worker_monitor_ip_type']))) checked="checked" @endif>
                                      <div class="layui-unselect layui-form-checkbox"><span>美国</span><i class="layui-icon layui-icon-ok"></i></div>  
                                  	</div>
                            </div>
                            
              </div>
              <div class="layui-form-item">
                <div class="layui-input-block">
                  <button class="layui-btn" lay-submit lay-filter="setmonitor">确认修改</button>
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
  }).use(['index','form','laydate'],function(){
  	var form=layui.form;
  	var $=layui.jquery;
  		form.verify({
        laydate: function(value, item){ //value：表单的值、item：表单的DOM对象
          var time_arr =value.split(" ~ ");console.log(time_arr);
          if(time_arr[0]==time_arr[1]){
          	return '开始时间与结束时间不得一致';
          }
        }
      });   
  		var laydate=layui.laydate;
	  	laydate.render({
	      elem: '#test-laydate' //指定元素
	      ,type:'time'
	      ,range: '~' //或 range: '~' 来自定义分割字符
	      ,theme: 'molv'
	      ,calendar: true
	    });
  		form.on('submit(setmonitor)',function(data){
  			 var loading = layer.load();
         $.ajax({
              url:"{{url('admin/worker/monitor/set')}}",
              type:'post',
              data:data.field,
              datatype:'json',
              success:function(msg){console.log(msg);
                     if(msg.err==1){
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
                     }else if(msg.err==0){
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