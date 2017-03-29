<?php

namespace App\Models;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Model;
use Eloquent;
date_default_timezone_set("Asia/Shanghai");
class SendSMS extends Eloquent
{
    public function isMobile($mobile)
    {
        if (!is_numeric($mobile)) {
            return false;
        }
        return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
    }

    /**
     * @param int $len
     * @return string
     */
    public function get_random($len = 2)
    {
        //range 是将10到99列成一个数组
        $numbers = range(10, 99);
        //shuffle 将数组顺序随即打乱
        shuffle($numbers);
        //取值起始位置随机
        $start = mt_rand(1, 10);
        //取从指定定位置开始的若干数
        $result = array_slice($numbers, $start, $len);
        $random = "";
        for ($i = 0; $i < $len; $i++) {
            $random = $random . $result[$i];
        }
        return $random;
    }

    /**
     * @param Request $request
     * @return mixed
     ** 调用sms短息接口
     * 返回接口状态
     * register 注册
     */
    public function index(Request $request)
    {
        //获取手机号码
        $mobile_number = Input::get("moblie_number");
        //判断用户是否已注册
        $set_user = User::where(['username' => $mobile_number])->select('id')->get()->toArray();
        if (!empty($set_user)) {
            return json_encode(["msg" => "用户已注册，请登陆", "sta" => 1, "data" => ""], JSON_UNESCAPED_UNICODE);
        } else {
            $send_SMS = $this->send_sms($mobile_number, "register");
            if ($send_SMS['sta'] == 0) {
                return json_encode(['msg' => '短信发送成功', 'sta' => 0, 'data' => $send_SMS['code']], JSON_UNESCAPED_UNICODE);
            } else {
                return json_encode(['msg' => $send_SMS['msg'], 'sta' => 1, 'data' => ''], JSON_UNESCAPED_UNICODE);
            }
        }
    }

