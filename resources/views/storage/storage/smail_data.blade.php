@extends('storage.father.static')
@section('content')
<style>
  .layui-table-tool-temp{
    padding:0;
  }
</style>
<script type="text/html" id="search_tem">
  <div class="layui-inline test-table-reload-btn">
                  <div class="layui-inline">
                      <input class="layui-input" name="goods_kind_name" id="search" autocomplete="off">
                  </div>
                  <div class="layui-inline">  
                    <button class="layui-btn" data-type="reload" lay-event='search'>搜索</button>
                  </div>
                
   </div>
</script>
<div class="layui-fluid">
  <div class="layui-card-body layui-text">
            <table class="layui-table">
              <colgroup>
                <col width="100">
                <col>
              </colgroup>
              <tbody> 
               <tr>
                  <td>仓库名</td>
                  <td style="padding-bottom: 0;">
                   <b>{{$storage->storage_name}}</b>
                  </td>
                </tr>
                <tr>
                  <td>建仓时间</td>
                  <td>
                     {{$storage->created_at}}
                  </td>
                </tr>
                <tr>
                  <td>上次出货时间</td>
                  <td>
                     {{$storage->check_at}}
                 </td>
                </tr>
                <tr>
                  <td>上次补货时间</td>
                  <td>
                    @if(\App\storage_append::select('storage_append_end_time')->where('storage_append_status',2)->orderBy('storage_append_end_time','desc')->first()!=null)
                     {{\App\storage_append::select('storage_append_end_time')->where('storage_append_status',2)->orderBy('storage_append_end_time','desc')->first()->storage_append_end_time}}
                    @else
                     暂无到货记录
                    @endif
                 </td>
                </tr>
                <tr>
                  <td>账户地区</td>
                  <td>
                    @if($storage->is_local!=1)
                        <span style='color:brown'>海外仓</span>
                    @else
                        <span style='color:green'>国内仓</span>
                    @endif
                  </td>
                </tr>
              
              </tbody>
            </table>
          </div>
  <div class="layui-card">
      <input type="hidden" id="storage_id" value="{{$storage_id}}">
      <div class="layui-inline " style="width: 100%">                  
                  <button class="layui-btn"  onclick="show_storage_data()" style="width: 100%">库存数据详情</button>
                 <!--  <button class="layui-btn" id="outstorage">仓库信息导出</button> -->

      </div>
  <!-- 表格元素 -->
    <div class="layui-card-body">
      <table id="smail_data" lay-filter='smail-listen'></table>
    </div>

  </div>
</div>
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
    var laydate = layui.laydate;
    var $ =layui.jquery;
    var options={
      elem: '#smail_data'
      ,url: '/admin/storage/list/product_data_smail?id={{$storage_id}}' //数据接口
      ,page: false //开启分页
      ,method:'post'
      ,headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'}
      ,toolbar:'#search_tem'
      ,defaultToolbar: [ 'print']
      ,text: {
        none: '暂无数据' 
      }
      ,autoSort:false
      ,initSort: {
        field: 'num' //排序字段，对应 cols 设定的各字段名
        ,type: 'desc' //排序方式  asc: 升序、desc: 降序、null: 默认排序
      }
      ,where: {
        search:$('#search').val()
      }
      ,cols: [[ //表头
        {field: 'goods_kind_name', title: '产品名'} 
        ,{field: 'goods_kind_sku', title: '产品SKU'}
        ,{field: 'num', title: '产品数量', sort: true}
        /*,{field: 'score', title: '评分', width: 80, sort: true}
        ,{field: 'classify', title: '职业', width: 80}
        ,{field: 'wealth', title: '财富', width: 135, sort: true}*/
      ]]
     };
    //表格初始化
    table.render(options);
    //打开父页面侧边栏
    show_storage_data=function(){
      parent.parent.layui.index.openTabsPage('/admin/storage/list/product_data?id='+$('#storage_id').val(), '库存数据');
    }
    //定义表格排序
     table.on('sort(smail-listen)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                        //尽管我们的 table 自带排序功能，但并没有请求服务端。
                        //有些时候，你可能需要根据当前排序的字段，重新向服务端发送请求，从而实现服务端排序，如：
                        table.reload('smail_data',{
                            initSort: obj //记录初始排序，如果不设的话，将无法标记表头的排序状态。
                            , where: { //请求参数（注意：这里面的参数可任意定义，并非下面固定的格式）
                                field: obj.field //排序字段
                                , order: obj.type //排序方式
                                 ,search:$('#search').val()
                            },
                            page: false
                        });
                    });
    //定义表格重载
     var active = {
                reload: function(){
                    //执行重载
                    table.reload('smail_data',{
                        page: false
                        ,where: {
                            search:$('#search').val()
                                }
                            });
                        },
    };
    table.on('toolbar(smail-listen)', function(obj){
      //var checkStatus = table.checkStatus(obj.config.id);//获取选中行的id
      if(obj.event=='search'){
         var type = $(this).data('type');
          active[type] ? active[type].call(this) : '';
      }
    });

  })
  </script>
@endsection