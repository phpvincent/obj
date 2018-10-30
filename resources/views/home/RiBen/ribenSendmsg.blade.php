<div class="product_image">
	        <img src="{{\App\img::where('img_goods_id',$goods->goods_id)->first()->img_url}}">
	    </div>
	    <div class="check_show">
	        <h2><b>商品名称:</b>{{$goods->goods_name}}</h2>
	        <h2><b>あなたのオーダーナンバー: </b>{{$order->order_single_id}}</h2>
	        <h2><b>あなたのオーダー状況: </b>@if($order->order_type==0)未査定 @elseif($order->order_type==1)査定通った @elseif($order->order_type==2)<span style="color: red;">審査失敗</span>@elseif($order->order_type==3)配送会社に発送済み elseif($order->order_type==4)受取済み elseif($order->order_type==5||$order->order_type==6||$order->order_type==7)<span style="color: red;">返品処理中</span>@elseif($order->order_type==8)<span style="color: red;">受取拒否</span>@else &nbsp; @endif</h2>
	        <h2><b>物流会社:</b>@if($order->order_send_type==null)物流会社情報なし @else{{$order->order_send_type}}@endif</h2>
	        <h2><b>オーダーナンバー/トラッキングナンバー（上記の上、1つだけ入力すれば、検索できる）:</b>@if($order->order_send==null)物流情報なし @else{{$order->order_send}}@endif</h2>
</div>