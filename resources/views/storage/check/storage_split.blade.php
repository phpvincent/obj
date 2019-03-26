@extends('storage.father.static')
@section('content')
 <div class="layui-form layui-card-header layuiadmin-card-header-auto">
          <div class="layui-form-item">
              <div class="layui-inline">
                  <label class="layui-form-label">订单地区</label>
                  <div class="layui-input-block">
                      <select name="order_blade_type" id="order_blade_type" lay-verify="required">
                        <option value="#">所有</option>
                        <option value="0" >0--台湾模板</option>
						<option value="1">1--简体模板</option>
						<option value="2">2--阿联酋模板</option>
						<option value="3">3--马来西亚模板</option>
						<option value="4">4--泰国模板（旧版）</option>
						<option value="5">5--日本模板（旧版）</option>
						<option value="6">6--印度尼西亚</option>
						<option value="7">7--菲律宾</option>
						<option value="8">8--英国（旧版）</option>
						<option value="9">9--Google-PC（旧版）</option>
						<option value="10">10--美国（旧版）</option>
						<option value="11">11--越南（旧版）</option>
						<option value="12">12--沙特</option>
						<option value="13">13--沙特英文</option>						
						<option value="14">14--卡塔尔</option>
						<option value="15">15--卡塔尔英文</option>
						<option value="16">16--中东阿语</option>
						<option value="17">17--中东英语</option>
                      </select>
                  </div>
              </div>
              <div class="layui-inline test-table-reload-btn">
                  <label>从当前数据中检索:</label>
                  <div class="layui-inline">
                      <input class="layui-input" name="id" id="out_search" autocomplete="off">
                  </div>
                  <button class="layui-btn" data-type="reload">搜索</button>
                 <!--  <button class="layui-btn" id="outstorage">仓库信息导出</button> -->
              </div>
          </div>
  </div>
<div class="layui-fluid">
  <div class="layui-card">
  	<div class="layui-card-body">
      <table id="out_list" lay-filter='out-listen'></table>
    </div>
  </div>
</div>
<script type="text/html" id="use_button">
        <button class="layui-btn layui-btn-primary layui-btn-sm" style="border-radius: 0;">
            <b style="color:green;"
               onclick="data_out()">确定出仓</b>
        </button>
</script>
@endsection
@section('js')
<script type="text/javascript">
layui.config({
    base: '{{asset("/admin/layuiadmin/")}}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index','admin', 'table'],function(){
    var table = layui.table;
    var $ =layui.jquery;
    var options={
      elem: '#out_list'
      ,url: '/admin/storage/out_data' //数据接口
      ,page: true //开启分页
      ,limits:[10,20,30,40,50,60,70,80,90,999999999]
      ,toolbar:'#use_button'
      ,defaultToolbar: ['filter','exports', 'print']
      ,text: {
        none: '暂无待出仓订单数据' 
      },
      method:'get'
      ,autoSort:true
      ,initSort: {
        field: 'order_id' //排序字段，对应 cols 设定的各字段名
        ,type: 'desc' //排序方式  asc: 升序、desc: 降序、null: 默认排序
      }
      ,where: {
        search:$('#out_search').val(),
        order_blade_type:$('#order_blade_type').val(),
      }
      ,cols: [[ //表头
        {type: 'checkbox',fixed: 'left',LAY_CHECKED:true}
        ,{field: 'order_id', title: '订单ID', sort: true, fixed: 'left'}
        ,{field: 'order_single_id', title: '订单号'}
        ,{field: 'goods_kind_name', title: '产品名'}
        ,{field: 'goods_kind_sku', title: '产品sku'}
        ,{field: 'goods_blade_type', title: '订单地区'}
        /*,{field: 'score', title: '评分', width: 80, sort: true}
        ,{field: 'classify', title: '职业', width: 80}
        ,{field: 'wealth', title: '财富', width: 135, sort: true}*/
      ]]
     };
    //表格初始化
    table.render(options);
    table.on('checkbox(test)', function(obj){
	  console.log(obj.checked); //当前是否选中状态
	  console.log(obj.data); //选中行的相关数据
	  console.log(obj.type); //如果触发的是全选，则为：all，如果触发的是单选，则为：one
	});
       //排序监听
   table.on('sort(out-listen)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                    //尽管我们的 table 自带排序功能，但并没有请求服务端。
                    //有些时候，你可能需要根据当前排序的字段，重新向服务端发送请求，从而实现服务端排序，如：
                    table.reload('out_list',{
                        initSort: obj //记录初始排序，如果不设的话，将无法标记表头的排序状态。
                        , where: { //请求参数（注意：这里面的参数可任意定义，并非下面固定的格式）
                            field: obj.field //排序字段
                            , order: obj.type //排序方式
                             ,search:$('#out_search').val(),
        					 order_blade_type:$('#order_blade_type').val(),
                        }
                    });
                });
	//表格重载
	 var $ = layui.$, active = {
                reload: function(){
                    //执行重载
                    table.reload('order_list',{
                        page: {
                            curr: 1 //重新从第 1 页开始
                        }
                        ,where: {
                            search:$('#out_search').val(),
                             order_blade_type:$('#order_blade_type').val(),
                                }
                            });
                        }
    };
    data_out=function data_out(){
    	var checkStatus = table.checkStatus('out_list'); //out_list 即为基础参数 id 对应的值
		//console.log(checkStatus.data) //获取选中行的数据
		//console.log(checkStatus.data.length) //获取选中行数量，可作为是否有选中行的条件
		//console.log(checkStatus.isAll ) //表格是否全选
		var ids=new Array;
		$.each(checkStatus.data,function(key,val){
			ids.push(val.order_id);
		})
		if(ids.length==0){
			layer.msg('无选中项');
			return;
		}
		var index=layer.load();
    	 $.ajax({
                url:"{{url('admin/storage/out_data')}}",
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
                                     layer.msg('出货失败！');
                                 }
                             }
              })  
    }
    $('.test-table-reload-btn .layui-btn').on('click', function () {
                        var type = $(this).data('type');
                        active[type] ? active[type].call(this) : '';
                    });
  })
</script>
@endsection