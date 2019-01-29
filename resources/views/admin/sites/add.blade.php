@extends('admin.father.css')
@section('content')
    <article class="page-container">
        <form class="form form-horizontal" id="form-role-update" enctype="multipart/form-data" action="{{url('admin/sites/add')}}" method="post">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>站点名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="role_name" name="role_name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>站点轮播图：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="file" id="size_file" class="input-text" value="" placeholder="" id="size_file" name="size_file" accept="image/png,image/gif,image/jpg,image/jpeg">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-2 col-sm-2"><span class="c-red">*</span>站点分类：</label>
                <div class="col-xs-10 col-sm-10">
                    @foreach($goods_type as $item)
                    <div style="margin-top: 10px">
                        <label>商品分类:</label> <input type="text" readonly style="width: 20%;vertical-align:middle; " class="input-text" value="{{$item->goods_type_name}}" placeholder="" id="goods_config">
                        <label>展示分类:</label> <input type="text" style="width: 20%;vertical-align:middle; " class="input-text" value="" placeholder="" id="goods_config" name="">
                        <label>排序:</label> <input type="text" style="width: 15%;vertical-align:middle; " class="input-text" value="0" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d{0,4})?.*$/,'$1');}).call(this)" onblur="this.v();"  id="goods_config" name="">
                        <input type="checkbox" id="config_isshow" class="price" name="" style="vertical-align:middle;cursor:pointer;" value="1"><label for="price">隐藏分类</label>
                    </div>
                    @endforeach
                    {{--<div style="margin-top: 10px">--}}
                        {{--<label>商品分类:</label> <input type="text" readonly style="width: 20%;vertical-align:middle; " class="input-text" value="" placeholder="" id="goods_config">--}}
                        {{--<label>展示分类:</label> <input type="text" style="width: 20%;vertical-align:middle; " class="input-text" value="" placeholder="" id="goods_config" name="">--}}
                        {{--<label>排序:</label> <input type="text" style="width: 15%;vertical-align:middle; " class="input-text" value="" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d*\.?\d{0,2})?.*$/,'$1');}).call(this)" onblur="this.v();"  id="goods_config" name="">--}}
                        {{--<input type="checkbox" id="config_isshow" class="price" name="" style="vertical-align:middle;" value="1"><label for="price">隐藏分类</label>--}}
                    {{--</div>--}}
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>特殊分类：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="role_name" name="role_name">
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
        $("#form-role-update").validate({
            rules:{
                role_name:{
                    required:true,
                },

            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                $(form).ajaxSubmit({
                    type: 'post',
                    url: "{{url('admin/sites/add')}}",
                    success: function(data){
                        if(data.err==1){
                            layer.msg('添加成功!',{time:2*1000},function() {
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
                    }});
                var index = parent.layer.getFrameIndex(window.name);
                //parent.$('.btn-refresh').click();
                /*parent.layer.close(index);*/
            }
        });
    </script>
@endsection