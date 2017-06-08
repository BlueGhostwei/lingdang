<?php

namespace App\Http\Controllers\Admin;

use App\Models\Collection;
use App\Models\User;
use App\Models\User_share;
use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Message_record;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Input;
use App\Models\Userattention;
use phpDocumentor\Reflection\Types\Null_;
use Pusher;
use Validator;
use DB;
use Illuminate\Support\Facades\Redis;
use Auth;
use App\Models\User_dynamics;
use App\Http\Controllers\Controller;

class Apicontroller extends Controller
{


    public function user_send_sms()
    {
        return json_encode(['sta' => "1", 'msg' => "测试接口", 'data' => ""]);
    }


    /**
     *
     * 首页数据
     */
    public function HomeData()
    {
        //banner图片
        $data['photo'] = Photo::orderBy('number', 'asc')->get()->toArray();
        if (!empty($data['photo'])) {
            foreach ($data['photo'] as $ky => $rs) {
                $data['photo'][$ky]['img_Md5'] = md52url($rs['img_Md5']);
            }
        } else {
            $data['photo'] = [];
        }
        //热门话题（加##的话题达到1万阅读量可上热门话题栏）
        $data['hot_topic'] = "";
        //热门动态（热门动态：转发率，评论，点赞，其中一样在5个小时内高达200，24小时内高达3000的动态;
        //$time = date("Y-m-d H:i:s", time() - 18000);
        $time =date("Y-m-d",strtotime("-1 day"));
        //点赞，转发统计 ，判断是否是好友动态，判断用户登录状态
        if(Auth::check()==true){
            $data['Popular_dynamic'] = User_dynamics::where(["created_at", '>', $time,'Authority'=>0])
                ->orWhere('comment_num', '>=', 500)
                ->orWhere('send_out_num', '>=', 500)
                ->orWhere('like_num', '>=', 500)
                ->orWhere('Authority','1')
                ->orderBy('created_at', 'desc')
                ->limit(10)->get()->toArray();
            if (empty($data['Popular_dynamic'])) {
                $data['Popular_dynamic'] = User_dynamics::orderBy('comment_num', 'desc')
                    ->orderBy('send_out_num', 'desc')
                    ->orderBy('like_num', 'desc')
                    ->orderBy('created_at', 'desc')->where('Authority',0)->limit(10)->get()->toArray();
                if(empty($data['Popular_dynamic'])){
                    $data['Popular_dynamic']=[];
                }
                    $data['Popular_dynamic']=$this->Dataprocess($data['Popular_dynamic']);
            }else{
                $data['Popular_dynamic']=$this->Dataprocess($data['Popular_dynamic']);
            }
            //所关注用户的动态
            $data['dynamics'] = User_dynamics::select('userdynamics.*')
                ->where(["userdynamics.Authority"=>"0"])
                ->join('userattention', 'userdynamics.user_id', '=', 'userattention.user_id')
                ->join('user','userattention.attention_userid','=','user.id')
                ->orderBy('userdynamics.created_at', 'desc')->limit(10)->get()->toArray();
            $data['dynamics']=$this->Dataprocess($data['dynamics']);

        }else{
            /**未登录数据处理*/
            $data['Popular_dynamic'] = User_dynamics::where(["created_at", '>', $time,'Authority'=>0])
                ->orWhere('comment_num', '>=', 500)
                ->orWhere('send_out_num', '>=', 500)
                ->orWhere('like_num', '>=', 500)
                ->orderBy('created_at', 'desc')
                ->limit(10)->get()->toArray();
            if (empty($data['Popular_dynamic'])) {
                $data['Popular_dynamic'] = User_dynamics::orderBy('comment_num', 'desc')
                    ->orderBy('send_out_num', 'desc')
                    ->orderBy('like_num', 'desc')
                    ->orderBy('created_at', 'desc')->where('Authority',0)->limit(10)->get()->toArray();
                if(empty($data['Popular_dynamic'])){
                    $data['Popular_dynamic']=[];
                }
                $data['Popular_dynamic']=$this->Dataprocess($data['Popular_dynamic']);
            }else{
                $data['Popular_dynamic']=$this->Dataprocess($data['Popular_dynamic']);
            }
            $data['dynamics']=[];
            $data['Popular_dynamic'] = User_dynamics::where("created_at", '>', $time)
                ->orWhere('comment_num', '>=', 500)
                ->orWhere('send_out_num', '>=', 500)
                ->orWhere('like_num', '>=', 500)
                ->orderBy('created_at', 'desc')->where('Authority',0)->limit(10)->get()->toArray();
        }

        return json_encode(['sta' => '1', 'msg' => "请求成功", 'data' => $data]);
    }


