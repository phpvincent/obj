<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\admin;
use Illuminate\Support\Facades\Auth;
use DB;
class AdminController extends Controller
{
    public function index(){
    	
    	$counts=admin::count();
    	return view('admin.admin.index')->with(compact('counts'));
    }
    public function addadmin(Request $request){
    	if($request->isMethod('get')){
    		$roles=\App\role::get();
    		return view('admin.admin.addadmin')->with(compact('roles'));
    	}elseif($request->isMethod('post')){
    		$data=$request->all();
    		$admin=new admin();
    		$admin->admin_name=$data['admin_name'];
    		$admin->password=password_hash($data['password'], PASSWORD_BCRYPT);
    		if($data['admin_role_id']==0){
    			$admin->is_root='1';
    			$admin->admin_role_id='1';
    		}else{
    			$admin->admin_role_id=$data['admin_role_id'];
    		}
    		$msg=$admin->save();
    		if($msg){
    			 $ip=$request->getClientIp(); 
    			$time=date('Y-m-d H:i:s',time());
    			\Log::notice("【".$ip."】".Auth::user()->admin_name."于【".$time."]添加了".$data['admin_name'].'-'.\App\role::where('role_id',$data['admin_role_id'])->first()['role_name']."账户");
                    return response()->json(['err'=>1,'str'=>'添加成功']);
	        }else{
	                    return response()->json(['err'=>0,'str'=>'添加失败']);
	        }
    	}
    	
    }
    public function get_table(Request $request){
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
	        $newcount=DB::table('admin')
	        ->select('admin.*','role.role_name'	)
	        ->leftjoin('role','admin.admin_role_id','role.role_id')
	        ->orwhere(function($query) use($search){
	        	$query->where('admin.admin_name','like',"%$search%");
	        	$query->where('admin.admin_id','like',"%$search%");
	        	$query->where('role.role_name','like',"%$search%");
	        })
	        ->count();
	        $data=DB::table('admin')
	        ->select('admin.*','role.role_name')
	        ->leftjoin('role','admin.admin_role_id','role.role_id')
	        ->orwhere(function($query) use($search){
	        	$query->where('admin.admin_name','like',"%$search%");
	        	$query->where('admin.admin_id','like',"%$search%");
	        	$query->where('role.role_name','like',"%$search%");
	        })
	        ->orderBy($order,$dsc)
	        ->offset($start)
	        ->limit($len)
	        ->get();
	        foreach($data as $key => $v){
	        	$day_sale=DB::select("select sum(`order`.order_price) as day_sale from `order`  where DateDiff(order.order_time,now())=1 and order.order_admin_id=$v->admin_id");
/*                $day_sale=DB::table('order')->where([['order.order_admin_id',$v->admin_id],["DateDiff(order.order_time,now())",'0']])->sum('order.order_price');
*/              if($day_sale[0]->day_sale==null){
					$day_sale[0]->day_sale=0;
				}  
				$data[$key]->day_sale=$day_sale[0]->day_sale;
                $goods_num=DB::table('goods')->where([['goods.goods_admin_id',$v->admin_id],['goods.is_del','0']])->count();
                $data[$key]->goods_num=$goods_num;
                $orders_num=DB::table('order')->where('order.order_admin_id',$v->admin_id)->count();
                $data[$key]->orders_num=$orders_num;
	        }
	        $arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>$data];
	        return response()->json($arr);
    }
    public function deladmin(Request $request){
    	$id=$request->input('id');
    	$msg=\App\admin::where('admin_id',$id)->delete();
    	if($msg){
	   	    	return response()->json(['err'=>1,'str'=>'删除成功']);
	   	}else{
		   	    	return response()->json(['err'=>0,'str'=>'删除失败']);
	   	}
    }
    public function ch_root(Request $request){
    	$id=$request->input('id');
    	$msg=\App\admin::where('admin_id',$id)->first();
    	$msg->is_root='1';
    	$msg1=$msg->save();
    	if($msg){
	   	    	return response()->json(['err'=>1,'str'=>'更改成功']);
	   	}else{
		   	    	return response()->json(['err'=>0,'str'=>'更改失败']);
	   	}
    }
    public function cl_root(Request $request){
    	$id=$request->input('id');
    	$msg=\App\admin::where('admin_id',$id)->first();
    	$msg->is_root='0';
    	$msg1=$msg->save();
    	if($msg){
	   	    	return response()->json(['err'=>1,'str'=>'更改成功']);
	   	}else{
		   	    	return response()->json(['err'=>0,'str'=>'更改失败']);
	   	}
    }
    public function unuse(Request $request){
    	$id=$request->input('id');
    	$msg=\App\admin::where('admin_id',$id)->first();
    	$msg->admin_use='0';
    	$msg1=$msg->save();
    	if($msg){
	   	    	return response()->json(['err'=>1,'str'=>'更改成功']);
	   	}else{
		   	    	return response()->json(['err'=>0,'str'=>'更改失败']);
	   	}
    }
    public function opuse(Request $request){
    	$id=$request->input('id');
    	$msg=\App\admin::where('admin_id',$id)->first();
    	$msg->admin_use='1';
    	$msg1=$msg->save();
    	if($msg){
	   	    	return response()->json(['err'=>1,'str'=>'更改成功']);
	   	}else{
		   	    	return response()->json(['err'=>0,'str'=>'更改失败']);
	   	}
    }
    public function upadmin(Request $request){
    	if($request->isMethod('get')){
    		$admin=\App\admin::where('admin_id',$request->input('id'))->first();
    		return view('admin.admin.upadmin')->with(compact('admin'));
    	}else if($request->isMethod('post')){
    		$data=$request->all();
    		$id=$request->input('admin_id');
    		$admin=\App\admin::where('admin_id',$id)->first();
    		$admin->admin_name=$data['admin_name'];
    		$admin->admin_role_id=$data['role_id'];
    		$admin->password=password_hash($data['password'], PASSWORD_BCRYPT);
    		$msg=$admin->save();
    		if($msg){
	   	    	return response()->json(['err'=>1,'str'=>'更改成功']);
		   	}else{
			   	    	return response()->json(['err'=>0,'str'=>'更改失败']);
		   	}
    	}
    }
    public function addrole(Request $request){
    	if($request->isMethod('get')){
    		return view('admin.admin.addrole');
    	}else if($request->isMethod('post')){
    		$role=new \App\role;
    		$role->role_name=$request->input('role_name');
    		$msg=$role->save();
    		if($msg){
	   	    	return response()->json(['err'=>1,'str'=>'添加成功']);
		   	}else{
			   	    	return response()->json(['err'=>0,'str'=>'添加失败']);
		   	}
    	}
    }
}
