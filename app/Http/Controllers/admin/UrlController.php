<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\goods;
use App\url;
use DB;
use Illuminate\Support\Facades\Auth;
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
          ->where(function($query)use($search){
            $query->where('url.url_url','like',"%$search%");
            $query->orWhere(function($query)use($search){
              $query->whereIn('url.url_goods_id',\App\goods::get_search_arr($search));
            });
            $query->orWhere(function($query)use($search){
              $query->whereIn('url.url_zz_goods_id',\App\goods::get_search_arr($search));
            });
          })
          ->where(function($query){
             if(Auth::user()->is_root!='1'){
              $ids=\App\admin::get_group_ids(Auth::user()->admin_id);
              $query->whereIn('url.url_admin_id',$ids);
            }
          })
	        ->count();
	        $data=DB::table('url')
	         ->select('url.*')
          ->where(function($query)use($search){
            $query->where('url.url_url','like',"%$search%");
            $query->orWhere(function($query)use($search){
              $query->whereIn('url.url_goods_id',\App\goods::get_search_arr($search));
            });
            $query->orWhere(function($query)use($search){
              $query->whereIn('url.url_zz_goods_id',\App\goods::get_search_arr($search));
            });
          })
          ->where(function($query){
             if(Auth::user()->is_root!='1'){
              $ids=\App\admin::get_group_ids(Auth::user()->admin_id);
              $query->whereIn('url.url_admin_id',$ids);
            }
          })
	        ->orderBy($order,$dsc)
	        ->offset($start)
	        ->limit($len)
	        ->get();
          foreach($data as $key => $v){
            $url_goods=\App\goods::where('goods_id',$v->url_goods_id)->first();
            $url_zz_goods=\App\goods::where('goods_id',$v->url_zz_goods_id)->first();
            if($url_goods!=null){
              $data[$key]->url_goods_id=$url_goods->goods_real_name;
            }
            if($url_zz_goods!=null){
              $data[$key]->url_zz_goods_id=$url_zz_goods->goods_real_name;
            }
          }
	        $arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>$data];
	        return response()->json($arr);
    }
    public function url_add(Request $request){
      //添加域名
      if($request->isMethod('get')){
        return view('admin.url.url_add');
      }elseif($request->isMethod('post')){
        $data=$request->all();
        $isalive=url::where('url_url',$data['url_url'])->first();
          if($isalive!=null){
                 return response()->json(['err'=>0,'str'=>'添加失败！该域名已存在！']);
          }
        $url=new url;
        $url->url_url=$data['url_url'];
        $url->url_zz_level=$data['url_level'];
        $url->url_zz_for=$data['url_for'];
        $url->url_admin_id=Auth::user()->admin_id;
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
      //修改域名配置信息
   	    $msg=$request->all();
        if(isset($msg['url_goods_id'])&&$msg['url_goods_id']=='null'){
          unset($msg['url_goods_id']);
        }
        if(isset($msg['url_zz_goods_id'])&&$msg['url_zz_goods_id']=='null'){
          unset($msg['url_zz_goods_id']);
        }
   	    $url=url::where('url_id',$msg['url_id'])->first();
   	    if($url==null){
   	    	$url=new url();
   	    	$url->url_goods_id=$msg['id'];
          $url->url_admin_id=Auth::user()->admin_id;
   	    	$url->url_url=$msg['url_url'];
   	    	$url->url_type=$msg['url_type'];
   	    	$msg=$url->save();
   	    	if($msg){
   	    		return json_encode(true);
   	    	}else{
   	    		return json_encode(false);
   	    	}
   	    }else{
          $isalive=url::where('url_url',$msg['url_url'])->first();
          if($isalive!=null&&$isalive->url_id!=$url->url_id){
                 return response()->json(['err'=>0,'str'=>'更改失败！该域名已存在！']);
          }
          if(isset($msg['url_goods_id'])&&isset($msg['url_zz_goods_id'])&&($msg['url_goods_id']==$msg['url_zz_goods_id'])){
              if($msg['url_goods_id']==null&&$msg['url_zz_goods_id']==null){
                //清空域名商品绑定
              }else{
               //选择同一商品绑定
                 return response()->json(['err'=>0,'str'=>'添加失败！遮罩单品不得与正常单品相同！']);
              }
                 
          }
          //撤销原商品的绑定状态
          if(!isset($msg['url_goods_id'])){
            $oldid=$url->url_goods_id;
            if($oldid!=null){
              $xxgoods=\App\goods::where('goods_id',$oldid)->first();
              $xxgoods->bd_type='0';
              $xxgoods->save();
            }
          }
          if(!isset($msg['url_zz_goods_id'])){
            $oldids=$url->url_zz_goods_id;
            if($oldids!=null){
              $xxgoodss=\App\goods::where('goods_id',$oldids)->first();
              $xxgoodss->bd_type='0';
              $xxgoodss->save();
            }
          }
          //遮罩单品与正常单品位置互换
          if(isset($msg['url_goods_id'])&&isset($msg['url_zz_goods_id'])&&$msg['url_goods_id']==$url->url_zz_goods_id&&$msg['url_zz_goods_id']==$url->url_goods_id){
            $zz_goods=\App\goods::where('goods_id',$msg['url_zz_goods_id'])->first();
            $zz_goods->bd_type='1';
            $zz_goods->save();
            $zc_goods=\App\goods::where('goods_id',$msg['url_goods_id'])->first();
            $zc_goods->bd_type='2';
            $zc_goods->save();
          }else{
                if(isset($msg['url_goods_id'])){
                  $bd_type=\App\goods::where('goods_id',$msg['url_goods_id'])->first();
                  if($bd_type!=null&&$bd_type->bd_type!=0&&$url->url_goods_id!=$msg['url_goods_id']){
                          return response()->json(['err'=>0,'str'=>'更改失败！被选中正常单品已处于绑定状态']);
                  }
                  $bd_type->bd_type='1';
                  $bd_type->save();
                }
                 if(isset($msg['url_zz_goods_id'])){
                   $bd_type=\App\goods::where('goods_id',$msg['url_zz_goods_id'])->first();
                  if($bd_type!=null&&$bd_type->bd_type!=0&&$url->url_zz_goods_id!=$msg['url_zz_goods_id']){
                          return response()->json(['err'=>0,'str'=>'更改失败！被选中遮罩单品已处于绑定状态']);
                  }
                  $bd_type->bd_type='2';
                  $bd_type->save();
                }
          }
          $url->url_goods_id=isset($msg['url_goods_id'])?$msg['url_goods_id']:null;
   	    	$url->url_zz_goods_id=isset($msg['url_zz_goods_id'])?$msg['url_zz_goods_id']:null;
   	    	$url->url_url=$msg['url_url'];
          $url->url_type=$msg['url_type'];
          $url->url_zz_level=$msg['url_zz_level'];
   	    	$url->url_zz_for=$msg['url_zz_for'];
          $url->url_admin_id=Auth::user()->admin_id;
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
