<div class="product_image">
	        <img src="{{\App\img::where('img_goods_id',$goods->goods_id)->first()->img_url}}">
	    </div>
	    <div class="check_show">
	        <h2><b>ชื่อผลิตภัณฑ์：</b>{{$goods->goods_name}}</h2>
	        <h2><b>หมายเลขคำสั่งซื้อของคุณ: </b>{{$order->order_single_id}}</h2>
	        <h2><b>สถานะการสั่งซื้อของคุณ: </b>@if($order->order_type==0)การตรวจสอบล้มเหลว @elseif($order->order_type==1)การอนุมัติ @elseif($order->order_type==2)<span style="color: red;">Nuclear trial failure</span>@elseif($order->order_type==3)Has been sent to express company. elseif($order->order_type==4)Signed elseif($order->order_type==5||$order->order_type==6||$order->order_type==7)<span style="color: red;">Withdrawal processing</span>@elseif($order->order_type==8)<span style="color: red;">Signature rejected</span>@else error @endif</h2>
	        <h2><b>บริษัท โลจิสติกส์：</b>@if($order->order_send_type==null)ไม่มีข้อมูล บริษัท จัดส่ง @else{{$order->order_send_type}}@endif</h2>
	        <h2><b>หมายเลขคำสั่งซื้อ / หมายเลขโลจิสติก (กรอกข้อมูลลงในแบบสอบถาม):</b>@if($order->order_send==null)ไม่มีข้อมูลหมายเลขการจัดส่งด่วน @else{{$order->order_send}}@endif</h2>
</div>