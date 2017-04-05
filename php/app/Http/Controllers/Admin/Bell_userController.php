<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use DB,App\Models\Integration,Input,App\Models\SendSMS,App\Models\Baby;
use Validator,Auth,App\Models\Bell_user;
use App\Http\Requests;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;

class Bell_userController extends Controller
{
    public function Send_sms()
    {
        $mobile = Input::get('username');
        $mobile = '13217616078';
        $sendsms = new SendSMS();
        $rst = $sendsms->send_sms($mobile, 'sign_up');
        if ($rst['sta'] == 1) {
            return json_encode(['sta' => '1', 'msg' => '请求成功', 'data' => $rst], JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(['sta' => '0', 'msg' => $rst['msg'], 'data' => ''], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     *
     * 宝贝信息录入
     * 身高体重， 男女，生日，性别,是否提醒生日
     */
    public function baby_info(Request $request)
    {
        $bady=new Baby();
        $data['gender'] = Input::get('gender');
        $data['birthday'] = Input::get('birthday');
        $data['baby_weight'] = Input::get('baby_weight');
        $data['remind'] = Input::get('remind');
        $data['MOM_id'] = Auth::id();
        $message = [
            'gender.required' => "请选择宝贝的性别",
            'baby_weight.required' => '请填写宝贝的体重',
            'birthday.required' => '请填写宝贝的生日',
            'remind.required' => '请选择是否提醒宝贝生日'
        ];
        //计算宝贝多大
        $data['bady_age']=Controller::calcAge($data['birthday']);
        $validate= Validator::make($data, $message, $bady->rules()['create']);
        $messages = $validate->messages();
        if ($validate->fails()) {
            $msg = $messages->toArray();
            foreach ($msg as $k => $v) {
                return json_encode(['sta' => '0', 'msg' => $v[0], 'data' => '']);
            }
        }
        $rst = Baby::create($data);
        if($rst){
            return json_encode(['sta' => '1', 'msg' =>'请求成功', 'data' => $rst]);
        }else{
            return json_encode(['sta' => '0', 'msg' =>'请求失败', 'data' => '']);
        }

    }



    /**
     *这里需要单独存一个表，积分放到用户表
     *签到，验证（登陆状态）
     *判断是否已签到过了date('Y-m-d'),如果已签到就直接返回地址
     *返回当前月所有已经签到过得日期。
     *为签到则获得积分。
     */
    public function User_Integration()
    {
        //获取当前时间。
        $user_id=Input::get('user_id');
        $flush=Integration::where('user_id',$user_id)->select('sign_time')->orderBy('id','desc')->limit(1)->get()->toArray();
        if(empty($flush)){
            //更新积分
            Bell_user::where('id',$user_id)->update(['integral',Auth::user()->get()->integral+2]);
        }else{
            return json_encode(['msg'=>'您今天已经签到过了！','sta'=>'0','data'=>'']);
        }
        //根据上面的结果来查询这个月有几天是签到过得。
        $All_in=DB::select("SELECT sign_time FROM Integration WHERE user_id = ".$user_id." AND DATE_FORMAT(NOW(),'%Y-%m-%d')");
        return json_encode(['msg'=>'请求成功','sta'=>'1','data'=>$All_in]);
    }

    /**
     * Show the form for creating a new resource.
     * 用户注册（仅限手机用户），接收手机号码，短信验证码
     * 验证用户手机号合法性，验证该手机用户是否已注册，验证该手机用户验证码正确性与实时性。
     * 验证用户密码，最后Bell_user->save();
     * @return \Illuminate\Http\Response
     */
    public function sign_up(Request $request)
    {

        $data=$request->all();
        $data['type']='phone';
        $data['name']='13217616078';
        $data['password']='123123';
        $data['user_code']="5683";
        $user_SMS = Redis::exists('user_SMS');
        if ($user_SMS == 1 && $data) {
            $send_num_data = Redis::get('user_SMS');
            $send_num = json_decode($send_num_data, true);
            if ($data['user_code'] == $send_num['code']) {
                //验证码5分钟内有效
                $endtime = date('Y-m-d H:i:s', $send_num['Send_time'] + 600);
                $this_time = date('Y-m-d H:i:s', time());
                //当前时间是否大于发送时间+时间限制 在限制时间内，当前时间小于发送时间+限制
                $second = intval((strtotime($this_time) - strtotime($endtime)) % 86400);
                if ($second <> 0 && $second > 0) {
                    Redis::del('user_SMS');
                    return json_encode(['sta' => "1", 'msg' => '验证码已过期，请重新申请', 'data' => ""], JSON_UNESCAPED_UNICODE);
                }
                if ($data['name'] != $send_num['user_mobile']) {
                    return json_encode(['msg' => "验证用户不一致！", 'sta' => "1", 'data' => ''], JSON_UNESCAPED_UNICODE);
                }
                $bell_user = new User();
                $validate = Validator::make($data, $bell_user->rules()['create']);
                $messages = $validate->messages();
                if ($validate->fails()) {
                    $msg = $messages->toArray();
                    foreach ($msg as $k => $v) {
                        return json_encode(['sta' => "1", 'msg' => $v[0], 'data' => ''], JSON_UNESCAPED_UNICODE);
                    }
                }
                $use_data = $bell_user->create($data);
                Auth::login($use_data);
                // $data = User::where(['username'=>$request->username])->update(['created_by' => Auth::id()]);
                if ($data) {
                    Redis::del('user_SMS');
                    return json_encode(['sta' => "0", 'msg' => '注册成功', 'data' => $data], JSON_UNESCAPED_UNICODE);
                }
            } else {
                return json_encode(['msg' => "验证码错误", 'sta' => "1", 'data' => '']);
            }
        }


    }

    /**
     *
     * 第三方登陆集合
     * QQ wechat,weibo
     * 获取账号类型，与对应openid
     */
    protected function  ThirdParty(){
        $type=Input::get('type');//账号类型QQ，wechat,weibo
        $Account_type=$type;







    }
    /**
     * 用户找回密码
     */
    public function findPass(){

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
