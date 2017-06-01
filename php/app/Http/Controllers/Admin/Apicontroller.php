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


    /**
     *验证登陆
     */
    public function check_user_login(){
        $username=Input::get('name');
        if(Redis::get($username.'_token')){
            $sele_user=User::where('name',$username)->first();
            Auth::login($sele_user);
            return json_encode(['sta'=>"0",'msg'=>'','data'=>""]);
        }else{
            return json_encode(['sta'=>"1",'msg'=>'','data'=>""]);
        }

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
     *'user_dynamics's
     * 发表日志
     */
    public function daily_record()
    {
        /* $myfile = fopen("alipay_log.txt","w");
         fwrite($myfile,var_export(Input::all(),true));
         fclose($myfile);*/

        $dynamics = new User_dynamics();
        $dynamics->user_id = Auth::id();
        $dynamics->content = Input::get('centent');
        $dynamics->img_photo = implode(',',Input::get('img_photo'));
        $dynamics->remind_friend = Input::get('remind_friend');
        /*$dynamics->content = $centent;
        $dynamics->img_photo = $img_photo;
        $dynamics->remind_friend =$remind_friend;*/
        if ($dynamics->content == null) {
            return json_encode(['msg' => '日记内容不能为空', 'sta' => '0', 'data' => ''], JSON_UNESCAPED_UNICODE);
        }
        $rst = $dynamics->save();
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
        if(empty($diary_data->userdynamics_id )){
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
        // dd($request->all());
        //$data['user_id']=Auth::id();
        $data['userdynamics_id'] = $request->userdynamics_id;//动态id
        $data['user_id'] = Input::get('user_id');
        //dd($data['user_id']);
        $data['share_content'] = $request->share_content;
        $data['pid'] = $request->pid;
        $data['share_pic'] = implode(',',$request->share_pic);
        $vali = Validator::make($data, $User_share->rules()['create']);
        if ($vali->fails()) {
            return json_encode(['msg' => "请求失败，请重新尝试", 'sta' => '0', 'data' => ''], JSON_UNESCAPED_UNICODE);
        }
        $rst = $User_share->create($data);
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
            foreach ($set_diary as $ky => $vy) {
                $set_diary[$ky]['user_id'] = $this->get_user_info($vy['id']);
                //处理图片
                if (!empty($vy['img_photo'])) {
                    $img = explode(',', $vy['img_photo']);
                    $set_data = array();
                    foreach ($img as $rst => $rvb) {
                        if (!empty($rvb)) {
                            //$set_data[$rst] = env('assets') . '/' . $rvb;
                            $set_data[$rst] = md52url($rvb);
                        } else {
                            $set_data[$rst] = "";
                        }
                    }
                    $set_diary[$ky]['img_photo'] = $set_data;
                }
                $id = $vy['id'];
                //判断当前用户是否点赞该动态
                $set_diary[$ky]['selflaud']= Collection::where(['userdynamics_id'=>$vy['id'],"user_id"=>$vy['user_id']])->count();
                //获取点赞数
                $set_collection_Favor = DB::select("select * from collection where userdynamics_id='.$id.' and type=2");
                //获取转发
                $set_collection_Forwar = DB::select("select * from collection where userdynamics_id='.$id.' and type=1");
                $set_diary[$ky]['set_Favor'] = count($set_collection_Favor);
                $set_diary[$ky]['set_Forwar'] = count($set_collection_Forwar);
                //该用户是否评论此条说说
                $self_share=User_share::select('id')->where('user_id',Auth::id())->first();
                if($self_share){
                    $set_diary[$ky]['self_share']="0";
                }else{
                    $set_diary[$ky]['self_share']="1";
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
                    $set_diary[$ky]['set_share'] = "";
                }
            }
        }
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
    public function UserInfo(){
        $data=User::find(Auth::id())->toArray();
        if(!empty($data)){
            foreach ($data as $key=>&$rs){
                if($key=="avatar"){
                    if(!empty($rs)){
                        $rs=md52url($rs);
                    }
                }
                if(empty($rs)){
                 $rs="";
                }
            }
        }
        $data["dynmics"] =User_dynamics::where('user_id',Auth::id())->count();
        //获取用户关注好友个数Userattention
        $data['attention']=Userattention::where('user_id',Auth::id())->count();
        //获取关注用户粉丝个数
        $data['fans']=Userattention::where('attention_userid',Auth::id())->count();
        return json_encode(["sta"=>'1','msg'=>'请求成功','data'=>$data]);
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
