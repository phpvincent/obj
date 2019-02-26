@extends('admin.father.css')
@section('content')
    <article class="page-container">
        <form class="form form-horizontal" id="form-goods-update" enctype="multipart/form-data" action="{{url('admin/goods/copy_goods')}}">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>站点名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="sites_name" name="sites_name">
                    <input type="text" class="input-text" style="display: none" value="{{$site->sites_id}}" placeholder="" id="sites_id" name="id">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>站点模板类型：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box">
                        <select name="site_blade_type" id="site_blade_type" class="select" >
                            <option disabled="disabled"  value="0" @if($site->site_blade_type==0) selected="selected" @endif>0--台湾模板</option>
							<option disabled="disabled"  value="1" @if($site->site_blade_type==1) selected="selected" @endif>1--简体模板</option>
							<option disabled="disabled"  value="2" @if($site->site_blade_type==2) selected="selected" @endif>2--阿联酋模板</option>
							<option disabled="disabled"  value="3" @if($site->site_blade_type==3) selected="selected" @endif>3--马来西亚模板</option>
							<option disabled="disabled"  value="4" @if($site->site_blade_type==4) selected="selected" @endif>4--泰国模板（旧版）</option>
							<option disabled="disabled"  value="5" @if($site->site_blade_type==5) selected="selected" @endif>5--日本模板（旧版）</option>
							<option disabled="disabled"  value="6" @if($site->site_blade_type==6) selected="selected" @endif>6--印度尼西亚</option>
							<option disabled="disabled"  value="7" @if($site->site_blade_type==7) selected="selected" @endif>7--菲律宾</option>
							<option disabled="disabled"  value="8" @if($site->site_blade_type==8) selected="selected" @endif>8--英国（旧版）</option>
							<option  disabled="disabled" value="9" @if($site->site_blade_type==9) selected="selected" @endif>9--Google-PC（旧版）</option>
							<option  disabled="disabled" value="10" @if($site->site_blade_type==10) selected="selected" @endif>10--美国（旧版）</option>
							<option  disabled="disabled" value="11" @if($site->site_blade_type==11) selected="selected" @endif>11--越南（旧版）</option>
							<option  disabled="disabled" value="12" @if($site->site_blade_type==12) selected="selected" @endif>12--沙特</option>
							<option  disabled="disabled" value="13" @if($site->site_blade_type==13) selected="selected" @endif>13--沙特英文</option>						
							<option  disabled="disabled" value="14" @if($site->site_blade_type==14) selected="selected" @endif>14--卡塔尔</option>
							<option disabled="disabled"  value="15" @if($site->site_blade_type==15) selected="selected" @endif>15--卡塔尔英文</option>
							<option disabled="disabled"  value="16" @if($site->site_blade_type==16) selected="selected" @endif>16--中东阿语</option>
							<option disabled="disabled"  value="17" @if($site->site_blade_type==17) selected="selected" @endif>17--中东英语</option>
                        </select>
					</span>
                </div>
            </div>
            @if(Auth::user()->is_root == '1')
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>站点所属人：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box">
                        <select name="site_admin" id="site_admin" class="select">
                            @foreach(\App\admin::where('admin_use',1)->get() as $item)
                                <option value="{{$item->admin_id}}" @if(Auth::user()->is_root != '1') disabled="disabled" @endif @if($site->sites_admin_id==$item->admin_id) selected="selected" @endif>{{$item->admin_show_name ? $item->admin_show_name : $item->admin_name}}</option>
                            @endforeach
                        </select>
					</span>
                </div>
              </div>
			 @endif
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
                    url: "{{url('admin/sites/site_copy')}}",
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