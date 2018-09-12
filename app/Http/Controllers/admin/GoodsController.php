<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use Exception;
use Illuminate\Support\Facades\Storage;
use Log;
use App\goods;
use App\comment;
use App\des;
use App\par;
use App\img;
use App\cuxiao;
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

    /** 商品信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
          ->where(function($query){
            $query->where('goods_id','<>','4');
          })
          ->where(function($query)use($request){
            if($request->input('mintime')!=null&&$request->input('maxtime')==null){
              $query->where('goods.goods_up_time','>',$request->input('mintime'));
            }elseif($request->input('maxtime')!=null&&$request->input('mintime')==null){
              $query->where('goods.goods_up_time','<',$request->input('maxtime'));
            }elseif($request->input('maxtime')!=null&&$request->input('mintime')!=null){
               $query->whereBetween('goods.goods_up_time',[$request->input('mintime'),$request->input('maxtime')]);
            }
          })
          ->where(function($query)use($request){
            $check_type=$request->input('check_type');
              if($check_type=='#'){

              }elseif(is_numeric($check_type)){
                $query->where('goods.goods_heshen',$check_type);
              }elseif($check_type=='@'){
                $second=\App\goods_check::first();
                $second=$second->goods_check_second;
                $query->where('goods.goods_check_time','>',date("Y-m-d H:i:s",time()-$second));
                $query->where('goods.goods_heshen','<>','1');
              }elseif($check_type=='$'){
                $second=\App\goods_check::first();
                $second=$second->goods_check_second;
                $query->where('goods.goods_check_time','<',date("Y-m-d H:i:s",time()-$second));
                $query->where('goods.goods_heshen','<>','1');
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
          ->where(function($query)use($request){
            if($request->input('mintime')!=null&&$request->input('maxtime')==null){
              $query->where('goods.goods_up_time','>',$request->input('mintime'));
            }elseif($request->input('maxtime')!=null&&$request->input('mintime')==null){
              $query->where('goods.goods_up_time','<',$request->input('maxtime'));
            }elseif($request->input('maxtime')!=null&&$request->input('mintime')!=null){
               $query->whereBetween('goods.goods_up_time',[$request->input('mintime'),$request->input('maxtime')]);
            }
          })
          ->where(function($query)use($request){
            $check_type=$request->input('check_type');
              if($check_type=='#'){

              }elseif(is_numeric($check_type)){
                $query->where('goods.goods_heshen',$check_type);
              }elseif($check_type=='@'){
                $second=\App\goods_check::first();
                $second=$second->goods_check_second;
                $query->where('goods.goods_check_time','>',date("Y-m-d H:i:s",time()-$second));
                $query->where('goods.goods_heshen','<>','1');
              }elseif($check_type=='$'){
                $second=\App\goods_check::first();
                $second=$second->goods_check_second;
                $query->where('goods.goods_check_time','<',date("Y-m-d H:i:s",time()-$second));
                $query->where('goods.goods_heshen','<>','1');
              }
          })
	        ->orderBy($order,$dsc)
	        ->offset($start)
	        ->limit($len)
	        ->get();
	         
           foreach($data as $key => $v){
            $url=\App\url::where('url_zz_goods_id',$v->goods_id)->first();
            if($url!=null){
               $data[$key]->url_type=$url->url_type;
               $data[$key]->url_url=$url->url_url;
            }
            //计算剩余保护时间
            if($v->goods_heshen!='1'){
              $second=\App\goods_check::first()['goods_check_second'];
                $less_time=time()-strtotime($v->goods_check_time)-$second;
                  if($less_time>0){
                      $data[$key]->less_time='<span style="color:red;">保护时间已过！已被屏蔽！</span>';
                  }else{
                    if($less_time>-300){
                         $data[$key]->less_time="<span style='color:red;'>仅剩".abs($less_time).'秒</span>';
                    }else{
                         $data[$key]->less_time=abs($less_time).'秒';
                    }
                  }
            }else{
              $data[$key]->less_time='<span style="color:green;">正常状态</span>';
            }
           }
	        $arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>$data];
	        return response()->json($arr);
   }
   public function addgoods(Request $request){
      $type=\App\goods_type::get();
      return view('admin.goods.addgoods')->with(compact('type'));
   }

    /** 新增商品
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
   public function post_add(Request $request){
    //修改单品
        $data=$request->all();
        $array_goods_config = [];
        $array_config_val = [];
        $array_true = [];
        if(isset($data['goods_config_name'])){
            if(count($data['goods_config_name']) == 1){
                foreach ($data['goods_config_name'] as $item)
                {
                    if(!$item['goods_config_name']){
                        $data['goods_config_name'] = [];
                    }
                }
            }
        }else{
            $data['goods_config_name'] = [];
        }
        if(!empty($data['goods_config_name'])){
            foreach ($data['goods_config_name'] as $item)
            {
                if(!trim($item['goods_config_name'])){
                    array_push($array_goods_config,false);
                }
                if(!empty($item['msg'])){
                    foreach ($item['msg'] as $val)
                    {
                        if(!$val['config_imgs']){
                            array_push($array_true,false);
                        }else{
                            array_push($array_true,true);
                        }
                        if(!trim($val['goods_config'])){
                            array_push($array_config_val,false);
                        }
                    }
                }
            }
        }
       if(in_array(true,$array_true) && in_array(false,$array_true)){
            return response()->json(['err'=>0,'str'=>'扩展属性图片上传不完整！']);
        }
       if(!empty($array_config_val)){
           return response()->json(['err'=>0,'str'=>'属性值不能为空！']);
       }
       if(!empty($array_goods_config)){
           return response()->json(['err'=>0,'str'=>'属性名不能为空！']);
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
         //触发核审机制
         if(\App\goods_check::first()['goods_is_check']=='0'){//判断是否开启核审机制
            if(Auth::user()->is_root!='1'){
                  $goods->goods_heshen='0';
                  $goods->goods_check_time=date('Y-m-d H:i:s',time());
                  $goods->goods_check_num=1;
           }
         }
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
           $goods_attr = isset($data['goods_config_name'])?$data['goods_config_name']:[];
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
            if(\App\goods_check::first()['goods_is_check']==0){
              return response()->json(['err'=>1,'str'=>'保存成功！请留意核审状态！']);
            }else{
              return response()->json(['err'=>1,'str'=>'保存成功！']);
            }
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

    /** 修改商品
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
   public function post_update(Request $request){
       $data=$request->all();
       
       //字段验证（属性值，属性名，属性照片）
       $array_true = [];
       $array_goods_config = [];
       $array_config_val = [];
       $photo = \App\config_val::where('config_goods_id',$data['goods_id'])->pluck('config_val_img')->toArray();
       if(isset($data['goods_config_name'])){
           if(count($data['goods_config_name']) == 1){
               foreach ($data['goods_config_name'] as $item)
               {
                   if(!$item['goods_config_name']){
                       $data['goods_config_name'] = [];
                   }
               }
           }
       }else{
           $data['goods_config_name'] = [];
       }
   		if(empty($photo) || in_array(null,$photo)){
            if(!empty($data['goods_config_name'])){
                foreach ($data['goods_config_name'] as $item)
                {
                    if(!trim($item['goods_config_name'])){
                        array_push($array_goods_config,false);
                    }
                    if(!empty($item['msg'])){
                        foreach ($item['msg'] as $val)
                        {
                            if(!$val['config_imgs']){
                                array_push($array_true,false);
                            }else{
                                array_push($array_true,true);
                            }
                            if(!trim($val['goods_config'])){
                                array_push($array_config_val,false);
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
                    if(!trim($item['goods_config_name'])){
                        array_push($array_goods_config,false);
                    }
                    if(!empty($item['msg'])){
                        foreach ($item['msg'] as $val)
                        {
                            if(!$val['config_imgs'] && !isset($val['id'])){
                                array_push($array_true,false);
                            }else{
                                array_push($array_true,true);
                            }
                            if(!trim($val['goods_config'])){
                                array_push($array_config_val,false);
                            }
                        }
                    }
                }
            }
            if(in_array(false,$array_true)){
                return response()->json(['err'=>0,'str'=>'扩展属性图片上传不完整！']);
            }
        }
       if(!empty($array_config_val)){
           return response()->json(['err'=>0,'str'=>'属性值不能为空！']);
       }
       if(!empty($array_goods_config)){
           return response()->json(['err'=>0,'str'=>'属性名不能为空！']);
       }

   		$goods=goods::where('goods_id',$data['goods_id'])->first();
        $isset=\App\goods::where('goods_real_name',$data['goods_real_name'])->first();
         if($isset!=null&&$isset['goods_id']!=$data['goods_id']){
                  return response()->json(['err'=>0,'str'=>'添加失败！该单品名已被使用！']);
         }
       //判断是否触发核审机制
       if(\App\goods_check::first()['goods_is_check']==0){
         $recheck=$request->has('recheck')?$request->input('recheck'):0;
         if($request->input('recheck')!=1){//核审人员修改单品不做记录
            //判断是否触发修改次数上限
            $maxcheck=\App\goods_check::first()['goods_check_max'];
            if($goods->goods_check_num>=$maxcheck){
              $old_time=$goods->goods_check_time;
              $o_date=strtotime($old_time);
              $o_date=date('Y-m-d',$o_date);
              $n_date=date('Y-m-d');
                if($o_date==$n_date){
                return response()->json(['err'=>0,'str'=>'该单品今日已达到最高核审次数上限，无法再次修改！请联系管理员处理！']);
              }else{
                $goods->goods_check_time=date('Y-m-d H:i:s',time());
                $goods->goods_check_num=1;
              }
            }
            $goods->goods_heshen='0';
            $old_time=$goods->goods_check_time;
            if($old_time==null){
              $goods->goods_check_time=date('Y-m-d H:i:s',time());
              $goods->goods_check_num=1;
            }elseif($old_time!=null){
              //判断上次核审时间是否为今天
              $o_date=strtotime($old_time);
              $o_date=date('Y-m-d',$o_date);
              $n_date=date('Y-m-d');
              if($o_date==$n_date){
                $goods->goods_check_time=date('Y-m-d H:i:s',time());
                $goods->goods_check_num+=1;
              }else{
                $goods->goods_check_time=date('Y-m-d H:i:s',time());
                $goods->goods_check_num=1;
              }
            }
          }
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
            if(\App\goods_check::first()['goods_is_check']==0){
              return response()->json(['err'=>1,'str'=>'保存成功！请留意核审状态！']);
            }else{
              return response()->json(['err'=>1,'str'=>'保存成功！']);
            }
         }else{
		   	 return response()->json(['err'=>0,'str'=>'保存失败！']);
         }
   }
   public function getcuxiaohtml(Request $request){
   	 $sdk=cuxiaoSDK::getcuxiaohtml($request->input('id'),$request->input('goods_id'));
   	 return $sdk;
   }

    /** 重置单品名
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function only_name(Request $request)
    {
        $id = $request->input('id');
        return view('admin.goods.onlyname')->with(compact('id'));
    }
    /** 复制商品
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function copy_goods(Request $request)
    {
        $id = $request->input('id');
        $good = \App\goods::where('goods_real_name',$request->input('goods_name'))->first();
        if($good){
            return response()->json(['err'=>0,'str'=>'单商品名已存在，请重新命名！']);
        }
        $goods = \App\goods::where('goods_id',$id)->first();
        if(!$goods){
            return response()->json(['err'=>0,'str'=>'请选择复制商品！']);
        }
        $goods = $goods->toArray();
        unset($goods['goods_id']);
        $goods['bd_type'] = 0;
        $goods['goods_real_name'] = $request->input('goods_name');  //单品名称
        $goods['goods_admin_id'] = Auth::user()->admin_id;     //复制人
        $goods['goods_up_time'] = date('Y-m-d H:i:s',time());  // 操作时间
        try {
            DB::beginTransaction();   //开启事务
            //处理视频操作
            if($goods['goods_video']){
                $image = substr($goods['goods_video'],6);
                $ext = strrchr($goods['goods_video'], '.');
                $newImages = '/fm_video/fz_fm_video'.md5(microtime()).rand(100000,1000000).$ext;
                if(Storage::disk('public')->exists($image)){
                    Storage::disk('public')->copy($image, $newImages);
                    $goods['goods_video'] = 'upload'.$newImages;
                }else{
                    $goods['goods_video'] = '';
                }
            }

            //复制新商品
            $goods_id = \App\goods::insertGetId($goods);
            if(!$goods_id){
                throw new Exception('复制失败!');
            }

            //处理封面图片
            $imgs = \App\img::where('img_goods_id',$id)->get();
            if(!$imgs->isEmpty()){
                $imgs = $imgs->toArray();
                foreach ($imgs as $img)
                {
                    unset($img['img_id']);
                    if($img['img_url']){
                        $image = substr($img['img_url'],6);
                        $ext = strrchr($img['img_url'], '.');
                        $newImages = '/fm_imgs/fz_fm_'.md5(microtime()).rand(100000,1000000).$ext;
                        if(Storage::disk('public')->exists($image)){
                            Storage::disk('public')->copy($image, $newImages);
                            $img['img_url'] = 'upload'.$newImages;
                        }else{
                            $img['img_url'] = '';
                        }
                    }
                    $img['img_goods_id'] = $goods_id;
                    $bool = \App\img::insert($img);
                    if(!$bool){
                        throw new Exception('复制失败!');
                    };
                }
            }

            //处理商品属性名 + 属性值
            $goods_config = \App\goods_config::where('goods_primary_id', $id)->get();
            if (!$goods_config->isEmpty()) {
                $goods_config = $goods_config->toArray();
                foreach ($goods_config as $item) {
                    $config_type_id = $item['goods_config_id'];
                    unset($item['goods_config_id']);
                    $item['goods_primary_id'] = $goods_id;
                    //复制新商品属性名
                    $goods_config_id = \App\goods_config::insertGetId($item);
                    if(!$goods_config_id){
                        throw new Exception('复制失败!');
                    }
                    $config_type = \App\config_val::where('config_type_id', $config_type_id)->get();
                    if (!$config_type->isEmpty()) {
                        $config_type = $config_type->toArray();
                        foreach ($config_type as $value) {
                            unset($value['config_val_id']);
                            $value['config_type_id'] = $goods_config_id;
                            $value['config_goods_id'] = $goods_id;
                            //处理图片（图片不可以和原来属性使用一张，防止一个商品改动，其它商品也随之改动）
                            if($value['config_val_img']){
                                $image = substr($value['config_val_img'],6);
                                $ext = strrchr($value['config_val_img'], '.');
                                $newImages = '/sx_imgs/fzgoods_'.md5(microtime()).rand(10000,100000).$ext;
                                if(Storage::disk('public')->exists($image)){
                                    Storage::disk('public')->copy($image, $newImages);
                                    $value['config_val_img'] = 'upload'.$newImages;
                                }else{
                                    $value['config_val_img'] = '';
                                }
                            }
                            //复制新商品属性值
                            $bool = \App\config_val::insert($value);
                            if(!$bool){
                                throw new Exception('复制失败!');
                            }
                        }
                    }
                }
            }

            //处理商品获得促销
            $cuxiao = \App\cuxiao::where('cuxiao_goods_id', $id)->get();
            if ($cuxiao) {
                if (!$cuxiao->isEmpty()) {
                    $cuxiao = $cuxiao->toArray();
                    foreach ($cuxiao as $item)
                    {
                        unset($item['cuxiao_id']);
                        $item['cuxiao_goods_id'] = $goods_id;
                        $special_id = $item['cuxiao_special_id'];
                        if($special_id){
                             $special = \App\special::where('special_id',$special_id)->first();
                             if($special){
                                 $special = $special->toArray();
                                 $special['special_goods_id'] = $goods_id;
                                 unset($special['special_id']);
                                 $new_special_id = \App\special::insertGetId($special);
                                 if(!$new_special_id){
                                     throw new Exception('复制失败!');
                                 }
                                 $item['cuxiao_special_id'] = $new_special_id;
                                 $cuxiao_id = \App\cuxiao::insertGetId($item);
                                 if(!$cuxiao_id){
                                     throw new Exception('复制失败!');
                                 }
                             }
                        }else{
                            $cuxiao_id = \App\cuxiao::insertGetId($item);
                            if(!$cuxiao_id){
                                throw new Exception('复制失败!');
                            }
                        }

                    }
                }
            }
            DB::commit();
        } catch (Exception $e){
            DB::rollback();
            return response()->json(['err' => '0', 'msg' => $e->getMessage()]);
        }
        return response()->json(['err'=>1,'str'=>'操作成功！']);
    }
    //商品预览
    public function show(Request $request)
    {

      $goods_id=$request->input('id');
      \Session::put('test_id',$goods_id);
      return redirect('/');
     /* $imgs=img::where('img_goods_id',$goods_id)->orderBy('img_id','asc')->get(['img_url']);
      $goods=goods::where('goods_id',$goods_id)->first();
      $comment=comment::where(['com_goods_id'=>$goods_id,'com_isshow'=>'1'])->orderBy('com_order','desc')->get();
        foreach($comment as $v=> $key){
            $usename=mb_substr($key->com_name,0,1);
            $usename.='*';
            if(strlen($key->com_name)>2){
              $usename.=mb_substr($key->com_name,2);
            }
            $comment[$v]->com_name=$usename;
            $com_imgs=\App\com_img::where('com_primary_id',$key->com_id)->get();
            if(count($com_imgs)>0){
                 $comment[$v]->com_img=$com_imgs;
             }else{
                $comment[$v]->com_img=null;
             }
           
        }
        //dd($comment);
      $des_img=des::where('des_goods_id',$goods_id)->get();
      $par_img=par::where('par_goods_id',$goods_id)->get();
      //分配预览页面vis_id防止插入访问者记录
      view()->share('vis_id',0);
      //分配状态变量为测试
      view()->share('istest',true);
      $cuxiao=cuxiao::where('cuxiao_goods_id',$goods_id)->orderBy('cuxiao_id','asc')->first();
      //获取倒计时计算为秒数
        $timer=$goods->goods_end;
        $parsed = date_parse($timer);
        $goods->goods_end=$parsed['hour'] * 3600+$parsed['minute'] * 60+$parsed['second'];
        //模板渲染
        $blade_type=$goods->goods_blade_type;
        switch ($blade_type) {
            case '0':
            return view('home.index')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','vis_id'));
                break;
            case '1':
            return view('home.index1')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','vis_id'));
                break;
            case '2':
            return view('home.index2')->with(compact('imgs','goods','comment','des_img','par_img','cuxiao','vis_id'));
                break;
            default:
                # code...
                break;
        }*/
    }
}
  