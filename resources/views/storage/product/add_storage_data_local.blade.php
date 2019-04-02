@extends('storage.father.static')
@section('content')
<script src="https://cdn.bootcss.com/xlsx/0.11.5/xlsx.core.min.js"></script>
    <div class="layui-container">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
            <div class="layui-card">
            <div class="layui-tab">
              <ul class="layui-tab-title">
                <li class="layui-this">手动添加</li>
                <li>上传表格添加</li>
              </ul>
              <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                <div class="layui-card">
                    <div class="layui-card-body" pad15>
                        <form class="layui-form layui-form-pane " method="post" lay-filter="" action="">
                            {{csrf_field()}}
                            <div class="layui-form-item">
                                <div class="layui-inline">
                                    <label class="layui-form-label">采购商品</label>
                                    <input style="display: none" value="{{$storage->storage_id}}" name="storage_id" id="storage_id" type="text">
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
                                <label class="layui-form-label">选择属性:</label>
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
                    <div class="layui-card-header">补货表格</div>
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
                <div class="layui-tab-item">
                   <input type="file" id="excel-file">
                   <div class="layui-card">
                    <div class="layui-card-header">补货表格</div>
                    <div class="layui-card-body" pad15>
                        <form class="layui-form layui-form-pane goodsAppendForm2" method="post" lay-filter="" action="">
                            <div class="layui-row">
                                <table class="layui-table goodsAppend2">
                                    <thead>
                                    <tr>
                                        <th>产品名</th>
                                        <th>产品sku</th>
                                        <th>产品数目</th>
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
                                        <button style="float: right;" class="layui-btn" lay-submit lay-filter="formDemo2">立即提交</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                </div>
              </div>
            </div>
            <div>

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
                    <input type="text" name="num" value=""  onkeyup="(this.v=function(){this.value=this.value.replace(/[^\d]/g,'');})" onblur="this.v();" placeholder="请输入数量" class="layui-input" lay-verify="required">
                </td>
                <td>
                    <span class="layui-btn layui-btn-xs layui-btn-danger removeGoodsAppend"><i class="layui-icon">&#xe640;</i></span>
                </td>
            </tr>
        </script>
        <script id="goodsAppend2" type="text/html">
            <tr>
                <td>
                    <input type="hidden" readonly name="goods_kind_name" value="@{{d.goods_kind_name}}" class="layui-input">
                    <span>@{{d.goods_kind_name}}</span>
                </td>
                <td>
                    <input type="hidden" readonly name="goods_sku" value="@{{d.goods_sku}}" class="layui-input">
                    <span>@{{d.goods_sku}}</span>
                </td>
                <td>
                    <input type="text" name="num" value="@{{d.num}}"  onkeyup="(this.v=function(){this.value=this.value.replace(/[^\d]/g,'');})" onblur="this.v();" placeholder="请输入数量" class="layui-input" lay-verify="required">
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
                    laydate.render({
                        elem: '#goodsdate' //指定元素
                    });
                    // 监听 下拉框变化
                    form.on('select(goodsSelec)', function(data) {
                        var index = layer.load();
                        $.ajax({
                            type:'post',
                            url: "/admin/storage/add/get_goods_config",
                            data: {id:data.value},
                            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                            success: function (response) {
                                // console.log('response',response)
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
                                // console.log(string);
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
                                $('.goodsAppend tbody input[value="'+$(value).attr("goods_sku")+'"]').parent().parent().remove()
                            })
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
                        var num = 0;
                        var obj = {};
                        var arr = [];
                        for(var i=0; i<data.length; i++){
                            if(num===4){
                                obj[data[i].name] = data[i].value
                                arr.push(obj)
                                num = 0;
                                obj = {};
                            } else{
                                obj[data[i].name] = data[i].value
                                num++
                            }
                        }
                        var index = layer.load();
                        $.ajax({
                            url:"/admin/storage/list/add_storage_data_local",
                            type:'post',
                            data:{goods_attr:JSON.stringify(arr),storage_id:$('#storage_id').val()},
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

                        //给input标签绑定change事件，一上传选中的.xls文件就会触发该函数
                        $('#excel-file').change(function(e) {
                            var files = e.target.files;
                            var fileReader = new FileReader();
                                fileReader.onload = function(ev) {
                                    try {
                                        var data = ev.target.result
                                        var workbook = XLSX.read(data, {
                                                type: 'binary'
                                            }) // 以二进制流方式读取得到整份excel表格对象
                                        var persons = []; // 存储获取到的数据
                                    } catch (e) {
                                        console.log('文件类型不正确');
                                        return;
                                    }
                            
                                    // 表格的表格范围，可用于判断表头是否数量是否正确
                                    var fromTo = '';
                                    // 遍历每张表读取
                                    for (var sheet in workbook.Sheets) {
                                        if (workbook.Sheets.hasOwnProperty(sheet)) {
                                            fromTo = workbook.Sheets[sheet]['!ref'];
                                            console.log(fromTo);
                                            persons = persons.concat(XLSX.utils.sheet_to_json(workbook.Sheets[sheet]));
                                            // break; // 如果只取第一张表，就取消注释这行
                                        }
                                    }
                                    //在控制台打印出来表格中的数据
                                    console.log(persons);

                                // 吧数据渲染到表格里可查看可修改
                                $.each(persons, function (index, value) {
                                   var arr = {}
                                   var reg = /^[0-9]*$/;
                                   var re = /^\d{10}$/;

                                if(Object.keys(value).length !== 3) {
                                    layer.msg('<i class="layui-icon layui-icon-face-cry" style="font-size: 30px; color: #FF5722;"></i> 请检查表格列数!' ,{offset: '100px'})
                                    $('.goodsAppend2 tbody').empty()
                                    return false
                                }else if (Object.keys(value).indexOf('产品名') === -1 || Object.keys(value).indexOf('产品SKU') === -1 || Object.keys(value).indexOf('产品数目') === -1) {
                                    layer.msg('<i class="layui-icon layui-icon-face-cry" style="font-size: 30px; color: #FF5722;"></i> 请检查表头名称!' ,{offset: '100px'})
                                    $('.goodsAppend2 tbody').empty()
                                    return false
                                } else if (!reg.test(value['产品数目'])) {
                                    layer.msg('<i class="layui-icon layui-icon-face-cry" style="font-size: 30px; color: #FF5722;"></i> 产品数目必须为数字，请检查表格！' ,{offset: '100px'})
                                    $('.goodsAppend2 tbody').empty()
                                    return false
                                } else if (!re.test(value['产品SKU'])) {
                                    layer.msg('<i class="layui-icon layui-icon-face-cry" style="font-size: 30px; color: #FF5722;"></i> 产品sku必须为10位数字，请检查表格！' ,{offset: '100px'})
                                    $('.goodsAppend2 tbody').empty()
                                    return false
                                }

                                arr['goods_kind_name'] = value['产品名'];
                                arr['goods_sku'] = value['产品SKU'];
                                arr['num'] = value['产品数目'];
                                var getTpl = goodsAppend2.innerHTML
                                laytpl(getTpl).render(arr, function(string){
                                    $('.goodsAppend2 tbody').append(string)
                                })
                            })

                     // 表格提交
                    form.on('submit(formDemo2)', function(data){
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
                        if(arr.length === 0) {
                            layer.msg('<i class="layui-icon layui-icon-face-cry" style="font-size: 30px; color: #FF5722;"></i> 数据不能为空' ,{offset: '100px'})
                            return false
                        }
                        var index = layer.load();
                        // $.ajax({
                        //     url:"/admin/storage/list/add_storage_data_local",
                        //     type:'post',
                        //     data:{goods_attr:JSON.stringify(arr),storage_id:$('#storage_id').val()},
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

                               };
                               // 以二进制方式打开文件
                               fileReader.readAsBinaryString(files[0]);

                        });
                });

            </script>
@endsection