<?php

namespace App\Http\Controllers\admin;

use App\admin;
use App\channel\excelData;
use App\config_val;
use App\currency_type;
use App\goods;
use App\goods_config;
use App\kind_val;
use App\order_config;
use App\price;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\order;
use DB;
use App\Jobs\SendHerbEmail;
use Illuminate\Support\Facades\Auth;
use Excel;

class OrderController extends Controller
{
   public function index(){
//         $admin_id=Auth::user()->admin_id;
//     if(Auth::user()->is_root!='1'){
//      $admins=\App\admin::get_group($admin_id);
//      $garr=order::get_group_order($admin_id);
//      $counts=DB::table('order')
//      ->where(function($query){
//        $query->where('is_del','0');
//      })
//      ->whereIn('order_goods_id',$garr)
//      ->count();
//     return view('admin.order.index_notroot')->with(compact('counts','admins'));
//     }else{
//      $admins=\App\admin::get();
//      $counts=order::where(function($query){
//        $query->where('is_del','0');
//      })->count();
     $admins = admin::whereIn('admin_id',admin::get_admins_id())->get();
     $counts = DB::table('order')
     ->where(function($query){
        $query->where('is_del','0');
     })
     ->whereIn('order_goods_id',admin::get_goods_id())
     ->count();
     $languages = admin::$LANGUAGES;
     if(\Auth::user()->admin_is_order!='1'){
      return view('admin.order.index_notroot')->with(compact('counts','admins','languages'));
     }else{
      return view('admin.order.index')->with(compact('counts','admins','languages'));
     }
//     }

   }

