<?php
namespace App\channel;

use App\goods_kind;
use App\kind_val;
use App\price;
use Excel;

class excelData{
    /** Excel导出菲律宾数据
     * @param $data
     * @return array
     */
    public static function flb($data){
        $cellData[] = ['Client（客户）','Sender`s Name（寄件人）','Sender Mobile No.（手机）','Landline of Sender（固话）','Sender Address（寄件人地址）','Order Number(平台订单号）','Receiver`s Name（收件人）','Receiver`s Mobile No.（收件人手机）','Landline of Receiver（收件人固话）','Receiver`s Address（收件人详细地址）','Provincal（收件省份）','city（收件城市）','Bray(地区）','Item Value（物品价值）','COD（代收货款）','Remark（备注）','remark1（备注一）'];
        foreach($data as $k => $v) {
            $exdata = [];
            //Client（客户）
            $exdata[] = 'ORIENTAL MAGIC HEALTH PTE.LTD.';

            //Sender`s Name（寄件人）
            $exdata[] = 'ORIENTAL MAGIC HEALTH PTE.LTD.';

            //Sender Mobile No.（手机）
            $exdata[] = '18739903577';

            //Landline of Sender（固话）
            $exdata[] = '18739903577';

            //Sender Address（寄件人地址）
            $exdata[] = '152 Beach Road, Singapore 189721';

            //Order Number(平台订单号）
            $exdata[] = $v['order_single_id'];

            //Receiver`s Name（收件人）
            $exdata[] = $v['order_name'];

            //Receiver`s Mobile No.（收件人手机）
            $exdata[] = $v['order_tel'];

            //Landline of Receiver（收件人固话）
            $exdata[] = $v['order_tel'];

            //Receiver`s Address（收件人详细地址）
            if ($v['order_zip']) {
                $str = $v['order_add'];
                $pattern = '/(.*)\(Zip:(.*?)\)/';
                preg_match_all($pattern, $str, $p);
                $area_info = (isset($p[1][0]) && $p[1][0]) ? $p[1][0] : $v['order_add'];
                $exdata[] = $v['order_state'] . ' ' . $v['order_city'] . '(' . $area_info . ')';
                $exdata[] = $v['order_state'];
                $exdata[] = $v['order_city'];
                $exdata[] = 0;
            } else {
                $str = $v['order_add'];
                $pattern = '/(.*)\(Zip:(.*?)\)/';
                preg_match_all($pattern, $str, $p);
                $area_info = (isset($p[1][0]) && $p[1][0]) ? $p[1][0] : $v['order_add'];
                $exdata[] = $v['order_state'] . ' ' . $v['order_city'] . '(' . $area_info . ')';
                $exdata[] = $v['order_state'];
                $exdata[] = $v['order_city'];
                $exdata[] = 0;
            }
            //Item Value（物品价值）
            $exdata[] = $v['order_price'];

            //COD（代收货款）.
            $exdata[] = $v['order_pay_type'] == 0 ? $v['order_price'] : 0;

            //Remark（备注）
            $order_config = \App\order_config::where('order_primary_id', $v['order_id'])->get();
            if ($order_config->count() > 0) {
                $config_msg = goods_kind::where('goods_kind_id',$v['goods_kind_id'])->value('goods_kind_name');//产品属性
                $i = 0;
                foreach ($order_config as $va) {
                    $i++;
                    $orderarr = explode(',', $va['order_config']);
                    $config_val = '';
                    foreach ($orderarr as $key => $val) {
                        $conmsg = \App\config_val::where('config_val_id', $val)
                            ->where(function ($query) use ($v) {
                                if ($v['goods_is_update'] == '1') {
                                    $query->where('kind_val_id', '>', 0);
                                }
                            })
                            ->first();
                        if ($conmsg == null) {
                            $conmsg = \App\config_val::where('config_val_id', $val)->first();
                        }
                        if (isset($conmsg->kind_val_id) && $conmsg->kind_val_id) {
                            $config_val_msg = kind_val::where('kind_val_id', $conmsg->kind_val_id)->value('kind_val_msg');
                        } else {
                            $config_val_msg = $conmsg['config_val_msg'];
                        }
                        $config_val .= $config_val_msg;
                    }
                    $config_msg .= $config_val;
                }
                $special = price::where('price_id',$v['order_price_id'])->value('price_name');
                if($special){
                    $config_msg .= '赠：'.$special;
                }
                $exdata[] = $config_msg;
            } else {
                $exdata[] = "暂无属性信息";
            }

            //remark1（备注一）
            $exdata[] = $v['order_remark'];

            array_push($cellData,$exdata);
        }
        return $cellData;
    }

