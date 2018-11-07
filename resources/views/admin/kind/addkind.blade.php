@extends('admin.father.css')
@section('content')
    <article class="page-container">
        {{--商品属性信息--}}
        <div class="config" style="display: none;" id="configclo">
            <div class="row" style="margin-left: 0px;">
                属性名: <input type="text" style="width: 25%;margin-top:10px;" class="input-text attribute" value="" placeholder="" id="goods_config_name" name="goods_config_name">
                <input type="text" style="width: 10%;margin-top:10px;display: none" class="input-text attribute" value="0" name="num">
            </div>
            <div class="con-value">
                <div class="row" style="height: 40px;" >
                    <div class="col-xs-8 col-sm-8" style="display: inline">
                        <label>属性值:</label> <input type="text" style="width: 70%;margin-top:10px; " class="input-text" value="" placeholder="" id="goods_config" name="goods_config">
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
                属性值: <input type="text" style="width: 70%;margin-top:10px; " class="input-text" value="" placeholder="" id="goods_config" name="goods_config[]">
            </div>
        </div>
        {{--新增产品form--}}
        <form class="form form-horizontal" id="form-goodskind-update" enctype="multipart/form-data" action="{{url('admin/goods/addgoods_kind')}}">
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
            <div class="row cl">
                <label for="goods_kind_name" class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>新增产品：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="goods_kind_name" name="goods_kind_name">
                </div>
            </div>
            <div class="row cl">
                <label for="goods_kind_name" class="form-label col-xs-4 col-sm-2">产品采购地址：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="goods_buy_url" name="goods_buy_url">
                </div>
            </div>
            <div class="row cl">
                <label for="goods_kind_name" class="form-label col-xs-4 col-sm-2">产品采购备注：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="goods_buy_msg" name="goods_buy_msg">
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
                                属性名: <input type="text" style="width: 25%;margin-top:10px;" class="input-text attribute" attr='goods_config_name[0][msg]' value="" placeholder="" id="goods_config_name" name="goods_config_name[0][goods_config_name]">
                                <input type="text" style="width: 10%;margin-top:10px;display: none" class="input-text attribute" value="0" name="num">
                            </div>
                            <div class="con-value">
                                <div class="row" style="height: 40px;" >
                                    <div class="col-xs-8 col-sm-8" style="display: inline">
                                        <label>属性值:</label> <input type="text" style="width: 70%;margin-top:10px; " class="input-text" value="" placeholder="" id="goods_config" name="goods_config_name[0][msg][0][goods_config]">
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

            configdiv.children('.row').find('input:first').attr('name','goods_config_name['+a+'][goods_config_name]');
            configdiv.children('.row').find('input').attr('attr','goods_config_name['+a+'][msg]');
            configdiv.children('div:last').children('.row').children('.col-sm-8').find('input:first').attr('name','goods_config_name['+a+']'+'[msg][0][goods_config]');
            $('#num').val(a);
            configdiv.show(200);
            $('#conhtml').append(configdiv);
        })

        //产品属性值删除
        $("#rmconfig").on('click',function(){
            if($('.config').length>1){
                $('.config').last().remove();
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
    </script>
@endsection