   /** 修改订单
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
   public function edit(Request $request) {
       $order = order::where('order_id', $request->input('id'))->where('is_del','0')->first();
       $goods = goods::find($order->order_goods_id);
       $goods_attrs = goods_config::where('goods_primary_id', $order->order_goods_id)->get();

       if ($goods_attrs) {
           foreach ($goods_attrs as $k=>$v) {
               if ($goods->goods_is_update) {
                   $vals = config_val::where('config_type_id', $v->goods_config_id)->where('config_isshow', 0)->where('kind_val_id','>',0)->get();
               } else {
                   $vals = config_val::where('config_type_id', $v->goods_config_id)->where('config_isshow', 0)->where('kind_val_id','<',0)->get();
               }

            if (count($vals) > 0) {
                $v->vals = $vals;
            }else {
                $goods_attrs->pull($k);
            }
           }
           $goods->attrs = $goods_attrs;
       }
       $order->order_currency = currency_type::where('currency_type_id', $order->order_currency_id)->value('currency_type_name');
       $order->order_config=\App\order_config::where('order_primary_id',$order->order_id)->pluck('order_config','order_config_id');
       if($order->order_price_id){
           $order->special = price::where('price_id',$order->order_price_id)->value('price_name');
       }

       return view('admin.order.edit')->with(compact('order','goods'));

   }

   private function get_attr_price($goods_id,$attrs){
        if (! $attrs) {
            return false;
        }
        $price = 0;
        foreach ($attrs as $attr) {
            if (is_array($attr)) {
                $goods_attrs = $attr;
            } else {
                $goods_attrs = explode(',', $attr);
            }
            $price += config_val::whereIn('config_val_id', $goods_attrs)->where('config_goods_id', $goods_id)->sum('config_diff_price');
        }
        return $price;
   }

   public function update(Request $request){
       if(! $request->input('order_id')) {
           return response()->json(['err' => 0, 'str' => '订单ID不合法！']);
       }
       $order = order::find($request->input('order_id'));
       if (! $order || !in_array($order->order_type ,[0,1,9,11,13,14])) {
           return response()->json(['err' => 0, 'str' => '订单不存在或订单状态不为未审核状态不允许修改！']);
       }
       $order_configs = order_config::where('order_primary_id',$order->order_id)->pluck('order_config','order_config_id')->toArray();
       $old_goods_attr_prices = $this->get_attr_price($order->order_goods_id, $order_configs);
       $now_goods_attr_prices = $this->get_attr_price($order->order_goods_id, $request->input('config_val_id'));
       if ($old_goods_attr_prices !== $now_goods_attr_prices) {
           return response()->json(['err' => 0, 'str' => '订单属性价格存在差值，不允许修改！', 'data' => ['old' => $old_goods_attr_prices,'new' => $now_goods_attr_prices]]);
       }

       $order->order_name = $request->input('order_name');
       $order->order_tel = $request->input('order_tel');
       $order->order_state = $request->input('order_state');
       $order->order_city = $request->input('order_city');
       $order->order_add = $request->input('order_add');
       $order->order_village = $request->input('order_village');
       $order->order_email = $request->input('order_email');
       $order->order_remark = $request->input('order_remark');
       $order->order_time = $request->input('order_time');
        $order_Array = [];
       //设置订单是否出现姓名，ip，手机号码重复(更改日期2018-09-18)=========================================================
       //ip
       $goods_ip = order::where('order_ip',$order->order_ip)->get();
       if(!$goods_ip->isEmpty() && count($goods_ip) <> 1){
           array_push($order_Array,'1');
           foreach ($goods_ip as $item)
           {
               if($item->order_repeat_field){
                   $pos = strpos($item->order_repeat_field, ',');
                   $order_repeat_field  = substr($item->order_repeat_field,$pos-1);
                   $order_repeat = explode(',',$order_repeat_field);
                   if(!in_array('1',$order_repeat)){
                       array_push($order_repeat,'1');
                       sort($order_repeat);
                       $order_repeat_array = implode($order_repeat);
                       $item->order_repeat_field = trim($order_repeat_array);
                       $item->save();
                   }
               }else{
                   $item->order_repeat_field = '1';
                   $item->save();
               }
           }
       }

       //姓名
       $orders_name = \App\order::where('order_name',$request->input('order_name'))->get();
       if(!$orders_name->isEmpty() && count($orders_name) <> 1){
           array_push($order_Array,'2');
           foreach ($orders_name as $item)
           {
               if($item->order_repeat_field){
                   $pos = strpos($item->order_repeat_field, ',');
                   $order_repeat_field  = substr($item->order_repeat_field,$pos-1);
                   $order_repeat = explode(',',$order_repeat_field);
                   if(!in_array('2',$order_repeat)){
                       array_push($order_repeat,'2');
                       sort($order_repeat);
                       $order_repeat_array = implode(',',$order_repeat);
                       $item->order_repeat_field = trim($order_repeat_array);
                       $item->save();
                   }
               }else{
                   $item->order_repeat_field = '2';
                   $item->save();
               }
           }
       }

       //手机号
       $orders_tel = \App\order::where('order_tel',$request->input('order_tel'))->get();
       if(!$orders_tel->isEmpty() && count($orders_tel) <> 1){
           array_push($order_Array,'3');
           foreach ($orders_tel as $item)
           {
               if($item->order_repeat_field){
                   $pos = strpos($item->order_repeat_field, ',');
                   $order_repeat_field  = substr($item->order_repeat_field,$pos-1);
                   $order_repeat = explode(',',$order_repeat_field);
                   if(!in_array('3',$order_repeat)){
                       array_push($order_repeat,'3');
                       sort($order_repeat);
                       $order_repeat_array = implode(',',$order_repeat);
                       $item->order_repeat_field = trim($order_repeat_array);
                       $item->save();
                   }
               }else{
                   $item->order_repeat_field = '3';
                   $item->save();
               }
           }
       }

       if(!empty($order_Array)){
           sort($order_Array);
           $order_Array = implode(',',$order_Array);
           $order->order_repeat_field=$order_Array;
       }
       $order->save();
       if ($request->has('config_val_id')) {
           foreach ($request->input('config_val_id') as $config_key=>$config_values) {
                order_config::where('order_config_id', $config_key)->update(['order_config' => implode(',',$config_values)]);
           }
       }

       return response()->json(['err' => 1, 'str' => '保存成功！']);
   }
    /** 订单列表数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
   public function get_table(Request $request){
      		$info=$request->all();
          if(!isset($info['order'])){
            $arr=['err'=>'缺少order参数'];
            \Log::notice('获取order缺少datatable参数');
          return response()->json($arr);
          }
        	$cm=$info['order'][0]['column'];
	        $dsc=$info['order'][0]['dir'];
	        $order=$info['columns']["$cm"]['data'];
	        $draw=$info['draw'];
	        $start=$info['start'];
	        $len=$info['length'];
	        $search=trim($info['search']['value']);
            //获取账户名
            $goods_search=$request->has('goods_search')?$request->input('goods_search'):0;
            $order_repeat_ip=$request->has('order_repeat_ip')?$request->input('order_repeat_ip'):0;
            $order_repeat_name=$request->has('order_repeat_name')?$request->input('order_repeat_name'):0;
            $order_repeat_tel=$request->has('order_repeat_tel')?$request->input('order_repeat_tel'):0;
	        $counts=DB::table('order')
          ->where(function($query){
            $query->where('is_del','0');
          })
	        ->count();

           if(\Auth::user()->is_root!='1'){ //非root 用户
            $garr = admin::get_order_goods_id();
            $counts=DB::table('order')
            ->whereIn('order_goods_id',$garr)
            ->where(function($query){
              $query->where('is_del','0');
            })
            ->count();

             $newcount=DB::table('order')
            ->select('order.*','goods.goods_real_name','admin.admin_show_name')
            ->leftjoin('goods','order.order_goods_id','=','goods.goods_id')
            ->leftjoin('admin','order.order_admin_id','=','admin.admin_id')
            ->where(function($query)use($search){
                $query->where([['order.order_single_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_ip','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['goods.goods_real_name','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_cuxiao_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_send','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['admin.admin_show_name','like',"%$search%"],['order.is_del','=','0']]);
            })
            ->where(function($query)use($request){
            if($request->input('mintime')!=null&&$request->input('maxtime')==null){
              $query->where('order.order_time','>',$request->input('mintime'));
            }elseif($request->input('maxtime')!=null&&$request->input('mintime')==null){
              $query->where('order.order_time','<',$request->input('maxtime'));
            }elseif($request->input('maxtime')!=null&&$request->input('mintime')!=null){
               $query->whereBetween('order.order_time',[$request->input('mintime'),$request->input('maxtime')]);
            }
           })
          ->where(function($query)use($request){
              $order_type=$request->input('order_type');
              $pay_type=$request->input('pay_type');
              if($order_type!='#'){
                if($order_type==0){
                  $query->whereIn('order.order_type',[0,11]);
                }else{
                  $query->where('order.order_type',$order_type);
                }
              }
              if($pay_type!='#'){
                  $query->where('order.order_pay_type',$pay_type);
              }
              //根据语言搜索
              if($request->has('languages')&&$request->input('languages')!='0'){
                  //按语言查询（根据模板置换语言）
                  $band = goods::get_blade($request->input('languages'));
                  if($band){
                       $query->whereIn('goods.goods_blade_type',$band);
                  }
              }

              //根据地区搜索
              if($request->has('goods_blade_type')&&$request->input('goods_blade_type')!='0'){
                  //按语言查询（根据模板置换语言）
                  $band = goods::get_area_blade($request->input('goods_blade_type'));
                  if($band){
                      $query->whereIn('goods.goods_blade_type',$band);
                  }
              }
            })
            ->where(function($query)use($garr){
              $query->whereIn('order_goods_id',$garr);
            })->where(function ($query)use($order_repeat_ip){
                 if($order_repeat_ip == 1){
                     $query->where('order_repeat_field','1');
                     $query->orWhere('order_repeat_field','1,2');
                     $query->orWhere('order_repeat_field','1,3');
                     $query->orWhere('order_repeat_field','1,2,3');
                 }
            })->where(function ($query)use($order_repeat_name){
                 if($order_repeat_name == 1){
                     $query->where('order_repeat_field','2');
                     $query->orWhere('order_repeat_field','1,2');
                     $query->orWhere('order_repeat_field','2,3');
                     $query->orWhere('order_repeat_field','1,2,3');
                 }
             })->where(function ($query)use($order_repeat_tel){
                 if($order_repeat_tel == 1){
                     $query->where('order_repeat_field','3');
                     $query->orWhere('order_repeat_field','1,3');
                     $query->orWhere('order_repeat_field','2,3');
                     $query->orWhere('order_repeat_field','1,2,3');
                 }
             })
            ->count();

             //列表数据
            $data=DB::table('order')
            ->select('order.*','goods.goods_real_name','admin.admin_show_name')
            ->leftjoin('goods','order.order_goods_id','=','goods.goods_id')
            ->leftjoin('admin','order.order_admin_id','=','admin.admin_id')
            ->where(function($query)use($search){
                $query->where([['order.order_single_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_ip','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['goods.goods_real_name','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_cuxiao_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_send','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['admin.admin_show_name','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_name','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_tel','like',"%$search%"],['order.is_del','=','0']]);
            })
             ->where(function($query)use($request){
            if($request->input('mintime')!=null&&$request->input('maxtime')==null){
              $query->where('order.order_time','>',$request->input('mintime'));
            }elseif($request->input('maxtime')!=null&&$request->input('mintime')==null){
              $query->where('order.order_time','<',$request->input('maxtime'));
            }elseif($request->input('maxtime')!=null&&$request->input('mintime')!=null){
               $query->whereBetween('order.order_time',[$request->input('mintime'),$request->input('maxtime')]);
            }
          })
          ->where(function($query)use($request){
              $order_type=$request->input('order_type');
              $pay_type=$request->input('pay_type');
              if($order_type!='#'){
                if($order_type==0){
                  $query->whereIn('order.order_type',[0,11]);
                }else{
                  $query->where('order.order_type',$order_type);
                }
              }
              if($pay_type!='#'){
                   $query->where('order.order_pay_type',$pay_type);
              }
              //根据语言搜索
              if($request->has('languages')&&$request->input('languages')!='0'){
                  //按语言查询（根据模板置换语言）
                  $band = goods::get_blade($request->input('languages'));
                  if($band){
                      $query->whereIn('goods.goods_blade_type',$band);
                  }
              }

              //根据地区搜索
              if($request->has('goods_blade_type')&&$request->input('goods_blade_type')!='0'){
                  //按语言查询（根据模板置换语言）
                  $band = goods::get_area_blade($request->input('goods_blade_type'));
                  if($band){
                      $query->whereIn('goods.goods_blade_type',$band);
                  }
              }
          })
          ->where(function($query)use($garr){
              $query->whereIn('order_goods_id',$garr);
          })->where(function ($query)use($order_repeat_ip){
                if($order_repeat_ip == 1){
                      $query->where('order_repeat_field','1');
                      $query->orWhere('order_repeat_field','1,2');
                      $query->orWhere('order_repeat_field','1,3');
                      $query->orWhere('order_repeat_field','1,2,3');
                }
          })->where(function ($query)use($order_repeat_name){
                if($order_repeat_name == 1){
                    $query->where('order_repeat_field','2');
                    $query->orWhere('order_repeat_field','1,2');
                    $query->orWhere('order_repeat_field','2,3');
                    $query->orWhere('order_repeat_field','1,2,3');
                }
          })->where(function ($query)use($order_repeat_tel){
              if($order_repeat_tel == 1){
                  $query->where('order_repeat_field','3');
                  $query->orWhere('order_repeat_field','1,3');
                  $query->orWhere('order_repeat_field','2,3');
                  $query->orWhere('order_repeat_field','1,2,3');
              }
          })
          ->orderBy($order,$dsc)
          ->offset($start)
          ->limit($len)
          ->get();


          }else{ //root用户

          $newcount=DB::table('order')
          ->select('order.*','goods.goods_real_name','admin.admin_show_name')
          ->leftjoin('goods','order.order_goods_id','=','goods.goods_id')
          ->leftjoin('admin','order.order_admin_id','=','admin.admin_id')
          ->where(function($query)use($search){
              $query->where([['order.order_single_id','like',"%$search%"],['order.is_del','=','0']]);
              $query->orWhere([['order.order_ip','like',"%$search%"],['order.is_del','=','0']]);
              $query->orWhere([['order.order_id','like',"%$search%"],['order.is_del','=','0']]);
              $query->orWhere([['goods.goods_real_name','like',"%$search%"],['order.is_del','=','0']]);
              $query->orWhere([['order.order_cuxiao_id','like',"%$search%"],['order.is_del','=','0']]);
              $query->orWhere([['order.order_send','like',"%$search%"],['order.is_del','=','0']]);
              $query->orWhere([['admin.admin_show_name','like',"%$search%"],['order.is_del','=','0']]);
              $query->orWhere([['order.order_name','like',"%$search%"],['order.is_del','=','0']]);
              $query->orWhere([['order.order_tel','like',"%$search%"],['order.is_del','=','0']]);
          })
          ->where(function($query)use($goods_search){
              if($goods_search!=0){
                   $garr=\App\goods::get_only_slef_id($goods_search);
                   $query->whereIn('order_goods_id',$garr);
                }
          })->where(function ($query)use($order_repeat_ip){
              if($order_repeat_ip == 1){
                    $query->where('order.order_repeat_field','1');
                    $query->orWhere('order.order_repeat_field','1,2');
                    $query->orWhere('order.order_repeat_field','1,3');
                    $query->orWhere('order.order_repeat_field','1,2,3');
              }
          })->where(function ($query)use($order_repeat_name){
              if($order_repeat_name == 1){
                    $query->where('order.order_repeat_field','2');
                    $query->orWhere('order.order_repeat_field','1,2');
                    $query->orWhere('order.order_repeat_field','2,3');
                    $query->orWhere('order.order_repeat_field','1,2,3');
              }
          })->where(function ($query)use($order_repeat_tel){
              if($order_repeat_tel == 1){
                   $query->where('order.order_repeat_field','3');
                   $query->orWhere('order.order_repeat_field','1,3');
                   $query->orWhere('order.order_repeat_field','2,3');
                   $query->orWhere('order.order_repeat_field','1,2,3');
              }
          })
          ->where(function($query)use($request){
                if($request->input('mintime')!=null&&$request->input('maxtime')==null){
                    $query->where('order.order_time','>',$request->input('mintime'));
                }elseif($request->input('maxtime')!=null&&$request->input('mintime')==null){
                    $query->where('order.order_time','<',$request->input('maxtime'));
                }elseif($request->input('maxtime')!=null&&$request->input('mintime')!=null){
                    $query->whereBetween('order.order_time',[$request->input('mintime'),$request->input('maxtime')]);
                }
          })
          ->where(function($query)use($request){
              $order_type=$request->input('order_type');
              $pay_type=$request->input('pay_type');
              if($order_type!='#'){
                    if($order_type==0){
                        $query->whereIn('order.order_type',[0,11]);
                    }else{
                        $query->where('order.order_type',$order_type);
                    }
              }
          if($pay_type!='#'){
              $query->where('order.order_pay_type',$pay_type);
          }
          //根据语言搜索
          if($request->has('languages')&&$request->input('languages')!='0'){
              //按语言查询（根据模板置换语言）
              $band = goods::get_blade($request->input('languages'));
              if($band){
                  $query->whereIn('goods.goods_blade_type',$band);
              }
          }

          //根据地区搜索
          if($request->has('goods_blade_type')&&$request->input('goods_blade_type')!='0'){
              //按语言查询（根据模板置换语言）
              $band = goods::get_area_blade($request->input('goods_blade_type'));
              if($band){
                  $query->whereIn('goods.goods_blade_type',$band);
              }
          }
          })
          ->count();

            //table表格数据
            $data=DB::table('order')
            ->select('order.*','goods.goods_real_name','admin.admin_show_name')
            ->leftjoin('goods','order.order_goods_id','=','goods.goods_id')
            ->leftjoin('admin','order.order_admin_id','=','admin.admin_id')
           ->where(function($query)use($search){
                $query->where([['order.order_single_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_ip','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['goods.goods_real_name','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_cuxiao_id','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_send','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['admin.admin_show_name','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_name','like',"%$search%"],['order.is_del','=','0']]);
                $query->orWhere([['order.order_tel','like',"%$search%"],['order.is_del','=','0']]);
            })
           ->where(function($query)use($goods_search){
            if($goods_search!=0){
              $garr=\App\goods::get_only_slef_id($goods_search);
                $query->whereIn('order_goods_id',$garr);
            }
           })->where(function ($query)use($order_repeat_ip){
                    if($order_repeat_ip == 1){
                        $query->where('order_repeat_field','1');
                        $query->orWhere('order_repeat_field','1,2');
                        $query->orWhere('order_repeat_field','1,3');
                        $query->orWhere('order_repeat_field','1,2,3');
                    }
                })->where(function ($query)use($order_repeat_name){
                    if($order_repeat_name == 1){
                        $query->where('order_repeat_field','2');
                        $query->orWhere('order_repeat_field',',2');
                        $query->orWhere('order_repeat_field','1,2');
                        $query->orWhere('order_repeat_field','2,3');
                        $query->orWhere('order_repeat_field','1,2,3');
                    }
                })->where(function ($query)use($order_repeat_tel){
                    if($order_repeat_tel == 1){
                        $query->where('order_repeat_field','3');
                        $query->orWhere('order_repeat_field',',3');
                        $query->orWhere('order_repeat_field','1,3');
                        $query->orWhere('order_repeat_field','2,3');
                        $query->orWhere('order_repeat_field','1,2,3');
                    }
                })
            ->where(function($query)use($request){
            if($request->input('mintime')!=null&&$request->input('maxtime')==null){
              $query->where('order.order_time','>',$request->input('mintime'));
            }elseif($request->input('maxtime')!=null&&$request->input('mintime')==null){
              $query->where('order.order_time','<',$request->input('maxtime'));
            }elseif($request->input('maxtime')!=null&&$request->input('mintime')!=null){
               $query->whereBetween('order.order_time',[$request->input('mintime'),$request->input('maxtime')]);
            }
          })
             ->where(function($query)use($request){
              $order_type=$request->input('order_type');
              $pay_type=$request->input('pay_type');
              if($order_type!='#'){
                if($order_type==0){
                  $query->whereIn('order.order_type',[0,11]);
                }else{
                  $query->where('order.order_type',$order_type);
                }
              }
              if($pay_type!='#'){
                 $query->where('order.order_pay_type',$pay_type);
              }
             //根据语言搜索
             if($request->has('languages')&&$request->input('languages')!='0'){
                 //按语言查询（根据模板置换语言）
                 $band = goods::get_blade($request->input('languages'));
                 if($band){
                     $query->whereIn('goods.goods_blade_type',$band);
                 }
             }
             //根据地区搜索
             if($request->has('goods_blade_type')&&$request->input('goods_blade_type')!='0'){
                 //按语言查询（根据模板置换语言）
                 $band = goods::get_area_blade($request->input('goods_blade_type'));
                 if($band){
                     $query->whereIn('goods.goods_blade_type',$band);
                 }
             }
            })
            ->orderBy($order,$dsc)
            ->offset($start)
            ->limit($len)
            ->get();
           }
           //商品附带规格信息
	        foreach($data as $k => &$v){
	        $goods= \App\goods::where('goods_id',$v->order_goods_id)->first();
          if(time()-strtotime($v->order_time)>=86400){
            $data[$k]->order_time.="<span style='color:red;display:block;'>此订单已超过24小时</span>";
          }
          //订单价格换算为人民币
	        $goods_currency_id = $goods->goods_currency_id;
            if($goods->is_del == '1'){
                $v->goods_real_name = $v->goods_real_name.'<span style="color: red">(已删除)</span>';
            }
	        $currency_type_name = \App\currency_type::where('currency_type_id',$goods_currency_id)->value('currency_type_name');
	        $v->order_price = $currency_type_name.' '.$v->order_price;
	        if($v->order_repeat_field){
	            if(substr( $v->order_repeat_field, 0, 1 ) == ','){
                    $v->order_repeat_field = substr( $v->order_repeat_field, 1);
                }
                $v->order_repeat_field = explode(',',$v->order_repeat_field);
            }
            $order_config=\App\order_config::where('order_primary_id',$v->order_id)->get();
	        $special = '';
            if($v->order_price_id){
//                $special= special::select('price.price_name')->leftjoin('price','price.price_id','special.special_price_id')->where('special.special_id',$v->order_price_id)->first();
                    $special = price::where('price_id',$v->order_price_id)->value('price_name');
            }
            if($order_config->count()>0){
                $config_msg='';
                $i=0;
                foreach($order_config  as  $va){
                  $i++;
                  $config_msg.="第".$i."件：";
                  $orderarr=explode(',',$va['order_config']);
                  foreach($orderarr as $key => $val){
                    $conmsg=\App\config_val::where('config_val_id',$val)->first();
                    $config_msg.=$conmsg['config_val_msg'].'-';
                  }
                  $config_msg=rtrim($config_msg,'-');
                  $config_msg.='<br/>';
                }
                if($special){
                    $config_msg .= '<hr>赠：'.$special;
                }
                /*$config_msg=rtrim($config_msg,'<br/>');*/
                $data[$k]->config_msg=$config_msg;
              }else{
                $config_msg = $special ? "暂无属性信息<hr>赠：".$special : "暂无属性信息";
                $data[$k]->config_msg=$config_msg;
              }
            $iparea=getclientcity($request,$v->order_ip);
            $data[$k]->order_ip=($iparea['country']==$iparea['city']?$v->order_ip."<br/>".$iparea['country']:$v->order_ip."<br/>".$iparea['country'].'-'.$iparea['city']);
            $data[$k]->order_tel=($v->order_tel==''||$v->order_tel==null?"<span style=color:red;>没有填写</span>":$v->order_tel);
            $data[$k]->order_email=($v->order_email==''||$v->order_email==null?"<span style=color:red;>没有填写</span>":$v->order_email);
            $data[$k]->order_add=($v->order_add==''||$v->order_add==null?"<span style=color:red;>没有填写</span>":$v->order_add);
            $data[$k]->order_remark=($v->order_remark==''||$v->order_remark==null?"<span style=color:red;>没有填写</span>":$v->order_remark);
          }
	        $arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>$data];
	        return response()->json($arr);
   }
   public function orderinfo(Request $request){
    //获取订单信息
      $id=$request->input('id');
      $msg=order::where('order_id',$id)->first();
      $html=$msg->order_return;
      return $html;
   }

    /** 订单审核页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
   public function heshen(Request $request){
    if($request->has('type')&&$request->input('type')=='all'){
      $id=explode(',',$request->input('id'));
      $orders=order::whereIn('order_id',$id)->get();
      $send_nums='';
      foreach($orders as $k => $v){
        if($v->order_send!=null&&$v->order_send!=''){
                  $send_nums.=$v->order_send.';';
        }else{
          $send_nums.='暂无;';
        }
      }
      $send_nums=rtrim($send_nums,';');
      return view('admin/order/heshenarr')->with(compact('orders','send_nums'));
    }else{
       //获取订单核审页面
      $id=$request->input('id');
      $order=order::where('order_id',$id)->first();
      $goods=\App\goods::where('goods_id',$order->order_goods_id)->first();
      return view('admin/order/heshen')->with(compact('order','goods'));
    }
   }

    /** 订单批量审核
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
   public function order_arr_change(Request $request){
    //订单批量核审
     $data=$request->all();
     $msg=false;
     $msg_content = false;
     $order_single = false;
     foreach ($data['order_ids'] as $key => $val) {
          $order=order::where('order_single_id',$val)->first();
          if($order->order_type == '9'){
              $msg_content.=$val.',';
          }else{
              if($request->has('order_send')&&$request->input('order_send')!=null){
                  if(count(explode(';', $data['order_send']))!=count($data['order_ids'])){
                      //检查快递单号数目是否有错
                      return response()->json(['err'=>0,'str'=>'快递单号数目错误']);
                  }
                  $admin=Auth::user()->admin_name;
                  $date=date('Y-m-d H:i:s',time());
                  $oldmsg=$order->order_return;
                  $order_send_now=explode(';',$data['order_send'])[$key];
                  if($order_send_now=='暂无'){
                      $order_send_now=null;
                  }
                  $err=order::where('order_single_id',$val)->update(['order_type'=>$data['order_type_now'],'order_send'=>$order_send_now,'order_return'=>$oldmsg."<p style='text-align:center'>[".$date."] ".$admin."：".$data['order_return']."</p>",'order_return_time'=>$date,'order_admin_id'=>Auth::user()->admin_id]);
                  if($err===false){
                      $msg.=$val.',';
                  }else{
                      $order_single.=$val.',';
                  }
              }else{
                  $admin=Auth::user()->admin_name;
                  $date=date('Y-m-d H:i:s',time());
                  $oldmsg=$order->order_return;
                  $err=order::where('order_single_id',$val)->update(['order_type'=>$data['order_type_now'],'order_return'=>$oldmsg."<p style='text-align:center'>[".$date."] ".$admin."：".$data['order_return']."</p>",'order_return_time'=>$date,'order_admin_id'=>Auth::user()->admin_id]);
                  if($err===false){
                      $msg.=$val.',';
                  }else{
                      $order_single.=$val.',';
                  }
              }
          }
     }
     if($order_single!==false){
         $ip = $request->getClientIp();
         //加log日志
         operation_log($ip,'订单审核成功,订单编号：'.$order_single);
     }
     if($msg!==false || $msg_content!==false){
            if($msg!==false && $msg_content===false){
                $str = rtrim($msg,',').'号订单核审失败';
            }elseif($msg===false && $msg_content!==false){
                $str = rtrim($msg_content,',').'号订单为预支付订单，不能审核';
            }else{
                $str = rtrim($msg_content,',').'号订单为预支付订单，不能审核\n'.rtrim($msg,',').'号订单核审失败';
            }
            return response()->json(['err'=>0,'str'=>$str]);
      }else{
            return response()->json(['err'=>1,'str'=>'核审成功']);
      }
   }

    /** 审核订单
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
   public function order_type_change(Request $request){
   	  $data=$request->all();
      if(!isset($data['id'])){
        $arr=['msg'=>'err'];
        return response()->json($arr);
      }
   	  $order=order::where('order_id',$data['id'])->first();
   	  $oldmsg=$order->order_return;
   	  $date=date('Y-m-d H:i:s',time());
   	  $admin=Auth::user()->admin_name;
   	  $htmlnow=$oldmsg."<p style='text-align:center'>[".$date."] ".$admin."：".$data['order_return']."</p>";
   	  $order->order_type=$data['order_type_now'];
   	  $order->order_return= $htmlnow;
   	  $order->order_send=$data['order_send'];
   	  $order->order_return_time=$date;
        $order->order_admin_id=Auth::user()->admin_id;
   	  $msg=$order->save();
   	  if($msg){
          $ip = $request->getClientIp();
          //加log日志
          operation_log($ip,'订单审核成功,订单号：'.$order['order_single_id']);
   	  	    $arr=['msg'=>0];
	        return response()->json($arr);
   	  }else{
   	  		$arr=['msg'=>'err'];
	        return response()->json($arr);
   	  }
   }

    /** 删除订单（软删除）
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
   public function delorder(Request $request){
       $ip = $request->getClientIp();
       if($request->has('type')&&$request->input('type')=='all'){
          $ids=$request->input('id');
          $err=null;
          $order_single=null;
           foreach($ids as $k => $v){
            if($v==null){break;}
            $msg=order::where('order_id',$v)->update(['is_del'=>'1']);
            if(!$msg){
              $err.=$v.',';
            }
            $order_single.=order::where('order_id',$v)->value('order_single_id').',';
           }
           if($err!=null){
               return response()->json(['err'=>0,'str'=>rtrim($err,',').'号订单删除失败']);
           }else{
               operation_log($ip,'订单删除成功,订单号：'.$order_single);
               return response()->json(['err'=>1,'str'=>'删除成功']);
           }
         }
   	     $order=order::where('order_id',$request->input('id'))->first();
         $order->is_del='1';
         if($order->save()){
             //加log日志
             operation_log($ip,'订单删除成功,订单号：'.$order->order_single_id);
             return response()->json(['err'=>1,'str'=>'删除成功']);
         }else{
	   	    	return response()->json(['err'=>0,'str'=>'删除失败']);
         }
   }
   public function getaddr(Request $request){
   	     $id=$request->input('id');
   	     $order=order::where('order_id',$id)->first();
         return view('admin.order.addr')->with(compact('order'));

   }
   public function outorder(Request $request){
//        //判断导出时间
//        if(strtotime($request->input('max'))-strtotime($request->input('min'))>604800){
//          return '<span style="color:red;display:block;width:100%;text-align:center;">最多导出七天数据！(三秒后自动返回上个页面)<span><script>setTimeout("window.history.go(-1)",3000); </script>';
//        }
//
//       //订单导出
//       $data=order::select('order.order_id','order.order_zip','order.order_price_id','order.order_single_id','goods.goods_id','goods.goods_is_update','goods.goods_is_update','order.order_single_id','order.order_currency_id','order.order_ip','order.order_pay_type','goods.goods_kind_id','cuxiao.cuxiao_msg','order.order_price','order.order_type','order.order_return','order.order_time','order.order_return_time','admin.admin_name','order.order_num','order.order_send','goods.goods_real_name','order.order_name','order.order_state','order.order_city','order.order_add','order.order_remark','order.order_tel')
//           ->leftjoin('goods','order.order_goods_id','=','goods.goods_id')
//           ->leftjoin('cuxiao','order.order_cuxiao_id','=','cuxiao.cuxiao_id')
//           ->leftjoin('admin','order.order_admin_id','=','admin.admin_id')
//           ->where(function($query){
//            if(Auth::user()->is_root!='1'){
//              $query->whereIn('goods_admin_id', admin::get_admins_id());
//            }
//           })
//           ->where(function($query){
//            $query->where('order.is_del','0');
//           })
//           ->where(function($query)use($request){
//              if($request->has('min')&&$request->has('max')){
//                $query->whereBetween('order.order_time',[$request->input('min'),$request->input('max')]);
//              }else{
//                $now_date=date('Y-m-d',time()).' 00:00:00';
//                $query->where('order.order_time','>',$now_date);
//              }
//           })
//           ->where(function($query)use($request){
//            $goods_search=$request->input('admin_name');
//            //筛选不同账户条件
//              if($goods_search!=0){
//                   $garr=\App\goods::get_only_slef_id($goods_search);
//                $query->whereIn('order_goods_id',$garr);
//                }
//           })
//           ->where(function($query)use($request){
//             $order_type=$request->input('order_type');
//              $pay_type=$request->input('pay_type');
//              if($order_type!='null'){
//                if($order_type==0){
//                  $query->whereIn('order.order_type',[0,11]);
//                }else{
//                  $query->where('order.order_type',$order_type);
//                }
//              }else{
//                $query->where('order.order_type','1');
//              }
//              if($pay_type!='null'){
//                  $query->where('order.order_pay_type',$pay_type);
//              }
//              //根据语言搜索
//              if($request->has('languages')&&$request->input('languages')!='0'){
//                  //按语言查询（根据模板置换语言）
//                  $band = goods::get_blade($request->input('languages'));
//                  if($band){
//                      $query->whereIn('goods.goods_blade_type',$band);
//                  }
//              }
//
//               //根据地区搜索
//               if($request->has('goods_blade_type')&&$request->input('goods_blade_type')!='0'){
//                   //按语言查询（根据模板置换语言）
//                   $band = goods::get_area_blade($request->input('goods_blade_type'));
//                   if($band){
//                       $query->whereIn('goods.goods_blade_type',$band);
//                   }
//               }
//           })
//           ->orderBy('order.order_time','desc')
//           ->get()->toArray();
//           if($request->has('min')&&$request->has('max')){
//               $start_time = substr($request->input('min'),5,5);
//               $end = substr($request->input('max'),5,5);
//               $filename=$start_time.'__'.$end.'订单记录'.date('m-d H时i分s秒',time());
//           }else{
//               $filename='订单记录'.date('Y年m月d日 H时i分s秒',time());
//           }
//       //默认
//       excelData::unify($data,$filename);
//       $goods_blade_type = $request->input('goods_blade_type');
//       if($goods_blade_type == 7){
//           //菲律宾
//           $cellData = excelData::flb($data);
//           Excel::create($filename,function ($excel) use ($cellData,$filename){
//               $excel->sheet($filename, function ($sheet) use ($cellData){
//                   $sheet->rows($cellData);
//               });
//           })->export('xls');
//       }else if($goods_blade_type == 2){
//           //中东地区
//           excelData::zd($data,$filename);
//       }else{
//           //默认
//           excelData::unify($data,$filename);
//       }



       //==============================================================================
        if(strtotime($request->input('max'))-strtotime($request->input('min'))>604800){
          return '<span style="color:red;display:block;width:100%;text-align:center;">最多导出七天数据！(三秒后自动返回上个页面)<span><script>setTimeout("window.history.go(-1)",3000); </script>';
        }
       //订单导出
       $data=order::select('order.order_id','order.order_zip','order.order_price_id','order.order_village','order.order_single_id','goods.goods_id','goods.goods_is_update','goods.goods_is_update','order.order_single_id','order.order_currency_id','order.order_ip','order.order_pay_type','goods.goods_kind_id','cuxiao.cuxiao_msg','order.order_price','order.order_type','order.order_return','order.order_time','order.order_return_time','admin.admin_name','order.order_num','order.order_send','goods.goods_real_name','order.order_name','order.order_state','order.order_city','order.order_add','order.order_remark','order.order_tel')
           ->leftjoin('goods','order.order_goods_id','=','goods.goods_id')
           ->leftjoin('cuxiao','order.order_cuxiao_id','=','cuxiao.cuxiao_id')
           ->leftjoin('admin','order.order_admin_id','=','admin.admin_id')
           ->where(function($query){
            if(Auth::user()->is_root!='1'){
//              $goods=\App\goods::get_ownid(Auth::user()->admin_id);
              $query->whereIn('goods_admin_id', admin::get_admins_id());
            }
           })
           ->where(function($query){
            $query->where('order.is_del','0');
           })
          /* ->where(function($query){
            $query->where('order.order_type','1');
           })*/
           ->where(function($query)use($request){
              if($request->has('min')&&$request->has('max')){
                $query->whereBetween('order.order_time',[$request->input('min'),$request->input('max')]);
              }else{
                $now_date=date('Y-m-d',time()).' 00:00:00';
                $query->where('order.order_time','>',$now_date);
              }
           })
           ->where(function($query)use($request){
            $goods_search=$request->input('admin_name');
            //筛选不同账户条件
              if($goods_search!=0){
                   $garr=\App\goods::get_only_slef_id($goods_search);
                $query->whereIn('order_goods_id',$garr);
                }
           })
           ->where(function($query)use($request){
             $order_type=$request->input('order_type');
              $pay_type=$request->input('pay_type');
              if($order_type!='null'){
                if($order_type==0){
                  $query->whereIn('order.order_type',[0,11]);
                }else{
                  $query->where('order.order_type',$order_type);
                }
              }else{
                $query->where('order.order_type','1');
              }
              if($pay_type!='null'){
                  $query->where('order.order_pay_type',$pay_type);
              }
              //根据语言搜索
              if($request->has('languages')&&$request->input('languages')!='0'){
                  //按语言查询（根据模板置换语言）
                  $band = goods::get_blade($request->input('languages'));
                  if($band){
                      $query->whereIn('goods.goods_blade_type',$band);
                  }
              }

               //根据地区搜索
               if($request->has('goods_blade_type')&&$request->input('goods_blade_type')!='0'){
                   //按语言查询（根据模板置换语言）
                   $band = goods::get_area_blade($request->input('goods_blade_type'));
                   if($band){
                       $query->whereIn('goods.goods_blade_type',$band);
                   }
               }
           })
           ->orderBy('order.order_time','desc')
           ->get()->toArray();
          $goods_blade_type = $request->input('goods_blade_type');
          $new_exdata=[];
           foreach($data as $k => $v){
//            switch ($v['order_type']) {
//               case '0':
//                 $data[$k]['order_type']='<span class="label label-success radius" style="color:#ccc;">未核审</span>';
//                  break;
//               case '1':
//                 $data[$k]['order_type']='<span class="label label-default radius" style="color:green;">核审通过</span>';
//                 break;
//               case '2':
//                 $data[$k]['order_type']=' <span class="label label-default radius" style="color:red;">核审驳回</span>';
//                 break;
//               case '3':
//                 $data[$k]['order_type']=' <span class="label label-default radius" style="color:brown;">已发货</span>';
//                 break;
//               case '4':
//                 $data[$k]['order_type']=' <span class="label label-default radius" style="color:#6699ff;">已签收</span>';
//                 break;
//               case '5':
//                 $data[$k]['order_type']=' <span class="label label-default radius" style="color:#red;">退货未退款</span>';
//                 break;
//               case '6':
//                 $data[$k]['order_type']=' <span class="label label-default radius" style="color:#red;">退货并已退款</span>';
//                 break;
//               case '7':
//                 $data[$k]['order_type']=' <span class="label label-default radius" style="color:#red;">未退货并已退款</span>';
//                 break;
//               case '8':
//                 $data[$k]['order_type']=' <span class="label label-default radius" style="color:#red;">拒签</span>';
//                 break;
//               default:
//                  $data[$k]['order_type']=' <span class="label label-default radius" style="color:red;">数据错误！</span>';
//                  break;
//            }
            //重组新格式
              $new_exdata[$k]['order_time'] = $v['order_time'];
              $new_exdata[$k]['order_single_id'] = $v['order_single_id'];
              $new_exdata[$k]['name'] = $v['order_name'];
              $new_exdata[$k]['tel'] = $v['order_tel'];
               if($v['order_zip']){
                   $str = $v['order_add'];
                   $pattern = '/(.*)\(Zip:(.*?)\)/';
                   preg_match_all($pattern,$str,$p);
                   $area_info = (isset($p[1][0]) && $p[1][0]) ? $p[1][0] : $v['order_add'];

                   if($goods_blade_type == 6){
                       $new_exdata[$k]['area_data_info'] = $v['order_state'].' '.$v['order_city'].' '. $v['order_village'] .'('.$area_info.')';
                       $new_exdata[$k]['order_state'] = $v['order_state'];
                       $new_exdata[$k]['order_city'] = $v['order_city'];
                       $new_exdata[$k]['order_village'] = $v['order_village'];
                   }else{
                       $new_exdata[$k]['area_data_info'] = $v['order_state'].' '.$v['order_city'].' '. $v['order_village'] .'('.$area_info.')';
                       $new_exdata[$k]['order_state'] = $v['order_state'];
                       $new_exdata[$k]['order_city'] = $v['order_city'];
                   }
                   $new_exdata[$k]['area_info'] = $area_info;
                   $new_exdata[$k]['order_zip'] = $v['order_zip'];
               }else{
                   $str=$v['order_add'];
                   $pattern='/(.*)\(Zip:(.*?)\)/';
                   preg_match_all($pattern,$str,$p);
                   $area_info = (isset($p[1][0]) && $p[1][0]) ? $p[1][0] : $v['order_add'];
                   $new_exdata[$k]['area_data_info'] = $v['order_state'].' '.$v['order_city'].' '. $v['order_village'] .'('.$area_info.')';
                   $new_exdata[$k]['order_state'] = $v['order_state'];
                   $new_exdata[$k]['order_city'] = $v['order_city'];
                   if($goods_blade_type == 6){
                       $new_exdata[$k]['area_data_info'] = $v['order_state'].' '.$v['order_city'].' '. $v['order_village'] .'('.$area_info.')';
                       $new_exdata[$k]['order_state'] = $v['order_state'];
                       $new_exdata[$k]['order_city'] = $v['order_city'];
                       $new_exdata[$k]['order_village'] = $v['order_village'];
                   }else{
                       $new_exdata[$k]['area_data_info'] = $v['order_state'].' '.$v['order_city'].' '. $v['order_village'] .'('.$area_info.')';
                       $new_exdata[$k]['order_state'] = $v['order_state'];
                       $new_exdata[$k]['order_city'] = $v['order_city'];
                   }
                   $new_exdata[$k]['area_info'] = $area_info;
                   $new_exdata[$k]['order_zip'] = isset($p[2][0]) ? $p[2][0] : '';
               }

              $new_exdata[$k]['goods_real_name'] = \App\goods_kind::where('goods_kind_id',$v['goods_kind_id'])->value('goods_kind_name');
              $new_exdata[$k]['goods_name'] = $v['goods_real_name'];
              $new_exdata[$k]['payof'] = \App\currency_type::where('currency_type_id',$v['order_currency_id'])->value('currency_english_name');
              $new_exdata[$k]['order_price'] = $v['order_price'];
              $new_exdata[$k]['order_num'] = $v['order_num'];
               //尺寸信息
               $order_config = \App\order_config::where('order_primary_id',$v['order_id'])->get();
               if($order_config->count() > 0){
                   $config_msg = '';//产品属性
                   $goods_config_msg = '';//商品展示属性
                   $i = 0;
                   foreach($order_config  as  $va){
                       $i++;
                       $goods_config_msg .= "第".$i."件：";
                       $kind_msg = "<td>第".$i."件</td>";
                       $orderarr = explode(',',$va['order_config']);
                       foreach($orderarr as $key => $val){
                           $conmsg = \App\config_val::where('config_val_id',$val)
                               ->where(function($query)use($v){
                                   if($v['goods_is_update'] == '1'){
                                       $query->where('kind_val_id','>',0);
                                   }
                               })
                               ->first();
                           if($conmsg == null){
                               $conmsg = \App\config_val::where('config_val_id',$val)->first();
                           }
                           if(isset($conmsg->kind_val_id) && $conmsg->kind_val_id){
                               $config_val_msg = kind_val::where('kind_val_id',$conmsg->kind_val_id)->value('kind_val_msg');
                           }else{
                               $config_val_msg = $conmsg['config_val_msg'];
                           }
                           $kind_msg .= '<td>'.$conmsg['config_val_msg'].'</td>';
                           $goods_config_msg .= $config_val_msg.'-';
                       }
                       $config_msg .= '<tr>'.$kind_msg.'</tr>';
                       $goods_config_msg = rtrim($goods_config_msg,'-');
                       $goods_config_msg .= '<br/>';
                   }
                   $new_exdata[$k]['config_msg'] = '<table border=1>'.$config_msg.'</table>';
                   $new_exdata[$k]['goods_config_msg'] = $goods_config_msg;
               }else{
                   $new_exdata[$k]['config_msg'] = "暂无属性信息";
                   $new_exdata[$k]['goods_config_msg'] = "暂无属性信息";
               }
              $new_exdata[$k]['remark'] = $v['order_remark'];
              $new_exdata[$k]['order_pay_type'] = $v['order_pay_type'] == 0 ? '货到付款': '在线支付';
              $new_exdata[$k]['special_name'] = price::where('price_id',$v['order_price_id'])->value('price_name');
           }
         if($request->has('min')&&$request->has('max')){
          $filename='['.$request->input('min').']—'.'['.$request->input('max').']'.'订单记录'.date('Y-m-d H:i:s',time()).'.xls';
         }else{
            $filename='订单记录'.date('Y-m-d H:i:s',time()).'.xls';
         }
