@extends('admin.father.css')
@section('content')
    <style>
        /* 搜索下拉框 */
        .box{
            position: absolute;
            top: 36px;
            z-index: 999;
            width: 100%;
            overflow-y: auto;
            padding-right: 30px;
            box-sizing: border-box;
            height: 132px;
            border: 1px solid #ddd;
            background:#fff;
        }
        .box ul{

            background-color: #fff;
        }
        .box li{
            padding: 0 15px;
            cursor:pointer;
        }
        .box li:nth-child(odd){background:#F4F4F4;}
        .deletes,.xinpin_deletes,.miaosha_deletes,.remai_deletes{
            cursor: pointer;
        }
        .xinpin_add,.miaosha_add,.remai_add{
            cursor: pointer;
            display: inline-block;
            margin-left:6px;
            border:1px solid #666;
            padding:2px 6px;
        }
        .title{
            font-size:20px;
            color:#333
        }
    </style>
    <article class="page-container">
        <form class="form form-horizontal" id="form-role-update" enctype="multipart/form-data" action="{{url('admin/sites/post_update')}}" method="post">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>站点名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" readonly class="input-text" value="{{$site->sites_name}}" placeholder="" id="site_name" name="site_name">
                    <input type="text" style="display: none" class="input-text" value="{{$site->sites_id}}" placeholder="" id="site_id" name="site_id">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>模板类型：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
					<select name="goods_blade_type" id="goods_blade_type" class="select">
						<option value="0" @if($site->sites_blade_type=='0') selected="selected" @endif>0--台湾模板</option>
						<option value="1" @if($site->sites_blade_type=='1') selected="selected" @endif>1--简体模板</option>
						<option value="2" @if($site->sites_blade_type=='2') selected="selected" @endif>2--阿联酋模板</option>
						<option value="3" @if($site->sites_blade_type=='3') selected="selected" @endif>3--马来西亚模板</option>
						<option value="4" @if($site->sites_blade_type=='4') selected="selected" @endif>4--泰国模板（旧版）</option>
						<option value="5" @if($site->sites_blade_type=='5') selected="selected" @endif>5--日本模板（旧版）</option>
						<option value="6" @if($site->sites_blade_type=='6') selected="selected" @endif>6--印度尼西亚</option>
						<option value="7" @if($site->sites_blade_type=='7') selected="selected" @endif>7--菲律宾</option>
						<option value="8" @if($site->sites_blade_type=='8') selected="selected" @endif>8--英国（旧版）</option>
						<option value="9" @if($site->sites_blade_type=='9') selected="selected" @endif>9--Google-PC（旧版）</option>
						<option value="10" @if($site->sites_blade_type=='10') selected="selected" @endif>10--美国（旧版）</option>
						<option value="11" @if($site->sites_blade_type=='11') selected="selected" @endif>11--越南（旧版）</option>
						<option value="12" @if($site->sites_blade_type=='12') selected="selected" @endif>12--沙特</option>
						<option value="13" @if($site->sites_blade_type=='13') selected="selected" @endif>13--沙特英文</option>
						<option value="14" @if($site->sites_blade_type=='14') selected="selected" @endif>14--卡塔尔</option>
						<option value="15" @if($site->sites_blade_type=='15') selected="selected" @endif>15--卡塔尔英文</option>
						<option value="16" @if($site->sites_blade_type=='16') selected="selected" @endif>16--中东阿语</option>
						<option value="17" @if($site->sites_blade_type=='17') selected="selected" @endif>17--中东英语</option>
					</select>
					</span> </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>站点轮播图：</label>
                <span class="c-red" style="display: inline-block;height: 30px;line-height: 30px;">注意：轮播图片宽：730像素，高：400像素</span>
                <div style="margin:0 auto; width: 73%;margin-left:18%; " id="pzhtml">
                    <input type="button" class="btn btn-default" value="增加轮播图" id="addpz" style="margin-left:18%;" />
                    <input type="text" style="width: 10%;margin-top:10px;display: none" class="input-text attribute" value="{{count($site_imgs)}}" id="num" name="num">
                    @foreach($site_imgs as $k=>$site_img)
                    <div  style="margin-top:6px;position: relative; " >
                        <div>
                            关联商品:<input type="text" style="width: 10%;" class="input-text chanpin"  value="{{$site_img->goods_real_name}}" placeholder="" id="chanpin_prize">
                            <input type="text" style="display: none;" class="input-text chanpin" autocomplete="off" id="goods_kind" name="goods[{{$k}}]" value="{{$site_img->site_goods_id}}">
                            <input type="text" style="display: none;" class="input-text lunbo" autocomplete="off" name="site_img_id[{{$k}}]" value="{{$site_img->site_img_id}}">
                            轮播图片:<input type="file" id="size_file" style="width: 22%;" class="input-text" value="" placeholder="" name="size_file[{{$k}}]" accept="image/png,image/gif,image/jpg,image/jpeg">
                            <span class="deletes"><i class="Hui-iconfont"></i></span>
                        </div>
                        <div class="box" style="display: none;">
                            <ul>
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-2 col-sm-2"><span class="c-red">*</span>站点分类：</label>
                <div class="col-xs-10 col-sm-10">
                    @foreach($site_class as $item)
                        <div style="margin-top: 10px">
                            <label>商品分类:</label> <input type="text" readonly style="width: 20%;vertical-align:middle; " class="input-text" value="{{$item->goods_type_name}}" placeholder="" id="goods_config">
                            <input type="text" style="display: none" class="input-text" value="{{$item->goods_type_id}}" name="goods_type_id[{{$item->goods_type_id}}]" id="goods_config">
                            <input type="text" style="display: none" class="input-text" value="{{$item->site_class_id}}" name="site_class_id[{{$item->goods_type_id}}]" id="goods_config">
                            <label>展示分类:</label> <input type="text" style="width: 20%;vertical-align:middle; " class="input-text" value="{{$item->site_class_show_name}}" placeholder="" id="goods_config" name="goods_type_show_name[{{$item->goods_type_id}}]">
                            <label>排序:</label> <input type="text" style="width: 15%;vertical-align:middle; " class="input-text" value="{{$item->site_class_sort}}" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d{0,4})?.*$/,'$1');}).call(this)" onblur="this.v();"  id="goods_config" name="goods_type_sort[{{$item->goods_type_id}}]">
                            <input type="checkbox" @if($item->site_is_show=='0') checked @endif id="config_isshow" class="price" name="goods_type_isshow[{{$item->goods_type_id}}]" style="vertical-align:middle;cursor:pointer;" value="1"><label for="price">隐藏分类</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>特殊分类：</label>
                <div class="col-xs-10 col-sm-10">
                    <div class="miaosha" style="margin-top:10px">
                        <div>
                            <label class="title" for="">秒杀抢购</label><span class="miaosha_add">添加</span>
                            <div style="margin-top:10px;position: relative;">
                                秒杀抢购图片：<input type="file" id="size_file" style="width: 22%;vertical-align:middle;margin-bottom: 10px" value="" placeholder="" name="site_active[2][img]" accept="image/png,image/gif,image/jpg,image/jpeg">
                                <input type="text" style="display: none" id="zeno_sell" value="{{isset($site_active[2]['goods']) ? count($site_active[2]['goods']) : 0}}">
                                <input type="text" style="display: none" name="site_active[2][site_active_id]" value="{{isset($site_active[2]['site_active_id']) ? $site_active[2]['site_active_id'] : ""}}">
                            </div>
                        </div>
                        <span class="c-red" style="display: inline-block;height: 30px;line-height: 30px;">注意：新品推荐图片宽：308像素，高：380像素</span>
                        @if(!empty($site_active[2]['goods']))
                            @foreach($site_active[2]['goods'] as $key => $val)
                                <div class="miaosha_1" style="margin-top:10px;    position: relative;">
                                    <div>
                                        关联商品:<input type="text" style="width: 10%;" class="input-text chanpin"  value="{{$val['goods_name']}}" placeholder="" id="chanpin_prize">
                                        <input type="text" style="display: none;" class="input-text chanpin"autocomplete="off" id="goods_kind" name="site_active[2][goods_id][{{$key}}]" value="{{$val['site_good_id']}}">
                                        <input type="text" style="display: none;" class="input-text" autocomplete="off" name="site_active[2][site_active_good_id][{{$key}}]" value="{{$val['site_active_good_id']}}">
                                        <label>排序:</label> <input type="text" style="width: 15%;vertical-align:middle; " class="input-text" value="{{$val['sort']}}" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d{0,4})?.*$/,'$1');}).call(this)" onblur="this.v();"  id="goods_config" name="site_active[2][sort][{{$key}}]">
                                        <span class="xinpin_deletes" style="margin-left:8px"><i class="Hui-iconfont"></i></span>
                                    </div>
                                    <div class="box" style="display: none;">
                                        <ul>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        @else
                        @endif
                    </div>
                    <div class="xinpin">
                        <div>
                            <label class="title" for="">新品推荐</label><span class="xinpin_add">添加</span>
                            <div style="margin-top:10px;position: relative;">
                                新品推荐图片：<input type="file" id="size_file" style="width: 22%;vertical-align:middle;margin-bottom: 10px" value="" placeholder="" name="site_active[1][img]" accept="image/png,image/gif,image/jpg,image/jpeg">
                                <input type="text" style="display: none" id="new_sell" value="{{isset($site_active[1]['goods']) ? count($site_active[1]['goods']) : 0}}">
                                <input type="text" style="display: none" name="site_active[1][site_active_id]" value="{{isset($site_active[1]['site_active_id']) ? $site_active[1]['site_active_id'] : ''}}">
                            </div>
                        </div>
                        <span class="c-red" style="display: inline-block;height: 30px;line-height: 30px;">注意：秒杀抢购图片宽：308像素，高：190像素</span>
                    @if(!empty($site_active[1]['goods']))
                            @foreach($site_active[1]['goods'] as $key => $val)
                            <div style="margin-top:10px;    position: relative;">
                                <div>
                                    关联商品:<input type="text" style="width: 10%;" class="input-text chanpin"  value="{{$val['goods_name']}}" placeholder="" id="chanpin_prize">
                                    <input type="text" style="display: none;" class="input-text chanpin" autocomplete="off" id="goods_kind" name="site_active[1][goods_id][{{$key}}]" value="{{$val['site_good_id']}}">
                                    <input type="text" style="display: none;" class="input-text" autocomplete="off" name="site_active[1][site_active_good_id][{{$key}}]" value="{{$val['site_active_good_id']}}">
                                    <label>排序:</label> <input type="text" style="width: 15%;vertical-align:middle; " class="input-text" value="{{$val['sort']}}" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d{0,4})?.*$/,'$1');}).call(this)" onblur="this.v();"  id="goods_config" name="site_active[1][sort][{{$key}}]">
                                    <span class="xinpin_deletes" style="margin-left:8px"><i class="Hui-iconfont"></i></span>
                                </div>
                                <div class="box" style="display: none;">
                                    <ul>
                                    </ul>
                                </div>
                            </div>
                            @endforeach
                        @else

                        @endif
                    </div>
                    <div class="remai" style="margin-top:10px">
                        <div>
                            <label class="title" for="">热卖推荐</label><span class="remai_add">添加</span>
                            <div style="margin-top:10px;position: relative;">
                                热卖推荐图片：<input type="file" id="size_file" style="width: 22%;vertical-align:middle;margin-bottom: 10px" value="" placeholder="" name="site_active[3][img]" accept="image/png,image/gif,image/jpg,image/jpeg">
                                <input type="text" style="display: none" id="fire_sell" value="{{isset($site_active[3]['goods']) ? count($site_active[3]['goods']) : 0}}">
                                <input type="text" style="display: none" name="site_active[3][site_active_id]" value="{{isset($site_active[3]['site_active_id']) ? $site_active[3]['site_active_id'] : ''}}">
                            </div>
                        </div>
                        <span class="c-red" style="display: inline-block;height: 30px;line-height: 30px;">注意：热卖推荐图片宽：308像素，高：190像素</span>
                    @if(!empty($site_active[3]['goods']))
                            @foreach($site_active[3]['goods'] as $key => $val)
                            <div style="margin-top:10px;    position: relative;">
                                <div>
                                    关联商品:<input type="text" style="width: 10%;" class="input-text chanpin"  value="{{$val['goods_name']}}" placeholder="" id="chanpin_prize">
                                    <input type="text" style="display: none;" class="input-text chanpin" autocomplete="off" id="goods_kind" name="site_active[3][goods_id][{{$key}}]" value="{{$val['site_good_id']}}">
                                    <input type="text" style="display: none;" class="input-text" autocomplete="off" name="site_active[3][site_active_good_id][{{$key}}]" value="{{$val['site_active_good_id']}}">
                                    <label>排序:</label> <input type="text" style="width: 15%;vertical-align:middle; " class="input-text" value="{{$val['sort']}}" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d{0,4})?.*$/,'$1');}).call(this)" onblur="this.v();"  id="goods_config" name="site_active[3][sort][{{$key}}]">
                                    <span class="xinpin_deletes" style="margin-left:8px"><i class="Hui-iconfont"></i></span>
                                </div>
                                <div class="box" style="display: none;margin-top: 25px">
                                    <ul>
                                    </ul>
                                </div>
                            </div>
                            @endforeach
                        @else

                        @endif
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">站点热搜词：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea rows="3" cols="110" placeholder="热搜词格式：男士豆豆鞋,女士豆豆鞋；每个热搜词以 ',' 隔开" name="site_fire_word">{{$site->site_fire_word}}</textarea>
                    {{--<input type="text" class="input-text" value="" placeholder="" id="site_name" name="site_name">--}}
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
                site_name:{
                    required:true,
                },
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                var indexs=layer.load(2, {shade: [0.15, '#393D49']});
                $(form).ajaxSubmit({
                    type: 'post',
                    url: "{{url('admin/sites/post_update')}}",
                    success: function(data){
                        layer.close(indexs);
                        if(data.err==1){
                            layer.msg('修改成功!',{time:2*1000},function() {
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
        var index=1;
        $("#addpz").on("click",function(){
            var a = $('#num').val();
            a++;
            var html='<div  style="margin-top:6px;    position: relative; " >'
                +'<div>'
                +'关联商品:<input type="text"style="width: 10%;" class="input-text chanpin"  value="" placeholder="" id="chanpin_prize">'
                +'<input type="text" style="display: none;" class="input-text chanpin"autocomplete="off" id="goods_kind" name="goods['+ a +']" value="">'
                +'轮播图片:<input type="file" id="size_file"style="width: 22%;" class="input-text" value="" placeholder=""name="size_file['+ a +']" accept="image/png,image/gif,image/jpg,image/jpeg">'
                +'<span class="deletes"><i class="Hui-iconfont"></i></span>'
                +'</div>'
                +'<div class="box" style="display: none;">'
                +'<ul>'
                +'</ul>'
                +'</div>'
                +'</div>';
            $('#num').val(a);
            $("#pzhtml").append(html);
            index+=1;
        });
        $('body').on("click",".deletes",function(){
            $(this).parent().parent().remove();
        })
        // 新品推荐添加
        $('.xinpin_add').on("click",function(){
            var b = $('#new_sell').val();
            b++;
            var html = '<div style="margin-top:10px; position: relative;">'
                +'<div>'
                +'关联商品:<input type="text"style="width: 10%;" class="input-text chanpin" name=""  value="" placeholder="" id="chanpin_prize">'
                +'<input type="text" style="display: none;" class="input-text chanpin"autocomplete="off" id="goods_kind" name="site_active[1][goods_id]['+ b +']" value="">'
                +'<label>排序:</label> <input type="text" style="width: 15%;vertical-align:middle; " class="input-text" value="0" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\\d{0,4})?.*$/,\'$1\');}).call(this)" onblur="this.v();"  id="goods_config" name="site_active[1][sort]['+ b +']">'
                +'<span class="xinpin_deletes" style="margin-left:8px"><i class="Hui-iconfont"></i></span>'
                +'</div>'
                +'<div class="box" style="display: none;">'
                +'<ul>'
                +'</ul>'
                +'</div>'
                +'</div>';
            $('#new_sell').val(b);
            $('.xinpin').append(html)
        });
        $('body').on("click",".xinpin_deletes",function(){
            $(this).parent().parent().remove();
        });
        // 秒杀添加
        $(".miaosha_add").click(function () {
            var c = $('#zeno_sell').val();
            c++;
            var html = '<div style="margin-top:10px; position: relative;">'
                +'<div>'
                +'关联商品:<input type="text"style="width: 10%;" class="input-text chanpin" name=""  value="" placeholder="" id="chanpin_prize">'
                +'<input type="text" style="display: none;" class="input-text chanpin"autocomplete="off" id="goods_kind" name="site_active[2][goods_id]['+ c +']" value="">'
                +'<label>排序:</label> <input type="text" style="width: 15%;vertical-align:middle; " class="input-text" value="0" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\\d{0,4})?.*$/,\'$1\');}).call(this)" onblur="this.v();"  id="goods_config" name="site_active[2][sort]['+ c +']">'
                +'<span class="xinpin_deletes" style="margin-left:8px"><i class="Hui-iconfont"></i></span>'
                +'</div>'
                +'<div class="box" style="display: none;">'
                +'<ul>'
                +'</ul>'
                +'</div>'
                +'</div>';
            $('#zeno_sell').val(c);
            $('.miaosha').append(html)
        });
        $('body').on("click",".miaosha_deletes",function(){
            $(this).parent().parent().remove();
        })
        // 热卖添加
        $('.remai_add').on("click",function(){
            var d = $('#fire_sell').val();
            d++;
            console.log(d+"mmmmmmm");
            var html = '<div style="margin-top:10px; position: relative;">'
                +'<div>'
                +'关联商品:<input type="text"style="width: 10%;" class="input-text chanpin" name=""  value="" placeholder="" id="chanpin_prize">'
                +'<input type="text" style="display: none;" class="input-text chanpin"autocomplete="off" id="goods_kind" name="site_active[3][goods_id]['+ d +']" value="">'
                +'<label>排序:</label> <input type="text" style="width: 15%;vertical-align:middle; " class="input-text" value="0" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\\d{0,4})?.*$/,\'$1\');}).call(this)" onblur="this.v();"  id="goods_config" name="site_active[3][sort]['+ d +']">'
                +'<span class="xinpin_deletes" style="margin-left:8px"><i class="Hui-iconfont"></i></span>'
                +'</div>'
                +'<div class="box" style="display: none;">'
                +'<ul>'
                +'</ul>'
                +'</div>'
                +'</div>';
            $('#fire_sell').val(d);
            $('.remai').append(html)
        })
        $('body').on("click",".remai_deletes",function(){
            $(this).parent().parent().remove();
        })
        // 搜索下拉框
        $("body").on('focus','.chanpin',function(){
            $(this).parent().next().show(400)  ;
            var datathis= $(this).parent().next().children("ul");
            // $('.box_+id').show(400);
            var a=$(this).val();
            var goods_blade_type = $('#goods_blade_type').val();
            $.ajax({
                //请求方式
                type:'GET',
                url:'{{url("admin/vis/get_goods_name")}}?name='+a+'&goods_blade_type='+goods_blade_type,
                dataType:'json',
                data:{},
                success:function(data){
                    xialaCheck =false;
                    var str='';
                    jQuery.each(data.data,function(key,value){

                        str+='<li data-id='+value.goods_id + '>' + value.goods_real_name + '</li>'

                    })
                    // $('.box ul').html(str);
                    datathis.html(str);
                },
                error:function(jqXHR){

                }
            });
        });
        // function xiala(){
        $('body').on('input propertychange','.chanpin', function() {
            $(this).next('#goods_kind').val('');
            var datathis= $(this).parent().next().children("ul");
            datathis.empty();
            $(this).parent().next().show(400);
            var a=$(this).val();
            var goods_blade_type = $('#goods_blade_type').val();
            $.ajax({
                //请求方式
                type:'GET',
                url:'{{url("admin/vis/get_goods_name")}}?name='+a+'&goods_blade_type='+goods_blade_type,
                dataType:'json',
                data:{},
                success:function(data){
                    var str='';
                    if(data.data.length !=0 ){
                        // xialaCheck =false;
                        var str='';
                        jQuery.each(data.data,function(key,value){

                            str+='<li data-id='+value.goods_id + '>' + value.goods_real_name + '</li>'

                        })
                        datathis.html(str);
                    }else{
                        datathis.html('<span >没有相应产品</span>');
                    }
                },
                error:function(jqXHR){

                }
            });
        })

        $('body').on('blur','.chanpin',function(){
            var ab=$(this).next().val();
            if( ab ==''){
                $(this).val('')
            }
            $('.box').hide(400);
        });
        $('body').on('mousedown','.box li',function(){

            $('.box').hide(400);
            var content=$(this).text();
            var content_id=$(this).attr('data-id');
            $(this).parent().parent().prev().find(".chanpin").val(content);
            $(this).parent().parent().prev().find("#goods_kind").val(content_id);
            // $('.chanpin').val(content);
            // $('#goods_kind').val(content_id);
            $('.box ul').empty();
        })

        //模板、商品联动
        $('#goods_blade_type').on('change',function () {
            // var tab = $(this).val();
            $('.chanpin').val('');
            $('.lunbo').val('');
        })

    </script>
@endsection