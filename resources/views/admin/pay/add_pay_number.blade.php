@extends('admin.father.css')
@section('content')
    <style>
        .content {
            padding-top:20px;
        }
        .content .neirong .row{
            margin-bottom:10px;
        }
        .content .neirong label{
            text-align:right;
            padding:0;
        }

    </style>
    <article class="content">
        <form class="form form-horizontal" id="spend-add" enctype="multipart/form-data" action="{{url('admin/pay/add_pay_number')}}" method="post">
            {{csrf_field()}}
            <div class="neirong">
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">投放平台：</label>
                    <div class="formControls col-xs-6 col-sm-4">
                        <div class="select-box" >
                            <select name="ad_platform" id="admin_name" class="select" >
                                <option value="1">雅虎</option>
                                <option value="2" >谷歌</option>
                                <option value="3" >FB</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">广告编号：</label>
                    <div class="formControls col-xs-6 col-sm-4">
                        <input type="text" class="input-text"  placeholder="" id="ad_number" name="ad_number">
                    </div>
                </div>
                <div class="row cl">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                        <button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont"></i> 提交</button>
                    </div>
                </div>
                <input type="hidden" id="spend_goods_id" name="ad_goods_id" value="{{$id}}">
            </div>
        </form>
    </article>

@section('js')
    <script>

        $(function(){
            var id = $('#spend_goods_id').val();
            $("#spend-add").validate({
                rules:{
                    ad_number:{
                        required:true,
                    }
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        type: 'post',
                        url: "{{url('admin/pay/add_pay_number')}}",
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
                        }
                    });
                }
            });
        })
    </script>
@endsection
