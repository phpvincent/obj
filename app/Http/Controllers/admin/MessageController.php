<?php

namespace App\Http\Controllers\admin;

use App\channel\cuxiaoSDK;
use App\config_val;
use App\goods;
use App\goods_config;
use App\kind_val;
use App\message;
use App\price;
use App\special;
use App\url;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function index()
    {
        $counts = message::count();
        return view('admin.message.index')->with(compact('counts'));
    }

    public function get_table(Request $request)
    {
        $info = $request->all();
        $cm = $info['order'][0]['column'];
        $dsc = $info['order'][0]['dir'];
        $order = $info['columns']["$cm"]['data'];
        $draw = $info['draw'];
        $start = $info['start'];
        $len = $info['length'];
        $search = trim($info['search']['value']);
        $goods_blade_type = $request->input('goods_blade_type', 'all');
        $status = $request->input('status', 'all');
        $phone = $request->input('phone', '');
        $is_captcha = $request->input('is_captcha', 'all');
        $order_sn = $request->input('order_sn', '');
        $mark = $request->input('mark', 'all');
        $order_id = $request->input('order_id', 'all');
        $datemin = $request->input('datemin');
        $datemax = $request->input('datemax');
        $messages = DB::table('message as m')->join('goods as g', 'm.message_goods_id', '=', 'g.goods_id', 'left')->join('order as o', 'o.order_id', '=', 'm.message_order_id', 'left')
            ->where(function ($query) use ($status) {
                if ($status != 'all') {
                    $query->where('m.message_status', $status);
                }
            })->where(function ($query) use ($phone) {
                if ($phone) {
                    $query->where('m.message_mobile_num', 'like', '%' . $phone . '%');
                }
            })->where(function ($query) use ($mark) {
                if ($mark != 'all') {
                    $query->where('m.message_marking', $mark);
                }
            })->where(function ($query) use ($is_captcha) {
                if ($is_captcha != 'all') {
                    if ($is_captcha == 1) {
                        $query->where('messaga_code', '<>', 0);
                    } else {
                        $query->where('messaga_code', 0);
                    }
                }
            })->where(function ($query) use ($order_sn) {
                if ($order_sn) {
                    $query->where('o.order_single_id', 'like', '%' . $order_sn . '%');
                }
            })->where(function ($query) use ($goods_blade_type) {
                if ($goods_blade_type != 'all') {
                    $query->where('g.goods_blade_type', $goods_blade_type);
                }
            })->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('order_single_id', 'like', '%' . $search . '%')->orWhere('message_mobile_num', 'like', '%' . $search . '%');
                }
            })->orderBy($order, $dsc)
            ->offset($start)
            ->limit($len)
            ->get();
        $counts = message::count();
        $newcount = DB::table('message as m')->join('goods as g', 'm.message_goods_id', '=', 'g.goods_id', 'left')->join('order as o', 'o.order_id', '=', 'm.message_order_id', 'left')
            ->where(function ($query) use ($status) {
                if ($status != 'all') {
                    $query->where('m.message_status', $status);
                }
            })->where(function ($query) use ($phone) {
                if ($phone) {
                    $query->where('m.message_mobile_num', 'like', '%' . $phone . '%');
                }
            })->where(function ($query) use ($is_captcha) {
                if ($is_captcha != 'all') {
                    if ($is_captcha == 1) {
                        $query->where('messaga_code', '<>', 0);
                    } else {
                        $query->where('messaga_code', 0);
                    }
                }
            })->where(function ($query) use ($goods_blade_type) {
                if ($goods_blade_type != 'all') {
                    $query->where('g.goods_blade_type', $goods_blade_type);
                }
            })->where(function ($query) use ($order_sn) {
                if ($order_sn) {
                    $query->where('o.order_single_id', 'like', '%' . $order_sn . '%');
                }
            })->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('order_single_id', 'like', '%' . $search . '%')->orWhere('message_mobile_num', 'like', '%' . $search . '%');
                }
            })->count();
        if ($messages) {
            foreach ($messages as $message) {
                if ($message->goods_id) {
                    $message->goods_url = url::where('url_goods_id', $message->goods_id)->value('url_url');
                }
            }
        }

        $arr = ['draw' => $draw, 'recordsTotal' => $counts, 'recordsFiltered' => $newcount, 'data' => $messages];
        return response()->json($arr);
    }

    public function export(Request $request)
    {
        $datemin = $request->input('datemin');
        $datemax = $request->input('datemax');
        $messages = DB::table('message as m')
            ->where('m.message_order_id', 0)->where(function ($query) use ($datemin) {
                if ($datemin) {
                    $query->where('m.message_gettime', '>', $datemin);
                }
            })->where(function ($query) use ($datemax) {
                if ($datemax) {
                    $query->where('m.message_gettime', '<', $datemax);
                }
            })->where('messaga_code', '<>', 0)
            ->get();
        $new_exdata = [];
        if ($messages) {
            foreach ($messages as $key => $message) {
                $v = unserialize($message->message_order_msg);
                $goods = goods::find($message->message_goods_id);
                $cuxiaoSDK = new cuxiaoSDK($goods);
                $price = $cuxiaoSDK->get_price($v['specNumber'], $v['cuxiao_id']);
                $cuxiao_msg = \App\cuxiao::where('cuxiao_id', $v['cuxiao_id'])->first();
                if ($cuxiao_msg) {
                    $v['order_price_id'] = special::where('special_id', $cuxiao_msg->cuxiao_special_id)->value('special_price_id');
                }
                if (isset($v['goodsAtt']) && $v['goodsAtt']) {
                    $price = $cuxiaoSDK->get_diff_price($v['goodsAtt'], $price);
                }
                $new_exdata[$key]['order_time'] = $message->message_gettime;
                $new_exdata[$key]['order_single_id'] = '';
                $new_exdata[$key]['name'] = (isset($v['firstname']) ? $v['firstname'] : '') . (isset($v['lastname']) ? $v['lastname'] : '');
                $new_exdata[$key]['tel'] = isset($v['telephone']) ? $v['telephone'] : '';
                if (isset($v['zip'])) {
                    $str = isset($v['address1']) ? $v['address1'] : '';
                    $pattern = '/(.*)\(Zip:(.*?)\)/';
                    preg_match_all($pattern, $str, $p);
                    $area_info = (isset($p[1][0]) && $p[1][0]) ? $p[1][0] : $v['order_add'];
//                    if ($goods_blade_type == 6 || $goods_blade_type == 7) {
                    $new_exdata[$key]['area_data_info'] = (isset($v['state']) ? $v['state'] : '') . ' ' . (isset($v['city']) ? $v['city'] : '') . ' ' . (isset($v['order_village']) ? $v['order_village'] : '') . '(' . $area_info . ')';
                    $new_exdata[$key]['order_state'] = isset($v['state']) ? $v['state'] : '';
                    $new_exdata[$key]['order_city'] = isset($v['city']) ? $v['city'] : '';
                    $new_exdata[$key]['order_village'] = isset($v['order_village']) ? $v['order_village'] : '';
                    $new_exdata[$key]['area_info'] = $area_info;
                    $new_exdata[$key]['order_zip'] = $v['zip'];
                } else {
                    $str = isset($v['address1']) ? $v['address1'] : '';
                    $pattern = '/(.*)\(Zip:(.*?)\)/';
                    preg_match_all($pattern, $str, $p);
                    $area_info = (isset($p[1][0]) && $p[1][0]) ? $p[1][0] : $v['address1'];
                    $new_exdata[$key]['order_state'] = isset($v['state']) ? $v['state'] : '';;
                    $new_exdata[$key]['order_city'] = isset($v['city']) ? $v['city'] : '';
                    $new_exdata[$key]['area_data_info'] = (isset($v['state']) ? $v['state'] : '') . ' ' . (isset($v['city']) ? $v['city'] : '') . ' ' . (isset($v['order_village']) ? $v['order_village'] : '') . '(' . $area_info . ')';
                    $new_exdata[$key]['area_data_info'] = (isset($v['state']) ? $v['state'] : '') . ' ' . (isset($v['city']) ? $v['city'] : '') . ' ' . (isset($v['order_village']) ? $v['order_village'] : '') . '(' . $area_info . ')';
                    $new_exdata[$key]['order_state'] = isset($v['state']) ? $v['state'] : '';;
                    $new_exdata[$key]['order_city'] = isset($v['city']) ? $v['city'] : '';
                    $new_exdata[$key]['order_village'] = isset($v['order_village']) ? $v['order_village'] : '';

                    $new_exdata[$key]['area_info'] = $area_info;
                    $new_exdata[$key]['order_zip'] = isset($p[2][0]) ? $p[2][0] : '';
                }
                $goods_kind = \App\goods_kind::where('goods_kind_id', $goods->goods_kind_id)->first();
                $new_exdata[$key]['goods_real_name'] = $goods_kind->goods_kind_name;
                $new_exdata[$key]['goods_real_english_name'] = $goods_kind->goods_kind_english_name;
                $new_exdata[$key]['goods_name'] = $goods['goods_real_name'];
                $new_exdata[$key]['payof'] = \App\currency_type::where('currency_type_id', $goods->goods_currency_id)->value('currency_english_name');
                $new_exdata[$key]['order_price'] = $price;
                $new_exdata[$key]['order_num'] = $v['specNumber'];

                if (isset($v['goodsAtt']) && $v['goodsAtt']) {
                    $arrs = [];
                    foreach ($v['goodsAtt'] as $name => $val) {
                        $id = str_replace('goods', '', $name);
                        foreach ($val as $key_att => $v) {
                            if (isset($arrs[$key_att])) {
                                $arrs[$key_att][$id] = $v;
                            } else {
                                $arrs[$key_att][$id] = $v;
                            }
                        }
                    }
                    $config_msg = '';//产品属性
                    $config_english_msg = '';
                    $goods_config_msg = '';//商品展示属性
                    $i = 0;
                    foreach ($arrs as $arr) {
                        $i++;
                        $goods_msg = "<td>第" . $i . "件</td>";
                        $kind_msg = "<td>第" . $i . "件</td>";
                        $kind_english_msg = "";
                        //================================================
                        foreach ($arr as $item) {
                            $goods_msg .= '<td>' . config_val::where('config_val_id', $item)->value('config_val_msg') . '</td>';
                            $kind_msg .= '<td>' . config_val::where('config_val_id', $item)->value('config_val_msg') . '</td>';
                            $kind_english_msg .= kind_val::where('kind_val_id', config_val::where('config_val_id', $item)->value('kind_val_id'))->value('kind_val_english_msg');
                        }
                        $config_msg .= '<tr>' . $kind_msg . '</tr>';
                        $config_english_msg .= $kind_english_msg . ',';
                        $goods_config_msg .= '<tr>' . $goods_msg . '</tr>';
                    }
                    $new_exdata[$key]['config_msg'] = '<table border=1>' . $config_msg . '</table>';
                    if (rtrim($config_english_msg, ',') == '') {
                        $new_exdata[$key]['config_english_msg'] = '';
                    } else {
                        if ($goods_kind->goods_kind_english_name) {
                            $new_exdata[$key]['config_english_msg'] = $goods_kind->goods_kind_english_name . ',' . rtrim($config_english_msg, ',');
                        } else {
                            $new_exdata[$key]['config_english_msg'] = rtrim($config_english_msg, ',');
                        }
                    }
                    $new_exdata[$key]['goods_config_msg'] = '<table border=1>' . $goods_config_msg . '</table>';
                } else {
                    $new_exdata[$key]['config_msg'] = "暂无属性信息";
                    $new_exdata[$key]['config_english_msg'] = "暂无属性信息";
                    $new_exdata[$key]['goods_config_msg'] = "暂无属性信息";
                }
                $new_exdata[$key]['remark'] = isset($v['notes']) ? $v['notes'] : '';
                $new_exdata[$key]['order_pay_type'] = 0;
                $new_exdata[$key]['special_name'] = price::where('price_id', (isset($v['order_price_id']) ? $v['order_price_id'] : 0))->value('price_name');
            }
            if ($request->has('datemin') && $request->has('datemax')) {
                $filename = '[' . $request->input('datemin') . ']—' . '[' . $request->input('datemax') . ']' . '订单记录' . date('Y-m-d H:i:s', time()) . '.xls';
            } else {
                $filename = '下单失败短信记录' . date('Y-m-d H:i:s', time()) . '.xls';
            }
            /*         $zdname=['订单id','订单编号','下单者ip','单品名','促销信息','订单价格','订单类型','反馈信息','下单时间','反馈时间','核审人员','商品件数','快递单号'];
            */
            /*        order_time . name.tel.send_msg.state.city.area_msg.zip.goods_kind_name.goods_name.currency_type.account.count.color.remark.pay_type*/
            //$zdname=['下单时间','产品名称','商品名','型号/尺寸/颜色','数量','币种','总金额','支付方式','客户名字','客户电话','地区','城市','详细地址','邮寄地址','邮政编码','备注'];
//            if ($goods_blade_type == 6 || $goods_blade_type == 7) {
            $zdname = ['下单时间', '订单编号', '客户名字', '客户电话', '详细地址', '省', '市', '区', '邮寄地址', '邮政编码', '产品名称', '产品英文名称', '商品名', '币种', '总金额', '数量', '产品属性信息', '产品英文属性信息', '商品展示属性信息', '备注', '支付方式', '赠品名称'];

            out_excil($new_exdata, $zdname, '下单失败短信记录表', $filename);
        }
    }

    function mark(Request $request)
    {
        $message = message::find($request->input('id'));
        $message->message_marking = $request->input('marking');
        if ($message->save()) {
            return response()->json(['err' => 1, 'str' => '设置成功']);
        } else {
            return response()->json(['err' => 0, 'str' => '设置失败']);
        }
    }

    public
    function order_msg(Request $request)
    {
        $message = message::find($request->input('id'));
        $order = unserialize($message->message_order_msg);
        $goods = goods::find($message->message_goods_id);
        $goods->goods_url = url::where('url_goods_id', $message->message_goods_id)->value('url_url');
        $arrs = [];
        if (isset($order['goodsAtt'])) {
            foreach ($order['goodsAtt'] as $name => $val) {
                $id = str_replace('goods', '', $name);
                foreach ($val as $key => $v) {
                    if (isset($arrs[$key])) {
                        $arrs[$key][$id] = $v;
                    } else {
                        $arrs[$key][$id] = $v;
                    }
                }
            }
            $goods_attrs = [];
            foreach ($arrs as $arr) {
                $str = '';
                foreach ($arr as $key => $item) {
                    $str .= goods_config::where('goods_config_id', $key)->value('goods_config_msg') . '：' . config_val::where('config_val_id', $item)->value('config_val_msg') . ' ';
                }
                $goods_attrs[] = $str;
            }
            $goods->goods_attrs = $goods_attrs;
        }
        return view('admin.message.edit')->with(compact('order', 'goods'));
    }

    public
    function delmessages(Request $request)
    {
        if ($request->has('type') && $request->input('type') == 'all') {
            $ids = $request->input('id');
            $ip = $request->getClientIp();
            $err = false;
            $err_ids = [];
            foreach ($ids as $id) {
                if (!$this->del_message($id, $ip)) {
                    $err = true;
                    $err_ids[] = $id;
                }
            }
            if ($err) {
                return response()->json(['err' => 0, 'str' => '删除失败, 删除失败的短信id为' . implode(', ', $err_ids)]);
            } else {
                return response()->json(['err' => 1, 'str' => '删除成功']);
            }
        } else {
            $id = $request->input('id');
            $ip = $request->getClientIp();
            if ($this->del_message($id, $ip)) {
                return response()->json(['err' => 1, 'str' => '删除成功']);
            } else {
                return response()->json(['err' => 0, 'str' => '删除失败']);
            }
        }

    }

    private
    function del_message($id, $ip)
    {
        $message = message::find($id);
        if (message::destroy($id)) {
            operation_log($ip, '删除短信成功,短信内容：' . $message->messaga_content);
            return true;
        }
        return false;
    }
}
