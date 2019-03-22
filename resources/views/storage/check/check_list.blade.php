@extends('storage.father.static')
@section('content')
<div class="layui-fluid">
<div class="layui-card">
  <div class="layui-card-header">卡片面板</div>
  <div class="layui-card-body">
      <table id="table1" lay-filter='table1'></table>
  </div>
</div>
</div>

<div class="layui-container" id="tabDom">  
  <div class="layui-row">
    <div class="layui-col-md12">
    <div class="layui-tab">
      <ul class="layui-tab-title">
        <li class="layui-this">网站设置</li>
        <li>用户管理</li>
        <li>权限分配</li>
        <li>商品管理</li>
        <li>订单管理</li>
      </ul>
      <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">内容1</div>
        <div class="layui-tab-item">内容2</div>
        <div class="layui-tab-item">内容3</div>
        <div class="layui-tab-item">内容4</div>
        <div class="layui-tab-item">内容5</div>
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
  }).use(['index','admin', 'table','laydate', 'laytpl'],function(){
    var table = layui.table;
    var laydate = layui.laydate;
    var $ =layui.jquery;
    var layer = layui.layer;
    var laytpl = layui.laytpl;
    
    var options={
      elem: '#table1'
      ,url: '/admin/storage/list/check_list_data' //数据接口
      ,page: true //开启分页
      ,limits:[10,20,30,40,50,60,70,80,90,999999999]
      ,defaultToolbar: ['filter','exports', 'print']
      ,text: {
        none: '暂无订单数据' 
      }
      ,autoSort:false
      ,initSort: {
        field: 'order_return_time' //排序字段，对应 cols 设定的各字段名
        ,type: 'desc' //排序方式  asc: 升序、desc: 降序、null: 默认排序
      }
      ,headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
      ,method:'post'
      ,where: {
        // search:'',
        // goods_blade_type:'#',
        // order_select_type:'#',
        // start:'',
      }
      ,cols: [[ //表头
         {type:'checkbox', fixed: 'left'}
        ,{field: 'storage_check_id', title: 'ID', sort: true}
        ,{field: 'admin_show_name', title: '校对发起者'}
        ,{field: 'storage_check_string', title: '校对单号'}
        ,{field: 'storage_check_time', title: '校对时间'}
        ,{field: 'storage_check_type', title: '校对发起方式'}
        ,{field: 'storage_check_is_out', title: '校对类型'}
      ]]
     };
    //表格初始化
    table.render(options);
    // 表格1复选框监听
    var flag = true // true 表示没有一个弹层
    table.on('checkbox(table1)', function(obj){
      console.log(obj)
       
    //   if (flag) {
        layer.open({
        type: 1 //此处以iframe举例
        ,title: '多表对比'
        ,area: ['600px', '100%']
        ,shade: 0
        ,maxmin: true
        ,offset: 'rt'
        ,content: $('#tabDom')
        ,btn: ['继续弹出', '全部关闭'] //只是为了演示
        ,yes: function(){
          $(that).click(); 
        }
        ,btn2: function(){
          layer.closeAll();
        }
        ,zIndex: layer.zIndex //重点1
        ,success: function(layero){
          layer.setTop(layero); //重点2
        }
      });
    //   flag = false
    //   $('#tabDom .layui-tab-title').append('<li class="layui-this">网站设置</li>')
    //   $('#tabDom .layui-tab-content').append('<div class="layui-tab-item layui-show">内容1</div>')
    // } else {
    //   $('#tabDom .layui-tab-title').append('<li>网站设置</li>')
    //   $('#tabDom .layui-tab-content').append('<div class="layui-tab-item">内容1</div>')
    //   }

    // laytpl(tabDoms.innerHTML).render({name: '贤心'}, function(html){
    //     $('#tabDom .content').html(html)
    // });

    });
    
    })

</script>
@endsection