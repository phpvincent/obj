@extends('admin.father.css')
<style>
    .border-color{
        border: 1px solid #333333;
    }
</style>
@section('content')
    <article class="page-container">
        <table class="table table-border table-bordered table-bg">
                <tr  class="text-c">
                    <th>产品唯一SKU前缀(整体SKU码前四位)</th>
                    <th>当前状态</th>
                </tr>
                
                    <tr class="text-c">
                        <td rowspan = '2'>{{$goods_kind->goods_kind_sku }}</td>
                        <td rowspan = '2'>@if($goods_kind->goods_kind_sku_status==0) <span color='green'>正常</span> @elseif($goods_kind->goods_kind_sku_status==1) <span style="color:#ccc;">已被释放</span> @else <span style="color:brown;">重用SKU</span> @endif </td>
                    </tr>
               
        </table>
        @if($goods_kind->attrs)
            <table class="table table-border table-bordered table-bg">
            <tr class="text-c">
                <th>产品属性名/产品英文属性值</th><th>产品属性值/产品英文属性值</th><th>sku</th>
            </tr>

        @foreach($goods_kind->attrs as $attr)
            <tr class="text-c">
                <td>{{ $attr->kind_config_msg }}/{{ $attr->kind_config_english_msg }}</td>
                <td>{{ $attr->kind_val_msg }}/{{ $attr->kind_val_msg }}</td>
                <td>{{ $attr->kind_val_sku }}</td>
            </tr>
        @endforeach
            </table>
        @endif
        <br>
        <br>
        <br>
                <p style="text-align: center;">
                   
                        <b>
                            @if($goods_kind->goods_kind_sku_status==0) 
                                <span color='green' style="font-size: 80px;">SKU码绑定状态正常,如要释放请确认产品不再使用并没有库存存在</span> 
                            @elseif($goods_kind->goods_kind_sku_status==1) 
                                <span style="color:#ccc;font-size: 100px;">该产品绑定SKU码已经被释放,请勿再使用此产品!!!</span> 
                            @else 
                                <span style=" color:brown;font-size: 80px;">此SKU码由其它产品释放得来，可以正常使用，但切勿与其它产品混用！</span> 
                            @endif
                        </b>
                    
                </p>
    </article>
@endsection