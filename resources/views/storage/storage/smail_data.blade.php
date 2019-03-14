@extends('storage.father.static')
@section('content')
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
      <input type="hidden" name="storage_id" value="{{$storage_id}}">
      <div class="layui-inline test-table-reload-btn" style="width: 100%">                  
                  <button class="layui-btn"  onclick="show_storage_data()" style="width: 100%">库存数据详情</button>
                 <!--  <button class="layui-btn" id="outstorage">仓库信息导出</button> -->

      </div>
  <!-- 表格元素 -->
    <div class="layui-card-body">
      <table id="smail_data" lay-filter='button-listen'></table>
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
      ,url: '/admin/storage/list/data' //数据接口
      ,page: false //开启分页
      ,toolbar:'#use_button'
      ,defaultToolbar: ['filter', 'print']
      ,text: {
        none: '暂无仓库数据' 
      }
      ,initSort: {
        field: 'num' //排序字段，对应 cols 设定的各字段名
        ,type: 'desc' //排序方式  asc: 升序、desc: 降序、null: 默认排序
      }
      ,where: {
      }
      ,cols: [[ //表头
        {field: 'goods_kind_name', title: '产品名'} 
        ,{field: 'sku', title: '产品SKU（前四位）'}
        ,{field: 'num', title: '产品数量', sort: true}
        /*,{field: 'score', title: '评分', width: 80, sort: true}
        ,{field: 'classify', title: '职业', width: 80}
        ,{field: 'wealth', title: '财富', width: 135, sort: true}*/
      ]]
     };
    //表格初始化
    table.render(options);
    show_storage_data=function(){
      parent.parent.layui.index.openTabsPage('/admin/storage/list/product_data?storage_id='+$('.storage_id').val(), '库存数据');
    }
  })
  </script>
@endsection