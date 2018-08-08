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
	        $counts=DB::table('url')
	        ->count();
	        $newcount=DB::table('url')
	        ->select('url.*')
          ->where('url.url_url','like',"%$search%")
	        ->count();
	        $data=DB::table('url')
	         ->select('url.*')
          ->where('url.url_url','like',"%$search%")
	        ->orderBy($order,$dsc)
	        ->offset($start)
	        ->limit($len)
	        ->get();
          foreach($data as $key => $v){
            $url_goods=\App\goods::where('goods_id',$v->url_goods_id)->first();
            $url_zz_goods=\App\goods::where('goods_id',$v->url_zz_goods_id)->first();
            if($url_goods!=null){
              $data[$key]->url_goods_id=$url_goods->goods_name;
            }
            if($url_zz_goods!=null){
              $data[$key]->url_zz_goods_id=$url_zz_goods->goods_name;
            }
          }
	        $arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>$data];
	        return response()->json($arr);
    }
    public function url_add(Request $request){
      if($request->isMethod('get')){
        return view('admin.url.url_add');
      }elseif($request->isMethod('post')){
        $data=$request->all();
        $url=new url;
        $url->url_url=$data['url_url'];
        $url->url_zz_level=$data['url_level'];
        $url->url_zz_for=$data['url_for'];
        if(isset($data['is_online'])&&$data['is_online']!=null){
          $url->url_type='1';
        }else{
          $url->url_type='0';
        }
        $msg=$url->save();
        if($msg)
         {
                  return response()->json(['err'=>1,'str'=>'添加成功！']);
         }else{
                  return response()->json(['err'=>0,'str'=>'添加失败！']);
         }
      }
      
    }
   public function churl(Request $request){
   		
   		$url=url::where('url_id',$request->id)->first();
   		return view('admin.url.churl')->with(compact('goods','url'));
   }
   public function ajaxup(Request $request){
   	    $msg=$request->all();
   	    $url=url::where('url_id',$msg['url_id'])->first();
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
          if($msg['url_goods_id']==$msg['url_zz_goods_id']){
                  return response()->json(['err'=>0,'str'=>'添加失败！遮罩单品不得与正常单品相同！']);
          }
          $url->url_goods_id=$msg['url_goods_id'];
   	    	$url->url_zz_goods_id=$msg['url_zz_goods_id'];
   	    	$url->url_url=$msg['url_url'];
          $url->url_type=$msg['url_type'];
          $url->url_zz_level=$msg['url_zz_level'];
   	    	$url->url_zz_for=$msg['url_zz_for'];
   	    	$msg=$url->save();
   	    	if($msg)
         {
                  return response()->json(['err'=>1,'str'=>'更改成功！']);
         }else{
                  return response()->json(['err'=>0,'str'=>'更改失败！']);
         }
   	    }
   }


}
