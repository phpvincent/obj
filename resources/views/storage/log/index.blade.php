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
                          <label class="layui-form-label">操作日期：</label>
                          <div class="layui-input-inline">
                              <input type="text" class="layui-input" id="created_at"
                                     placeholder="日期范围">
                          </div>
                      </div>
                  </div>
              </div>
              <div class="layui-inline">
                  <label class="layui-form-label">操作类型</label>
                  <div class="layui-input-block">
                      <select name="storage_log_type" id="storage_log_type" lay-verify="required">
                          <option value="#">所有</option>
                          <option value="1">补货单操作</option>
                          <option value="2">库存数据操作</option>
                          <option value="3">仓库数据操作</option>
                          <option value="4">数据校准操作</option>
                          <option value="5">订单扣货操作</option>
                          <option value="6">订单出仓操作</option>
                      </select>
                  </div>
              </div>
               <div class="layui-inline">
                  <label class="layui-form-label">操作性质</label>
                  <div class="layui-input-block">
                      <select name="is_danger" id="is_danger" lay-verify="required">
                          <option value="#">所有</option>
                          <option value="0">非危险操作</option>
                          <option value="1">危险操作</option>
                      </select>
                  </div>
              </div>
              <div class="layui-inline test-table-reload-btn">
                  <label>从当前数据中检索:</label>
                  <div class="layui-inline">
                      <input class="layui-input" name="search" id="test-table-log" autocomplete="off">
                  </div>
                  <button class="layui-btn" data-type="reload">搜索</button>
                 <!--  <button class="layui-btn" id="outstorage">仓库信息导出</button> -->
              </div>
          </div>
  </div>
  <!-- 表格元素 -->
    <div class="layui-card-body">
      <table id="loglist" lay-filter='log-listen'></table>
    </div>

  </div>
</div>
  <script type="text/html" id="use_button">
        <button class="layui-btn layui-btn-primary layui-btn-sm" style="border-radius: 0;">
            <b style="color:red;"
               onclick="log_delete()">删除记录</b>
        </button>
  </script>

<script type="text/html" id='danger'>
  <div>
  @{{# if(d.is_danger=='是'){ }}
    <span style='color:red'>危险操作</span>
  @{{# }else{ }}
    <span style='color:green'>普通操作</span>
  @{{# } }}
  </div>
</script>
<script type="text/html" id="button" >
  <a class="layui-btn layui-btn-xs" lay-event="detail">详情</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
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
      elem: '#loglist'
      ,url: '/admin/storage/log/index' //数据接口
      ,page: true //开启分页
      ,limits:[10,20,30,40,50,60,70,80,90,999999999]
      ,toolbar:'#use_button'
      ,defaultToolbar: ['filter','exports', 'print']
      ,text: {
        none: '暂无日志数据' 
      }
      ,method:'post'
      ,headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'}
      ,autoSort:true
      ,initSort: {
        field: 'created_at' //排序字段，对应 cols 设定的各字段名
        ,type: 'desc' //排序方式  asc: 升序、desc: 降序、null: 默认排序
      }
      ,where: {
        search:$('#test-table-log').val(),
        storage_log_type:$('#storage_log_type').val(),
        created_at:$('#created_at').val(),
        is_danger:$('#is_danger').val(),
      }
      ,cols: [[ //表头
        {type: 'checkbox',fixed: 'left',LAY_CHECKED:true}
        ,{field: 'storage_log_id', title: 'ID', sort: true, fixed: 'left'}
        ,{field: 'storage_log_type', title: '操作类型'}
        ,{field: 'is_danger', title: '是否危险',templet:'#danger'} 
        ,{field: 'admin_show_name', title: '操作人'}
        ,{field: 'created_at', title: '操作日期', sort: true}
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
      elem: '#created_at' //指定元素
      ,type:'datetime'
      ,range: true //或 range: '~' 来自定义分割字符
      ,theme: 'molv'
      ,calendar: true
    });
       //搜索刷新数据
       var $ = layui.$;

       //table事件监听
       table.on("tool(log-listen)",function(obj){
           var data = obj.data; //获得当前行数据
           var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
           var tr = obj.tr; //获得当前行 tr 的DOM对象
           if(layEvent=='detail'){
                layer.open({
                  type:2,
                  offset:'rt',
                  title:'具体数据',
                  area:[600,800],
                  content:"{{url('/admin/storage/log/log_show?storage_log_id=')}}"+data.storage_log_id,
                });

           }else{
               layer.confirm('真的删除此日志记录吗', function(index){
                   var index=layer.load();
                   layer.close(index);
                   //向服务端发送删除指令
                   $.ajax({
                       url:"{{url('admin/storage/log/del_log')}}",
                       type:'post',
                       headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'},
                       data:{id:data.storage_log_id},
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
                               layer.msg('删除失败！');
                           }
                       }
                   });
               });
           }
       })
       //排序监听
       table.on('sort(log-listen)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                        //尽管我们的 table 自带排序功能，但并没有请求服务端。
                        //有些时候，你可能需要根据当前排序的字段，重新向服务端发送请求，从而实现服务端排序，如：
                        table.reload('loglist',{
                            initSort: obj //记录初始排序，如果不设的话，将无法标记表头的排序状态。
                            , where: { //请求参数（注意：这里面的参数可任意定义，并非下面固定的格式）
                                field: obj.field //排序字段
                                , order: obj.type //排序方式
                                 , search:$('#test-table-log').val(),
        						   storage_log_type:$('#storage_log_type').val(),
        						   created_at:$('#created_at').val(),
        						     is_danger:$('#is_danger').val(),
                            }
                        });
                    });

    //复选删除日志记录
    log_delete=function (){
    	 layer.confirm('真的删除所有被选中日志记录吗', function(index){
	    	var checkStatus = table.checkStatus('loglist'); //out_list 即为基础参数 id 对应的值
			//console.log(checkStatus.data) //获取选中行的数据
			//console.log(checkStatus.data.length) //获取选中行数量，可作为是否有选中行的条件
			//console.log(checkStatus.isAll ) //表格是否全选
			var ids=new Array;
			$.each(checkStatus.data,function(key,val){
				ids.push(val.storage_log_id);
			})
			if(ids.length==0){
				layer.msg('无选中项');
				return;
			}
			var index=layer.load();
	    	 $.ajax({
	                url:"{{url('admin/storage/log/del_log')}}",
	                             type:'post',
	                             headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'},
	                             datatype:'json',
	                             data:{'ids':ids},
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
	                                     layer.msg('删除失败！');
	                                 }
	                             }
	              }) 
              }) 
    }


     var $ = layui.$, active = {
                reload: function(){
                    //执行重载
                    table.reload('loglist',{
                        page: {
                            curr: 1 //重新从第 1 页开始
                        }
                        ,where: {
                            search:$('#test-table-log').val(),
        					storage_log_type:$('#storage_log_type').val(),
        					created_at:$('#created_at').val(),
        					  is_danger:$('#is_danger').val(),
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