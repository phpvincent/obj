@extends('admin.father.css')
@section('content')
    <article class="page-container" style="padding-top:0;">
        <div style="margin-top: 10px;font-weight: bold">产品名称：{{\App\goods_kind::where('goods_kind_id',$kind_id)->value('goods_kind_name')}}</div>
        {{--新增产品form--}}
        <form class="form form-horizontal" id="form-goodskind-add" method="post" enctype="multipart/form-data" action="{{url('admin/goods/kind_config_val')}}">
            {{csrf_field()}}
            <input type="text" style="display: none" id="name" name="id" value="{{$id}}">
            {{--隐藏产品名称--}}
            <div class="row cl">
                @if(count($goods_config)<=0)
                <div style="margin: 0 auto;color: red;width: 40%">暂无产品属性，请先添加产品属性</div>
                <div style="margin: 0 auto;width: 40%">
                    <input type="button" style="width: 70%;" onclick="addCon({{$kind_id}})" class="btn btn-default" value="添加产品属性" id="addcon"/>
                </div>
                @else
                    {{--商品属性--}}
                    <div class="clearfix" style="margin-left: 2%">
                        <label class="form-label col-xs-4 col-sm-2"> </label>
                        <input type="button" class="btn btn-default" style="display: none" value="{{count($goods_config)}}" id="num"/>
                    </div>

                    <div style="margin:0px auto;border: 1px dashed #000;border-radius: 3%; width: 88%; padding: 32px;padding-top: 0px;position: relative;margin-bottom: 60px" id="conhtml">
                        @foreach($goods_config as $k=>$v)
                            <div class="config">
                                <div class="row" style="margin-left: 0px;">
                                    <label for="kind_config_name" style="font-weight: bold;color: #D43">属性名:</label> <input type="text" readonly style="width: 10%;margin-top:10px;" attr='goods_config_name[{{$k}}][msg]' class="input-text attribute" value="{{$v->kind_config_msg}}" placeholder="" id="goods_config_name">
                                    <label for="goods_config_name" style="font-weight: bold;color: #D43">展示名:</label> <input type="text" style="width: 10%;margin-top:10px;" class="input-text attribute" value="{{$v->goods_config_msg}}" placeholder="" id="goods_config_name" name="goods_config_name[{{$k}}][goods_config_name]">
                                    <input type="text" style="display: none" class="input-text attribute" value="{{$v->goods_config_id}}" name="goods_config_name[{{$k}}][id]">
                                    <input type="text" style="display: none" class="input-text attribute" value="{{$v->kind_config_id}}" name="goods_config_name[{{$k}}][kind_config_id]">
                                    <input type="text" style="display: none" class="input-text attribute" value="{{count($v->config_msg)}}" name="num">
                                </div>
                                <div id="con-value">
                                    @if(count($v->config_msg) > 0)
                                        @foreach($v->config_msg as $key=>$item)
                                            <div class="row" style="height: 40px;" >
                                                <div class="col-xs-9 col-sm-9" style="display: inline">
                                                    <label>属性值:</label> <input type="text" readonly style="width: 20%;margin-top:10px; " class="input-text" value="{{$item['kind_val_msg']}}" placeholder="" id="goods_config">
                                                    <label>展示值:</label> <input type="text" style="width: 20%;margin-top:10px; " class="input-text" value="{{$item['config_val_msg']}}" placeholder="" id="goods_config" name="goods_config_name[{{$k}}][msg][{{$key}}][goods_config]">
                                                    <label>差额:</label> <input type="text" style="width: 15%;margin-top:10px; " class="input-text" value="{{$item['config_diff_price']}}" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([1-9]\d*\.?\d{0,2})?.*$/,'$1');}).call(this)" onblur="this.v();"  id="goods_config" name="goods_config_name[{{$k}}][msg][{{$key}}][config_diff_price]">
                                                    <input type="checkbox" id="config_isshow" class="price" @if($item['config_isshow']==1) checked="checked" @endif name="goods_config_name[{{$k}}][msg][{{$key}}][config_isshow]" value="1"><label for="price">隐藏属性</label>
                                                    <input type="text" style="display: none " class="input-text" value="{{$item['config_val_id']}}" name="goods_config_name[{{$k}}][msg][{{$key}}][id]">
                                                    <input type="text" style="display: none " class="input-text" value="{{$item['kind_val_id']}}" name="goods_config_name[{{$k}}][msg][{{$key}}][kind_val_id]">
                                                </div>
                                                <div class="formControls col-xs-3 col-sm-3" style="display: inline;">
                                                    <div class="uploader-thum-container">
                                                        <input type="file" name="goods_config_name[{{$k}}][msg][{{$key}}][config_imgs]" width="420" height="280" style="margin-top: 15px;" multiple="multiple"	accept="image/png,image/gif,image/jpg,image/jpeg">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div id="con-value">
                                            <div class="row" style="height: 40px;" >
                                                <div class="col-xs-4 col-sm-4" style="display: inline">
                                                    <label>属性值:</label> <input type="text" style="width: 60%;margin-top:10px; " class="input-text attribute" value="" placeholder="" id="goods_config" name="goods_config[]">
                                                </div>
                                                <div class="formControls col-xs-3 col-sm-3" style="display: inline;">
                                                    <div class="uploader-thum-container">
                                                        <input type="file" name="config_imgs[]" onclick="uploadFile(this)" width="420" height="280" style="margin-top: 15px;" multiple="multiple"	accept="image/png,image/gif,image/jpg,image/jpeg">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                @endif
                            </div>
                    @endforeach
                    </div>
                @endif
            </div>
            <div class="row cl" style="margin-top: 10px;position: absolute;bottom: -50px">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <button class="btn btn-primary radius"><i class="Hui-iconfont">&#xe632;</i> 保存并提交</button>
                </div>
            </div>
        </form>
    </article>
@endsection
@section('js')
    <script type="text/javascript">
        //添加产品属性
        function addCon(a)
        {
            var url = '/admin/kind/upgoods_kind?id='+a;
            window.location.href = url;
            // layer_show('新增产品属性',url,'600','500');
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
                    url: "{{url('admin/goods/attr')}}",
                    success: function(data){
                        if(data.err==1){
                            layer.msg(data.str,{time:2*1000},function() {
                                //回调
                                index = parent.layer.getFrameIndex(window.name);
                                setTimeout("parent.layer.close(index);",2000);
                                window.parent.location.reload();
                            });
                        }else{
                            layer.msg(data.str);
                        }
                    },
                    error: function(XmlHttpRequest, textStatus, errorThrown){
                        layer.msg('error!');
                    }
                });
            }
        });
    </script>
@endsection