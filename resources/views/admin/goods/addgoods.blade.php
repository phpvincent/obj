@extends('admin.father.css')
<link rel="stylesheet" type="text/css" href="{{asset('/css/addgoods.css')}}" />
@section('content')
<article class="page-container">
	{{--商品属性信息--}}
	<div class="config" style="display: none;" id="configclo">
		<div class="row" style="margin-left: 0px;">
			属性名: <input type="text" style="width: 10%;margin-top:10px;" class="input-text attribute" value="" placeholder="" id="goods_config_name" name="goods_config_name">
			<input type="text" style="width: 10%;margin-top:10px;display: none" class="input-text attribute" value="0" name="num">
		</div>
		<div class="con-value">
			<div class="row" style="height: 40px;" >
				<div class="col-xs-4 col-sm-4" style="display: inline">
					<label>属性值:</label> <input type="text" style="width: 60%;margin-top:10px; " class="input-text" value="" placeholder="" id="goods_config" name="goods_config">
				</div>
				<div class="formControls col-xs-3 col-sm-3" style="display: inline;">
					<div class="uploader-thum-container">
						<input type="file" name="config_imgs[]" width="420" height="280" style="margin-top: 15px;" multiple="multiple"	accept="image/png,image/gif,image/jpg,image/jpeg">
					</div>
				</div>
				<div style="display: inline;">
					<span class="btn btn-primary" style="margin-top:10px; " title="添加"  onclick="addConfig(this)"><i class="Hui-iconfont">&#xe600;</i></span><span style="margin-top:10px; " class="btn btn-primary" onclick="rmConfig(this)" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span>
				</div>
			</div>
		</div>
	</div>

	{{--商品属性值--}}
	<div class="row" style="height: 40px;display: none;" id="configclo-value">
		<div class="col-xs-4 col-sm-4" style="display: inline">
			属性值: <input type="text" style="width: 60%;margin-top:10px; " class="input-text" value="" placeholder="" id="goods_config" name="goods_config[]">
		</div>
		<div class="formControls col-xs-3 col-sm-3" style="display: inline;">
			<div class="uploader-thum-container">
				<input type="file" name="config_imgs[]" width="420" height="280" style="margin-top: 15px;" multiple="multiple"	accept="image/png,image/gif,image/jpg,image/jpeg">
			</div>
		</div>
	</div>
	<div class="clearfix">

	</div>
	<form class="form form-horizontal " id="form-goods-update" enctype="multipart/form-data" action="{{url('admin/goods/post_add')}}">
		{{csrf_field()}}
		<div class="row cl" style="border:0px">
			<div class="clearfix" style="margin: 0px">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品名：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="" placeholder="" id="goods_name" name="goods_name">
				</div>
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>单品名：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="" placeholder="" id="goods_real_name" name="goods_real_name">
				</div>
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品原价：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="" placeholder="" id="goods_real_price" name="goods_real_price">
				</div>
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品定价：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="" placeholder="" id="goods_price" name="goods_price">
				</div>
			</div>
            <div class="clearfix">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品库存：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" placeholder="" id="goods_num" name="goods_num" value="">
                </div>
            </div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>货币类型：</label>
				<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
					<select name="currency_type" id="currency_type" class="select">
						@foreach($currency_type as $item)
						<option value="{{$item->currency_type_id}}" {{$item->currency_type_id == 1 ? 'selected' : '' }} >{{$item->currency_type_name}}</option>
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
						<option value="0" >0--台湾模板</option>
						<option value="1">1--中东模板</option>
						{{--<option value="2">2--无倒计时模板</option>--}}
					</select>
					</span> </div>
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>促销类型：</label>
				<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
					<select name="goods_cuxiao_type" id="goods_cuxiao_type" class="select">
						<option value="0" >单件销售</option>
						<option value="1" >买几送几</option>
						<option value="2" >满件优惠</option>
						<option value="3" >自定义套餐</option>
					</select>
					</span> </div>
			</div>
			<div class="clearfix" id="cuxiaohtml">
				
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品发布者：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="{{Auth::user()->admin_name}}" disabled placeholder="" value="{{Auth::user()->admin_id}}" id="admin_name" name="admin_name"><input type="hidden" name="admin_id" value="{{Auth::user()->admin_id}}">
				</div>
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>单品类型：</label>
				<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
					<select name="goods_type" id="goods_type" class="select">
							@foreach($type as $val)
							<option value="{{$val->goods_type_id}}" >{{$val->goods_type_name}}</option>
							@endforeach
					</select>
						</span> 
				</div>
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">单品采购备注：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="" placeholder="" id="goods_buy_msg" name="goods_buy_msg">
				</div>
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">单品采购地址：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="" placeholder="" id="goods_buy_url" name="goods_buy_url">
				</div>
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">YaHoo像素(没有则留空)：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="" placeholder="" id="goods_yahoo_pix" name="goods_yahoo_pix">
				</div>
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">fb像素(没有则留空)：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="" placeholder="" id="goods_pix" name="goods_pix">
				</div>
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2"> </label>
				
				<div class="formControls col-xs-8 col-sm-9" style="margin-left: 2%">
					<input type="button" class="btn btn-default" value="添加商品附带属性" id="addcon" isalive='off'/>
					<input type="button" class="btn btn-default" style="display: none" value="0" id="num"/>
				
					<div style="margin:0px auto;border: 1px dashed #000;border-radius: 3%; width: 73%;margin-left:0%; padding: 5px;display: none;" id="conhtml">
						<span class="btn btn-primary" title="添加" id="addconfig"><i class="Hui-iconfont">&#xe600;</i></span><span class="btn btn-primary" id="rmconfig" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span><br>
						<div class="config" id="configclo">
							<div class="row" style="margin-left: 0px;">
								属性名: <input type="text" style="width: 10%;margin-top:10px;" class="input-text attribute" attr='goods_config_name[0][msg]' value="" placeholder="" id="goods_config_name" name="goods_config_name[0][goods_config_name]">
								<input type="text" style="width: 10%;margin-top:10px;display: none" class="input-text attribute" value="0" name="num">
							</div>
							<div class="con-value">
								<div class="row" style="height: 40px;" >
									<div class="col-xs-4 col-sm-4" style="display: inline">
										<label>属性值:</label> <input type="text" style="width: 60%;margin-top:10px; " class="input-text" value="" placeholder="" id="goods_config" name="goods_config_name[0][msg][0][goods_config]">
									</div>
									<div class="formControls col-xs-3 col-sm-3" style="display: inline;">
										<div class="uploader-thum-container" style="overflow: hidden;">
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
				</div>
			</div>
			<div class="clearfix">
				
			</div>
		</div>
		<div class="row cl">
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">物流公司：</label>
				<div class="formControls col-xs-8 col-sm-9 skin-minimal">
					<div class="check-box">
						是 <input type="radio" id="express_1" class="is_nav" name="express_1"  value="1">
						否 <input type="radio" id="express_1" class="is_nav" name="express_1" checked="checked" value="0">
						<label for="checkbox-pinglun">&nbsp;</label>
					</div>
				</div>
			</div>
		</div>
		<div class="row cl">
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">评论内容：</label>
				<div class="formControls col-xs-8 col-sm-9 skin-minimal">
					<div class="check-box">
						是 <input type="radio" id="commit_1" class="is_nav" name="commit_1"  value="1">
						否 <input type="radio" id="commit_1" class="is_nav" name="commit_1" checked="checked" value="0">
						<label for="checkbox-pinglun">&nbsp;</label>
					</div>
				</div>
			</div>
		</div>
		<div class="row cl">
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">价格模块：</label>
				<div class="formControls col-xs-8 col-sm-9 skin-minimal">
					<div class="check-box">
						是 <input type="radio" id="price_1" class="is_nav" name="price_1"  value="1">
						否 <input type="radio" id="price_1" class="is_nav" name="price_1" checked="checked" value="0">
						<label for="checkbox-pinglun">&nbsp;</label>
					</div>
				</div>
			</div>
			<div class="clearfix" style="display: none;">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>选择导航内容：</label>
				<div class="check-box formControls col-xs-8 col-sm-9 conter_nav">
					<label for="price">免运费</label>
					<input type="checkbox" id="price" name="price[]" value="free_freight">
					<label for="price">货到付款</label>
					<input type="checkbox" id="price" name="price[]" value="cash_on_delivery">
					<label for="price">七天鉴赏期</label>
					<input type="checkbox" id="price" name="price[]" value="seven_days">
					<label for="price">商品原价</label>
					<input type="checkbox" id="price" name="price[]" value="original">
				</div>
			</div>
		</div>
		<div class="row cl">
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">倒计时模块：</label>
				<div class="formControls col-xs-8 col-sm-9 skin-minimal">
					<div class="check-box">
						是 <input type="radio" id="count_down_1" class="is_nav" name="count_down_1"  value="1">
						否 <input type="radio" id="count_down_1" class="is_nav" name="count_down_1" checked="checked" value="0">
						<label for="checkbox-pinglun">&nbsp;</label>
					</div>
				</div>
			</div>
			<div class="clearfix" style="display: none;">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品倒计时展示：</label>
				<div class="formControls col-xs-8 col-sm-9">
					时:<input type="text" style="width: 10%;" class="input-text" value="24" placeholder="" id="goods_end1" name="goods_end1">
					分:<input type="text" style="width: 10%;" class="input-text" value="00" placeholder="" id="goods_end2" name="goods_end2">
					秒:<input type="text" style="width: 10%;" class="input-text" value="00" placeholder="" id="goods_end3" name="goods_end3"><div>展示形式:<img src="/images/djs.png"></div>
				</div>
			</div>
		</div>
		<div class="row cl">
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">促销活动模块：</label>
				<div class="formControls col-xs-8 col-sm-9 skin-minimal">
					<div class="check-box ">
						是 <input type="radio" id="promotion_1" class="is_nav" name="promotion_1"  value="1">
						否 <input type="radio" id="promotion_1" class="is_nav" name="promotion_1" checked="checked" value="0">
						<label for="checkbox-pinglun">&nbsp;</label>
					</div>
				</div>
			</div>
			<div class="clearfix" style="display: none;">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品促销活动名：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="" placeholder="" id="goods_cuxiao_name" name="goods_cuxiao_name">
				</div>
			</div>
			<div class="clearfix" style="display: none;">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品描述：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<textarea name="goods_msg" cols="" rows="" id="goods_msg" class="textarea"  placeholder="说点什么..." datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！" onKeyUp="$.Huitextarealength(this,200)"></textarea>
					<p class="textarea-numberbar"><em class="textarea-length">0</em>/200</p>
				</div>
			</div>
		</div>
		<div class="row cl">
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">中部导航模块：</label>
				<div class="formControls col-xs-8 col-sm-9 skin-minimal">
					<div class="check-box">
						是 <input type="radio" id="conter_nav_1" class="is_nav_1" name="center_nav_1"  value="1">
						否 <input type="radio" id="conter_nav_1" class="is_nav_1" name="center_nav_1" checked="checked" value="0">
						<label for="checkbox-pinglun">&nbsp;</label>
					</div>
				</div>
			</div>
			<div class="clearfix" style="display: none;">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>选择导航内容：</label>
				<div class="check-box formControls col-xs-8 col-sm-9 conter_nav">
					<label for="conter_nav">商品规格</label>
					<input type="checkbox" id="conter_nav" name="center_nav[]" value="specifications">
					<label for="conter_nav">商品介绍</label>
					<input type="checkbox" id="conter_nav"name="center_nav[]" value="introduce">
					<label for="conter_nav">评论</label>
					<input type="checkbox" id="conter_nav" class="pinglun"name="center_nav[]" value="evaluate">
				</div>
			</div>
			<div class="clearfix" style="display: none;">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品评论数展示：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="" placeholder="" id="goods_comment_num" name="goods_comment_num" value="999">
					<div style="border:2px dashed #ccc;">展示形式:<img src="/images/comm.png"></div>
				</div>
			</div>
		</div>
		<div class="row cl">
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">用户帮助模块：</label>
				<div class="formControls col-xs-8 col-sm-9 skin-minimal">
					<div class="check-box">
						是 <input type="radio" id="uesr_help_1" class="is_nav" name="uesr_help_1" checked="checked"  value="1">
						否 <input type="radio" id="uesr_help_1" class="is_nav" name="uesr_help_1" value="0">
						<label for="checkbox-pinglun">&nbsp;</label>
					</div>
				</div>
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>选择显示内容：</label>
				<div class="check-box formControls col-xs-8 col-sm-9 conter_nav">
					<label for="uesr_help">用户须知</label>
					<input type="checkbox" checked="checked" id="uesr_help" name="user_help[]" value="user_know">
					<label for="uesr_help">如何申请退换货</label>
					<input type="checkbox" checked="checked" id="uesr_help" name="user_help[]" value="apply_goods">
					<label for="uesr_help">退换货流程</label>
					<input type="checkbox" checked="checked" id="uesr_help" name="user_help[]" value="exchange_of_goods">
				</div>
			</div>
		</div>
		<div class="row cl">
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">是否附带视频:</label>
				<div class="formControls col-xs-8 col-sm-9 skin-minimal">
					<div class="check-box">
						是 <input type="radio" id="is_video" class="is_video" name="is_video"  value="1">
						否 <input type="radio" id="is_video" class="is_video" name="is_video" checked="checked" value="0">
						<label for="checkbox-pinglun">&nbsp;</label>
					</div>
				</div>
			</div>
			<div class="clearfix" style="display: none;">
				<label class="form-label col-xs-4 col-sm-2">附带视频(仅限mp4/mpeg格式)：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="file" id="goods_video" class="input-text" value="" placeholder="" id="goods_video" name="goods_video" accept="audio/mp4,video/mp4,video/mpeg,video/mpeg">
				</div>
			</div>
		</div>
		<div class="row cl">
			<div class="clearfix">
					<label class="form-label col-xs-4 col-sm-2">轮播图模块：</label>
					<div class="formControls col-xs-8 col-sm-9 skin-minimal">
						<div class="check-box">
							是 <input type="radio" id="broadcast_1" class="is_nav" name="broadcast_1"  checked="checked" value="1">
							否 <input type="radio" id="broadcast_1" class="is_nav" name="broadcast_1"  value="0">
							<label for="checkbox-pinglun">&nbsp;</label>
						</div>
					</div>
				</div>
				<div class="clearfix">
					<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>封面图：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<div class="uploader-thum-container">
							<input type="file" id="fm_imgs" name="fm_imgs[]" width="420" height="280" multiple="multiple"	accept="image/png,image/gif,image/jpg,image/jpeg">
						</div>
					</div>
				</div>
		</div>
	<!-- 	<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>对应域名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value=""  placeholder="" id="url" name="url">
			</div>
		</div> -->
	<!-- 	<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">是否上线：</label>
			<div class="formControls col-xs-8 col-sm-9 skin-minimal">
				<div class="check-box">
					<input type="checkbox" id="is_online" name="is_online"  checked="checked"  >
					<label for="checkbox-pinglun">&nbsp;</label>
				</div>
			</div>
		</div> -->
		<div class="row cl">
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2">底部导航模块：</label>
				<div class="formControls col-xs-8 col-sm-9 skin-minimal">
					<div class="check-box">
						是 <input type="radio" id="order_nav_1" class="is_nav" name="order_nav_1" checked="checked" value="1">
						否 <input type="radio" id="order_nav_1" class="is_nav" name="order_nav_1"  value="0">
						<label for="checkbox-pinglun">&nbsp;</label>
					</div>
				</div>
			</div>
			<div class="clearfix">
				<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>选择显示内容：</label>
				<div class="check-box formControls col-xs-8 col-sm-9 conter_nav">
					<label for="order_nav">订单查询</label>
					<input type="checkbox" checked="checked" id="order_nav" name="order_nav[]" value="order_select">
					<label for="order_nav">立即购买</label>
					<input type="checkbox" checked="checked" id="order_nav" name="order_nav[]" value="now_buy">
				</div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品描述：</label>
			<div class="formControls col-xs-8 col-sm-9"> 
				<script id="editor1" type="text/plain" name='editor1' style="width:100%;height:400px;"></script> 
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品规格：</label>
			<div class="formControls col-xs-8 col-sm-9"> 
				<script id="editor2" type="text/plain" name='editor2' style="width:100%;height:400px;"></script> 
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button  class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交</button>
				<!-- <button onClick="article_save();" class="btn btn-secondary radius" type="button"><i class="Hui-iconfont">&#xe632;</i> 保存草稿</button>
				<button onClick="removeIframe();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button> -->
			</div>
		</div>
		
	</form>
