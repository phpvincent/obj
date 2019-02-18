@extends('admin.father.css')
@section('content')
    <article class="page-container">
        {{--商品属性信息--}}
        <div class="config" style="display: none;" id="configclo">
            <div class="row" style="margin-left: 0px;">
                属性名: <input type="text" style="width: 25%;margin-top:10px;" class="input-text attribute" value="" placeholder="" id="goods_config_name" name="goods_config_name">
                英文属性名: <input type="text" style="width: 25%;margin-top:10px;" class="input-text attribute" value="" placeholder="" id="goods_config_english_name" name="goods_config_english_name">
                <input type="text" style="width: 10%;margin-top:10px;display: none" class="input-text attribute" value="0" name="num">
            </div>
            <div class="con-value">
                <div class="row" style="height: 40px;" >
                    <div class="col-xs-8 col-sm-8" style="display: inline">
                        <label>属性值:</label> <input type="text" style="width: 26%;margin-top:10px; " class="input-text sexi" value="" placeholder="" id="goods_config" name="goods_config">
                        <label>英文属性值:</label> <input type="text" style="width: 26%;margin-top:10px; " class="input-text" value="" placeholder="" id="goods_config_english" name="goods_config_english">
                        <label>色系:</label> <input type="text" style="width: 26%;margin-top:10px; " class="input-text" value="" placeholder="" id="goods_config_english" name="goods_config_english">
                    </div>
                    <div style="display: inline;">
                        <span class="btn btn-primary" style="margin-top:10px; " title="添加"  onclick="addConfig(this)"><i class="Hui-iconfont">&#xe600;</i></span><span style="margin-top:10px; " class="btn btn-primary" onclick="rmConfig(this)" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span>
                    </div>
                </div>
            </div>
        </div>
        {{--商品属性值--}}
        <div class="row" style="height: 40px;display: none;" id="configclo-value">
            <div class="col-xs-8 col-sm-8" style="display: inline">
                属性值: <input type="text" style="width: 40%;margin-top:10px; " class="input-text sexi" value="" placeholder="" id="goods_config" name="goods_config[]">
                英文属性值: <input type="text" style="width: 40%;margin-top:10px; " class="input-text" value="" placeholder="" id="goods_config_english" name="goods_config[]">
                英文属性值: <input type="text" style="width: 40%;margin-top:10px; " class="input-text" value="" placeholder="" id="goods_config_english" name="goods_config[]">
            </div>
        </div>
        {{--新增产品form--}}
        <form class="form form-horizontal" id="form-goodskind-update" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">已有产品(所属单品数)：</label>
                <div class="formControls col-xs-8 col-sm-9">
			 <span class="select-box">
				<select name="goods_type_chose" id="goods_type_chose" class="select">
					@foreach($goods_kinds as $k => $v)
                        <option @if($v->goods_kind_id == $id) selected @endif>{{$v->goods_kind_name}}</option>
                    @endforeach
				</select>
			</span>
                </div>
            </div>
            <br>
            <hr>

            <div class="row cl">
                <label for="goods_kind_name" class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>新增产品名：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="goods_kind_name" name="goods_kind_name">
                </div>
            </div>
            <div class="row cl">
                <label for="goods_kind_english_name" class="form-label col-xs-4 col-sm-2">产品英文名：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="goods_kind_english_name" name="goods_kind_english_name">
                </div>
            </div>
            <div class="row cl">
                <label for="goods_kind_img" class="form-label col-xs-4 col-sm-2">产品图片：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="file" class="input-text" value="" placeholder="" id="goods_kind_img" name="goods_kind_img">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">所属种类：</label>
                <div class="formControls col-xs-8 col-sm-9">
             <span class="select-box">
                <select name="product_type_id" id="product_type_id" class="select">
                    @foreach(\App\product_type::get() as $k => $v)
                        <option value="{{$v->product_type_id}}">{{$v->product_type_name}}</option>
                    @endforeach
                </select>
            </span>
                </div>
            </div>
            <div class="row cl">
                <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2">产品重量（单位：kg）：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="0" placeholder="" id="goods_buy_weight" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d*\.?\d{0,3})?.*$/,'$1');}).call(this)" onblur="this.v();"   name="goods_buy_weight">
                </div>
            </div>
            <div class="row cl">
                <label for="goods_kind_volume" class="form-label col-xs-4 col-sm-2">产品体积（单位：cm）：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" style="width: 80px;" value="0" placeholder="" id="width" name="width" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d*\.?\d{0,3})?.*$/,'$1');}).call(this)" onblur="this.v();">cm
                    <input type="text" class="input-text" style="width: 80px;" value="0" placeholder="" id="depth" name="depth" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d*\.?\d{0,3})?.*$/,'$1');}).call(this)" onblur="this.v();">cm
                    <input type="text" class="input-text" style="width: 80px;" value="0" placeholder="" id="height" name="height" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d*\.?\d{0,3})?.*$/,'$1');}).call(this)" onblur="this.v();">cm
                </div>
            </div>
            <div class="row cl">
                <label for="goods_kind_postage" class="form-label col-xs-4 col-sm-2">邮费（单位：元）：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="0" placeholder="" id="goods_kind_postage" name="goods_kind_postage" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d*\.?\d{0,3})?.*$/,'$1');}).call(this)" onblur="this.v();">
                </div>
            </div>
            {{--<div class="row cl">--}}
            {{--<label for="goods_kind_url" class="form-label col-xs-4 col-sm-2">产品采购地址：</label>--}}
            {{--<div class="formControls col-xs-8 col-sm-9">--}}
            {{--<input type="text" class="input-text" value="" placeholder="" id="goods_buy_url" name="goods_buy_url">--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="row cl">--}}
            {{--<label for="goods_kind_name" class="form-label col-xs-4 col-sm-2">产品采购备注：</label>--}}
            {{--<div class="formControls col-xs-8 col-sm-9">--}}
            {{--<input type="text" class="input-text" value="" placeholder="" id="goods_buy_msg" name="goods_buy_msg">--}}
            {{--</div>--}}
            {{--</div>--}}
            <div class="row cl">
                <label for="supplier_url" class="form-label col-xs-4 col-sm-2" >供货商地址（链接）：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="supplier_url" name="supplier_url">
                </div>
            </div>
            <div class="row cl">
                <label for="supplier_contact" class="form-label col-xs-4 col-sm-2" >供货商联系人：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="supplier_contact" name="supplier_contact">
                </div>
            </div>
            <div class="row cl">
                <label for="supplier_tel" class="form-label col-xs-4 col-sm-2" >供货商电话：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="supplier_tel" name="supplier_tel">
                </div>
            </div>
            <div class="row cl">
                <label for="supplier_price" class="form-label col-xs-4 col-sm-2" >供货商单价：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="0" placeholder="" id="supplier_price" name="supplier_price" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d*\.?\d{0,3})?.*$/,'$1');}).call(this)" onblur="this.v();">
                </div>
            </div>
            <div class="row cl">
                <label for="supplier_num" class="form-label col-xs-4 col-sm-2" >供货商日供货量：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="0" placeholder="" id="supplier_num" name="supplier_num" onkeyup="(this.v=function(){this.value=this.value.replace(/[^\d]/g,'');})" onblur="this.v();">
                </div>
            </div>
            <div class="row cl">
                <label for="supplier_is_spots" class="form-label col-xs-4 col-sm-2" >供货商是否现货：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="radio" value="1" placeholder="" id="supplier_is_spots" name="supplier_is_spots" checked> 是
                    <input type="radio" value="0" placeholder="" id="supplier_is_spots" name="supplier_is_spots" > 否
                </div>
            </div>
            <div class="row cl">
                <label for="supplier_remark" class="form-label col-xs-4 col-sm-2" >供货商备注信息：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="supplier_remark" name="supplier_remark">
                </div>
            </div>
            <div class="row cl">
                <label for="spare_supplier_url" class="form-label col-xs-4 col-sm-2" >备用供货商地址（链接）：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="spare_supplier_url" name="spare_supplier_url">
                </div>
            </div>
            <div class="row cl">
                <label for="spare_supplier_contact" class="form-label col-xs-4 col-sm-2" >备用供货商联系人：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="spare_supplier_contact" name="spare_supplier_contact">
                </div>
            </div>
            <div class="row cl">
                <label for="spare_supplier_tel" class="form-label col-xs-4 col-sm-2" >备用供货商电话：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="spare_supplier_tel" name="spare_supplier_tel">
                </div>
            </div>
            <div class="row cl">
                <label for="spare_supplier_price" class="form-label col-xs-4 col-sm-2" >备用供货商单价：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="0" placeholder="" id="spare_supplier_price" name="spare_supplier_price" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d*\.?\d{0,3})?.*$/,'$1');}).call(this)" onblur="this.v();">
                </div>
            </div>
            <div class="row cl">
                <label for="spare_supplier_num" class="form-label col-xs-4 col-sm-2" >备用供货商日供货量：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="0" placeholder="" id="spare_supplier_num" name="spare_supplier_num" onkeyup="(this.v=function(){this.value=this.value.replace(/[^\d]/g,'');})" onblur="this.v();">
                </div>
            </div>
            <div class="row cl">
                <label for="spare_supplier_is_spots" class="form-label col-xs-4 col-sm-2" >备用供货商是否现货：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="radio" value="1" placeholder="" id="spare_supplier_is_spots" name="spare_supplier_is_spots" checked> 是
                    <input type="radio" value="0" placeholder="" id="spare_supplier_is_spots" name="spare_supplier_is_spots"> 否
                </div>
            </div>
            <div class="row cl">
                <label for="spare_supplier_remark" class="form-label col-xs-4 col-sm-2" >备用供货商备注信息：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="spare_supplier_remark" name="spare_supplier_remark">
                </div>
            </div>
            <div class="row cl">
                <div class="formControls" style="margin-left: 2%;margin-right: 2%">
                    <input type="button" class="btn btn-default" value="移除产品附加属性" id="addcon" isalive='on'/>
                    <input type="button" class="btn btn-default" style="display: none" value="0" id="num"/>

                    <div style="margin:0px auto;border: 1px dashed #000;margin-top: 10px;border-radius: 3%;margin-left:0%; padding: 5px;padding-bottom: 10px;" id="conhtml">
                        <span class="btn btn-primary" title="添加" id="addconfig"><i class="Hui-iconfont">&#xe600;</i></span><span class="btn btn-primary" id="rmconfig" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span><br>
                        <div class="config" id="configclo">
                            <div class="row" style="margin-left: 0px;">
                                属性名: <input type="text" style="width: 25%;margin-top:10px;" class="input-text attribute" attr='goods_config_name[0][msg]' value="颜色" placeholder="" id="goods_config_name" name="goods_config_name[0][goods_config_name]">
                                英文属性名: <input type="text" style="width: 25%;margin-top:10px;" class="input-text attribute" attr='goods_config_name[0][msg]' value="color" placeholder="" id="goods_config_english_name" name="goods_config_name[0][goods_config_english_name]">
                                <input type="text" style="width: 10%;margin-top:10px;display: none" class="input-text attribute" value="0" name="num">
                            </div>
                            <div class="con-value">
                                <div class="row" style="height: 40px;" >
                                    <div class="col-xs-8 col-sm-8" style="display: inline">
                                        <label>属性值:</label> <input type="text" style="width: 26%;margin-top:10px; " class="input-text sexi" value="" placeholder="" id="goods_config" name="goods_config_name[0][msg][0][goods_config]">
                                        <label>英文属性值:</label> <input type="text" style="width: 26%;margin-top:10px; " class="input-text" value="" placeholder="" id="goods_config_english" name="goods_config_name[0][msg][0][goods_config_english]">
                                        <label>色系:</label> 
                                        <select name="goods_type_chose" id="sexi"style="width: 26%;height: 30px; " class="select">
                                                <option value="">选择色系</option>
                                                <option value="00">黑色</option>
                                                <option value="10">灰色</option>
                                                <option value="20">蓝色</option>
                                                <option value="30">绿色</option>
                                                <option value="40">棕色</option>
                                                <option value="50">红色</option>
                                                <option value="60">紫色</option>
                                                <option value="70">黄色</option>
                                                <option value="80">白色</option>
                                                <option value="90">混色色</option>
                                        </select>
                                    </div>
                                    <div style="display: inline;">
                                        <span class="btn btn-primary" style="margin-top:10px; " title="添加"  onclick="addConfig(this)"><i class="Hui-iconfont">&#xe600;</i></span><span style="margin-top:10px; " class="btn btn-primary" onclick="rmConfig(this)" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <button  class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交</button>
                </div>
            </div>
        </form>
    </article>
