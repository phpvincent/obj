 <div class="product_image">
	        <img src="{{\App\img::where('img_goods_id',$goods->goods_id)->first()->img_url}}">
	    </div>
	    <div class="check_show">
	        <h2>{{$goods->goods_name}}<b> : اسم المنتج</b></h2>
	        <h2>{{$order->order_single_id}}<b>:رقم الطلب </b></h2>
	        <h2><b>حاله الطلب:</b>@if($order->order_type==0)لم يتم الفحص @elseif($order->order_type==1) تم الفحص @elseif($order->order_type==2)<span style="color: red;">فشل الفحص </span>@elseif($order->order_type==3)تم الارسال الي شركه البريد  elseif($order->order_type==4)تم الاستلام  elseif($order->order_type==5||$order->order_type==6||$order->order_type==7)<span style="color: red;">يتم الارجاع </span>@elseif($order->order_type==8)<span style="color: red;">تم رفض الاستلام من قبل</span>@else &nbsp; @endif </h2>
	        <h2><b>شركه الشحن:</b>@if($order->order_send_type==null)لا توجد معلومات عن الشحن في الوقت الحالي@else{{$order->order_send_type}}@endif </h2>
	        <h2><b>رقم الشحنه البريديه/رقم الطلب: </b>@if($order->order_send==null)لا يوجد رقم شحنه البريد في الوقت الحالي@else{{$order->order_send}}@endif </h2>
</div>