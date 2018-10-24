<div class="product_image">
	        <img src="{{\App\img::where('img_goods_id',$goods->goods_id)->first()->img_url}}">
	    </div>
	    <div class="check_show">
	        <h2><b>製品名：</b>{{$goods->goods_name}}</h2>
	        <h2><b>注文番号: </b>{{$order->order_single_id}}</h2>
	        <h2><b>ご注文状態: </b>@if($order->order_type==0)承認されません @elseif($order->order_type==1)審議合格 @elseif($order->order_type==2)<span style="color: red;">Nuclear trial failure</span>@elseif($order->order_type==3)Has been sent to express company. elseif($order->order_type==4)Signed elseif($order->order_type==5||$order->order_type==6||$order->order_type==7)<span style="color: red;">Withdrawal processing</span>@elseif($order->order_type==8)<span style="color: red;">Signature rejected</span>@else &nbsp; @endif</h2>
	        <h2><b>物流会社：</b>@if($order->order_send_type==null)一時的に物流会社情報が得られません @else{{$order->order_send_type}}@endif</h2>
	        <h2><b>注文番号/物流番号(1つで入力してよいです):</b>@if($order->order_send==null)一時的に物流番号情報が得られません @else{{$order->order_send}}@endif</h2>
</div>