</article>
@endsection
@section('js')
<script type="text/javascript">
	
	get_cuxiao_html($('#goods_cuxiao_type').val());


	(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
		});

	});
	
	$('#goods_cuxiao_type').on('change',function(){
		var now=$(this).val();
		get_cuxiao_html(now);
	})
	
	function get_cuxiao_html(now){
		$('#cuxiaohtml').html('<div  style="margin:0px auto;width:50%;float:right;"><img src="/images/loading.gif"> </div>');
		$.ajax({
			url:"{{url('admin/goods/getcuxiaohtml')}}",
			type:'get',
			data:{'id':now,'goods_id':"*"},
			datatype:'json',
			success:function(msg){
			  $('#cuxiaohtml').html(msg);
			}
		})
	}

    var rules={
        goods_name:{
            required:true,
        },
        goods_real_name:{
            required:true,
        },

        goods_real_price:{
            required:true,
            number:true,
        },
        goods_price:{
            required:true,
            number:true,
        },
        admin_name:{
            required:true,
        },
        url:{
            required:true,
        },
        commentdatemax:{
            required:true,
        },
        goods_num:{
            required:true,
        }
    };
    $('#price_1').on('click',function(){
        var val=$(this).val();
        if(val==1){
            $('#price').rules('add', {
                required:true
            });
        }else{
            $('#price').rules('add', {
                required:false
            });
        }
    });
    $('#count_down_1').on('click',function(){
        var val=$(this).val();
        if(val==1){
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
    });
    $('#promotion_1').on('click',function(){
        var val=$(this).val();
        if(val==1){
            $('#goods_cuxiao_name').rules('add', {
                required:true
            });
        }else{
            $('#goods_cuxiao_name').rules('add', {
                required:false
            });
        }
    });
    $('#conter_nav_1').on('click',function(){
        var val=$(this).val();
        if(val==1){
            $('#conter_nav').rules('add', {
                required:true
            });
        }else{
            $('#conter_nav').rules('add', {
                required:false
            });
        }
    });
    $('.pinglun').on('click',function(){
        var val=$(this).val();
        if($(".pinglun").is(":checked")){
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
    });
    $('#uesr_help_1').on('click',function(){
        var val=$(this).val();
        if(val==1){
            $('#uesr_help').rules('add', {
                required:true
            });
        }else{
            $('#uesr_help').rules('add', {
                required:false
            });
        }
    });
    $('#broadcast_1').on('click',function(){
        var val=$(this).val();
        if(val==1){
            $('#fm_imgs').rules('add', {
                required:true
            });
        }else{
            $('#fm_imgs').rules('add', {
                required:false
            });
        }
    });
    $('#order_nav_1').on('click',function(){
        var val=$(this).val();
        if(val==1){
            $('#order_nav').rules('add', {
                required:true
            });
        }else{
            $('#order_nav').rules('add', {
                required:false
            });
        }
    });
    $('#is_video').on('click',function(){
        var val=$(this).val();
        if(val==1){
            $('#goods_video').rules('add', {
                required:true
            });
        }else{
            $('#goods_video').rules('add', {
                required:false
            });
        }
    });
	//表单验证
	$("#form-goods-update").validate({
		rules:rules,
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			$(form).ajaxSubmit({
				type: 'post',
				url: "{{url('admin/goods/post_add')}}",
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
				}});
			var index = parent.layer.getFrameIndex(window.name);
			//parent.$('.btn-refresh').click();
			/*parent.layer.close(index);*/
		}
	});
	$('#goods_video').on('change',function(){
		$(this).prev().hide(1000);
	})
		 UE.getEditor('editor1');
		 UE.getEditor('editor2');
		function removeIframe(){
	var index = parent.layer.getFrameIndex(window.name);
	setTimeout(function(){parent.layer.close(index)}, 500); 
		}
		$('.is_video').on('click',function(){
			var val=$(this).val();
			if(val==0){
				$(this).parent().parent().parent().next().hide(400);
			}else if(val==1){
				$(this).parent().parent().parent().next().show(400);
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

	$('#addconfig').on('click',function(){
			//var configdiv=$(this).next().next().next('div').clone();
			var configdiv=$('#configclo').clone();
			//属性名键值
			var a = $('#num').val();
        	a++;

            configdiv.children('.row').find('input:first').attr('name','goods_config_name['+a+'][goods_config_name]');
			configdiv.children('.row').find('input').attr('attr','goods_config_name['+a+'][msg]');
			configdiv.children('div:last').children('.row').children('.col-sm-4').find('input').attr('name','goods_config_name['+a+']'+'[msg][0][goods_config]');
			configdiv.children('div:last').children('.row').children('.col-sm-3').find('input').attr('name','goods_config_name['+a+']'+'[msg][0][config_imgs]');
        	$('#num').val(a);
			configdiv.show(200);
			$('#conhtml').append(configdiv);
		})
	
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
		configdiv.children('.col-sm-4').find('input').attr('name',msg+'['+k+']'+'[goods_config]');
		configdiv.children('.col-sm-3').find('input').attr('name',msg+'['+k+']'+'[config_imgs]');
		// console.log(configdiv.children('.col-sm-3').find('input').attr('name'));
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
</script>
@endsection