@extends('storage.father.static')
@section('content')
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md8">
        <div class="layui-row layui-col-space15">
          <div class="layui-col-md6">
            <div class="layui-card">
              <div class="layui-card-header">快捷方式</div>
              <div class="layui-card-body">
                
                <div class="layui-carousel layadmin-carousel layadmin-shortcut">
                  <div carousel-item>
                    <ul class="layui-row layui-col-space10">
                      <li class="layui-col-xs3">
                        <a href="#" onclick="parent.location.href='{{url('admin/index')}}'">
                          <i class="layui-icon layui-icon-home"></i>
                          <cite>信息管理系统</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="{{url('admin/kind/index')}}">
                          <i class="layui-icon layui-icon-tabs"></i>
                          <cite>产品列表</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="{{url('admin/storage/list')}}">
                          <i class="layui-icon layui-icon-align-left"></i>
                          <cite>仓库列表</cite>
                        </a>
                      </li>
                      
                      <li class="layui-col-xs3">
                        <a lay-href="{{url('admin/storage/password')}}">
                          <i class="layui-icon layui-icon-password"></i>
                          <cite>密码修改</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="{{url('admin/storage/list/product_data')}}">
                          <i class="layui-icon ">&#xe62a;</i>
                          <cite>库存数据</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="{{url('admin/storage/add')}}">
                          <i class="layui-icon layui-icon-prev"></i>
                          <cite>补货记录</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="{{url('admin/storage/check/list')}}">
                          <i class="layui-icon layui-icon-next"></i>
                          <cite>出库记录</cite>
                        </a>
                      </li> 
                      <li class="layui-col-xs3">
                        <a lay-href="{{url('admin/storage/log/index')}}">
                          <i class="layui-icon "></i>
                          <cite>操作日志</cite>
                        </a>
                      </li>
                      
                    </ul>
                    <ul class="layui-row layui-col-space10">
                     <li class="layui-col-xs3">
                        <a lay-href="{{url('admin/storage/log/index')}}">
                          <i class="layui-icon ">&#xe631;</i>
                          <cite>仓库扣减</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="{{url('admin/storage/admin_info')}}">
                          <i class="layui-icon layui-icon-user"></i>
                          <cite>个人信息</cite>
                        </a>
                      </li>
                      
                      <li class="layui-col-xs3">
                        <a lay-href="{{url('admin/storage/jsq')}}">
                          <i class="layui-icon t">&#xe600;</i>
                          <cite>计算器</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="{{url('admin/storage/send_phone')}}">
                          <i class="layui-icon ">&#xe63b;</i>
                          <cite>短信推送</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="{{url('admin/storage/send_mail')}}">
                          <i class="layui-icon ">&#xe609;</i>
                          <cite>邮件推送</cite>
                        </a>
                      </li>
                    </ul>
                    
                  </div>
                </div>
                
              </div>
            </div>
          </div>
          <div class="layui-col-md6">
            <div class="layui-card">
              <div class="layui-card-header">待办事项</div>
              <div class="layui-card-body">

                <div class="layui-carousel layadmin-carousel layadmin-backlog">
                  <div carousel-item>
                    <ul class="layui-row layui-col-space10">
                      <li class="layui-col-xs6">
                        <a lay-href="{{url('admin/kind/index')}}" class="layadmin-backlog-body">
                          <h3>产品数</h3>
                          <p><cite>{{\App\goods_kind::count()}}</cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a lay-href="{{url('admin/storage/list')}}" class="layadmin-backlog-body">
                          <h3>未处理补货单</h3>
                          <p><cite style="color: #FF5722;">{{\App\storage_append::where('storage_append_status','0')->count()}}</cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a  lay-href="{{url('admin/storage/check/list')}}" class="layadmin-backlog-body">
                          <h3>今日校准单</h3>
                          <p><cite>{{\App\storage_check::where([['storage_check_time','>',date("Y-m-d").' 00:00:00'],['storage_check_is_out','0']])->count()}}</cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a  lay-href="{{url('admin/storage/check/list')}}" class="layadmin-backlog-body">
                          <h3>今日出货单</h3>
                          <p><cite style="color: #FF5722;">{{\App\storage_check::where([['storage_check_time','>',date("Y-m-d").' 00:00:00'],['storage_check_is_out','1']])->count()}}</cite></p>
                        </a>
                      </li>
                     
                    </ul>
                    <ul class="layui-row layui-col-space10">
                       <li class="layui-col-xs6">
                        <a href="javascript:;" onclick="layer.tips('请通知订单管理员核审订单', this, {tips: 3});" class="layadmin-backlog-body">
                          <h3>待审单</h3>
                          <p><cite>{{\App\order::where([['order_type',0],['is_del',0]])->count()}}</cite></p>
                        </a>
                      </li> 
                      <li class="layui-col-xs6">
                        <a lay-href="{{url('admin/storage/check')}}"  class="layadmin-backlog-body">
                          <h3>待扣货</h3>
                          <p><cite>{{\App\order::where([['order_type',1],['is_del',0]])->count()}}</cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a lay-href="{{url('admin/storage/check')}}"  class="layadmin-backlog-body">
                          <h3>待出仓</h3>
                          <p><cite>{{\App\order::where([['order_type',3],['is_del',0]])->count()}}</cite></p>
                        </a>
                      </li>
                       <li class="layui-col-xs6">
                        <a lay-href="{{url('admin/storage/list')}}" class="layadmin-backlog-body">
                          <h3>仓库数</h3>
                          <p><cite>{{\App\storage::where('storage_status',1)->count()}}</cite></p>
                        </a>
                      </li>
                      
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="layui-col-md12">
            <div class="layui-card">
              <div class="layui-card-header">数据概览</div>
              <div class="layui-card-body">
                
                <div class="layui-carousel layadmin-carousel layadmin-dataview" data-anim="fade" lay-filter="LAY-index-dataview">
                  <div carousel-item id="LAY-index-dataview">
                    <div><i class="layui-icon layui-icon-loading1 layadmin-loading"></i></div>
                    <div></div>
                    <div></div>
                  </div>
                </div>
                
              </div>
            </div>
            <div class="layui-card">
              <div class="layui-tab layui-tab-brief layadmin-latestData">
                <ul class="layui-tab-title">
                  <li class="layui-this">海外仓扣货榜</li>
                  <!-- <li>今日热帖</li> -->
                </ul>
                <div class="layui-tab-content">
                  <div class="layui-tab-item layui-show">
                    <table id="LAY-index-dataout"></table>
                  </div>
                  <!-- <div class="layui-tab-item">
                    <table id="LAY-index-topCard"></table>
                  </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="layui-col-md4">
        <div class="layui-card">
          <div class="layui-card-header">版本信息</div>
          <div class="layui-card-body layui-text">
            <table class="layui-table">
              <colgroup>
                <col width="100">
                <col>
              </colgroup>
              <tbody>
                <tr>
                  <td>登陆次数</td>
                  <td>
                    <script type="text/html" template>
                     {{\Auth::user()->admin_num}}
                    </script>
                  </td>
                </tr>
                <tr>
                  <td>上次登陆时间</td>
                  <td>
                    <script type="text/html" template>
                     {{\Auth::user()->admin_time}}
                    </script>
                 </td>
                </tr>
                <tr>
                  <td>账户角色</td>
                  <td>@if(Auth::user()->is_root==1)
                    <li>超级管理员</li>
                    @else
                    {{App\role::where('role_id',Auth::user()->admin_role_id)->first()->role_name}}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>辅助工具</td>
                  <td style="padding-bottom: 0;">
                    <div class="layui-btn-container">
                      <a lay-href="{{url('admin/message/send_phone')}}" target="_blank" class="layui-btn layui-btn-danger">发送短信</a>
                      <a lay-href="{{url('admin/message/send_mail')}}" target="_blank" class="layui-btn">发送邮件</a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        
        <div class="layui-card">
          <div class="layui-card-header">效果报告</div>
          <div class="layui-card-body layadmin-takerates">
            <div class="layui-progress" lay-showPercent="yes">
              @if($t_out_today/$order_count > $y_out_today/$yse_order_count)
              <h3>今日订单扣货率（日同比 {{($t_out_today/$order_count-$y_out_today/$yse_order_count)*100}}% <span class="layui-edge layui-edge-top" lay-tips="增长" lay-offset="-15"></span>）</h3>
              <div class="layui-progress-bar" lay-percent="{{$t_out_today/$order_count*100}}%"></div>
              @else
               <h3>今日订单扣货率（日同比 {{($y_out_today/$yse_order_count-$t_out_today/$order_count)*100}}% <span class="layui-edge layui-edge-bottom" lay-tips="下降" lay-offset="-15"></span>）</h3>
              <div class="layui-progress-bar" lay-percent="{{$t_out_today/$order_count*100}}%"></div>
              @endif
            </div>
            <div class="layui-progress" lay-showPercent="yes">
              @if($t_splite_count/$order_count > $y_splite_count/$yse_order_count)
              <h3>今日订单出仓率（日同比 {{($t_splite_count/$order_count-$y_splite_count/$yse_order_count)*100}}% <span class="layui-edge layui-edge-top" lay-tips="增长" lay-offset="-15"></span>）</h3>
              <div class="layui-progress-bar" lay-percent="{{$t_splite_count/$order_count*100}}%"></div>
              @else
               <h3>今日订单出仓率（日同比 {{($y_splite_count/$yse_order_count-$t_splite_count/$order_count)*100}}% <span class="layui-edge layui-edge-bottom" lay-tips="下降" lay-offset="-15"></span>）</h3>
              <div class="layui-progress-bar" lay-percent="{{$t_splite_count/$order_count*100}}%"></div>
              @endif
            </div>
          </div>
        </div>
        
        <div class="layui-card">
          <div class="layui-card-header">实时监控</div>
          <div class="layui-card-body layadmin-takerates">
            <div class="layui-progress" lay-showPercent="yes">
              <h3>CPU使用率</h3>
              <div class="layui-progress-bar" lay-percent="58%"></div>
            </div>
            <div class="layui-progress" lay-showPercent="yes">
              <h3>内存占用率</h3>
              <div class="layui-progress-bar layui-bg-red" lay-percent="90%"></div>
            </div>
          </div>
        </div>
        
        <div class="layui-card">
          <div class="layui-card-header">产品动态</div>
          <div class="layui-card-body">
            <div class="layui-carousel layadmin-carousel layadmin-news" data-autoplay="true" data-anim="fade" lay-filter="news">
              <div carousel-item>
                <div><a href="http://fly.layui.com/docs/2/" target="_blank" class="layui-bg-red">layuiAdmin 快速上手文档</a></div>
                <div><a href="http://fly.layui.com/vipclub/list/layuiadmin/" target="_blank" class="layui-bg-green">layuiAdmin 会员讨论专区</a></div> 
                <div><a href="http://www.layui.com/admin/#get" target="_blank" class="layui-bg-blue">获得 layui 官方后台模板系统</a></div>
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
    base: '/admin/layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'console','table'],function(){
    var table=layui.table;
    '#LAY-index-dataout';
     var options={
      elem: '#LAY-index-dataout'
      ,url: '/admin/storage/list/home_table' //数据接口
      ,page: true //开启分页
      ,limits:[10,20,30,40,50,60,70,80,90,999999999]
      ,defaultToolbar: ['filter','exports', 'print']
      ,text: {
        none: '暂无数据' 
      }
      ,method:'post'
      ,headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'}
      ,autoSort:true
      ,initSort: {
        field: 'sum' //排序字段，对应 cols 设定的各字段名
        ,type: 'desc' //排序方式  asc: 升序、desc: 降序、null: 默认排序
      }
      ,cols: [[ //表头
        ,{field: 'storage_id', title: 'ID', fixed: 'left',sort: true}
        ,{field: 'storage_name', title: '仓库名'}
        ,{field: 'sum', title: '今日扣货数',sort: true} 
      ]]
     };
    //表格初始化
    table.render(options);
  });
  </script>
@endsection
