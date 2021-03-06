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
                           <label class="layui-form-label">补货时间：</label>
                          <div class="layui-input-inline">
                              <input type="text" class="layui-input" id="test-laydate-out"
                                     placeholder="日期范围">
                          </div>
                      </div>
                  </div>
              </div>
              <div class="layui-inline">
                  <label class="layui-form-label">补货单状态</label>
                  <div class="layui-input-block">
                      <select name="storage_status" id="storage_status" lay-verify="required">
                          <option value="#">请选择</option>
                          <option value="0">未补充到仓库</option>
                          <option value="1">补充到仓库</option>
                          <option value="2">补货取消</option>
                      </select>
                  </div>
              </div>
              <div class="layui-inline test-table-reload-btn">
                  <label>从当前数据中检索:</label>
                  <div class="layui-inline">
                      <input class="layui-input" name="id" id="test-table-demoReload" autocomplete="off">
                  </div>
                  <button class="layui-btn" data-type="reload">搜索</button>
              </div>
          </div>
  </div>
  <!-- 表格元素 -->
    <div class="layui-card-body">
      <table id="storagelist" lay-filter='button-listen'></table>
    </div>

  </div>
</div>
  <script type="text/html" id="use_button">
        <button class="layui-btn layui-btn-primary layui-btn-sm" style="border-radius: 0;">
            <b style="color:green;"
               onclick="goods_show('新建补货单','{{url("admin/storage/add/add_goods")}}',2,600,510)">新建补货单</b>
        </button>
  </script>
<script type="text/html" id="button" >
    <a class="layui-btn layui-btn-xs" lay-event="detail">查看</a>
    @{{# if(d.storage_append_status==='未入仓库'){ }}
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-xs" lay-event="warehouse">补货入库</a>
        <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="cancel">取消补货</a>
    @{{#  } }}
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
      elem: '#storagelist'
      ,url: '/admin/storage/add'//数据接口
      ,page: true //开启分页
      ,toolbar:'#use_button'
      ,defaultToolbar: []
      ,method:'post'
      ,headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
      ,text: {
        none: '暂无补货单数据'
      }
      ,autoSort:false
      ,initSort: {
        field: 'check_at' //排序字段，对应 cols 设定的各字段名
        ,type: 'desc' //排序方式  asc: 升序、desc: 降序、null: 默认排序
      }
      ,where: {
        search:$('#test-table-demoReload').val(),
        time:$('#test-laydate-out').val(),
        storage_status:$('#storage_status').val()
      }
      ,cols: [[ //表头
        {field: 'storage_append_id', title: 'ID',width:80, sort: true, fixed: 'left'}
        ,{field: 'storage_append_single', title: '补货单号'}
        ,{field: 'storage_append_admin',width:80, title: '补货人'}
        ,{field: 'storage_append_status',width:100, title: '状态'}
        ,{field: 'storage_append_time',width:160, title: '补货时间'}
        ,{field: 'storage_append_end_time',width:160, title: '进仓时间'}
        ,{field: 'storage_append_msg', title: '补货单备注'}
        ,{ title: '操作',templet:'#button'}
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
       table.on("tool(button-listen)",function(obj){
           var data = obj.data; //获得当前行数据
           var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
           var tr = obj.tr; //获得当前行 tr 的DOM对象
           if(layEvent=='detail'){
                layer.open({
                  type:2,
                  offset:'rt',
                  title:'补货单数据',
                  area:[1200,800],
                  content:"{{url('/admin/storage/add/show_goods_kind?storage_append_id=')}}"+data.storage_append_id,
                });

           }else if(layEvent=='edit'){
               //修改产品
               that.goods_show('修改补货单数据', '{{url("admin/storage/add/up_storage_append")}}?storage_append_id=' +data.storage_append_id, 2, 600, 510);
           }else if(layEvent=='cancel'){
               that.goods_show('取消补货单', '{{url("admin/storage/add/cancel_storage_append")}}?storage_append_id=' +data.storage_append_id, 2, 600, 510);
           }else{
               layer.confirm('确认补货单商品已到达仓库？', function(index){
                   layer.close(index);
                   //向服务端发送删除指令
                   $.ajax({
                       url:"{{url('admin/storage/add/append_goods_over')}}",
                       type:'post',
                       data:{storage_append_id:data.storage_append_id},
                       headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                       datatype:'json',
                       success:function(msg){
                           if(msg['err']==1){
                               layer.close(index);
                               layer.msg(msg.msg,{
                                   time: 2000 //2秒关闭（如果不配置，默认是3秒）
                               }, function(){
                                   parent.layui.admin.events.refresh();
                               });
                           }else if(msg['err']==0){
                               layer.close(index);
                               layer.msg(msg.msg);
                           }else{
                               layer.close(index);
                               layer.msg('入库失败！');
                           }
                       }
                   });
               });
           }
       });
       //排序监听
       table.on('sort(button-listen)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                        //尽管我们的 table 自带排序功能，但并没有请求服务端。
                        //有些时候，你可能需要根据当前排序的字段，重新向服务端发送请求，从而实现服务端排序，如：
                        table.reload('storagelist',{
                            initSort: obj //记录初始排序，如果不设的话，将无法标记表头的排序状态。
                            , where: { //请求参数（注意：这里面的参数可任意定义，并非下面固定的格式）
                                field: obj.field //排序字段
                                , order: obj.type //排序方式
                                 ,search:$('#test-table-demoReload').val(),
                                 time:$('#test-laydate-out').val(),
                                storage_status:$('#storage_status').val()
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
                content: url,
                end: function (){
                    //执行重载
                    table.reload('storagelist',{
                        page: {
                            curr: 1 //重新从第 1 页开始
                        }
                        ,where: {
                            search:$('#test-table-demoReload').val(),
                            time:$('#test-laydate-out').val(),
                            storage_status:$('#storage_status').val()
                        }
                    });
                }
            });
      }else{
         layer.open({
            skin: 'layui-layer-nobg', //没有背景色
            type: type,
            title: title,
            area: [w, h],
            fixed: false, //不固定
            maxmin: true,
            content: url,
            end: function (){
                 //执行重载
                 table.reload('storagelist',{
                     page: {
                         curr: 1 //重新从第 1 页开始
                     }
                     ,where: {
                         search:$('#test-table-demoReload').val(),
                         time:$('#test-laydate-out').val(),
                         storage_status:$('#storage_status').val(),
                     }
                 });
            }
         });
      }
    };

     var $ = layui.$, active = {
        reload: function(){
            //执行重载
            table.reload('storagelist',{
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                ,where: {
                    search:$('#test-table-demoReload').val(),
                    time:$('#test-laydate-out').val(),
                    storage_status:$('#storage_status').val(),
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