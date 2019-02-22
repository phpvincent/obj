    <br>
@foreach($goods_kinds as $k => $goods_kind)
    <table class="table table-border table-bordered table-bg">
                    <tr  class="text-c">
                        <th>名</th>
                        <th>值</th>
                    </tr>
                    <tr class="text-c">
                        <td>产品id</td>
                        <td>{{$goods_kind->goods_kind_id}}</td>
                    </tr>
                    <tr class="text-c">
                        <td>产品名</td>
                        <td>{{$goods_kind->goods_kind_name}}</td>
                    </tr>
                    <tr class="text-c">
                        <td>产品类型</td>
                        <td>{{\App\product_type::where('product_type_id',$goods_kind->goods_product_id)->first()['product_type_name']}}</td>
                    </tr>
                    <tr class="text-c">
                        <td>产品SKU</td>
                        <td>{{$goods_kind->goods_kind_sku}}</td>
                    </tr>
                    <tr class="text-c">
                        <td>产品上线时间</td>
                        <td>{{$goods_kind->goods_kind_time}}</td>
                    </tr>
                    <tr class="text-c">
                        <td>产品发布人</td>
                        <td>{{\App\admin::select('admin_show_name')->where('admin_id',$goods_kind->goods_kind_admin)->first()['admin_show_name']}}</td>
                    </tr>
                    <tr class="text-c">
                        <td>产品受众</td>
                        <td>
                            @if($goods_kind->goods_kind_user_type==0)
                            通用
                            @elseif($goods_kind->goods_kind_user_type==1)
                            男士
                            @elseif($goods_kind->goods_kind_user_type==2)
                            女士
                            @elseif($goods_kind->goods_kind_user_type==3)
                            男童
                            @elseif($goods_kind->goods_kind_user_type==4)
                            女童
                            @elseif($goods_kind->goods_kind_user_type==5)
                            男老
                            @elseif($goods_kind->goods_kind_user_type==6)
                            女老
                            @else
                            通用
                            @endif
                        </td>
                        <td>{{\App\admin::select('admin_show_name')->where('admin_id',$goods_kind->goods_kind_admin)->first()['admin_show_name']}}</td>
                    </tr>
                    <tr class="text-c">
                        <td>产品名下单品数</td>
                       <!--  <td>{{\App\goods::where('goods_kind_id',$goods_kind->goods_kind_id)->count()}}</td> -->
                        <td>
                            <a title="商品列表" href="javascript:;" onclick="goods_info('http://52.14.183.239/admin/goods/index?id={{$goods_kind->goods_kind_id}}','{{\App\goods::where('goods_kind_id',$goods_kind->goods_kind_id)->count()}}')" class="ml-5"><span class="label label-default radius" style="background-color:#ccc;color:red;">1</span></a>
                        </td>
                    </tr>
                    <tr class="text-c">
                        <td>产品图片</td>
                        <td>@if($goods_kind->goods_kind_img!=null&&$goods_kind->goods_kind_img!='')
                            <img alt="产品图片" src="/{{$goods_kind->goods_kind_img}}" target="_blank" width="50px">
                            @else
                            暂无产品图片
                            @endif</td>
                    </tr>
                    <tr class="text-c">
                        <td>产品SKU绑定状态</td>
                        <td>
                                @if($goods_kind->goods_kind_sku_status==0) 
                                    <span color='green' style="color:green;">正常</span> 
                                @elseif($goods_kind->goods_kind_sku_status==1) 
                                    <span style="color:#ccc;"">已被释放</span> 
                                @else 
                                    <span style=" color:brown"">使用被释放的SKU</span> 
                                @endif
                        </td>
                    </tr>
        <tr class="text-c"><td>产品属性</td><td>
                @if($goods_kind->attrs)
                @foreach($goods_kind->attrs as $attr)
              @if(in_array($attr->kind_val_id,$goods_kind->current_attrs)) <span style="color:red;"> {{ $attr->kind_val_msg }}  √ </span>@else {{ $attr->kind_val_msg }} @endif<br>
                @endforeach
                @endif
            </td></tr>
    </table>
    <br>
    <hr>
    <br>
    <p>

    </p>
@endforeach