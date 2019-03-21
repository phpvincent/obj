@extends('storage.father.static')
@section('content')
<div class="layui-fluid">
	
   <div class="layui-card">
   <div class="layui-card-header ">
   	<p class="message-text"></p>
		<ul >
			<li class="layui-text"><span style="color:red;width: 50%;">校对时间：</span>{{$storage_check->storage_check_time}}  <span style="color:red;width: 50%;">校准单编号：</span>{{$storage_check->storage_check_string}}</li>
			<li class="layui-text"><span style="color:red;width: 50%;">校对类型：</span>@if($storage_check->storage_check_type==0) 系统定时校对 @else 手动发起校对 @endif<span style="color:red;width: 50%;"> 校对发起者：</span>@if($storage_check->storage_check_type==0) 系统 @else \App\admin::where('admin_id',$storage_check->storage_check_admin)->first()['admin_real_name'] @endif</li>

		</ul>
	</div>
    <!-- 搜索控件 -->
  <div class="layui-form layui-card-header layuiadmin-card-header-auto">
          <div class="layui-form-item">
              <div class="layui-inline test-table-reload-btn">
                  <label>根据订单编号检索:</label>
                  <div class="layui-inline">
                      <input class="layui-input" name="id" id="test-table-demoReload" autocomplete="off">
                  </div>
                  <button class="layui-btn" data-type="reload">搜索</button>
                  <button class="layui-btn" id="reload_data">更新校准数据</button>
              </div>
          </div>
  </div>
   
  <!-- 表格元素 -->
    <div class="layui-card-body">
      <table id="order_list" lay-filter='order-listen'></table>
    </div>

  </div>
</div>
  <script type="text/html" id="check_data_button">
        <button class="layui-btn layui-btn-primary layui-btn-sm" style="border-radius: 0;">
            <b style="color:green;"
               onclick="check_data()">详细信息</b>
        </button>
        <button class="layui-btn layui-btn-primary layui-btn-sm" style="border-radius: 0;" >
        	<b style="color:green;"
               onclick="locationn.reload()">刷新数据</b>
        </button>
  </script>

<script type="text/html" id="button" >
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
  }).use(['index','admin', 'table'],function(){
    var table = layui.table;
    var $ =layui.jquery;
    var options={
      elem: '#order_list'
      ,url: '/admin/storage/list/order_data' //数据接口
      ,page: true //开启分页
      ,limits:[10,20,30,40,50,60,70,80,90,999999999]
      ,toolbar:'#check_data_button'
      ,defaultToolbar: ['filter','exports', 'print']
      ,text: {
        none: '暂无校准单数据' 
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
        {field: 'storage_check_data_order', title: '订单号', sort: true, fixed: 'left'}
        ,{field: 'storage_check_data_type', title: '订单状态'}
        ,{field: 'storage_check_data_num', title: '货物数目'}
        ,{field: 'goods_kind_name', title: '产品名'}
        ,{field: 'storage_check_data_sku', title: '产品sku(前四位)'} 
        ,{field: 'storage_name', title: '出货仓'}
        /*,{field: 'score', title: '评分', width: 80, sort: true}
        ,{field: 'classify', title: '职业', width: 80}
        ,{field: 'wealth', title: '财富', width: 135, sort: true}*/
      ]]
     };
    //表格初始化
    table.render(options);
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
    //model 模态框
    check_data=function check_data(){
     parent.parent.layui.index.openTabsPage('/admin/storage/check/list', '校准数据记录');
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
    $('#reload_data').on('click',function(){
    	msg=layer.confirm('是否要更新校准数据，生成新的校准单？', {icon: 3, title:'提示'},function(index){
    		var index = layer.load();
    		$.ajax({
    			url:"{{url('admin/storage/list/reload_storage_check')}}",
                       type:'post',
                       headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'},
                       datatype:'json',
                       success:function(msg){
                           if(msg['err']==1){ 
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
                               layer.msg('校准失败！');
                           }
                       }
    		})	
    	});
    })
   });
</script>
@endsection