<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Image;
use Input;
use App\Models\Sort;
use DB;
use App\Models\User_share;
use App\Models\Order;
use App\Models\Order_goods_info,App\Models\Goods,App\Models\Goods_standard,App\Models\Attributes,App\Models\Dgoods;
use phpDocumentor\Reflection\Types\Object_;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    //请求分页
    public function SetPage()
    {
        $page = Input::get('page') ?: 0;
        if ($page && $page > 0) {
            $page = ($page-1) * 10;
        }
        return $page;
    }
    /**
     * @param $str
     * @return bool
     * 判断字符串是否有特殊字符
     */
    public function unusual($str)
    {
        return preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/", trim($str)) ? true : false;
    }

    /**
     * @param $strParam
     * @return mixed
     *去除特殊字符
     */
    public function replaceSpecialChar($strParam)
    {
        $regex = "/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\|/";
        return preg_replace($regex, "", $strParam);
    }

    /**
     * @param $C_char
     * @return bool
     *
     */
    public function CheckEmptyString($C_char)
    {
        if (!is_string($C_char)) return false; //判断是否是字符串类型
        if (empty($C_char)) return false; //判断是否已定义字符串
        if ($C_char == '') return false; //判断字符串是否为空
        return true;
    }

    /**
     * @param $mobile
     * @return bool
     * 验证手机号码合法性
     */
    public function isMobile($mobile)
    {
        if (!is_numeric($mobile)) {
            return false;
        }
        return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
    }

    /**
     * @param $birthday
     * @return int
     *  根据生日计算年龄
     */
    public function calcAge($birth)
    {

        $date = date_diff(date_create($birth), date_create(date('Y-m-d')));
        return $date->y . '岁' . $date->m . '月' . $date->d . '天';
        /*  $age = 0;
          if(!empty($birthday)){
              $age = strtotime($birthday);
              if($age === false){
                  return 0;
              }

              list($y1,$m1,$d1) = explode("-",date("Y-m-d", $age));

              list($y2,$m2,$d2) = explode("-",date("Y-m-d"), time());

              $age = $y2 - $y1;
              if((int)($m2.$d2) < (int)($m1.$d1)){
                  $age -= 1;
              }
          }
          return $age;*/
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

    public function change_reurl($data, $size)
    {
        foreach ($data as $k => $v) {
            $v->re_img_url = resize_url($v->img_url, $size);
        }

        return $data;

    }

    /**
     * @param int $parent_id
     * @param array $result
     * @return array
     *
     */
    public function getCommlist($parent_id = 0, &$result = array())
    {
        $arr = User_share::where("pid", $parent_id)->orderBy("id", 'desc')->get()->toArray();
        if (empty($arr)) {
            return array();
        }
        foreach ($arr as $cm) {
            $thisArr =& $result[];
            $cm["children"] = $this->getCommlist($cm["id"], $thisArr);
            $thisArr = $cm;
        }
        return $result;
    }

    /**
     * @param $category_id
     * @return string
     *
     */
    public function get_category($category_id)
    {
        $category_ids = $category_id . ",";
        $child_category = DB::select("select id from sort where pid = '$category_id'");
        foreach ($child_category as $key => $val)
            $category_ids .= $this->get_category($val->id);
        return $category_ids;
    }

    /**
     * @param $category_id
     * @return string
     *
     */
     public function get_share_category($category_id)
    {
        $category_ids = $category_id . ",";
        $child_category = DB::select("select id from user_share where pid = '$category_id'");
        foreach ($child_category as $key => $val)
            $category_ids .= $this->get_category($val->id);
        return $category_ids;
    }

    /**
     * @param $id
     *获取用户昵称
     */
    public function get_nackname($id){
        $rst=User::where('id',$id)->select('nickname')->first();
        return $rst->nickname;
    }
    /**
     * @param $url
     * @return bool
     * 验证地址是否合法
     */
    function check_url($url)
    {

        if (!preg_match('/http:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is', $url)) {

            return false;

        }

        return true;

    }

    /**
     * @return array
     */
    public function get_sort_data()
    {
        $sort = Sort::where(['pid' => '0', 'type' => '0'])->select('id', 'pid', 'name')->orderBy('id', 'asc')->orderBy('num', 'asc')->get()->toArray();
        if (!empty($sort)) {
            foreach ($sort as $ky => $vy) {
                $rst = $this->get_category($vy['id']);
                if (strlen($rst) >= 4) {
                    $child = substr($rst, 0, strlen($rst) - 1);
                    $child = explode(',', $child);
                    foreach ($child as $k => $v) {
                        if ($v != $vy['id']) {
                            $result = Sort::where('id', $v)->select('id', 'pid', 'name')->get()->toArray();
                            if (!empty($result)) {
                                $sort[$ky]['child'][$k - 1] = $result[0];
                            }
                        }
                    }
                } else {
                    $sort[$ky]['child'] = "";
                }
            }
        }
        return $sort;
    }

    /**
     *获取用户头像
     */
    public function get_user_info($id)
    {
        $rst = User::where('id',$id)->select('id','nickname','avatar','name')->get()->toArray();
        if(!empty( $rst)){
            foreach($rst as $key=>$rvb){
                if($rst[$key]['avatar']){
                    $rst[$key]['avatar']=md52url($rst[$key]['avatar']);
                }else{
                    $rst[$key]['avatar']="";
                }

                if(empty($rst[$key]['nickname'])){
                    $rst[$key]['nickname']="";
                }
            }
            return $rst[0];
        }
    }

    /**
     * @param $user_id
     * @return string
     * 订单号生成
     */
    public function make_order($user_id)
    {
        return mt_rand(15,99)
        . sprintf('%010d',time() - 946656000)
        . sprintf('%03d', (float) microtime() * 1000)
        . sprintf('%03d', (int) $user_id % 1000);
    }

    /**
     * @param $content
     * @return mixed
     * 去除文章HTML文本格式
     */
    public function ContentProcess($content){
        return trim(htmlspecialchars(str_replace(array("\r\n", "\r", "\n"), "", strip_tags($content))));
    }

    /**
     * @param $DataList
     * arr_name
     * @return mixed
     * 获取列表商品详情
     */
    protected function OrderInfo($DataList)
    {
        if ($DataList) {
            foreach ($DataList as $k => &$vel) {
                $vel['goods'] = Order_goods_info::where('order_id', $vel['order_id'])
                    ->select('goods_id', 'specif', 'brand_id', 'goods_num', 'goods_name','geval')
                    ->get()->toArray();
                $vel['pay_count']=count($vel['goods']);
                $vel['remark'] = $vel['remark'] ?: "";
                foreach ($vel['goods'] as $r => &$v) {
                    if ($v['specif'] != '') {
                        $GetPrice=Goods_standard::where(['goods_id'=>$v['goods_id'],'attributes_id'=>$v['specif']])->first();
                        $v['price']=$GetPrice->price;
                        $v['stock']=$GetPrice->stock;
                        $v['specif'] = $this->SpcifName($v['goods_id'], $v['specif']);
                    }
                    $v['goods_info'] = $this->Set_goods_data($v['goods_id']);
                }
            }
            return $DataList;
        }
    }

    /**
     * 获取规格名称
     */
    private function SpcifName($id, $name)
    {
        $StrArr = explode(',', $name);
        if (!empty($StrArr)) {
            $GoodSort = Goods::find($id);
            if ($GoodSort) {
                $sort_name = "";
                foreach ($StrArr as $key => $vey) {
                    $Att = Attributes::where(['sort_id' => $GoodSort->sort_id, 'id' => $vey])->first();
                    if ($sort_name != '') {
                        $sort_name = $sort_name . ',' . $sort_name = $Att->arr_name;
                    } else {
                        $sort_name = $sort_name = $Att['arr_name'];
                    }
                }
                return $sort_name;
            }
        }
    }
    /**
     * @param $goods_id
     * @return array|string
     * 获取商品详情
     */
    private function Set_goods_data($goods_id)
    {
        $class_sort = Goods::where('id', $goods_id)->first()->toArray();
        if (!$class_sort) {
            $class_sort = "";
        } else {
            $goods_sort = Dgoods::where('gid', $goods_id)->orderBy('id', 'desc')->first();
            if (!empty($goods_sort)) {
                $goods_sort['dimg'] = md52url($goods_sort['dimg']);
                $good_user = $this->get_user_info($goods_sort['uid']);
                $good_user['avatar'] = md52url($good_user['avatar']);
                $class_sort['good_sort'] =$goods_sort;
                $class_sort['good_user'] =$good_user;
            }
            //处理商品详情信息strip_tags
            $class_sort["content"] = $this->ContentProcess($class_sort["content"]);
            $class_sort["Thumbnails"] = md52url($class_sort["Thumbnails"]);
            $plan = $class_sort["plan"];
            $plans = explode(',', $plan);
            $plangs = array();
            for ($i = 0; $i < count($plans); $i++) {
                $plangs[] = md52url($plans[$i]);
            }
            $class_sort["plan"] = $plangs;
        }
        return $class_sort;
    }



}
