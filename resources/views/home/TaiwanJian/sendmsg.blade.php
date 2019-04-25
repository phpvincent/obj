 <div class="product_image">
 	@if(\App\img::where('img_goods_id',$goods->goods_id)->first()!=null)
	        <img src="{{\App\img::where('img_goods_id',$goods->goods_id)->first()->img_url}}">
	@else
				        <img src="">
	@endif
	    </div>
	    <div class="check_show">
	        <h2><b>Product Name：</b>{{$goods->goods_name}}</h2>
	        <h2><b>您的订单编号：</b>{{$order->order_single_id}}</h2>
	        <h2><b>您的订单状态：</b>@if($order->order_type==0)未核实@elseif($order->order_type==1)核审通过@elseif($order->order_type==2)<span style="color: red;">核审失败</span>@elseif($order->order_type==3)已发往快递公司elseif($order->order_type==4)已签收elseif($order->order_type==5||$order->order_type==6||$order->order_type==7)<span style="color: red;">退购处理中</span>@elseif($order->order_type==8)<span style="color: red;">签收被拒</span>@else &nbsp; @endif</h2>
	        <h2><b>Logistics Company：</b>@if($order->order_send_type==null)暂无快递公司信息@else{{$order->order_send_type}}@endif</h2>
	        <h2><b>订单号/物流单号（填写一项即可查询）：</b>@if($order->order_send==null)暂无快递单号信息@else{{$order->order_send}}@endif</h2>
</div>