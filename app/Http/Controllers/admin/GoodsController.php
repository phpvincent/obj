<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Storage;
use Log;
use App\goods;
use App\url;
use App\channel\cuxiaoSDK;
class GoodsController extends Controller
{
   public function index(){
      if(Auth::user()->is_root=='1'){
         $counts=goods::count();
       }else{
        $counts=goods::where('goods_admin_id',Auth::user()->admin_id)->count();
       }
        $type=\App\goods_type::get();

   	  return view('admin.goods.index')->with(compact('counts','type'));
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
          ->where(function($query){
            if(Auth::user()->is_root!='1'){
              $query->whereIn('goods_admin_id',\App\admin::get_group_ids(Auth::user()->admin_id));
            }
          })
	        ->count();
	         if(strtotime(explode(';',$search)[0])>100&&strtotime(explode(';',$search)[1])>100){
            $timesearch=$search;
            $search='';
            $newlen=$len;
            $len=$counts;
           }
           $json=json_decode($search,true);
           if(isset($json['goods_type'])&&$json['goods_type']>0){
            $where=['goods.goods_type','=',(Int)$json['goods_type']];
            $search=null;
           }else if(isset($json['goods_type'])&&$json['goods_type']==0){
            $where=['goods.goods_id','>',0];
            $search=null;
           }else{
            $where=['goods.goods_id','>',0];
           }
	        $newcount=DB::table('goods')
	        ->select('goods.*','url.url_url','url.url_type','admin.admin_name')
	        ->leftjoin('url','goods.goods_id','=','url.url_goods_id')
	        ->leftjoin('admin','goods.goods_admin_id','=','admin.admin_id')
          ->where(function($query)use($where,$search){
             $query->where([['goods.goods_name','like',"%$search%"],['goods.is_del','=','0'],$where]);
             $query->orWhere([['goods.goods_real_name','like',"%$search%"],['goods.is_del','=','0'],$where]);
             $query->orWhere([['goods.goods_msg','like',"%$search%"],['goods.is_del','=','0'],$where]);
             $query->orWhere([['url.url_url','like',"%$search%"],['goods.is_del','=','0'],$where]);
             $query->orWhere([['admin.admin_name','like',"%$search%"],['goods.is_del','=','0'],$where]);
          })
	       
          ->where(function($query){
            if(Auth::user()->is_root!='1'){
              $ids=\App\admin::get_group_ids(Auth::user()->admin_id);
              $query->whereIn('goods.goods_admin_id',$ids);
            }
          })
	        ->count();
	        $data=DB::table('goods')
	        ->select('goods.*','url.url_url','url.url_type','admin.admin_name')
	        ->leftjoin('url','goods.goods_id','=','url.url_goods_id')
	        ->leftjoin('admin','goods.goods_admin_id','=','admin.admin_id')
          ->where(function($query)use($where,$search){
            $query->where([['goods.goods_name','like',"%$search%"],['goods.is_del','=','0'],$where]);
            $query->orWhere([['goods.goods_real_name','like',"%$search%"],['goods.is_del','=','0'],$where]);
            $query->orWhere([['goods.goods_msg','like',"%$search%"],['goods.is_del','=','0'],$where]);
            $query->orWhere([['url.url_url','like',"%$search%"],['goods.is_del','=','0'],$where]);
            $query->orWhere([['admin.admin_name','like',"%$search%"],['goods.is_del','=','0'],$where]);
          })
	        
          ->where(function($query){
           if(Auth::user()->is_root!='1'){
              $ids=\App\admin::get_group_ids(Auth::user()->admin_id);
              $query->whereIn('goods.goods_admin_id',$ids);
            }
          })
          ->where(function($query){
            $query->where('goods_id','<>','4');
          })
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
      $type=\App\goods_type::get();
      return view('admin.goods.addgoods')->with(compact('type'));
   }
   public function post_add(Request $request){
    //修改单品
        $data=$request->all();
        $array_true = [];
        if(!empty($data['goods_config_name'])){
            foreach ($data['goods_config_name'] as $item)
            {
                if(!empty($item['msg'])){
                    foreach ($item['msg'] as $val)
                    {
                        if(!$val['config_imgs']){
                            array_push($array_true,false);
                        }else{
                            array_push($array_true,true);
                        }
                    }
                }
            }
        }
        if(in_array(true,$array_true) && in_array(false,$array_true)){
            return response()->json(['err'=>0,'str'=>'扩展属性图片上传不完整！']);
        }
        $goods=new \App\goods();
         $goods->goods_name=$data['goods_name'];
         $goods->goods_real_name=$data['goods_real_name'];
         $isset=\App\goods::where('goods_real_name',$data['goods_real_name'])->first();
         if($isset!=null){
                  return response()->json(['err'=>0,'str'=>'添加失败！该单品名已被使用！']);
         }
         $goods->goods_msg=$data['goods_msg'];
         $goods->goods_real_price=$data['goods_real_price'];
         $goods->goods_price=$data['goods_price'];
         $goods->goods_cuxiao_name=$data['goods_cuxiao_name'];
         $goods->goods_pix=$data['goods_pix'];
         $goods->goods_yahoo_pix=$data['goods_yahoo_pix'];
         $goods->goods_admin_id=$data['admin_id'];
         $goods->goods_buy_url=$request->has('goods_buy_url')?$data['goods_buy_url']:null;
         $goods->goods_buy_msg=$request->has('goods_buy_msg')?$data['goods_buy_msg']:null;
         $goods->goods_up_time=date('Y-m-d h:i:s',time());
         $goods->goods_blade_type=$data['goods_blade_type'];
         $goods->goods_type=isset($data['goods_type'])?$data['goods_type']:null;
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
         //增加商品扩展属性
//         if($request->has('goods_config_name')&&$data['goods_config_name']!=null){
//            foreach($data['goods_config_name'] as $k => $v){
//              $gf=new \App\goods_config();
//              $gf->goods_primary_id=$goods->goods_id;
//              if($v==null||$v==''){
//                break;
//              }
//              $gf->goods_config_msg=$v;
//              $gf->save();
//               $msgarr=explode(';', $data['goods_config'][$k]);
//                foreach($msgarr as $kk => $vv){
//                  if($vv!=null && $vv!=''){
//                     $fm=new \App\config_val();
//                     $fm->config_type_id=$gf->goods_config_id;
//                     $fm->config_val_msg=$vv;
//                     $fm->config_goods_id=$goods->goods_id;
//                     $fm->config_val_img=isset($vv['config_val_msg'])?$vv['config_val_msg']:null;
//                     $fm->save();
//                  }
//                }
//            }
//         }
           //新增或修改商品属性名和属性值
           $goods_attr = $data['goods_config_name'];
           if(!empty($goods_attr)){
               foreach ($goods_attr as $item)
               {
                   if(isset($item['id'])){
                       $goods_config = \App\goods_config::where('goods_config_id',$item['id'])->first();
                   }else{
                       $goods_config = new \App\goods_config();
                   }
                   $goods_config->goods_config_msg = $item['goods_config_name'];
                   $goods_config->goods_config_type = 0;
                   $goods_config->goods_primary_id = $goods_id;
                   $goods_config->is_img = 0;
                   $goods_config->save();
                   $con_val = \App\config_val::createOrSave($item['msg'],$goods_config->goods_config_id,$goods_id);
                   if($con_val === false){
                       return response()->json(['err'=>0,'str'=>'保存失败！']);
                   }
               }
           }
         if($msg1&&$msg2)
         {
                  return response()->json(['err'=>1,'str'=>'添加成功！']);
         }else{
                  return response()->json(['err'=>0,'str'=>'添加失败！']);
         }
      
   }
   public function delgoods(Request $request){
    //删除单品
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
    //下载Excel
   		$data=goods::select('goods.goods_id','goods.goods_name','goods.goods_msg','goods.goods_video','goods.goods_real_price','goods.goods_price','goods.goods_num','goods.goods_end','goods.goods_comment_num','goods.goods_real_name','goods.goods_cuxiao_name','admin.admin_name','goods_online_time','goods_pix','goods_buy_url')
	        ->leftjoin('url','goods.goods_id','=','url.url_goods_id')
	        ->leftjoin('admin','goods.goods_admin_id','=','admin.admin_id')
	        ->where('goods.is_del','0')
          ->where(function($query){
            if(Auth::user()->is_root!='1'){
              $ids=\App\admin::get_group_ids(Auth::user()->admin_id);
              $query->whereIn('goods.goods_admin_id',$ids);
            }
          })
			->orderBy('goods.goods_up_time','desc')
			->get()->toArray();
   		$filename='商品信息'.date('Y-m-d H:i:s',time()).'.xls';
   		$zdname=['商品id','商品名','商品描述','商品视频地址','商品单价','商品现价','商品库存','倒计时','评论数','单品名','促销信息','所属人员','发布时间','商品像素','商品采购url'];
        out_excil($data,$zdname,'单品信息记录表',$filename);
   }
   public function chgoods(Request $request){
    //修改单品模板
   	 	$id=$request->input('id');
   	 	$goods=goods::where('goods_id',$id)->first();
   	 	$goods['admin_name']=\App\admin::where('admin_id',$goods['goods_admin_id'])->first()->admin_name;
         $type=\App\goods_type::get();
     
        $goods_config=\App\goods_config::where('goods_primary_id',$id)->get();
        if($goods_config!=null){
          foreach($goods_config as $k => $v){
            $arr=\App\config_val::where('config_type_id',$v->goods_config_id)->orderBy('config_val_id','asc')->get()->toArray();
//            $str=[];
//            foreach($arr as $val){
//                array_push($str,$arr);
//                $str[$val['config_val_id']] = $val['config_val_msg'];
//            }
            $goods_config[$k]->config_msg=$arr;
          }
        }
   	 	return view('admin.goods.update')->with(compact('goods','type','goods_config'));
   }
   public function post_update(Request $request){
       $data=$request->all();
       $array_true = [];
       $photo = \App\config_val::where('config_goods_id',$data['goods_id'])->pluck('config_val_img')->toArray();
   		if(empty($photo) || in_array(null,$photo)){
            if(!empty($data['goods_config_name'])){
                foreach ($data['goods_config_name'] as $item)
                {
                    if(!empty($item['msg'])){
                        foreach ($item['msg'] as $val)
                        {
                            if(!$val['config_imgs']){
                                array_push($array_true,false);
                            }else{
                                array_push($array_true,true);
                            }
                        }
                    }
                }
            }
            if(in_array(true,$array_true) && in_array(false,$array_true)){
                return response()->json(['err'=>0,'str'=>'扩展属性图片上传不完整！']);
            }
        }else{
            if(!empty($data['goods_config_name'])){
                foreach ($data['goods_config_name'] as $item)
                {
                    if(!empty($item['msg'])){
                        foreach ($item['msg'] as $val)
                        {
                            if(!$val['config_imgs'] && !isset($val['id'])){
                                array_push($array_true,false);
                            }else{
                                array_push($array_true,true);
                            }
                        }
                    }
                }
            }
            if(in_array(false,$array_true)){
                return response()->json(['err'=>0,'str'=>'扩展属性图片上传不完整！']);
            }
        }

   		$goods=goods::where('goods_id',$data['goods_id'])->first();
        $isset=\App\goods::where('goods_real_name',$data['goods_real_name'])->first();
         if($isset!=null&&$isset['goods_id']!=$data['goods_id']){
                  return response()->json(['err'=>0,'str'=>'添加失败！该单品名已被使用！']);
         }
   		$goods->goods_name=$data['goods_name'];
   		$goods->goods_real_name=$data['goods_real_name'];
   		$goods->goods_msg=$data['goods_msg'];
   		$goods->goods_real_price=$data['goods_real_price'];
   		$goods->goods_price=$data['goods_price'];
   		$goods->goods_cuxiao_name=$data['goods_cuxiao_name'];
        $goods->goods_blade_type=$data['goods_blade_type'];
        $goods->goods_buy_url=$request->has('goods_buy_url')?$data['goods_buy_url']:null;
        $goods->goods_buy_msg=$request->has('goods_buy_msg')?$data['goods_buy_msg']:null;
        $goods->goods_pix=$data['goods_pix'];
        $goods->goods_yahoo_pix=$data['goods_yahoo_pix'];
        $goods->goods_type=$data['goods_type'];
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

         //新增或修改商品属性名和属性值
       $goods_attr = $data['goods_config_name'];
       if(!empty($goods_attr)){
          foreach ($goods_attr as $item)
          {
              if(isset($item['id'])){
                  $goods_config = \App\goods_config::where('goods_config_id',$item['id'])->first();
              }else{
                  $goods_config = new \App\goods_config();
              }
              $goods_config->goods_config_msg = $item['goods_config_name'];
              $goods_config->goods_config_type = 0;
              $goods_config->goods_primary_id = $data['goods_id'];
              $goods_config->is_img = 0;
              $goods_config->save();
              $con_val = \App\config_val::createOrSave($item['msg'],$goods_config->goods_config_id,$data['goods_id']);
              if($con_val === false){
                  return response()->json(['err'=>0,'str'=>'保存失败！']);
              }
          }
       }
       /*$msg3=$url->save();*/
       /* if($request->has('goods_config_name')&&$data['goods_config_name']!=null){
          //删除原有附加属性
          \App\goods_config::where('goods_primary_id',$goods->goods_id)->delete();
          \App\config_val::where('config_goods_id',$goods->goods_id)->delete();
          //添加现有附加属性
              foreach($data['goods_config_name'] as $k => $v){
              $gf=new \App\goods_config();
              $gf->goods_primary_id=$goods->goods_id;
              $gf->goods_config_msg=$v;
               if($v==null||$v==''){
                break;
              }
              $gf->save();
               $msgarr=explode(';', $data['goods_config'][$k]);
                foreach($msgarr as $kk => $vv){
                  if($vv!=null && $vv!=''){
                     $fm=new \App\config_val();
                     $fm->config_type_id=$gf->goods_config_id;
                     $fm->config_val_msg=$vv;
                     $fm->config_goods_id=$goods->goods_id;
                     $fm->config_val_img=isset($vv['config_val_msg'])?$vv['config_val_msg']:null;
                     $fm->save();
                  }
                }              
            }
           }*/
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
  