<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Auth;
use \App\channel\skuSDK;
class storage extends Model
{
    protected $table = 'storage';
    protected $primaryKey ='storage_id';
    public static function order_out($storage_check_id)
    {	
       $order_ids=array_map('array_shift',\App\storage_check_data::select('storage_check_data_order')->where([['storage_primary_id',$storage_check_id],['storage_check_data_type','<',4]])->get()->toArray());
       //订单导出
       $data=order::select('order.order_id','order.order_zip','order.order_price_id','order.order_village','order.order_single_id','goods.goods_id','order.order_goods_admin_id','goods.goods_is_update','goods.goods_is_update','order.order_single_id','order.order_currency_id','order.order_ip','order.order_pay_type','goods.goods_kind_id','cuxiao.cuxiao_msg','order.order_price','order.order_type','order.order_return','order.order_time','order.order_return_time','admin.admin_name','order.order_num','order.order_send','goods.goods_real_name','order.order_name','order.order_state','order.order_city','order.order_add','order.order_remark','order.order_tel')
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
           ->whereIn('order.order_id',$order_ids)
          
           ->orderBy('order.order_time','desc')
           ->get()->toArray();
          $goods_blade_type = 0;
          $new_exdata=[];
           foreach($data as $k => $v){
               $goods_kind = goods_kind::where('goods_kind_id',$v['goods_kind_id'])->first();
               //获取该订单对应校准数据
               $storage_check_data=\App\storage_check_data::where([['storage_primary_id',$storage_check_id],['storage_check_data_order',$v['order_id']]])->first();
               if($goods_kind){
                   //获取数据信息
                   $skuSDK = new skuSDK($v['goods_kind_id'],$goods_kind->goods_product_id,$goods_kind->goods_kind_user_type);

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
 					   $new_exdata[$k]['area_data_info'] = $v['order_state'].' '.$v['order_city'].' '. $v['order_village'] .'('.$area_info.')';
                       $new_exdata[$k]['order_state'] = $v['order_state'];
                       $new_exdata[$k]['order_city'] = $v['order_city'];
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
                       $new_exdata[$k]['area_data_info'] = $v['order_state'].' '.$v['order_city'].' '. $v['order_village'] .'('.$area_info.')';
                       $new_exdata[$k]['order_state'] = $v['order_state'];
                       $new_exdata[$k]['order_city'] = $v['order_city'];
                       $new_exdata[$k]['area_info'] = $area_info;
                       $new_exdata[$k]['order_zip'] = isset($p[2][0]) ? $p[2][0] : '';
                   }
                   $goods_kind = \App\goods_kind::where('goods_kind_id',$v['goods_kind_id'])->first();
                   $new_exdata[$k]['goods_real_name'] = $goods_kind->goods_kind_name;
                   $new_exdata[$k]['goods_real_english_name'] = $goods_kind->goods_kind_english_name;
                   $new_exdata[$k]['goods_name'] = $v['goods_real_name'];
                   $new_exdata[$k]['payof'] = \App\currency_type::where('currency_type_id',$v['order_currency_id'])->value('currency_english_name');
                   $new_exdata[$k]['order_price'] = $v['order_price'];
                   $new_exdata[$k]['order_num'] = $v['order_num'];
//              $new_exdata[$k]['kind_weight'] = $goods_kind->goods_buy_weight ? $goods_kind->goods_buy_weight . 'kg' : '';
//              $new_exdata[$k]['kind_volume'] = $goods_kind->goods_kind_volume == '0cm*0cm*0cm' ? '' : $goods_kind->goods_kind_volume;
                   //尺寸信息
                   $order_config = \App\order_config::select('order_primary_id','order_config')->where('order_primary_id',$v['order_id'])->get()->toArray();/*dd($order_config->toArray());dd(array_unique($order_config->toArray(), SORT_REGULAR));*/
                   $new=[];
                   $count=[];
                   foreach($order_config as $key_s => $vall){
                    if(in_array($vall, $new)){
                      //dd(array_keys($new,$v)[0]);
                      $count[array_keys($new,$vall)[0]]+=1;
                    }else{
                      $new[$key_s]=$vall;
                      $count[$key_s]=1;
                    }
                   }
                   /*foreach($new as $k => $val){
                    $new[$k]['num']=$count[$k];
                   }*/
                   $order_config=$new;
                   /*if($order_config->count() > 0){*/
                    if(count($order_config)>0){
                       $config_msg = '';//产品属性
                       $config_english_msg = '';
                       $goods_config_msg = '';//商品展示属性
                       $goods_all_sku = '';

                       $i = 0;
                       foreach($order_config  as $keyss=> $va){
                           $i++;
                           $goods_msg = "";
                           $kind_msg = "<td>".$count[$keyss]."</td>";
                           $kind_english_msg = "";
                           $orderarr = explode(',',$va['order_config']);
                           //================================================
                           $config_attr = [];
                           $sort_config_msg = [];
                           $sort_config_msg1 = [];
                           foreach($orderarr as $key => $val){
                               $sort_config = config_val::where('config_val_id',$val)->select('kind_config.kind_config_msg')->join('kind_val','kind_val.kind_val_id','=','config_val.kind_val_id')->join('kind_config','kind_config_id','=','kind_val.kind_type_id')->first();
                               if($sort_config){
                                   $sort_config_msg1[$val] = $sort_config->kind_config_msg;
                               }
                           }
                           if((in_array('尺码',$sort_config_msg1) && in_array('颜色',$sort_config_msg1)) || (in_array('尺碼',$sort_config_msg1) && in_array('顏色',$sort_config_msg1)) || (in_array('尺寸',$sort_config_msg1) && in_array('颜色',$sort_config_msg1))){
                               $size =  array_keys($sort_config_msg1,"尺码");
                               $color =  array_keys($sort_config_msg1,"颜色");
                               $size1 =  array_keys($sort_config_msg1,"尺碼");
                               $color1 =  array_keys($sort_config_msg1,"顏色");
                               $size2 =  array_keys($sort_config_msg1,"尺寸");
                               if(!empty($size) && !empty($color)){
                                   array_push($sort_config_msg,$color[0]);
                                   array_push($sort_config_msg,$size[0]);
                                   unset($sort_config_msg1[$color[0]]);
                                   unset($sort_config_msg1[$size[0]]);
                               }else if(!empty($size1) && !empty($color1)){
                                   array_push($sort_config_msg,$color1[0]);
                                   array_push($sort_config_msg,$size1[0]);
                                   unset($sort_config_msg1[$color1[0]]);
                                   unset($sort_config_msg1[$size1[0]]);
                               }else if(!empty($size2) && !empty($color)){
                                   array_push($sort_config_msg,$color[0]);
                                   array_push($sort_config_msg,$size2[0]);
                                   unset($sort_config_msg1[$color[0]]);
                                   unset($sort_config_msg1[$size2[0]]);
                               }

                               if(!empty($sort_config_msg1)){
                                   $arr = array_keys($sort_config_msg1);
                                   $config_attr = array_merge($sort_config_msg,$arr);
                               }else{
                                   $config_attr = $sort_config_msg;
                               }
                           }
                           if(!empty($config_attr)){
                               $orderarr = $config_attr;
                           }
                           $goods_kind_val_id = '';
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
                                   //===============================================
                                   //获取产品完整SKU
                                   $goods_kind_val_id .= $conmsg->kind_val_id.',';
                                   //================================================
                                   $config_val_msg = kind_val::where('kind_val_id',$conmsg->kind_val_id)->value('kind_val_msg');
                                   $kind_english_msg .= kind_val::where('kind_val_id',$conmsg->kind_val_id)->value('kind_val_english_msg');
                               }else{
                                   $config_val_msg = $conmsg['config_val_msg'];
                                   $kind_english_msg .= '';
                               }
                               $goods_msg .= $conmsg['config_val_msg'] . '-';
                               $kind_msg .= '<td>'.$config_val_msg.'</td>';
                           }
                           //使用产品属性id组合换取该属性SKU码
                           $all_sku=$skuSDK->get_all_sku(rtrim($goods_kind_val_id,','));
                           $goods_all_sku .= '<tr><td>' .$all_sku.'</td><td>';
                           $out_msg='<table>';
                           //拼接出库信息
                           $storage_check_data_id=$storage_check_data->storage_check_data_id;
                           $storage_check_info=\App\storage_check_info::select('storage_check_info_single','storage_check_info_num')->where([['storage_check_data_id',$storage_check_data_id],['storage_check_info_sku',substr($all_sku, -6)]])->get(); 
                           foreach($storage_check_info as $k_info => $v_info){
                           	 $out_msg.='<tr><td>'.$v_info->storage_check_info_single.'</td><td>'.$v_info->storage_check_info_num.'</td></tr>';
                           }
                           $out_msg.='</table>';
                           $goods_all_sku.=$out_msg.'</td></tr>';
                           //根据出仓数据条数合并单元格
                           if($storage_check_info->count()>1){
                           	$w_where=strripos($kind_msg,'<tr>');
                           	if($w_where){
                           		$w_str=substr($kind_msg, $w_where);
	                           	$w_str=str_replace('<td>', '<td rowspan="'.$storage_check_info->count().'">', $w_str);
	                           	$kind_msg=substr($kind_msg, 0,$w_where+1).$w_str.str_repeat('<tr></tr>', $storage_check_info->count()-1);
	                           }else{
	                           	$kind_msg=str_replace('<td>', '<td rowspan="'.$storage_check_info->count().'">', $kind_msg).str_repeat('<tr></tr>', $storage_check_info->count()-1);
	                           }
                           }
                           $config_msg .= '<tr>'.$kind_msg.'</tr>';
                           for ($i=0; $i <(int)$count[$keyss] ; $i++) {
                              $config_english_msg .= $kind_english_msg.',';
                               $goods_config_msg .= rtrim($goods_msg,'-').' ,';
                           }
                           /*$config_english_msg .= $kind_english_msg.'*'.$count[$keyss].',';*/
//                           if($count[$keyss] > 1){
//                               $goods_config_msg .= rtrim($goods_msg,'-').' * '. $count[$keyss] .' ,';
//                           }else{
//                               $goods_config_msg .= rtrim($goods_msg,'-').' ,';
//                           }
                       }
                       $new_exdata[$k]['config_msg'] = '<table border=1>'.$config_msg.'</table>';//dd($new_exdata[$k]['config_msg']);
                       if (rtrim($config_english_msg, ',') == '') {
                           $new_exdata[$k]['config_english_msg'] =  '';
                       } else {
                           if ($goods_kind->goods_kind_english_name) {
                               $new_exdata[$k]['config_english_msg'] =  $goods_kind->goods_kind_english_name . ',' . rtrim($config_english_msg, ',') ;
                           }else{
                               $new_exdata[$k]['config_english_msg'] = rtrim($config_english_msg, ',') ;
                           }
                       }
                       $new_exdata[$k]['goods_config_msg'] = rtrim($goods_config_msg,',');
                       //TODO sku
                       $new_exdata[$k]['get_all_sku'] = '<table border=1>'. $goods_all_sku.'</table>';
                   }else{
                       $new_exdata[$k]['config_msg'] = "暂无属性信息";
                       $new_exdata[$k]['config_english_msg'] = "暂无属性信息";
                       $new_exdata[$k]['goods_config_msg'] = "暂无属性信息";
                       $new_exdata[$k]['get_all_sku'] = $skuSDK->get_all_sku('');
                   }
                   if($storage_check_data->storage_abroad_id!='#'){
                   	   $new_exdata[$k]['storage_name'] = \App\storage::select('storage_name')->where('storage_id',$storage_check_data->storage_abroad_id)->first()['storage_name'];
                   }else{
                   	   $new_exdata[$k]['storage_name'] = \App\storage::select('storage_name')->where('is_local','1')->first()['storage_name'];
                   }
                   $new_exdata[$k]['remark'] = $v['order_remark'];
                   $new_exdata[$k]['order_pay_type'] = $v['order_pay_type'] == 0 ? '货到付款': '在线支付';
                   $new_exdata[$k]['admin_show_name'] = admin::where('admin_id',$v['order_goods_admin_id'])->value('admin_show_name');
               }
           }
         $filename='订单记录'.date('Y-m-d H:i:s',time()).'.xls';

       if($goods_blade_type == 6 || $goods_blade_type == 7){
           $zdname=['下单时间','订单编号','客户名字','客户电话','详细地址','地区','城市','县','邮寄地址','邮政编码','产品名称','产品英文名称','商品名','币种','总金额','数量','产品属性信息','产品英文属性信息','商品展示属性信息','出货信息','出货仓','备注','支付方式','商品所属人'];
       }else{
           $zdname=['下单时间','订单编号','客户名字','客户电话','详细地址','地区','城市','邮寄地址','邮政编码','产品名称','产品英文名称','商品名','币种','总金额','数量','产品属性信息','产品英文属性信息','商品展示属性信息','出货信息','出货仓','备注','支付方式','商品所属人'];
       }
        out_excil($new_exdata,$zdname,'訂單信息记录表',$filename);
    }
}
