 <div class="product_image">
	        <img src="{{\App\img::where('img_goods_id',$goods->goods_id)->first()->img_url}}">
	    </div>
	    <div class="check_show">
	        <h2><b>Product Name：</b>{{$goods->goods_name}}</h2>
	        <h2><b>您的訂單編號：</b>{{$order->order_single_id}}</h2>
	        <h2><b>您的訂單狀態：</b>@if($order->order_type==0)未核審@elseif($order->order_type==1)核審通過@elseif($order->order_type==2)<span style="color: red;">核審失敗</span>@elseif($order->order_type==3)已發往快遞公司elseif($order->order_type==4)已簽收elseif($order->order_type==5||$order->order_type==6||$order->order_type==7)<span style="color: red;">退購處理中</span>@elseif($order->order_type==8)<span style="color: red;">簽收被拒</span>@else error @endif</h2>
	        <h2><b>Logistics Company：</b>@if($order->order_send_type==null)暫無快遞公司信息@else{{$order->order_send_type}}@endif</h2>
	        <h2><b>訂單號/物流單號(填寫一項即可查詢)：</b>@if($order->order_send==null)暫無快遞單號信息@else{{$order->order_send}}@endif</h2>
</div>