    /**
     * @param $mob
     * @return mixed
     * 发送请求
     */
    public function Tohttp_requst($mob,$code)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://api.weimi.cc/2/sms/send.html");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        $uid = '5CipH7ou8gpw';
        $pas = 'hbnv53a3';
        $cid = "R7NwD6BxC0Mc";
        $vcode = $code;
        $p2 = "3";
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'uid=' . $uid . '&pas=' . $pas . '&mob=' . $mob . '&cid=' . $cid . '&p1=' . $vcode . '&p2=' . $p2 . '&type=json');
        $res = curl_exec($ch);
        curl_close($ch);
        return array('res' => $res, 'vcode' => $vcode);
    }

    /**
     * user_phone用户手机号
     * time发送时间
     * num发送次数
     * code 随机验证码
     * type请求发送类型（注册，找回密码）
     * 发送次数验证，当发送次数超过5次时，等待20分钟才可再次发送短信
     */
    public function getnumber($mob, $type)
    {
        $send_num_data = Redis::get('user_Send_num');
        $send_num = json_decode($send_num_data, true);
        if (!empty($send_num)) {
            //时间判断
            $endtime = date('Y-m-d H:i:s', $send_num['Send_time'] + 1200);
            $this_time = date('Y-m-d H:i:s', time());
            $second = intval((strtotime($endtime) - strtotime($this_time)) % 86400);
            //当前时间是否大于发送时间+时间限制 在限制时间内，当前时间小于发送时间+限制
            if ($second <> 0 && $second < 0) {
                Redis::del('user_Send_num');
                $array2 = array(
                    'num' => 1,
                    'user_phone' => $mob,
                    'type' => $type,
                    'Send_time' => time()
                );
            } else {
                Redis::del('user_Send_num');
                $array2 = array(
                    'num' => $send_num['num'] + 1,
                    'type' => $type,
                    'user_phone' => $mob,
                    'Send_time' => $send_num['Send_time']
                );
            }
        } else {
            $array2 = array(
                'num' => 1,
                'user_phone' => $mob,
                'type' => $type,
                'Send_time' => time()
            );
        }
        return $array2;
    }

    /**
     * @param $mob
     * @param null $type
     * @return array
     * 短信接口一，自写短信内容。该接口提交的短信均由人工审核，下发后请联系在线客服。适合：节假日祝福、会员营销群发等。
     * 1、设定微米账号的接口UID和接口密码
     * 2、传入目标手机号码，多个以“,”分隔，一次性调用最多100个号码，示例：139********,138********
     * 3、传入短信内容。必须设置好短信签名，签名规范：
     * 1）短信内容一定要带签名，签名放在短信内容的最前面；
     * 2）签名格式：【***】，签名内容为三个汉字以上（包括三个）；
     * 3）短信内容不允许双签名，即短信内容里只有一个“【】”
     */
    public function send_sms($mob, $type = null)
    {
        $set_type = $this->send_num($mob, $type);
        //dd($set_type);
        if ($set_type['sta'] == 0) { //num < 5
            $vcode = $this->get_random();
            $array2 = $this->getnumber($mob, $type);
            $result = $this->Tohttp_requst($mob,$vcode);
            $data = json_decode($result['res'], true);
            if ($data['code'] == 0) {
                $array = array(
                    'user_phone' => $mob,
                    'Send_time' => time(),
                    'code' => $vcode,
                    'type' => $type
                );
                Redis::set('user_SMS', json_encode($array));
                Redis::set('user_Send_num', json_encode($array2));
                return array('code' => $vcode, 'sta' => 0);
            } else {
                return array('msg' => "短信发送失败，请联系客服！", 'sta' => '1', 'data' => '');
            }
        } else {
            return array('msg' => $set_type['msg'], 'sta' => '1', 'data' => '');

        }
    }


    /**
     * @param $mob
     * @param $type
     * @return bool
     * 当前请求次数 user_Send_num
     * 用户验证码信息 user_SMS
     * 用户注册调用 register
     * 判断手机号码（用户）user_phone
     * 判断发送参数，日期与次数
     * 发送次数等于5，则需等待20分钟才可再次调用；
     * 获取当前请求次数user_Send_num，判断手机号码（用户）是否一致，判断发送日期与当前日期是否一致，判断发送次数是否受限，判断发送时间是否超时；
     * 如果当天请求次数没有达到5次，且超时则清空发送信息记录 user_SMS，return TRUE;   否则 返回错误信息；
     * 如果次数达到5次并没有超时则不发送短信，否则清除发送次数记录 user_Send_num ，return TRUE；
     * 当前时间是否大于发送时间+时间限制
     */
    public function send_num($mob, $type)
    {
        if ($this->isMobile($mob)) {
            if ($type == "register") {
                //判断用户是否已注册
                $set_user = User::where(['username' => $mob])->select('id')->get()->toArray();
                if (!empty($set_user)) {
                    return array("msg" => "用户已注册，请登陆", "sta" => "1", "data" => "");
                }
                $send_num_data = Redis::get('user_Send_num');
                $send_num = json_decode($send_num_data, true);
                if (!empty($send_num)) {
                    $send_date = date('Y-m-d', $send_num['Send_time']) == date('Y-m-d', time());//判断日期
                    if ($send_date == false) {
                        Redis::del('user_Send_num');
                        return array('msg' => '', 'sta' => "0");
                    }
                    if ($mob == $send_num['user_phone'] && $send_num['num'] >= 5 && $send_date == true) {//当天发送次数等于5
                        if (time() < ($send_num['Send_time'] + 600)) {
                            $endtime = date('Y-m-d H:i:s', $send_num['Send_time'] + 600);
                            $this_time = date('Y-m-d H:i:s', time());
                            //当前时间是否大于发送时间+时间限制 在限制时间内，当前时间小于发送时间+限制
                            $second = intval((strtotime($this_time) - strtotime($endtime)) % 86400 / 60);
                            if ($second <> 0 && $second < 0) {
                                $second_time = substr($second, 1);
                                $msg = "系统提示：您的操作过于频繁，请在" . $second_time . "分钟后再试";
                                return array('msg' => $msg, 'sta' => "1");
                            }
                        }
                        Redis::del('user_Send_num');
                        return array('msg' => '', 'sta' => "0");
                    } else {
                        $send_num_data = Redis::get('user_SMS');
                        $send_num = json_decode($send_num_data, true);
                        $endtime1=$send_num['Send_time']+60;
                        if (time() < $endtime1) {
                            $endtime = date('Y-m-d H:i:s', $send_num['Send_time'] + 60);
                            $this_time = date('Y-m-d H:i:s', time());
                            $second = intval((strtotime($this_time) - strtotime($endtime)) % 86400);
                            if ($second <> 0 && $second < 0) { //小于零
                                $second_time = substr($second, 1);
                                $msg = "系统提示：您的操作过于频繁，请在" . $second_time . "秒后再试";
                                return  array('msg' => $msg, 'sta' => "1");
                            }
                        }
                        Redis::del('user_SMS');//清空数据
                        return array('msg' => '', 'sta' => "0");

                    }
                } else {
                    return array('msg' => '', 'sta' => "0");
                }
            } else {
                /**
                 * 别的发送请求
                 */
                return array('msg' => '', 'sta' => "0");
            }
        } else {
            return array('msg' => "短息发送失败，请输入合法的手机号码！", 'sta' => 1, 'data' => '');
        }

    }
}
