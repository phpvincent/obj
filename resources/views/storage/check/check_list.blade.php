@extends('storage.father.static')
@section('content')
<div class="layui-fluid">
<div class="layui-card">
  <div class="layui-card-header layui-form layuiadmin-card-header-auto">
  <div class="layui-form-item">
      <div class="layui-inline">
          <label class="layui-form-label">日期时间：</label>
          <div class="layui-input-inline">
              <input type="text" class="layui-input" id="test-laydate-out"
                     placeholder="日期范围">
          </div>
      </div>
      <div class="layui-inline">
          <label class="layui-form-label">校验单类型</label>
          <div class="layui-input-block">
              <select name="storage_check_is_out" id="storage_check_is_out" lay-verify="required">
                  <option value="#">请选择</option>
                  <option value="0">仅校准</option>
                  <option value="1">校准并扣货</option>
              </select>
          </div>
      </div>
      <div class="layui-inline">
          <label class="layui-form-label">校对方式</label>
          <div class="layui-input-block">
              <select name="storage_check_type" id="storage_check_type" lay-verify="required">
                  <option value="#">请选择</option>
                  <option value="0">系统校对</option>
                  <option value="1">人工校对</option>
              </select>
          </div>
      </div>
      <div class="layui-inline">
      <button class="layui-btn" id="reload">搜索</button>
      </div>
  </div>
  
  </div>
  <div class="layui-card-body">
      <table id="table1" lay-filter='table1'></table>
  </div>
</div>
</div>

