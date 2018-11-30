<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class vis extends Model
{
    protected $table = 'vis';
    protected $primaryKey ='vis_id';
    public $timestamps=false;

    /** 获取某段时间的访问量
     * @param $start_time
     * @param $end_time
     * @param int $goods_id
     * @return mixed
     */
    public static function visCount($start_time,$end_time,$goods_id = 0)
    {
        $leng = intval((strtotime($end_time)-strtotime($start_time))/3600/24);
        $data =  \App\data_log::whereBetween('data_time',[$start_time,$end_time])->get();
        $data4 = [];
        $data5 = [];
        $data6 = [];
        $data4['name'] = '浏览量';
        $data5['name'] = '购买量';
        $data6['name'] = '下单量';
        $time = [];
        //默认7天
        if(!$data->isEmpty()){
            if(strtotime($start_time)+($leng-1)*3600*24 <= time() &&  strtotime($start_time)+$leng*3600*24 > time() && $leng > 1){ //多天，包括今天
                foreach ($data as $item)
                {
                    $data_browse = json_decode($item->data_browse);
                    $data_buy = json_decode($item->data_buy);
                    $data_order = json_decode($item->data_order);
                    for ($i = 1; $i <= $leng; $i++) {
                        $time[] = date('Y-m-d', strtotime($start_time) + ($i - 1) * 3600 * 24);
                        if (strtotime($start_time) + ($i - 1) * 3600 * 24 <= strtotime($item->data_time) && strtotime($item->data_time) < strtotime($start_time) + $i * 3600 * 24) {
                            $get_data = self::get_data($data_browse, $data_buy, $data_order, $goods_id);
                            isset($data4['data'][$i]) ? $data4['data'][$i] += $get_data['browse_count'] : $data4['data'][$i] = $get_data['browse_count'];
                            isset($data5['data'][$i]) ? $data5['data'][$i] += $get_data['buy_count'] : $data5['data'][$i] = $get_data['buy_count'];
                            isset($data6['data'][$i]) ? $data6['data'][$i] += $get_data['order_count'] : $data6['data'][$i] = $get_data['order_count'];
                            unset($get_data);
                        }
                    }
                }
                ksort($data4['data']);
                ksort($data5['data']);
                ksort($data6['data']);
                $get_today_data = self::toDayData($goods_id);
                isset($data4['data'][$leng]) ? $data4['data'][$leng] += $get_today_data['browse_count'] : $data4['data'][$leng] = $get_today_data['browse_count'];
                isset($data5['data'][$leng]) ? $data5['data'][$leng] += $get_today_data['buy_count'] : $data5['data'][$leng] = $get_today_data['buy_count'];
                isset($data6['data'][$leng]) ? $data6['data'][$leng] += $get_today_data['order_count'] : $data6['data'][$leng] = $get_today_data['order_count'];
                $time = array_slice($time,0,$leng);
                unset($get_today_data);
            }else if($leng > 1 && strtotime($start_time)+$leng*3600*24 < time()){ //多天，不包括今天
                foreach ($data as $item)
                {
                    $data_browse = json_decode($item->data_browse);
                    $data_buy = json_decode($item->data_buy);
                    $data_order = json_decode($item->data_order);
                    for ($i = 1; $i<=$leng;$i++)
                    {
                        $time[] = date('Y-m-d',strtotime($start_time)+($i - 1) * 3600 * 24);
                        if(strtotime($start_time)+($i-1)*3600*24 <= strtotime($item->data_time) && strtotime($item->data_time) < strtotime($start_time)+$i*3600*24){
                            $get_data = self::get_data($data_browse,$data_buy,$data_order,$goods_id);
                            isset($data4['data'][$i]) ? $data4['data'][$i] += $get_data['browse_count'] : $data4['data'][$i] = $get_data['browse_count'];
                            isset($data5['data'][$i]) ? $data5['data'][$i] += $get_data['buy_count'] : $data5['data'][$i] = $get_data['buy_count'];
                            isset($data6['data'][$i]) ? $data6['data'][$i] += $get_data['order_count'] : $data6['data'][$i] = $get_data['order_count'];
                            unset($get_data);
                        }
                    }
                }
                $time = array_slice($time,0,$leng);
                ksort($data4['data']);
                ksort($data5['data']);
                ksort($data6['data']);
            }else{ //1天  不包括今天
                foreach ($data as $item) {
                    $data_browse = json_decode($item->data_browse);
                    $data_buy = json_decode($item->data_buy);
                    $data_order = json_decode($item->data_order);
                    for ($i = 1; $i <= 24; $i++) {
                        if (strtotime($start_time) + ($i - 1) * 3600 <= strtotime($item->data_time) && strtotime($item->data_time) < strtotime($start_time) + $i * 3600) {
                            $time[] = date('Y-m-d H', strtotime($start_time) + ($i - 1) * 3600);
                            $get_data = self::get_data($data_browse, $data_buy, $data_order, $goods_id);
                            isset($data4['data'][$i]) ? $data4['data'][$i] += $get_data['browse_count'] : $data4['data'][$i] = $get_data['browse_count'];
                            isset($data5['data'][$i]) ? $data5['data'][$i] += $get_data['buy_count'] : $data5['data'][$i] = $get_data['buy_count'];
                            isset($data6['data'][$i]) ? $data6['data'][$i] += $get_data['order_count'] : $data6['data'][$i] = $get_data['order_count'];
                        }
                    }
                }
            }
        }else if($data->isEmpty()){ //1天 今天
            $start = date('Y-m-d',time()).' 00:00:00';
            $times = strtotime($start);
            $leng = date('H');
            for ($i = 0; $i <= $leng; $i++)
            {
                $start_time = date('Y-m-d H:i:s',$times + $i*3600);
                $end_time = date('Y-m-d H:i:s',$times + ($i+1)*3600);
                $time[] = date('Y-m-d H',$times + $i*3600);
                $visBrowse = vis::whereBetween('vis_time',[$start_time,$end_time])->select(DB::Raw('COUNT(vis_goods_id) AS count'),'vis_goods_id')->groupBy('vis_goods_id')->get()->toArray();
                $visBuy = vis::whereBetween('vis_buytime',[$start_time,$end_time])->select(DB::Raw('COUNT(vis_goods_id) AS count'),'vis_goods_id')->groupBy('vis_goods_id')->get()->toArray();
                $visOrder = order::whereBetween('order_time',[$start_time,$end_time])->select(DB::Raw('COUNT(order_goods_id) AS count'),'order_goods_id')->groupBy('order_goods_id')->get()->toArray();
                $data4['data'][$i] = 0;
                if(!empty($visBrowse)){
                    foreach ($visBrowse as $key=>$value) {
                        if ($goods_id) {
                            if ($value['vis_goods_id'] == $goods_id) {
                                $data4['data'][$i] = $value['count'] ? $value['count'] : 0;
                            }
                        } else {
                            $count = $value['count'] ? $value['count'] : 0;
                            isset($data4['data'][$i]) ? $data4['data'][$i] += $count : $data4['data'][$i] = $count;
                        }
                    }
                    }
                unset($visBrowse);
                //购买量
                $data5['data'][$i] = 0;
                if(!empty($visBuy)){
                    foreach ($visBuy as $key=>$value)
                    {
                        if($goods_id){
                            if ($value['vis_goods_id'] == $goods_id) {
                                $data5['data'][$i] = $value['count'] ? $value['count'] : 0;
                            }
                        }else{
                            $count = $value['count'] ? $value['count'] : 0;
                            isset($data5['data'][$i]) ? $data5['data'][$i] += $count : $data5['data'][$i] = $count;
                        }
                    }
                }
                unset($visBuy);

                //下单量
                $data6['data'][$i] = 0;
                if(!empty($visOrder)){
                    foreach ($visOrder as $key=>$value)
                    {
                        if($goods_id){
                            if ($value['order_goods_id'] == $goods_id) {
                                $data6['data'][$i] = $value['count'] ? $value['count'] : 0;
                            }
                        }else{
                            $count = $value['count'] ? $value['count'] : 0;
                            isset($data6['data'][$i]) ? $data6['data'][$i] += $count : $data6['data'][$i] = $count;
                        }
                    }
                }
                unset($visOrder);
            }
        }
        $data1['name'] = '购买转化率';
        //浏览转化率
        foreach ($data4['data'] as $key => $item)
        {
            foreach ($data5['data'] as $k => $value)
            {
                if($key == $k){
                    if($item != 0){
                        $data1['data'][$k] = sprintf('%.6f',$value/$item);
                    }else{
                        $data1['data'][$k] = 0;
                    }
                }
            }
        }

        $data2['name'] = '下单转化率';
        //购买转化率
        foreach ($data4['data'] as  $key => $item)
        {
            foreach ($data6['data'] as $k=> $val)
            {
                if($key == $k){
                    if($item != 0){
                        $data2['data'][$k] = sprintf('%.6f',$val/$item);
                    }else{
                        $data2['data'][$k] = 0;
                    }
                }
            }
        }

        //折线图
        $datas[]=$data1;  //购买转化率
        $datas[]=$data2;  //下单转化率
        $datacount[]=$data4;  //浏览量
        $datacount[]=$data5;  //购买量
        $datacount[]=$data6;  //下单量
        $data_total['datacount'] = $datacount;
        $data_total['time'] = $time;
        $data_total['data'] = $datas;
        return $data_total;
    }

    /** 订单数据
     * @param $data_browse
     * @param $data_buy
     * @param $data_order
     * @param int $goods_id
     * @return array
     */
    private static function get_data($data_browse,$data_buy,$data_order,$goods_id)
    {
        $array['browse_count'] = 0;
        $array['buy_count'] = 0;
        $array['order_count'] = 0;

        if(!empty($data_browse)){
            foreach ($data_browse as $val)
            {
                if($goods_id){
                    if($val->vis_goods_id == $goods_id){
                        $array['browse_count'] += $val->count;
                    }
                }else{
                    $array['browse_count'] += $val->count;
                }
            }
        }
        if(!empty($data_buy)){
            foreach ($data_buy as $val)
            {
                if($goods_id){
                    if($val->vis_goods_id == $goods_id){
                        $array['buy_count'] += $val->count;
                    }
                }else{
                    $array['buy_count'] += $val->count;
                }
            }
        }
        if(!empty($data_order)){
            foreach ($data_order as $val)
            {
                if($goods_id){
                    if($val->order_goods_id == $goods_id){
                        $array['order_count'] += $val->count;
                    }
                }else{
                    $array['order_count'] += $val->count;
                }
            }
        }

        return $array;
    }

    /** 今日数据日数据
     * @param $goods_id
     * @return mixed
     */
    private static function toDayData($goods_id)
    {
        $start_time = date('Y-m-d',time()).' 00:00:00';
        $end_time = date('Y-m-d H:i:s',time());
        $vis_count =  \App\vis::whereBetween('vis_time',[$start_time,$end_time])
            ->where(function($query)use($goods_id){
                if($goods_id){
                    $query->where('vis_goods_id',$goods_id);
                }
            })->count();
        $buy_count =  \App\vis::whereBetween('vis_buytime',[$start_time,$end_time])
            ->where(function($query)use($goods_id){
                if($goods_id){
                    $query->where('vis_goods_id',$goods_id);
                }
            })->count();
        $order_count =  \App\order::whereBetween('order_time',[$start_time,$end_time])
            ->where(function($query)use($goods_id){
                if($goods_id){
                    $query->where('order_goods_id',$goods_id);
                }
            })->count();
        $array['browse_count'] = $vis_count;
        $array['buy_count'] = $buy_count;
        $array['order_count'] = $order_count;
        return $array;
    }

    /** 获取某段时间的购买量
     * @param $today
     * @param $goods_id
     * @param $user_id
     * @return mixed
     */
    public static function visBuyCount($today,$goods_id,$goods_arr)
    {
        $count =  \App\vis::where('vis_buytime','like',$today.'%')
            ->whereIn('vis_goods_id',$goods_arr)
            ->where(function($query)use($goods_id){
                if($goods_id){
                    $query->where('vis_goods_id',$goods_id);
                }
            })->count();
        return $count;
    }

    /** 获取某段时间的下单量
     * @param $today
     * @param $goods_id
     * @param $user_id
     * @return mixed
     */
    public static function visOrderCount($today,$goods_id,$goods_arr)
    {
        $count = \App\order::where('order_time','like',$today.'%')
            ->whereIn('order_goods_id',$goods_arr)
            ->where('is_del','0')
            ->where(function($query)use($goods_id){
                if($goods_id){
                    $query->where('order_goods_id',$goods_id);
                }
            })->count();
        return $count;
    }

    /** 获取某段时间的评论量
     * @param $today
     * @param $goods_id
     * @param $user_id
     * @return mixed
     */
    public static function visComCount($today,$goods_id,$goods_arr)
    {
        $count =  \App\vis::where('vis_comtime','like',$today.'%')
            ->whereIn('vis_goods_id',$goods_arr)
            ->where(function($query)use($goods_id){
                if($goods_id){
                    $query->where('vis_goods_id',$goods_id);
                }
            })->count();
        return $count;
    }

    /** 数据保存（定时任务，保存前一天数据）
     * @param $start
     * @param $end
     * @return array
     */
    public static function visBrowseCount($start)
    {
//        $visBrowse = vis::whereBetween('vis_time',[$start,$end])->get();
//        $visBuy = vis::whereBetween('vis_buytime',[$start,$end])->get();
//        $visOrder = order::whereBetween('order_time',[$start,$end])->get();
//        $data = [];
        //分24小时
        $time = strtotime($start);
        for ($i = 0; $i < 24; $i++)
        {
            $start_time = date('Y-m-d H:i:s',$time + $i*3600);
            $end_time = date('Y-m-d H:i:s',$time + ($i+1)*3600);
            $visBrowse = vis::whereBetween('vis_time',[$start_time,$end_time])->select(DB::Raw('COUNT(vis_goods_id) AS count'),'vis_goods_id')->groupBy('vis_goods_id')->get()->toArray();
            $visBuy = vis::whereBetween('vis_buytime',[$start_time,$end_time])->select(DB::Raw('COUNT(vis_goods_id) AS count'),'vis_goods_id')->groupBy('vis_goods_id')->get()->toArray();
            $visOrder = order::whereBetween('order_time',[$start_time,$end_time])->select(DB::Raw('COUNT(order_goods_id) AS count'),'order_goods_id')->groupBy('order_goods_id')->get()->toArray();
//dd($visBrowse);
//            $arrBrowse = [];
//            foreach ($visBrowse as $item)
//            {
//                if($start_time <= $item->vis_time && $end_time > $item->vis_time){
//                    $arrBrowse[$item->vis_goods_id][] = $item;
//                }
//            }
//            $arrayBrowse = [];
//            if(!empty($arrBrowse)){
//                foreach ($arrBrowse as $key=>$value)
//                {
//                    $arrayBrowse[$key] = count($value);
//                }
//            }
            $data_info['data_time'] = date('Y-m-d H:i:s',$time + $i*3600+120);
            $data_info['data_browse'] = json_encode($visBrowse);
            unset($visBrowse);
            //购买量
//            $arrBuy = [];
//            foreach ($visBuy as $item)
//            {
//                if($start_time <= $item->vis_buytime && $end_time > $item->vis_buytime){
//                    $arrBuy[$item->vis_goods_id][] = $item;
//                }
//            }
//            $arrayBuy = [];
//            if(!empty($arrBuy)){
//                foreach ($arrBuy as $key=>$value)
//                {
//                    $arrayBuy[$key] = count($value);
//                }
//            }
            $data_info['data_buy'] = json_encode($visBuy);
            unset($visBuy);
//            unset($arrBuy);

            //下单量
//            $arrOrder = [];
//            foreach ($visOrder as $item)
//            {
//                if($start_time <= $item->order_time && $end_time > $item->order_time){
//                    $arrOrder[$item->order_goods_id][] = $item;
//                }
//            }
//            $arrayOrder = [];
//            if(!empty($arrOrder)){
//                foreach ($arrOrder as $key=>$value)
//                {
//                    $arrayOrder[$key] = count($value);
//                }
//            }
//            $visOrder = [];
            $data_info['data_order'] = json_encode($visOrder);
            unset($visOrder);
//            unset($arrayOrder);

            $bool = \App\data_log::insert($data_info);  //data_log插入昨天浏览量、购买量、下单量
            if(!$bool){
                Log::error('插入数据失败');
            }
            unset($data_info);
//            array_push($data,$data_info);
        }
//        return $data;
    }
}
