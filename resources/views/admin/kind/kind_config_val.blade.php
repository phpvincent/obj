    <article class="page-container" style="padding-top:0;">
        {{--商品属性信息--}}
        <div class="config" attr="newConfig" style="display: none;" id="configclo">
            <div class="row" style="margin-left: 0px;">
                属性名: <input type="text" style="width: 25%;margin-top:10px;" class="input-text attribute" value="" placeholder="" id="goods_config_name" name="goods_config_name">
                <input type="text" style="display: none" class="input-text attribute" value="0" name="num">
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
        <div class="row" attr="newConfig" style="height: 40px;display: none;" id="configclo-value">
            <div class="col-xs-8 col-sm-8" style="display: inline">
                属性值: <input type="text" style="width: 70%;margin-top:10px; " class="input-text" value="" placeholder="" id="goods_config" name="goods_config[]">
            </div>
        </div>
        {{--新增产品form--}}
        <form class="form form-horizontal" id="form-goodskind-add" method="post" enctype="multipart/form-data" action="{{url('admin/goods/kind_config_val')}}">
            {{csrf_field()}}
            <input type="text" style="display: none" id="name" name="name" value="1">
            <div class="row cl">
                <label for="goods_kind_name" style="text-align: left" class="form-label col-xs-4 col-sm-3">产品采购地址：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$goods_kinds->goods_buy_url}}" placeholder="" id="goods_buy_url" name="goods_buy_url">
                </div>
            </div>
            <div class="row cl">
                <label for="goods_kind_name" style="text-align: left" class="form-label col-xs-4 col-sm-3">产品采购备注：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$goods_kinds->goods_buy_msg}}" placeholder="" id="goods_buy_msg" name="goods_buy_msg">
                </div>
            </div>
            {{--隐藏产品名称--}}
             <div class="row cl">
                @if(\App\kind_config::where('kind_primary_id',$goods_kinds->goods_kind_id)->count()<=0)
                    <div class="formControls" style="margin-left: 2%;margin-right: 2%">
                        <input type="button" class="btn btn-default" value="移除产品附加属性" id="addcon" isalive='on'/>
                        <input class="btn btn-default" style="display: none" value="0" id="num"/>

                        <div style="margin:0px auto;border: 1px dashed #000;margin-top: 10px;border-radius: 3%;margin-left:0%; padding: 5px;padding-bottom: 10px;" id="conhtml">
                            <span class="btn btn-primary" title="添加" id="addconfig"><i class="Hui-iconfont">&#xe600;</i></span><span class="btn btn-primary" id="rmconfig" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span><br>
                            <div class="config" id="configclo">
                                <div class="row" style="margin-left: 0px;">
                                    属性名: <input type="text" style="width: 25%;margin-top:10px;" class="input-text attribute" attr='goods_config_name[0][msg]' value="" placeholder="" id="goods_config_name" name="goods_config_name[0][goods_config_name]">
                                    <input type="text" style="display: none" class="input-text attribute" value="0" name="num">
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
            @else
                {{--商品属性--}}
                <div class="formControls" style="margin-left: 2%;margin-right: 2%">
                    <label class="form-label col-xs-4 col-sm-2"> </label>
                    {{--<input type="button" class="btn btn-default" value="移除商品附带属性" id="addcon" isalive='on'/>--}}
                    <input class="btn btn-default" style="display: none" value="{{count($goods_config)}}" id="num"/>

                    <div style="margin:0px auto;border: 1px dashed #000;border-radius: 3%;  padding: 5px;padding-bottom: 10px;" id="conhtml">
                        <span class="btn btn-primary" title="添加" id="addconfig"><i class="Hui-iconfont">&#xe600;</i></span><span class="btn btn-primary" id="rmconfig" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span><br>
                        @foreach($goods_config as $k=>$v)
                            <div class="config">
                                <div class="row" style="margin-left: 0px;">
                                    <label for="goods_config_name">属性名:</label> <input type="text" style="width: 25%;margin-top:10px;" attr='goods_config_name[{{$k}}][msg]' class="input-text attribute" value="{{$v->kind_config_msg}}" placeholder="" id="goods_config_name" name="goods_config_name[{{$k}}][goods_config_name]">
                                    <input type="text" style="display: none" class="input-text attribute" value="{{$v->kind_config_id}}" name="goods_config_name[{{$k}}][id]">
                                    <input type="text" style="display: none" class="input-text attribute" value="{{count($v->config_msg)}}" name="num">
                                </div>
                                <div id="con-value">
                                    @if(count($v->config_msg) > 0)
                                        @foreach($v->config_msg as $key=>$item)
                                            <div class="row" style="height: 40px;" >
                                                <div class="col-xs-8 col-sm-8" style="display: inline">
                                                    <label>属性值:</label> <input type="text" style="width: 70%;margin-top:10px; " class="input-text" value="{{$item['kind_val_msg']}}" placeholder="" id="goods_config" name="goods_config_name[{{$k}}][msg][{{$key}}][goods_config]">
                                                    <input type="text" style="display: none " class="input-text" value="{{$item['kind_val_id']}}" name="goods_config_name[{{$k}}][msg][{{$key}}][id]">
                                                </div>
                                                @if($key == 0)
                                                    <div style="display: inline;">
                                                        <span class="btn btn-primary addconfig-value" style="margin-top:10px; " title="添加" onclick="addConfig(this)"><i class="Hui-iconfont">&#xe600;</i></span><span style="margin-top:10px; " class="btn btn-primary" onclick="rmConfig(this)" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <div id="con-value">
                                            <div class="row" style="height: 40px;" >
                                                <div class="col-xs-8 col-sm-8" style="display: inline">
                                                    <label>属性值:</label> <input type="text" style="width: 70%;margin-top:10px; " class="input-text attribute" value="" placeholder="" id="goods_config" name="goods_config[]">
                                                </div>
                                                <div style="display: inline;">
                                                    <span class="btn btn-primary" style="margin-top:10px; " title="添加"  onclick="addConfig(this)"><i class="Hui-iconfont">&#xe600;</i></span><span style="margin-top:10px; " class="btn btn-primary" onclick="rmConfig(this)" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span>
                                                </div>
                                            </div>
                                        </div>
                                @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
            </div>
            @endif
            </div>
            <div class="row cl">
                <input type="text" style="display: none" id="goods_kind_id" name="goods_kind_id" value="{{$goods_kinds->goods_kind_id}}">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <button class="btn btn-primary radius"><i class="Hui-iconfont">&#xe632;</i> 保存并提交</button>
                </div>
            </div>
        </form>
    </article>
    <script type="text/javascript">
        //点击添加商品附加属性
        $('#addcon').on('click',function(){
            var isalive=$(this).attr('isalive');
            if(isalive!='on'){
                $('#conhtml').show(300);
                $(this).val('移除产品附加属性');
                $(this).attr('isalive','on');
            }else{
                $('#conhtml').hide(300);
                while($('.config').length>1){
                    $('.config').last().remove();
                }
                $(this).val('添加产品附加属性');
                $(this).attr('isalive','off');
            }
        })

        // 点击添加属性名
        $('#addconfig').on('click',function(){
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
            if($('.config').length>1 && $('.config:last').attr('attr') == 'newConfig' ){
                $('.config').last().remove();
            }else{
                layer.msg('已保存产品属性，不可删除');
            }
        });

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
                if($(obj).parent().parent().parent().children("div.row:last").attr('attr') == 'newConfig'){
                    $(obj).parent().parent().parent().children("div.row:last").remove();
                }else{
                    layer.msg('已保存产品属性值，不可删除');
                }
            }else{
                layer.msg('如果想要删除，请通过虚线框内第一个减号进行删除');
            }
        }

        //表单验证、提交
        $("#form-goodskind-add").validate({
            rules:{
                name:{
                    required:true,
                }
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                $(form).ajaxSubmit({
                    type: 'post',
                    url: "{{url('admin/kind/post_update')}}",
                    success: function(data){
                        if(data.err==1){
                            layer.msg(data.msg,{time:2*1000},function() {
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
            }
        });
    </script>