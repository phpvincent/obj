@extends('admin.father.css')
<link rel="stylesheet" type="text/css" href="{{asset('/css/addgoods.css')}}" />
@section('content')
<article class="page-container">
	<div class="clearfix">
	</div>
	<form class="form form-horizontal " id="form-orders-update" enctype="multipart/form-data" action="{{url('admin/order/update')}}">
		<p style="color:red;width:100%;text-align: center;">* 为必填项！</p>
		{{csrf_field()}}
		<div class="row cl" style="border:0px">
			<div class="clearfix" style="margin: 0px">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>订单编号：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="{{$order->order_single_id}}" placeholder="" id="order_single_id" disabled="disabled">
				</div>
			</div>
        </div>
		<div class="row cl" style="border:0px">
			<div class="clearfix" style="margin: 0px">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>订单IP：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="{{$order->order_ip}}" placeholder="" id="order_ip" disabled="disabled">
				</div>
			</div>
		</div>
		<div class="row cl" style="border:0px">
			<div class="clearfix" style="margin: 0px">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>订单金额：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="{{ $order->order_currency }}{{$order->order_price}}" placeholder="" id="order_price" disabled="disabled" style="width: 200px">
				</div>
			</div>
		</div>
		<div class="row cl" style="border:0px">
			<div class="clearfix" style="margin: 0px">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>支付方式：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="@if($order->order_pay_type == 0) 货到付款 @else 在线支付 @endif" placeholder="" id="order_pay_type" disabled="disabled">
				</div>
			</div>

		</div>
		<div class="row cl" style="border:0px">
			<div class="clearfix" style="margin: 0px">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>订单状态：</label>
				<div class="formControls col-xs-8 col-sm-9">
					@switch($order->order_type)
						@case(0)
							<input type="text" class="input-text" value="未审核"  id="order_type" disabled="disabled">
							@break
						@case(1)
							<input type="text" class="input-text"value="通过核审"  id="order_type" disabled="disabled">
							@break
						@case(2)
							<input type="text" class="input-text"value="拒绝核审"  id="order_type" disabled="disabled">
							@break
						@case(3)
							<input type="text" class="input-text"value="已发货"  id="order_type" disabled="disabled">
							@break
						@case(4)
							<input type="text" class="input-text"value="已签收"  id="order_type" disabled="disabled">
							@break
						@case(5)
							<input type="text" class="input-text"value="退货未退款"  id="order_type" disabled="disabled">
							@break
						@case(6)
							<input type="text" class="input-text"value="退货并已退款"  id="order_type" disabled="disabled">
							@break
						@case(7)
							<input type="text" class="input-text"value="未退货已退款"  id="order_type" disabled="disabled">
							@break
						@case(8)
							<input type="text" class="input-text"value="拒签"  id="order_type" disabled="disabled">
							@break
						@case(9)
							<input type="text" class="input-text"value="预支付"  id="order_type" disabled="disabled">
							@break
						@case(10)
							<input type="text" class="input-text"value="取消支付"  id="order_type" disabled="disabled">
							@break
						@case(11)
							<input type="text" class="input-text"value="支付成功"  id="order_type" disabled="disabled">
							@break
						@case(12)
							<input type="text" class="input-text"value="支付失败"  id="order_type" disabled="disabled">
							@break
						@case(13)
							<input type="text" class="input-text"value="支付成功但无paypal数据"  id="order_type" disabled="disabled">
							@break
						@case(14)
							<input type="text" class="input-text"value="问题订单"  id="order_type" disabled="disabled">
							@break
						@default
						<input type="text" class="input-text" value="" id="order_type" disabled="disabled">
					@endswitch
				</div>
			</div>
		</div>
		<div class="row cl" style="border:0px">
			<div class="clearfix" style="margin: 0px">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>单品信息：</label>
				<div class="formControls col-xs-8 col-sm-9">
					单品名称：<input type="text" class="input-text" value="{{$goods->goods_name}}" id="goods_name" disabled>
					单品数量：<input type="text" class="input-text" value="{{$order->order_num}}" id="order_num" disabled>
					促销信息：<input type="text" class="input-text" value="{{ $order->order_cuxiao_id }}" id="order_cuxiao_id" disabled>
					@if($order->order_config)
					@foreach($order->order_config as $config_id=>$config)
						属性信息：@foreach ($goods->attrs as $key_attr => $attr)
							  <div>
								  <label>{{ $attr->goods_config_msg }}</label>
								  @if($attr->goods_config_type == 0)
									  <div class="check-box">
										  @foreach($attr->vals as $key => $val)
											  {{ $val->config_val_msg }}
											  <input type="radio" name="config_val_id[{{ $config_id }}][{{ $val->config_type_id }}]" value="{{ $val->config_val_id }}"   @if (in_array($val->config_val_id,explode(',',$config)))checked @endif> 差额 {{ $val->config_diff_price }}
										  @endforeach
									  </div>
									@else
									  <div class="check-box formControls col-xs-8 col-sm-9 conter_nav">
									  @foreach($attr->vals as $val)
										  @foreach($attr->vals as $key => $val)
											  {{ $val->config_val_msg }}<input type="checkbox" class="order_nav valid" name="config_val_id[{{ $config_id }}][{{ $val->config_type_id }}][]" value="{{ $val->config_val_id }}">差额 {{ $val->config_diff_price }}
										  @endforeach
									  @endforeach
									  </div>
								  @endif
							  </div>
						@endforeach
					@endforeach
					@endif
					@if(isset($order->special))
					赠品:<input type="text" class="input-text" value="{{ $order->special }}" id="order_special" disabled>
					@endif
				</div>
			</div>
		</div>
		<div class="row cl" style="border:0px">
			<div class="clearfix" style="margin: 0px">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>下单时间：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss' })" id="order_time" name="order_time" class="input-text Wdate" style="width:180px;" value="{{ $order->order_time }}">
				</div>
			</div>
		</div>

		<div class="row cl" style="border:0px">
			<div class="clearfix" style="margin: 0px">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>姓名：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="{{$order->order_name}}" placeholder="" id="order_name" name="order_name">
				</div>
			</div>
		</div>
		<div class="row cl" style="border:0px">
			<div class="clearfix" style="margin: 0px">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>电话：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="{{$order->order_tel}}" placeholder="" id="order_tel" name="order_tel">
				</div>
			</div>
		</div>
		<div class="row cl" style="border:0px">
			<div class="clearfix" style="margin: 0px">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>下单地址：</label>
				<div class="formControls col-xs-8 col-sm-9">
					省<input type="text" class="input-text" style="width: 200px" value="{{$order->order_state}}" placeholder="" id="order_state" name="order_state">
					市<input type="text" class="input-text" style="width: 200px" value="{{$order->order_city}}" placeholder="" id="order_city" name="order_city">
					详细地址<input type="text" class="input-text" style="width: 200px" value="{{$order->order_add}}" placeholder="" id="order_add" name="order_add">
				</div>
			</div>
		</div>
		<div class="row cl" style="border:0px">
			<div class="clearfix" style="margin: 0px">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>邮箱地址：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="{{$order->order_email}}" placeholder="" id="order_email" name="order_email">
				</div>
			</div>
		</div>
		<div class="row cl" style="border:0px">
			<div class="clearfix" style="margin: 0px">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>备注：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="{{$order->order_remark}}" placeholder="" id="order_remark" name="order_remark">
				</div>
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<input type="hidden" name="order_id" value="{{ $order->order_id }}">
				<button  class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交</button>
			</div>
		</div>
	</form>
</article>
@endsection
@section('js')
<script type="text/javascript">
    var rules={
        order_name:{
            required:true,
            maxlength:50,
        },
        order_tel:{
            required:true,
            number:true,
        },
        order_state:{
            required:true,
            maxlength:50,
        },
        order_city:{
            required:true,
            maxlength:50,
        },
        order_add:{
            required:true,
            maxlength:255,
        },
        order_email:{
            required:true
        },
        order_remark:{
            required:false
        },
        order_time:{
            required:true
        }
    };
    $("#form-orders-update").validate({
        rules:rules,
        onkeyup:false,
        focusCleanup:true,
        success:"valid",
        submitHandler:function(form){
			var indexs=layer.load(2, {shade: [0.15, '#393D49']})
			$(form).ajaxSubmit({
				type: 'post',
				url: "{{url('admin/order/update')}}",
				success: function(data){
					layer.close(indexs);
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
				}});
			var index = parent.layer.getFrameIndex(window.name);
		}


    });
</script>
@endsection