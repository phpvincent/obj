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
<script id="suntable" type="text/html">
<fieldset class="layui-elem-field">
	    <legend>
      @{{#  if(d[0].storage_check_data_type === '4'){ }}
         缺货
     @{{#  }else if(d[0].storage_check_data_type === '1'){ }} 
         从海外仓拆分发货
      @{{#  }else if(d[0].storage_check_data_type === '2'){ }} 
         从海外仓不拆分发货
      @{{#  }else if(d[0].storage_check_data_type === '3'){ }} 
      从本地仓发货
      @{{#  } }}
      </legend>
	<div class="layui-field-box">
  <blockquote class="layui-elem-quote">总数目：@{{d[0].storage_check_data_num}}</blockquote>
  <blockquote class="layui-elem-quote">产品sku：@{{d[0].storage_check_data_sku}}</blockquote>
  <blockquote class="layui-elem-quote">订单编号：@{{d[0].storage_check_data_order}}</blockquote>
  <blockquote class="layui-elem-quote">校准单编号：@{{d[0].storage_check_string}}</blockquote>
  <blockquote class="layui-elem-quote" style="color:brown">仓库名：@{{d[0].storage_name}}</blockquote>
  </div>
  <div>扣货信息</div>
  <table class="layui-table">
  <thead>
    <tr>
      <th>订单id</th>
      <th>订单编号</th>
      <th>数量</th>
      <th>属性sku</th>
    </tr> 
  </thead>
  <tbody>
     @{{#  layui.each(d, function(index, item){ }}
     <tr>
      <td>@{{item.storage_check_info_order}}</td>
      <td>@{{item.storage_check_info_single}}</td>
      <td>@{{item.storage_check_info_num}}</td>
      <td>@{{item.storage_check_info_sku}}</td>
    </tr>
     @{{#  }); }}
  </tbody>
</table>
  </fieldset>
</script>
<script id="songSibTableDom" type="text/html">
    <table id="sib@{{d.storage_check_id}}" lay-filter="sib@{{d.storage_check_id}}"></table>
</script>
<script type="text/html" id="use_button">
  
</script>
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
      ,toolbar:'#use_button'
      ,defaultToolbar: ['filter','exports', 'print']
      ,text: {
        none: '暂无订单数据' 
      }
      ,autoSort:false
      ,initSort: {
        field: 'storage_check_time' //排序字段，对应 cols 设定的各字段名
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
        ,{field: 'storage_check_time', title: '校对时间',  sort: true}
        ,{field: 'storage_check_type', title: '校对发起方式'}
        ,{field: 'storage_check_is_out', title: '校对类型'}
        ,{field: '', title: '操作', templet: function(d){
           if(d.storage_check_is_out === '<span style="color:red;">仓储扣货</span>') {
             return '<button class="layui-btn layui-btn-xs" lay-event="out">出货单导出</button>'
           }else {return '--'}
        }}
      ]]
     };
    //表格初始化
    table.render(options);
    //排序监听
    table.on('sort(table1)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                        //尽管我们的 table 自带排序功能，但并没有请求服务端。
                        //有些时候，你可能需要根据当前排序的字段，重新向服务端发送请求，从而实现服务端排序，如：
                        table.reload('table1',{
                            initSort: obj //记录初始排序，如果不设的话，将无法标记表头的排序状态。
                            , where: { //请求参数（注意：这里面的参数可任意定义，并非下面固定的格式）
                                field: obj.field //排序字段
                                , order: obj.type //排序方式
                                 ,storage_check_is_out: $('#storage_check_is_out').val(),
                                  storage_check_type: $('#storage_check_type').val(),
                                  start: $('#test-laydate-out').val(),
                            }
                        });
                    });
    table.on('tool(table1)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
         var data = obj.data; //获得当前行数据
         if(obj.event === 'out'){
         location.href="/admin/storage/list/data_out?storage_check_id="+data.storage_check_id
         }
         })

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
        ,{ title: '操作', width: 130, templet: function(){ return '<button class="layui-btn" lay-event="showsong">订单扣货详情</button>'}}
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
            ,title: '订单扣货详情'
            ,area: ['800px', '600px']
            ,maxmin: true
            ,content: '<div id="'+data.storage_check_data_order+'"></div>'
            ,zIndex: layer.zIndex //重点1
          })
          $.ajax({
                url:'/admin/storage/list/check_order_info',
                type:'get',
                data:{
                  storage_check_id: storage_check_id,
                  order_id: data.storage_check_data_order
                },
                // datatype:'json',
                headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                success:function(msg){
                   console.log(msg)
                   var getTpl = suntable.innerHTML;
                  
                   laytpl(getTpl).render(msg, function(html){
                     $('#'+data.storage_check_data_order).html(html)
                   });
                }
          })
         }

       })
    }

    var songSibTable = function (storage_check_id) {
        var getTpl = songSibTableDom.innerHTML;               
            laytpl(getTpl).render({storage_check_id: storage_check_id}, function(html){
              $('div[dataid="'+storage_check_id+'"]').append(html)
            });
             var options={
             elem: '#sib'+storage_check_id
             ,url: '/admin/storage/list/data_less' //数据接口
             ,page: true //开启分页
             ,limits:[10,20,30,40,50,60,70,80,90,999999999]
             ,toolbar:'#use_button'
             ,defaultToolbar: ['filter','exports', 'print']
             ,text: {
               none: '暂无缺货数据' 
             }
             ,width: 1250
             ,autoSort:false
             ,initSort: {
               field: 'order_return_time' //排序字段，对应 cols 设定的各字段名
               ,type: 'desc' //排序方式  asc: 升序、desc: 降序、null: 默认排序
             }
             ,headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
             ,method:'get'
             ,where: {
              storage_check_id: storage_check_id
              ,search: ''
             }
             ,cols: [[ //表头
                {field: 'goods_kind_name', title: '产品名', minWidth: 150}
               ,{field: 'storage_check_lack_num', title: '缺货数量', minWidth: 130}
               ,{field: 'storage_check_lack_six_sku', title: '属性sku', minWidth: 130}
               ,{field: 'storage_check_lack_sku', title: '产品sku', minWidth: 130}
             ]]
            };
            //zi表格初始化
            table.render(options);
    }
      
    if (flag) {
      layer.open({
        type: 1 //此处以iframe举例
        ,title: '多记录对比'
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
        songSibTable(obj.data.storage_check_id)
      } else {
        $('#tabDom .layui-tab-title').append('<li dataid="'+obj.data.storage_check_id+'">'+obj.data.storage_check_id+'</li>')
        $('#tabDom .layui-tab-content').append('<div class="layui-tab-item" dataid="'+obj.data.storage_check_id+'"><table id="'+obj.data.storage_check_id+'" lay-filter="'+obj.data.storage_check_id+'"></table></div>')
        songTable(obj.data.storage_check_id)
        songSibTable(obj.data.storage_check_id)
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