@endsection
@section('js')
    <script type="text/javascript">
        //点击添加商品附加属性
        $('#addcon').on('click',function(){
            var isalive=$(this).attr('isalive');
            if(isalive!='on'){
                $('#conhtml').show(300);
                $(this).val('移除商品附加属性');
                $(this).attr('isalive','on');
            }else{
                $('#conhtml').hide(300);
                while($('.config').length>1){
                    $('.config').last().remove();
                }
                $(this).val('添加商品附加属性');
                $(this).attr('isalive','off');
            }
        })

        // 点击添加属性名
        $('#addconfig').on('click',function(){
            //var configdiv=$(this).next().next().next('div').clone();
            var configdiv=$('#configclo').clone();
            //属性名键值
            var a = $('#num').val();
            a++;

            if (a == 0) {
                configdiv.children('.row').find('input:first').attr('name','goods_config_name['+a+'][goods_config_name]');
                configdiv.children('.row').find('input').eq(1).attr('name','goods_config_name['+a+'][goods_config_english_name]');
                configdiv.children('.row').find('input:first').val('颜色');
                configdiv.children('.row').find('input').eq(1).val('color');
            } else if(a == 1) {
                configdiv.children('.row').find('input:first').attr('name','goods_config_name['+a+'][goods_config_name]');
                configdiv.children('.row').find('input').eq(1).attr('name','goods_config_name['+a+'][goods_config_english_name]');
                configdiv.children('.row').find('input:first').val('尺码');
                configdiv.children('.row').find('input').eq(1).val('size');
            } else {
                configdiv.children('.row').find('input:first').attr('name','goods_config_name['+a+'][goods_config_name]');
                configdiv.children('.row').find('input').eq(1).attr('name','goods_config_name['+a+'][goods_config_english_name]');
            }
            configdiv.children('.row').find('input').attr('attr','goods_config_name['+a+'][msg]');
            configdiv.children('div:last').children('.row').children('.col-sm-8').find('input:first').attr('name','goods_config_name['+a+']'+'[msg][0][goods_config]');
            configdiv.children('div:last').children('.row').children('.col-sm-8').find('input').eq(1).attr('name','goods_config_name['+a+']'+'[msg][0][goods_config_english]');
            $('#num').val(a);
            configdiv.show(200);
            $('#conhtml').append(configdiv);
        })

        //产品属性值删除
        $("#rmconfig").on('click',function(){
            if($('.config').length>1){
                $('.config').last().remove();
                var a = $('#num').val();
                a--;
                $('#num').val(a);
            }
        })

        // 新增属性
        function addConfig(obj){
            var configdiv=$('#configclo-value').clone();
            //属性值键值
            var k = $(obj).parent().parent().parent().prev().find('input:last').val();
            //属性值名称
            k++;
            var msg = $(obj).parent().parent().parent().prev().find('input:first').attr('attr');
            configdiv.children('.col-sm-8').find('input:first').attr('name',msg+'['+k+']'+'[goods_config]');
            configdiv.children('.col-sm-8').find('input').eq(1).attr('name',msg+'['+k+']'+'[goods_config_english]');
            configdiv.show(200);
            $(obj).parent().parent().parent().prev().find('input:last').val(k);
            $(obj).parent().parent().parent().append(configdiv);
        }

        // 删除属性(控制原有数据不可删除)
        function rmConfig(obj){
            if($(obj).parent().parent().parent().children("div.row").length>1){
                $(obj).parent().parent().parent().children("div.row:last").remove();
            }else{
                layer.msg('如果想要删除，请通过虚线框内第一个减号进行删除');
            }
        }

        //表单验证、提交
        $("#form-goodskind-update").validate({
            rules:{
                goods_type_name:{
                    required:true,
                },
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                $(form).ajaxSubmit({
                    type: 'post',
                    url: "{{url('admin/kind/addkind')}}",
                    success: function(data){
                        if(data.err==1){
                            layer.msg('添加成功!',{time:2*1000},function() {
                                //回调
                                index = parent.layer.getFrameIndex(window.name);
                                setTimeout("parent.layer.close(index);",2000);
                                window.parent.location.reload();
                            });
                        }else{
                            layer.msg(data.msg);
                        }
                    },
                    error: function(XmlHttpRequest, textStatus, errorThrown){
                        layer.msg('error!');
                    }});
                //var index1 = parent.layer.getFrameIndex(window.name);
                //parent.$('.btn-refresh').click();
                /*parent.layer.close(index);*/
            }
        });
        $('body').on('input propertychange','.sexi',function(){
            var arr=$(this).val();
            if(arr.length==0){
                $("#sexi").val("")
            }
            var aa = false;
            for (let i = 0; i < arr.length; i++) {
                var a=arr.substr(i,1)
                switch (a){
                    case "黑":
                    $("#sexi").val("00")
                    aa=true
                        break;
                    case "灰":
                    $("#sexi").val("10")
                    aa=true
                        break;
                    case "蓝":
                    $("#sexi").val("20")
                    aa=true
                        break;
                    case "绿":
                    $("#sexi").val("30")
                    aa=true
                        break;
                    case "棕":
                    $("#sexi").val("40")
                    aa=true
                        break;
                    case "红":
                    $("#sexi").val("50")
                    aa=true
                        break;
                    case "紫":
                    $("#sexi").val("60")
                    aa=true
                        break;
                    case "黄":
                    $("#sexi").val("70")
                    aa=true
                        break;
                    case "白":
                    $("#sexi").val("80")
                    aa=true
                        break;
                    case "混":
                    $("#sexi").val("90")
                    aa=true
                        break;
                    default:
                    $("#sexi").val("")
                }
                if(aa){
                    break;
                }
                
            }
        })
    </script>
@endsection