    /** Excel导出中东数据
     * @param $data
     */
    public static function zd($data,$filename){
       $cellData[] = ['Consignee','ConsigneeName','ConsigneeAddress1','ConsigneeAddress2','ConsigneeCity','ConsigneePhone','ConsigneeTel','Origin','Destination','Zipcode','TotalWeight','noofpieces','weight','product','ServiceType','customnote','GoodsDesc','PCS','ValueOfShipment','ShipperRef','Description','Retail Code','AgentCode','InAmt','transportMode','WithBattery'];

       foreach($data as $k => $v) {
           $exdata = [];
           //Consignee(收件公司)
           $exdata[1] = 'First Flight Couriers (Middle East) LLC';

           //ConsigneeName(收件人)
           $exdata[2] = $v['order_name'];

           //ConsigneeAddress1
           if ($v['order_zip']) {
               $str = $v['order_add'];
               $pattern = '/(.*)\(Zip:(.*?)\)/';
               preg_match_all($pattern, $str, $p);
               $area_info = (isset($p[1][0]) && $p[1][0]) ? $p[1][0] : $v['order_add'];
               $exdata[3] = $v['order_state'] . ' ' . $v['order_city'] . '(' . $area_info . ')';
               //ConsigneeAddress2
               $exdata[4] = '';
               //ConsigneeCity
               $exdata[5] = $v['order_city'];
           } else {
               $str = $v['order_add'];
               $pattern = '/(.*)\(Zip:(.*?)\)/';
               preg_match_all($pattern, $str, $p);
               $area_info = (isset($p[1][0]) && $p[1][0]) ? $p[1][0] : $v['order_add'];
               $exdata[3] = $v['order_state'] . ' ' . $v['order_city'] . '(' . $area_info . ')';
               //ConsigneeAddress2
               $exdata[4] = '';
               //ConsigneeCity
               $exdata[5] = $v['order_city'];
           }
           //ConsigneePhone
           $exdata[6] = $v['order_tel'];
           //ConsigneeTel
           $exdata[7] = $v['order_tel'];
           //Origin
           $exdata[8] = 'CZX';
           //Destination
           $exdata[9] = 'AE1';
           //Zipcode
           $exdata[10] = '51000';
           $w = goods_kind::where('goods_kind_id',$v['goods_kind_id'])->value('goods_buy_weight');//产品属性
           $num = $v['order_num'];
           //TotalWeight
           $exdata[11] = $num*$w;
           //noofpieces
           $exdata[12] = '1';
           //weight
           $weight = floatval($w);
           if($num>1 && $w != 0){
               for($i = 1; $i < $num; $i++){
                   $weight .= ','.floatval($weight);
               }
           }else{
               $weight = '';
           }
           $exdata[13] = $weight;

           //product
           $exdata[14] = 'XPS';

           //ServiceType
           $exdata[15] = $v['order_pay_type'] == 0 ? 'NCND' : 'NOR';

           //customnote
           $exdata[16] = '';

           //GoodsDesc
           $order_config = \App\order_config::where('order_primary_id', $v['order_id'])->get();
           if ($order_config->count() > 0) {
               $config_msg = '';
               $msg = goods_kind::where('goods_kind_id',$v['goods_kind_id'])->value('goods_kind_name');//产品属性
               $i = 0;
               foreach ($order_config as $va) {
                   $i++;
                   $orderarr = explode(',', $va['order_config']);
                   $config_val = '';
                   foreach ($orderarr as $key => $val) {
                       $conmsg = \App\config_val::where('config_val_id', $val)
                           ->where(function ($query) use ($v) {
                               if ($v['goods_is_update'] == '1') {
                                   $query->where('kind_val_id', '>', 0);
                               }
                           })
                           ->first();
                       if ($conmsg == null) {
                           $conmsg = \App\config_val::where('config_val_id', $val)->first();
                       }
                       if (isset($conmsg->kind_val_id) && $conmsg->kind_val_id) {
                           $config_val_msg = kind_val::where('kind_val_id', $conmsg->kind_val_id)->value('kind_val_msg');
                       } else {
                           $config_val_msg = $conmsg['config_val_msg'];
                       }
                       $config_val .= $config_val_msg;
                   }
                   $config_msg .= $msg.' '.$config_val.'*1,';
               }
               $config_msg = rtrim($config_msg,',');
               $exdata[17] = $config_msg;
           } else {
               $exdata[17] = "";
           }


           //PCS
           $pcs = '1';
           if($num>1){
               for($i = 1; $i < $num; $i++){
                   $pcs .= ' 1';
               }
           }

           $exdata[18] = $pcs;

           //ValueOfShipment
           $exdata[19] = '';

           //ShipperRef
           $exdata[20] = '';

           //Description
           $exdata[21] = '';

           //Retail Code
           $exdata[22] = '';

           //AgentCode
           $exdata[23] = 'FF';

           //InAmt
           $exdata[24] = '';

           //transportMode
           $exdata[25] = '5000';

           //WithBattery
           $exdata[26] = '0';
           array_push($cellData,$exdata);
       }

       // 菜单 样式
       Excel::create($filename,function($excel) use ($cellData,$filename){
           $excel->sheet($filename, function($sheet) use ($cellData) {
               $sheet->rows($cellData);
               $i = 1;
               foreach ($cellData as $k=>$value) {
                   $tel = $value[6];
                   if(strlen($tel) == 9){
                       $tel = '971'.$tel;
                       $sheet->cell('F'.$i,$tel);
                       $sheet->cell('G'.$i,$tel);
                   }
                   if(strlen($tel) == 12 && substr($tel, 0, 3) != '971' && $i != 1){
                       // 总分内容样式
                       $sheet->cells('F'.$i.':G'.$i, function($cells) {
                           $cells->setFontColor('#F51322');
                       });
                   }
                   $i++;
               }
           });
       })->export('xls');
    }

