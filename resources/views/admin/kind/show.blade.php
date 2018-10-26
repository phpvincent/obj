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
                    <th>属性名</th>
                    <th>属性值</th>
                </tr>
                @foreach($goods_config as $item)
                    <?php $i = 1; ?>
                    @foreach($item->config_msg as $value)
                    <tr class="text-c">
                        @if($i == 1)
                        <td rowspan = '{{count($item->config_msg)}}'>{{$item->kind_config_msg}}</td>
                        @endif
                        <td>{{$value['kind_val_msg']}}</td>
                        <?php $i++;
                            if($i > count($item->config_msg)){
                                $i = 1;
                            }
                        ?>
                    </tr>
                    @endforeach
            @endforeach
        </table>
    </article>
@endsection