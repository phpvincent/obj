@extends('admin.father.css')
<link rel="stylesheet" type="text/css" href="{{asset('/css/addgoods.css')}}" />
@section('content')
<article class="page-container">
<style>
	.uploader-thum-container input{
		width:100%!important;
	}
</style>
    <div class="config" style="display: none;" attr="newConfig" id="configclo">
        <div class="row" style="margin-left: 0px;">
            属性名: <input type="text" style="width: 10%;margin-top:10px;" class="input-text attribute" value="" placeholder="" id="goods_config_name" name="goods_config_name[]">
			<input type="text" style="width: 10%;margin-top:10px;display: none" class="input-text attribute" value="0" name="num">
		</div>
        <div class="con-value">
            <div class="row" style="height: 40px;" >
                <div class="col-xs-4 col-sm-4" style="display: inline">
                    <label>属性值:</label> <input type="text" style="width: 60%;margin-top:10px; " class="input-text" value="" placeholder="" id="goods_config" name="goods_config">
                    <input type="checkbox" id="config_isshow" class="price" name="config_isshow[]" value="1"><label for="price">隐藏属性</label>
                </div>
                <div class="formControls col-xs-3 col-sm-3" style="display: inline;">
                    <div class="uploader-thum-container">
                        <input type="file" name="config_imgs[]" width="420" height="280" style="margin-top: 15px;" multiple="multiple" accept="image/png,image/gif,image/jpg,image/jpeg">
                    </div>
                </div>
                <div style="display: inline;">
                    <span class="btn btn-primary" style="margin-top:10px; " title="添加"  onclick="addConfig(this)"><i class="Hui-iconfont">&#xe600;</i></span><span style="margin-top:10px; " class="btn btn-primary" onclick="rmConfig(this)" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span>
                </div>
            </div>
        </div>
    </div>
    {{--商品属性值--}}
    <div class="row" style="height: 40px;display: none;"  attr="newConfig" id="configclo-value">
        <div class="col-xs-4 col-sm-4" style="display: inline">
            属性值: <input type="text" style="width: 60%;margin-top:10px; " class="input-text" value="" placeholder="" id="goods_config" name="goods_config[]">
                    <input type="checkbox" id="config_isshow" class="price"   name="config_isshow[]" value="1"><label for="price">隐藏属性</label>
        </div>
        <div class="formControls col-xs-3 col-sm-3" style="display: inline;">
            <div class="uploader-thum-container">
                <input type="file" name="config_imgs[]" width="420" height="280" style="margin-top: 15px;" multiple="multiple"	accept="image/png,image/gif,image/jpg,image/jpeg">
            </div>
        </div>
    </div>

	<form class="form form-horizontal" id="form-goods-update" enctype="multipart/form-data" action="{{url('admin/goods/post_update')}}">
		{{csrf_field()}}
				<p style="color:red;width:100%;text-align: center;">* 为必填项！</p>
		<input type="hidden" name="goods_id" value="{{$goods->goods_id}}">
		<div class="row cl" style="border: 0px;">
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>网页标题名：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="{{$goods->goods_name}}" placeholder="" id="goods_name" name="goods_name">
				</div>
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>单品名：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="{{$goods->goods_real_name}}" readonly="readonly" placeholder="" id="goods_real_name" name="goods_real_name">
				</div>
			</div>

			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品原价：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([1-9]\d*\.?\d{0,2})?.*$/,'$1');}).call(this)" onblur="this.v();" value="{{$goods->goods_real_price}}" placeholder="" id="goods_real_price" name="goods_real_price">
				</div>
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品定价：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([1-9]\d*\.?\d{0,2})?.*$/,'$1');}).call(this)" onblur="this.v();" value="{{$goods->goods_price}}" placeholder="" id="goods_price" name="goods_price">
				</div>
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品库存：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" placeholder="" id="goods_num" name="goods_num" value="{{$goods->goods_num}}">
				</div>
			</div>
			 <div class="clearfix">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>所属产品：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" placeholder="" id="goods_kind" name="goods_kind" readonly="readonly" value="{{\App\goods_kind::where('goods_kind_id',$goods->goods_kind_id)->first()['goods_kind_name']}}">
                </div>
            </div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>货币类型：</label>
				<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
					<select name="currency_type" id="currency_type" class="select">
						@foreach($currency_type as $item)
							<option disabled="disabled" value="{{$item->currency_type_id}}" {{$item->currency_type_id == $goods->goods_currency_id ? 'selected' : '' }} >{{$item->currency_type_name}}</option>
						@endforeach
						{{--<option value="1">1--中东模板</option>--}}
						{{--<option value="2">2--无倒计时模板</option>--}}
					</select>
					</span> </div>
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>模板类型：</label>
				<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
					<select name="goods_blade_type" id="goods_blade_type" class="select">
						<option value="0" @if($goods->goods_blade_type=='0') selected="selected" @endif>0--台湾模板</option>
						<option value="1" @if($goods->goods_blade_type=='1') selected="selected" @endif>1--简体模板</option>
						<option value="2" @if($goods->goods_blade_type=='2') selected="selected" @endif>2--中东模板</option>
						<option value="3" @if($goods->goods_blade_type=='3') selected="selected" @endif>3--马来西亚模板</option>
						<option value="4" @if($goods->goods_blade_type=='4') selected="selected" @endif>4--泰国模板</option>
						<option value="5" @if($goods->goods_blade_type=='5') selected="selected" @endif>5--日本模板</option>
						<option value="6" @if($goods->goods_blade_type=='6') selected="selected" @endif>6--印度尼西亚</option>
						<option value="7" @if($goods->goods_blade_type=='7') selected="selected" @endif>7--菲律宾</option>
						<option value="8" @if($goods->goods_blade_type=='8') selected="selected" @endif>8--英国</option>
						<option value="9" @if($goods->goods_blade_type=='9') selected="selected" @endif>9--Google-PC(调试中)</option>
						<option value="10" @if($goods->goods_blade_type=='10') selected="selected" @endif>10--美国(调试中)</option>
						{{--<option value="2" @if($goods->goods_blade_type=='2') selected="selected"  @endif>2--无倒计时模板</option>--}}
					</select>
					</span> </div>
			</div>

			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>促销类型：</label>
				<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
					<select name="goods_cuxiao_type" id="goods_cuxiao_type" class="select">
						<option value="0" @if($goods->goods_cuxiao_type=='0') selected="selected" @endif>单件销售</option>
						<option value="1" @if($goods->goods_cuxiao_type=='1') selected="selected"  @endif>买几送几</option>
						<option value="2" @if($goods->goods_cuxiao_type=='2') selected="selected"  @endif>满件优惠</option>
						<option value="3" @if($goods->goods_cuxiao_type=='3') selected="selected"  @endif>自定义套餐</option>
					</select>
					</span> </div>
			</div>
			<div class="clearfix"	id="cuxiaohtml">
				<!-- <div class="formControls col-xs-8 col-sm-9" >
				</div> -->
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品发布者：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="{{$goods->admin_name}}" disabled placeholder="" id="admin_name" name="admin_name">
				</div>
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>单品类型：</label>
				<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
					<select name="goods_type" id="goods_type" class="select">
						@foreach($type as $val)
							<option value="{{$val->goods_type_id}}" @if($goods->goods_type==$val->goods_type_id) selected="selected" @endif>{{$val->goods_type_name}}</option>
						@endforeach
					</select>
					</span> </div>
			</div>
			{{--在线支付--}}
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>选择支付方式：</label>
				<div class="check-box formControls col-xs-8 col-sm-9 conter_nav">
					<label for="delivery">货到付款</label>
					<input type="checkbox" id="pay_type" @if(in_array('0',$goods['goods_pay_type'])) checked="checked"  @endif  name="pay_type[]" value="0">
					<label for="pay_type">paypal支付</label>
					<input type="checkbox" id="pay_type" @if(in_array('1',$goods['goods_pay_type'])) checked="checked"  @endif  name="pay_type[]" value="1">
				</div>
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">单品采购地址：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="{{$goods->goods_buy_url}}" placeholder="" id="goods_buy_url" name="goods_buy_url">
				</div>
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">单品采购备注：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="{{$goods->goods_buy_msg}}" placeholder="" id="goods_buy_msg" name="goods_buy_msg">
				</div>
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">fb像素(没有则留空)：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="{{$goods->goods_pix}}" placeholder="" id="goods_pix" name="goods_pix">
				</div>
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">YaHoo像素(没有则留空)：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="{{$goods->goods_yahoo_pix}}" placeholder="" id="goods_yahoo_pix" name="goods_yahoo_pix">
				</div>
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">Google像素(没有则留空)：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="{{$goods->goods_google_pix}}" placeholder="" id="goods_google_pix" name="goods_google_pix">
				</div>
			</div>

		@if(\App\goods_config::where('goods_primary_id',$goods->goods_id)->count()<=0)
		<div class="clearfix" style="margin-left: 2%">
			<label class="form-label col-xs-4 col-sm-2"> </label>
			<input type="button" class="btn btn-default" value="添加商品附带属性" id="addcon" isalive='off'/>
            <input type="button" class="btn btn-default" style="display: none" value="1" id="num1"/>
        </div>
            <div style="margin:0px auto;border: 1px dashed #000;border-radius: 3%; width: 73%;margin-left:18%; padding: 5px;display: none;" id="conhtml">
                <span class="btn btn-primary" title="添加" id="addconfig"><i class="Hui-iconfont">&#xe600;</i></span><span class="btn btn-primary" id="rmconfig" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span><br>
                <div class="config" id="configclo">
                    <div class="row" style="margin-left: 0px;">
                        属性名: <input type="text" style="width: 10%;margin-top:10px;" class="input-text attribute" attr='goods_config_name[0][msg]' value="" placeholder="" id="goods_config_name" name="goods_config_name[0][goods_config_name]">
                        <input type="text" style="width: 10%;margin-top:10px;display: none" class="input-text attribute" value="1" name="num">
                    </div>
                    <div class="con-value">
                        <div class="row" style="height: 40px;" >
                            <div class="col-xs-4 col-sm-4" style="display: inline">
                                <label>属性值:</label> <input type="text" style="width: 60%;margin-top:10px; " class="input-text" value="" placeholder="" id="goods_config" name="goods_config_name[0][msg][0][goods_config]">
                                                    <input type="checkbox" id="config_isshow" class="price"   name="goods_config_name[0][msg][0][config_isshow]" value="1"><label for="price">隐藏属性</label>
                            </div>
                            <div class="formControls col-xs-3 col-sm-3" style="display: inline;">
                                <div class="uploader-thum-container">
                                    <input type="file" name="goods_config_name[0][msg][0][config_imgs]" width="420" height="280" style="margin-top: 15px;" multiple="multiple"	accept="image/png,image/gif,image/jpg,image/jpeg">
                                </div>
                            </div>
                            <div style="display: inline;">
                                <span class="btn btn-primary" style="margin-top:10px; " title="添加"  onclick="addConfig(this)"><i class="Hui-iconfont">&#xe600;</i></span><span style="margin-top:10px; " class="btn btn-primary" onclick="rmConfig(this)" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		@else
        {{--商品属性--}}
		<div class="clearfix" style="margin-left: 2%">
			<label class="form-label col-xs-4 col-sm-2"> </label>
			{{--<input type="button" class="btn btn-default" value="移除商品附带属性" id="addcon" isalive='on'/>--}}
			<input type="button" class="btn btn-default" style="display: none" value="{{count($goods_config)}}" id="num"/>
		</div>
		
		<div style="margin:0px auto;margin-bottom:100px;border: 1px dashed #000;border-radius: 3%; width: 73%;margin-left:18%; padding: 5px;" id="conhtml">
			<span class="btn btn-primary" title="添加" id="addconfig"><i class="Hui-iconfont">&#xe600;</i></span><span class="btn btn-primary" id="rmconfig" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span><br>
            @foreach($goods_config as $k=>$v)
				<div class="config">
                    <div class="row" style="margin-left: 0px;">
                        <label for="goods_config_name">属性名:</label> <input type="text" style="width: 10%;margin-top:10px;" attr='goods_config_name[{{$k}}][msg]' class="input-text attribute" value="{{$v->goods_config_msg}}" placeholder="" id="goods_config_name" name="goods_config_name[{{$k}}][goods_config_name]">
                        <input type="text" style="width: 10%;margin-top:10px;display: none" class="input-text attribute" value="{{$v->goods_config_id}}" name="goods_config_name[{{$k}}][id]">
                        <input type="text" style="width: 10%;margin-top:10px;display: none" class="input-text attribute" value="{{count($v->config_msg)}}" name="num">
				    </div>
                    <div id="con-value">
                    @if(count($v->config_msg) > 0)
                        @foreach($v->config_msg as $key=>$item)
                        <div class="row" style="height: 40px;" >
                            <div class="col-xs-4 col-sm-4" style="display: inline">
                                <label>属性值:</label> <input type="text" style="width: 60%;margin-top:10px; " class="input-text" value="{{$item['config_val_msg']}}" placeholder="" id="goods_config" name="goods_config_name[{{$k}}][msg][{{$key}}][goods_config]">
                                <input type="checkbox" id="config_isshow" class="price" @if($item['config_isshow']==1) checked="checked" @endif name="goods_config_name[{{$k}}][msg][{{$key}}][config_isshow]" value="1"><label for="price">隐藏属性</label>
								<input type="text" style="width: 60%;margin-top:10px;display: none " class="input-text" value="{{$item['config_val_id']}}" name="goods_config_name[{{$k}}][msg][{{$key}}][id]">
							</div>
                            <div class="formControls col-xs-3 col-sm-3" style="display: inline;">
                                <div class="uploader-thum-container">
                                    <input type="file" name="goods_config_name[{{$k}}][msg][{{$key}}][config_imgs]" width="420" height="280" style="margin-top: 15px;" multiple="multiple"	accept="image/png,image/gif,image/jpg,image/jpeg">
                                </div>
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
                                <div class="col-xs-4 col-sm-4" style="display: inline">
                                    <label>属性值:</label> <input type="text" style="width: 60%;margin-top:10px; " class="input-text attribute" value="" placeholder="" id="goods_config" name="goods_config[]">
                                </div>
                                <div class="formControls col-xs-3 col-sm-3" style="display: inline;">
                                    <div class="uploader-thum-container">
                                        <input type="file" name="config_imgs[]" onclick="uploadFile(this)" width="420" height="280" style="margin-top: 15px;" multiple="multiple"	accept="image/png,image/gif,image/jpg,image/jpeg">
                                    </div>
                                </div>
                                <div style="display: inline;">
                                    <span class="btn btn-primary" style="margin-top:10px; " title="添加"  onclick="addConfig(this)"><i class="Hui-iconfont">&#xe600;</i></span><span style="margin-top:10px; " class="btn btn-primary" onclick="rmConfig(this)" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span>
                                </div>
                            </div>
                        </div>
                        </div>
                    @endif
                    </div>
				</div>
			@endforeach
		</div>
		@endif
		{{--物流公司--}}
		<div class="row cl">
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">物流公司：</label>
				<div class="formControls col-xs-8 col-sm-9 skin-minimal">
					<div class="check-box">
						是 <input type="radio" id="express_1" class="is_nav" name="express_1" @if(in_array('express',$goods_templet)) checked="checked" @endif  value="1">
						否 <input type="radio" id="express_1" class="is_nav" name="express_1" @if(!in_array('express',$goods_templet)) checked="checked" @endif value="0">
						<label for="checkbox-pinglun">&nbsp;</label>
					</div>
				</div>
			</div>
		</div>
		{{--评论内容--}}
		<div class="row cl">
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">评论内容：</label>
				<div class="formControls col-xs-8 col-sm-9 skin-minimal">
					<div class="check-box">
						是 <input type="radio" id="commit_1" class="is_nav" @if(in_array('commit',$goods_templet)) checked="checked" @endif  name="commit_1"  value="1">
						否 <input type="radio" id="commit_1" class="is_nav" @if(!in_array('commit',$goods_templet)) checked="checked" @endif  name="commit_1" value="0">
						<label for="checkbox-pinglun">&nbsp;</label>
					</div>
				</div>
			</div>
		</div>
		{{--价格模块--}}
		<div class="row cl">
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">价格模块：</label>
				<div class="formControls col-xs-8 col-sm-9 skin-minimal">
					<div class="check-box">
						是 <input type="radio" id="price_1" class="is_nav price_1" name="price_1" @if(in_array('price',$goods_templet)) checked="checked"  @endif  value="1">
						否 <input type="radio" id="price_1" class="is_nav price_1" name="price_1" @if(!in_array('price',$goods_templet)) checked="checked" @endif value="0">
						<label for="checkbox-pinglun">&nbsp;</label>
					</div>
				</div>
			</div>
			<div class="clearfix templet_show jian_templet" style="display: {{in_array('price',$goods_templet) ? 'block' : 'none'}};">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>选择导航内容：</label>
				<div class="check-box formControls col-xs-8 col-sm-9 conter_nav">
					<label for="price">免运费</label>
					<input type="checkbox" id="price" class="price" @if(in_array('free_freight',$goods_templet)) checked="checked" @endif name="price[]" value="free_freight">
					<label for="price">货到付款</label>
					<input type="checkbox" id="price" class="price" @if(in_array('cash_on_delivery',$goods_templet)) checked="checked" @endif name="price[]" value="cash_on_delivery">
					<label for="price">七天鉴赏期</label>
					<input type="checkbox" id="price" class="price" @if(in_array('seven_days',$goods_templet)) checked="checked" @endif name="price[]" value="seven_days">
                    <label for="price">商品原价</label>
                    <input type="checkbox" id="price" class="price" @if(in_array('original',$goods_templet)) checked="checked" @endif name="price[]" value="original">
                </div>
			</div>
		</div>
		{{--倒计时模块--}}
		<div class="row cl">
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">倒计时模块：</label>
				<div class="formControls col-xs-8 col-sm-9 skin-minimal">
					<div class="check-box">
						是 <input type="radio" id="count_down_1" class="is_nav count_down_1" name="count_down_1"  @if(in_array('count_down',$goods_templet)) checked="checked" @endif   value="1">
						否 <input type="radio" id="count_down_1" class="is_nav count_down_1" name="count_down_1"  @if(!in_array('count_down',$goods_templet)) checked="checked" @endif value="0">
						<label for="checkbox-pinglun">&nbsp;</label>
					</div>
				</div>
			</div>
			<div class="clearfix templet_show" style="display: {{in_array('count_down',$goods_templet) ? 'block' : 'none'}};">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品倒计时展示：</label>
				<div class="formControls col-xs-8 col-sm-9">
					时:<input type="text" style="width: 10%;" class="input-text" value="{{$goods->goods_end ? explode(':',$goods->goods_end)[0] : 24}}" placeholder="" id="goods_end1" name="goods_end1">
					分:<input type="text" style="width: 10%;" class="input-text" value="{{$goods->goods_end ? explode(':',$goods->goods_end)[1] : 00}}" placeholder="" id="goods_end2" name="goods_end2">
					秒:<input type="text" style="width: 10%;" class="input-text" value="{{$goods->goods_end ? explode(':',$goods->goods_end)[2] : 00}}" placeholder="" id="goods_end3" name="goods_end3"><div style="border:2px dashed #ccc;">展示形式:<img src="/images/djs.png"></div>
				</div>
			</div>
		</div>
		{{--促销活动模块--}}
		<div class="row cl">
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">促销活动模块：</label>
				<div class="formControls col-xs-8 col-sm-9 skin-minimal">
					<div class="check-box ">
						是 <input type="radio" id="promotion_1" class="is_nav promotion_1" @if(in_array('description',$goods_templet)) checked="checked" @endif name="promotion_1"  value="1">
						否 <input type="radio" id="promotion_1" class="is_nav promotion_1" @if(!in_array('description',$goods_templet)) checked="checked" @endif name="promotion_1" value="0">
						<label for="checkbox-pinglun">&nbsp;</label>
					</div>
				</div>
			</div>
			<div class="clearfix templet_show" style="display: {{in_array('description',$goods_templet) ? 'block' : 'none'}};">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品促销活动名：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="{{$goods->goods_cuxiao_name}}" placeholder="" id="goods_cuxiao_name" name="goods_cuxiao_name">
				</div>
			</div>
			<div class="clearfix  templet_show" style="display: {{in_array('description',$goods_templet) ? 'block' : 'none'}};">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品描述：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<textarea name="goods_msg" cols="" rows="" id="goods_msg" class="textarea"  placeholder="说点什么..." datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！" onKeyUp="$.Huitextarealength(this,200)">{{$goods->goods_msg}}</textarea>
					<p class="textarea-numberbar"><em class="textarea-length">0</em>/200</p>
				</div>
			</div>
		</div>
		{{--中部导航模块--}}
		<div class="row cl">
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">中部导航模块：</label>
				<div class="formControls col-xs-8 col-sm-9 skin-minimal">
					<div class="check-box">
						是 <input type="radio" id="conter_nav_1" class="is_nav_1 conter_nav_1" name="center_nav_1" @if(in_array('center_nav',$goods_templet)) checked="checked" @endif  value="1">
						否 <input type="radio" id="conter_nav_1" class="is_nav_1 conter_nav_1" name="center_nav_1" @if(!in_array('center_nav',$goods_templet)) checked="checked" @endif value="0">
						<label for="checkbox-pinglun">&nbsp;</label>
					</div>
				</div>
			</div>
			<div class="clearfix templet_show" style="display: {{in_array('center_nav',$goods_templet) ? 'block' : 'none'}};">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>选择导航内容：</label>
				<div class="check-box formControls col-xs-8 col-sm-9 conter_nav">
					<label for="conter_nav">商品规格</label>
					<input type="checkbox" id="conter_nav" name="center_nav[]" @if(in_array('specifications',$goods_templet)) checked="checked" @endif  value="specifications">
					<label for="conter_nav">商品介绍</label>
					<input type="checkbox" id="conter_nav"name="center_nav[]" @if(in_array('introduce',$goods_templet)) checked="checked" @endif  value="introduce">
					<label for="conter_nav">评论</label>
					<input type="checkbox" id="conter_nav" class="pinglun"name="center_nav[]" @if(in_array('evaluate',$goods_templet)) checked="checked" @endif  value="evaluate">
				</div>
			</div>
			<div class="clearfix templet_show" id="evaluate_show" style="display: {{in_array('evaluate',$goods_templet) ? 'block' : 'none'}};">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品评论数展示：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" placeholder="" id="goods_comment_num" name="goods_comment_num" value="{{$goods->goods_comment_num}}">
					<div style="border:2px dashed #ccc;">展示形式:<img src="/images/comm.png"></div>
				</div>
			</div>
		</div>
		{{--用户帮助模块--}}
		<div class="row cl">
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">用户帮助模块：</label>
				<div class="formControls col-xs-8 col-sm-9 skin-minimal">
					<div class="check-box">
						是 <input type="radio" id="uesr_help_1" class="is_nav uesr_help_1" name="user_help_1"  @if(in_array('user_help',$goods_templet)) checked="checked" @endif  value="1">
						否 <input type="radio" id="uesr_help_1" class="is_nav uesr_help_1" name="user_help_1"  @if(!in_array('user_help',$goods_templet)) checked="checked" @endif  value="0">
						<label for="checkbox-pinglun">&nbsp;</label>
					</div>
				</div>
			</div>
			<div class="clearfix templet_show" style="display: {{in_array('user_help',$goods_templet) ? 'block' : 'none'}};">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>选择显示内容：</label>
				<div class="check-box formControls col-xs-8 col-sm-9 conter_nav">
					<label for="uesr_help">用户须知</label>
					<input type="checkbox" checked="checked" id="uesr_help"  @if(in_array('user_know',$goods_templet)) checked="checked" @endif name="user_help[]" value="user_know">
					<label for="uesr_help">如何申请退换货</label>
					<input type="checkbox" checked="checked" id="uesr_help"  @if(in_array('apply_goods',$goods_templet)) checked="checked" @endif name="user_help[]" value="apply_goods">
					<label for="uesr_help">退换货流程</label>
					<input type="checkbox" checked="checked" id="uesr_help"  @if(in_array('exchange_of_goods',$goods_templet)) checked="checked" @endif name="user_help[]" value="exchange_of_goods">
				</div>
			</div>
		</div>
		{{--是否附带视频--}}
		<div class="row cl">
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">是否附带视频:</label>
				<div class="formControls col-xs-8 col-sm-9 skin-minimal">
					<div class="check-box">
						是 <input type="radio" id="is_video" class="is_nav is_video" name="is_video" @if(in_array('video',$goods_templet)) checked="checked"  @endif  value="1">
						否 <input type="radio" id="is_video" class="is_nav is_video" name="is_video" @if(!in_array('video',$goods_templet)) checked="checked" @endif value="0">
						<label for="checkbox-pinglun">&nbsp;</label>
					</div>
				</div>
			</div>
			<div class="clearfix templet_show" style="display: {{in_array('video',$goods_templet) ? 'block' : 'none'}};">
				<label class="form-label col-xs-4 col-sm-2">附带视频(仅限mp4/mpeg格式)：</label>
				<div class="formControls col-xs-8 col-sm-9">
					@if($goods->goods_video!=''||$goods->goods_video!=null)<video src="/{{$goods->goods_video}}"	controls="" preload="none" width="420" height="280" data-setup="{}"></video>@else 	<label class="form-label col-xs-4 col-sm-2">暂无数据</label>@endif
					<input type="file" id="goods_video" class="input-text" value="" placeholder="" id="goods_video" name="goods_video" accept="audio/mp4,video/mp4,video/mpeg,video/mpeg">
				</div>
			</div>
		</div>
		{{--轮播图模块--}}
		<div class="row cl">
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">轮播图模块：</label>
				<div class="formControls col-xs-8 col-sm-9 skin-minimal">
					<div class="check-box">
						是 <input type="radio" id="broadcast_1" class="is_nav broadcast_1" name="broadcast_1" @if(in_array('broadcast',$goods_templet)) checked="checked"  @endif value="1">
						否 <input type="radio" id="broadcast_1" class="is_nav broadcast_1" name="broadcast_1" @if(!in_array('broadcast',$goods_templet)) checked="checked"  @endif   value="0">
						<label for="checkbox-pinglun">&nbsp;</label>
					</div>
				</div>
			</div>
			<div class="clearfix templet_show jian_templet" style="display: {{in_array('broadcast',$goods_templet) ? 'block' : 'none'}};">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>封面图：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<div class="uploader-thum-container">
						<input type="file" id="fm_imgs" name="fm_imgs[]" width="420" height="280" multiple="multiple"	accept="image/png,image/gif,image/jpg,image/jpeg">
					</div>
				</div>
			</div>
			<div class="clearfix templet_show">
				<label class="form-label col-xs-4 col-sm-2">封面视频(仅限mp4/mpeg格式)：</label>
				<div class="formControls col-xs-8 col-sm-9">
					@if($goods->goods_fm_video!=''||$goods->goods_fm_video!=null)<video src="/{{$goods->goods_fm_video}}"	id="fm_video_show" 	controls="" preload="none" width="420" height="280" data-setup="{}"></video>
					<input class="btn btn-danger-outline radius" type="button" id="cl_fmvideo" value="X">
					<input type="hidden" name="cl_fmvideo" value="0">
					@else 	<label class="form-label col-xs-4 col-sm-2">暂无数据</label>@endif
					<input type="file" id="goods_fm_video" class="input-text" value="" placeholder="" id="goods_fm_video" name="goods_fm_video" accept="audio/mp4,video/mp4,video/mpeg,video/mpeg">
				</div>
		</div>
		{{--底部导航模块--}}
		<div class="row cl">
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">底部导航模块：</label>
				<div class="formControls col-xs-8 col-sm-9 skin-minimal">
					<div class="check-box">
						是 <input type="radio" id="order_nav_1" class="is_nav order_nav_1" name="order_nav_1" @if(in_array('order_nav',$goods_templet)) checked="checked"  @endif value="1">
						否 <input type="radio" id="order_nav_1" class="is_nav order_nav_1" name="order_nav_1" @if(!in_array('order_nav',$goods_templet)) checked="checked"  @endif value="0">
						<label for="checkbox-pinglun">&nbsp;</label>
					</div>
				</div>
			</div>
			<div class="clearfix templet_show jian_templet" style="display: {{in_array('order_nav',$goods_templet) ? 'block' : 'none'}};">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>选择显示内容：</label>
				<div class="check-box formControls col-xs-8 col-sm-9 conter_nav">
					<label for="order_nav">订单查询</label>
					<input type="checkbox" class="order_nav" @if(in_array('order_select',$goods_templet)) checked="checked"  @endif id="order_nav" name="order_nav[]" value="order_select">
					<label for="order_nav">立即购买</label>
					<input type="checkbox" class="order_nav" @if(in_array('now_buy',$goods_templet)) checked="checked"  @endif  id="order_nav" name="order_nav[]" value="now_buy">
				</div>
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品描述：</label>
			<div class="formControls col-xs-8 col-sm-9"> 
				<script id="editor1" type="text/plain" name='editor1' style="width:100%;height:400px;">{!!$goods->goods_des_html!!}</script> 
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品规格：</label>
			<div class="formControls col-xs-8 col-sm-9"> 
				<script id="editor2" type="text/plain" name='editor2' style="width:100%;height:400px;">{!!$goods->goods_type_html!!}</script> 
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button  class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交</button>
				<!-- <button onClick="article_save();" class="btn btn-secondary radius" type="button"><i class="Hui-iconfont">&#xe632;</i> 保存草稿</button>
				<button onClick="removeIframe();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button> -->
			</div>
		</div>
		<input type="hidden" name="recheck" value="{{isset($_GET['recheck'])?$_GET['recheck']:0}}">
	</form>
	<div class="img_templet_2"onclick="guanbi_img_templet()"></div>
	<div class="img_templet" id="img_templet" > <div style="width: 100%;height: 100%;overflow-y:auto ;"onclick="img_templet()"><image style="width: 100%;" src="/images/templet.png"></div></image>  </div>
	<div class="allselect public_css" onclick="allselect()">全选模板</div>
	<div class="partselect public_css" onclick="partselect()">简选模板</div>
	<div class="totop public_css" onclick="totop()"><i class="Hui-iconfont">&#xe699;</i></div>
	<div class="tobottom public_css" onclick="tobottom()"><i class="Hui-iconfont">&#xe698;</i></div>
