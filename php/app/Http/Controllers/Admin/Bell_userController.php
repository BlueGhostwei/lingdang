<?php

namespace App\Http\Controllers\Admin;

use Redirect;
use Response;
use App\Models\Userattention;
use App\Models\User;
use App\Models\Message_record;
use DB, App\Models\Integration, Input, App\Models\SendSMS;
use Validator, Auth, App\Models\Bell_user;
use App\Http\Requests;
use Hash;
use App\Models\Collection;
use App\Models\User_dynamics;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Bell_userController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     * 添加关注
     * 获取关注动态的
     */
    public function add_attention(Request $request)
    {
        $user_id = Input::get('user_id') ?: Auth::id();
        $attention_userid = Input::get('attention_userid');
        $find_user = User::find($attention_userid);
        if ($find_user) {
            $set_attention_userid = Userattention::where(['user_id' => $user_id, 'attention_userid' => $attention_userid])->get()->toArray();
            if (empty($set_attention_userid)) {
                $Userattention = new Userattention();
                Validator::make($request->all(), $Userattention->rules()['create']);
                $Userattention->create($request->only($Userattention->getFillable()));
                //消息日志
                $message_record['user_id'] = $user_id;
                $message_record['remind_name'] = $attention_userid;
                $message_record['userdynamics_id'] = "";
                $message_record['record_type'] = "6";
                $message_record['puser_id'] = '';
                $message_record['record_content'] = '';
                $message_record['record_status'] = '0';
                Message_record::create($message_record);
                return json_encode(['msg' => '关注成功', 'sta' => '1', 'data' => '']);
            } else {
                Userattention::where(['user_id' => $user_id, 'attention_userid' => $attention_userid])->delete();
                return json_encode(['msg' => '取消关注成功', 'sta' => '1', 'data' => '']);
            }
        }
    }


    /**
     *获取关注列表动态
     */
    public function Get_friend_list()
    {

        $user_id = Input::get('user_id');
        if (empty($user_id)) {
            $user_id = Auth::id();
        }
        $user_friend = Userattention::where('user_id', $user_id)
            ->join('user', 'userattention.attention_userid', '=', 'user.id')
            ->select('user.id', 'user.avatar', 'user.nickname', 'user.signature')->get()->toArray();
        //获取好友列表
        foreach ($user_friend as $ky => $vy) {
            if ($vy['avatar'] != '') {
                $user_friend[$ky]['avatar'] = md52url($vy['avatar']);
            }
        }
        return json_encode(['msg' => '请求成功', 'sta' => '1', 'data' => $user_friend]);

    }

    /**
     * @return mixed
     *
     */
    public function check_login()
    {
        return json_encode(['msg' => '', 'sta' => '1', 'data' => Auth::id()]);
    }

    /**
     * @return mixed
     *
     */
    public function Send_sms()
    {
        $mobile = Input::get('mobile');
        $type = Input::get('type');
        $sendsms = new SendSMS();
        if (!empty($type)) {
            $rst = $sendsms->send_sms($mobile, $type);
        } else {
            $rst = $sendsms->send_sms($mobile, 'sign_up');
        }
        if ($rst['sta'] == 1) {
            return json_encode(['sta' => '1', 'msg' => '请求成功', 'data' => $rst], JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(['sta' => $rst['sta'], 'msg' => $rst['msg'], 'data' => ''], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     *
     * 宝贝信息录入
     *
     * 'email', 邮箱
     * 'avatar',头像
     * 'role',权限
     * 'nickname',昵称
     * 'gender',性别
     * 'phone',手机
     * 'wechat',微信
     * 'height'，身高
     * 'birthday',生日
     * 'bady_age',年龄
     * 'location',地址
     * 身高体重， 男女，生日，性别,是否提醒生日
     */
    public function baby_info(Request $request)
    {
        if (Input::get('user_id')) {
            $user_id = Input::get('user_id');
        } else {
            $user_id = Auth::id();
        }
        $bady = User::find($user_id);
        //判断用户昵称是否重复
        if (!empty($request->nickname)) {
            $rst = User::where('nickname', $request->nickname)->where('id', '!=', $user_id)->count();
            if ($rst) {
                return json_encode(['sta' => '0', 'msg' => '请求失败,昵称已被占用', 'data' => ""]);
            }
        }
        /* $data['location'] = Input::get('location');
         $data['avatar'] = Input::get('avatar');
         $data['phone'] = Input::get('mobile');
         $data['birthday'] = Input::get('birthday');
         $data['wechat'] = trim(Input::get('wechat'));
         $data['height'] = trim(Input::get('height'));
         $data['nickname'] = Input::get('nickname');
         $data['gender'] = Input::get('gender');
         $signature = Input::get('signature');*/
        /* $data['birthday'] = Input::get('birthday');*/
        if ($bady) {
            $bady->update($request->all());
        } else {
            return json_encode(['sta' => '0', 'msg' => '请求失败', 'data' => ""]);
        }
        return json_encode(['sta' => '1', 'msg' => '请求成功', 'data' => ""]);
    }


    /**
     *这里需要单独存一个表，积分放到用户表
     *签到，验证（登陆状态）
     *判断是否已签到过了date('Y-m-d'),如果已签到就直接返回地址
     *返回当前月所有已经签到过得日期。
     *为签到则获得积分。
     * sign_time
     */
    public function User_Integration()
    {
        //获取当前时间。
        $user_id = Input::get('user_id');
        $this_time = date('Y-m-d', time());
        if (!empty($user_id)) {
            if ($user_id != Auth::id()) {
                return json_encode(['msg' => '请求失败，参数错误', 'sta' => '0', 'data' => '']);
            }
            $flush = Integration::leftJoin('bell_user', function ($join) {
                $join->on('bell_user.user_id', '=', 'integration.user_id');
            })->where('integration.user_id', $user_id)->select("*")->limit(1)->orderBy('integration.id', 'desc')->get()->toArray();
            $set_bell_user = Bell_user::where('user_id', $user_id)->first();
            if (empty($flush)) {
                //更新积分
                Bell_user::where('user_id', $user_id)->update(['integral' => 2, 'sign_sta' => '1']);
                Integration::create(['user_id' => $user_id, 'sign_time' => date('Y-m-d H:i:s', time())]);
            } else {
                foreach ($flush as $ky => $rs) {
                    $old_time = date("Y-m-d", strtotime($rs['sign_time']));
                    // dd($this_time == $old_time);
                    if ($this_time == $old_time) {
                        $set_rst[$ky] = $old_time;
                    } else {
                        //判断是否连续签到
                        $set_flush_inte = Integration::where('user_id', $user_id)->orderBy('id', 'desc')->limit(1)->first();
                        $get_old_time = date('Y-m-d', strtotime($set_flush_inte->sign_time));
                        /* dd($get_old_time == date('Y-m-d', strtotime("$this_time-1 day")));*/
                        //开启事务
                        DB::beginTransaction();
                        try {
                            if ($get_old_time == date('Y-m-d', strtotime("$this_time-1 day"))) {
                                Bell_user::where('user_id', $user_id)->update(['sign_sta' => $set_bell_user->sign_sta + 1, 'integral' => $set_bell_user->integral + 2]);
                                Integration::create(['user_id' => $user_id, 'sign_time' => date('Y-m-d H:i:s', time())]);
                            } else {
                                Bell_user::where('user_id', $user_id)->update(['sign_sta' => 1, 'integral' => $set_bell_user->integral + 2]);
                                Integration::create(['user_id' => $user_id, 'sign_time' => date('Y-m-d H:i:s', time())]);
                            }
                            //中间逻辑代码 DB::commit();
                        } catch (\Exception $e) {
                            DB::rollBack();
                            //接收异常处理并回滚 DB::rollBack();
                        }
                    }
                }
            }
        }
        //根据上面的结果来查询这个月有几天是签到过得。
        //$All_in = DB::select("select sign_time from integration where user_id =" . Auth::id() . " AND strcmp(date_format(sign_time,'%Y-%m'),'" . date('Y-m', time()) . "') =  0");
        $All_in = DB::select("select sign_time from integration where user_id =" . Auth::id());
        $bell_user = Bell_user::where('user_id', Auth::id())->first();
        if (!$All_in) {
            return json_encode(['msg' => '请求成功', 'sta' => '1', 'data' => [
                'time' => [],
                'num' => $bell_user->sign_sta,
                'integral' => $bell_user->integral
            ]]);
        } else {
            $ret = array();
            foreach ($All_in as $ky => $vy) {
                $ret[$ky] = $vy->sign_time;
            }
            $data = [
                'time' => $ret,
                'num' => $bell_user->sign_sta,
                'integral' => $bell_user->integral
            ];
            return json_encode(['msg' => '签到成功', 'sta' => '1', 'data' => $data]);
        }

    }

    /**
     * Show the form for creating a new resource.
     * 用户注册（仅限手机用户），接收手机号码，短信验证码
     * 验证用户手机号合法性，验证该手机用户是否已注册，验证该手机用户验证码正确性与实时性。
     * 验证用户密码，最后Bell_user->save();
     *
     * @return \Illuminate\Http\Response
     */
    public function sign_up()
    {
        $data = Input::all();
        $data['type'] = '1';
        $data['name'] = Input::get('name');
        $data['password'] = Input::get('password');
        $data['password_confirmation'] = Input::get('password');
        $data['user_code'] = Input::get('user_code');
        $data['role'] = "3";
        $user_SMS = Redis::exists('user_SMS_' . $data['name']);
        if ($user_SMS == 1 && $data) {
            $send_num_data = Redis::get('user_SMS_' . $data['name']);
            $send_num = json_decode($send_num_data, true);
            if ($data['user_code'] == $send_num['code']) {
                //验证码5分钟内有效
                $endtime = date('Y-m-d H:i:s', $send_num['Send_time'] + 600);
                $this_time = date('Y-m-d H:i:s', time());
                //当前时间是否大于发送时间+时间限制 在限制时间内，当前时间小于发送时间+限制
                $second = intval((strtotime($this_time) - strtotime($endtime)) % 86400);
                if ($second <> 0 && $second > 0) {
                    Redis::del('user_SMS_' . $data['name']);
                    return json_encode(['sta' => "0", 'msg' => '验证码已过期，请重新申请', 'data' => ""], JSON_UNESCAPED_UNICODE);
                }
                if ($data['name'] != $send_num['user_mobile']) {
                    return json_encode(['msg' => "验证用户不一致！", 'sta' => "0", 'data' => ''], JSON_UNESCAPED_UNICODE);
                }
                if (empty(Input::get('nickname'))) {
                    return json_encode(['msg' => "昵称不能为空", 'sta' => "0", 'data' => ''], JSON_UNESCAPED_UNICODE);
                }
                $set_nickname = User::where('nickname', Input::get('nickname'))->count();
                if ($set_nickname) {
                    return json_encode(['msg' => "该昵称已被占用", 'sta' => "0", 'data' => ''], JSON_UNESCAPED_UNICODE);
                }
                $user = new User();
                $validate = Validator::make($data, $user->rules()['create']);
                $messages = $validate->messages();
                if ($validate->fails()) {
                    $msg = $messages->toArray();
                    foreach ($msg as $k => $v) {
                        return json_encode(['sta' => "0", 'msg' => $v[0], 'data' => ''], JSON_UNESCAPED_UNICODE);
                    }
                }
                $use_data = $user->create($data);
                if ($use_data) {
                    //创建关系表
                    $bell_user = new Bell_user();
                    $bell_user->create(['user_id' => $use_data->id]);
                }
                if ($data) {
                    Redis::del('user_SMS_' . $data['name']);
                    Redis::del('user_Send_num_' . $data['name']);
                    return json_encode(['sta' => "1", 'msg' => '注册成功', 'data' => $use_data], JSON_UNESCAPED_UNICODE);
                }
            } else {
                return json_encode(['msg' => "验证码错误", 'sta' => "0", 'data' => '']);
            }
        }
    }


    /**
     * @return mixed
     *
     */
    public function user_login()
    {
        $username = Input::get('name');
        $password = Input::get('password');
        $remember = Input::get('remember', true);
        $field = isEmail($username) ? 'email' : 'name';
        $redirect = urldecode(Input::get('redirect', '/'));
        $data['id'] = User::where(array(
            'name' => $username,
            'deleted_at' => NULL,
            'type' => 1
        ))->get();
        if (count($data['id']->toArray()) > 0) {
            $id_data = $data['id']->toArray();
            $data['id'] = $id_data['0']['id'];
            $rst = Auth::attempt([$field => $username, $field => $username, 'password' => $password], $remember);
            if ($rst == false) {
                return json_encode(['msg' => "用户名或者密码错误", 'sta' => 0, 'data' => '']);
            }
            $dynmics = User_dynamics::where('user_id', Auth::id())->count();
            //获取用户关注好友个数Userattention
            $attention = Userattention::where('user_id', Auth::id())->count();
            //获取关注用户粉丝个数
            $Fans = Userattention::where('attention_userid', Auth::id())->count();
            //记录登陆状态
            $arr = ['token' => Input::get('_token'), 'time' => time()];
            Redis::set($username . '_token', json_encode($arr));
            $data = ([
                'id' => $data['id'],
                'rst' => $rst,
                'username' => $username,
                'password' => $password,
                'redirect' => $redirect,
                'dynmics' => $dynmics,
                'attention' => $attention,
                'fans' => $Fans,
            ]);
            return json_encode(['msg' => '登录成功', 'sta' => '1', 'data' => $data]);
        } else {
            return json_encode(['msg' => "用户名或者密码错误", 'sta' => 0, 'data' => '']);
        }
    }

    /**
     *
     * 第三方登陆集合
     * QQ wechat,weibo
     * 获取账号类型，与对应openid
     *
     */
    protected function ThirdParty()
    {
        $type = Input::get('type');//账号类型QQ，wechat,weibo
        $Account_type = $type;


    }

    /**
     * 用户找回密码
     * bcrypt($password)
     */
    public function findPass(Request $request)
    {
        $name = Input::get('name');
        $code = Input::get('user_code');
        $password = Input::get('new_pass');
        $data = User::where('name', $name)->first();
        if (empty($data->name)) {
            return json_encode(['sta' => "0", 'msg' => '用户不存在，请注册', 'data' => ""], JSON_UNESCAPED_UNICODE);
        }
        $user_SMS = Redis::exists('user_SMS_' . $name);
        if ($user_SMS == 1 && $data) {
            $send_num_data = Redis::get('user_SMS_' . $name);
            $send_num = json_decode($send_num_data, true);
            if (trim($code) == $send_num['code']) {
                //验证码5分钟内有效
                $endtime = date('Y-m-d H:i:s', $send_num['Send_time'] + 600);
                $this_time = date('Y-m-d H:i:s', time());
                //当前时间是否大于发送时间+时间限制 在限制时间内，当前时间小于发送时间+限制
                $second = intval((strtotime($this_time) - strtotime($endtime)) % 86400);
                if ($second <> 0 && $second > 0) {
                    Redis::del('user_SMS_' . $name);
                    return json_encode(['sta' => "0", 'msg' => '验证码已过期，请重新申请', 'data' => ""], JSON_UNESCAPED_UNICODE);
                }
                if ($data->name != $send_num['user_mobile']) {
                    return json_encode(['msg' => "验证用户不一致！", 'sta' => "0", 'data' => ''], JSON_UNESCAPED_UNICODE);
                }
                if (Hash::check($password, $data->password)) {
                    return json_encode(['sta' => "0", 'msg' => '密码与原密码太过于相似', 'data' => ""], JSON_UNESCAPED_UNICODE);
                }
                $data->password = bcrypt($password);
                $use_data = User::where('name', $name)->update(['password' => bcrypt($password)]);
                if ($use_data) {
                    Redis::del('user_SMS_' . $name);
                    Redis::del('user_Send_num_' . $name);
                    return json_encode(['sta' => "1", 'msg' => '密码修改成功', 'data' => $use_data], JSON_UNESCAPED_UNICODE);
                }
            } else {
                return json_encode(['msg' => "验证码错误", 'sta' => "0", 'data' => '']);
            }
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
