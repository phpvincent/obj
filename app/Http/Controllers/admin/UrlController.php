<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\goods;
use App\url;
use DB;
class UrlController extends Controller
{
    public function goods_url(){
    	$counts=goods::count();
    	return view('admin.url.goods_url')->with('counts',$counts);
    }
    public function get_url(Request $request){
    		$info=$request->all();
        	$cm=$info['order'][0]['column'];
	        $dsc=$info['order'][0]['dir'];
	        $order=$info['columns']["$cm"]['data'];
	        $draw=$info['draw'];
	        $start=$info['start'];
	        $len=$info['length'];
	        $search=trim($info['search']['value']);
	        $counts=DB::table('goods')
	        ->count();
	        $newcount=DB::table('goods')
	        ->select('goods.goods_id','goods.goods_name','goods_real_name','url.url_type','url.url_url')
	        ->leftjoin('url','goods.goods_id','=','url.url_goods_id')
	        ->where([['goods.goods_name','like',"%$search%"],['goods.is_del','=','0']])
	        ->orWhere([['goods.goods_id','like',"%$search%"],['goods.is_del','=','0']])
	        ->orWhere([['url.url_url','like',"%$search%"],['goods.is_del','=','0']])
	        ->count();
	        $data=DB::table('goods')
	        ->select('goods.goods_id','goods.goods_name','goods_real_name','url.url_type','url.url_url')
	        ->leftjoin('url','goods.goods_id','=','url.url_goods_id')
	        ->where([['goods.goods_name','like',"%$search%"],['goods.is_del','=','0']])
	        ->orWhere([['goods.goods_id','like',"%$search%"],['goods.is_del','=','0']])
	        ->orWhere([['url.url_url','like',"%$search%"],['goods.is_del','=','0']])
	        ->orderBy($order,$dsc)
	        ->offset($start)
	        ->limit($len)
	        ->get();

	        $arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>$data];
	        return response()->json($arr);
    }
   public function churl(Request $request){
   		$goods=goods::where('goods_id',$request->input('id'))->first();
   		$url=url::where('url_goods_id',$goods->goods_id)->first();
   		return view('admin.url.churl')->with(compact('goods','url'));
   }
   public function ajaxup(Request $request){
   	    $msg=$request->all();
   	    $url=url::where('url_goods_id',$msg['id'])->first();
   	    if($url==null){
   	    	$url=new url();
   	    	$url->url_goods_id=$msg['id'];
   	    	$url->url_url=$msg['url_url'];
   	    	$url->url_type=$msg['url_type'];
   	    	$msg=$url->save();
   	    	if($msg){
   	    		return json_encode(true);
   	    	}else{
   	    		return json_encode(false);
   	    	}
   	    }else{
   	    	$url->url_goods_id=$msg['id'];
   	    	$url->url_url=$msg['url_url'];
   	    	$url->url_type=$msg['url_type'];
   	    	$msg=$url->save();
   	    	if($msg){
   	    		return json_encode(true);
   	    	}else{
   	    		return json_encode(false);
   	    	}
   	    }
   }


}