<div class="layui-container" id="tabDom" style="display: none;">  
  <div class="layui-row">
    <div class="layui-col-md12">
    <div class="layui-tab">
      <ul class="layui-tab-title">
      </ul>
      <div class="layui-tab-content">
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
        storage_check_is_out: $('#storage_check_is_out').val(),
        storage_check_type: $('#storage_check_type').val(),
        start: $('#test-laydate-out').val(),
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
    laydate.render({
      elem: '#test-laydate-out' //指定元素
      ,type:'datetime'
      ,range: true //或 range: '~' 来自定义分割字符
      ,theme: 'molv'
      ,calendar: true
    });
    $('#reload').on('click', function() {
      table.reload('table1', { where: {
        storage_check_is_out: $('#storage_check_is_out').val(),
        storage_check_type: $('#storage_check_type').val(),
        start: $('#test-laydate-out').val(),
      }})
    })
    // 表格1复选框监听
    var flag = true // true 表示没有一个弹层
    table.on('checkbox(table1)', function(obj){
      console.log(obj)
    var closeFunc = function () {
        $('#tabDom .layui-tab-title li').remove()
        $('#tabDom .layui-tab-content div').remove()
         layer.closeAll();
         flag = true
        table.reload('table1', { where: {
        storage_check_is_out: $('#storage_check_is_out').val(),
        storage_check_type: $('#storage_check_type').val(),
        start: $('#test-laydate-out').val(),
      }})
    }

    var songTable = function (storage_check_id) {
      var options={
      elem: '#'+storage_check_id
      ,url: '/admin/storage/list/check_list_data_info' //数据接口
      ,page: true //开启分页
      ,limits:[10,20,30,40,50,60,70,80,90,999999999]
      ,defaultToolbar: ['filter','exports', 'print']
      ,text: {
        none: '暂无订单数据' 
      }
      ,width: 1250
      ,autoSort:false
      ,initSort: {
        field: 'order_return_time' //排序字段，对应 cols 设定的各字段名
        ,type: 'desc' //排序方式  asc: 升序、desc: 降序、null: 默认排序
      }
      ,headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
      ,method:'post'
      ,where: {
        storage_check_id: storage_check_id
      }
      ,cols: [[ //表头
         {field: 'storage_check_data_order', title: '仓储校准数据表ID', minWidth: 150}
        ,{field: 'storage_abroad_id', title: '对应海外仓ID', minWidth: 130}
        ,{field: 'storage_primary_id', title: '对应校对单ID', minWidth: 130}
        ,{field: 'goods_kind_name', title: '校对发起者', minWidth: 130}
        ,{field: 'storage_check_data_num', title: '货物数量', minWidth: 100}
        ,{field: 'storage_check_data_sku', title: '产品SKU（前四位）', minWidth: 150}
        ,{field: 'storage_check_data_type', title: '仓储校准数据类型', minWidth: 150}
        ,{field: 'storage_name', title: '仓库名', minWidth: 90}
        ,{ title: '操作', width: 130, templet: function(){ return '<button class="layui-btn" lay-event="showsong">显示子table</button>'}}
      ]]
     };
       //zi表格初始化
       table.render(options);
       table.on('tool('+storage_check_id+')', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
         var data = obj.data; //获得当前行数据
         if(obj.event === 'showsong'){ 
            console.log(data)
            layer.open({
            type: 1 //此处以iframe举例
            ,title: '显示子表'
            ,area: ['800px', '300px']
            ,maxmin: true
            ,content: '<table id="'+data.storage_check_data_order+'" lay-filter="'+data.storage_check_data_order+'"></table>'
            ,zIndex: layer.zIndex //重点1
          })
          var options={
              elem: '#'+data.storage_check_data_order
              ,url: '/admin/storage/list/check_list_data_info' //数据接口
              ,page: true //开启分页
              ,limits:[10,20,30,40,50,60]
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
                storage_check_id: storage_check_id,
                order_id: data.storage_check_data_order,
              }
              ,cols: [[ //表头
                 {field: 'storage_check_data_order', title: '仓储校准数据表ID', minWidth: 150}
                ,{field: 'storage_abroad_id', title: '对应海外仓ID', minWidth: 130}
                ,{field: 'storage_primary_id', title: '对应校对单ID', minWidth: 130}
                ,{field: 'goods_kind_name', title: '校对发起者', minWidth: 100}
                ,{field: 'storage_check_data_num', title: '货物数量', minWidth: 90}
                ,{field: 'storage_check_data_sku', title: '产品SKU（前四位）', minWidth: 170}
                ,{field: 'storage_check_data_type', title: '仓储校准数据类型', minWidth: 150}
                ,{field: 'storage_name', title: '仓库名', minWidth: 90}
              ]]
          };
       //zi表格初始化
       table.render(options);

         }

       })
    }
      
    if (flag) {
      layer.open({
        type: 1 //此处以iframe举例
        ,title: '多表对比'
        ,area: ['600px', '100%']
        ,shade: 0
        ,maxmin: true
        ,offset: 'rt'
        ,content: $('#tabDom')
        ,btn: ['全部关闭'] //只是为了演示
        ,end: function (){
          closeFunc()
        }
        ,btn2: function(){
          closeFunc()
        }
        ,zIndex: layer.zIndex //重点1
        ,success: function(layero){
          layer.setTop(layero); //重点2
        }
      })
      flag = false
    }
    if(obj.checked){
      if($('#tabDom .layui-tab-title li').length === 0){
        $('#tabDom .layui-tab-title').append('<li class="layui-this" dataid="'+obj.data.storage_check_id+'">'+obj.data.storage_check_id+'</li>')
        $('#tabDom .layui-tab-content').append('<div class="layui-tab-item layui-show" dataid="'+obj.data.storage_check_id+'"><table id="'+obj.data.storage_check_id+'" lay-filter="'+obj.data.storage_check_id+'"></table></div>')
        songTable(obj.data.storage_check_id)
      } else {
        $('#tabDom .layui-tab-title').append('<li dataid="'+obj.data.storage_check_id+'">'+obj.data.storage_check_id+'</li>')
        $('#tabDom .layui-tab-content').append('<div class="layui-tab-item" dataid="'+obj.data.storage_check_id+'"><table id="'+obj.data.storage_check_id+'" lay-filter="'+obj.data.storage_check_id+'"></table></div>')
        songTable(obj.data.storage_check_id)
      }
    } else {
        $('#tabDom .layui-tab-title li[dataid="'+obj.data.storage_check_id+'"]').remove()
        $('#tabDom .layui-tab-content div[dataid="'+obj.data.storage_check_id+'"]').remove()
      }

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