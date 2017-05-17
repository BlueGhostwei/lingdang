<?php

namespace App\Http\Controllers\Admin;

use App\Models\Collection;
use Illuminate\Http\Request;
use App\Models\Photo;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Pusher;
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
        $dynamics->record_img = Input::get('img_photo');
        $dynamics->remind_friend = Input::get('remind_friend');
        /*$dynamics->content = $centent;
        $dynamics->img_photo = $img_photo;
        $dynamics->remind_friend =$remind_friend;*/
        if ($dynamics->content == null) {
            return json_encode(['msg' => '日记内容不能为空', 'sta' => '0', 'data' => '']);
        }
        $rst = $dynamics->save();
        if ($rst) {
            //消息通知事件
            //返回状态
            return json_encode(['msg' => '发表成功', 'sta' => '1', 'data' => $rst]);
        } else {
            return json_encode(['msg' => '请求失败', 'sta' => '0', 'data' => '']);
        }
    }

    /**
     * @return mixed
     * 日记点赞
     */
    public function Collection_diary()
    {
        $diary_data = New Collection();
        $diary_data->user_id = Input::get('user_id');
        $diary_data->userdynamics_id = Input::get('userdynamics_id');
        $diary_data->type = "2";
        if ($diary_data->user_id || $diary_data->userdynamics_id) {
            $rst = $diary_data->save();
            if (!$rst) {
                return json_encode(['sta' => '0', 'msg' => '收藏失败，请刷新页面重试', 'data' => '']);
            }
        } else {
            return json_encode(['sta' => '0', 'msg' => '请求失败，参数错误', 'data' => '']);
        }
        return json_encode(['sta' => '1', 'msg' => '收藏成功', 'data' => '']);
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
        if($get_user_dynamics){

        }else{
            return json_encode(['sta'=>'1','msg'=>"",'data'=>'']);
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
