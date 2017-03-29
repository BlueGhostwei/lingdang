<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Image;
use Input;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //返回方法，sta=1 成功，sta=0 失败
    public function return_back($data, $sta)
    {

        $back = Input::get('back');

        if ($sta == 1) {
            if (isset($back) == 'json') {
                return json_encode([
                    'sta' => 1,
                    'msg' => '请求成功',
                    'data' => $data
                ]);
            }
        } elseif ($sta == 1) {

        }


    }


    /**
     * @param $data
     * @param $id
     * @return mixed
     * 遍历图片方法1公用
     */
    function pic_to_array($data, $id='')
    {
        $set_data = array();
        foreach ($data['data'] as $key => $val) {
            if (is_string($val['list_pic'])) { //判断封面图片张数,换号数据结构
                $val['list_pic'] = explode(',', $val['list_pic']);
                $old_time = strtotime($val['created_at']);
                if($val['live_status']==1){
                    $val['live_end'] = date('Y-m-d H:i:s', $val['live_end']);
                    $val['live_start'] = date('Y-m-d H:i:s', $val['live_start']);
                }else{
                    $val['live_end'] = '';
                    $val['live_start'] = '';
                }
                $val['created_at'] = date('Y-m-d ', $old_time);//获取前一天日期
                //$val['time'] = date('Y-m-d ',$val['time']);//获取前一天日期
            }
            $set_data[] = $val;

        }
        $data['data'] = $set_data;
        $key_id = array();
        foreach ($data['data'] as $key => $vel) {
            /* $vel['list_id'] = $key;
             $vel['new_tag_id'] = $id;*/
            $key_id[] = $vel;
        }
        $data['data'] = $key_id;
        return $data;

    }

    /**
     * @param $array
     * @param $id
     * @return mixed
     *遍历图片方法2公用
     */
    public function str_to_array($array, $id)
    {
        foreach ($array as $rst => $v) {
            $set_data = array();
            foreach ($v['data'] as $key => $val) {
                if (is_string($val['list_pic'])) { //判断封面图片张数,换号数据结构
                    $val['list_pic'] = explode(',', $val['list_pic']);
                    $val['label'] = explode(',', $val['label']);
                }
                $set_data[] = $val;
            }
            $array[$rst]['data'] = $set_data;
        }
        foreach ($array as $rt => $vb) {
            $key_id = array();
            foreach ($array[$rt]['data'] as $key => $vel) {
                /* $vel['list_id'] = $key;
                 $vel['new_tag_id'] = $id;*/
                $key_id[] = $vel;
            }
            $array[$rt]['data'] = $key_id;


        }
        return $array;
    }

    /**
     * @param $array
     * @return array
     * 合并相同数据
     */

    public function formatArray($array)
    {
        sort($array);
        $tem = "";
        $temarray = array();
        $j = 0;
        for ($i = 0; $i < count($array); $i++) {
            if ($array[$i] != $tem) {
                $temarray[$j] = $array[$i];
                $j++;
            }
            $tem = $array[$i];
        }
        return $temarray;
    }






    /**
     * @param $array1
     * @param $array2
     * @return array
     *合并二维数组方法
     */

    public function set_num_array($array1, $array2)
    {
        $all_data = (array($array1, $array2));
        $date = array();
        for ($i = 0; $i < count($all_data); $i++) { //数据格式转换
            for ($b = 0; $b < count($all_data[0]); $b++) {
                $cacheDate = array();
                $cacheDate[] = $all_data[$i][$b];
                if (isset($date[$b])) {
                    $date[$b] = array_merge($date[$b], $cacheDate);
                } else {
                    $date[$b] = $cacheDate;
                }
                unset($cacheData);
            }
        }
        return $date;

    }

    public function wpjam_is_holiday($data_time)
    {
        $ch = curl_init();
        $url = 'http://apis.baidu.com/xiaogg/holiday/holiday?d=20151001';
        $header = array(
            'apikey: d3b9d4a6e448764761cd9917e11398d0',
        );
        // 添加apikey到header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 执行HTTP请求
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);
        return json_decode($res);
    }


    /**
     * sha1加密方法，加密demo
     *
     * 加密微信user_id
     * @package App\Controller
     *
     * @author  kino <735745089@qq.com>
     * @copyright Copyright (c) 2016 lc.top all rights reserved.
     */
    public function sha1_demo()
    {
        $string = "Helloworld";
        $str1 = $this->dencrypt($string, true, "www.miaohr.com");


        $str2 = $this->dencrypt($str1, false, "www.miaohr.com");
        //dd($str1, $str2);

    }



    /**
     * sha1加密方法，false为解密
     *
     * 加密微信user_id
     * @package App\Controller
     *
     * @author  kino <735745089@qq.com>
     * @copyright Copyright (c) 2016 lc.top all rights reserved.
     */

    public function dencrypt($string, $isEncrypt = true, $key = KEY_SPACE)
    {


        /*if (!isset($string{0}) || !isset($key{0})) {
            return false;
        }*/

        $dynKey = $isEncrypt ? hash('sha1', microtime(true)) : substr($string, 0, 40);
        $fixedKey = hash('sha1', $key);

        $dynKeyPart1 = substr($dynKey, 0, 20);
        $dynKeyPart2 = substr($dynKey, 20);
        $fixedKeyPart1 = substr($fixedKey, 0, 20);
        $fixedKeyPart2 = substr($fixedKey, 20);
        $key = hash('sha1', $dynKeyPart1 . $fixedKeyPart1 . $dynKeyPart2 . $fixedKeyPart2);

        $string = $isEncrypt ? $fixedKeyPart1 . $string . $dynKeyPart2 : (isset($string{339}) ? gzuncompress(base64_decode(substr($string, 40))) : base64_decode(substr($string, 40)));

        $n = 0;
        $result = '';
        $len = strlen($string);

        for ($n = 0; $n < $len; $n++) {
            $result .= chr(ord($string{$n}) ^ ord($key{$n % 40}));
        }

        return $isEncrypt ? $dynKey . str_replace('=', '', base64_encode($n > 299 ? gzcompress($result) : $result)) : substr($result, 20, -20);
    }


    /**
     * 替换压缩图方法
     *
     * @package App\Controller
     *
     * @author  kino <735745089@qq.com>
     * @copyright Copyright (c) 2016 lc.top all rights reserved.
     */

    public function change_reurl($data,$size)
    {
       foreach ($data as $k => $v){
           $v -> re_img_url = resize_url($v -> img_url,$size);
       }

        return $data;

    }

    //取出数组值
    public function get_arr_val($data,$val)
    {

        $arr = array();
        foreach ($data as $k => $v){
            if($v -> $val == ''){
                $v -> $val = '其它';
            }
            $arr[] = $v -> $val;
        }

        return $arr;

    }

    //硬删除图片
    public function img_unlink($img)
    {

        $old_unlink = str_replace(env('assets').'/',"",$img);

        if(file_exists($old_unlink)){
            unlink($old_unlink);
        }


    }




}