    /** 导Excel导出数据
     * @param $data
     * @return array
     */
//    public static function unify($data,$filename)
//    {
//       $cellData[] = ['下单时间','订单编号','客户名字','客户电话','详细地址','地区','城市','邮寄地址','邮政编码','产品名称','商品名','币种','总金额','数量','产品属性信息','商品展示属性信息','备注','支付方式','赠品名称'];
//
//        Excel::create($filename,function ($excel) use ($cellData,$filename,$data){
//            $excel->sheet($filename, function ($sheet) use ($cellData,$data){
//                $sheet->rows($cellData);
//                $num = 2;
//                foreach ($data as $key=>$v)
//                {
//                    //产品属性信息
//                    $order_config = \App\order_config::where('order_primary_id', $v['order_id'])->get();
//                    if ($order_config->count() > 0) {
//                        $config_msg = '';//产品属性
//                        $goods_config_msg = '';//商品展示属性
//                        $i = 0;
//                        foreach ($order_config as $va) {
//                            $i++;
//                            $config_msg .= "第" . $i . "件：";
//                            $goods_config_msg .= "第" . $i . "件：";
//                            $orderarr = explode(',', $va['order_config']);
//                            foreach ($orderarr as $key => $val) {
//                                $conmsg = \App\config_val::where('config_val_id', $val)
//                                    ->where(function ($query) use ($v) {
//                                        if ($v['goods_is_update'] == '1') {
//                                            $query->where('kind_val_id', '>', 0);
//                                        }
//                                    })
//                                    ->first();
//                                if ($conmsg == null) {
//                                    $conmsg = \App\config_val::where('config_val_id', $val)->first();
//                                }
//                                if (isset($conmsg->kind_val_id) && $conmsg->kind_val_id) {
//                                    $config_val_msg = kind_val::where('kind_val_id', $conmsg->kind_val_id)->value('kind_val_msg');
//                                } else {
//                                    $config_val_msg = $conmsg['config_val_msg'];
//                                }
//                                $goods_config_msg .= $conmsg['config_val_msg'] . '-';
//                                $config_msg .= $config_val_msg . '-';
//                            }
//                            $config_msg = rtrim($config_msg, '-').',';
//                            $goods_config_msg = rtrim($goods_config_msg, '-').',';
//                        }
//                        $exdata = rtrim($config_msg, ',');
//                    } else {
//                        $exdata = " ";
//                    }
//
//                    $config_msg = explode(',',$exdata);
//                    $config_num = count($config_msg);
//                    $sheet->setMergeColumn([
//                        'columns' => ['A', 'B', 'C', 'D','E','F','G','H','I','J','K','L','M','N','Q','R','S'],
//                        'rows' => [
//                            [$num, $num+$config_num-1],
//                        ],
//                    ]);
//                    // 设置多个列
//                    $sheet->setWidth([
//                        'A' => 10,
//                        'B' => 10,
//                        'C' => 10,
//                        'D' => 10,
//                        'E' => 50,
//                        'F' => 10,
//                        'G' => 10,
//                        'H' => 20,
//                        'I' => 10,
//                        'J' => 10,
//                        'K' => 10,
//                        'L' => 10,
//                        'M' => 10,
//                        'N' => 10,
//                        'O' => 18,
//                        'P' => 18,
//                        'Q' => 10,
//                        'R' => 10,
//                        'S' => 10,
//                    ]);
//
//                    for($j = 0;$j<$config_num;$j++) {
//                        $sheet->cell('O'.($num+$j),$config_msg[$j]);
//                        $sheet->cell('P'.($num+$j),$config_msg[$j]);
//                    }
//                    $sheet->cell('A'.$num,$v['order_time']);
//                    $sheet->cell('B'.$num,$v['order_single_id']);
//                    $sheet->cell('C'.$num,$v['order_name']);
//                    $sheet->cell('D'.$num,$v['order_tel']);
//
//                    //详细地址
//                    if ($v['order_zip']) {
//                        $str = $v['order_add'];
//                        $pattern = '/(.*)\(Zip:(.*?)\)/';
//                        preg_match_all($pattern, $str, $p);
//                        $area_info = (isset($p[1][0]) && $p[1][0]) ? $p[1][0] : $v['order_add'];
//                        $sheet->cell('E'.$num,$v['order_state'] . ' ' . $v['order_city'] . '(' . $area_info . ')');
//                        $sheet->cell('F'.$num,$v['order_state']);
//                        $sheet->cell('G'.$num,$v['order_city']);
//                        $sheet->cell('H'.$num,$area_info);
//                        $sheet->cell('I'.$num,$v['order_zip']);
//                    } else {
//                        $str = $v['order_add'];
//                        $pattern = '/(.*)\(Zip:(.*?)\)/';
//                        preg_match_all($pattern, $str, $p);
//                        $area_info = (isset($p[1][0]) && $p[1][0]) ? $p[1][0] : $v['order_add'];
//                        $sheet->cell('E'.$num,$v['order_state'] . ' ' . $v['order_city'] . '(' . $area_info . ')');
//                        $sheet->cell('F'.$num,$v['order_state']);
//                        $sheet->cell('G'.$num,$v['order_city']);
//                        $sheet->cell('H'.$num,$area_info);
//                        $sheet->cell('I'.$num,isset($p[2][0]) ? $p[2][0] : '');
//                    }
//
//                    $sheet->cell('J'.$num,\App\goods_kind::where('goods_kind_id', $v['goods_kind_id'])->value('goods_kind_name'));
//                    $sheet->cell('K'.$num,$v['goods_real_name']);
//                    $sheet->cell('L'.$num,\App\currency_type::where('currency_type_id', $v['order_currency_id'])->value('currency_english_name'));
//                    $sheet->cell('M'.$num,$v['order_price']);
//                    $sheet->cell('N'.$num,$v['order_num']);
//                    $sheet->cell('Q'.$num,$v['order_remark']);
//                    $sheet->cell('R'.$num,$v['order_pay_type'] == 0 ? '货到付款' : '在线支付');
//                    $sheet->cell('S'.$num,price::where('price_id', $v['order_price_id'])->value('price_name'));
//                    $num += $config_num;
//                }
//            });
//        })->export('xls');
//    }
    /** 默认
     * @param $data
     * @param $filename
     */
    public static function unify($data,$filename)
    {
        $cellData[] = ['下单时间','订单编号','客户名字','客户电话','详细地址','地区','城市','邮寄地址','邮政编码','产品名称','商品名','币种','总金额','数量','产品属性信息','商品展示属性信息','备注','支付方式','赠品名称'];

        Excel::create($filename,function ($excel) use ($cellData,$filename,$data){
            $excel->sheet($filename, function ($sheet) use ($cellData,$data){
                $sheet->rows($cellData);
                $num = 2;
                foreach ($data as $key=>$v)
                {
                    //产品属性信息
                    $order_config = \App\order_config::where('order_primary_id', $v['order_id'])->get();
                    if ($order_config->count() > 0) {
                        $config_msg = '';//产品属性
                        $goods_config_msg = '';//商品展示属性
                        $i = 0;
                        foreach ($order_config as $va) {
                            $i++;
                            $config_msg .= "第" . $i . "件：";
                            $goods_config_msg .= "第" . $i . "件：";
                            $orderarr = explode(',', $va['order_config']);
                            foreach ($orderarr as $key => $val) {
                                $conmsg = \App\config_val::where('config_val_id', $val)
                                    ->where(function ($query) use ($v) {
                                        if ($v['goods_is_update'] == '1') {
                                            $query->where('kind_val_id', '>', 0);
                                        }
                                    })
                                    ->first();
                                if ($conmsg == null) {
                                    $conmsg = \App\config_val::where('config_val_id', $val)->first();
                                }
                                if (isset($conmsg->kind_val_id) && $conmsg->kind_val_id) {
                                    $config_val_msg = kind_val::where('kind_val_id', $conmsg->kind_val_id)->value('kind_val_msg');
                                } else {
                                    $config_val_msg = $conmsg['config_val_msg'];
                                }
                                $goods_config_msg .= $conmsg['config_val_msg'] . '-';
                                $config_msg .= $config_val_msg . '-';
                            }
                            $config_msg = rtrim($config_msg, '-').',';
                            $goods_config_msg = rtrim($goods_config_msg, '-').',';
                        }
                        $exdata = rtrim($config_msg, ',');
                    } else {
                        $exdata = " ";
                    }

                    $config_msg = explode(',',$exdata);
                    $config_num = count($config_msg);
                    $sheet->setMergeColumn([
                        'columns' => ['A', 'B', 'C', 'D','E','F','G','H','I','J','K','L','M','N','Q','R','S'],
                        'rows' => [
                            [$num, $num+$config_num-1],
                        ],
                    ]);
                    // 设置多个列
                    $sheet->setWidth([
                        'A' => 10,
                        'B' => 10,
                        'C' => 10,
                        'D' => 10,
                        'E' => 50,
                        'F' => 10,
                        'G' => 10,
                        'H' => 20,
                        'I' => 10,
                        'J' => 10,
                        'K' => 10,
                        'L' => 10,
                        'M' => 10,
                        'N' => 10,
                        'O' => 18,
                        'P' => 18,
                        'Q' => 10,
                        'R' => 10,
                        'S' => 10,
                    ]);

                    for($j = 0;$j<$config_num;$j++) {
                        $sheet->cell('O'.($num+$j),$config_msg[$j]);
                        $sheet->cell('P'.($num+$j),$config_msg[$j]);
                    }
                    $sheet->cell('A'.$num,$v['order_time']);
                    $sheet->cell('B'.$num,$v['order_single_id']);
                    $sheet->cell('C'.$num,$v['order_name']);
                    $sheet->cell('D'.$num,$v['order_tel']);

                    //详细地址
                    if ($v['order_zip']) {
                        $str = $v['order_add'];
                        $pattern = '/(.*)\(Zip:(.*?)\)/';
                        preg_match_all($pattern, $str, $p);
                        $area_info = (isset($p[1][0]) && $p[1][0]) ? $p[1][0] : $v['order_add'];
                        $sheet->cell('E'.$num,$v['order_state'] . ' ' . $v['order_city'] . '(' . $area_info . ')');
                        $sheet->cell('F'.$num,$v['order_state']);
                        $sheet->cell('G'.$num,$v['order_city']);
                        $sheet->cell('H'.$num,$area_info);
                        $sheet->cell('I'.$num,$v['order_zip']);
                    } else {
                        $str = $v['order_add'];
                        $pattern = '/(.*)\(Zip:(.*?)\)/';
                        preg_match_all($pattern, $str, $p);
                        $area_info = (isset($p[1][0]) && $p[1][0]) ? $p[1][0] : $v['order_add'];
                        $sheet->cell('E'.$num,$v['order_state'] . ' ' . $v['order_city'] . '(' . $area_info . ')');
                        $sheet->cell('F'.$num,$v['order_state']);
                        $sheet->cell('G'.$num,$v['order_city']);
                        $sheet->cell('H'.$num,$area_info);
                        $sheet->cell('I'.$num,isset($p[2][0]) ? $p[2][0] : '');
                    }

                    $sheet->cell('J'.$num,\App\goods_kind::where('goods_kind_id', $v['goods_kind_id'])->value('goods_kind_name'));
                    $sheet->cell('K'.$num,$v['goods_real_name']);
                    $sheet->cell('L'.$num,\App\currency_type::where('currency_type_id', $v['order_currency_id'])->value('currency_english_name'));
                    $sheet->cell('M'.$num,$v['order_price']);
                    $sheet->cell('N'.$num,$v['order_num']);
                    $sheet->cell('Q'.$num,$v['order_remark']);
                    $sheet->cell('R'.$num,$v['order_pay_type'] == 0 ? '货到付款' : '在线支付');
                    $sheet->cell('S'.$num,price::where('price_id', $v['order_price_id'])->value('price_name'));
                    $num += $config_num;
                }
            });
        })->export('xls');
    }