/*         $zdname=['订单id','订单编号','下单者ip','单品名','促销信息','订单价格','订单类型','反馈信息','下单时间','反馈时间','核审人员','商品件数','快递单号'];
*/
/*        order_time . name.tel.send_msg.state.city.area_msg.zip.goods_kind_name.goods_name.currency_type.account.count.color.remark.pay_type*/
        //$zdname=['下单时间','产品名称','商品名','型号/尺寸/颜色','数量','币种','总金额','支付方式','客户名字','客户电话','地区','城市','详细地址','邮寄地址','邮政编码','备注'];
       if($goods_blade_type == 6){
           $zdname=['下单时间','订单编号','客户名字','客户电话','详细地址','地区','城市','县','邮寄地址','邮政编码','产品名称','商品名','币种','总金额','数量','产品属性信息','商品展示属性信息','备注','支付方式','赠品名称'];
       }else{
           $zdname=['下单时间','订单编号','客户名字','客户电话','详细地址','地区','城市','邮寄地址','邮政编码','产品名称','商品名','币种','总金额','数量','产品属性信息','商品展示属性信息','备注','支付方式','赠品名称'];
       }
        out_excil($new_exdata,$zdname,'訂單信息记录表',$filename);
   }
   public function payinfo(Request $request)
   {
    $id=$request->input('id');
    $paypal=\App\paypal::where('paypal_order_id',$id)->first();
    return view('admin.order.paypal')->with(compact('paypal'));
   }

    /** 订单统计页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
   public function count(Request $request)
   {

    if($request->isMethod('get')){
        $goods_ids=\App\admin::get_goods_id();
        $counts=\App\goods::whereIn('goods_id',$goods_ids)->where('is_del','0')->count();
        return view('admin.order.count')->with(compact('counts'));
      }elseif($request->isMethod('post')){
         if($request->input('mintime')!=null&&$request->input('maxtime')!=null){
            if(strtotime($request->input('maxtime'))-strtotime($request->input('mintime'))>604800){
              return response()->json(['error'=>'所选时间范围不得超过七天']);
            }
         }
        $info=$request->all();
          if(!isset($info['order'])){
            $dsc='desc';
            $order='order_id';
          }else{
            $cm=$info['order'][0]['column'];
            if($info['columns']["$cm"]['data']=='order_counts'){
              //当已单数统计时使用默认排序
              $order='goods_up_time';
              $dsc='desc';
            }else{
              $dsc=$info['order'][0]['dir'];
              $order=$info['columns']["$cm"]['data'];
            }
          }

          $draw=$info['draw'];
          $start=$info['start'];
          $len=$info['length'];
          $search=trim($info['search']['value']);
          $goods_ids=\App\admin::get_goods_id();
          $counts=\App\goods::whereIn('goods_id',$goods_ids)->where('is_del','0')->count();
            $newcount=DB::table('goods')
            ->select('goods.goods_name','goods.goods_up_time','goods.goods_admin_id','goods.goods_id','goods.goods_currency_id','admin.admin_show_name')
            ->leftjoin('admin','goods.goods_admin_id','=','admin.admin_id')
            ->where(function($query)use($search){
                $query->where('goods.goods_id','like',"%$search%");
                $query->orWhere('goods.goods_name','like',"%$search%");
                $query->orWhere('goods.goods_real_name','like',"%$search%");
                $query->orWhere('admin.admin_show_name','like',"%$search%");
            })
            ->whereIn('goods_id',\App\admin::get_goods_id())
            ->count();
          $data=DB::table('goods')
          ->select('goods.goods_name','goods.goods_real_name','goods.goods_up_time','goods.goods_admin_id','goods.goods_id','goods.goods_currency_id','admin.admin_show_name')
            ->leftjoin('admin','goods.goods_admin_id','=','admin.admin_id')
            ->where(function($query)use($search){
                $query->where('goods.goods_id','like',"%$search%");
                $query->orWhere('goods.goods_name','like',"%$search%");
                $query->orWhere('goods.goods_real_name','like',"%$search%");
                $query->orWhere('admin.admin_show_name','like',"%$search%");
            })
            ->whereIn('goods_id',\App\admin::get_goods_id())
          ->orderBy($order,$dsc)
          ->get()->toArray();
        if($request->input('mintime')==null&&$request->input('maxtime')==null){
            $order=\App\order::where(function($query){
                      $time=date('Y-m-d',time()).' 00:00:00';
                      $query->where('order.order_time','>',$time);
                     })
                     ->where('order.is_del','0')
                     ->get();
        }elseif(($request->input('mintime')!=null&&$request->input('maxtime')==null)||($request->input('mintime')==null&&$request->input('maxtime')!=null)){
              return response()->json(['error'=>'日期选择不规范']);
        }else{
          $order=\App\order::where(function($query)use($request){
                      $query->where('order.order_time','>',$request->input('mintime'));
                      $query->where('order.order_time','<',$request->input('maxtime'));
                     })
                     ->where('order.is_del','0')
                     ->get();
        }
            $allcount=0;
            $allprecount=0;
            $allaccount=0;
          if(count($data)>0){
                foreach($data as $key => $v) {
                  if($request->input('mintime')==null&&$request->input('maxtime')==null){
                     $goods_id=$v->goods_id;
                     $data[$key]->order_counts=$order->where('order_goods_id',$goods_id)
                     ->count();
                     $data[$key]->order_real_counts=$order->where('order_goods_id',$goods_id)
                     ->whereIn('order_type',\App\order::get_sale_type())
                     ->count();
                     $data[$key]->order_hdfk_counts=$order->where('order_goods_id',$goods_id)
                     ->where('order_pay_type','0')
                     ->count();
                     $data[$key]->order_zxzf_counts=$order->where('order_goods_id',$goods_id)
                     ->where('order_pay_type','<>','0')
                     ->count();
                    $allcount+=$data[$key]->order_counts;
                    $allprecount+=$data[$key]->order_real_counts;
                  }elseif(($request->input('mintime')!=null&&$request->input('maxtime')==null)||($request->input('mintime')==null&&$request->input('maxtime')!=null)){
                         return response()->json(['error'=>'日期选择不规范']);
                  }else{
                     $goods_id=$v->goods_id;
                     $data[$key]->order_counts=$order->where('order_goods_id',$goods_id)
                     ->count();
                     $data[$key]->order_real_counts=$order->where('order_goods_id',$goods_id)
                     ->whereIn('order_type',\App\order::get_sale_type())
                     ->count();
                     $data[$key]->order_hdfk_counts=$order->where('order_goods_id',$goods_id)
                     ->where('order_pay_type','0')
                     ->count();
                     $data[$key]->order_zxzf_counts=$order->where('order_goods_id',$goods_id)
                     ->where('order_pay_type','<>','0')
                     ->count();
                    $allcount+=$data[$key]->order_counts;
                    $allprecount+=$data[$key]->order_real_counts;
                  }
                  //计算销售额
                   if($request->input('mintime')==null&&$request->input('maxtime')==null){
                    $time = date('Y-m-d',time()).' 00:00:00';
                    $endtime=date('Y-m-d H:i:s',time());
                    $data[$key]->day_sales=$order->where('order_time','>',$time)->where('order_time','<',$endtime)->where('order_goods_id',$v->goods_id)
                    ->whereIn('order_type',\App\order::get_sale_type())
                    ->sum('order_price')*\App\currency_type::where('currency_type_id',$v->goods_currency_id)->first()['exchange_rate'];
                    $allaccount+=$data[$key]->day_sales;
                   /* //1.获取今天数据订单
                    $orders = \App\order::where('order_time','like',$time.'%')->where(function($query){
                        $query->whereIn('order.order_type',\App\order::get_sale_type());
                        $query->where('order.is_del','0');
                    })->get();*/
                  }elseif(($request->input('mintime')!=null&&$request->input('maxtime')==null)||($request->input('mintime')==null&&$request->input('maxtime')!=null)){
                         return response()->json(['error'=>'日期选择不规范']);
                  }else{
                    $time=$request->input('mintime');
                    $endtime=$request->input('maxtime');
                    $data[$key]->day_sales=$order->where('order_time','>',$time)->where('order_time','<',$endtime)->where('order_goods_id',$v->goods_id)
                    ->whereIn('order_type',\App\order::get_sale_type())
                    ->sum('order_price')*\App\currency_type::where('currency_type_id',$v->goods_currency_id)->first()['exchange_rate'];
                    $allaccount+=$data[$key]->day_sales;
                    /* $orders = \App\order::where('order_time','>',$request->input('mintime'))
                     ->where('order_time','<',$request->input('maxtime'))
                     ->where(function($query){
                        $query->whereIn('order.order_type',\App\order::get_sale_type());
                        $query->where('order.is_del','0');
                    })->get();*/
                  }
                    /*$day_sales = 0;
                    if(!$orders->isEmpty()){
                        foreach ($orders as $item)
                        {
                            $day_sales += $item->order_price * $item->currency_has_order->exchange_rate;
                        }
                    }
                    $data[$key]->day_sales=$day_sales;*/
                }
            }
        }
        if($info['columns']["$cm"]['data']=='order_counts'&&$info['order'][0]['dir']=='desc'){
            array_multisort(array_column($data,'order_counts'),SORT_DESC,$data);
          }else{
            array_multisort(array_column($data,'order_counts'),SORT_ASC,$data);
          }
          $data=array_slice($data,$start,$len);
        /*  $data['allaccount']=$allaccount;
          $data['allcount']=$allcount;
          $data['allprecount']=$allprecount;*/
          $arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>$data,'allaccount'=>$allaccount,'allcount'=>$allcount,'allprecount'=>$allprecount];
          return response()->json($arr);
      }
      public function send_mail(Request $request)
      //邮件补发
      {
        if($request->isMethod('get')){
           $order=\App\order::findorfail($request->input('id'));
           return view('admin.order.send_mail')->with(compact('order'));
        }elseif($request->isMethod('post')){
           $order=\App\order::findorfail($request->input('id'));
           $email=$request->order_mail;
            if(filter_var($email,FILTER_VALIDATE_EMAIL)!=false){
                if(config('queue')['default']!='sync'){
                       if(checkdnsrr(explode("@",$email)[1],"MX")==false){
                           return response()->json(['msg'=>'无效邮箱，取消推送']);
                       }else{
                           $order->order_email=$email;
                           $order->order_isemail='1';
                           $order->save();
                           try{$emailsend=SendHerbEmail::dispatch($order);}catch(\Exception $e){\Log::notice(json_encode($e));return response()->json(['msg'=>$email.'队列推送失败']);};
                           \Log::notice('邮件补发推送：'.$email);
                           return response()->json(['msg'=>0]);
                      }
                }else{
                   return response()->json(['msg'=>'队列任务未开启！推送失败！']);
                }
            }else{
              return response()->json(['msg'=>'无效邮箱，取消推送']);
            }
        }
      }
  public function change_exl(Request $request)
  {
    if($request->isMethod('get')){
      return view('admin.order.change_exl');
    }else if($request->isMethod('post')){
      if(!$request->hasFile('excil')){
          return '<span style="color:red;display:block;width:100%;text-align:center;">未上传文件！(三秒后自动返回上个页面)<span><script>setTimeout("window.history.go(-1)",3000); </script>';
      }
      if($request->input('excil_name')==null||$request->input('excil_name')==''){
          return '<span style="color:red;display:block;width:100%;text-align:center;">未设置导出文件名！(三秒后自动返回上个页面)<span><script>setTimeout("window.history.go(-1)",3000); </script>';
      }
      $file=$request->file('excil');
       $ext = $file->getClientOriginalExtension();
       if(!in_array($ext, ['exl','csv','xls'])){
          return '<span style="color:red;display:block;width:100%;text-align:center;">文件格式仅支持exl,csv,xls！(三秒后自动返回上个页面)<span><script>setTimeout("window.history.go(-1)",3000); </script>';
       }
      $realPath = $file->getRealPath();
      Excel::selectSheetsByIndex(0)->load($realPath,function($reader)use($request,$file){
        $arr=[];
         $reader->each(function($sheet)use(&$arr){      // 循环所有工作表 
           
                $sheet->each(function($row)use(&$arr){ // 循环单个工作表，所有行 
                  if(($testa=preg_match("/[A-Z]{2}\d{18}(\d{2})?/",$row,$arrs))>0){
                      foreach($arrs as $v){
                         $arr[]=$v;
                      }
                  }
                }); 
            }); 
        $orders=\App\order::select('order.order_id','order.order_zip','order.order_price_id','order.order_village','order.order_single_id','goods.goods_id','goods.goods_is_update','goods.goods_is_update','order.order_single_id','order.order_currency_id','order.order_ip','order.order_pay_type','goods.goods_kind_id','cuxiao.cuxiao_msg','order.order_price','order.order_type','order.order_return','order.order_time','order.order_return_time','admin.admin_name','order.order_num','order.order_send','goods.goods_real_name','order.order_name','order.order_state','order.order_city','order.order_add','order.order_remark','order.order_tel')
           ->leftjoin('goods','order.order_goods_id','=','goods.goods_id')
           ->leftjoin('cuxiao','order.order_cuxiao_id','=','cuxiao.cuxiao_id')
           ->leftjoin('admin','order.order_admin_id','=','admin.admin_id')
           ->whereIn('order.order_single_id',$arr)
           ->orderBy('order.order_time','desc')
        ->get()->toArray();
        switch ($request->input('goods_blade_type')) {
          case '0':
            excelData::unify($orders,$request->input('excil_name'));
            break;
          case '2':
            excelData::zd($orders,$request->input('excil_name'));
            break;
          case '6':
            excelData::ydnxy($orders,$request->input('excil_name'));
            break;
           case '7':
            excelData::flb($orders,$request->input('excil_name'));
            break;
          default:
            excelData::unify($orders,$request->input('excil_name'));
            break;
        }
      });
    }
  }
}
