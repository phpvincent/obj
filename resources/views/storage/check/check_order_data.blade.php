@extends('storage.father.static')
@section('content')
<div class="layui-fluid">
	
   <div class="layui-card">
   <div class="layui-card-header ">
   	<p class="message-text"></p>
   	@if($storage_check!==null)
		<ul >
			<li class="layui-text"><span style="color:red;width: 50%;">校对时间：</span>{{$storage_check->storage_check_time}}  <span style="color:red;width: 50%;">校准单编号：</span>{{$storage_check->storage_check_string}}</li>
			<li class="layui-text"><span style="color:red;width: 50%;">校对类型：</span>@if($storage_check->storage_check_type==0) 系统定时校对 @else 手动发起校对 @endif<span style="color:red;width: 50%;"> 校对发起者：</span>@if($storage_check->storage_check_type==0) 系统 @else {{\App\admin::where('admin_id',$storage_check->storage_check_admin)->first()['admin_show_name']}} @endif</li>

		</ul>
	@endif
	</div>
    <!-- 搜索控件 -->
  <div class="layui-form layui-card-header layuiadmin-card-header-auto">
          <div class="layui-form-item">
          	<div class="layui-inline">
                  <label class="layui-form-label">订单状态</label>
                  <div class="layui-input-block">
                      <select name="storage_check_data_type" id="storage_check_data_type" lay-verify="required">
                          <option value="#">所有</option>
                          <option value="1">海外仓拆分发货</option>
                          <option value="2">海外仓不拆分发货</option>
                          <option value="3">本地仓出货</option>
                          <option value="4">货物不足无法发货</option>
                      </select>
                  </div>
              </div>
              <div class="layui-inline test-table-reload-btn">
                  <label>检索:</label>
                  @if($storage_check!=null)
                  <input type="hidden" name="storage_check_id" id="storage_check_id" value="{{$storage_check->storage_check_id}}">
                  @else
                  <input type="hidden" name="storage_check_id" id="storage_check_id" value="0">
                  @endif
                  <div class="layui-inline">
                      <input class="layui-input" name="id" id="check-table-demoReload" autocomplete="off">
                  </div>
                  <button class="layui-btn" data-type="reload">搜索</button>
                  <button class="layui-btn" id="reload_data">更新校准数据</button>
              </div>
          </div>
  </div>
   
  <!-- 表格元素 -->
    <div class="layui-card-body">
      <table id="check_data" lay-filter='order-listen'></table>
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
               onclick="location.reload()">刷新数据</b>
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
      elem: '#check_data'
      ,url: '/admin/storage/list/get_check_data' //数据接口
      ,page: false //开启分页

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
        search:$('#check-table-demoReload').val(),
        storage_check_id:$('#storage_check_id').val(),
        storage_check_data_type:$('#storage_check_data_type').val(),
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

       
    //切换为数据校准记录栏
    check_data=function check_data(){
     parent.parent.layui.index.openTabsPage('/admin/storage/check/list', '校准数据记录');
    }

     var $ = layui.$, active = {
                reload: function(){
                    //执行重载
                    table.reload('check_data',{
                        where: {
                            search:$('#check-table-demoReload').val(),
                            storage_check_id:$('#storage_check_id').val(),
                            storage_check_data_type:$('#storage_check_data_type').val(),
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
                               layer.msg('校准失败！');
                           }
                       }
    		})	
    	});
    })
   });
</script>
@endsection