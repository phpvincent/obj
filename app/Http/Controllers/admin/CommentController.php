<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\comment;
use App\goods;
use DB;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
   public function index(){
   	$goods=goods::get();
   	$counts=goods::count();
   	return view('admin.comment.comment')->with('counts',$counts);
   }
   public function getindex(Request $request){
   			$info=$request->all();
        	$cm=$info['order'][0]['column'];
	        $dsc=$info['order'][0]['dir'];
	        $order=$info['columns']["$cm"]['data'];
	        $draw=$info['draw'];
	        $start=$info['start'];
	        $len=$info['length'];
	        $search=trim($info['search']['value']);
	        $counts=DB::table('goods')
	        ->where(function($query){
	        	if(Auth::user()->is_root!='1'){
	        		$query->whereIn('goods_admin_id',\App\admin::get_group_ids(Auth::user()->admin_id));
	        	}
	        })
	        ->count();
	        $newcount=DB::table('goods')
	        ->where([['goods.goods_real_name','like',"%$search%"],['goods.is_del','=','0']])
	        ->orWhere([['goods.goods_name','like',"%$search%"],['goods.is_del','=','0']])
	        ->where(function($query){
	        	if(Auth::user()->is_root!='1'){
	        		$query->whereIn('goods_admin_id',\App\admin::get_group_ids(Auth::user()->admin_id));
	        	}
	        })
	        ->count();
	        $data=DB::table('goods')
	        ->select('goods.*')
	        ->where([['goods.goods_real_name','like',"%$search%"],['goods.is_del','=','0']])
	        ->orWhere([['goods.goods_name','like',"%$search%"],['goods.is_del','=','0']])
	        ->where(function($query){
	        	if(Auth::user()->is_root!='1'){
	        		$query->whereIn('goods_admin_id',\App\admin::get_group_ids(Auth::user()->admin_id));
	        	}
	        })
	        ->orderBy($order,$dsc)
	        ->offset($start)
	        ->limit($len)
	        ->get();
	        foreach($data as $key => $v){
                $usecount=\App\comment::where([['com_goods_id','=',$v->goods_id],['com_isuser','=','1']])->count();
                $oncount=\App\comment::where([['com_goods_id','=',$v->goods_id],['com_isshow','=','1']])->count();
                $data[$key]->usecount=$usecount;
                $data[$key]->oncount=$oncount;
               
	        }
	        $arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>$data];
	        return response()->json($arr);
   }
   public function oncomment(Request $request){
   	$id=$request->input('id');
   	return view('admin.comment.oncomment')->with('id',$id);
   }
   public function downcom(Request $request){
   	$id=$request->input('id');
   	$com=\App\comment::where('com_id',$id)->first();
   	$com->com_isshow=0;
   	if($com->save()){
	   	    	return response()->json(['err'=>1,'str'=>'下线成功']);
   	}else{
	   	    	return response()->json(['err'=>0,'str'=>'删除失败']);
   	}
   }
   public function upcom(Request $request){
   	$id=$request->input('id');
   	$com=\App\comment::where('com_id',$id)->first();
   	$com->com_isshow=1;
   	if($com->save()){
	   	    	return response()->json(['err'=>1,'str'=>'展示成功']);
   	}else{
	   	    	return response()->json(['err'=>0,'str'=>'展示失败']);
   	}
   }
   public function geton(Request $request){
   	$id=$request->input('id');
   	$info=$request->all();
        	$cm=$info['order'][0]['column'];
	        $dsc=$info['order'][0]['dir'];
	        $order=$info['columns']["$cm"]['data'];
	        $draw=$info['draw'];
	        $start=$info['start'];
	        $len=$info['length'];
	        $search=trim($info['search']['value']);
	        $counts=DB::table('comment')
	        ->where([['com_isshow','1'],['com_goods_id',$id]])
	        ->count();
	        $newcount=DB::table('goods')
	        ->select('comment.*','goods.goods_real_name')
            ->leftjoin('comment','goods.goods_id','comment.com_goods_id')
	        ->where([['goods.goods_real_name','like',"%$search%"],['comment.com_isshow','=','1'],['goods.goods_id','=',$id]])
	        ->orWhere([['comment.com_name','like',"%$search%"],['comment.com_isshow','=','1'],['goods.goods_id','=',$id]])
	        ->orWhere([['comment.com_phone','like',"%$search%"],['comment.com_isshow','=','1'],['goods.goods_id','=',$id]])
	        ->count();
	        $data=DB::table('goods')
	        ->select('comment.*','goods.goods_real_name')
            ->leftjoin('comment','goods.goods_id','comment.com_goods_id')
	        ->where([['goods.goods_real_name','like',"%$search%"],['comment.com_isshow','=','1'],['goods.goods_id','=',$id]])
	        ->orWhere([['comment.com_name','like',"%$search%"],['comment.com_isshow','=','1'],['goods.goods_id','=',$id]])
	        ->orWhere([['comment.com_phone','like',"%$search%"],['comment.com_isshow','=','1'],['goods.goods_id','=',$id]])
	        ->orderBy($order,$dsc)
	        ->offset($start)
	        ->limit($len)
	        ->get();
	        foreach($data as $key => $v){
                 $imgs=\App\com_img::where('com_primary_id',$v->com_id)->get();
                if(count($imgs)>0){
                	$data[$key]->com_img=$imgs->first()->com_url;
                }else{
                	$data[$key]->com_img=null;
                }
	        }
	        $arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>$data];
	        return response()->json($arr);
   }
   public function usecomment(Request $request){
   	$comment=comment::where('com_id',$request->input('id'))->first();
   	 if($comment==null){
   	 	return "数据错误！";
   	 }
   	 return view('admin.comment.usecomment')->with('comment',$comment);
   }
   public function usercomment(Request $request){
   	$comment=comment::where('com_goods_id',$request->input('id'))->get();
   	$id=$request->input('id');
   	 /*if($comment->isEmpty()){
   	 	return "数据错误！";
   	 }*/
   	 return view('admin.comment.usercomment')->with(compact('comment','id'));
   }
   public function newcomment(Request $request){
   	$fname=\App\comment::get_fakercom();
   	$fphone=\App\comment::get_phone(9);
   	$id=$request->input('id');
   	return view('admin.comment.newcomment')->with(compact('fname','fphone','id'));
   }
   public function save_com(Request $request){
   	if($request->input('id')!==null){
   		$comment=comment::where('com_id',$request->input('id'))->first();
   			@unlink($comment->com_img);
   		$imgs=\App\com_img::where('com_primary_id',$request->input('id'))->get();
   		foreach($imgs as $k => $v){
   			@unlink($v->com_url);
   		}
   		\App\com_img::where('com_primary_id',$request->input('id'))->delete();
   		$comment->com_name=$request->input('com_name');
   		$comment->com_phone=$request->input('com_phone');
   		$comment->com_order=$request->input('com_order');
   		$comment->com_msg=$request->input('com_msg');
   		$comment->com_star=$request->input('com_star');
   		$comment->com_isshow=$request->input('com_isshow');
   		$comment->com_time=date('Y-m-d H:i:s',time());
   		$comment->com_isuser='0';
   		$msg=$comment->save();
   		if($request->file('com_img')!=null){
   			 foreach($request->file('com_img') as $pic) {
                 $size = filesize($pic);
                 //这里可根据配置文件的设置，做得更灵活一点
                 if($size > 8*1024*1024){
                     return response()->json(['err' => 0, 'str' => '上传封面图文件不能超过8M！']);
                 }
		         $name=$pic->getClientOriginalName();//得到图片名；
		         $ext=$pic->getClientOriginalExtension();//得到图片后缀；
		         $fileName=md5(uniqid($name));
		         $newImagesName=$request->input('id')."_".$fileName.'.'.$ext;//生成新的的文件名
		         $filedir="upload/commment_img/";
		         $msg=$pic->move($filedir,$newImagesName);
		         //$bool=Storage::disk('article')->put($fileName,file_get_contents($pic->getRealPath()));
		         /*$data['pic']='storage/Photo/article/'.$fileName;*///返回文件路径存贮在数据库
		         if(!$msg){
			   	    	return response()->json(['err'=>0,'str'=>'图片上传失败']);
		         }
		         $new_comimg=new \App\com_img();
		         $new_comimg->com_url='/'.$filedir.$newImagesName;
		         $new_comimg->com_primary_id=$comment->com_id;
		         $new_comimg->save();
		   		 }
 		    }
 		 		if($msg)
		         {
				   	    	return response()->json(['err'=>1,'str'=>'保存成功！']);
		         }else{
				   	    	return response()->json(['err'=>0,'str'=>'保存失败！']);
		         }
   	}else{
   		$comment=new comment;
   		$comment->com_name=$request->input('com_name');
   		$comment->com_phone=$request->input('com_phone');
   		$comment->com_order=$request->input('com_order');
   		$comment->com_msg=$request->input('com_msg');
   		$comment->com_star=$request->input('com_star');
   		$comment->com_isshow=$request->input('com_isshow');
   		$comment->com_goods_id=$request->input('goods_id');
   		$comment->com_time=date('Y-m-d H:i:s',time());
   		$comment->com_isuser='0';
   			$msg=$comment->save();
   		if($request->file('com_img')!=null){
   			 foreach($request->file('com_img') as $pic) {
                 $size = filesize($pic);
                 //这里可根据配置文件的设置，做得更灵活一点
                 if($size > 8*1024*1024){
                     return response()->json(['err' => 0, 'str' => '上传图片文件不能超过8M！']);
                 }
		         $name=$pic->getClientOriginalName();//得到图片名；
		         $ext=$pic->getClientOriginalExtension();//得到图片后缀；
		         $fileName=md5(uniqid($name));
		         $newImagesName=$request->input('id')."_".$fileName.'.'.$ext;//生成新的的文件名
		         $filedir="upload/commment_img/";
		         $msg=$pic->move($filedir,$newImagesName);
		         //$bool=Storage::disk('article')->put($fileName,file_get_contents($pic->getRealPath()));
		         /*$data['pic']='storage/Photo/article/'.$fileName;*///返回文件路径存贮在数据库
		         if(!$msg){
			   	    	return response()->json(['err'=>0,'str'=>'图片上传失败']);
		         }
		         $new_comimg=new \App\com_img();
		         $new_comimg->com_url='/'.$filedir.$newImagesName;
		         $new_comimg->com_primary_id=$comment->com_id;
		         $new_comimg->save();
		   		 }
 		    }
 		 		if($msg)
		         {
				   	    	return response()->json(['err'=>1,'str'=>'保存成功！']);
		         }else{
				   	    	return response()->json(['err'=>0,'str'=>'保存失败！']);
		         }
   	}
   }
    public function getusers(Request $request){
    		$id=$request->input('id');
   			$info=$request->all();
        	$cm=$info['order'][0]['column'];
	        $dsc=$info['order'][0]['dir'];
	        $order=$info['columns']["$cm"]['data'];
	        $draw=$info['draw'];
	        $start=$info['start'];
	        $len=$info['length'];
	        $search=trim($info['search']['value']);
	        $counts=DB::table('comment')
	        ->where([['com_isuser','1'],['com_goods_id',$id]])
	        ->count();
	        $newcount=DB::table('goods')
	        ->select('comment.*','goods.goods_real_name')
            ->leftjoin('comment','goods.goods_id','comment.com_goods_id')
	        ->where([['goods.goods_real_name','like',"%$search%"],['comment.com_isuser','=','1'],['goods.goods_id','=',$id]])
	        ->orWhere([['comment.com_name','like',"%$search%"],['comment.com_isuser','=','1'],['goods.goods_id','=',$id]])
	        ->orWhere([['comment.com_phone','like',"%$search%"],['comment.com_isuser','=','1'],['goods.goods_id','=',$id]])
	        ->count();
	        $data=DB::table('goods')
	        ->select('comment.*','goods.goods_real_name')
            ->leftjoin('comment','goods.goods_id','comment.com_goods_id')
	        ->where([['goods.goods_real_name','like',"%$search%"],['comment.com_isuser','=','1'],['goods.goods_id','=',$id]])
	        ->orWhere([['comment.com_name','like',"%$search%"],['comment.com_isuser','=','1'],['goods.goods_id','=',$id]])
	        ->orWhere([['comment.com_phone','like',"%$search%"],['comment.com_isuser','=','1'],['goods.goods_id','=',$id]])
	        ->orderBy($order,$dsc)
	        ->offset($start)
	        ->limit($len)
	        ->get();
	        /*foreach($data as $key => $v){
                $data[$key]->com_time=strtotime('Y-m-d H:i:s',$v->com_time);
	        }*/
	        $arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>$data];
	        return response()->json($arr);
    }

}
