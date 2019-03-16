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
                                <div class="layui-inline">
                                    <label class="layui-form-label">搜索选择框</label>
                                    <div class="layui-input-inline">
                                        <select name="goods_kind" lay-verify="required" lay-search="" lay-filter="goodsSelec">
                                            @foreach($product as $item)
                                            <option value="{{$item->goods_kind_id}}">{{$item->goods_kind_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="layui-form-item">
                               <label class="layui-form-label">选择变种:</label>
                            </div>
                            <div class="layui-form-item">
                                <div class="layui-inline">
                                    <div class="layui-input-block">
                                        <input type="checkbox" name="" title="豆豆" goods_sku="1" goods_kind_name="豆豆" good_attr="红大" lay-filter="goodsCheck">
                                        <input type="checkbox" name="" title="香水" goods_sku="2" goods_kind_name="香水" good_attr="白大" lay-filter="goodsCheck"> 
                                        <input type="checkbox" name="" title="牛仔" goods_sku="3" goods_kind_name="牛仔" good_attr="小女" lay-filter="goodsCheck"> 
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="layui-card">
                <div class="layui-card-header">补货单</div>
                <div class="layui-card-body" pad15>
                   <form class="layui-form layui-form-pane" method="post" lay-filter="" action="">
                   <div class="layui-row">
                       <div class="layui-col-md6">
                         laofan 
                       </div>
                       <div class="layui-col-md6">
                         laofan 
                       </div>
                    </div>
                   </form>
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
        }).use(['form','index', 'set','admin'],function(){
            var form=layui.form;

            var admin=layui.admin;
            var $=layui.jquery;
            form.on('select(goodsSelec)', function(data) {
               console.log('goodsSelec',data)
               $.ajax({
                   type: "get",
                   url: "url",
                   data: data.value,
                //    dataType: "dataType",
                   success: function (response) {
                       
                   }
               });
            })

            form.on('checkbox(goodsCheck)', function(data) {
               console.log('goodsCheck',data)
               console.log('checked',data.elem.checked,$(data.elem).prop("title"),$(data.elem).attr("goods_sku"),$(data.elem).attr("goods_kind_name"), $(data.elem).attr("good_attr") )
            })

            var addressID = $("input[name='is_local']:checked").val();
            if(addressID === '1'){
                $('.item-model-hide').addClass('layui-hide');
            }

            form.on('radio(is_local)', function () {
                var addressID = $("input[name='is_local']:checked").val();
                if(addressID === '1'){
                    $('.item-model-hide').addClass('layui-hide');
                }else{
                    $('.item-model-hide').removeClass('layui-hide');
                }
            });
            
            form.on('submit',function(data){
                var index = layer.load();
                $.ajax({
                    url:"{{url('admin/storage/list/add_storage')}}",
                    type:'post',
                    data:data.field,
                    datatype:'json',
                    success:function(msg){
                        if(msg['err']==1){
                            layer.close(index);
                            layer.msg(msg.msg,{
                                time: 2000 //2秒关闭（如果不配置，默认是3秒）
                            }, function(){
                                // parent.layui.admin.events.refresh();
                                window.parent.location.reload();
                            });
                        }else if(msg['err']==0){
                            layer.close(index);
                            layer.msg(msg.msg);
                        }else{
                            layer.close(index);
                            layer.msg('新增失败！');
                        }
                    }
                });
                return false;
            })
        });

    </script>
@endsection