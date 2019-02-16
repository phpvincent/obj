@extends('admin.father.css')
@section('content')
    <article class="page-container">
        <form class="form form-horizontal" id="form-goods-update" enctype="multipart/form-data" action="{{url('admin/goods/copy_goods')}}">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>单商品名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="goods_price" name="goods_name">
                    <input type="text" class="input-text" style="display: none" value="{{$goods->goods_id}}" placeholder="" id="goods_price" name="id">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>支付方式：</label>
                <div class="check-box formControls col-xs-8 col-sm-9 conter_nav">
                    <label for="delivery">货到付款</label>
                    <input type="checkbox" id="pay_type" @if(in_array('0',$goods->goods_pay_type)) checked="checked"  @endif  name="pay_type[]" value="0">
                    <label for="pay_type">paypal支付</label>
                    <input type="checkbox" id="pay_type" @if(in_array('1',$goods->goods_pay_type)) checked="checked"  @endif  name="pay_type[]" value="1">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>货币类型：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
					<select name="currency_type" id="currency_type" class="select">
						@foreach($currency_type as $item)
                            <option value="{{$item->currency_type_id}}" {{$item->currency_type_id == $goods->goods_currency_id ? 'selected' : '' }} >{{$item->currency_type_name}}</option>
                        @endforeach
					</select>
					</span> </div>
            </div>
            @if(Auth::user()->is_root == '1')
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品所属人：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box">
                        <select name="goods_admin_id" id="goods_admin_id" class="select">
                            @foreach($admin as $item)
                                <option value="{{$item->admin_id}}">{{$item->admin_show_name ? $item->admin_show_name : $item->admin_name}}</option>
                            @endforeach
                        </select>
					</span>
                </div>
            </div>
            @endif
             <div class="row cl">
                <div class="clearfix">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>是否附带复制评论：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="check-box">
                        是 <input type="radio" id="copy_com" class="is_nav" name="copy_com" checked="checked" value="1">
                        否 <input type="radio" id="copy_com" class="is_nav" name="copy_com"  value="0">
                        <label for="checkbox-pinglun">&nbsp;</label>
                    </div>
                </div>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <button  class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 提交</button>
                </div>
            </div>
        </form>
    </article>
@endsection
@section('js')
    <script type="text/javascript">
        function pay_type(){
            $('#pay_type').rules('add', {
                required:true
            });

        }
        $(function () {
            //在线支付
            pay_type();
        });
        var rules = {
                goods_name: {
                    required: true,
                }
            };
        //表单验证
        $("#form-goods-update").validate({
            rules: rules,
            onkeyup: false,
            focusCleanup: true,
            success: "valid",
            submitHandler: function (form) {
                $(form).ajaxSubmit({
                    type: 'post',
                    url: "{{url('admin/goods/copy_goods')}}",
                    success: function (data) {
                        if(data.err==1){
                            layer.msg('复制成功!',{time:2*1000},function() {
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
                   var index = parent.layer.getFrameIndex(window.name);
            }
        })
    </script>
@endsection