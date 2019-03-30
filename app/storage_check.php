<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\channel\skuSDK;
class storage_check extends Model
{
    protected $table = 'storage_check';
    protected $primaryKey ='storage_check_id';
    public $timestamps = false;
     /**
     * 订单数据校准、扣货
     * @param  boolean $type [默认为校准，false为扣货操作]
     * @return [type]        [description]
     */
    public static function storage_center($type=true,$user=0)
    {
    	//检查锁状态
    	$storage_check_option=\App\storage_check_option::where('storage_check_option','1')->first();
    	if($storage_check_option==null){
    		\App\storage_check_option::insert(['storage_check_option'=>'1','storage_check_option_val'=>'1']);
    	}else{
    		if($storage_check_option=='1'){
    			return false;
    		}else{
    			\App\storage_check_option::where('storage_check_option','1')->update(['storage_check_option_val'=>'1']);
    		}
    	}
    	//开始处理逻辑
    	try{
    		$orders=\App\order::where([['order_type',1],['is_del','0']])->get();
	        //删除一天前的校准数据
	        $ids=\App\storage_check::select('storage_check_id')->where([['storage_check_time','<',date('Y-m-d H:i:s',time()-86400)],['storage_check_is_out',0]])->get()->toArray();
	        \App\storage_check::whereIn('storage_check_id',$ids)->delete();
	        \App\storage_check_data::whereIn('storage_primary_id',$ids)->delete();
	        \App\storage_check_lack::whereIn('storage_check_lack_primary_id',$ids)->delete();
	        //生成新的校准单
	        $storage_check=new \App\storage_check;
	        $storage_check->storage_check_time=date('Y-m-d H:i:s',time());
	        $storage_check->storage_check_string=time().mt_rand(100000,999999);
	        $storage_check->storage_check_admin=$user;
	        if($user==0){
	        	$storage_check->storage_check_type=0;
	        }else{
	        	$storage_check->storage_check_type=1;
	        }
	        $storage_check->storage_check_reload_time=date('Y-m-d H:i:s',time()+180);
	        if(!$type){
	        	$storage_check->storage_check_is_out='1';
	        }else{
	        	$storage_check->storage_check_is_out='0';
	        }
	        $storage_check->save(); 
	        //记录各属性对应数目数据
	        $goods_check_data=[];
	        //记录总体缺货数据
	        $goods_less_data=[];
	        //如果为校准操作开启事务
	        if($type)  \DB::beginTransaction();
	        //$storage_goods_abroad=\App\storage_goods_abroad::all();
	        //声明海外仓拆分情况下验证记录数据
	        $aborad_check_arr=[];
	        foreach($orders as $k => $v)
	        {   
	            //声明变量存放校准单数据
	           
	            //循环判断订单状态
	            $goods_kind=\App\goods_kind::
	            select('goods_kind_id','goods_kind_sku','goods_product_id','goods_kind_user_type')
	            ->where('goods_kind_id',\App\goods::select('goods_kind_id')->where('goods_id',$v->order_goods_id)->first()['goods_kind_id'])
	            ->first();
	            $goods_kind_id=$goods_kind->goods_kind_id;
	            
	            //实例化SKU复制SDK
	            $skuSDK=new skuSDK($goods_kind_id,$goods_kind->goods_product_id,$goods_kind->goods_kind_user_type);
	            $blade_type=\App\goods::select('goods_blade_type')->where('goods_id',$v->order_goods_id)->first()['goods_blade_type'];
	            if($blade_type=='16'||$blade_type=='17'){
	                switch ($v->order_country) {
	                    case 'Saudi Arabia':
	                        $blade_type=12;
	                        break;
	                    case 'United Arab Emirates':
	                        $blade_type=2;
	                        break;
	                    case 'Qatar':
	                        $blade_type=14;
	                        break;
	                    default:
	                        $error = '中东地区未匹配';  
	                        throw new \Exception($error);  
	                        break;
	                }
	             }else{
	                $blade_type=self::get_storage_area($blade_type);
	             }
	            //找到对应国外仓库
	            $storage=\App\storage::where([['template_type_primary_id',$blade_type],['storage_status',1],['is_local',0]])->first();
	            //证明没有对应海外仓
	            $order_config=\App\order_config::select('order_primary_id','order_config')->where('order_primary_id',$v->order_id)->get()->toArray();
                //处理数据变更属性组加数目
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
                foreach($new as $kk => $vv){
                    $new[$kk]['num']=$count[$kk];
                }
                $order_config=$new;
                unset($new,$count);
                //处理属性数据拼装产品属性id与SKU
                $is_new=true;//判断该单品是否配置新属性，如未配置新属性则无产品对应，SKU属性码为000000
                
                //为订单属性分配属性SKU与属性件数
                foreach($order_config as $kkk=> $v_config){
                    $order_config_arr=explode(',', $order_config[$kkk]['order_config']);
                    if(count($order_config_arr)<=0){
                        $order_config[$kkk]['sku']='000000';
                        continue;
                    }
                    foreach($order_config_arr as $kkkk => $v_config_arr)
                    {
                        $config_val=\App\config_val::where([['config_val_id',$v_config_arr],['kind_val_id','>',0]])->first();
                        if($config_val==null){
                            //没有对应属性id信息
                            $is_new=false;
                            $order_config[$kkk]['kind_val_arr']=null;
                            break;
                        }
                        //向订单属性配置数据中增加对应产品属性的id
                        $order_config[$kkk]['kind_val_arr'][$kkkk]=$config_val['kind_val_id'];
                        $order_config_arr[$kkkk]=$config_val['kind_val_id'];
                    }
                    if(!$is_new){//属性未更新
                        $order_config[$kkk]['sku']='000000';
                        continue;
                    }
                     //为订单属性分配属性SKU
                    if(!isset($order_config[$kkk]['sku'])||$order_config[$kkk]['sku']!='000000'){
                         $sku=$skuSDK->get_all_sku($order_config_arr);
                         $order_config[$kkk]['sku']=substr($sku,4);
                    }
                }
	            if($storage!=null){
	                //声明便令记录改订单是否可从国外仓发送状态
	                $is_send=true;
	                //获取订单配置信息数据
	                
	                $is_out=true;//判断
	                $is_forigen=true;//判断是否可以从海外仓发货
	                foreach($order_config as $kkk => $v_config){
	                    /////////////////////////////////////////////////////
	                    //sku获取逻辑完成,开始处理订单
	                    //1.判断订单状态（是否从海外仓发货）
	                    $is_split=$storage->is_split;
	                    $storage_id=$storage->storage_id;
	                    $order_config_sku=$v_config['sku'];//改属性SKU码
	                    if($is_split=='1'){
	                        //当海外仓允许拆分时
	                        //1.初始化要填充的数据
	                        $goods_check_data[$v->order_id][$kkk]['storage_check_data_order']=$v->order_id;
	                        $goods_check_data[$v->order_id][$kkk]['storage_check_data_sku']=$goods_kind->goods_kind_sku;
	                        $goods_check_data[$v->order_id][$kkk]['storage_check_data_num']=$v_config['num'];
	                        $goods_check_data[$v->order_id][$kkk]['storage_primary_id']=$storage_check->storage_check_id;
	                        $goods_check_data[$v->order_id][$kkk]['storage_check_data_sixsku']=$order_config_sku;
	                        $goods_check_data[$v->order_id][$kkk]['storage_check_data_type']='1';
	                        if(!array_key_exists($v->order_id, $aborad_check_arr)||!$aborad_check_arr[$v->order_id]){
	                        	 //2.判断海外仓中对应产品的对应属性的货物数目是否足够
		                         $aborad=true;
		                         foreach($order_config as $k_check => $v_check){
		                        	$use_config=$v_check['sku'];
		                        	$max_num=\App\storage_goods_abroad::select(\DB::raw('SUM(num) as num'))
		                                ->where(function($query)use($use_config,$storage_id,$goods_kind_id){
		                                    $query->where('sku_data', $use_config);
		                                    $query->where('storage_primary_id', $storage_id);
		                                    $query->where('goods_kind_id', $goods_kind_id);
		                                    $query->where('expiry_at','>',date('Y-m-d H:i:s',time()));
		                                    $query->where('num','>',0);
		                                })
		                                ->first();
		                               if($max_num['num']<$v_check['num']){
				                            //海外仓对应属性的货物数目总和不足这条属性信息的数目，无法从海外仓发货
				                            $aborad=false;
				                            $is_forigen=false;
				                            break;
				                        } 
		                         }
		                         if(!$aborad){
		                        	$is_forigen=false;
		                        	break;
	                       		 }else{
	                       		 	//记录验证成功状态
	                       		 	$aborad_check_arr[$v->order_id]=true;
	                       		 } 
	                        }
	                        //3.循环扣除货物
	                        $goods_check_data[$v->order_id][$kkk]['storage_abroad_id']=$storage_id;
	                        $storage_goods_abroad=\App\storage_goods_abroad::select('order_id','order_single','sku','sku_data','goods_kind_id','num')
	                                ->where(function($query)use($order_config_sku,$storage_id,$goods_kind_id){
	                                    $query->where('sku_data', $order_config_sku);
	                                    $query->where('storage_primary_id', $storage_id);
	                                    $query->where('goods_kind_id', $goods_kind_id);
	                                    $query->where('expiry_at','>',date('Y-m-d H:i:s',time()));
	                                    $query->where('num','>',0);
	                                })
	                                ->get();
	                        $need_num=$v_config['num'];//当前所需货物数目
	                        foreach($storage_goods_abroad as $k_abroad=>$v_abroad){//if($v->order_id==283&&$v_config['sku']=='900100') dd($v_abroad,$storage_goods_abroad,$order_config,$v_config);
	                            //if($need_num<=0) continue;
	                            $old_num=$need_num;
	                            $need_num=$need_num-$v_abroad->num;
	                            //记录被扣货订单、被扣货数目、被扣货sku
	                            $goods_check_data[$v->order_id][$kkk]['storage_from'][$k_abroad]['order_id']=$v_abroad['order_id'];
	                            $goods_check_data[$v->order_id][$kkk]['storage_from'][$k_abroad]['order_single']=$v_abroad['order_single'];
	                            $goods_check_data[$v->order_id][$kkk]['storage_from'][$k_abroad]['sku_data']=$v_abroad->sku_data;
	                            if($need_num<=0){
	                                //已扣除完毕，跳出循环
	                                 $goods_check_data[$v->order_id][$kkk]['storage_from'][$k_abroad]['num']=$need_num+$v_abroad->num;
	                                 \App\storage_goods_abroad::where([['order_id',$v_abroad->order_id],['sku_data',$v_abroad->sku_data]])->update(['num'=>$v_abroad->num-$old_num]);
	                                 //$v_abroad->update(['num'=>$v_abroad->num-$need_num]);
	                                 break;
	                            }else{
	                                 $goods_check_data[$v->order_id][$kkk]['storage_from'][$k_abroad]['num']=$v_abroad->num;
	                                 \App\storage_goods_abroad::where([['order_id',$v_abroad->order_id],['sku_data',$v_abroad->sku_data]])->update(['num'=>0]);
	                                 //$v_abroad->update(['num'=>0]);
	                            }
	                        }
	                        //dd($goods_check_data);
	                    }else{
	                        //当海外仓不允许拆分时
	                        $is_nosplit=false;//记录是否有符合条件的订单，默认为false
	                        $all_sum=\App\storage_goods_abroad::select('storage_goods_abroad.order_id',\DB::Raw('SUM(num) AS num'))
	                                            ->where(function($query)use($order_config_sku,$storage_id,$goods_kind_id){
	                                                $query->where('storage_primary_id', $storage_id);
	                                                $query->where('goods_kind_id', $goods_kind_id);
	                                                $query->where('expiry_at','>',date('Y-m-d H:i:s',time()));
	                                            })
	                                            ->groupBy('order_id')
	                                            ->get();        
	                        foreach($all_sum as $k_num => $v_num){
	                            $order_num_all=array_sum(array_map(function($val){return $val['num'];}, $order_config));
	                            //订单数量总数匹配
	                            if($order_num_all==$v_num->num){
	                                $is_nosplit=true;
	                                break;
	                            }
	                        }
	                        if(!$is_nosplit){
	                            $is_forigen=false;
	                            break;
	                        }
	                        //订单属性匹配
	                        $storage_goods_abroad=\App\storage_goods_abroad::
	                                            where(function($query)use($order_config_sku,$storage_id,$goods_kind_id){
	                                                $query->where('storage_primary_id', $storage_id);
	                                                $query->where('goods_kind_id', $goods_kind_id);
	                                                $query->where('expiry_at','>',date('Y-m-d H:i:s',time()));
	                                            })
	                                            ->get()
	                                            ->groupBy('order_id')
	                                            ->toArray();
	                        $is_same=false;
	                        // dd($storage_goods_abroad);
	                        //dd($order_config,$storage_goods_abroad);
	                        foreach($storage_goods_abroad as $k_abroad => $v_abroad){
	                            //当产品属性数据条数不一样时跳过循环
	                            if(count($order_config)!=count($v_abroad))  continue;
	                            //数量与SKU码完全匹配,更改状态并记录数据
	                            if(array_column($order_config,'num','sku')==array_column($v_abroad, 'num','sku_data')){
	                                \App\storage_goods_abroad::where('order_id',$k_abroad)->update(['num'=>0]);
	                                $is_same=true;
	                                //重新宾壮填充数据数租
	                                //$goods_check_data[$v->order_id]['no_split']['storage_check_data_sixsku']=$order_config_sku;
	                                $goods_check_data[$v->order_id]['no_split']['storage_check_data_order']=$v->order_id;
	                                $goods_check_data[$v->order_id]['no_split']['storage_check_data_sku']=$goods_kind->goods_kind_sku;
	                                $goods_check_data[$v->order_id]['no_split']['storage_check_data_num']=$v->order_num;
	                                $goods_check_data[$v->order_id]['no_split']['storage_primary_id']=$storage_check->storage_check_id;
	                                $goods_check_data[$v->order_id]['no_split']['storage_abroad_id']=$storage_id;
	                                $goods_check_data[$v->order_id]['no_split']['storage_from']=$k_abroad;
	                                $goods_check_data[$v->order_id]['no_split']['storage_check_data_type']='2';
	                                break;
	                            }
	                        }
	                        //海外仓数据循环完毕仍无发现匹配订单，结束order_config循环并标记为无法从海外仓发货
	                        if(!$is_same){
	                            $is_forigen=false;
	                            break;
	                        }
	                    }

	                }//结束该订单在海外仓的数据处理
	            }else{
	                $is_forigen=false;
	            }
	            //无法从海外仓发货,开始处理本地仓数据
	            unset($is_same,$is_nosplit,$all_sum,$storage_goods_abroad,$is_split,$order_config_sku,$config_val);
	            if(!$is_forigen){
	                //找到国内仓
	                $storage=\App\storage::where([['is_local','1'],['storage_status','1']])->orderBy('created_at','asc')->first();
	                //声明标记标记国内仓数目是否足够
	                $is_ennugh=true; 
	                foreach($order_config as  $v_config){
	                    $storage_data_local=\App\storage_goods_local::where([['storage_primary_id',$storage->storage_id],['goods_kind_id',$goods_kind->goods_kind_id],['sku_attr',$v_config['sku']],['sku',$goods_kind->goods_kind_sku]])->first(['num']);
	                    if($storage_data_local==null||$storage_data_local['num']<$v_config['num']){
	                        $is_ennugh=false;
	                        break;
	                    }
	                }
	               if($is_ennugh){
	                    //该订单所有属性的数目都足够，可以从本地仓发货
	                    foreach($order_config as $k_config => $v_config){
	                        $storage_data_local=\App\storage_goods_local::where([['storage_primary_id',$storage->storage_id],['goods_kind_id',$goods_kind->goods_kind_id],['sku_attr',$v_config['sku']],['sku',$goods_kind->goods_kind_sku]])->first(['num']);
	                        //减去本地仓库存
	                        \App\storage_goods_local::where([['storage_primary_id',$storage->storage_id],['goods_kind_id',$goods_kind->goods_kind_id],['sku_attr',$v_config['sku']],['sku',$goods_kind->goods_kind_sku]])->update(['num'=>$storage_data_local['num']-$v_config['num']]);
	                        //记录总缺货数据(剩余库存不参与统计，在储存时需要减去)
	                         if(!isset($goods_less_data[$goods_kind->goods_kind_sku])){
	                            $goods_less_data[$goods_kind->goods_kind_sku]=[];
	                         }
	                         if(!isset($goods_less_data[$goods_kind->goods_kind_sku][$v_config['sku']])){
	                            $goods_less_data[$goods_kind->goods_kind_sku][$v_config['sku']]=$v_config['num'];
	                         }else{
	                            $goods_less_data[$goods_kind->goods_kind_sku][$v_config['sku']]+=$v_config['num'];
	                         }         
	                    }   
	                    //生成填充数据           
	                    $goods_check_data[$v->order_id]['local']['storage_check_data_type']='3';
	                    $goods_check_data[$v->order_id]['local']['storage_check_data_order']=$v->order_id;
	                    $goods_check_data[$v->order_id]['local']['storage_check_data_from']=$order_config;
	                    $goods_check_data[$v->order_id]['local']['storage_check_data_num']=$v->order_num;
	                    $goods_check_data[$v->order_id]['local']['storage_check_data_sku']=$goods_kind->goods_kind_sku;
	                    $goods_check_data[$v->order_id]['local']['storage_primary_id']=$storage->storage_id; 
	               }else{
	                //货物不足,计算缺货数据
	                    $goods_check_data[$v->order_id]['local_less']['storage_check_data_type']='4';
	                    $goods_check_data[$v->order_id]['local_less']['storage_check_data_order']=$v->order_id;
	                    $goods_check_data[$v->order_id]['local_less']['storage_check_data_from']='#';
	                    $goods_check_data[$v->order_id]['local_less']['storage_check_data_num']=$v->order_num;
	                    $goods_check_data[$v->order_id]['local_less']['storage_check_data_sku']=$goods_kind->goods_kind_sku;
	                    $goods_check_data[$v->order_id]['local_less']['storage_primary_id']=$storage->storage_id;
	                    foreach($order_config as $k_config => $v_config){
	                         //获取改属性货物所剩数目
	                         $storage_data_local=\App\storage_goods_local::where([['storage_primary_id',$storage->storage_id],['goods_kind_id',$goods_kind->goods_kind_id],['sku_attr',$v_config['sku']],['sku',$goods_kind->goods_kind_sku]])->first(['num']);
	                         if($storage_data_local==null){
	                            $storage_data_local_num=0;
	                         }else{
	                            $storage_data_local_num=$storage_data_local['num'];
	                         }
	                         //记录缺货数据
	                         $goods_check_data[$v->order_id]['local_less']['data'][$k_config]['sku']=$v_config['sku'];
	                         /* if($v_config['num']-$storage_data_local_num<0) dd($v_config['num'],$storage_data_local_num,$order_config,$v_config);*/
	                         $goods_check_data[$v->order_id]['local_less']['data'][$k_config]['num']=$v_config['num']-$storage_data_local_num;
	                         //记录总缺货数据(剩余库存不参与统计，在储存时需要减去)
	                         if(!isset($goods_less_data[$goods_kind->goods_kind_sku])){
	                            $goods_less_data[$goods_kind->goods_kind_sku]=[];
	                         }
	                         if(!isset($goods_less_data[$goods_kind->goods_kind_sku][$v_config['sku']])){
	                            $goods_less_data[$goods_kind->goods_kind_sku][$v_config['sku']]=$v_config['num'];
	                         }else{
	                            $goods_less_data[$goods_kind->goods_kind_sku][$v_config['sku']]+=$v_config['num'];
	                         }          
	                    }  
	               }
	            }//结束该订单在国内仓的数据处理
	            unset($skuSDK); 
	        }//结束订单循环                
	        //根据状态判断是否为出库操作，不是则回滚数据库
	        if($type){
	            \DB::rollback();
	        } else{
	            \DB::commit();
	        }
    	}catch(\Exception $e){
    		$storage_check->delete();
    		  //记录报错
            \Log::info('仓储数据校准失败,admin_id'.\Auth::user()->admin_id.'内容'.$e->getMessage());
            //关闭锁
    		\App\storage_check_option::where('storage_check_option','1')->update(['storage_check_option_val'=>'0']);
    		 return false;
    	}
        //开始储存数据
        //1.存储校对单
        $storage_check_id=$storage_check->storage_check_id;
        //2.存储校对单总体缺货数据
        $storag_local=\App\storage::where([['is_local','1'],['storage_status','1']])->orderBy('created_at','asc')->first(['storage_id']);
        foreach($goods_less_data as $k => $v){
            foreach($v as $key => $val){
                $storage_check_lack=new \App\storage_check_lack;
                $storage_check_lack->storage_check_lack_sku=$k;
                $storage_check_lack->storage_check_lack_six_sku=$key;
                $storage_check_lack->storage_check_lack_primary_id=$storage_check->storage_check_id;
                $storage_goods_local_num=\App\storage_goods_local::where([['storage_primary_id',$storag_local['storage_id']],['sku',$k],['sku_attr',$key]])->first(['num']);
                if($storage_goods_local_num==null){
                    $local_num=0;
                }else{
                    $local_num=$storage_goods_local_num['num'];
                }
                $num=$val-$local_num;
                $storage_check_lack->storage_check_lack_num=$num;
                if($num>0)      $storage_check_lack->save();
            }
        }
        //3.存储校对单数据
        \DB::beginTransaction();
        try{
            foreach($goods_check_data as $k => $v){
                $order_id=$k;
                if(isset($v['no_split'])){
                    //海外仓不拆分发货订单
                    $storage_check_data=new \App\storage_check_data;
                    $storage_check_data->storage_check_data_type=$v['no_split']['storage_check_data_type'];
                    $storage_check_data->storage_check_data_order=$k;
                    $storage_check_data->storage_check_data_num=$v['no_split']['storage_check_data_num'];
                    $storage_check_data->storage_check_data_sku=$v['no_split']['storage_check_data_sku'];
                    $storage_check_data->storage_primary_id=$storage_check_id;
                    $storage_check_data->storage_abroad_id=$v['no_split']['storage_abroad_id'];
                    $storage_check_data->save();
                    if(!$type){
	                    //\App\order::where('order_id',$k)->update(['order_type'=>3,]);
	                    $order_update= \App\order::where('order_id',$k)->first();
	                    $order_update->order_type=3;
	                    $order_update->order_return= $order_update->order_return."<p style='text-align:center'>[".date('Y-m-d H:i:s')."] ".\Auth::user()->admin_name."：订单从海外仓不拆分扣货</p>";
	                    $order_update->save();
                    }
                    unset($goods_check_data[$k]);
                    $froms=\App\storage_goods_abroad::where('order_id',$v['no_split']['storage_from'])->get();
                    foreach($froms as $key => $val){
                        //记录该订单货物属性数目等数据
                        $storage_check_info=new \App\storage_check_info;
                        if($storage_check_info->storage_check_info_single=\App\order::where('order_id',$v['no_split']['storage_from'])->first(['order_single_id'])['order_single_id']==null){
                              $storage_check_info->storage_check_info_single=\App\storage_goods_abroad::where('order_id',$v['no_split']['storage_from'])->first(['order_single'])['order_single'];
                        }
                        $storage_check_info->storage_check_info_order=$v['no_split']['storage_from'];
                        $storage_check_info->storage_check_info_num=$val->num;
                        $storage_check_info->storage_check_info_sku=$val->sku_data;
                        $storage_check_info->storage_check_data_id=$storage_check_data->storage_check_data_id;
                        $storage_check_info->save();
                    }
                    continue;
                }
                if(isset($v['local'])){
                   //处理本地仓发货订单数据
                    $storage_check_data=new \App\storage_check_data;
                    $storage_check_data->storage_check_data_type=$v['local']['storage_check_data_type'];
                    $storage_check_data->storage_check_data_order=$k;
                    $storage_check_data->storage_abroad_id='#';
                    $storage_check_data->storage_primary_id=$storage_check_id;
                    $storage_check_data->storage_check_data_num=$v['local']['storage_check_data_num'];
                    $storage_check_data->storage_check_data_sku=$v['local']['storage_check_data_sku'];
                    $storage_check_data->save();
                    if(!$type){
	                    //\App\order::where('order_id',$k)->update(['order_type'=>3]);
	                    $order_update= \App\order::where('order_id',$k)->first();
	                    $order_update->order_type=3;
	                    $order_update->order_return= $order_update->order_return."<p style='text-align:center'>[".date('Y-m-d H:i:s')."] ".\Auth::user()->admin_name."：订单从本地仓扣货</p>";
	                    $order_update->save();
                    }
                    foreach($v['local']['storage_check_data_from'] as $key => $val){
                        //记录该订单货物属性数目等数据
                        $storage_check_info=new \App\storage_check_info;
                        $storage_check_info->storage_check_info_single='#';
                        $storage_check_info->storage_check_info_order='#';
                        $storage_check_info->storage_check_info_num=$val['num'];
                        $storage_check_info->storage_check_info_sku=$val['sku'];
                        $storage_check_info->storage_check_data_id=$storage_check_data->storage_check_data_id;
                        $storage_check_info->save();
                    }
                    continue;
                }
                if(isset($v['local_less'])){
                     //处理货物不足
                    $storage_check_data=new \App\storage_check_data;
                    $storage_check_data->storage_check_data_type=$v['local_less']['storage_check_data_type'];
                    $storage_check_data->storage_check_data_order=$k;
                    $storage_check_data->storage_abroad_id='#';
                    $storage_check_data->storage_primary_id=$storage_check_id;
                    $storage_check_data->storage_check_data_num=$v['local_less']['storage_check_data_num'];
                    $storage_check_data->storage_check_data_sku=$v['local_less']['storage_check_data_sku'];
                    $storage_check_data->save();
                    $order_update= \App\order::where('order_id',$k)->first();
	                $order_update->order_return= $order_update->order_return."<p style='text-align:center'>[".date('Y-m-d H:i:s')."] ".\Auth::user()->admin_name."：订单扣货失败，货物不足</p>";
	                $order_update->save();
                    foreach($v['local_less']['data'] as $key => $val){
                        //记录该订单货物属性数目等数据
                        $storage_check_info=new \App\storage_check_info;
                        $storage_check_info->storage_check_info_single='#';
                        $storage_check_info->storage_check_info_order='#';
                        $storage_check_info->storage_check_info_num=$val['num'];
                        $storage_check_info->storage_check_info_sku=$val['sku'];
                        $storage_check_info->storage_check_data_id=$storage_check_data->storage_check_data_id;
                        $storage_check_info->save();
                    }
                    continue;
                }
                 //处理海外仓拆分发货订单数据
                $storage_check_data=new \App\storage_check_data;
                $storage_check_data->storage_check_data_type=$v[0]['storage_check_data_type'];
                $storage_check_data->storage_check_data_order=$v[0]['storage_check_data_order'];
                $storage_check_data->storage_abroad_id=$v[0]['storage_abroad_id'];
                $storage_check_data->storage_primary_id=$storage_check_id;
                $storage_check_data->storage_check_data_num=$v[0]['storage_check_data_num'];
                $storage_check_data->storage_check_data_sku=$v[0]['storage_check_data_sku'];
                $storage_check_data->storage_check_data_sixsku='#'; 
                $storage_check_data->save();
                if(!$type){
	                    //\App\order::where('order_id',$v[0]['storage_check_data_order'])->update(['order_type'=>3]);
	                    $order_update= \App\order::where('order_id',$v[0]['storage_check_data_order'])->first();
	                    $order_update->order_type=3;
	                    $order_update->order_return= $order_update->order_return."<p style='text-align:center'>[".date('Y-m-d H:i:s')."] ".\Auth::user()->admin_name."：订单从海外仓拆分扣货</p>";
	                    $order_update->save();
                    }
                foreach($v as $key => $val){
                    foreach($val['storage_from'] as $k_from => $v_from){
                        $storage_check_info=new \App\storage_check_info;
                        $storage_check_info->storage_check_info_order=$v_from['order_id'];
                        $storage_check_info->storage_check_info_single=$v_from['order_single'];
                        $storage_check_info->storage_check_info_sku=$v_from['sku_data'];
                        $storage_check_info->storage_check_info_num=$v_from['num'];
                        $storage_check_info->storage_check_data_id=$storage_check_data->storage_check_data_id;
                        $storage_check_info->save();
                    }
                }
            }
        }catch(\Exception $e){
            \DB::rollback();
            $storage_check->delete();
            \Log::info('仓储数据校准失败,admin_id'.\Auth::user()->admin_id.'内容'.$e->getMessage());
            //数据操作日志记录
	        $arr=['storage_log_type'=>4,'storage_log_operate_type'=>0,'is_danger'=>0,'storage_log_admin_id'=>$user];
	        if(!$type){
	        	$arr['storage_log_type']=5;
	        	$arr['is_danger']=1;
	        } 
	        $data=['is_success'=>0];
	        \App\storage_log::insert_log($arr,serialize($data));
            //关锁
            \App\storage_check_option::where('storage_check_option','1')->update(['storage_check_option_val'=>'0']);
           return false;
        }
        //关锁
        \App\storage_check_option::where('storage_check_option','1')->update(['storage_check_option_val'=>'0']);
        \DB::commit();
        //数据操作日志记录
        $arr=['storage_log_type'=>4,'storage_log_operate_type'=>0,'is_danger'=>0,'storage_log_admin_id'=>$user];
        if(!$type){
        	$arr['storage_log_type']=5;
	        	$arr['is_danger']=1;
        } 
        $data=['is_success'=>1,'storage_check_id'=>$storage_check->storage_check_id,'storage_check_string'=>$storage_check->storage_check_string];
        \App\storage_log::insert_log($arr,serialize($data));
        return true;
    }
        /**
     * 根据订单所属单品模板地区获取订单所属仓库地区
     * @param  \Illuminate\Database\Eloquent\Collection $blade_type [description]
     * @return [type]                                               [description]
     */
    private static function get_storage_area( $type)
    {
        $arr=[
            0=>0,
            1=>0,
            2=>2,
            3=>3,
            4=>4,
            5=>5,
            6=>6,
            7=>7,
            8=>8,
            9=>10,
            10=>10,
            11=>11,
            12=>12,
            13=>12,
            14=>14,
            15=>14
        ];
        return $arr[$type];
    }
}
