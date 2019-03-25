@extends('storage.father.static')
@section('content')
<div class="layui-fluid">
  <div class="layui-card">
    <!-- 搜索控件 -->
  <div class="layui-form layui-card-header layuiadmin-card-header-auto">
          <div class="layui-form-item">
              <div class="layui-inline">
                  <div class="layui-form-item">
                      <div class="layui-inline">
                          <label class="layui-form-label">核审日期：</label>
                          <div class="layui-input-inline">
                              <input type="text" class="layui-input" id="test-laydate-start"
                                     placeholder="日期范围">
                          </div>
                          <!--  <label class="layui-form-label">出库时间：</label>
                          <div class="layui-input-inline">
                              <input type="text" class="layui-input" id="test-laydate-out"
                                     placeholder="日期范围">
                          </div> -->
                         <!--  <div class="layui-form-mid">
                              -
                          </div>
                          <div class="layui-input-inline">
                              <input type="text" class="layui-input" id="test-laydate-end"
                                     placeholder="结束日期">
                          </div> -->
                      </div>
                      <!-- <span style="color: red">时间不选择默认为近10天</span> -->
                  </div>
              </div>
              <div class="layui-inline">
                  <label class="layui-form-label">订单地区</label>
                  <div class="layui-input-block">
                      <select name="goods_blade_type" id="goods_blade_type" lay-verify="required">
                          <option value="#">所有</option>
                          <option value="1">台湾</option>
                          <option value="2">阿联酋</option>
                          <option value="3">马来西亚</option>
                          <option value="4">泰国</option>
                          <option value="5">日本</option>
                          <option value="6">印尼</option>
                          <option value="7">菲律宾</option>
                          <option value="8">英国</option>
                          <option value="9">美国</option>
                          <option value="11">越南</option>
                          <option value="12">沙特</option>
                          <option value="14">卡塔尔</option>
                          <option value="16">中东</option>
                      </select>
                  </div>
              </div>
              <div class="layui-inline">
                  <label class="layui-form-label">订单类型</label>
                  <div class="layui-input-block">
                      <select name="order_select_type" id="order_select_type" lay-verify="required">
                          <option value="#">所有</option>
                          <option value="1">待扣货</option>
                          <option value="3">待出仓</option>
                      </select>
                  </div>
              </div>
              <div class="layui-inline test-table-reload-btn">
                  <label>从当前数据中检索:</label>
                  <div class="layui-inline">
                      <input class="layui-input" name="id" id="test-table-demoReload" autocomplete="off">
                  </div>
                  <button class="layui-btn" data-type="reload">搜索</button>
                 <!--  <button class="layui-btn" id="outstorage">仓库信息导出</button> -->
              </div>
          </div>
  </div>
  <!-- 表格元素 -->
    <div class="layui-card-body">
      <table id="order_list" lay-filter='order-listen'></table>
    </div>

  </div>
