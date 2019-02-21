    <article class="page-container" style="padding-top:0;">
        <!-- 色系下拉框 -->
        <div style="display: inline;display: none;" class="selectSexi"id="selectSexi">
            <label>色系:</label>
            <select name="goods_config_name[0][msg][0][color]" id="sexi"style="width: 26%;height: 30px; " class="select">
                <option value="">选择色系</option>
                <option value="01">黑色</option>
                <option value="10">灰色</option>
                <option value="20">蓝色</option>
                <option value="30">绿色</option>
                <option value="40">棕色</option>
                <option value="50">红色</option>
                <option value="60">紫色</option>
                <option value="70">黄色</option>
                <option value="80">白色</option>
                <option value="90">混色</option>
            </select>
        </div>
        {{--商品属性信息--}}
        <div class="config" style="display: none;" id="configclo">
            <div class="row" style="margin-left: 0px;">
                属性名: <input type="text" style="width: 25%;margin-top:10px;" class="input-text attribute attrName" value="" placeholder="" id="goods_config_name" name="goods_config_name">
                英文属性名: <input type="text" style="width: 25%;margin-top:10px;" class="input-text attribute" value="" placeholder="" id="goods_config_english_name" name="goods_config_english_name">
                <input type="text" style="width: 10%;margin-top:10px;display: none" class="input-text attribute" value="0" name="num">
            </div>
            <div class="con-value" attr="newConfig">
                <div class="row" style="height: 40px;" >
                    <div class="col-xs-8 col-sm-8" style="display: inline">
                        <label>属性值:</label> <input type="text" style="width: 26%;margin-top:10px; " class="input-text sexi" value="" placeholder="" id="goods_config" name="goods_config_name[0][msg][0][goods_config]">
                        <label>英文属性值:</label> <input type="text" style="width: 26%;margin-top:10px; " class="input-text" value="" placeholder="" id="goods_config_english" name="goods_config_name[0][msg][0][goods_config_english]">
                        <div style="display: inline;display: none;" class="selectSexi"id="selectSexi">
                            <label>色系:</label>
                            <select name="goods_config_name[0][msg][0][color]" id="sexi"style="width: 26%;height: 30px; " class="select">
                                <option value="">选择色系</option>
                                <option value="01">黑色</option>
                                <option value="10">灰色</option>
                                <option value="20">蓝色</option>
                                <option value="30">绿色</option>
                                <option value="40">棕色</option>
                                <option value="50">红色</option>
                                <option value="60">紫色</option>
                                <option value="70">黄色</option>
                                <option value="80">白色</option>
                                <option value="90">混色</option>
                            </select>
                        </div>
                    </div>
                    <div style="display: inline;">
                        <span class="btn btn-primary"id="btn_1" style="margin-top:10px; " title="添加"  onclick="addConfig(this)"><i class="Hui-iconfont">&#xe600;</i></span><span style="margin-top:10px; " class="btn btn-primary" onclick="rmConfig(this)" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="config" style="display: none;"attr="newConfig" id="configclo_1">
            <div class="row" style="margin-left: 0px;">
                属性名: <input type="text" style="width: 25%;margin-top:10px;" class="input-text attribute attrName" value="" placeholder="" id="goods_config_name" name="goods_config_name">
                英文属性名: <input type="text" style="width: 25%;margin-top:10px;" class="input-text attribute" value="" placeholder="" id="goods_config_english_name" name="goods_config_english_name">
                <input type="text" style="width: 10%;margin-top:10px;display: none" class="input-text attribute" value="0" name="num">
            </div>
            <div class="con-value"  attr="newConfig">
                <div class="row" style="height: 40px;" >
                    <div class="col-xs-8 col-sm-8" style="display: inline">
                        <label>属性值:</label> <input type="text" style="width: 26%;margin-top:10px; " class="input-text sexi" value="" placeholder="" id="goods_config" name="goods_config_name[0][msg][0][goods_config]">
                        <label>英文属性值:</label> <input type="text" style="width: 26%;margin-top:10px; " class="input-text" value="" placeholder="" id="goods_config_english" name="goods_config_name[0][msg][0][goods_config_english]">
                    </div>
                    <div style="display: inline;">
                        <span class="btn btn-primary" style="margin-top:10px; " title="添加"  onclick="addConfig(this)"><i class="Hui-iconfont">&#xe600;</i></span><span style="margin-top:10px; " class="btn btn-primary" onclick="rmConfig(this)" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row config" style="height: 40px;display: none;"attr="newConfig"  id="configclo-value">
            <div class="col-xs-8 col-sm-8" attr="newConfig" style="display: inline">
                <label>属性值:</label> <input type="text" style="width: 26%;margin-top:10px; " class="input-text sexi" value="" placeholder="" id="goods_config" name="goods_config_name[0][msg][0][goods_config]">
                <label>英文属性值:</label> <input type="text" style="width: 26%;margin-top:10px; " class="input-text" value="" placeholder="" id="goods_config_english" name="goods_config_name[0][msg][0][goods_config_english]">
                <div style="display: inline;" class="selectSexi"id="selectSexi">
                    <label>色系:</label>
                    <select name="goods_config_name[0][msg][0][color]" id="sexi"style="width: 26%;height: 30px; " class="select">
                        <option value="">选择色系</option>
                        <option value="01">黑色</option>
                        <option value="10">灰色</option>
                        <option value="20">蓝色</option>
                        <option value="30">绿色</option>
                        <option value="40">棕色</option>
                        <option value="50">红色</option>
                        <option value="60">紫色</option>
                        <option value="70">黄色</option>
                        <option value="80">白色</option>
                        <option value="90">混色</option>
                    </select>
                </div>
            </div>
        </div>
        {{--商品属性值_1--}}
        <div class="row config" style="height: 40px;display: none;"    id="configclo-value_1">
            <div class="col-xs-8 col-sm-8" attr="newConfig" style="display: inline">
                <label>属性值:</label> <input type="text" style="width: 26%;margin-top:10px; " class="input-text sexi" value="" placeholder="" id="goods_config" name="goods_config_name[0][msg][0][goods_config]">
                <label>英文属性值:</label> <input type="text" style="width: 26%;margin-top:10px; " class="input-text" value="" placeholder="" id="goods_config_english" name="goods_config_name[0][msg][0][goods_config_english]">
            </div>
        </div>
        {{--新增产品form--}}
        <form class="form form-horizontal" id="form-goodskind-add" method="post" enctype="multipart/form-data" action="{{url('admin/goods/kind_config_val')}}">
            {{csrf_field()}}
            <input type="text" style="display: none" id="name" name="name" value="1">
            <div class="row cl">
                <label for="goods_kind_english_name" class="form-label col-xs-4 col-sm-2">产品英文名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text"  value="{{$goods_kinds->goods_kind_english_name}}" placeholder="" id="goods_kind_english_name" name="goods_kind_english_name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>产品受众：</label>
                <div class="formControls col-xs-8 col-sm-9">
             <span class="select-box">
                <select name="goods_kind_user_type" id="goods_kind_user_type" class="select" style="background-color: #EEEEEE;">
                    <option value="0" selected="selected" @if($goods_kinds->goods_kind_user_type==0) selected="selected" @endif >通用</option>
                    <option value="1" @if($goods_kinds->goods_kind_user_type==1) selected="selected" @endif >男士</option>
                    <option value="2" @if($goods_kinds->goods_kind_user_type==2) selected="selected" @endif >女士</option>
                    <option value="3" @if($goods_kinds->goods_kind_user_type==3) selected="selected" @endif >男童</option>
                    <option value="4" @if($goods_kinds->goods_kind_user_type==4) selected="selected" @endif >女童</option>
                    <option value="5" @if($goods_kinds->goods_kind_user_type==5) selected="selected" @endif >男老</option>
                    <option value="6" @if($goods_kinds->goods_kind_user_type==6) selected="selected" @endif >女老</option>
                </select>
            </span>
                </div>
            </div>
            <div class="row cl">
                <label for="goods_kind_img" class="form-label col-xs-4 col-sm-2">产品图片：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="file" class="input-text" value="{{$goods_kinds->goods_kind_img}}" placeholder="" id="goods_kind_img" name="goods_kind_img">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">所属种类：</label>
                <div class="formControls col-xs-8 col-sm-9">
             <span class="select-box">
                <select name="product_type_id" id="product_type_id" class="select">
                    @foreach(\App\product_type::get() as $k => $v)
                        <option @if($goods_kinds->goods_product_id==$v->product_type_id) selected='selected' @endif value="{{$v->product_type_id}}">{{$v->product_type_name}}</option>
                    @endforeach
                </select>
            </span>
                </div>
            </div>
            <div class="row cl">
                <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2">产品重量（单位：kg）：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{floatval($goods_kinds->goods_buy_weight)}}" placeholder="" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d*\.?\d{0,3})?.*$/,'$1');}).call(this)" onblur="this.v();"   id="goods_buy_weight" name="goods_buy_weight">
                </div>
            </div>
            <div class="row cl">
                <label for="goods_kind_volume" class="form-label col-xs-4 col-sm-2">产品体积（单位：cm）{{ $goods_kinds->goods_kind_volume }}：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" style="width: 80px;" value="{{floatval($goods_kinds->width)}}" placeholder="" id="width" name="width" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d*\.?\d{0,3})?.*$/,'$1');}).call(this)" onblur="this.v();">cm
                    <input type="text" class="input-text" style="width: 80px;" value="{{floatval($goods_kinds->depth)}}" placeholder="" id="depth" name="depth" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d*\.?\d{0,3})?.*$/,'$1');}).call(this)" onblur="this.v();">cm
                    <input type="text" class="input-text" style="width: 80px;" value="{{floatval($goods_kinds->height)}}" placeholder="" id="height" name="height" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d*\.?\d{0,3})?.*$/,'$1');}).call(this)" onblur="this.v();">cm
                </div>
            </div>
            <div class="row cl">
                <label for="goods_kind_postage" class="form-label col-xs-4 col-sm-2">邮费（单位：元）：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{floatval($goods_kinds->goods_kind_postage)}}" placeholder="" id="goods_kind_postage" name="goods_kind_postage" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d*\.?\d{0,3})?.*$/,'$1');}).call(this)" onblur="this.v();">
                </div>
            </div>
            {{--<div class="row cl">--}}
            {{--<label for="goods_buy_url"  class="form-label col-xs-4 col-sm-2">产品采购地址：</label>--}}
            {{--<div class="formControls col-xs-8 col-sm-9">--}}
            {{--<input type="text" class="input-text" value="{{$goods_kinds->goods_buy_url}}" placeholder="" id="goods_buy_url" name="goods_buy_url">--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="row cl">--}}
            {{--<label for="goods_buy_msg"  class="form-label col-xs-4 col-sm-2">产品采购备注：</label>--}}
            {{--<div class="formControls col-xs-8 col-sm-9">--}}
            {{--<input type="text" class="input-text" value="{{$goods_kinds->goods_buy_msg}}" placeholder="" id="goods_buy_msg" name="goods_buy_msg">--}}
            {{--</div>--}}
            {{--</div>--}}
            @if(isset($goods_kinds->supplier))
            <div class="row cl">
                <label for="supplier_url" class="form-label col-xs-4 col-sm-2" >供货商地址（链接）：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$goods_kinds->supplier->supplier_url}}" placeholder="" id="supplier_url" name="supplier_url">
                </div>
            </div>
            <div class="row cl">
                <label for="supplier_contact" class="form-label col-xs-4 col-sm-2" >供货商联系人：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="hidden" class="input-text" value="{{$goods_kinds->supplier->supplier_id}}" placeholder="" id="supplier_id" name="supplier_id">
                    <input type="text" class="input-text" value="{{$goods_kinds->supplier->supplier_contact}}" placeholder="" id="supplier_contact" name="supplier_contact">
                </div>
            </div>
            <div class="row cl">
                <label for="supplier_tel" class="form-label col-xs-4 col-sm-2" >供货商电话：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$goods_kinds->supplier->supplier_tel}}" placeholder="" id="supplier_tel" name="supplier_tel">
                </div>
            </div>
            <div class="row cl">
                <label for="supplier_price" class="form-label col-xs-4 col-sm-2" >供货商单价：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$goods_kinds->supplier->supplier_price}}" placeholder="" id="supplier_price" name="supplier_price" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d*\.?\d{0,3})?.*$/,'$1');}).call(this)" onblur="this.v();">
                </div>
            </div>
            <div class="row cl">
                <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >供货商日供货量：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$goods_kinds->supplier->supplier_num}}" placeholder="" id="supplier_num" name="supplier_num" onkeyup="(this.v=function(){this.value=this.value.replace(/[^\d]/g,'');})" onblur="this.v();">
                </div>
            </div>
            <div class="row cl">
                <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >供货商是否现货：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="radio" value="1" placeholder="" id="is_spots" name="is_spots" @if($goods_kinds->supplier->is_spots != 0) checked @endif> 是
                    <input type="radio" value="0" placeholder="" id="is_spots" name="is_spots" @if($goods_kinds->supplier->is_spots == 0) checked @endif> 否
                </div>
            </div>
            <div class="row cl">
                <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >备注信息：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$goods_kinds->supplier->supplier_remark}}" placeholder="" id="supplier_remark" name="supplier_remark">
                </div>
            </div>
                @else
                <div class="row cl">
                    <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >供货商地址（链接）：{{ $goods_kinds->supplier }}</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" value="" placeholder="" id="supplier_url" name="supplier_url" maxlength="255">
                    </div>
                </div>
                <div class="row cl">
                    <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >供货商联系人：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="hidden" class="input-text" value="0" placeholder="" id="supplier_id" name="supplier_id">
                        <input type="text" class="input-text" value="" placeholder="" id="supplier_contact" name="supplier_contact">
                    </div>
                </div>
                <div class="row cl">
                    <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >供货商电话：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" value="" placeholder="" id="supplier_tel" name="supplier_tel">
                    </div>
                </div>
                <div class="row cl">
                    <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >供货商单价：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" value="0" placeholder="" id="supplier_price" name="supplier_price" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d*\.?\d{0,3})?.*$/,'$1');}).call(this)" onblur="this.v();">
                    </div>
                </div>
                <div class="row cl">
                    <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >供货商日供货量：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" value="0" placeholder="" id="supplier_num" name="supplier_num" onkeyup="(this.v=function(){this.value=this.value.replace(/[^\d]/g,'');})" onblur="this.v();">
                    </div>
                </div>
                <div class="row cl">
                    <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >供货商是否现货：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="radio" value="1" placeholder="" id="is_spots" name="is_spots" checked> 是
                        <input type="radio" value="0" placeholder="" id="is_spots" name="is_spots" > 否
                    </div>
                </div>
                <div class="row cl">
                    <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >备注信息：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" value="" placeholder="" id="supplier_remark" name="supplier_remark">
                    </div>
                </div>
            @endif
            @if(isset($goods_kinds->spare_supplier))
            <div class="row cl">
                <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >备用供货商地址（链接）：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="hidden" class="input-text" value="{{$goods_kinds->spare_supplier->supplier_id}}" placeholder="" id="spare_supplier_id" name="spare_supplier_id">
                    <input type="text" class="input-text" value="{{$goods_kinds->spare_supplier->supplier_url}}" placeholder="" id="spare_supplier_url" name="spare_supplier_url">
                </div>
            </div>
            <div class="row cl">
                <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >备用供货商联系人：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$goods_kinds->spare_supplier->supplier_contact}}" placeholder="" id="spare_supplier_contact" name="spare_supplier_contact">
                </div>
            </div>
            <div class="row cl">
                <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >备用供货商电话：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$goods_kinds->spare_supplier->supplier_tel}}" placeholder="" id="spare_supplier_tel" name="spare_supplier_tel">
                </div>
            </div>
            <div class="row cl">
                <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >备用供货商单价：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$goods_kinds->spare_supplier->supplier_price}}" placeholder="" id="spare_supplier_price" name="spare_supplier_price" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d*\.?\d{0,3})?.*$/,'$1');}).call(this)" onblur="this.v();">
                </div>
            </div>
            <div class="row cl">
                <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >备用供货商日供货量：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$goods_kinds->spare_supplier->supplier_num}}" placeholder="" id="spare_supplier_num" name="spare_supplier_num" onkeyup="(this.v=function(){this.value=this.value.replace(/[^\d]/g,'');})" onblur="this.v();">
                </div>
            </div>
            <div class="row cl">
                <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >备用供货商是否现货：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="radio" value="1" placeholder="" id="spare_supplier_is_spots" name="spare_supplier_is_spots" @if($goods_kinds->spare_supplier->is_spots != 0) checked @endif> 是
                    <input type="radio" value="0" placeholder="" id="spare_supplier_is_spots" name="spare_supplier_is_spots" @if($goods_kinds->spare_supplier->is_spots == 0) checked @endif> 否
                </div>
            </div>
            <div class="row cl">
                <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >备用供货商备注信息：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$goods_kinds->spare_supplier->supplier_remark}}" placeholder="" id="spare_supplier_remark" name="spare_supplier_remark">
                </div>
            </div>
                @else
                <div class="row cl">
                    <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >备用供货商地址（链接）：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="hidden" class="input-text" value="0" placeholder="" id="spare_supplier_id" name="spare_supplier_id">
                        <input type="text" class="input-text" value="" placeholder="" id="spare_supplier_url" name="spare_supplier_url" maxlength="255">
                    </div>
                </div>
                <div class="row cl">
                    <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >备用供货商联系人：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" value="" placeholder="" id="spare_supplier_contact" name="spare_supplier_contact">
                    </div>
                </div>
                <div class="row cl">
                    <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >备用供货商电话：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" value="" placeholder="" id="spare_supplier_tel" name="spare_supplier_tel">
                    </div>
                </div>
                <div class="row cl">
                    <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >备用供货商单价：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" value="0" placeholder="" id="spare_supplier_price" name="spare_supplier_price" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d*\.?\d{0,3})?.*$/,'$1');}).call(this)" onblur="this.v();">
                    </div>
                </div>
                <div class="row cl">
                    <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >备用供货商日供货量：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" value="0" placeholder="" id="spare_supplier_num" name="spare_supplier_num" onkeyup="(this.v=function(){this.value=this.value.replace(/[^\d]/g,'');})" onblur="this.v();">
                    </div>
                </div>
                <div class="row cl">
                    <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >备用供货商是否现货：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="radio" value="1" placeholder="" id="spare_supplier_is_spots" name="spare_supplier_is_spots" checked > 是
                        <input type="radio" value="0" placeholder="" id="spare_supplier_is_spots" name="spare_supplier_is_spots" > 否
                    </div>
                </div>
                <div class="row cl">
                    <label for="goods_kind_weight" class="form-label col-xs-4 col-sm-2" >备用供货商备注信息：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" value="" placeholder="" id="spare_supplier_remark" name="spare_supplier_remark">
                    </div>
                </div>
            @endif

            
            {{--隐藏产品名称--}}
             <div class="row cl">
                @if(\App\kind_config::where('kind_primary_id',$goods_kinds->goods_kind_id)->count()<=0)
                    <div class="formControls" style="margin-left: 2%;margin-right: 2%">
                        <input type="button" class="btn btn-default" value="移除产品附加属性" id="addcon" isalive='on'/>
                        <input class="btn btn-default" style="display: none" value="0" id="num"/>
                        <div style="margin:0px auto;border: 1px dashed #000;margin-top: 10px;border-radius: 3%;margin-left:0%; padding: 5px;padding-bottom: 10px;" id="conhtml">
                            <span class="btn btn-primary" title="添加" id="addconfig"><i class="Hui-iconfont">&#xe600;</i></span><span class="btn btn-primary" id="rmconfig" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span><br>
                            <div class="config" attr="newConfig" id="configclo">
                                <div class="row" style="margin-left: 0px;">
                                    属性名: <input type="text" style="width: 25%;margin-top:10px;" class="input-text attribute attrName" attr='goods_config_name[0][msg]' value="颜色" placeholder="" id="goods_config_name" name="goods_config_name[0][goods_config_name]">
                                    英文属性名: <input type="text" style="width: 25%;margin-top:10px;" class="input-text attribute" attr='goods_config_name[0][english_msg]' value="color" placeholder="" id="goods_config_english_name" name="goods_config_name[0][goods_config_english_name]">
                                    <input type="text" style="display: none" class="input-text attribute" value="0" name="num">
                                </div>
                                <div class="con-value">
                                    <div class="row" style="height: 40px;" >
                                        <div class="col-xs-8 col-sm-8" style="display: inline">
                                            <label>属性值:</label> <input type="text" style="width: 26%;margin-top:10px; " class="input-text sexi" value="" placeholder="" id="goods_config" name="goods_config_name[0][msg][0][goods_config]">
                                            <label>英文属性值:</label> <input type="text" style="width: 26%;margin-top:10px; " class="input-text" value="" placeholder="" id="goods_config_english" name="goods_config_name[0][msg][0][goods_config_english]">
                                            <div style="display: inline;display: none;" class="selectSexi"id="selectSexi">
                                                <label>色系:</label>
                                                <select name="goods_config_name[0][msg][0][color]" id="sexi"style="width: 26%;height: 30px; " class="select">
                                                    <option value="">选择色系</option>
                                                    <option value="01">黑色</option>
                                                    <option value="10">灰色</option>
                                                    <option value="20">蓝色</option>
                                                    <option value="30">绿色</option>
                                                    <option value="40">棕色</option>
                                                    <option value="50">红色</option>
                                                    <option value="60">紫色</option>
                                                    <option value="70">黄色</option>
                                                    <option value="80">白色</option>
                                                    <option value="90">混色</option>
                                                </select>
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
                                    <label for="goods_config_name">属性名:</label> <input type="text" @if($v->kind_config_msg == "顏色" || $v->kind_config_msg == "颜色") readonly @endif style="width: 25%;margin-top:10px;" attr='goods_config_name[{{$k}}][msg]' class="input-text attribute attrName" value="{{$v->kind_config_msg}}" placeholder="" id="goods_config_name" name="goods_config_name[{{$k}}][goods_config_name]">
                                    <label for="goods_config_name">英文属性名:</label> <input type="text" style="width: 25%;margin-top:10px;" attr='goods_config_name[{{$k}}][msg]' class="input-text attribute" value="{{$v->kind_config_english_msg}}" placeholder="" id="goods_config_english_name" name="goods_config_name[{{$k}}][goods_config_english_name]">
                                    <input type="text" style="display: none" class="input-text attribute" value="{{$v->kind_config_id}}" name="goods_config_name[{{$k}}][id]">
                                    <input type="text" style="display: none" class="input-text attribute" value="{{count($v->config_msg)}}" name="num">
                                </div>
                                <div id="con-value">
                                    @if(count($v->config_msg) > 0)
                                        @foreach($v->config_msg as $key=>$item)
                                            <div class="row" style="height: 40px;" >
                                                <div class="col-xs-8 col-sm-8" style="display: inline">
                                                    <label>属性值:</label> <input type="text" style="width: 26%;margin-top:10px; " class="input-text sexi" value="{{$item['kind_val_msg']}}" placeholder="" id="goods_config" name="goods_config_name[{{$k}}][msg][{{$key}}][goods_config]">
                                                    <label>英文属性值:</label> <input type="text" style="width: 26%;margin-top:10px; " class="input-text" value="{{$item['kind_val_english_msg']}}" placeholder="" id="goods_config_english" name="goods_config_name[{{$k}}][msg][{{$key}}][goods_config_english]">
                                                    <input type="text" style="display: none " class="input-text" value="{{$item['kind_val_id']}}" name="goods_config_name[{{$k}}][msg][{{$key}}][id]">
                                                    @if(isset($item['color']))
                                                        <input type="text" style="display: none " class="input-text" value="{{$item['kind_val_sku']}}" name="goods_config_name[{{$k}}][msg][{{$key}}][kind_val_sku]">
                                                        {{--<label>色系:</label>--}}
                                                        {{--<select name="goods_config_name[{{$k}}][msg][{{$key}}][color]" id="sexi" style="width: 26%;height: 30px; " class="select">--}}
                                                            {{--<option value="">选择色系</option>--}}
                                                            {{--<option @if($item['color']=='01') selected="selected" @endif value="01">黑色</option>--}}
                                                            {{--<option @if($item['color']=='10') selected="selected" @endif value="10">灰色</option>--}}
                                                            {{--<option @if($item['color']=='20') selected="selected" @endif value="20">蓝色</option>--}}
                                                            {{--<option @if($item['color']=='30') selected="selected" @endif value="30">绿色</option>--}}
                                                            {{--<option @if($item['color']=='40') selected="selected" @endif value="40">棕色</option>--}}
                                                            {{--<option @if($item['color']=='50') selected="selected" @endif value="50">红色</option>--}}
                                                            {{--<option @if($item['color']=='60') selected="selected" @endif value="60">紫色</option>--}}
                                                            {{--<option @if($item['color']=='70') selected="selected" @endif value="70">黄色</option>--}}
                                                            {{--<option @if($item['color']=='80') selected="selected" @endif value="80">白色</option>--}}
                                                            {{--<option @if($item['color']=='90') selected="selected" @endif value="90">混色</option>--}}
                                                        {{--</select>--}}
                                                        <div style="display: inline" class="selectSexi" id="selectSexi">
                                                            <label>色系:</label>
                                                            <select name="goods_config_name[{{$k}}][msg][{{$key}}][color]" id="sexi"style="width: 26%;height: 30px; " class="select">
                                                                <option value="">选择色系</option>
                                                                <option @if($item['color']=='01') selected="selected" @endif value="01">黑色</option>
                                                                <option @if($item['color']=='10') selected="selected" @endif value="10">灰色</option>
                                                                <option @if($item['color']=='20') selected="selected" @endif value="20">蓝色</option>
                                                                <option @if($item['color']=='30') selected="selected" @endif value="30">绿色</option>
                                                                <option @if($item['color']=='40') selected="selected" @endif value="40">棕色</option>
                                                                <option @if($item['color']=='50') selected="selected" @endif value="50">红色</option>
                                                                <option @if($item['color']=='60') selected="selected" @endif value="60">紫色</option>
                                                                <option @if($item['color']=='70') selected="selected" @endif value="70">黄色</option>
                                                                <option @if($item['color']=='80') selected="selected" @endif value="80">白色</option>
                                                                <option @if($item['color']=='90') selected="selected" @endif value="90">混色</option>
                                                            </select>
                                                        </div>
                                                    @endif
                                                </div>
                                                {{--@if($key == 0)--}}
                                                    {{--<div style="display: inline;">--}}
                                                        {{--<span class="btn btn-primary addconfig-value" id="btn_1" style="margin-top:10px; " title="添加" onclick="addConfig(this)"><i class="Hui-iconfont">&#xe600;</i></span><span style="margin-top:10px; " class="btn btn-primary" onclick="rmConfig(this)" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span>--}}
                                                    {{--</div>--}}
                                                @if($k === 0 && isset($item['color']))
                                                    @if($key == 0)
                                                        <div style="display: inline;">
                                                            <span class="btn btn-primary addconfig-value" id="btn_1" style="margin-top:10px; " title="添加" onclick="addConfig(this)"><i class="Hui-iconfont">&#xe600;</i></span><span style="margin-top:10px; " class="btn btn-primary" onclick="rmConfig(this)" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if($key == 0)
                                                    <div style="display: inline;">
                                                        <span class="btn btn-primary addconfig-value" style="margin-top:10px; " title="添加" onclick="addConfig(this)"><i class="Hui-iconfont">&#xe600;</i></span><span style="margin-top:10px; " class="btn btn-primary" onclick="rmConfig(this)" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span>
                                                    </div>
                                                    @endif
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <div id="con-value">
                                            <div class="row" style="height: 40px;" >
                                                <div class="col-xs-8 col-sm-8" style="display: inline">
                                                    <label>属性值:</label> <input type="text" style="width: 26%;margin-top:10px; " class="input-text attribute sexi" value="" placeholder="" id="goods_config" name="goods_config_name[{{$k}}][msg][0][goods_config]">
                                                    <label>英文属性值:</label> <input type="text" style="width: 26%;margin-top:10px; " class="input-text attribute" value="" placeholder="" id="goods_config_english" name="goods_config_name[{{$k}}][msg][0][goods_config_english]">
                                                    <div style="display: inline;display: none;" class="selectSexi"id="selectSexi">
                                                        <label>色系:</label>
                                                        <select name="goods_config_name[0][msg][0][color]" id="sexi"style="width: 26%;height: 30px; " class="select">
                                                            <option value="">选择色系</option>
                                                            <option value="01">黑色</option>
                                                            <option value="10">灰色</option>
                                                            <option value="20">蓝色</option>
                                                            <option value="30">绿色</option>
                                                            <option value="40">棕色</option>
                                                            <option value="50">红色</option>
                                                            <option value="60">紫色</option>
                                                            <option value="70">黄色</option>
                                                            <option value="80">白色</option>
                                                            <option value="90">混色</option>
                                                        </select>
                                                    </div>
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
        // $('#addconfig').on('click',function(){
        //     var configdiv=$('#configclo').clone();
        //     //属性名键值
        //     var a = $('#num').val();
        //     a++;
        //     if (a == 0) {
        //         configdiv.children('.row').find('input:first').attr('name','goods_config_name['+a+'][goods_config_name]');
        //         configdiv.children('.row').find('input').eq(1).attr('name','goods_config_name['+a+'][goods_config_english_name]');
        //         configdiv.children('.row').find('input:first').val('颜色');
        //         configdiv.children('.row').find('input').eq(1).val('color');
        //     } else if(a == 1) {
        //         configdiv.children('.row').find('input:first').attr('name','goods_config_name['+a+'][goods_config_name]');
        //         configdiv.children('.row').find('input').eq(1).attr('name','goods_config_name['+a+'][goods_config_english_name]');
        //         configdiv.children('.row').find('input:first').val('尺码');
        //         configdiv.children('.row').find('input').eq(1).val('size');
        //     } else {
        //         configdiv.children('.row').find('input:first').attr('name','goods_config_name['+a+'][goods_config_name]');
        //         configdiv.children('.row').find('input').eq(1).attr('name','goods_config_name['+a+'][goods_config_english_name]');
        //     }
        //     configdiv.children('.row').find('input').attr('attr','goods_config_name['+a+'][msg]');
        //     configdiv.children('div:last').children('.row').children('.col-sm-8').find('input:first').attr('name','goods_config_name['+a+']'+'[msg][0][goods_config]');
        //     configdiv.children('div:last').children('.row').children('.col-sm-8').find('input').eq(1).attr('name','goods_config_name['+a+']'+'[msg][0][goods_config_english]');
        //     $('#num').val(a);
        //     configdiv.show(200);
        //     $('#conhtml').append(configdiv);
        // })
            // 点击添加属性名
        $('#addconfig').on('click',function(){
            //var configdiv=$(this).next().next().next('div').clone();

            //属性名键值
            var a = $('#num').val();
            a++;
            if(a > 3) {
                layer.msg('产品属性最多添加三组')
                return false;
            }
            if (a == 0) {
                var configdiv=$('#configclo').clone();
                configdiv.children('.row').find('input:first').attr('name','goods_config_name['+a+'][goods_config_name]');
                configdiv.children('.row').find('input').eq(1).attr('name','goods_config_name['+a+'][goods_config_english_name]');
                configdiv.children('.row').find('select').attr('name','goods_config_name['+a+'][color]');
                configdiv.children('.row').find('input:first').val('颜色');
                configdiv.children('.row').find('input').eq(1).val('color');
            } else if(a == 1) {
                var configdiv=$('#configclo_1').clone();
                configdiv.children('.row').find('input:first').attr('name','goods_config_name['+a+'][goods_config_name]');
                configdiv.children('.row').find('input').eq(1).attr('name','goods_config_name['+a+'][goods_config_english_name]');
                configdiv.children('.row').find('input:first').val('尺码');
                configdiv.children('.row').find('input').eq(1).val('size');
            } else {
                var configdiv=$('#configclo_1').clone();
                configdiv.children('.row').find('input:first').attr('name','goods_config_name['+a+'][goods_config_name]');
                configdiv.children('.row').find('input').eq(1).attr('name','goods_config_name['+a+'][goods_config_english_name]');
            }
            configdiv.children('.row').find('input').attr('attr','goods_config_name['+a+'][msg]');
            configdiv.children('div:last').children('.row').children('.col-sm-8').find('input:first').attr('name','goods_config_name['+a+']'+'[msg][0][goods_config]');
            configdiv.children('div:last').children('.row').children('.col-sm-8').find('input').eq(1).attr('name','goods_config_name['+a+']'+'[msg][0][goods_config_english]');

            if (a == 0) {
                configdiv.children('div:last').children('.row').children('.col-sm-8').find('.select').attr('name','goods_config_name['+a+']'+'[msg][0][color]');
            }
            $('#num').val(a);
            configdiv.show(200);
            $('#conhtml').append(configdiv);
        });

        //产品属性值删除
        $("#rmconfig").on('click',function(){
            console.log($('.config:last'));
            if($('.config').length>1 && $('.config:last').attr('attr') == 'newConfig' ){
                $('.config').last().remove();
                var a = $('#num').val();
                a--;
                $('#num').val(a);
            }else{
                layer.msg('已保存产品属性，不可删除');
            }
        });

        // // 新增属性
        // function addConfig(obj){
        //     var configdiv=$('#configclo-value').clone();
        //     //属性值键值
        //     var k = $(obj).parent().parent().parent().prev().find('input:last').val();
        //     //属性值名称
        //     k++;
        //     var msg = $(obj).parent().parent().parent().prev().find('input:first').attr('attr');
        //     configdiv.children('.col-sm-8').find('input:first').attr('name',msg+'['+k+']'+'[goods_config]');
        //     configdiv.children('.col-sm-8').find('input').eq(1).attr('name',msg+'['+k+']'+'[goods_config_english]');
        //     configdiv.show(200);
        //     $(obj).parent().parent().parent().prev().find('input:last').val(k);
        //     $(obj).parent().parent().parent().append(configdiv);
        // }
            // 新增属性
        function addConfig(obj){
            //属性值键值
            var k = $(obj).parent().parent().parent().prev().find('input:last').val();
            //属性值名称
            k++;
            var msg = $(obj).parent().parent().parent().prev().find('input:first').attr('attr');
            // if ($(obj).attr('id') == 'btn_1') {
            console.log($(obj).parent().prev().children(".selectSexi").length)
            if ($(obj).parent().prev().children(".selectSexi").length == 1) {
                var configdiv=$('#configclo-value').clone();
                configdiv.children('.col-sm-8').find('.select').attr('name',msg+'['+k+']'+'[color]');
            } else{
                var configdiv=$('#configclo-value_1').clone();
            }
            configdiv.children('.col-sm-8').find('input:first').attr('name',msg+'['+k+']'+'[goods_config]');
            configdiv.children('.col-sm-8').find('input').eq(1).attr('name',msg+'['+k+']'+'[goods_config_english]');

            configdiv.show(200);
            $(obj).parent().parent().parent().prev().find('input:last').val(k);
            $(obj).parent().parent().parent().append(configdiv);
        }

        // 删除属性(控制原有数据不可删除)
        function rmConfig(obj){
            if($(obj).parent().parent().parent().children("div.row").length>1){
                if($(obj).parent().parent().parent().children("div.row:last").children("div:last").attr('attr') == 'newConfig'){
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
                },
                supplier_url:{
                    maxlength:255,
                },
                spare_supplier_url:{
                    maxlength:255,
                },
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
                                setTimeout("parent.layer.close(index);",100);
                                parent.shuaxin(); 
                            });
                        }else{
                            layer.msg(data.msg);
                        }
                    },
                    error: function(XmlHttpRequest, textStatus, errorThrown){
                        layer.close(indexs);
                        layer.msg('error!');
                    }});
            }
        });
        $('body').on('input propertychange','.sexi',function(){
            var arr=$(this).val();
            if(arr.length==0){
                $(this).parent().children("div:last").children("select:last").val("")
            }
            console.log(arr)
            var aa = false;
            for (let i = 0; i < arr.length; i++) {
                var a=arr.substr(i,1)
                switch (a){
                    case "黑":
                        // $("#sexi").val("00")
                        $(this).parent().children("div:last").children("select:last").val("01")
                        aa=true
                        break;
                    case "灰":
                        $(this).parent().children("div:last").children("select:last").val("10")
                        aa=true
                        break;
                    case "蓝":
                        $(this).parent().children("div:last").children("select:last").val("20")
                        aa=true
                        break;
                    case "绿":
                        $(this).parent().children("div:last").children("select:last").val("30")
                        aa=true
                        break;
                    case "棕":
                        $(this).parent().children("div:last").children("select:last").val("40")
                        aa=true
                        break;
                    case "红":
                        $(this).parent().children("div:last").children("select:last").val("50")
                        aa=true
                        break;
                    case "紫":
                        $(this).parent().children("div:last").children("select:last").val("60")
                        aa=true
                        break;
                    case "黄":
                        $(this).parent().children("div:last").children("select:last").val("70")
                        aa=true
                        break;
                    case "白":
                        $(this).parent().children("div:last").children("select:last").val("80")
                        aa=true
                        break;
                    case "混":
                        $(this).parent().children("div:last").children("select:last").val("90")
                        aa=true
                        break;
                    default:
                        $(this).parent().children("div:last").children("select:last").val("")
                }
                if(aa){
                    break;
                }

            }
        })
        $('body').on('input propertychange','.attrName',function(){
            var a=$(this).val();
            var msg = $(this).parent().find('input:first').attr('attr');
            if(a=='颜色' || a=='顏色'){
                var arr=$(this).parent().next().children().children("div.col-sm-8").length;
                for (var i = 0; i < arr; i++) {
                    var configdiv=$('#selectSexi').clone();
                    configdiv.css('display','inline');
                    $(configdiv).find('select').attr('name',msg+'['+i+']'+'[color]');
                    $($(this).parent().next().children().children("div.col-sm-8").get(i)).append(configdiv);
                }
            }else{
                $(this).parent().next().find(".selectSexi").remove()
            }

        })
    </script>
