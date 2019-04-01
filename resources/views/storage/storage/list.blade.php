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
                          <label class="layui-form-label">建仓日期：</label>
                          <div class="layui-input-inline">
                              <input type="text" class="layui-input" id="test-laydate-start"
                                     placeholder="日期范围">
                          </div>
                           <label class="layui-form-label">出库时间：</label>
                          <div class="layui-input-inline">
                              <input type="text" class="layui-input" id="test-laydate-out"
                                     placeholder="日期范围">
                          </div>
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
                  <label class="layui-form-label">仓库分类</label>
                  <div class="layui-input-block">
                      <select name="storage_type" id="storage_type" lay-verify="required">
                          <option value="#">所有</option>
                          <option value="1">国内仓</option>
                          <option value="0">海外仓</option>
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
      <table id="storagelist" lay-filter='button-listen'></table>
    </div>

  </div>
</div>
  <script type="text/html" id="use_button">
        <button class="layui-btn layui-btn-primary layui-btn-sm" style="border-radius: 0;">
            <b style="color:green;"
               onclick="goods_show('新建仓库','{{url("admin/storage/list/add_storage")}}',2,600,510)">新建仓库</b>
        </button>
  </script>
  <script type="text/html" id="area">
   <div>
    @{{# if(d.is_local==1){ }}
      <span style='color:green'>本地仓</span>
    @{{# }else if(d.template_type_primary_id==0||d.template_type_primary_id==1){ }}
      <span style='color:brown'>台湾地区仓</span>
    @{{# }else if(d.template_type_primary_id==2){ }}
      <span style='color:brown'>阿联酋地区仓</span>
    @{{# }else if(d.template_type_primary_id==3){ }}
      <span style='color:brown'>马来西亚地区仓</span>
    @{{# }else if(d.template_type_primary_id==4){ }}
      <span style='color:brown'>泰国地区仓</span>
    @{{# }else if(d.template_type_primary_id==5){ }}
      <span style='color:brown'>日本地区仓</span>
    @{{# }else if(d.template_type_primary_id==6){ }}
      <span style='color:brown'>印尼地区仓</span>
    @{{# }else if(d.template_type_primary_id==7){ }}
      <span style='color:brown'>菲律宾地区仓</span>
    @{{# }else if(d.template_type_primary_id==8){ }}
      <span style='color:brown'>英国地区仓</span>
    @{{# }else if(d.template_type_primary_id==9||d.template_type_primary_id==10){ }}
      <span style='color:brown'>美国地区仓</span>
    @{{# }else if(d.template_type_primary_id==11){ }}
      <span style='color:brown'>越南地区仓</span>
    @{{# }else if(d.template_type_primary_id==12||d.template_type_primary_id==13){ }}
      <span style='color:brown'>沙特地区仓</span>
    @{{# }else if(d.template_type_primary_id==14||d.template_type_primary_id==15){ }}
      <span style='color:brown'>卡塔尔地区仓</span>
    @{{# }else if(d.template_type_primary_id==16||d.template_type_primary_id==17){ }}
      <span style='color:brown'>中东地区仓</span>
    @{{# } }}
  </div>
</script>
<script type="text/html" id='is_local'>
  <div>
  @{{# if(d.is_local==1){ }}
    <span style='color:green'>本地仓</span>
  @{{# }else{ }}
    <span style='color:brown'>海外仓</span>
  @{{# } }}
  </div>
</script>
<script type="text/html" id="button" >
  <a class="layui-btn layui-btn-xs" lay-event="detail">查看</a>
  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
  @{{# if(d.is_local!=1){ }}
  <a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="out">退货</a>
  @{{# } }}
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
      ,url: '/admin/storage/list/data' //数据接口
      ,page: true //开启分页
      ,toolbar:'#use_button'
      ,defaultToolbar: ['filter', 'print']
      ,text: {
          none: '暂无仓库'
      }
      ,where: {
        search:$('#test-table-demoReload').val(),
        storage_type:$('#storage_type').val(),
        start:$('#test-laydate-start').val(),
        out:$('#test-laydate-out').val(),
      }
      ,cols: [[ //表头
        {field: 'storage_id', title: 'ID', sort: true, width: 80, fixed: 'left'}
        ,{field: 'storage_name', title: '仓库名'}
        ,{field: 'template_type_primary_id', title: '仓库地区',templet:'#area'}
        ,{field: 'is_local', title: '仓库类型',templet:'#is_local'} 
        ,{field: 'admin_show_name', title: '仓库所属人',width: 100}
        ,{field: 'check_at', title: '上次出库时间', sort: true}
        ,{field: 'created_at', title: '仓库建立时间', sort: true}
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
       table.on("tool(button-listen)",function(obj){
           var data = obj.data; //获得当前行数据
           var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
           var tr = obj.tr; //获得当前行 tr 的DOM对象
           if(layEvent==='detail'){
                layer.open({
                  type:2,
                  offset:'rt',
                  title:'库存数据',
                  area:[400,800],
                  content:"{{url('/admin/storage/list/product_data_smail?storage_id=')}}"+data.storage_id,
                });

           }else if(layEvent==='edit'){
               //修改产品
               that.goods_show('修改仓库信息', '{{url("admin/storage/list/up_storage")}}?id=' + data.storage_id, 2, 600, 510);
           }else if(layEvent==='out'){
               that.goods_show('订单退货', '{{url("admin/storage/list/return_goods")}}?id=' + data.storage_id + '&template_id=' + data.template_type_primary_id, 2, 600, 510);
           }else{
               layer.confirm('真的删除行么', function(index){
                   
                   layer.close(index);
                   //向服务端发送删除指令
                   $.ajax({
                       url:"{{url('admin/storage/list/del_storage')}}",
                       type:'get',
                       data:{id:data.storage_id},
                       datatype:'json',
                       success:function(msg){
                           if(msg['err']==1){
                               layer.close(index);
                               layer.msg(msg.str,{
                                   time: 2000 //2秒关闭（如果不配置，默认是3秒）
                               }, function(){
                                   obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
                                   // parent.layui.admin.events.refresh();
                               });
                           }else if(msg['err']==0){
                               layer.close(index);
                               layer.msg(msg.str);
                           }else{
                               layer.close(index);
                               layer.msg('删除失败！');
                           }
                       }
                   });
               });
           }
       })
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
                                 storage_type:$('#storage_type').val(),
                                 start:$('#test-laydate-start').val(),
                                 out:$('#test-laydate-out').val(),
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

     var $ = layui.$, active = {
                reload: function(){
                    //执行重载
                    table.reload('storagelist',{
                        page: {
                            curr: 1 //重新从第 1 页开始
                        }
                        ,where: {
                            search:$('#test-table-demoReload').val(),
                            storage_type:$('#storage_type').val(),
                            start:$('#test-laydate-start').val(),
                            out:$('#test-laydate-out').val(),
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