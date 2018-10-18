<?php

namespace App\Http\Controllers\admin;

use App\admin;
use App\com_img;
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
//      if(Auth::user()->is_root=='1'){
//         $counts=goods::count();
//       }else{
//        $counts=goods::where('goods_admin_id',Auth::user()->admin_id)->count();
//       }
       $counts=goods::whereIn('goods_admin_id',admin::get_admins_id())->count();
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
//              $query->whereIn('goods_admin_id',\App\admin::get_group_ids(Auth::user()->admin_id));
              $query->whereIn('goods_admin_id',admin::get_admins_id());
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
//              $ids=\App\admin::get_group_ids(Auth::user()->admin_id);
//              $query->whereIn('goods.goods_admin_id',$ids);
                $query->whereIn('goods.goods_admin_id',admin::get_admins_id());
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
              if($request->has('pay_type')&&$request->input('pay_type')!='0'){
                //按币种查询
              $query->where('goods.goods_currency_id',$request->input('pay_type'));
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
//              $ids=\App\admin::get_group_ids(Auth::user()->admin_id);
//              $query->whereIn('goods.goods_admin_id',$ids);
              $query->whereIn('goods.goods_admin_id',admin::get_admins_id());
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
              if($request->has('pay_type')&&$request->input('pay_type')!='0'){
                //按币种查询
              $query->where('goods.goods_currency_id',$request->input('pay_type'));
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
            $data[$key]->goods_price=\App\currency_type::where('currency_type_id',$v->goods_currency_id)->first()['currency_type_name'].' '.$v->goods_price;
           }
	        $arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>$data];
	        return response()->json($arr);
   }
   public function addgoods(Request $request){
      $type=\App\goods_type::get();
      $currency_type = \App\currency_type::all();
      return view('admin.goods.addgoods')->with(compact('type','currency_type'));
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
       //验证属性规则
        if(!empty($data['goods_config_name'])){
            foreach ($data['goods_config_name'] as $item)
            {
                if(!trim($item['goods_config_name'])){
                    array_push($array_goods_config,false);
                }
                if(!empty($item['msg'])){
                    $array_true = [];
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
                    if(in_array(true,$array_true) && in_array(false,$array_true)){
                        return response()->json(['err'=>0,'str'=>'扩展属性图片上传不完整！']);
                    }
                }
            }
        }
       if(!empty($array_config_val)){
           return response()->json(['err'=>0,'str'=>'属性值不能为空！']);
       }
       if(!empty($array_goods_config)){
           return response()->json(['err'=>0,'str'=>'属性名不能为空！']);
       }

       $goods=new \App\goods();
       $isset=\App\goods::where('goods_real_name',$data['goods_real_name'])->first();
       if($isset!=null){
              return response()->json(['err'=>0,'str'=>'添加失败！该单品名已被使用！']);
       }

       $templets = []; //首页显示内容
       $array = [];    //模块显示数组

       $pay_type = isset($data['pay_type']) ? $data['pay_type'] : ['0'];
       $goods->goods_pay_type= implode(',',$pay_type);
       if(in_array('1',$pay_type)){
           //paypal不支持的币种
           $currency_type = \App\currency_type::where('currency_type_id',$data['currency_type'])->value('currency_english_name');
           if(!in_array($currency_type, \App\currency_type::$CURRENCY_TYPE)){
               return response()->json(['err'=>0,'str'=>'抱歉！当前选择币种不支持paypal支付！']);
           }
           //判断币种金额是否存在限制
           if($currency_type == 'THD' || $currency_type == 'JPY'){
               //满减优惠
               if(isset($data['new_cuxiao'])){
                   foreach ($data['new_cuxiao'] as $item)
                   {
                       if(intval($item['price']) != $item['price']){
                           return response()->json(['err'=>0,'str'=>'抱歉！当前选择币种不支持金额小数点！']);
                       }
                   }
               }
               //自定义套餐
               if(isset($data['cuxiao_prize'])){
                   foreach ($data['cuxiao_prize'] as $item)
                   {
                       if(intval($item) != $item){
                           return response()->json(['err'=>0,'str'=>'抱歉！当前选择币种不支持金额小数点！']);
                       }
                   }
               }
               if(intval($data['goods_real_price']) != $data['goods_real_price'] || intval($data['goods_price']) != $data['goods_price']){
                   return response()->json(['err'=>0,'str'=>'抱歉！当前选择币种不支持金额小数点！']);
               }
           }
       }


       //倒计时模块
         if($data['count_down_1'] == 1){
             if(!$request->has('goods_end1') || !$request->has('goods_end2') || !$request->has('goods_end3')){
                 return response()->json(['err'=>0,'str'=>'库存或倒计时时间不能为空！']);
             }
             array_push($array,'count_down');
             array_push($array,'goods_stock');
             array_push($array,'remaining_time');
             $goods->goods_end=$data['goods_end1'].':'.$data['goods_end2'].':'.$data['goods_end3'];
         }

         //促销活动模块
         if($data['promotion_1'] == 1){
             if(!$request->has('goods_cuxiao_name') || !$request->has('goods_msg')){
                 return response()->json(['err'=>0,'str'=>'促销活动名称或促销活动描述不能为空！']);
             }
             array_push($array,'description');
             $goods->goods_cuxiao_name=$data['goods_cuxiao_name'];
             $goods->goods_msg=$data['goods_msg'];
         }

         //封面图
         if($data['broadcast_1'] == 1) {
             array_push($array, 'broadcast');
             if (!$request->hasFile('fm_imgs')) {
                 return response()->json(['err' => 0, 'str' => '封面图不能为空！']);
             }
             if($request->hasFile('goods_fm_video')){
                 $size = filesize($request->file('goods_fm_video'));
                 //这里可根据配置文件的设置，做得更灵活一点
                 if($size > 8*1024*1024){
                     return response()->json(['err' => 0, 'str' => '封面图视频文件不能超过8M！']);
                 }
                 $file=$request->file('goods_fm_video');
                 $name=$file->getClientOriginalName();//得到视频名；
                 $ext=$file->getClientOriginalExtension();//得到视频后缀；
                 $fileName=md5(uniqid($name));
                 $newfilename='fm'."_".$fileName.'.'.$ext;//生成新的的文件名
                 $filedir="upload/fm_video/";
                 $msg=$file->move($filedir,$newfilename);
                 $goods->goods_fm_video=$filedir.$newfilename;
             }
         }

         //是否附带视频
         if($data['is_video'] == 1) {
            array_push($array,'video');
             if($request->hasFile('goods_video')){
                 $size = filesize($request->file('goods_video'));
                 //这里可根据配置文件的设置，做得更灵活一点
                 if($size > 8*1024*1024){
                     return response()->json(['err' => 0, 'str' => '上传视频文件不能超过8M！']);
                 }
                 $file=$request->file('goods_video');
                 $name=$file->getClientOriginalName();//得到图片名；
                 $ext=$file->getClientOriginalExtension();//得到图片后缀；
                 $fileName=md5(uniqid($name));
                 $newfilename='first'."_".$fileName.'.'.$ext;//生成新的的文件名
                 $filedir="upload/fm_video/";
                 $msg=$file->move($filedir,$newfilename);
                 $goods->goods_video=$filedir.$newfilename;
             }else{
                 return response()->json(['err' => 0, 'str' => '附带视频不能为空！']);
             }
         }

        //中部导航模块
        if($data['center_nav_1'] == 1) {
            array_push($array,'center_nav');
            $array = array_merge($array,$data['center_nav']);
            // 商品评论数根据是否显示商品来展示数量
            if(in_array('evaluate',$data['center_nav'])){
                $goods->goods_comment_num=$data['goods_comment_num'] ? $data['goods_comment_num'] : 0 ;
            }
        }


         $goods->goods_name=$data['goods_name'];
         $goods->goods_currency_id=$data['currency_type'];
         $goods->goods_real_name=$data['goods_real_name'];
         $goods->goods_real_price=$data['goods_real_price'];
         $goods->goods_price=$data['goods_price'];
         $goods->goods_pix=$data['goods_pix'];
         $goods->goods_num=$data['goods_num'];
         $goods->goods_yahoo_pix=$data['goods_yahoo_pix'];
         $goods->goods_google_pix=$data['goods_google_pix'];
         $goods->goods_admin_id=$data['admin_id'];
         $goods->goods_buy_url=$request->has('goods_buy_url')?$data['goods_buy_url']:null;
         $goods->goods_buy_msg=$request->has('goods_buy_msg')?$data['goods_buy_msg']:null;
         $goods->goods_up_time=date('Y-m-d h:i:s',time());
         $goods->goods_blade_type=$data['goods_blade_type'];
         $goods->goods_type=isset($data['goods_type'])?$data['goods_type']:null;
         $goods->goods_type_html=isset($data['editor2'])?$data['editor2']:"";
         if(!isset($data['goods_kind'])||$data['goods_kind']==null||$data['goods_kind']==''){
             return response()->json(['err' => 0, 'str' => '产品信息错误！']);
         }
         $goods->goods_kind_id=$data['goods_kind'];//单品所属产品id
       //商品描述
         if(isset($data['editor1'])){
             $goods->goods_des_html=$data['editor1'];
         }else{
             return response()->json(['err' => 0, 'str' => '富文本商品描述不能为空！']);
         }

        $msg2=$goods->save();
        $goods_id=$goods->goods_id;

       //1.价格模块（免运费、七天鉴赏期、货到付款）是否显示
       if($data['price_1'] == 1){
           array_push($array,'price');
           if(isset($data['price'])){
               $array = array_merge($array, $data['price']);
           }
       }

       //2.评价模块
       if($data['commit_1'] == 1){
           array_push($array,'commit');
       }

       //3.用户帮助模块
       if($data['uesr_help_1'] == 1) {
           array_push($array,'user_help');
           $array = array_merge($array,$data['user_help']);
       }

       //4.物流公司
       if($data['express_1'] == 1) {
           array_push($array,'express');
       }

       //5.轮播图模块
       if($data['broadcast_1'] == 1) {
           foreach($request->file('fm_imgs') as $pic) {
               $size = filesize($pic);
               //这里可根据配置文件的设置，做得更灵活一点
               if($size > 8*1024*1024){
                   return response()->json(['err' => 0, 'str' => '上传封面图文件不能超过8M！']);
               }
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
       }

       //6.底部导航模块
       if($data['order_nav_1'] == 1) {
           array_push($array,'order_nav');
           $array = array_merge($array,$data['order_nav']);
       }

       if(!empty($array)){
           $datas = \App\templet_show::whereIn('templet_english_name',$array)->select(DB::raw('templet_show_id AS templet_id'))->get()->toArray();
           foreach ($datas as &$val)
           {
               $val['goods_id'] = $goods_id;
           }
           $bool = \App\goods_templet::insert($datas);
           if(!$bool){
               return response()->json(['err'=>0,'str'=>'添加失败！']);
           }
       }

         $sdk=new cuxiaoSDK($goods);
         $msg1=$sdk->saveadd($request,$goods_id);
         $goods->goods_cuxiao_type=$data['goods_cuxiao_type'];
         //触发核审机制
         if(\App\goods_check::first()['goods_is_check']=='0'){//判断是否开启核审机制
            if(Auth::user()->is_root!='1'){
                  $goods->goods_heshen='0';
                  $goods->goods_check_time=date('Y-m-d H:i:s',time());
                  $goods->goods_check_num=0;
           }else{
                $goods->goods_heshen='1';
                $goods->goods_check_time=date('Y-m-d H:i:s',time());
                $goods->goods_check_num=0;
            }
         }else{
                  $goods->goods_heshen='1';
                  $goods->goods_check_time=date('Y-m-d H:i:s',time());
                  $goods->goods_check_num=0;
         }
         $goods->save();

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

    /** 修改商品页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
   public function chgoods(Request $request){
    //修改单品模板
   	 	$id=$request->input('id');
   	 	$goods=goods::where('goods_id',$id)->first();
   	 	$goods['admin_name']=\App\admin::where('admin_id',$goods['goods_admin_id'])->first()->admin_name;
        $goods['goods_pay_type'] = explode(',',$goods['goods_pay_type']);
         $type=\App\goods_type::get();
     
        $goods_config=\App\goods_config::where('goods_primary_id',$id)->get();
        if($goods_config!=null){
          foreach($goods_config as $k => $v){
            $arr=\App\config_val::where('config_type_id',$v->goods_config_id)->orderBy('config_val_id','asc')->get()->toArray();
            $goods_config[$k]->config_msg=$arr;
          }
        }

        //返回前台用户权限显示
        $goods_templet = \App\goods_templet::where('goods_id',$id)->pluck('templet_id')->toArray();
        if(!empty($goods_templet)){
            $goods_templet = \App\templet_show::whereIn('templet_show_id',$goods_templet)->pluck('templet_english_name')->toArray();
        }

       $currency_type = \App\currency_type::all();

       return view('admin.goods.update')->with(compact('goods','type','goods_config','goods_templet','currency_type'));
   }

    /** 修改商品
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
   public function post_update(Request $request){
       $data=$request->all();

       //字段验证（属性值，属性名，属性照片）
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
                        $array_true = [];
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
                        if(in_array(true,$array_true) && in_array(false,$array_true)){
                            return response()->json(['err'=>0,'str'=>'扩展属性图片上传不完整！']);
                        }
                    }
                }
            }
        }else{
            if(!empty($data['goods_config_name'])){
                foreach ($data['goods_config_name'] as $item)
                {
                    if(!trim($item['goods_config_name'])){
                        array_push($array_goods_config,false);
                    }
                    if(!empty($item['msg'])){
                        $array_true = [];
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
                        if(in_array(true,$array_true) && in_array(false,$array_true)){
                            return response()->json(['err'=>0,'str'=>'扩展属性图片上传不完整！']);
                        }
                    }
                }
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

        $array = [];
        //在线支付
        $pay_type = isset($data['pay_type']) ? $data['pay_type'] : ['0'];
        $goods->goods_pay_type= implode(',',$pay_type);
        if(in_array('1',$pay_type)){
            //paypal不支持的币种
            $currency_type = \App\currency_type::where('currency_type_id',$data['currency_type'])->value('currency_english_name');
            if(!in_array($currency_type, \App\currency_type::$CURRENCY_TYPE)){
                return response()->json(['err'=>0,'str'=>'抱歉！当前选择币种不支持paypal支付！']);
            }
            //判断币种金额是否存在限制
            if($currency_type == 'THD' || $currency_type == 'JPY'){
                //满减优惠
                if(isset($data['new_cuxiao'])){
                    foreach ($data['new_cuxiao'] as $item)
                    {
                        if(intval($item['price']) != $item['price']){
                            return response()->json(['err'=>0,'str'=>'抱歉！当前选择币种不支持金额小数点！']);
                        }
                    }
                }
                //自定义套餐
                if(isset($data['cuxiao_prize'])){
                    foreach ($data['cuxiao_prize'] as $item)
                    {
                        if(intval($item) != $item){
                            return response()->json(['err'=>0,'str'=>'抱歉！当前选择币种不支持金额小数点！']);
                        }
                    }
                }
                //原价、商品定价
                if(intval($data['goods_real_price']) != $data['goods_real_price'] || intval($data['goods_price']) != $data['goods_price']){
                    return response()->json(['err'=>0,'str'=>'抱歉！当前选择币种不支持金额小数点！']);
                }
            }
        }


       //倒计时模块
       if($data['count_down_1'] == 1){
           if(!$request->has('goods_end1') || !$request->has('goods_end2') || !$request->has('goods_end3')){
               return response()->json(['err'=>0,'str'=>'库存或倒计时时间不能为空！']);
           }
           array_push($array,'count_down');
           array_push($array,'goods_stock');
           array_push($array,'remaining_time');
           $goods->goods_end=$data['goods_end1'].':'.$data['goods_end2'].':'.$data['goods_end3'];
       }else{
           $goods->goods_num=0;
           $goods->goods_end='0:0:0';
       }

       //促销活动模块
       if($data['promotion_1'] == 1){
           if(!$request->has('goods_cuxiao_name') || !$request->has('goods_msg')){
               return response()->json(['err'=>0,'str'=>'促销活动名称或促销活动描述不能为空！']);
           }
           array_push($array,'description');
           $goods->goods_cuxiao_name=$data['goods_cuxiao_name'];
           $goods->goods_msg=$data['goods_msg'];
       }else{
           $goods->goods_cuxiao_name='';
           $goods->goods_msg='';
       }

       //封面图
       $old_img=\App\img::where('img_goods_id',$data['goods_id'])->get();
       if($data['broadcast_1'] == 1) {
           array_push($array, 'broadcast');
          
           //插入新的封面视频
           if($request->hasFile('goods_fm_video')){
                //删除原有封面视频
               $old_fm_video=$goods->goods_fm_video;
               if($old_fm_video!=null&&$old_fm_video!=''){
                @unlink($old_fm_video);
               }
                 $size = filesize($request->file('goods_fm_video'));
                 //这里可根据配置文件的设置，做得更灵活一点
                 if($size > 8*1024*1024){
                     return response()->json(['err' => 0, 'str' => '封面图视频文件不能超过8M！']);
                 }
                 $file=$request->file('goods_fm_video');
                 $name=$file->getClientOriginalName();//得到视频名；
                 $ext=$file->getClientOriginalExtension();//得到视频后缀；
                 $fileName=md5(uniqid($name));
                 $newfilename='fm'."_".$fileName.'.'.$ext;//生成新的的文件名
                 $filedir="upload/fm_video/";
                 $msg=$file->move($filedir,$newfilename);
                 $goods->goods_fm_video=$filedir.$newfilename;
             }
          //删除封面视频
          if($request->has('cl_fmvideo')&&$request->input('cl_fmvideo')=='1'&&!$request->hasFile('goods_fm_video')){
            $old_fm_video=$goods->goods_fm_video;
               if($old_fm_video!=null&&$old_fm_video!=''){
                @unlink($old_fm_video);
               }
               $goods->goods_fm_video=null;
          }
           if($request->hasFile('fm_imgs')) {
               foreach($old_img as $val){
                   @unlink($val->img_url);
               }
               $old_img=\App\img::where('img_goods_id',$data['goods_id'])->delete();
               foreach ($request->file('fm_imgs') as $pic) {
                   $size = filesize($pic);
                   //这里可根据配置文件的设置，做得更灵活一点
                   if($size > 8*1024*1024){
                       return response()->json(['err' => 0, 'str' => '上传封面图文件不能超过8M！']);
                   }
                   $name = $pic->getClientOriginalName();//得到图片名；
                   $ext = $pic->getClientOriginalExtension();//得到图片后缀；
                   $fileName = md5(uniqid($name));
                   $newImagesName = 'first' . "_" . $fileName . '.' . $ext;//生成新的的文件名
                   $filedir = "upload/fm_imgs/";
                   $msg = $pic->move($filedir, $newImagesName);
                   $nimg = new \App\img;
                   $nimg->img_url = $filedir . $newImagesName;
                   $nimg->img_goods_id = $data['goods_id'];
                   $nimg->save();
               }
           }
       }else{
           foreach($old_img as $val){
               @unlink($val->img_url);
           }
           $old_img=\App\img::where('img_goods_id',$data['goods_id'])->delete();
       }

       //是否附带视频
       if($data['is_video'] == 1) {
           array_push($array,'video');
           if($request->hasFile('goods_video')){
               $size = filesize($request->file('goods_video'));
               //这里可根据配置文件的设置，做得更灵活一点
               if($size > 8*1024*1024){
                   return response()->json(['err' => 0, 'str' => '上传视频文件不能超过8M！']);
               }
               if($goods->goods_video){
                   @unlink($goods->goods_video);
               }
               $file=$request->file('goods_video');
               $name=$file->getClientOriginalName();//得到图片名；
               $ext=$file->getClientOriginalExtension();//得到图片后缀；
               $fileName=md5(uniqid($name));
               $newfilename=$request->input('goods_id')."_".$fileName.'.'.$ext;//生成新的的文件名
               $filedir="upload/fm_video/";
               $msg=$file->move($filedir,$newfilename);
               $goods->goods_video=$filedir.$newfilename;
           }
       }else{
           if($goods->goods_video){
               @unlink($goods->goods_video);
           }
           $goods->goods_video='';
       }

       //中部导航模块
       if($data['center_nav_1'] == 1) {
           array_push($array,'center_nav');
           $array = array_merge($array,$data['center_nav']);
           // 商品评论数根据是否显示商品来展示数量
           if(in_array('evaluate',$data['center_nav'])){
               $goods->goods_comment_num=$data['goods_comment_num'] ? $data['goods_comment_num'] : 0 ;
           }else{
               $goods->goods_comment_num=0;
           }
       }else {
           $goods->goods_comment_num = 0;
       }

       //判断是否触发核审机制
       if (\App\goods_check::first()['goods_is_check'] == 0&&Auth::user()->is_root=='0') {
           $recheck = $request->has('recheck') ? $request->input('recheck') : 0;
           if ($request->input('recheck') != 1) {//核审人员修改单品不做记录
               //判断是否触发修改次数上限
               $maxcheck = \App\goods_check::first()['goods_check_max'];
               if ($goods->goods_check_num >= $maxcheck) {
                   $old_time = $goods->goods_check_time;
                   $o_date = strtotime($old_time);
                   $o_date = date('Y-m-d', $o_date);
                   $n_date = date('Y-m-d');
                   if ($o_date == $n_date) {
                       return response()->json(['err' => 0, 'str' => '该单品今日已达到最高核审次数上限，无法再次修改！请联系管理员处理！']);
                   } else {
                       $goods->goods_check_time = date('Y-m-d H:i:s', time());
                       $goods->goods_check_num = 1;
                   }
               }
               $goods->goods_heshen = '0';
               $old_time = $goods->goods_check_time;
               if ($old_time == null) {
                   $goods->goods_check_time = date('Y-m-d H:i:s', time());
                   $goods->goods_check_num = 1;
               } elseif ($old_time != null) {
                   //判断上次核审时间是否为今天
                   $o_date = strtotime($old_time);
                   $o_date = date('Y-m-d', $o_date);
                   $n_date = date('Y-m-d');
                   if ($o_date == $n_date) {
                       $goods->goods_check_time = date('Y-m-d H:i:s', time());
                       $goods->goods_check_num += 1;
                   } else {
                       $goods->goods_check_time = date('Y-m-d H:i:s', time());
                       $goods->goods_check_num = 1;
                   }
               }
           }
       }else{
              $goods->goods_heshen='1';
              $goods->goods_check_time=date('Y-m-d H:i:s',time());
              $goods->goods_check_num=0;
       }

       $goods->goods_name = $data['goods_name'];
       $goods->goods_num=$data['goods_num'];
       $goods->goods_currency_id=$data['currency_type'];
       $goods->goods_real_name = $data['goods_real_name'];
       $goods->goods_real_price = $data['goods_real_price'];
       $goods->goods_price = $data['goods_price'];
       $goods->goods_blade_type = $data['goods_blade_type'];
       $goods->goods_buy_url = $request->has('goods_buy_url') ? $data['goods_buy_url'] : null;
       $goods->goods_buy_msg = $request->has('goods_buy_msg') ? $data['goods_buy_msg'] : null;
       $goods->goods_pix = $data['goods_pix'];
       $goods->goods_yahoo_pix = $data['goods_yahoo_pix'];
       $goods->goods_google_pix = $data['goods_google_pix'];
       $goods->goods_type = $data['goods_type'];
//           $goods->goods_pay_type=implode(',',$request->input('pay_type'));
//           $goods->goods_up_time = date('Y-m-d h:i:s', time());
       $goods->goods_type_html = isset($data['editor2']) ? $data['editor2'] : "";
       //商品描述
       if (isset($data['editor1'])) {
           $goods->goods_des_html = $data['editor1'];
       } else {
           return response()->json(['err' => 0, 'str' => '富文本商品描述不能为空！']);
       }
       $sdk = new cuxiaoSDK($goods);
       $msg1 = $sdk->saveupdate($request);
       $goods->goods_cuxiao_type = $data['goods_cuxiao_type'];
       $msg2 = $goods->save();

       //1.价格模块（免运费、七天鉴赏期、货到付款）是否显示
       if ($data['price_1'] == 1) {
           array_push($array, 'price');
           if(isset($data['price'])){
               $array = array_merge($array, $data['price']);
           }
       }

       //2.评价模块
       if($data['commit_1'] == 1){
           array_push($array,'commit');
       }

       //3.用户帮助模块
       if ($data['user_help_1'] == 1) {
           array_push($array, 'user_help');
           $array = array_merge($array, $data['user_help']);
       }

       //4.物流公司
       if ($data['express_1'] == 1) {
           array_push($array, 'express');
       }

       //5.底部导航模块
       if ($data['order_nav_1'] == 1) {
           array_push($array, 'order_nav');
           $array = array_merge($array, $data['order_nav']);
       }

       //删除之前的页面显示
       \App\goods_templet::where('goods_id', $data['goods_id'])->delete();

       //插入显示数据
       if (!empty($array)) {
           $datas = \App\templet_show::whereIn('templet_english_name', $array)->select(DB::raw('templet_show_id AS templet_id'))->get()->toArray();
           foreach ($datas as &$val) {
               $val['goods_id'] = $data['goods_id'];
           }
           $bool = \App\goods_templet::insert($datas);
           if (!$bool) {
               return response()->json(['err' => 0, 'str' => '修改失败！']);
           }
       }

       //新增或修改商品属性名和属性值
       $goods_attr = $data['goods_config_name'];
       if (!empty($goods_attr)) {
           foreach ($goods_attr as $item) {
               if (isset($item['id'])) {
                   $goods_config = \App\goods_config::where('goods_config_id', $item['id'])->first();
               } else {
                   $goods_config = new \App\goods_config();
               }
               $goods_config->goods_config_msg = $item['goods_config_name'];
               $goods_config->goods_config_type = 0;
               $goods_config->goods_primary_id = $data['goods_id'];
               $goods_config->is_img = 0;
               $goods_config->save();
               $con_val = \App\config_val::createOrSave($item['msg'], $goods_config->goods_config_id, $data['goods_id']);
               if ($con_val === false) {
                   return response()->json(['err' => 0, 'str' => '保存失败！']);
               }
           }
       }
       if ($msg1 && $msg2) {
           if (\App\goods_check::first()['goods_is_check'] == 0) {
               return response()->json(['err' => 1, 'str' => '保存成功！请留意核审状态！']);
           } else {
               return response()->json(['err' => 1, 'str' => '保存成功！']);
           }
       } else {
           return response()->json(['err' => 0, 'str' => '保存失败！']);
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
        $goods = goods::where('goods_id',$id)->first();
        $goods->goods_pay_type = explode(',',$goods->goods_pay_type);
        $currency_type = \App\currency_type::all();
        return view('admin.goods.onlyname')->with(compact('goods','currency_type'));
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
            return response()->json(['err'=>0,'str'=>'单品名已被使用，请重新命名！']);
        }
        $goods = \App\goods::where('goods_id',$id)->first();

        //复制商品是否存在
        if(!$goods){
            return response()->json(['err'=>0,'str'=>'请选择复制商品！']);
        }

        //审核状态为0 或者 2的商品不可复制
        if($goods->goods_heshen == 0 || $goods->goods_heshen == 2){
            return response()->json(['err'=>0,'str'=>'抱歉；当前商品核审状态不能复制！']);
        }

        $goods = $goods->toArray();
        unset($goods['goods_id']);
        $goods['bd_type'] = 0;
        $currency_type = $request->input('currency_type');
        $goods['goods_currency_id'] = $currency_type;//商品币种

        //在线支付不支持币种问题
        $pay_type = $request->input('pay_type') ? $request->input('pay_type') : ['0'];
        $goods['goods_pay_type']= implode(',',$pay_type);
        if(in_array('1',$pay_type)){
            //paypal不支持的币种
            $currency_type = \App\currency_type::where('currency_type_id',$currency_type)->value('currency_english_name');
            if(!in_array($currency_type, \App\currency_type::$CURRENCY_TYPE)){
                return response()->json(['err'=>0,'str'=>'抱歉！当前选择币种不支持paypal支付！']);
            }
        }

        $goods['goods_real_name'] = $request->input('goods_name');  //单品名称
        $goods['goods_admin_id'] = Auth::user()->admin_id;     //复制人
        $goods['goods_up_time'] = date('Y-m-d H:i:s',time());  // 操作时间
        if(\App\goods_check::first()['goods_is_check']=='0'){//判断是否开启核审机制
            if(Auth::user()->is_root!='1'){
                $goods['goods_heshen']='0';
                $goods['goods_check_time']=date('Y-m-d H:i:s',time());
                $goods['goods_check_num']=1;
            }else{
                $goods['goods_heshen']='1';
                $goods['goods_check_time']=date('Y-m-d H:i:s',time());
                $goods['goods_check_num']=0;
            }
        }

        //处理视频操作
        if($goods['goods_video']){
            $image = substr($goods['goods_video'],6);
            $ext = strrchr($goods['goods_video'], '.');
            $newImages = '/fm_video/fz_first_video'.md5(microtime()).rand(100000,1000000).$ext;
            if(Storage::disk('public')->exists($image)){
                Storage::disk('public')->copy($image, $newImages);
                $goods['goods_video'] = 'upload'.$newImages;
            }else{
                $goods['goods_video'] = '';
            }
        }
        //处理封面视频操作
        if($goods['goods_fm_video']){
            $image = substr($goods['goods_fm_video'],6);
            $ext = strrchr($goods['goods_fm_video'], '.');
            $newImages = '/fm_video/fz_fm_video'.md5(microtime()).rand(100000,1000000).$ext;
            if(Storage::disk('public')->exists($image)){
                Storage::disk('public')->copy($image, $newImages);
                $goods['goods_fm_video'] = 'upload'.$newImages;
            }else{
                $goods['goods_fm_video'] = '';

            }
        }

        //复制新商品
        $goods_id = \App\goods::insertGetId($goods);
        if(!$goods_id){
            return response()->json(['err' => '0', 'msg' => '复制失败!']);
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
                    return response()->json(['err' => '0', 'msg' => '复制失败!']);
                };
            }
        }

        //处理商品属性名 + 属性值
        $goods_config = \App\goods_config::where('goods_primary_id', $id)->orderBy('goods_config_id','asc')->get();
        if (!$goods_config->isEmpty()) {
            $goods_config = $goods_config->toArray();
            foreach ($goods_config as $item) {
                $config_type_id = $item['goods_config_id'];
                unset($item['goods_config_id']);
                $item['goods_primary_id'] = $goods_id;
                //复制新商品属性名
                $goods_config_id = \App\goods_config::insertGetId($item);
                if(!$goods_config_id){
                    return response()->json(['err' => '0', 'msg' => '复制失败!']);
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
                            return response()->json(['err' => '0', 'msg' => '复制失败!']);
                        }
                    }
                }
            }
        }

        //处理商品获得促销
        $cuxiao = \App\cuxiao::where('cuxiao_goods_id', $id)->orderBy('cuxiao_id','asc')->get();
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
                                 return response()->json(['err' => '0', 'msg' => '复制失败!']);
                             }
                             $item['cuxiao_special_id'] = $new_special_id;
                             $cuxiao_id = \App\cuxiao::insertGetId($item);
                             if(!$cuxiao_id){
                                 return response()->json(['err' => '0', 'msg' => '复制失败!']);
                             }
                         }
                    }else{
                        $cuxiao_id = \App\cuxiao::insertGetId($item);
                        if(!$cuxiao_id){
                            return response()->json(['err' => '0', 'msg' => '复制失败!']);
                        }
                    }

                }
            }
        }

        //处理模块显示信息
        $templet = \App\goods_templet::where('goods_id',$id)->select('templet_id')->get();
        if(!$templet->isEmpty()){
            $templet = $templet->toArray();
            foreach ($templet as &$item)
            {
                $item['goods_id'] = $goods_id;
            }
            $bool = \App\goods_templet::insert($templet);
            if(!$bool){
                return response()->json(['err' => '0', 'msg' => '复制失败!']);
            }
        }

        //处理商品评价模块
        $comment=comment::where('com_goods_id',$id)->where('com_isuser','0')->get();
        if(!$comment->isEmpty()){
            $comment = $comment->toArray();
            foreach ($comment as $item)
            {
                $com_img = com_img::where('com_primary_id',$item['com_id'])->get();
                unset($item['com_id']);
                $item['com_goods_id'] = $goods_id;
                $comment_id = comment::insertGetId($item);
                if(!$com_img->isEmpty()){
                    $com_img = $com_img->toArray();
                    foreach ($com_img as $val)
                    {
                        unset($val['com_img_id']);
                        //处理图片（图片不可以和原来属性使用一张，防止一个商品改动，其它商品也随之改动）
                        if($val['com_url']){
                            $image = substr($val['com_url'],7);
                            $ext = strrchr($val['com_url'], '.');
                            $newImages = '/commment_img/fzcommment_img_'.md5(microtime()).rand(10000,100000).$ext;
                            if(Storage::disk('public')->exists($image)){
                                Storage::disk('public')->copy($image, $newImages);
                                $val['com_url'] = '/upload'.$newImages;
                            }else{
                                $val['com_url'] = '';
                            }
                        }
                        $val['com_primary_id'] = $comment_id;
                        //复制新商品属性值
                        $bool = \App\com_img::insert($val);
                        if(!$bool){
                            return response()->json(['err' => '0', 'msg' => '复制失败!']);
                        }
                    }
                }
            }
            if(!$bool){
                return response()->json(['err' => '0', 'msg' => '复制失败!']);
            }
        }


        return response()->json(['err'=>1,'str'=>'复制成功！']);
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
    public function addgoods_type(Request $request)
    {
      if($request->isMethod('get')){
          $goods_type=\App\goods_type::get();
        foreach($goods_type as $k => $v){
          $goods_type[$k]->goods_num=\App\goods::where([['goods_type',$v->goods_type_id],['is_del','0']])->count();
        }
        return view('admin.goods.addgoods_type')->with(compact('goods_type'));
      }elseif($request->isMethod('post')){
        $goods_new_type=new \App\goods_type;
        $goods_new_type->goods_type_name=$request->input('goods_type_name');
        $isuse=\App\goods_type::where('goods_type_name',$request->input('goods_type_name'))->first();
        if($isuse!=null){
           return response()->json(['err' => '0', 'msg' => '添加失败!此类名已存在！']);
        }
        $msg=$goods_new_type->save();
        if($msg){
            return response()->json(['err' => '1', 'msg' => '添加成功!']);
        }else{
           return response()->json(['err' => '0', 'msg' => '添加失败!']);
        }
      }
    }
    public function goods_kind(Request $request)
    {
      if($request->isMethod('get')){
        $goods_kinds=\App\goods_kind::get();
        foreach($goods_kinds as $k => $v){
          $goods_kinds[$k]->goods_kind_name=$v->goods_kind_name.'('.\App\goods::where('goods_kind_id',$v->goods_kind_id)->count().')';
        }
        return view('admin.goods.goods_kind')->with(compact('goods_kinds'));
      }elseif($request->isMethod('post')){
        
      }
    }
    public function goods_kind_s(Request $request)
    {
      //获取所有产品名接口
      if($request->has('name')){
         $name=$request->input('name');
         if($name==null||$name==''){
          $goods_kinds=\App\goods_kind::get()->toArray();
         }else{
          $goods_kinds=\App\goods_kind::where('goods_kind_name','like',"%$name%")->get()->toArray();
         } 
          return response()->json($goods_kinds);
      }else{
        return response()->json(['error']); 
      }  
    }
    public function addgoods_kind(Request $request)
    {//新增产品
      if($request->isMethod('get')){
        $goods_kinds=\App\goods_kind::get();
        foreach($goods_kinds as $k => $v){
          $goods_kinds[$k]->goods_kind_name=$v->goods_kind_name.'('.goods::where('goods_kind_id',$v->goods_kind_id)->count().')';
        }
        return view('admin.goods.addgoods_kind')->with(compact('goods_kinds'));
      }elseif($request->isMethod('post')){
        if(!$request->has('goods_kind_name')||$request->input('goods_kind_name')==''||$request->input('goods_kind_name')==null){
           return response()->json(['err' => '0', 'msg' => '信息错误!']);
        }
        $goods_kind_name=$request->input('goods_kind_name');
        $goods_kind=new \App\goods_kind;
        $goods_kind->goods_kind_name=$request->input('goods_kind_name');
        $goods_kind->goods_kind_time=date("Y-m-d H:i:s",time());
        $msg=$goods_kind->save();
        if($msg){
            return response()->json(['err' => '1', 'msg' => '添加成功!']);
        }else{
           return response()->json(['err' => '0', 'msg' => '添加失败!']);
        }
      }
    }
    public function goods_real_name(Request $request)
    {//单品名验证接口
      if(!$request->has('name')||$request->input('name')==''||$request->input('name')==null)
      {
          return response()->json(false);
      }
      if(goods::where('goods_real_name',$request->input('name'))->first()!=null)
      {
          return response()->json(false);        
      }else{
          return response()->json(true);        
      }
    }
}
  