    /**
     * @return string
     * 用户粉丝列表
     */
    public function GetFansList()
    {
        $page = Input::get('page');
        if (empty($page)) {
            $UserFansList = Userattention::where('userattention.attention_userid', Auth::id())
                ->join('user', 'userattention.attention_userid', '=', 'user.id')
                ->select('user.id', 'user.avatar', 'user.nickname', 'user.signature')
                ->offset(0)->orderBy('userattention.id', 'desc')
                ->limit(10)->get()->toArray();
        } else {
            $UserFansList = Userattention::where('userattention.attention_userid', Auth::id())
                ->join('user', 'userattention.attention_userid', '=', 'user.id')
                ->select('user.id', 'user.avatar', 'user.nickname', 'user.signature')
                ->offset(($page - 1) * 10)->orderBy('id', 'desc')
                ->limit(10)->get()->toArray();
        }
        //获取好友列表
        if ($UserFansList) {
            foreach ($UserFansList as $ky => &$vy) {
                if (!empty($vy['avatar'])) {
                    $vy['avatar'] = md52url($vy['avatar']);
                } else {
                    $vy['avatar'] = "";
                }
            }
        } else {
            $UserFansList = [];
        }
        return json_encode(['sta' => "1", 'data' => $UserFansList, 'msg' => "请求成功"]);
    }


    /**
     *验证登陆
     */
    public function check_user_login()
    {

        $username = Input::get('name');
        if (Redis::exists($username . '_token')) {
            $rst = json_decode(Redis::get($username . '_token'), true);
            if (!empty($rst)) {
                if ($rst['token'] == Input::get('_token')) {
                    //计算时间
                    $thistime = time();
                    if (strtotime("+1week", strtotime(date('Y-m-d', $rst['time']))) > $thistime) {
                        $sele_user = User::where('name', $username)->first();
                        Auth::login($sele_user);
                        return json_encode(['sta' => "1", 'msg' => '自动登陆成功', 'data' => csrf_token()]);
                    }
                }
            }
        }
        return json_encode(['sta' => "0", 'msg' => '自动登陆失败', 'data' => ""]);

    }

    /**
     * Display a listing of the resource.
     *  app首页轮播banner
     * @return \Illuminate\Http\Response
     */
    public function Api_logo()
    {
        $photo = Photo::orderBy('number', 'asc')->get()->toArray();
        foreach ($photo as $ky => $rs) {
            $photo[$ky]['img_Md5'] = md52url($rs['img_Md5']);
        }
        return json_encode(['msg' => '请求成功', 'data' => $photo, 'sta' => '1']);
    }


