<?php

namespace App\Http\Controllers\Admin;

use App\Models\Collection;
use App\Models\User_share;
use Illuminate\Http\Request;
use App\Models\Photo;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use phpDocumentor\Reflection\Types\Null_;
use Pusher;
use Validator;
use Auth;
use App\Models\User_dynamics;
use App\Http\Controllers\Controller;

class Apicontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
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
        $dynamics->img_photo = Input::get('img_photo');
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
        $diary_data->type = "2";
        if ($diary_data->user_id || $diary_data->userdynamics_id) {
            $set_diary = Collection::where(['user_id' => $diary_data->user_id, 'userdynamics_id' => $diary_data->userdynamics_id])->first();
            if ($set_diary->id) {
                $set_diary->delete();
                return json_encode(['sta' => '0', 'msg' => '取消点赞成功', 'data' => '']);
            }
            $rst = $diary_data->save();
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
        $data['share_pic'] = $request->share_pic;
        $vali = Validator::make($data, $User_share->rules()['create']);
        if ($vali->fails()) {
            return json_encode(['msg' => "请求失败，请重新尝试", 'sta' => '0', 'data' => ''], JSON_UNESCAPED_UNICODE);
        }
        $rst = $User_share->create($data);
        if ($rst) {
            return json_encode(['msg' => "请求成功", 'sta' => '1', 'data' => ''], JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(['msg' => "请求失败，服务器错误", 'sta' => '0', 'data' => ''], JSON_UNESCAPED_UNICODE);
        }
    }


    /**
     *
     * 获取好友动态信息
     * 任何用户都可以请求此接口
     * 需要参数：动态id(userdynamics_id)
     * 分两部分，动态内容，评论部分
     * 另需统计参数：转发数，点赞数
     *
     */
    public function GetUserShare_list(){
        $set_diary=User_dynamics::orderBy('id','desc')->paginate(10);
        if($set_diary){
            //获取评论信息
          foreach ($set_diary as $ky =>$vy){
              //处理图片
              dd($vy->img_photo);
              if($vy->img_photo!=null){


              }
              //获取每条动态的评论及评论回复
              

          }

        }

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
