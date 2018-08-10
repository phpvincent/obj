<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use Log;
use App\goods;
use App\url;
use App\channel\cuxiaoSDK;
class GoodsController extends Controller
{
   public function index(){
   	  $counts=goods::count();
   	  return view('admin.goods.index')->with('counts',$counts);
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
	         if(strtotime(explode(';',$search)[0])>100&&strtotime(explode(';',$search)[1])>100){
            $timesearch=$search;
            $search='';
            $newlen=$len;
            $len=$counts;
           }
	        $newcount=DB::table('goods')
	        ->select('goods.*','url.url_url','url.url_type','admin.admin_name')
	        ->leftjoin('url','goods.goods_id','=','url.url_goods_id')
	        ->leftjoin('admin','goods.goods_admin_id','=','admin.admin_id')
	        ->where([['goods.goods_name','like',"%$search%"],['goods.is_del','=','0']])
	        ->orWhere([['goods.goods_real_name','like',"%$search%"],['goods.is_del','=','0']])
	        ->orWhere([['goods.goods_msg','like',"%$search%"],['goods.is_del','=','0']])
	        ->orWhere([['url.url_url','like',"%$search%"],['goods.is_del','=','0']])
	        ->orWhere([['admin.admin_name','like',"%$search%"],['goods.is_del','=','0']])
	        ->count();
	        $data=DB::table('goods')
	        ->select('goods.*','url.url_url','url.url_type','admin.admin_name')
	        ->leftjoin('url','goods.goods_id','=','url.url_goods_id')
	        ->leftjoin('admin','goods.goods_admin_id','=','admin.admin_id')
	        ->where([['goods.goods_name','like',"%$search%"],['goods.is_del','=','0']])
	        ->orWhere([['goods.goods_real_name','like',"%$search%"],['goods.is_del','=','0']])
	        ->orWhere([['goods.goods_msg','like',"%$search%"],['goods.is_del','=','0']])
	        ->orWhere([['url.url_url','like',"%$search%"],['goods.is_del','=','0']])
	        ->orWhere([['admin.admin_name','like',"%$search%"],['goods.is_del','=','0']])
	        ->orderBy($order,$dsc)
	        ->offset($start)
	        ->limit($len)
	        ->get();
	          if(isset($timesearch)){
               if((strtotime(explode(';',$timesearch)[0])>100&&strtotime(explode(';',$timesearch)[1])>100)||strtotime($timesearch)>100){
               $newcount=0;
               $dataarr=[];
               /*$msg=[];*/
               foreach($data as $k=> $v){/*dd(explode(';',$timesearch),$v->goods_up_time);dd(strtotime($v->goods_up_time),strtotime(explode(';',$timesearch)[1]),strtotime(explode(';',$timesearch)[0]));*/
            /* $msg[$k]['name']=$v->vis_ip;
               $msg[$k]['end']=(strtotime($v->goods_up_time)>=strtotime(explode(';',$timesearch)[0])&&strtotime($v->goods_up_time)<=strtotime(explode(';',$timesearch)[1]))||strtotime($v->goods_up_time)==strtotime($timesearch);
               $msg[$k]['time']=(strtotime($v->goods_up_time));
               $msg[$k]['aes']=strtotime(explode(';',$timesearch)[0]).'-'.strtotime(explode(';',$timesearch)[1]);*/
                  if((strtotime($v->goods_up_time)>=strtotime(explode(';',$timesearch)[0])&&strtotime($v->goods_up_time)<=strtotime(explode(';',$timesearch)[1]))||strtotime($v->goods_up_time)==strtotime($timesearch)){
                     $newcount+=1;
                     $dataarr[]=$v;
                     }
               }
               $arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>array_slice($dataarr,$start,$newlen)];
                   return response()->json($arr);
               }
           }
           foreach($data as $key => $v){
            $url=\App\url::where('url_zz_goods_id',$v->goods_id)->first();
            if($url!=null){
               $data[$key]->url_type=$url->url_type;
               $data[$key]->url_url=$url->url_url;
            }
           }
	        $arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>$data];
	        return response()->json($arr);
   }
   public function addgoods(Request $request){
      return view('admin.goods.addgoods');
   }
   public function post_add(Request $request){
        $data=$request->all();
     $goods=new \App\goods();
      $goods->goods_name=$data['goods_name'];
         $goods->goods_real_name=$data['goods_real_name'];
         $goods->goods_msg=$data['goods_msg'];
         $goods->goods_real_price=$data['goods_real_price'];
         $goods->goods_price=$data['goods_price'];
         $goods->goods_cuxiao_name=$data['goods_cuxiao_name'];
         $goods->goods_pix=$data['goods_pix'];
         $goods->goods_admin_id=$data['admin_id'];
         $goods->goods_up_time=date('Y-m-d h:i:s',time());
         if($request->hasFile('goods_video')){
               $file=$request->file('goods_video');
               $name=$file->getClientOriginalName();//得到图片名；
               $ext=$file->getClientOriginalExtension();//得到图片后缀；
               $fileName=md5(uniqid($name));
               $newfilename='first'."_".$fileName.'.'.$ext;//生成新的的文件名
               $filedir="upload/fm_video/";
               $msg=$file->move($filedir,$newfilename);
               $goods->goods_video=$filedir.$newfilename;
         }
         $goods->goods_num=$data['goods_num'];
         $goods->goods_end=$data['goods_end1'].':'.$data['goods_end2'].':'.$data['goods_end3'];
         $goods->goods_comment_num=$data['goods_comment_num'];
         $goods->goods_des_html=isset($data['editor1'])?$data['editor1']:"";
         $goods->goods_type_html=isset($data['editor2'])?$data['editor2']:"";
         if(!$request->hasFile('fm_imgs')){
                              return response()->json(['err'=>0,'str'=>'封面图为空！']);
         }
        $msg2=$goods->save();
        $goods_id=$goods->goods_id;
          foreach($request->file('fm_imgs') as $pic) {
              //$file->move(base_path().'/public/uploads/', $file->getClientOriginalName());
              $name=$pic->getClientOriginalName();//得到图片名；
               $ext=$pic->getClientOriginalExtension();//得到图片后缀；
               $fileName=md5(uniqid($name));
               $newImagesName='first'."_".$fileName.'.'.$ext;//生成新的的文件名
               $filedir="upload/fm_imgs/";
               $msg=$pic->move($filedir,$newImagesName);
               //$bool=Storage::disk('article')->put($fileName,file_get_contents($pic->getRealPath()));
               /*$data['pic']='storage/Photo/article/'.$fileName;*///返回文件路径存贮在数据库
               /*if(!$msg){
                     return response()->json(['err'=>0,'str'=>'图片上传失败']);
               }*/
               $nimg=new \App\img;
               $nimg->img_url=$filedir.$newImagesName;
               $nimg->img_goods_id=$goods_id;
               $nimg->save();
          }
         $sdk=new cuxiaoSDK($goods);
         $msg1=$sdk->saveadd($request,$goods_id);
         $goods->goods_cuxiao_type=$data['goods_cuxiao_type'];
         $goods->save();
         if($msg1&&$msg2)
         {
                  return response()->json(['err'=>1,'str'=>'添加成功！']);
         }else{
                  return response()->json(['err'=>0,'str'=>'添加失败！']);
         }
      
   }
   public function delgoods(Request $request){
         $goods=goods::where('goods_id',$request->input('id'))->first();
         $goods->is_del='1';
         $url_pt=\App\url::where('url_goods_id',$goods->goods_id)->get();
         foreach($url_pt as $key => $v){
            $v->url_goods_id=null;
            $v->save();
         }
         $zz_url=\App\url::where('url_zz_goods_id',$goods->goods_id)->get();
         foreach($zz_url as $key => $v){
            $v->url_zz_goods_id=null;
            $v->save();
         }
         if($goods->save()){
	   	    	return response()->json(['err'=>1,'str'=>'删除成功']);
         }else{
	   	    	return response()->json(['err'=>0,'str'=>'删除失败']);
         }
   }
   public function online(Request $request){
         $url=url::where('url_url',$request->input('id'))->first();
         if($url==null){
               return response()->json(['err'=>0,'str'=>'启动失败,需先绑定域名']);
         }
         $url->url_type='1';
         if($url->save()){
	   	    	return response()->json(['err'=>1,'str'=>'启动成功']);
         }else{
	   	    	return response()->json(['err'=>0,'str'=>'启动失败']);
         }
   }
   public function close(Request $request){
         $url=url::where('url_url',$request->input('id'))->first();
         $url->url_type='0';
         if($url->save()){
	   	    	return response()->json(['err'=>1,'str'=>'下线成功']);
         }else{
	   	    	return response()->json(['err'=>0,'str'=>'下线失败']);
         }
   }
   public function outgoods(Request $request){
   		$data=goods::select('goods.goods_id','goods.goods_name','goods.goods_msg','goods.goods_video','goods.goods_real_price','goods.goods_price','goods.goods_num','goods.goods_end','goods.goods_comment_num','goods.goods_real_name','goods.goods_cuxiao_name','admin.admin_name','goods_online_time')
	        ->leftjoin('url','goods.goods_id','=','url.url_goods_id')
	        ->leftjoin('admin','goods.goods_admin_id','=','admin.admin_id')
	        ->where('goods.is_del','0')
			->orderBy('goods.goods_up_time','desc')
			->get()->toArray();
   		$filename='商品信息'.date('Y-m-d h:i:s',time()).'.xls';
   		$zdname=['商品id','商品名','商品描述','商品视频地址','商品单价','商品现价','商品库存','倒计时','评论数','单品名','促销信息','所属人员','发布时间'];
        out_excil($data,$zdname,'单品信息记录表',$filename);
   }

   public function chgoods(Request $request){
   	 	$id=$request->input('id');
   	 	$goods=goods::where('goods_id',$id)->first();
   	 	$goods['admin_name']=\App\admin::where('admin_id',$goods['goods_admin_id'])->first()->admin_name;
   	 	/*$goods['is_online']=\App\url::where('url_goods_id',$goods['goods_id'])->first()->url_type;
         $url=\App\url::where('url_goods_id',$goods['goods_id'])->first();
   	 	$goods['url']=$url->url_url;
         if($id==$url->url_goods_id){
              $goods['is_zz']=0;
         }elseif($id==$url->url_zz_goods_id){
              $goods['is_zz']=1;
         }*/
   	 	return view('admin.goods.update')->with(compact('goods'));
   }
   public function post_update(Request $request){
   		$data=$request->all();
   		$goods=goods::where('goods_id',$data['goods_id'])->first();
   		$goods->goods_name=$data['goods_name'];
   		$goods->goods_real_name=$data['goods_real_name'];
   		$goods->goods_msg=$data['goods_msg'];
   		$goods->goods_real_price=$data['goods_real_price'];
   		$goods->goods_price=$data['goods_price'];
   		$goods->goods_cuxiao_name=$data['goods_cuxiao_name'];
         $goods->goods_pix=$data['goods_pix'];
         
   		if($request->hasFile('goods_video')){
   			@unlink($goods->goods_video);
   			$file=$request->file('goods_video');
   			$name=$file->getClientOriginalName();//得到图片名；
		         $ext=$file->getClientOriginalExtension();//得到图片后缀；
		         $fileName=md5(uniqid($name));
		         $newfilename=$request->input('goods_id')."_".$fileName.'.'.$ext;//生成新的的文件名
		         $filedir="upload/fm_video/";
		         $msg=$file->move($filedir,$newfilename);
		    $goods->goods_video=$filedir.$newfilename;
   		}
   		
   		$goods->goods_num=$data['goods_num'];
   		$goods->goods_end=$data['goods_end1'].':'.$data['goods_end2'].':'.$data['goods_end3'];
   		$goods->goods_comment_num=$data['goods_comment_num'];
   		$goods->goods_des_html=isset($data['editor1'])?$data['editor1']:"";
   		$goods->goods_type_html=isset($data['editor2'])?$data['editor2']:"";
   		if($request->hasFile('fm_imgs')){
   			$old_img=\App\img::where('img_goods_id',$data['goods_id'])->get();
   			foreach($old_img as $val){
   				@unlink($val->img_url);
   			}
   			$old_img=\App\img::where('img_goods_id',$data['goods_id'])->delete();
		    foreach($request->file('fm_imgs') as $pic) {
		        //$file->move(base_path().'/public/uploads/', $file->getClientOriginalName());
		        $name=$pic->getClientOriginalName();//得到图片名；
		         $ext=$pic->getClientOriginalExtension();//得到图片后缀；
		         $fileName=md5(uniqid($name));
		         $newImagesName=$request->input('goods_id')."_".$fileName.'.'.$ext;//生成新的的文件名
		         $filedir="upload/fm_imgs/";
		         $msg=$pic->move($filedir,$newImagesName);
		         //$bool=Storage::disk('article')->put($fileName,file_get_contents($pic->getRealPath()));
		         /*$data['pic']='storage/Photo/article/'.$fileName;*///返回文件路径存贮在数据库
		         /*if(!$msg){
			   	    	return response()->json(['err'=>0,'str'=>'图片上传失败']);
		         }*/
		         $nimg=new \App\img;
		         $nimg->img_url=$filedir.$newImagesName;
		         $nimg->img_goods_id=$data['goods_id'];
		         $nimg->save();
		    }
		}
   		/*$url=\App\url::where('url_goods_id',$data['goods_id'])->first();
   		$url->url_url=$data['url'];
   		$url->url_type=isset($data['is_online']) ? $data['is_online'] : '0';*/
         $sdk=new cuxiaoSDK($goods);
         $msg1=$sdk->saveupdate($request);
         $goods->goods_cuxiao_type=$data['goods_cuxiao_type'];
   		$msg2=$goods->save();
   		/*$msg3=$url->save();*/
   		if($msg1&&$msg2)
         {
		   	    	return response()->json(['err'=>1,'str'=>'保存成功！']);
         }else{
		   	    	return response()->json(['err'=>0,'str'=>'保存失败！']);
         }
   }
   public function getcuxiaohtml(Request $request){
   	 $sdk=cuxiaoSDK::getcuxiaohtml($request->input('id'),$request->input('goods_id'));
   	 return $sdk;
   }
}
/*	$dataResult = array();      //todo:导出数据（自行设置） 

$headTitle = "XX保险公司 优惠券赠送记录"; 

$title = "优惠券记录"; 

$headtitle= "<tr style='height:50px;border-style:none;><th border=\"0\" style='height:60px;width:270px;font-size:22px;' colspan='11' >{$headTitle}</th></tr>"; 

$titlename = "<tr> 

               <th style='width:70px;' >合作商户</th> 

               <th style='width:70px;' >会员卡号</th> 

               <th style='width:70px;'>车主姓名</th> 

               <th style='width:150px;'>手机号</th> 

               <th style='width:70px;'>车牌号</th> 

               <th style='width:100px;'>优惠券类型</th> 

               <th style='width:70px;'>优惠券名称</th> 

               <th style='width:70px;'>优惠券面值</th> 

               <th style='width:70px;'>优惠券数量</th> 

               <th style='width:70px;'>赠送时间</th> 

               <th style='width:90px;'>截至有效期</th> 

           </tr>"; 

           $filename = $title.".xls"; 

       $this->excelData($dataResult,$titlename,$headtitle,$filename); */

