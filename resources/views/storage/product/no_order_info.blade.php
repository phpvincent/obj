@extends('storage.father.static')
@section('content')
    <div class="layui-container">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-body" pad15>
                        <form class="layui-form layui-form-pane " method="post" lay-filter="" action="">
                            {{csrf_field()}}
                            <div class="layui-form-item">
                            <button class="layui-btn layui-btn-sm layui-btn-primary" onClick="javascript :history.back(-1)"><i class="layui-icon">&#xe65a;</i>返回</button>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">仓库名称</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="storage_append_msg" id="storage_append_msg" value="" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">订单编号</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="storage_append_single" id="storage_append_single" value="{{$order_single}}" lay-verify="required" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">运单号</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="storage_append_msg" id="storage_append_msg" value="" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">有效期</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="storage_append_msg" id="storage_append_msg" value="7" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <div class="layui-inline">
                                    <label class="layui-form-label">采购商品</label>
                                    <div class="layui-input-inline">
                                        <select name="goods_kind" id="goods_kind" lay-verify="required" lay-search="" lay-filter="goodsSelec">
                                        <option value="">请选择</option>
                                            @foreach($product as $item)
                                            <option value="{{$item->goods_kind_id}}">{{$item->goods_kind_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="layui-form-item flag" style="display:none">
                               <label class="layui-form-label">选择变种:</label>
                               <input type="checkbox" name="" title="全选" lay-filter="allGoodsCheck">
                            </div> -->
                            <!-- <div class="layui-form-item flag" style="display:none">
                                <div class="layui-inline">
                                    <div class="goodsCheckbox">

                                    </div>
                                </div>
                            </div> -->
                        </form>
                    </div>
                </div>
                <div class="layui-card">
                <div class="layui-card-header">补货单</div>
                <div class="layui-card-body" pad15>
                   <form class="layui-form layui-form-pane goodsAppendForm" method="post" lay-filter="" action="">
                   <div class="layui-row">
                      <table class="layui-table goodsAppend">
                        <thead>
                          <tr>
                           <th>产品ID</th>
                            <th>产品名称</th>
                            <th>变种</th>
                            <th>SKU</th>
                            <th>数量</th>
                            <th>操作</th>
                          </tr> 
                        </thead>
                        <tbody>

                        </tbody>
                      </table>
                    </div>
                    <div class="layui-row">
                        <div class="layui-form-item">
                           <div class="layui-input-block">
                             <button style="float: right;" class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                           </div>
                        </div>
                    </div>
                   </form>
                </div>
            </div>
        </div>
    </div>

   <script id="goodsAppend" type="text/html">
        <tr>
          <td>
          <input type="hidden" readonly name="goods_kind_id" value="@{{d.goods_kind_id}}" class="layui-input">
          <span>@{{d.goods_kind_id}}</span>
          </td>
          <td>
          <input type="hidden" readonly name="goods_kind_name" value="@{{d.goods_kind_name}}" class="layui-input">
          <span>@{{d.goods_kind_name}}</span>
          </td>
          <td>
          <input type="hidden" readonly name="goods_attr" value="@{{d.goods_attr}}" class="layui-input">
          <span>@{{d.goods_attr}}</span>
          </td>
          <td>
          <input type="hidden" readonly name="goods_sku" value="@{{d.goods_sku}}" class="layui-input">
          <span>@{{d.goods_sku}}</span>
          </td>
          <td>
          <input type="text" name="num" value="0"  onkeyup="(this.v=function(){this.value=this.value.replace(/[^\d]/g,'');})" onblur="this.v();" placeholder="请输入数量" class="layui-input" lay-verify="required">
          </td>
          <td>
           <span class="layui-btn layui-btn-xs layui-btn-danger removeGoodsAppend"><i class="layui-icon">&#xe640;</i></span>
          </td>
        </tr>
   </script>
@endsection
@section('js')
    <script>
        layui.config({
            base: '{{asset("/admin/layuiadmin/")}}/' //静态资源所在路径
        }).extend({
            index: 'lib/index' //主入口模块
        }).use(['form','index', 'set', 'admin', 'laytpl', 'laydate'],function(){
            var form=layui.form;
            var laytpl = layui.laytpl;
            var admin=layui.admin;
            var $=layui.jquery;
            var layer = layui.layer;
            var laydate = layui.laydate;



            // 监听 下拉框变化
            form.on('select(goodsSelec)', function(data) {
               var index = layer.load();
               $.ajax({
                   type:'post',
                   url: "/admin/storage/add/get_goods_config",
                   data: {id:data.value},
                   headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                   success: function (response) {
                       console.log('response',response)
                       layer.close(index);
                       $('.goodsAppend tbody').empty()
                       $.each(response.data, function(index, value){
                        var getTpl = goodsAppend.innerHTML
                            laytpl(getTpl).render(value, function(string){
                                $('.goodsAppend tbody').append(string)
                            })
                       })
                   }
               });
            })


            //自定义验证规则
            // form.verify({
            //     append_single: function (value) {
            //         if (value.length < 5) {
            //             return '标题至少得5个字符啊';
            //         }
            //     }
            // });

            // 表格提交
            form.on('submit(formDemo)', function(data){
            //   if($('#storage_append_single').val()===''){
            //       layer.msg('<i class="layui-icon layui-icon-face-cry" style="font-size: 30px; color: #FF5722;"></i> 请填写采购单号' ,{offset: '100px'})
            //       return false
            //   }
            // if($('#goodsdate').val()===''){
            //     layer.msg('<i class="layui-icon layui-icon-face-cry" style="font-size: 30px; color: #FF5722;"></i> 请选择采购时间' ,{offset: '100px'})
            //     return false
            // }

              var data = $(data.form).serializeArray();
              var num = 0;
              var obj = {};
              var arr = [];
              for(var i=0; i<data.length; i++){
                  if(data[i].name === 'num'){
                      obj[data[i].name] = data[i].value
                      arr.push(obj)
                      obj = {};
                  } else{
                      obj[data[i].name] = data[i].value
                  }
              }
                var index = layer.load();
                console.log(arr)
                // $.ajax({
                //     url:"/admin/storage/add/add_goods",
                //     type:'post',
                //     data:{goods_attr:JSON.stringify(arr),goods_kind:$('#goods_kind').val(),storage_append_msg:$('#storage_append_msg').val(),storage_append_single:$('#storage_append_single').val(),storage_append_time:$('#goodsdate').val()},
                //     // datatype:'json',
                //     headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                //     success:function(msg){
                //         if(msg['err']==1){
                //             layer.close(index);
                //             layer.msg(msg.msg,{
                //                 time: 2000 //2秒关闭（如果不配置，默认是3秒）
                //             }, function(){
                //                 // parent.layui.admin.events.refresh();
                //                 window.parent.location.reload();
                //             });
                //         }else if(msg['err']==0){
                //             layer.close(index);
                //             layer.msg(msg.msg);
                //         }else{
                //             layer.close(index);
                //             layer.msg('新增失败！');
                //         }
                //     }
                // });
              return false;
            });
            // 表格里面的删除按钮
            $(document).on("click",".removeGoodsAppend",function () {
               $(this).parent().parent().remove()
               $('.goodsCheckbox input[goods_sku="'+$(this).parent().parent().find('input[name="goods_sku"]').val()+'"]').prop("checked", false)
               form.render('checkbox');
            })
        });

    </script>
@endsection