    /** 印度尼西亚
     * @param $data
     * @param $filename
     */
    public static function ydnxy($data,$filename)
    {
       $cellData[] = ['数量(为必填项，货物实际数量)','运费付款方式(为必填项)','到付运费金额','到付运费币种','转单号码','订单编号(为必填项且小于20给字符)','件数(为必填项，小包数量)','包装类型(为必填项)','收费实重','收费材重','指定路线','目的地(为必填项)','中文品名','英文品名(为必填项)','申报价值(为必填项)','申报币别(为必填项)','寄件公司','寄件人(为必填项)','寄件人电话','寄件人手机','寄件地址(为必填项)','寄件国家','寄件省','寄件城市','寄件邮编','收件人(为必填项)','收件人电话(为必填项)','收件地址(为必填项)','收件省','收件城市(为必填项)','收件地区','收件邮编(为必填项)','代收款','代收款币别','货物类型(为必填项)'];
        foreach($data as $k => $v) {
            $exdata = [];
            //数量(为必填项，货物实际数量)
            $exdata[1] = $v['order_num'];

            //运费付款方式(为必填项)
            $exdata[2] = ' ';

            //到付运费金额
            $exdata[3] = ' ';

            //到付运费币种
            $exdata[4] = ' ';

            //转单号码
            $exdata[5] = ' ';

            //订单编号(为必填项且小于20给字符)
            $exdata[6] = $v['order_single_id'];

            //件数(为必填项，小包数量)
            $exdata[7] = 1;

            //包装类型(为必填项)
            $exdata[8] = 'WPX';

            //收费实重
            $exdata[9] = 0.1;

            //收费材重
            $exdata[10] = 0.1;

            //指定路线
            $exdata[11] = '印尼专线';

            //目的地(为必填项)
            $exdata[12] = 'INA';

            //中文品名
            $order_config = \App\order_config::where('order_primary_id', $v['order_id'])->get();
            if ($order_config->count() > 0) {
                $config_data = goods_kind::where('goods_kind_id',$v['goods_kind_id'])->first();//产品属性
                if($config_data){
                    $config_msg = $config_data->goods_kind_name;
                    $config_english_msg = $config_data->goods_kind_english_name;
                }else{
                    $config_msg = '';
                    $config_english_msg = '';
                }
//                $config_msg = goods_kind::where('goods_kind_id',$v['goods_kind_id'])->value('goods_kind_name');//产品属性
                $i = 0;
                foreach ($order_config as $va) {
                    $i++;
                    $orderarr = explode(',', $va['order_config']);
                    $config_val = '';
                    $config_english_val = '';
                    foreach ($orderarr as $key => $val) {
                        $conmsg = \App\config_val::where('config_val_id', $val)
                            ->where(function ($query) use ($v) {
                                if ($v['goods_is_update'] == '1') {
                                    $query->where('kind_val_id', '>', 0);
                                }
                            })
                            ->first();
                        if ($conmsg == null) {
                            $conmsg = \App\config_val::where('config_val_id', $val)->first();
                        }

                        if (isset($conmsg->kind_val_id) && $conmsg->kind_val_id) {
                            $config_val_data = kind_val::where('kind_val_id', $conmsg->kind_val_id)->first();
                            if($config_val_data){
                                $config_val_msg = $config_val_data->kind_val_msg;
                                $kind_val_english_msg = $config_val_data->kind_val_english_msg;
                            }else{
                                $config_val_msg = '';
                                $kind_val_english_msg = '';
                            }
//                            $config_val_msg = kind_val::where('kind_val_id', $conmsg->kind_val_id)->value('kind_val_msg');
                        } else {
                            $config_val_msg = $conmsg['config_val_msg'];
                            $kind_val_english_msg = '';
                        }
                        $config_val .= $config_val_msg;
                        $config_english_val .= $kind_val_english_msg;

                    }
                    $config_msg .= ','.$config_val;
                    $config_english_msg .= ','.$config_english_val;
                }
                //中文品名
                $exdata[13] = $config_msg;

                //英文品名(为必填项)
                $exdata[14] = $config_english_msg;
            } else {
                //中文品名
                $exdata[13] = "";

                //英文品名(为必填项)
                $exdata[14] = "";
            }

            //申报价值(为必填项)
            $exdata[15] = $v['order_price'];


            //申报币别(为必填项)
            $exdata[16] = \App\currency_type::where('currency_type_id', $v['order_currency_id'])->value('currency_english_name');

            //寄件公司
            $exdata[17] = 'ORIENTAL MAGIC';

            //寄件人(为必填项)
            $exdata[18] = 'Miss Guo';

            //寄件人电话
            $exdata[19] = '18739903577';

            //寄件人手机
            $exdata[20] = '18739903577';

            //寄件地址(为必填项)
            $exdata[21] = 'Jinshui District CBD Road Jin Building，Zhengzhou, China ';

            //寄件国家
            $exdata[22] = 'CHINA';

            //寄件省
            $exdata[23] = 'HENAN';

            //寄件城市
            $exdata[24] = 'ZHENGZHOU';

            //寄件邮编
            $exdata[25] = '450000';

            //收件人(为必填项)
            $exdata[26] = $v['order_name'];

            //收件人(为必填项)
            $exdata[27] = $v['order_tel'];

            //收件地址(为必填项)
            if ($v['order_zip']) {
                $str = $v['order_add'];
                $pattern = '/(.*)\(Zip:(.*?)\)/';
                preg_match_all($pattern, $str, $p);
                $area_info = (isset($p[1][0]) && $p[1][0]) ? $p[1][0] : $v['order_add'];
                //收件地址(为必填项)
                $exdata[28] = $v['order_state'] . ' ' . $v['order_city']. ' ' . $v['order_village'] . '(' . $area_info . ')';
                //收件省
                $exdata[29] = $v['order_state'];
                //收件城市(为必填项)
                $exdata[30] = $v['order_city'];
                //收件地区
                $exdata[31] = $v['order_village'];
                //收件邮编(为必填项)
                $exdata[32] = $v['order_zip'];
            } else {
                $str = $v['order_add'];
                $pattern = '/(.*)\(Zip:(.*?)\)/';
                preg_match_all($pattern, $str, $p);
                $area_info = (isset($p[1][0]) && $p[1][0]) ? $p[1][0] : $v['order_add'];
                //收件地址(为必填项)
                $exdata[28] = $v['order_state'] . ' ' . $v['order_city']. ' ' . $v['order_village'] . '(' . $area_info . ')';
                //收件省
                $exdata[29] = $v['order_state'];
                //收件城市(为必填项)
                $exdata[30] = $v['order_city'];
                //收件地区
                $exdata[31] = $v['order_village'];
                //收件邮编(为必填项)
                $exdata[32] = isset($p[2][0]) ? $p[2][0] : '';
            }

            //代收款
            $exdata[33] = $v['order_price'];

            //代代收款币别
            $exdata[34] = \App\currency_type::where('currency_type_id', $v['order_currency_id'])->value('currency_english_name');

            //货物类型(为必填项)
            $exdata[35] = '普货';

            array_push($cellData,$exdata);
        }
        // 菜单 样式
        Excel::create($filename,function($excel) use ($cellData,$filename){
            $excel->sheet($filename, function($sheet) use ($cellData) {
                $sheet->rows($cellData);
                $i = 1;
                foreach ($cellData as $k=>$value) {
                    $sheet->cells('H'.$i.':L'.$i, function($cells) {
                        $cells->setFontColor('#F51322');
                    });
                    $i++;
                }
            });
        })->export('xls');
    }
}