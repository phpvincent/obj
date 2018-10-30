<div class="product_image">
	        <img src="{{\App\img::where('img_goods_id',$goods->goods_id)->first()->img_url}}">
	    </div>
	    <div class="check_show">
	        <h2><b>ชื่อผลิตภัณฑ์:</b>{{$goods->goods_name}}</h2>
	        <h2><b>เลขที่คำสั่งซื้อของท่าน: </b>{{$order->order_single_id}}</h2>
	        <h2><b>สถานะคำสั่งซื้อของท่าน: </b>@if($order->order_type==0)รอตรวจสอบ @elseif($order->order_type==1)ตรวจสอบแล้ว @elseif($order->order_type==2)<span style="color: red;">ไม่ผ่านการตรวจสอบ</span>@elseif($order->order_type==3)ส่งไปยังบริษัทโลจิสติกส์แล้ว elseif($order->order_type==4)ลูกค้าเซ็นรับแล้ว elseif($order->order_type==5||$order->order_type==6||$order->order_type==7)<span style="color: red;">อยู่ช่วงการดำเนินการคืนสินค้า</span>@elseif($order->order_type==8)<span style="color: red;">ลูกค้าปฏิเสธเซ็นรับสินค้า</span>@else &nbsp; @endif</h2>
	        <h2><b>บริษัทการขนส่ง：</b>@if($order->order_send_type==null)ยังไม่มีข้อมูลบริษัทการขนส่ง @else{{$order->order_send_type}}@endif</h2>
	        <h2><b>เลขที่คำสั่งซื้อ/ เลขพัสดุ(กรอกอย่างเดียวก็เช็คได้):</b>@if($order->order_send==null)ยังไม่มีข้อมูลเลขที่พสตุ @else{{$order->order_send}}@endif</h2>
</div>