@extends('admin.father.css')
@section('content')
    <article class="page-container">
        <form class="form form-horizontal" id="order_type_change" action="{{url('admin/message/send_phone')}}" method="post">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-2 col-sm-2"><span class="c-red">*</span>选择国家：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    {{--<input type="text" name="order_tel" value="" id="order_tel" class="input-text valid"><span class="c-red">请检查手机号的格式是否正确</span>--}}
                    <select name="area" id="area" class="input-text valid">
                        <option value="0">大陆</option>
                        <option value="1">台湾</option>
                        <option value="2">菲律宾</option>
                        <option value="3">阿联酋</option>
                        <option value="4">沙特</option>
                        <option value="5">卡塔尔</option>
                        <option value="6">马来西亚</option>
                        <option value="7">泰国</option>
                        <option value="8">日本</option>
                        <option value="9">印度尼西亚</option>
                        <option value="10">美国</option>
                        <option value="11">英国</option>
                        <option value="12">越南</option>
                    </select>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-2 col-sm-2"><span class="c-red">*</span>手机号（一个）：</label>
                <div class="formControls col-xs-8 col-sm-9">

                <div class="formControls col-xs-3 col-sm-3" style="padding-left: 0;">
                    {{--<input type="text" name="order_tel" value="" id="order_tel" class="input-text valid"><span class="c-red">请检查手机号的格式是否正确</span>--}}
                    <select name="region" id="region" class="input-text valid">
                        <option value="86">86</option>
                        <option value="886">886</option>
                        <option value="63">63</option>
                        <option value="971">971</option>
                        <option value="966">966</option>
                        <option value="974">974</option>
                        <option value="60">60</option>
                        <option value="66">66</option>
                        <option value="81">81</option>
                        <option value="62">62</option>
                        <option value="1">1</option>
                        <option value="44">44</option>
                        <option value="84">84</option>
                    </select>
                </div>
                <div class="formControls col-xs-9 col-sm-9">
                    <input type="text" name="order_tel" value="" id="order_tel" class="input-text valid">
                </div>
                    <span class="c-red">请检查手机号的格式是否正确</span>
                    <span>
				<br>国际区号+移动号码，国际区号通过选择国家获取，移动号码前不比加0（适用于全球所有国家）。
				<br>正确示例：大陆国际区号是86 移动号码10086
				<br>错误示例：大陆国际区号是86 移动号码8610086，010086
			</span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-2 col-sm-2"><span class="c-red">*</span>推送内容：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea type="text" class="textarea"  cols="" rows="" value="" placeholder="" id="content" name="content" maxlength="134" dragonfly="true"></textarea>
                    <p class="textarea-numberbar"><em class="textarea-length">0</em>/134</p>
                    <span class="c-red">请将短信内容控制在一条以内</span>
                    <span>
				 <br>计费标准：
				<br>国内短信：支持中英文，70个字符/条，长短信（＞70字符时）按照67个字符/条；
				<br>国际短信：英文：140个字符/条，长短信（＞140字符时）按照134个字符/条，英文短信中出现非ASCII编码字符，按照国内短信计费方式计费； 除英文以外的其他语言按照国内短信计费方式计费。
			</span>

                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-2 col-sm-offset-2">
                    <input class="btn btn-primary size-XL radius" type="submit" value="&nbsp;&nbsp;发&nbsp;送&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </article>
@endsection
@section('js')
    <script type="text/javascript">
        //国家联动区号
        $('#area').change(function () {
            var tab = $(this).val();
            switch (tab) {
                case '0': //大陆 86
                    $('#region').val(86);
                    break;
                case '1': //台湾 886
                    $('#region').val(886);
                    break;
                case '2': //菲律宾 63
                    $('#region').val(63);
                    break;
                case '3': //阿联酋 971
                    $('#region').val(971);
                    break;
                case '4': //沙特 966
                    $('#region').val(966);
                    break;
                case '5': //卡塔尔 974
                    $('#region').val(974);
                    break;
                case '6': //马来西亚
                    $('#region').val(60);
                    break;
                case '7': //泰国 66
                    $('#region').val(66);
                    break;
                case '8': //日本 81
                    $('#region').val(81);
                    break;
                case '9': //印度尼西亚 62
                    $('#region').val(62);
                    break;
                case '10': //美国 1
                    $('#region').val(1);
                    break;
                case '11': //英国 44
                    $('#region').val(44);
                    break;
                case '12': //越南 84
                    $('#region').val(84);
                    break;
            }
        });
        //区号联动国家
        $('#region').change(function () {
            var tab = $(this).val();
            switch (tab) {
                case '86': //大陆 86
                    $('#area').val(0);
                    break;
                case '886': //台湾 886
                    $('#area').val(1);
                    break;
                case '63': //菲律宾 63
                    $('#area').val(2);
                    break;
                case '971': //阿联酋 971
                    $('#area').val(3);
                    break;
                case '966': //沙特 966
                    $('#area').val(4);
                    break;
                case '974': //卡塔尔 974
                    $('#area').val(5);
                    break;
                case '60': //马来西亚 60
                    $('#area').val(6);
                    break;
                case '66': //泰国 66
                    $('#area').val(7);
                    break;
                case '81': //日本 81
                    $('#area').val(8);
                    break;
                case '62': //印度尼西亚 62
                    $('#area').val(9);
                    break;
                case '1': //美国 1
                    $('#area').val(10);
                    break;
                case '44': //英国 44
                    $('#area').val(11);
                    break;
                case '84': //越南 84
                    $('#area').val(12);
                    break;
            }
        });

        $('#order_type_change').submit(function(){
            var order_tel= $('#order_tel').val();
            var content=$('#content').val();
            var patt = /^\d+$/;
            var patt2 = /^0\d+$/;
            if (isNull(order_tel) || !patt.test(order_tel) || patt2.test(order_tel)) {
                layer.msg("手机号不合法！");
                return false;
            }
            // console.log(content.length);
            if(isNull(content) || content.length > 134) {
                layer.msg("推送内容长度不合法！");
                return false;
            }
            var indexs = layer.load(2, {shade: [0.15, '#393D49']})
            $('#order_type_change').ajaxSubmit({
                type: 'post',
                url: "{{url('admin/message/send_phone')}}",
                success: function(data){
                    layer.close(indexs);
                    if(data.err===0){
                        layer.msg('发送成功!',{time:2*1000},function() {
                            //回调
                            $('#region').val(86);
                            $('#area').val(0);
                            $('#content').val("");
                            $('#order_tel').val("");
                        });
                        // layer.msg(data.str)
                    }else{
                        layer.msg(data.str)
                    }
                },
                error: function(XmlHttpRequest, textStatus, errorThrown){
                    layer.close(indexs);
                    layer.msg('error!');
                }
            });
            return false;
        })
        function isNull(data){
            return (data == "" || data == undefined || data == null) ? true: false;
        }
    </script>
@endsection