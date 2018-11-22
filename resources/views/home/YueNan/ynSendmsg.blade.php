 <div class="product_image">
	        <img src="{{\App\img::where('img_goods_id',$goods->goods_id)->first()->img_url}}">
	    </div>
	    <div class="check_show">
	        <h2><b>tên gọi sản phẩm ：</b>{{$goods->goods_name}}</h2>
	        <h2><b>số đơn đặt hàng của quý khách：</b>{{$order->order_single_id}}</h2>
	        <h2><b>tình trạng đơn đặt hàng của quý khách：</b>@if($order->order_type==0) chưa xét duyệt  @elseif($order->order_type==1) thông qua xét duyệt @elseif($order->order_type==2)<span style="color: red;"> thẩm tra thất bại </span>@elseif($order->order_type==3) đã gửi đến công ty vận tải elseif($order->order_type==4) đã ký nhận elseif($order->order_type==5||$order->order_type==6||$order->order_type==7)<span style="color: red;"> đang xử lý trả hàng </span>@elseif($order->order_type==8)<span style="color: red;"> từ chối nhận hàng </span>@else &nbsp; @endif</h2>
	        <h2><b>công ty vận tải：</b>@if($order->order_send_type==null) tạm thời không có thông tin của công ty vận tải @else{{$order->order_send_type}}@endif</h2>
	        <h2><b>số đơn đặt hàng, số đơn vận chuyển (điền một số thì có thể thẩm tra ) :</b>@if($order->order_send==null) tạm thời không có thông tin của số đơn vận chuyển @else{{$order->order_send}}@endif</h2>
</div>