    /**
     * @param $set_diary
     * @return mixed
     */
    protected function Dataprocess($set_diary){
        foreach ($set_diary as $ky => $vy) {
            $set_diary[$ky]['user_id'] = $this->get_user_info($vy['user_id']);
            //处理图片
            if (!empty($vy['img_photo'])) {
                $img = explode(',', $vy['img_photo']);
                $set_data = array();
                foreach ($img as $rst => $rvb) {
                    if (!empty($rvb)) {
                        $set_data[$rst] = md52url($rvb);
                    } else {
                        $set_data[$rst] = "";
                    }
                }
                $set_diary[$ky]['img_photo'] = $set_data;
            } else {
                $set_diary[$ky]['img_photo'] = [];
            }
            $id = $vy['id'];
            //判断当前用户是否点赞该动态
            $set_diary[$ky]['selflaud'] = Collection::where(['userdynamics_id' => $vy['id'], "user_id" => $vy['user_id']])->count();
            //获取点赞数
            $set_diary[$ky]['set_Favor']=Collection::where(['userdynamics_id'=>$id,'type'=>2])->count();
            //获取转发
            $set_diary[$ky]['set_Forwar'] =Collection::where(['userdynamics_id'=>$id,'type'=>1])->count();
            //获取评论数
            $set_diary[$ky]['set_comment']=User_share::where('userdynamics_id',$id)->count();
            //该用户是否评论此条说说
            if(Auth::check()==true){
                $self_share = User_share::select('id')->where('user_id', Auth::id())->first();
                //查看当前用户是否关注该用户
                $set_diary[$ky]['selfavor'] = Userattention::where(['user_id' => Auth::id(), 'attention_userid' => $vy['user_id']])->count();
            }else{
                $self_share="";
                $set_diary[$ky]['selfavor']="0";
            }
            if ($self_share) {
                $set_diary[$ky]['self_share'] = "0";
            } else {
                $set_diary[$ky]['self_share'] = "1";
            }
            //获取每条动态的评论及评论回复
            $set_diary[$ky]['set_share'] = User_share::where(['userdynamics_id' => $vy['id']])->orderBy('created_at', 'asc')->get()->toArray();
            //dd($set_diary[$ky]['set_share']);
            if (!empty($set_diary[$ky]['set_share'])) {
                //获取评论者头像，昵称，ID
                foreach ($set_diary[$ky]['set_share'] as $ksy => $vsy) {
                    $set_diary[$ky]['set_share'][$ksy]['share_user_info'] = $this->get_user_info($vsy['user_id']);
                    $set_diary[$ky]['set_share'][$ksy]['share_puser_info'] = $this->get_user_info($vsy['pid']);
                }
            } else {
                $set_diary[$ky]['set_share'] = [];
            }
        }
        return $set_diary;
    }
    /**
     *'user_dynamics's
     * 发表日志
     */
    public function daily_record()
    {
        /* $myfile = fopen("alipay_log.txt","w");
         fwrite($myfile,var_export(Input::all(),true));
         fclose($myfile);*/
        $data['user_id'] = Auth::id();
        $data['content'] = Input::get('content');
        $img_photo = Input::get('img_photo');
        if (!empty($img_photo)) {
            $data['img_photo'] = implode(',', $img_photo);
        } else {
            $data['img_photo'] = $img_photo;
        }
        $data['remind_friend'] = Input::get('remind_friend');
        if ($data['content'] == null) {
            return json_encode(['msg' => '日记内容不能为空', 'sta' => '0', 'data' => ''], JSON_UNESCAPED_UNICODE);
        }
        $data['Authority'] = Input::get('Authority');
        $data['comment_num'] = '';
        $data['like_num'] = '';
        $data['send_out_num'] = '';
        $rst = User_dynamics::create($data);
        if ($rst) {
            //消息通知事件
            //返回状态
            return json_encode(['msg' => '发表成功', 'sta' => '1', 'data' => $rst], JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(['msg' => '请求失败', 'sta' => '0', 'data' => ''], JSON_UNESCAPED_UNICODE);
        }

    }

    /**
     * @return mixed
     * 日记点赞
     */
    public function Collection_diary()
    {
        $diary_data = New Collection();
        $diary_data->user_id = Auth::id();
        $diary_data->userdynamics_id = Input::get('userdynamics_id');
        $dynamics = User_dynamics::find($diary_data->userdynamics_id);
        if (!$dynamics) {
            return json_encode(['sta' => '0', 'msg' => "服务器错误，请求失败", 'data' => '']);
        }
        if (empty($diary_data->userdynamics_id)) {
            return json_encode(['sta' => '0', 'msg' => "请选择点赞动态", 'data' => '']);
        }
        $diary_data->type = "2";
        if ($diary_data->user_id || $diary_data->userdynamics_id) {
            $set_diary = Collection::where(['user_id' => $diary_data->user_id, 'userdynamics_id' => $diary_data->userdynamics_id])->first();
            if ($set_diary) {
                $set_diary->delete();
                return json_encode(['sta' => '0', 'msg' => '取消点赞成功', 'data' => '']);
            }
            $rst = $diary_data->save();
            $rgd = $dynamics->update(['like_num' => $dynamics->like_num + 1]);
            /* //消息通知日志表
             $Message_record=New Message_record();
             $data['userdynamics_id']=Input::get('userdynamics_id');
             $data['user_id']=Auth::id();
             $data['record_type']="1";
             $data['puser_id']="";//评论转发，或者回复者id
             $messages="";*/
            if (!$rst) {
                return json_encode(['sta' => '0', 'msg' => '点赞失败', 'data' => '']);
            }
        } else {
            return json_encode(['sta' => '0', 'msg' => '请求失败，参数错误', 'data' => '']);
        }
        return json_encode(['sta' => '1', 'msg' => '点赞成功', 'data' => '']);
    }

    /**
     * 日记转发
     * 这里一条链接跳转链接，图片标题 ，带评论内容
     * 获取日记id，第一张图片，标题。附带查看日志详情链接
     */
    public function diary_forwarding()
    {
        $id = Input::get('id');
        $get_user_dynamics = User_dynamics::where('id', $id)->get()->toArray();
        if ($get_user_dynamics) {
        } else {
            return json_encode(['sta' => '1', 'msg' => "", 'data' => '']);
        }

    }


    /**
     *
     * 用户评论
     * 无限循环评论，用户回复评论，获取上级评论id作为此次回复的pid。
     * 评论消息通知；
     *
     * 回去动态id，评论人id，回复内容，回复图片等信息
     * 如果是回复别人的评论，则获取上一级的id作为此次pid。
     */
    public function User_Share(Request $request)
    {
        $User_share = New User_share();
        $data['userdynamics_id'] = $request->userdynamics_id;//动态id
        $dynamics = User_dynamics::find($request->userdynamics_id);
        if (!$dynamics) {
            return json_encode(['msg' => "请求失败,服务器错误", 'sta' => '0', 'data' => ''], JSON_UNESCAPED_UNICODE);
        }
        $data['user_id'] = Input::get('user_id');
        $data['share_content'] = $request->share_content;
        $data['pid'] = $request->pid;
        if (is_array($request->share_pic)) {
            $data['share_pic'] = implode(',', $request->share_pic);
        } else {
            $data['share_pic'] = $request->share_pic;
        }
        $vali = Validator::make($data, $User_share->rules()['create']);
        if ($vali->fails()) {
            return json_encode(['msg' => "请求失败，请重新尝试", 'sta' => '0', 'data' => ''], JSON_UNESCAPED_UNICODE);
        }
        $rst = $User_share->create($data);
        $dynamics->update(['comment_num' => $dynamics->comment_num + 1]);
        //消息日志
        //发送消息通知
        if ($rst) {
            return json_encode(['msg' => "请求成功", 'sta' => '1', 'data' => ''], JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(['msg' => "请求失败，服务器错误", 'sta' => '0', 'data' => ''], JSON_UNESCAPED_UNICODE);
        }
    }


    /**
     * @return mixed
     *  * 获取好友动态信息
     * 任何用户都可以请求此接口
     * 需要参数：动态id(userdynamics_id)
     * 分两部分，动态内容，评论部分
     * 另需统计参数：转发数，点赞数
     */
    public function GetUserShare_list()
    {
        $page = Input::get('page');
        if (empty($page)) {
            $set_diary = User_dynamics::orderBy('id', 'desc')->select('*')->offset(0)->limit(10)->get()->toArray();
        } else {
            $set_diary = User_dynamics::orderBy('id', 'desc')->select('*')->offset(($page - 1) * 10)->limit(10)->get()->toArray();
        }
        if ($set_diary) {
            //获取评论信息
         $set_diary=$this->Dataprocess($set_diary);
        }
        //dd($set_diary);
        return json_encode(['msg' => "请求成功", 'sta' => '1', 'data' => $set_diary]);
    }


    /**
     * @param $category_id
     * @return string
     * 获取所有子集
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
     * @return mixed
     *获取用户详细信息.
     */
    public function UserInfo()
    {
        $data = User::find(Auth::id())->toArray();
        if (!empty($data)) {
            foreach ($data as $key => &$rs) {
                if ($key == "avatar") {
                    if (!empty($rs)) {
                        $rs = md52url($rs);
                    }
                }
                if (empty($rs)) {
                    $rs = "";
                }
            }
        }
        $data["dynmics"] = User_dynamics::where('user_id', Auth::id())->count();
        //获取用户关注好友个数Userattention
        $data['attention'] = Userattention::where('user_id', Auth::id())->count();
        //获取关注用户粉丝个数
        $data['fans'] = Userattention::where('attention_userid', Auth::id())->count();
        return json_encode(["sta" => '1', 'msg' => '请求成功', 'data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {

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
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
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
    public
    function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }
}
