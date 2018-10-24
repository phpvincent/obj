<div class="product_image">
    <img src="{{\App\img::where('img_goods_id',$goods->goods_id)->first()->img_url}}">
</div>
<div class="check_show"style=" user-select: text;">
    <h4>Product Name:</h4>
    <p>{{$goods->goods_name}}</p>
    <h4><b>Your order number:</b></h4>
    <p>{{$order->order_single_id}}</p>
    <h4><b>Your order status:</b></h4>
    <p>@if($order->order_type==0)Not checked @elseif($order->order_type==1)Nuclear approval @elseif($order->order_type==2)<span style="color: red;">Nuclear trial failure</span>@elseif($order->order_type==3)Has been sent to express company. elseif($order->order_type==4)Signed elseif($order->order_type==5||$order->order_type==6||$order->order_type==7)<span style="color: red;">Withdrawal processing</span>@elseif($order->order_type==8)<span style="color: red;">Signature rejected</span>@else error @endif</p>
    <h4><b>Logistics Company:</b></h4>
    <p>@if($order->order_send_type==null)No express company information @else{{$order->order_send_type}}@endif</p>
    <h4><b>Order number / Logistics order number (please fill in one entry for enquiries):</b></h4>
    <p>@if($order->order_send==null)No express single number information for the time being @else{{$order->order_send}}@endif</p>
</div>