</div>
  <script type="text/html" id="use_button">
      
        <button class="layui-btn layui-btn-primary layui-btn-sm" style="border-radius: 0;">
            <b style="color:green;"
               onclick="goods_show('新建供货单','{{url("admin/storage/add/add_goods")}}',2,600,510)">新建供货单</b>
        </button>
        <button class="layui-btn layui-btn-primary layui-btn-sm" style="border-radius: 0;">
            <b style="color:green;"
               onclick="goods_show('库存校准','{{url("admin/storage/list/check_order")}}',2,1000,510)">库存校准</b>
        </button>
        <button class="layui-btn layui-btn-danger layui-btn-sm" style="border-radius: 0;">
            <b style="color:yellow;"
               onclick="storage_cut()">货物扣除</b>
        </button>
  </script>
  <script type="text/html" id="area">
   <div>
    @{{# if(d.goods_blade_type==0||d.goods_blade_type==1){ }}
      <span style='color:#7D26CD'>台湾地区</span>
    @{{# }else if(d.goods_blade_type==2){ }}
      <span style='color:#ffccff'>阿联酋地区</span>
    @{{# }else if(d.goods_blade_type==3){ }}
      <span style='color:#ff66cc'>马来西亚地区</span>
    @{{# }else if(d.goods_blade_type==4){ }}
      <span style='color:#ff3366'>泰国地区</span>
    @{{# }else if(d.goods_blade_type==5){ }}
      <span style='color:#cccc99'>日本地区</span>
    @{{# }else if(d.goods_blade_type==6){ }}
      <span style='color:#555555'>印尼地区</span>
    @{{# }else if(d.goods_blade_type==7){ }}
      <span style='color:#2E8B57'>菲律宾地区</span>
    @{{# }else if(d.goods_blade_type==8){ }}
      <span style='color:#6633ff'>英国地区</span>
    @{{# }else if(d.goods_blade_type==9||d.goods_blade_type==10){ }}
      <span style='color:#33ffff'>美国地区</span>
    @{{# }else if(d.goods_blade_type==11){ }}
      <span style='color:#FF4040'>越南地区</span>
    @{{# }else if(d.goods_blade_type==12|d.goods_blade_type==13){ }}
      <span style='color:#EE00EE'>沙特地区</span>
    @{{# }else if(d.goods_blade_type==14||d.goods_blade_type==15){ }}
      <span style='color:#9C9C9C'>卡塔尔地区</span>
    @{{# }else if(d.goods_blade_type==16||d.goods_blade_type==17){ }}
      @{{# if(d.order_country=='Qatar'){ }}
      <span style='color:#8B7765'>中东混合(卡塔尔地区)</span>
      @{{# }else if(d.order_country=='United Arab Emirates'){ }}
      <span style='color:#8B7765'>中东混合(阿联酋地区)</span>
      @{{# }else if(d.order_country=='Saudi Arabia'){ }}
      <span style='color:#8B7765'>中东混合(沙特地区)</span>
      @{{# } }}
    @{{# } }}
  </div>
</script>
<script type="text/html" id='order_type'>
  <div>
  @{{# if(d.order_type=='待扣货'){ }}
    <span style='color:#009688'>待扣货</span>
  @{{# }else{ }}
    <span style='color:brown'>待出仓</span>
  @{{# } }}
  </div>
</script>
<script type="text/html" id="button" >
   @{{# if(d.order_type=='待出仓'||d.order_type=='已扣货'){ }}
       <button class="layui-btn layui-btn-primary layui-btn-sm" style="border-radius: 0;">
            <b style="color:green;"
               onclick="goods_show('扣货信息','{{url("admin/storage/check/check_out").'?id='}}'+@{{d.order_id}} ,2,800,610)">扣货信息</b>
        </button>
       @{{# } }}
  <a class="layui-btn layui-btn-xs" lay-event="detail">查看</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">驳回</a>
</script>
@endsection
@section('js')
<script>
    var that = this;
   layui.config({
    base: '{{asset("/admin/layuiadmin/")}}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index','admin', 'table','laydate'],function(){
    var table = layui.table;
    var laydate = layui.laydate;
    var $ =layui.jquery;
    var options={
      elem: '#order_list'
      ,url: '/admin/storage/list/order_data' //数据接口
      ,page: true //开启分页
      ,limits:[10,20,30,40,50,60,70,80,90,999999999]
      ,toolbar:'#use_button'
      ,defaultToolbar: ['filter','exports', 'print']
      ,text: {
        none: '暂无订单数据' 
      }
      ,autoSort:false
      ,initSort: {
        field: 'order_return_time' //排序字段，对应 cols 设定的各字段名
        ,type: 'desc' //排序方式  asc: 升序、desc: 降序、null: 默认排序
      }
      ,where: {
        search:$('#test-table-demoReload').val(),
        goods_blade_type:$('#goods_blade_type').val(),
        order_select_type:$('#order_select_type').val(),
        start:$('#test-laydate-start').val(),
      }
      ,cols: [[ //表头
        {field: 'order_id', title: 'ID', sort: true, fixed: 'left'}
        ,{field: 'order_single_id', title: '订单号'}
        ,{field: 'goods_blade_type', title: '订单地区'}
        ,{field: 'order_type', title: '订单类型',templet:'#order_type'}
        ,{field: 'order_return_time', title: '订单核审时间', sort: true} 
        ,{field: 'admin_show_name', title: '订单核审人'}
        ,{field: 'order_num', title: '件数', sort: true}
        ,{field: 'order_pay_type', title: '订单支付类型', templet: '#pay_type'}
        ,{field: 'button', title: '操作', toolbar:'#button'}
        /*,{field: 'score', title: '评分', width: 80, sort: true}
        ,{field: 'classify', title: '职业', width: 80}
        ,{field: 'wealth', title: '财富', width: 135, sort: true}*/
      ]]
     };
    //表格初始化
    table.render(options);
    //日期选择组件初始化
    laydate.render({
      elem: '#test-laydate-start' //指定元素
      ,type:'datetime'
      ,range: true //或 range: '~' 来自定义分割字符
      ,theme: 'molv'
      ,calendar: true
    });
    laydate.render({
      elem: '#test-laydate-out' //指定元素
      ,type:'datetime'
      ,range: true //或 range: '~' 来自定义分割字符
      ,theme: 'molv'
      ,calendar: true
    });
    //表格刷新回调
    table.render({ //其它参数在此省略
      done: function(res, curr, count){
        //如果是异步请求数据方式，res即为你接口返回的信息。
        //如果是直接赋值的方式，res即为：{data: [], count: 99} data为当前页数据、count为数据总长度
        console.log(res);
        
        //得到当前页码
        console.log(curr); 
        
        //得到数据总量
        console.log(count);
      }
    });
       //搜索刷新数据
       var $ = layui.$;

       //table事件监听
       table.on("tool(order-listen)",function(obj){
           var data = obj.data; //获得当前行数据
           var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
           var tr = obj.tr; //获得当前行 tr 的DOM对象
           if(layEvent=='detail'){
                layer.open({
                  type:2,
                  offset:'rt',
                  title:'订单信息',
                  area:[400,600],
                  content:"{{url('/admin/order/getaddr?id=')}}"+data.order_id,
                });

           }else if(layEvent=='del'){
               layer.confirm('真的驳回此订单么', function(index){
                  
                   layer.close(index);
                   //向服务端发送删除指令
                   $.ajax({
                       url:"{{url('admin/storage/list/back_order')}}",
                       type:'get',
                       data:{id:data.order_id},
                       datatype:'json',
                       success:function(msg){
                           if(msg['err']==1){ 
                               obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
                               layer.close(index);
                               layer.msg(msg.str,{
                                   time: 2000 //2秒关闭（如果不配置，默认是3秒）
                               }, function(){
                                   parent.layui.admin.events.refresh();
                               });
                           }else if(msg['err']==0){
                               layer.close(index);
                               layer.msg(msg.str);
                           }else{
                               layer.close(index);
                               layer.msg('驳回失败！');
                           }
                       }
                   });
               });
           }
       })
       //排序监听
       table.on('sort(order-listen)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                        //尽管我们的 table 自带排序功能，但并没有请求服务端。
                        //有些时候，你可能需要根据当前排序的字段，重新向服务端发送请求，从而实现服务端排序，如：
                        table.reload('order_list',{
                            initSort: obj //记录初始排序，如果不设的话，将无法标记表头的排序状态。
                            , where: { //请求参数（注意：这里面的参数可任意定义，并非下面固定的格式）
                                field: obj.field //排序字段
                                , order: obj.type //排序方式
                                 ,search:$('#test-table-demoReload').val(),
                                 goods_blade_type:$('#goods_blade_type').val(),
                                 order_select_type:$('#order_select_type').val(),
                                 start:$('#test-laydate-start').val(),
                            }
                        });
                    });

    //model 模态框
    goods_show=function goods_show(title,url,type,w,h){
      if( layui.device().android||layui.device().ios){
        layer.open({
        skin: 'layui-layer-nobg', //没有背景色
                        type: type,
                        title: title,
                        area: [375, 667],
                        fixed: false, //不固定
                        maxmin: true,
                        content: url
                  });
      }else{
         layer.open({
        skin: 'layui-layer-nobg', //没有背景色
                        type: type,
                        title: title,
                        area: [w, h],
                        fixed: false, //不固定
                        maxmin: true,
                        content: url
                  });
      }
    }
    storage_cut=function storage_cut (){
      add_num=$.ajax({url:"{{url('admin/storage/get_add_num')}}",async:false,success:function(msg){
         layer.confirm('当前有'+msg+'个补货单尚未完成入库操作，确定要完成扣货？', { btn: ['前往确认补货单','确定']},function(){
              parent.parent.layui.index.openTabsPage('/admin/storage/add', '补货处理');
         },function(){
              $.ajax({
                url:"{{url('admin/storage/storage_out')}}",
                             type:'post',
                             headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'},
                             datatype:'json',
                             success:function(msg){
                                 if(msg['err']==1){ 
                                     layer.close(index);
                                     layer.msg(msg.str,{
                                         time: 1500 //1.5秒关闭（如果不配置，默认是3秒）
                                     }, function(){
                                        location.reload();
                                         //parent.layui.admin.events.refresh();
                                     });
                                 }else if(msg['err']==0){
                                     layer.close(index);
                                     layer.msg(msg.str);
                                 }else{
                                     layer.close(index);
                                     layer.msg('扣除失败！');
                                 }
                             }
              })  
         })
      },error:function(){
        layer.msg('数据拉取失败，请稍后重试！');
      }});
    }

     var $ = layui.$, active = {
                reload: function(){
                    //执行重载
                    table.reload('order_list',{
                        page: {
                            curr: 1 //重新从第 1 页开始
                        }
                        ,where: {
                            search:$('#test-table-demoReload').val(),
                            goods_blade_type:$('#goods_blade_type').val(),
                            order_select_type:$('#order_select_type').val(),
                            start:$('#test-laydate-start').val(),
                                }
                            });
                        }
    };
    $('.test-table-reload-btn .layui-btn').on('click', function () {
                        var type = $(this).data('type');
                        active[type] ? active[type].call(this) : '';
                    });

   });
</script>
@endsection