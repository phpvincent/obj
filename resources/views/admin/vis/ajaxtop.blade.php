<div id="content">
    <div>
        <text>销售额排行榜 Top 10</text>
    </div>
    @if(!empty($array))
        @foreach($array as $key=>$item)
        <div>
            <span>{{$key+1}}</span>
            <span>{{$item['admin_name']}}</span>
            <span>{{$item['sale_total']}}元</span>
        </div>
        @endforeach
    @else
       <div>
            <text>暂无管理员</text>
       </div>
    @endif
</div>
<style>
    #content {
        padding-top: 5px;
    }
    #content div text{
        font-size: 18px;
        color: #333333;
    }
    #content div{
        margin-left: 30px;
        height: 36px;
    }
    #content div span:first-child{
        text-align:center;
        color: #f51322;
        display: inline-block;
        width: 20px;
        height: 20px;
        background: #0e90d2;
    }
    #content div span:nth-child(2){
        font-size: 18px;
        display: inline-block;
        margin-left: 10px;
    }
    #content div span:last-child{
        font-size: 16px;
        float: right;
        display: inline-block;
        margin-right: 30px;
    }
</style>

