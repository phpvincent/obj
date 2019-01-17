<?php

namespace App\Http\Controllers\admin;

use App\message;
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
        $messages = DB::table('message as m')->join('goods as g', 'm.message_goods_id', '=', 'g.goods_id', 'left')->join('order as o', 'o.order_id', '=', 'm.message_order_id', 'left')
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
        $arr = ['draw' => $draw, 'recordsTotal' => $counts, 'recordsFiltered' => $newcount, 'data' => $messages];
        return response()->json($arr);
    }
}