</article>
@endsection
@section('js')
<script type="text/javascript">
    get_cuxiao_html($('#goods_cuxiao_type').val());
/*	$(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
		});

	});*/
	function guanbi_img_templet() {
        $("#img_templet").attr("class","img_templet");
		$(".img_templet_2").hide();
    }
	function img_templet() {
		if($("#img_templet").attr("class")=="img_templet_1"){
            $("#img_templet").attr("class","img_templet");
            $(".img_templet_2").hide();
		}else {
            $("#img_templet").attr("class","img_templet_1");
            $(".img_templet_2").show();
		}
    }

	//页面底部
	function tobottom(){
        var Sheight = document.body.offsetHeight - document.documentElement.offsetHeight
        document.documentElement.scrollTop = document.body.scrollTop =Sheight;
    }

	//页面置顶
    function totop(){
        document.documentElement.scrollTop = document.body.scrollTop =0;
    }

	//全选模板
	function allselect()
	{
		layer.msg("已全部选中，请完善信息。");
        for(var i=0; i<$('input[type="radio"][value="1"]').length;i++){
            $('input[type="radio"][value="1"]')[i].checked = true
		}
        for(var i=0; i<$('input[type="checkbox"]').length;i++){
            $('input[type="checkbox"]')[i].checked = true
        }
		$('.templet_show').show();
		        //价格
		        price();
				//倒计时
		        count_down()
				//促销活动模块
		        promotion();
				//中间导航
		        center_nav()
				//轮播导航
		        broadcast();
				//评论数
		        pinglun();
				//用户帮助
		        uesr_help();
				//订单查询
		        order_nav();
        		//在线支付
        		pay_type();
	}

	//简选模板
    function partselect()
    {
        layer.msg("已更改为简选模板模式，请完善信息。");
		//初始化，全部不选
        for(var i=0; i<$('input[type="radio"][value="0"]').length;i++){
            $('input[type="radio"][value="0"]')[i].checked = true
        }
        $('.templet_show').hide();

        //价格模板
        $('input[name="price_1"]')[0].checked = true;
        $('input[name="price_1"]')[1].checked = false;
		//轮播模块
        $('input[name="broadcast_1"]')[0].checked = true;
        $('input[name="broadcast_1"]')[1].checked = false;
		//底部导航
        $('input[name="order_nav_1"]')[0].checked = true;
        $('input[name="order_nav_1"]')[1].checked = false;
		//价格模块（全部不选）
        $('.price').attr('checked',false);
        $('.jian_templet').show();
		//
		$('.order_nav').attr('checked',true);
		broadcast();
		order_nav();
    }

	$('#goods_cuxiao_type').on('change',function(){
		var now=$(this).val();
		get_cuxiao_html(now);
	})
	$('#cl_fmvideo').on('click',function(){
    	$(this).prev().hide(300);
    	$(this).next().val('1');
    })
	function get_cuxiao_html(now){
		$('#cuxiaohtml').html('<div  style="margin:0px auto;width:50%;float:right;"><img src="/images/loading.gif"> </div>');
		$.ajax({
					url:"{{url('admin/goods/getcuxiaohtml')}}",
					type:'get',
					data:{'id':now,'goods_id':"{{$goods->goods_id}}"},
					datatype:'json',
					success:function(msg){
			          $('#cuxiaohtml').html(msg);
					}
				})
	}
	//2018-09-11 重写表单验证规则
    var rules={
        goods_num:{
        	required:true,
        	digits : true
    	},
        goods_name:{
            required:true,
            maxlength:100,
        },
        goods_real_name:{
            required:true,
            maxlength:100,
        },
        goods_real_price:{
            required:true,
            number:true,
            maxlength:12,
        },
        goods_price:{
            required:true,
            number:true,
            maxlength:12,
        },
        admin_name:{
            required:true,
        },
        url:{
            required:true,
        },
        commentdatemax:{
            required:true,
        }
    };
	//验证函数(价格)
	function price(){
        // if($('input[name="price_1"]:checked').val() == 1){
        //     $('#price').rules('add', {
        //         required:true
        //     });
        // }else{
        //     $('#price').rules('add', {
        //         required:false
        //     });
        // }
	}

    //验证函数(倒计时)
    function count_down(){
        if($('input[name="count_down_1"]:checked').val()==1){
            $('#goods_end1').rules('add', {
                required:true,
                digits : true
            });
            $('#goods_end2').rules('add', {
                required:true,
                digits : true
            });
            $('#goods_end3').rules('add', {
                required:true,
                digits : true
            });
        }else{
            $('#goods_end1').rules('add', {
                required:false,
                digits : false
            });
            $('#goods_end2').rules('add', {
                required:false,
                digits : false
            });
            $('#goods_end3').rules('add', {
                required:false,
                digits : false
            });
        }
    }

	//促销活动模块
	function  promotion(){
        if($('input[name="promotion_1"]:checked').val()==1){
            $('#goods_cuxiao_name').rules('add', {
                required:true
            });
        }else{
            $('#goods_cuxiao_name').rules('add', {
                required:false
            });
        }
	}

    //中间导航
	function  center_nav() {
        if($('input[name="center_nav_1"]:checked').val()==1){
            $('#conter_nav').rules('add', {
                required:true
            });
        }else{
            $('#conter_nav').rules('add', {
                required:false
            });
        }
	}

    function pay_type(){
            $('#pay_type').rules('add', {
                required:true
            });

	}

	//用户帮助
	function uesr_help() {
        if($('input[name="uesr_help_1"]:checked').val()==1){
            $('#uesr_help').rules('add', {
                required:true
            });
        }else{
            $('#uesr_help').rules('add', {
                required:false
            });
        }
    }


	//订单导航
	function order_nav(){
        if($('input[name="order_nav_1"]:checked').val()==1){
            $('#order_nav').rules('add', {
                required:true
            });
        }else{
            $('#order_nav').rules('add', {
                required:false
            });
        }
	}
	// function pay_type(){
    //     $('#pay_type').rules('add', {
    //         required:true
    //     });
	// }
	//
    // $(".error").hide(400)

    //评论数验证
	function pinglun(){
        if($(".pinglun").is(":checked")){
            $('#goods_comment_num').rules('add', {
                required:true,
                digits : true
            });
            $("#evaluate_show").show(400);
        }else{
            $('#goods_comment_num').rules('add', {
                required:false,
                digits : false
            });
            $("#evaluate_show").hide(400);
        }
	}

	//轮播图模块
	function broadcast(){
        if($('input[name="broadcast_1"]:checked').val()==1){
            $('#goods_comment_num').rules('add', {
                required:true,
                digits : true
            });
            $(this).parent().parent().next().show(400);
        }else{
            $('#goods_comment_num').rules('add', {
                required:false,
                digits : false
            });
            $(this).parent().parent().next().hide(400);
        }
	}

	// //视频
    // function video() {
    //     if($('input[name="is_video"]:checked').val()==1){
    //         $('#goods_video').rules('add', {
    //             required:true
    //         });
    //     }else{
    //         $('#goods_video').rules('add', {
    //             required:false
    //         });
    //     }
    // }

	//加载完成事件
	$(function(){
		//价格
		price();
		//倒计时
        count_down();
		//促销活动模块
        promotion();
		//中间导航
        center_nav();
		//轮播导航
        broadcast();
		//评论数
        pinglun();
		//用户帮助
        uesr_help();
		//订单查询
        order_nav();
		//在线支付
        pay_type();
	});

	//单击事件触发（价格）
    $('.price_1').on('click',function(){
        price();
    });

    //单击事件触发（倒计时）
    $('.count_down_1').on('click',function(){
        count_down();
    });

    //单击事件触发（促销活动模块）
    $('.promotion_1').on('click',function(){
        promotion();
    });

    //单击事件触发（中间导航）
    $('.conter_nav_1').on('click',function(){
        center_nav();
    });

    //单击事件触发（评论数）
    $('.pinglun').on('click',function(){
        pinglun();
    });

    //单击事件触发（用户帮助）
    $('.uesr_help_1').on('click',function(){
        uesr_help();
    });

    //单击事件触发（轮播）
    $('.broadcast_1').on('click',function(){
        broadcast();
    });

    //单击事件触发（订单查询）
    $('.order_nav_1').on('click',function(){
        order_nav();
    });

    //单击事件触发（在线支付）
    $('.pay_type_1').on('click',function(){
        pay_type();
    });

    // //单击事件触发（视频）
    // $('.is_video').on('click',function(){
    //     video();
    // });

	//表单验证
	$("#form-goods-update").validate({
		rules:rules,
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			@if(\App\goods_check::first()['goods_is_check']==0)
				var msg =confirm("确定要修改此商品吗？将触发核审机制！");
			@else
				var msg =confirm("确定要修改此商品吗？");
			@endif
				if(msg){
                		var indexs=layer.load(2, {shade: [0.15, '#393D49']})
						$(form).ajaxSubmit({
							type: 'post',
							url: "{{url('admin/goods/post_update')}}",
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
						//parent.$('.btn-refresh').click();
						/*parent.layer.close(index);*/
					}
				}
		
	});

	$('#goods_video').on('change',function(){
		$(this).prev().hide(1000);
	})
	$('#goods_fm_video').on('change',function(){
		$('#fm_video_show').hide(1000);
	})

    //富文本编辑器
    UE.getEditor('editor1');
	UE.getEditor('editor2');
	function removeIframe(){
	var index = parent.layer.getFrameIndex(window.name);
	setTimeout(function(){parent.layer.close(index)}, 500); 
		}
		$('.is_video').on('click',function(){
			var val=$(this).val();
			if(val==0){
				$(this).parent().parent().parent().prev().hide(400);
			}else if(val==1){
				$(this).parent().parent().parent().prev().show(400);
			}
		});

		$('.is_nav_1').on('click',function(){
			var val=$(this).val();
			if(val==0){
				$(this).parent().parent().parent().next().hide(400);
                $(this).parent().parent().parent().next().next().hide(400);
                $(this).parent().parent().parent().next().find('input[value="evaluate"]').attr('checked',false);
			}else if(val==1){
				$(this).parent().parent().parent().next().show(400);
			}
		});

		$('.is_nav').on('click',function(){
			var val=$(this).val();
			if(val==0){
				$(this).parent().parent().parent().next().hide(400);
				$(this).parent().parent().parent().next().next().hide(400);
			}else if(val==1){
				$(this).parent().parent().parent().next().show(400);
				$(this).parent().parent().parent().next().next().show(400);
			}
		});

		//删除属性名+属性值
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

	//新增属性名+属性值
	$('#addconfig').on('click',function(){
			var configdiv=$('#configclo').clone();
            //属性名键值
            if($('#num').val() == undefined){
                var a = $('#num1').val();
            }else{
                var a = $('#num').val();
            }
		    configdiv.children('.row').find('input:first').attr('name','goods_config_name['+a+'][goods_config_name]');
		    configdiv.children('.row').find('input').attr('attr','goods_config_name['+a+'][msg]');
            configdiv.children('div:last').children('.row').children('.col-sm-4').find('input:first').attr('name','goods_config_name['+a+']'+'[msg][0][goods_config]');
            configdiv.children('div:last').children('.row').children('.col-sm-4').find('input:last').attr('name','goods_config_name['+a+']'+'[msg][0][config_isshow]');
		    configdiv.children('div:last').children('.row').children('.col-sm-3').find('input').attr('name','goods_config_name['+a+']'+'[msg][0][config_imgs]');
        	a++;
            if($('#num').val() == undefined){
                $('#num1').val(a)
            }else{
                $('#num').val(a)
            }
			configdiv.show(200);
			$('#conhtml').append(configdiv);
		})

	//删除属性名+属性值
    $("#rmconfig").on('click',function(){
        if($('.config').length>1 && $('.config:last').attr('attr') == 'newConfig' ){
            $('.config').last().remove();
        }
    })

    // 新增属性
    function addConfig(obj){
        var configdiv=$('#configclo-value').clone();
        //属性值键值
        var k = $(obj).parent().parent().parent().prev().find('input:last').val();
        k++;
        //属性值名称
		var msg = $(obj).parent().parent().parent().prev().find('input:first').attr('attr');
        configdiv.children('.col-sm-4').find('input:first').attr('name',msg+'['+k+']'+'[goods_config]');
        configdiv.children('.col-sm-4').find('input:last').attr('name',msg+'['+k+']'+'[config_isshow]');
        configdiv.children('.col-sm-3').find('input').attr('name',msg+'['+k+']'+'[config_imgs]');
        console.log(configdiv.children('.col-sm-3').find('input').attr('name'));
        configdiv.show(200);
        $(obj).parent().parent().parent().prev().find('input:last').val(k);
        $(obj).parent().parent().parent().append(configdiv);
    }

    // 删除属性(控制原有数据不可删除)
    function rmConfig(obj){
        if($(obj).parent().parent().parent().children("div.row").length>1){
            if($(obj).parent().parent().parent().children("div.row:last").attr('attr') == 'newConfig'){
                $(obj).parent().parent().parent().children("div.row:last").remove();
            }
        }else{
            layer.msg('如果想要删除，请通过虚线框内第一个减号进行删除');
        }
    }
</script>
@endsection