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
                                <label class="layui-form-label">采购单号</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="storage_append_single" id="storage_append_single" value="" lay-verify="required" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">采购时间</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="storage_append_time" class="layui-input" id="goodsdate">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">备注</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="storage_append_msg" id="storage_append_msg" value="" autocomplete="off" class="layui-input">
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
                            <div class="layui-form-item flag" style="display:none">
                                <label class="layui-form-label">选择变种:</label>
                                <input type="checkbox" name="" title="全选" lay-filter="allGoodsCheck">
                            </div>
                            <div class="layui-form-item flag" style="display:none">
                                <div class="layui-inline">
                                    <div class="goodsCheckbox">
                                        <!-- <input type="checkbox" name="" title="豆豆" goods_sku="1" goods_kind_name="豆豆" good_attr="红大" lay-filter="goodsCheck">
                                        <input type="checkbox" name="" title="香水" goods_sku="2" goods_kind_name="香水" good_attr="白大" lay-filter="goodsCheck">
                                        <input type="checkbox" name="" title="牛仔" goods_sku="3" goods_kind_name="牛仔" good_attr="小女" lay-filter="goodsCheck">  -->
                                    </div>
                                </div>
                            </div>
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
        <script id="goodsCheckbox" type="text/html">
            @{{# if(d.data[0].goods_attr===''){d.data[0].goods_attr=d.data[0].goods_kind_name} layui.each(d.data, function(index, item){ }}
            <input type="checkbox" name="" title="@{{item.goods_attr}}" goods_sku="@{{item.goods_sku}}" goods_kind_id="@{{item.goods_kind_id}}" goods_kind_name="@{{item.goods_kind_name}}" goods_attr="@{{item.goods_attr}}" lay-filter="goodsCheck">
            @{{#  }); }}
        </script>
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
                    <input type="text" name="num" value="" placeholder="请输入数量" class="layui-input" lay-verify="required">
                </td>
                <td>
                    <span class="layui-btn layui-btn-xs layui-btn-danger removeGoodsAppend"><i class="layui-icon">&#xe640;</i></span>
                </td>
            </tr>
        </script>
        <script id="goodsAppendtow" type="text/html">
            <tr>
                <td>
                    <input type="hidden" readonly name="storage_append_data_id" value="@{{d.storage_append_data_id}}" class="layui-input">
                    <input type="hidden" readonly name="goods_kind_id" value="@{{d.storage_append_kind_id}}" class="layui-input">
                    <span>@{{d.storage_append_kind_id}}</span>
                </td>
                <td>
                    <input type="hidden" readonly name="goods_kind_name" value="@{{d.goods_kind_name}}" class="layui-input">
                    <span>@{{d.goods_kind_name}}</span>
                </td>
                <td>
                    <input type="hidden" readonly name="goods_attr" value="@{{d.storage_append_data_sku_attr}}" class="layui-input">
                    <span>@{{d.storage_append_data_sku_attr}}</span>
                </td>
                <td>
                    <input type="hidden" readonly name="goods_sku" value="@{{d.storage_append_data_sku}}" class="layui-input">
                    <span>@{{d.storage_append_data_sku}}</span>
                </td>
                <td>
                    <input type="text" name="num" value="@{{d.storage_append_data_num}}" placeholder="请输入数量" class="layui-input" lay-verify="required">
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
                    
                    // 初始化赋值
                    var datas = '{!!$storage_append_data!!}';
                    var datasList = JSON.parse(datas)
                       console.log(datasList)
                       $.each(datasList, function(index, value){
                        var getTpl = goodsAppendtow.innerHTML
                            laytpl(getTpl).render(value, function(string){
                                $('.goodsAppend tbody').append(string)
                            })
                       })
                    
                    laydate.render({
                        elem: '#goodsdate' //指定元素
                    });
                    // 监听 下拉框变化
                    form.on('select(goodsSelec)', function(data) {
                        var index = layer.load();
                        $.ajax({
                            type:'post',
                            url: "get_goods_config",
                            data: {id:data.value},
                            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                            success: function (response) {
                                console.log('response',response)
                                layer.close(index);
                                var getTpl = goodsCheckbox.innerHTML
                                laytpl(getTpl).render(response, function(string){
                                    $('.goodsCheckbox').html(string)
                                    form.render('checkbox');
                                });
                                // 让之前已经选过的重新选中；
                                var datas = $(".goodsAppendForm").serializeArray()
                                $.each(datas, function (index, value) {
                                    if (value.name === 'goods_sku') {
                                        $('.goodsCheckbox input[goods_sku="'+value.value+'"]').prop("checked", true)
                                        form.render('checkbox');
                                    }
                                });
                                if(response.data.length>0){$('.flag').show()}else{$('.flag').hide()}

                            }
                        });
                    })
                    // 复选框监听
                    form.on('checkbox(goodsCheck)', function(data) {
                        var datas = {};
                        datas['goods_kind_name']=$(data.elem).attr("goods_kind_name")
                        datas['goods_sku']=$(data.elem).attr("goods_sku")
                        datas['goods_attr']=$(data.elem).attr("goods_attr")
                        datas['goods_kind_id']=$(data.elem).attr("goods_kind_id")
                        if(data.elem.checked) {
                            var getTpl = goodsAppend.innerHTML
                            laytpl(getTpl).render(datas, function(string){
                                console.log(string);
                                $('.goodsAppend tbody').append(string)
                            });
                        } else {
                            $('.goodsAppend tbody input[value="'+datas.goods_sku+'"]').parent().parent().remove()
                        }
                    })
                    // checkbox全选按钮
                    form.on('checkbox(allGoodsCheck)', function(data) {
                        if(data.elem.checked){
                            $(".goodsCheckbox input").prop("checked", true);
                            form.render('checkbox');
                            $.each($(".goodsCheckbox input"), function (index, value) {
                                var datas = {};
                                datas['goods_kind_name']=$(value).attr("goods_kind_name")
                                datas['goods_sku']=$(value).attr("goods_sku")
                                datas['goods_attr']=$(value).attr("goods_attr")
                                datas['goods_kind_id']=$(value).attr("goods_kind_id")
                                var getTpl = goodsAppend.innerHTML
                                laytpl(getTpl).render(datas, function(string){
                                    $('.goodsAppend tbody').append(string)
                                })
                            })
                        } else {
                            $(".goodsCheckbox input").prop("checked", false);
                            form.render('checkbox');
                            $.each($(".goodsCheckbox input"), function (index, value) {
                                $('.goodsAppend tbody input[value="'+$(value).attr("goods_sku")+'"]').parent().parent().remove()
                            })
                        }
                    });

                    //自定义验证规则
                    form.verify({
                        append_single: function (value) {
                            if (value.length < 5) {
                                return '标题至少得5个字符啊';
                            }
                        }
                    });

                    // 表格提交
                    form.on('submit(formDemo)', function(data){
                        if($('#storage_append_single').val()===''){
                            layer.msg('<i class="layui-icon layui-icon-face-cry" style="font-size: 30px; color: #FF5722;"></i> 请填写采购单号' ,{offset: '100px'})
                            return false
                        }
                        if($('#goodsdate').val()===''){
                            layer.msg('<i class="layui-icon layui-icon-face-cry" style="font-size: 30px; color: #FF5722;"></i> 请选择采购时间' ,{offset: '100px'})
                            return false
                        }

                        var data = $(data.form).serializeArray();
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
                        $.ajax({
                            url:"/admin/storage/add/add_goods",
                            type:'post',
                            data:{goods_attr:JSON.stringify(arr),goods_kind:$('#goods_kind').val(),storage_append_msg:$('#storage_append_msg').val(),storage_append_single:$('#storage_append_single').val(),storage_append_time:$('#goodsdate').val()},
                            // datatype:'json',
                            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
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