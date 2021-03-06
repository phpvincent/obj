<?php

namespace App\Http\Controllers\admin;

use App\admin;
use App\goods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;
class CheckController extends Controller
{
    public function index(Request $request)
    {
    	$counts=\App\goods::where('goods_heshen','0')
            ->whereIn('goods_id',admin::get_goods_id())
            ->where(function($query){
                $query->where('goods_id','<>','4');
            })
            ->count();
    	return view('admin.check.index')->with(compact('counts'));
    }
    public function getcheck(Request $request)
    {
    	$info=$request->all();
        	$cm=$info['order'][0]['column'];
	        $dsc=$info['order'][0]['dir'];
	        $order=$info['columns']["$cm"]['data'];
	        $draw=$info['draw'];
	        $start=$info['start'];
	        $len=$info['length'];
	        $search=trim($info['search']['value']);
	        $counts=DB::table('goods')
          /*->where(function($query){
            if(Auth::user()->is_root!='1'){
              $query->whereIn('goods_admin_id',\App\admin::get_group_ids(Auth::user()->admin_id));
            }
          })*/
          ->where(function($query){
            $query->where('goods_id','<>','4');
          })
          ->whereIn('goods_id',admin::get_goods_id())
          ->where(function($query){
          	$query->where('goods_heshen','<>','1');
          })
	      ->count();

	      $newcount=DB::table('goods')
	      ->select('goods.*','url.url_url','url.url_type','admin.admin_name')
	      ->leftjoin('url','goods.goods_id','=','url.url_goods_id')
	      ->leftjoin('admin','goods.goods_admin_id','=','admin.admin_id')
          ->where(function($query)use($search){
            $query->where([['goods.goods_name','like',"%$search%"]]);
            $query->orWhere([['goods.goods_real_name','like',"%$search%"]]);
            $query->orWhere([['goods.goods_msg','like',"%$search%"]]);
            $query->orWhere([['url.url_url','like',"%$search%"]]);
            $query->orWhere([['admin.admin_name','like',"%$search%"]]);
          })
          /*->where(function($query){
           if(Auth::user()->is_root!='1'){
              $ids=\App\admin::get_group_ids(Auth::user()->admin_id);
              $query->whereIn('goods.goods_admin_id',$ids);
            }
          })*/
          ->where(function($query){
            $query->where('goods_id','<>','4');
            $query->where('goods_heshen','<>','1');
          })
          ->whereIn('goods.goods_id',admin::get_goods_id())
          ->where(function($query)use($info){
          	if($info['ischeck']==0){
            	$query->where('goods_heshen','<>','1');
          	}elseif($info['ischeck']==1){
          		$query->where('goods_heshen','2');
          	}elseif($info['ischeck']==2){
          		$second=\App\goods_check::first();
          		$second=$second->goods_check_second;
          		$query->where('goods.goods_check_time','<',date("Y-m-d H:i:s",time()-$second));
          	}
          })
          ->where(function($query)use($info){
          	if($info['chvis']!=0){
          		$query->where('admin.admin_group',$info['chvis']);
          	}
          })
	      ->count();
	      $data=DB::table('goods')
	      ->select('goods.*','url.url_url','url.url_type','admin.admin_name')
	      ->leftjoin('url','goods.goods_id','=','url.url_goods_id')
	      ->leftjoin('admin','goods.goods_admin_id','=','admin.admin_id')
          ->where('goods.is_del','0')
          ->where(function($query)use($search){
            $query->where([['goods.goods_name','like',"%$search%"]]);
            $query->orWhere([['goods.goods_real_name','like',"%$search%"]]);
            $query->orWhere([['goods.goods_msg','like',"%$search%"]]);
            $query->orWhere([['url.url_url','like',"%$search%"]]);
            $query->orWhere([['admin.admin_name','like',"%$search%"]]);
          })
          ->where(function($query){
//           if(Auth::user()->is_root!='1'){
//              $ids=\App\admin::get_group_ids(Auth::user()->admin_id);
//              $query->whereIn('goods.goods_admin_id',$ids);
              $query->whereIn('goods.goods_admin_id',admin::get_admins_id());
//            }
          })
          ->where(function($query){
            $query->where('goods_id','<>','4');
            $query->where('goods_heshen','<>','1');
          })
          ->whereIn('goods.goods_id',admin::get_goods_id())
          ->where(function($query)use($info){
          	if($info['ischeck']==0){
            	$query->where('goods_heshen','<>','1');
          	}elseif($info['ischeck']==1){
          		$query->where('goods_heshen','2');
          	}elseif($info['ischeck']==2){
          		$second=\App\goods_check::first();
          		$second=$second->goods_check_second;
          		$query->where('goods.goods_check_time','<',date("Y-m-d H:i:s",time()-$second));
          	}
          })
          ->where(function($query)use($info){
          	if($info['chvis']!=0){
          		$query->where('admin.admin_group',$info['chvis']);
          	}
          })
          ->orderBy($order,$dsc)
	      ->offset($start)
	      ->limit($len)
	      ->get();
	      foreach($data as $k => $v){
	      	if($v->goods_check_time!=null){
	      		//判断是否过期
	      		$second=\App\goods_check::first();
          		$second=$second->goods_check_second;
	      			$less_time=time()-strtotime($v->goods_check_time)-$second;
	      			if($less_time>0){
	      				if($v->goods_heshen==2){
	      					$data[$k]->less_time='<span style="color:red;">保护时间已过！</span>';
	      					$data[$k]->goods_heshen='<span style="color:red;">以驳回核审并超出保护时间后自动屏蔽！</span>';
	      				}else{
	      					$data[$k]->less_time='<span style="color:red;">保护时间已过！</span>';
	      					$data[$k]->goods_heshen='<span style="color:red;">已被屏蔽！</span>';
	      				}
	      			}else{
	      				$data[$k]->less_time=$less_time;
	      			}

	      	}else{
	      				$data[$k]->less_time='暂无数据';
	      	}
	      }
	      $arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>$data];
	        return response()->json($arr);
    }

    /** 单品审核
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function go_check(Request $request)
    {
    	$id=$request->input('id');
        $goods_name = goods::where('goods_id',$id)->value('goods_real_name');
    	$msg=\App\goods::where('goods_id',$id)->update(['goods_heshen'=>'1']);
    	if($msg){
            $ip = $request->getClientIp();
            //加log日志
            operation_log($ip,'单品审核通过,单品名称：'.$goods_name);
    		  return response()->json(['err'=>1,'str'=>'更改成功！']);
    	}else{
    		  return response()->json(['err'=>0,'str'=>'更改失败！']);
    	}
    }

    /** 拒绝单品审核
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function no_check(Request $request)
    {
    	$id=$request->input('id');
        $goods_name = goods::where('goods_id',$id)->value('goods_real_name');
        $msg=\App\goods::where('goods_id',$id)->update(['goods_heshen'=>'2']);
    	if($msg==0){
    		  return response()->json(['err'=>0,'str'=>'更改失败！单品已为拒绝核审状态！']);
    	}
    	$msg2=\App\goods::where('goods_id',$id)->update(['goods_check_time'=>date("Y-m-d H:i:s",time())]);
    	if($msg&&$msg2){
            $ip = $request->getClientIp();
            //加log日志
            operation_log($ip,'单品审核被拒绝,商品审核时间被刷新,单品名称：'.$goods_name);
    		  return response()->json(['err'=>1,'str'=>'更改成功！']);
    	}else{
    		  return response()->json(['err'=>0,'str'=>'更改失败！']);
    	}
    }

    /** 重置保护时间
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function re_check(Request $request)
    {
    	$id=$request->input('id');
    	$msg=\App\goods::where('goods_id',$id)->update(['goods_check_time'=>date("Y-m-d H:i:s",time())]);
    	if($msg){
    		  return response()->json(['err'=>1,'str'=>'更改成功！']);
    	}else{
    		  return response()->json(['err'=>0,'str'=>'更改失败！']);
    	}
    }

    /** 核审配置
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function set(Request $request)
    {
    	if($request->isMethod('get')){
    		return view('admin.check.set')->with('goods_check',\App\goods_check::first());
    	}elseif($request->isMethod('post')){
//    		$data=$request->all();
    		$data=$request->except('_token');
    		$goods_check=\App\goods_check::first();
        $old_status=$goods_check->goods_is_check;
    		$goods_check->goods_check_second=$data['goods_check_second'];
    		$goods_check->goods_check_max=$data['goods_check_max'];
    		if(isset($data['goods_is_check'])&&$data['goods_is_check']=='0'){
    			$goods_check->goods_is_check=0;
    		}else{
    			$goods_check->goods_is_check=1;
    		}
    		$msg=$goods_check->save();
        if($old_status==0&&$goods_check->goods_is_check==1){
          \Log::notice(Auth::user()->admin_name.'于'.date('Y-m-d H:i:s',time()).'在'.$request->getClientIp().'开启了核审机制');
        }
    		if($msg){
              $ip = $request->getClientIp();
              if($goods_check->goods_is_check==1){
                  $content = '关闭商品核审成功';
              }else{
                  $content = '开启商品核审成功';
              }
              //加log日志
              operation_log($ip,$content,json_encode($data));
    		  return response()->json(['err'=>1,'str'=>'更改成功！']);
	    	}else{
	    		  return response()->json(['err'=>0,'str'=>'更改失败！']);
	    	}
    	}
    }
}
