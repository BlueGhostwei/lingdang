<?php

namespace App\Http\Controllers\Admin;

use App\Models\Collection;
use App\Models\Comments_share;
use App\Models\User_share;
use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Forward;
use App\Models\Sort;
use App\Models\Actice;
use App\Models\Message_record;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Input;
use App\Models\Userattention;
use phpDocumentor\Reflection\Types\Null_;
use phpDocumentor\Reflection\Types\Object_;
use Pusher;
use Validator;
use DB;
use App\Models\Topic_combination;
use Illuminate\Support\Facades\Redis;
use Auth;use App\Models\User;

use App\Models\User_dynamics;
use App\Http\Controllers\Controller;

class Apicontroller extends Controller
{
    /**
    * @我的 /user/my_mine
     * 需要传入的值为type
     * 需要登录才能查询的到
     * type=0 所有微博
     * type=1 关注人的微博
     * type=2原则微博
     * type=3 所有评论
     * type=4 关注人的评论
     * get的请求
     *  返回参数格式json如下
     *{"msg":"请求成功","sta":"1","data":""}
    */
    public function my_for($rems)
    {
        error_reporting( E_ALL&~E_NOTICE );
        $rem=array();
        for ($i = 0; $i<count($rems); $i++) {

            if ($rems[$i]["record_type"] == 0)//发表动态
            {
                $mine[] = User_dynamics::where("id", $rems[$i]["userdynamics_id"])->get()->toArray();
                if(!empty($mine) and $mine[$i][0]["id"] and $mine[$i][0][pid]=="0")
                {
                    $mine[$i][0]["user_info"] = User::where("id", $mine[$i][0]["user_id"])->select("id", "nickname", "avatar")->first();
                    $mine[$i][0]["user_info"]["avatar"] = md52url($mine[$i][0]["user_info"]["avatar"]);
                    // $mine[$i][0]["userdt"]=User_dynamics::where($mine[$i][0]["pid"],"=","0")->first();
                    //$obj=(object)array()
                    $mine[$i][0]["userdt"]=(object)array();
                    $img = $mine[$i][0]["img_photo"];
                    if (!empty($img)) {
                        $imgs = explode(",", $img);
                        $photo = array();
                        for ($j = 0; $j < count($imgs); $j++) {
                            $photo[] = md52url($imgs[$j]);
                        }
                        $mine[$i][0]["img_photo"] = $photo;
                    } else {
//                    $mine[$i][0]["img_photo"] = $mine[$i][0]["img_photo"];
                        $mine[$i][0]["img_photo"] =[];
                    }
                    $mine[$i][0]["meg"] = "发表这条动态@我了";
                    $rem[]=$mine[$i][0];
                }


            } elseif ($rems[$i]["record_type"] == 3)//评论
            {
                $mine[] = User_share::where("id", $rems[$i]["share_id"])->get()->toArray();
                if(!empty($mine) and $mine[$i][0]["id"])
                {

                    //$mine[$i][0]["userdt"]=User_dynamics::where("id","=",$mine[$i][0]["userdynamics_id"])->first();
                    $mine[$i][0]["content"]=$mine[$i][0]["share_content"];
                    $mine[$i][0]["user_info"] = User::where("id", $mine[$i][0]["user_id"])->select("id", "nickname", "avatar")->first();
                    $mine[$i][0]["user_info"]["avatar"] = md52url($mine[$i][0]["user_info"]["avatar"]);
                    $img = $mine[$i][0]["share_pic"];
                    $mine[$i][0]["userdt"]=User_dynamics::where("id","=",$mine[$i][0]["userdynamics_id"])->first();
                    // $mine[$i][0]["userdt"]["content"]=$mine[$i][0][userdt]["share_content"];
                    $minename=User::where("id","=",$mine[$i][0]["userdt"]["user_id"])->select("nickname")->first();

                    $mine[$i][0]["userdt"]["username"]=$minename["nickname"];




                    $dimgh=$mine[$i][0]["userdt"]["img_photo"];
                    if(!empty($dimgh))
                    {
                        $dimghs = explode(",", $dimgh);
                        $photos = array();
                        for ($j = 0; $j < count($dimghs); $j++) {
                            $photos[] = md52url($dimghs[$j]);
                        }
                        $mine[$i][0]["userdt"]["img_photo"]=$photos;
                    }
                    else
                    {
                        $mine[$i][0]["userdt"]["img_photo"]=[];
                    }



                    if (!empty($img)) {
                        $imgs = explode(",", $img);
                        $photo = array();
                        for ($j = 0; $j < count($imgs); $j++) {
                            $photo[] = md52url($imgs[$j]);
                        }
                        $mine[$i][0]["share_pic"] = $photo;
                    } else {
                        $mine[$i][0]["share_pic"] = [];
                    }
                    $mine[$i][0]["meg"] = "评论这条动态@我了";
                    $rem[]=$mine[$i][0];
                }
            } elseif ($rems[$i]["record_type"] == 2)//转发
            {
                $mine[] = User_dynamics::where("id", $rems[$i]["userdynamics_id"])->get()->toArray();
                //$mines=User_dynamics::where("id", $rems[$i]["puser_id"])->get()->toArray();

                if(!empty($mine) and $mine[$i][0]["id"])
                {
                    $mine[$i][0]["userdt"]=User_dynamics::where("id",$mine[$i][0]["pid"])->first();

                    $minename=User::where("id","=",$mine[$i][0]["userdt"]["user_id"])->select("nickname")->first();

                    $mine[$i][0]["userdt"]["username"]=$minename["nickname"];

                    $imgh=$mine[$i][0]["userdt"]["img_photo"];
                    if(!empty($imgh))
                    {
                        $imghs = explode(",", $imgh);
                        $photos = array();
                        for ($j = 0; $j < count($imghs); $j++) {
                            $photos[] = md52url($imghs[$j]);
                        }
                        $mine[$i][0]["userdt"]["img_photo"]=$photos;
                    }
                    else
                    {
                        $mine[$i][0]["userdt"]["img_photo"]=[];
                    }
                    $mine[$i][0]["user_info"] = User::where("id", $mine[$i][0]["user_id"])->select("id", "nickname", "avatar")->first();
                    $mine[$i][0]["user_info"]["avatar"] = md52url($mine[$i][0]["user_info"]["avatar"]);
                    $img = $mine[$i][0]["img_photo"];
                    if (!empty($img)) {
                        $imgs = explode(",", $img);
                        $photo = array();
                        for ($j = 0; $j < count($imgs); $j++) {
                            $photo[] = md52url($imgs[$j]);
                        }
                        $mine[$i][0]["img_photo"] = $photo;
                    } else {
                        $mine[$i][0]["img_photo"] =[];
                    }
                    $mine[$i][0]["meg"] = "转发这条动态@我了";
                    $rem[]=$mine[$i][0];
                }
            } elseif ($rems[$i]["record_type"] == 4) {//回复
                $mine[] = User_share::where("id", $rems[$i]["reply_id"])->get()->toArray();
                if(!empty($mine) and $mine[$i][0]["id"])
                {
                    return json_encode(['sta' => "0", 'msg' => '请求失败', 'data' => ""]);

                    $mine[$i][0]["user_info"] = User::where("id", $mine[$i][0]["user_id"])->select("id", "nickname", "avatar")->first();
                    $mine[$i][0]["user_info"]["avatar"] = md52url($mine[$i][0]["user_info"]["avatar"]);
                    $img = $mine[$i][0]["share_pic"];
                    if (!empty($img)) {
                        $imgs = explode(",", $img);
                        $photo = array();
                        for ($j = 0; $j < count($imgs); $j++) {
                            $photo[] = md52url($imgs[$j]);
                        }
                        $mine[$i][0]["share_pic"] = $photo;
                    } else {
                        $mine[$i][0]["share_pic"] = [];
                    }

                    $mine[$i][0]["meg"] = "回复这条动态@我了";
                    $rem[]=$mine[$i][0];
                }
            }

        }
        return $rem;

    }
    public  function mypl($rems)
    {
        error_reporting( E_ALL&~E_NOTICE );
        $rem=array();
        for ($i = 0; $i < count($rems); $i++) {

            $mine[] = User_share::where("id", $rems[$i]["share_id"])->get()->toArray();

            if(!$mine)
            {
                return json_encode(['sta' => "0", 'msg' => '请求失败', 'data' => ""]);
            }
            $mine[$i][0]["user_info"] = User::where("id", $mine[$i][0]["user_id"])->select("id", "nickname", "avatar")->first();
            $mine[$i][0]["user_info"]["avatar"] = md52url($mine[$i][0]["user_info"]["avatar"]);
            $img = $mine[$i][0]["share_pic"];
            if (!empty($img)) {
                $imgs = explode(",", $img);
                $photo = array();
                for ($j = 0; $j < count($imgs); $j++) {
                    $photo[] = md52url($imgs[$j]);
                }
                $mine[$i][0]["share_pic"] = $photo;
            } else {
//                $mine[$i][0]["share_pic"] = $mine[$i][0]["share_pic"];
                $mine[$i][0]["share_pic"] = [];
            }
            $mine[$i][0]["meg"] = "评论这条动态@我了";
            $rem[]=$mine[$i][0];
        }
        return $rem;
    }
    public function my_mine()
    {
        $user_id = Input::get('user_id')?:Auth::id();

        //   $user_id =Auth::id();
        //$user_id=16;
        if($user_id){
            $nickname = User::where("id", $user_id)->select("nickname")->first()->toArray();
            $nick = $nickname["nickname"];
            $type=Input::get('type');
            if($type=="0") {
                $rems = Message_record::where("remind_name", "=", $nick)->get()->toArray();
                //dd($rems);
                if ($rems) {
                    if ($this->my_for($rems)) {
                        return json_encode(['sta' => "1", 'msg' => '请求成功', 'data' => $this->my_for($rems)]);
                    } else {
                        return json_encode(['sta' => "0", 'msg' => '请求失败', 'data' => ""]);
                    }

                }//@我的
                else {
                    return json_encode(['sta' => "0", 'msg' => '没有任何@我的', 'data' => ""]);
                }
            }
            if($type=="1"){//关注人的微博
                $rems = Message_record::join("userattention","userattention.user_id","=","message_record.user_id")
                    ->where("userattention.user_id","=","$user_id")->where("remind_name", "=", $nick)->get()->toArray();
                if ($rems) {
                    if ($this->my_for($rems)) {
                        return json_encode(['sta' => "1", 'msg' => '请求成功', 'data' => $this->my_for($rems)]);
                    } else {
                        return json_encode(['sta' => "0", 'msg' => '请求失败', 'data' => ""]);
                    }
                }//@我的
                else {
                    return json_encode(['sta' => "0", 'msg' => '没有任何@我的', 'data' => ""]);
                }
            }
            if($type=="2"){//原创微博
                $rems = Message_record::join("userattention","userattention.user_id","=","message_record.user_id")
                    ->where("userattention.attention_userid","=","$user_id")->where("record_type","=","0")->where("remind_name", "=", $nick)->get()->toArray();
                if ($rems) {
                    if ($this->my_for($rems)) {
                        return json_encode(['sta' => "1", 'msg' => '请求成功', 'data' => $this->my_for($rems)]);
                    } else {
                        return json_encode(['sta' => "0", 'msg' => '请求失败', 'data' => ""]);
                    }
                }//@我的
                else {
                    return json_encode(['sta' => "0", 'msg' => '没有任何@我的', 'data' => ""]);
                }
            }
            if($type=="3"){//所有评论
                $rems = Message_record::where("record_type","=","3")
                    ->where("remind_name","=", $nick)
                    ->get()->toArray();
                if ($rems) {
                    if ($this->mypl($rems)) {
                        return json_encode(['sta' => "1", 'msg' => '请求成功', 'data' => $this->mypl($rems)]);
                    } else {
                        return json_encode(['sta' => "0", 'msg' => '请求失败', 'data' => ""]);
                    }
                }//@我的
                else {
                    return json_encode(['sta' => "0", 'msg' => '没有任何@我的', 'data' => ""]);
                }
            }
            if($type=="4"){//关注人的评论
                $rems = Message_record::join("userattention","userattention.user_id","=","message_record.user_id")
                    ->where("userattention.user_id","=","$user_id")->where("record_type","=","3")
                    ->where("remind_name","=", $nick)
                    ->get()
                    ->toArray();
                if ($rems) {
                    if ($this->mypl($rems)) {
                        return json_encode(['sta' => "1", 'msg' => '请求成功', 'data' =>$this->mypl($rems)]);
                    } else {
                        return json_encode(['sta' => "0", 'msg' => '请求失败', 'data' => ""]);
                    }
                }//@我的
                else {
                    return json_encode(['sta' => "0", 'msg' => '没有任何@我的', 'data' => ""]);
                }
            }
        }//登录
        else
        {
            return json_encode(['sta'=>"0",'msg'=>'请登录','data'=>""]);
        }
    }


    /**
     *评论我的
     *
     */
    public function reminders_share()
    {
        $user_id = Input::get('user_id')?:Auth::id();
    // $user_id=18;
        $page=$this->SetPage();
        $type=Input::get('type');
        $rst=Message_record::where(['user_id'=>$user_id,'record_type' => 3,'record_status'=>'0'])
		                    ->where('user_id','<>',$user_id)
                            ->orWhere(['puser_id'=>$user_id])
                            ->update(['record_status'=>'1']);

        if($type=="0"){//全部评论
            /**事件执行者user_id,是否为当前用户，状态为3或者为4*/
            $share_data = Message_record::where(['record_type' => 3, 'puser_id' => $user_id,'record_status'=>'1'])
                                ->orWhere('user_id',$user_id)
                                ->offset($page)->limit(10)
                                ->orderBy('id', 'desc')->get()->toArray();
							

        }elseif ( $type=="1"){//我关注的人
            $share_data=Message_record::where(['message_record.puser_id'=>$user_id,'message_record.record_type'=>'3','message_record.record_status'=>'1'])
                                ->join('userattention','message_record.user_id','=','userattention.user_id')
                                ->where('message_record.puser_id',$user_id)
                                ->select('message_record.*')
                                ->offset($page)->limit(10)
                                ->orderBy('message_record.id', 'desc')->get()->toArray();
        }elseif($type=="2"){//自己评论的，包括自己评论自己
           $share_data=Message_record::where(['user_id'=>$user_id,'record_status'=>'1','record_type'=>3])
                                ->offset($page)->limit(10)
                                ->orderBy('id', 'desc')->get()->toArray();
        }
        if (!empty($share_data)) {
            foreach ($share_data as $key => &$vey) {
                  if($vey['reply_id']){
                      $reply_data=User_share::where('id',$vey['reply_id'])->first();
                      $reply['reply_userinfo']=$this->get_user_info($reply_data['user_id']);
                      $reply['reply_content']=$reply_data['share_content']?:"";
                      $vey['reply_data']=$reply;
                  }else{
                      $reply['reply_userinfo']=[
                          "id"=>'',  "nickname"=>'',"avatar"=>''
                      ];
                      $reply['reply_content']="";
                      $vey['reply_data']=$reply;
                  }
                  $share_content=User_share::where('id',$vey['share_id'])->first();
                  if(!empty($share_content)){
                      $vey['share_content']=$share_content->share_content;
                  }else {
                      $vey['share_content'] = '';
                  }
                  $vey['user_info']=$this->get_user_info($vey['user_id']);
                  $set_dynamics=User_dynamics::where('id',$vey['userdynamics_id'])
                                                ->select('id','user_id','content','img_photo')
                                                ->get()->toArray();
                  if(empty($set_dynamics)){
                      $vey['dynamics']=[];
                  }
                  $set_dynamics[0]['user_id']=$this->get_user_info($set_dynamics[0]['user_id']);
                  if($set_dynamics[0]['img_photo']){
                      $img = explode(',', $set_dynamics[0]['img_photo']);
                      foreach ($img as $rst => &$rvb) {
                          $img[$rst] = md52url($rvb);
                      }
                      $set_dynamics[0]['img_photo']=$img;
                  }else{
                      $set_dynamics[0]['img_photo']=[];
                  }
                      $vey['dynamics']=$set_dynamics[0];
                  $vey['type']=$type;
            }
        }else{
            $share_data=[];
        }
       return json_encode(['sta'=>"1",'msg'=>'请求成功','data'=>$share_data]);

    }
   /**
     * 我的赞
     */
    public function reminders_praise()
    {
        $user_id = Input::get('user_id');
        $Set_userInfo = User::find($user_id);
        $rem_name=$Set_userInfo["nickname"];
        $page=$this->SetPage();
        if (!$Set_userInfo) {
            return json_encode(['sta' => '0', 'msg' => '请求失败', 'data' => ""]);
        }
		 Message_record::where(['record_type' => "1", 'record_status' => '0', 'remind_name' => $user_id])->update(["record_status"=>"1"]);

         $user_praise = Message_record::where(['record_type' => "1", 'record_status' => '1', 'remind_name' =>$user_id])
                          ->offset($page)->limit(10)->orderBy('id', 'desc')
                          ->get()->toArray();
        foreach ($user_praise as $key => $vey) {
            //获取用户信息
            //$user_info=User::where('id',$vey['user_id'])->select('id','nickname','name')->get()->toArray();
            if($vey['record_type']==1 && !empty($vey['puser_id'])){
                $user_praise[$key]['Messages'] = '赞了这条评论';
                //获取评论内容
               $share=User_share::find($vey['puser_id']);
                if($share){
                    $user_praise[$key]['share']=$share->share_content;
                }else{
                    $user_praise[$key]['share']="此评论已被删除";
                }
            }else{
                $user_praise[$key]['Messages'] = '赞了这条动态';
                $user_praise[$key]['share']="";
            }
            $user_info = $this->get_user_info($vey['user_id']);

            if (!empty($user_info)) {
                $user_praise[$key]['user_info'] = $user_info;
            } else {
                $user_praise[$key]['user_info'] = [];
            }
            $content = User_dynamics::select('user_id', 'id', 'content', 'img_photo')->where('id', $vey['userdynamics_id'])->get()->toArray();
            if (!empty($content)) {
                $content[0]['user_id']=$this->get_user_info($content[0]['user_id']);
                if ($content[0]['img_photo'] =="") {
                    $content[0]['img_photo'] = [];
                } else {
                    $img = explode(',', $content[0]['img_photo']);
                    foreach ($img as $rst => &$rvb) {
                        $img[$rst] = md52url($rvb);
                    }
                    $content[0]['img_photo'] = $img;
                }
                $user_praise[$key]['dynamics'] = $content[0];
            } else {
                $user_praise[$key]['dynamics'] =new \stdClass();
            }
            $user_praise[$key]['remind_name'] = "@" . User::find($user_id)->nickname;
        }
        return json_encode(['sta' => '1', 'msg' => '请求成功', 'data' => $user_praise]);
    }

    /**消息提醒页*/
     public function reminders_concern(){
        
         $user_id=Input::get('user_id');
         if(empty($user_id)){
             return json_encode(['sta'=>'0','msg'=>'请求失败','data'=>""]);
         }
         //获取用户信息
         $nickname=User::find($user_id);
         if($nickname){
             $data['user_reminders']=Message_record::where(['record_type'=>"0",'record_status'=>'0'])
                 ->where('remind_name',$nickname->nickname)->get()->count();
             $data['user_comment']=Message_record::where(['record_type'=>"3",'record_status'=>'0'])
                 ->where('remind_name',$nickname)->get()->count();
             $data['user_praise']=Message_record::where(['record_type'=>"1",'record_status'=>'0'])
                 ->where('remind_name',$nickname)->get()->count();
             $data['user_concerns']=Message_record::where(['record_type'=>"6",'record_status'=>'0'])
                 ->where('remind_name',$user_id)->get()->count();
             $data['user_message']=0;
             return json_encode(['sta'=>'1','msg'=>'请求成功','data'=>$data]);
         }else{
             return json_encode(['sta'=>'0','msg'=>'请求失败','data'=>""]);
         }

     }

    /**
     * 用户删除动态接口
     * 登陆用户的id，动态id，删除动态的同事，删除下面所有的评论，点赞。转发除外。
     */
    public function destroy_bady_diary()
    {
        $user_id=Input::get('user_id');
        $userdynamics_id = Input::get('userdynamics_id');
        //查询动态是否存在
        $set_diary=User_dynamics::where(['id'=>$userdynamics_id,'user_id'=>$user_id])->get()->toArray();
        if(empty($set_diary)){
            return json_encode(['sta'=>'0','msg'=>'请求错误，请重新尝试','data'=>'']);
        }
        //开启事务
        DB::beginTransaction();
        try{
            $Set_diary_share=User_share::where('userdynamics_id',$userdynamics_id)->delete();
            $Set_diary_Collection=Collection::where('userdynamics_id',$userdynamics_id)->delete();
            $Set_diary_Comments_share=Comments_share::where('userdynamics_id',$userdynamics_id)->delete();
            $set_diary=User_dynamics::where(['id'=>$userdynamics_id,'user_id'=>$user_id])->delete();
			//删除动态消息提醒
            Message_record::where('userdynamics_id', $userdynamics_id)->delete();
        //中间逻辑代码
            DB::commit();
         }catch (\Exception $e) {
        //接收异常处理并回滚 DB::rollBack();
            DB::rollBack();
            return json_encode(['sta' => '0', 'msg' => '删除动态失败','data'=>'']);
        }
        return json_encode(['sta'=>'1','msg'=>'删除成功','data'=>'']);
    }

    /**
     * 删除动态接口，删除动态的时，把对应的评论，点赞数据一并处理。转发过该条动态的用户，在获取数据时，获取不到结果则返回："该动态已被用户删除"提示；
     *
     */
    public function destroy_share(){
        $share_user_id=Input::get('share_user_id');
        $share_id=Input::get('share_id');//评论id
        //$share_id="29";
        //$share_user_id="18";
        $rst_data=User_share::where(['id'=>$share_id,'user_id'=>$share_user_id])->get()->toArray();
        // dd($rst_data);
        if(empty($rst_data)){
            return json_encode(['sta'=>'0','msg'=>'请求失败','data'=>'']);
        }
        //查找子评论
        $get_category=$this->get_share_category($share_id);
        if (count($child = explode(',', $get_category))>=3) {
            $child = substr($get_category, 0, strlen($get_category) - 1);
            $child = explode(',', $child);
            rsort($child);
            $arr = array();
            $arrlength = count($child);
            for ($x = 0; $x < $arrlength; $x++) {
                $arr[$x] = $child[$x];
            }
            $child = array_slice($arr, 0, 4);
            foreach ($child as $rt => $mn) {
                //删除评论的同时，删除该评论的点赞
                $del1 = User_share::where('id', $mn)->delete();
                //获取评论点赞
                $get_del2 = Comments_share::where('comment_id', $share_id)->delete();
            }
            return json_encode(['sta'=>'1','msg'=>'删除评论成功','data'=>'']);
        }else{
            $delete_data=User_share::where(['id'=>$share_id,'user_id'=>$share_user_id])->delete();
            return json_encode(['sta'=>'1','msg'=>'删除评论成功','data'=>'']);
        }
    }

    /**
     * 发表话题时模糊搜索
     */
    public function get_topic()
    {
        $topic_name = Input::get('topic_name');
        if (!empty(Input::get('user_id'))) {
            $user_id = Input::get('user_id');
        } else {
            $user_id = Auth::id();
        }
        if ($topic_name) {
            $rst = User_dynamics::where('user_id', $user_id)->where('topic', 'like', "%$topic_name%")->select('topic')->offset(0)->limit(10)->orderBy('id', 'desc')->get()->toArray();
        } else {
            $rst = User_dynamics::where('user_id', $user_id)->where(function ($query) {
                $query->where('topic', '!=', null);
            })->select('topic')->offset(0)->limit(3)->orderBy('id', 'desc')->get()->toArray();
        }
        return json_encode(['sta' => "1", 'msg' => '请求成功', 'data' => $rst]);
    }



    /**
     * 热门动态
     * 热门话题（加##的话题达到1万阅读量可上热门话题栏）
     * hot_topic
     */
    public function  hot_topic(){
        $combination=Topic_combination::select('topic_name')->orderBy('read_amount')->get()->toArray();
        return json_encode(['sta' => '1', 'msg' => "请求成功", 'data' => $combination]);
    }
    /**
     * 查看已有话题接口
     * 需要传递的参数：话题id.话题名称。
     */
    public function Set_Topic()
    {
        $topic_name = Input::get('topic_name');
        if (empty($topic_name)) {
            return json_encode(['sta' => "0", 'msg' => '请求失败', 'data' => []]);
        }
        $page = Input::get('page');
        if (empty($page)) {
            $rst = User_dynamics::where('topic', 'like', "%$topic_name%")->offset(0)->limit(10)->orderBy('id', 'desc')->get()->toArray();
        } else {
            $rst = User_dynamics::where('topic', 'like', "%$topic_name%")->offset(($page - 1) * 10)->limit(10)->orderBy('id', 'desc')->get()->toArray();
        }
        //接受话题id，进行阅读量统计。
        $set_topic = Topic_combination::where('topic_name', $topic_name)->get()->toArray();
        if (!empty($set_topic) && $topic_name) {
            $upRst = Topic_combination::where('topic_name', $topic_name)->update([
                'topic_name' => $topic_name,
                "read_amount" => $set_topic[0]['read_amount'] + 1
            ]);
        } else {
            Topic_combination::create([
                'topic_name' => $topic_name,
                "read_amount" => 1
            ]);
        }
        if (!empty($rst)) {
            $SET_Data['result'] = $this->Dataprocess($rst);
        } else {
            $SET_Data['result'] = [];
        }
        //查询阅读量,讨论量
        $read_amount = Topic_combination::where('topic_name', $topic_name)->select('read_amount')->get()->toArray();
        if (!empty($read_amount)) {
            $SET_Data['read_count'] = $read_amount[0]['read_amount'];
        } else {
            $SET_Data['read_count'] = 0;
        }
        $SET_Data['discuss_count'] = User_dynamics::where('topic', 'like', "%$topic_name%")->count();
        return json_encode(['sta' => "1", 'msg' => '请求成功', 'data' => $SET_Data]);

    }


    /**
     *评论点赞
     *所需参数:_token ,动态id,评论id,当前登录用户id，点赞时间，当前评论点赞数
     */
    public function Goshare_like()
    {
        /**动态id，评论id，*/
        $dynamic = Input::get('dynamic_id');
        $comment_id = Input::get('comment_id');
        if (Input::get('user_id')) {
            $user_id = Input::get('user_id');
        } else {
            $user_id = Auth::id();
        }
        //查看动态是否存在
        $set_uynamics = User_dynamics::find($dynamic);
        if (!$set_uynamics) {
            return json_encode(['sta' => '0', 'msg' => '服务器异常，请重新尝试', 'data' => '']);
        }
        //查看评论内容是否存在
        $rvb = User_share::where(['userdynamics_id' => $dynamic, 'id' => $comment_id])->get()->toArray();
        if ($rvb) {
            $set_share = Comments_share::where(['userdynamics_id' => $dynamic, 'user_id' => $user_id])->count();
            if ($set_share) {
                Comments_share::where(['userdynamics_id' => $dynamic, 'user_id' => $user_id])->delete();
                $data['SetCommentShare_count'] = Comments_share::where(['userdynamics_id' => $dynamic, 'comment_id' => $comment_id])->count();
                $data['set_self'] = Comments_share::where(['userdynamics_id' => $dynamic, 'user_id' => $user_id, 'comment_id' => $comment_id])->count();
                return json_encode(['sta' => '1', 'msg' => '取消点赞成功', 'data' => $data]);

            } else {
                $rst = Comments_share::create([
                    'userdynamics_id' => $dynamic,
                    'user_id' => $user_id,
                    'comment_id' => $comment_id
                ]);
                if (!$rst) {
                    return json_encode(['sta' => '0', 'msg' => '点赞失败', 'data' => '']);
                }
                //统计点赞数量
                $data['SetCommentShare_count'] = Comments_share::where(['userdynamics_id' => $dynamic, 'comment_id' => $comment_id])->count();
                $data['set_self'] = Comments_share::where(['userdynamics_id' => $dynamic, 'user_id' => $user_id, 'comment_id' => $comment_id])->count();
                //评论点赞日志
                /**
                 * 获取评论id，点赞者，接收消息的用户（通过查询评论id拿到评论用户的用户id）
                 */
                $meg="点赞成功";
                $set_share_data = User_share::find($comment_id);
                $message_record['user_id'] = $user_id;
                $message_record['remind_name'] = $set_share_data->user_id;
                $message_record['userdynamics_id'] = $dynamic;
                $message_record['record_type'] = "1";//状态3为评论，具体查看sql文件
                $message_record['puser_id'] = $comment_id;//点赞，评论所需的用户id
                $message_record['record_content'] = $meg;
                $message_record['record_status'] = '0';
                $set_rst = Message_record::create($message_record);
                return json_encode(['sta' => '1', 'msg' => '点赞成功', 'data' => $data]);
            }
        } else {
            return json_encode(['sta' => '0', 'msg' => '点赞失败', 'data' => '']);
        }
    }
    /**
     *点赞用户列表
     */
    public function praise_list()
    {
        $page = Input::get('page');
        $dynamic = Input::get('dynamic_id');
        $set_uynamics = User_dynamics::find($dynamic);
        if (!$set_uynamics) {
            return json_encode(['sta' => '0', 'msg' => '服务器异常，请重新尝试', 'data' => '']);
        }
        //查询点赞列表
        if ($page && $page > 1) {
            $SetCollection = Collection::where('userdynamics_id', $dynamic)
                ->offset(($page - 1) * 10)->limit(10)->orderBy('id', 'desc')->get()->toArray();
        } else {
            $SetCollection = Collection::where('userdynamics_id', $dynamic)
                ->offset(0)->limit(10)->orderBy('id', 'desc')->get()->toArray();
        }
        if (empty($SetCollection)) {
            $SetCollection = [];
        } else {
            foreach ($SetCollection as $key => $rst) {
                $SetCollection[$key]['share_user_info'] = $this->get_user_info($rst['user_id']);
            }
        }
        return json_encode(['sta' => '1', 'msg' => '请求成功', 'data' => $SetCollection]);
    }

    /**
     * @return mixed
     * 当前登录用户的所有动态
     */
    public function My_dynamics()
    {
        $user_id=Input::get('user_id')?:Auth::id();
        $page=$this->SetPage();
        $SET_Data = User_dynamics::where('user_id', $user_id)
                ->offset($page)->orderBy('id', 'desc')
                ->limit(10)->get()->toArray();
        if (!empty($SET_Data)) {
            $SET_Data = $this->Dataprocess($SET_Data, $user_id);
        } else {
            $SET_Data = [];
        }
        return json_encode(['sta' => "1", 'msg' => '请求成功', 'data' => $SET_Data]);
    }

    /**
     * @return mixed
     * 获取子评论回复详细信息
     */
    public function share_Commented()
    {
        $share_id = Input::get('share_id');
        $get_category = $this->get_share_category($share_id);
        $set_diary = array();
        if (strlen($get_category) >= 4) {
            $child = substr($get_category, 0, strlen($get_category) - 1);
            $child = explode(',', $child);
            rsort($child);
            $arr = array();
            $arrlength = count($child);
            for ($x = 0; $x < $arrlength; $x++) {
                $arr[$x] = $child[$x];
            }
            /**统计每条评论用户点赞数,与评论用户个人资料*/
            foreach ($child as $rt => $mn) {
                if ($mn != $share_id) {
                    $rst = User_share::select('*')->where('id', $mn)->get()->toArray();
                    if (!empty($rst)) {
                        $rst[0]['share_user_info'] = $this->get_user_info($rst[0]['user_id']);
                        $set_diary[] = $rst[0];
                    } else {
                        $set_diary[] = [];
                    }
                }
            }
        }
        return json_encode(['sta' => "1", 'msg' => '请求成功', 'data' => $set_diary]);
    }

         /**
     * @return mixed
     *
     * 指定动态的所有评论
     */
    public function SetUserdynamics_share()
    {
        $page = Input::get("page");
        $id = Input::get('userdynamics_id');
        $user_id=Input::get('user_id')?:Auth::id();
        $Get_dynamics = User_dynamics::find($id);//查询动态
        if (!$Get_dynamics) {
            return json_encode(['sta' => "0", 'msg' => '动态不存在，或用户已删除', 'data' => '']);
        }
        //获取每条动态的评论及评论回复
        if (!empty($page) && $page > 1) {
            $set_diary = User_share::where(['userdynamics_id' => $id, 'pid' => null])
                ->select('*')
                ->orderBy('created_at', 'desc')
                ->offset(($page - 1) * 10)->limit(10)->get()->toArray();//获取第一 级评论
        } else {
            $set_diary = User_share::where(['userdynamics_id' => $id, 'pid' => null])
                ->select('*')
                ->orderBy('created_at', 'desc')
                ->offset(0)->limit(10)->get()->toArray();
        }
        if (!empty($set_diary)) {
            //获取评论者头像，昵称，ID
            foreach ($set_diary as $ksy => $vsy) {
                $set_diary[$ksy]['selflaud'] = Collection::where(['userdynamics_id' => $vsy['id'],"user_id" => $user_id,'type' => '2'])->count();
                if ($vsy['pid'] == null) {
                    $set_diary[$ksy]['pid'] = "";
                }
                $set_diary[$ksy]['share_user_info'] = $this->get_user_info($vsy['user_id']);
                $set_diary[$ksy]['share_puser_info'] = $this->get_user_info($vsy['pid']);
                $get_category = $this->get_share_category($vsy['id']);
                if (count(explode(',',$get_category)) >= 3) {
                    $child = substr($get_category, 0, strlen($get_category) - 1);
                    $child = explode(',', $child);
                    rsort($child);
                    $arr = array();
                    $arrlength = count($child);
                    for ($x = 0; $x < $arrlength; $x++) {
                        $arr[$x] = $child[$x];
                    }
                    $child = array_slice($arr, 0, 4);
                   foreach ($child as $rt => $mn) {
                        if($mn!=$vsy['id']){
                            $rst = User_share::select('*')->where('id', $mn)->get()->toArray();
                            if (!empty($rst)) {
                                if($rst[0]['pid']==null){
                                    $rst[0]['pid']="";
                                }
                                $rst[0]['share_user_info'] = $this->get_user_info($rst[0]['user_id']);
                                $rst[0]['selflaud']= Collection::where(['userdynamics_id' =>$mn, "user_id" => $user_id, 'type' => '2'])->count();
                                $set_diary[$ksy]['child'][] = $rst[0];
                            } else {
                                $set_diary[$ksy]['child'] = [];
                            }
                        }
                    }
                }else{
                    $set_diary[$ksy]['child'] = [];
                }
            }
        } else {
            $set_diary = [];
        }
        return json_encode(['sta' => "1", 'msg' => "请求成功", 'data' => $set_diary]);
    }
    /**
     * @return mixed
     * 首页数据
     */
	 public function HomeData()
    {
        $user_id = Input::get('user_id') ?: Auth::id();

        $data['photo'] = Photo::orderBy('number', 'asc')->get()->toArray();
        $page = Input::get('page');
        if (empty($page) || $page <= 1) {
            $page = 1;
        }
        if (!empty($data['photo'])) {
            foreach ($data['photo'] as $ky => $rs) {
                $data['photo'][$ky]['img_Md5'] = md52url($rs['img_Md5']);
            }
        } else {
            $data['photo'] = [];
        }
        //热门话题（加##的话题达到1万阅读量可上热门话题栏）
        $topic_data = Topic_combination::orderBy('id', 'desc')
            ->orderBy('read_amount', 'desc')
            ->limit(10)
            ->get()->toArray();
        $data['hot_topic'] = $topic_data ?: new Object_();
		if($topic_data)
		{
			 $data['hot_topic']=$topic_data;
		}
		else
		{
			$data['hot_topic'] =new Object_();
		}
        //$data['hot_topic'] = $topic_data ?:[];
        //热门动态（热门动态：转发率，评论，点赞，其中一样在5个小时内高达200，24小时内高达3000的动态;
        /**点赞，转发统计 ，判断是否是好友动态，判断用户登录状态,添加转发动态*/
        if (Auth::check() == true || $user_id) {
            $data['Popular_dynamic'] = User_dynamics::select('userdynamics.*', DB::raw('userdynamics.comment_num+userdynamics.send_out_num+userdynamics.like_num as count_num'))
                ->leftJoin('user', 'userdynamics.user_id', '=', 'user.id')
                ->where('userdynamics.Authority', '0')
                ->orWhere('userdynamics.comment_num', '>=', 500)
                ->orWhere('userdynamics.send_out_num', '>=', 500)
                ->orWhere('userdynamics.like_num', '>=', 500)
                ->groupBy('userdynamics.id')
                ->orderBy('updated_at', 'desc')
                ->orderBy('count_num', 'desc')
                ->offset(($page - 1) * 10)
                ->limit(10)->get()->toArray();
            $data['Popular_dynamic'] = $this->Dataprocess($data['Popular_dynamic'], $user_id);
            //所关注用户的动态_
            $data['dynamics'] = User_dynamics::select('userdynamics.*', DB::raw('userdynamics.comment_num+userdynamics.send_out_num+userdynamics.like_num as count_num'))
                ->leftJoin('userattention', 'userdynamics.user_id', '=', 'userattention.user_id')
                ->leftJoin('user', 'userattention.attention_userid', '=', 'user.id')
                ->where(["userdynamics.Authority" => "0", 'userattention.attention_userid' => $user_id])
                ->groupBy('userdynamics.id')
                ->orderBy('updated_at', 'desc')
                ->orderBy('count_num', 'desc')
                ->offset(($page - 1) * 10)->limit(10)->get()->toArray();
            $data['dynamics'] = $this->Dataprocess($data['dynamics'], $user_id);

        } else {
            /**未登录数据处理*/
            $data['Popular_dynamic'] = User_dynamics::select( 'userdynamics.*', DB::raw('userdynamics.comment_num+userdynamics.send_out_num+userdynamics.like_num as count_num'))
                ->where('Authority', 0)
                ->orWhere('comment_num', '>=', 500)
                ->orWhere('send_out_num', '>=', 500)
                ->orWhere('like_num', '>=', 500)
                ->orderBy('count_num', 'desc')
                ->orderBy('id', 'desc')
                ->groupBy('id')
                ->offset(($page - 1) * 10)
                ->limit(10)->get()->toArray();
            $data['Popular_dynamic'] = $this->Dataprocess($data['Popular_dynamic']);
            $data['dynamics'] = [];
        }
        return json_encode(['sta' => '1', 'msg' => "请求成功", 'data' => $data]);
    }
  

    /**
     * @return string
     * 用户粉丝列表
     */
    public function GetFansList()
    {
        $user_id=Input::get('user_id')?:Auth::id();
        $page=$this->SetPage();
        $UserFansList = Userattention::where('userattention.attention_userid', $user_id)
                ->join('user', 'userattention.user_id', '=', 'user.id')
                ->select('user.id', 'user.avatar', 'user.nickname', 'user.signature')
                ->where('user.id','<>',$user_id)
                ->offset($page)->orderBy('id', 'desc')
                ->limit(10)->get()->toArray();
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
        if (Auth::check() == true) {
            Auth::logout();
        }
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
                        $new_token = csrf_token();
                        $arr = ['token' => $new_token, 'time' => time()];
                        Redis::set($username . '_token', json_encode($arr));
                        return json_encode(['sta' => "1", 'msg' => '自动登陆成功', 'data' => $new_token]);
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

    protected function SetDynamic($id,$set2=null){
       $dynamic=User_dynamics::where('id',$id)->get()->toArray();
        if(!empty($dynamic)){
            $dynamic=$this->Dataprocess($dynamic,$set2);
            $dynamic=$dynamic[0];
        }
        return $dynamic;
    }
    /**
     * @param $set_diary
     * @return mixed
     */
    protected function Dataprocess($set_diary, $get_id = null)
    {
        $user_id = $get_id ?: Auth::id();
        foreach ($set_diary as $ky => $vy) {
           if($vy['pid']!="0"){
               $set_diary[$ky]['forward']=$this->SetDynamic($vy['pid'],$user_id)?:new Object_();
           }else{
             $set_diary[$ky]['forward']=new Object_();
           }
            if (empty($set_diary[$ky]['topic'])) {
                $set_diary[$ky]['topic'] = "";
            }
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
            //获取点赞数
            $set_diary[$ky]['set_Favor'] = Collection::where(['userdynamics_id' => $vy['id'], 'type' => 2])->count();
            //获取转发数
            $set_diary[$ky]['set_Forwar'] = User_dynamics::where('pid' ,$vy['id'])->count();
            //获取评论数
            $set_diary[$ky]['set_comment'] = User_share::where('userdynamics_id', $vy['id'])->count();
            //该用户是否评论此条说说
            if (Auth::check() == true || $user_id) {
                //判断当前用户是否点赞该动态
                $set_diary[$ky]['selflaud'] = Collection::where(['userdynamics_id' => $vy['id'], "user_id" => $user_id, 'type' => '2'])->count();
                $self_share = User_share::select('id')->where('user_id', $user_id)->first();
                //查看当前用户是否关注该用户
                $set_diary[$ky]['selfavor'] = Userattention::where(['user_id' => $user_id, 'attention_userid' => $vy['user_id']])->count();
            } else {
                $set_diary[$ky]['selflaud'] = "0";
                $self_share = "";
                $set_diary[$ky]['selfavor'] = "0";
            }
            if ($self_share) {
                $set_diary[$ky]['self_share'] = "0";
            } else {
                $set_diary[$ky]['self_share'] = "1";
            }
            //获取每条动态的评论及评论回复
            $set_diary[$ky]['set_share'] = User_share::where(['userdynamics_id' => $vy['id']])->orderBy('created_at', 'asc')->get()->toArray();
            $set_diary[$ky]['set_share_count'] = User_share::where(['userdynamics_id' => $vy['id']])->count();
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
     *'user_dynamics'
     *转发与发表日志
     */
    public function daily_record()
    {
        $data['pid'] = Input::get("pid");
        $data['user_id'] = Input::get('user_id') ?: Auth::id();
        $data['content'] = Input::get('content');
        $img_photo = Input::get('img_photo');
        if (!empty($img_photo)) {
            $data['img_photo'] = $img_photo;
        } else {
            $data['img_photo'] = $img_photo;
        }
        $data['remind_friend'] = Input::get('remind_friend');
        if ($data['pid'] == "0" || $data['pid'] == "") {
            if (empty($data['content']) && empty($data['img_photo']) && empty($data['remind_friend']) && empty($data['topic'])) {
                return json_encode(['msg' => '请求失败,参数错误', 'sta' => '0', 'data' => '']);
            }
        }
        $data['topic'] = Input::get('topic');
        $data['Authority'] = Input::get('Authority') ?: "0";
        $data['comment_num'] = '';
        $data['like_num'] = '';
        $data['send_out_num'] = '';
        if (!empty($data['topic'])) {
            //添加话题
            $topic_name = explode(',', $data['topic']);
            foreach ($topic_name as $key => $vel) {
                $set_topic = Topic_combination::where('topic_name', $vel)->first();
                if (!$set_topic) {
                    Topic_combination::create(['user_id' => $data['user_id'], 'read_amount' => '0', 'topic_name' => $vel]);
                }
            }
        }
        $rst = User_dynamics::create($data);
        if ($rst) {
            //发布动态消息通知事件
            $msg = "用户提到了你";
            //用户消息记录
            if ($data['pid'] == 0 || $data['pid'] == '') {
                if (!empty($data['remind_friend'])) {
                    //获取用户信息
                    $user_name = explode(',', $data['remind_friend']);
                    $user_name = array_unique($user_name);
                    foreach ($user_name as $key => $vey) {
                        $vey = substr($vey, 1);
                        $message_record['user_id'] = $data['user_id'];
                        $message_record['remind_name'] = $vey;
                        $message_record['userdynamics_id'] = $rst->id;
                        $message_record['record_type'] = "0";
                        $message_record['puser_id'] = '';
                        $message_record['record_content'] = $msg;
                        $message_record['record_status'] = '0';
                        Message_record::create($message_record);
                    }
                }
            } else {
                //转发动态日志
                $user_name = explode(',', $data['remind_friend']);
                $user_name = array_unique($user_name);
                if (!empty($data['remind_friend'])) {//@用户消息提醒
                    //获取用户信息
                    foreach ($user_name as $key => $vey) {
                        $vey = substr($vey, 1);
                        $get_dynamics_userId = User_dynamics::find($data['pid'])->user_id;
                        $message_record['user_id'] = $data['user_id'];
                        $message_record['remind_name'] = $vey;
                        $message_record['userdynamics_id'] = $data['pid'];
                        $message_record['record_type'] = "2";//状态1为点赞，具体查看sql文件
                        $message_record['puser_id'] = $get_dynamics_userId;//点赞，评论所需的用户id
                        $message_record['record_content'] = "用户@了我";
                        $message_record['record_status'] = '0';
                        Message_record::create($message_record);
                    }
                }
                $get_dynamics_userId = User_dynamics::find($data['pid'])->user_id;
                $message_record['user_id'] = $data['user_id'];
                $message_record['remind_name'] = $get_dynamics_userId;//转发动态的用户id
                $message_record['userdynamics_id'] = $data['pid'];
                $message_record['record_type'] = "2";//状态1为点赞，具体查看sql文件
                $message_record['puser_id'] = '';//点赞，评论所需的用户id
                $message_record['record_content'] = "用户转发了我的动态";
                $message_record['record_status'] = '0';
                Message_record::create($message_record);
            }
            return json_encode(['msg' => '发表成功', 'sta' => '1', 'data' => '']);
        }
        return json_encode(['msg' => '请求失败', 'sta' => '0', 'data' => '']);
    }

    /**
     * @return mixed
     * 日记点赞
     */
    public function Collection_diary()
    {
        $diary_data = New Collection();
        $diary_data->type = "2";
        $diary_data->user_id=Input::get('user_id')?:Auth::id();
        $diary_data->userdynamics_id = Input::get('userdynamics_id');
        if (empty($diary_data->userdynamics_id)) {
            return json_encode(['sta' => '0', 'msg' => "请选择点赞动态", 'data' => '']);
        }
        $dynamics = User_dynamics::find($diary_data->userdynamics_id);
        if (!$dynamics) {
            return json_encode(['sta' => '0', 'msg' => "服务器错误，请求失败", 'data' => '']);
        }
        if ($diary_data->user_id || $diary_data->userdynamics_id) {
            $set_diary = Collection::where(['user_id' => $diary_data->user_id, 'userdynamics_id' => $diary_data->userdynamics_id, 'type' => '2'])->first();
            if ($set_diary) {
                $set_diary->delete();
                $data = $this->get_collection_data($diary_data->user_id, $diary_data->userdynamics_id);
                //统计点赞数
                $like_num_count = Collection::where(['userdynamics_id' => $diary_data->userdynamics_id, 'type' => '2'])->count();
                $rgd = $dynamics->update(['like_num' => $like_num_count]);
                return json_encode(['sta' => '1', 'msg' => '取消点赞成功', 'data' => $data]);
            }
            $rst = $diary_data->save();
            //消息通知日志表
            /**需要动态id，消息提醒用户id,点赞者id*/
            $meg="";
            if($rst){
                //获取动态用户昵称
                $nickname=User::where('id',$dynamics->user_id)->first();
                $message_record['user_id']= $diary_data->user_id;
                $message_record['remind_name']=$nickname->id;;
                $message_record['userdynamics_id']=$diary_data->userdynamics_id;
                $message_record['record_type']="1";//状态1为点赞，具体查看sql文件
                $message_record['puser_id']="";//点赞，评论所需的用户id
                $message_record['record_content']=$meg;
                $message_record['record_status']='1';
                Message_record::create($message_record);
            }
            $like_num_count = Collection::where(['userdynamics_id' => $diary_data->userdynamics_id, 'type' => '2'])->count();
            $rgd = $dynamics->update(['like_num' => $like_num_count]);
            if (!$rst) {
                return json_encode(['sta' => '0', 'msg' => '点赞失败', 'data' => '']);
            }
            $data = $this->get_collection_data($diary_data->user_id, $diary_data->userdynamics_id);
            return json_encode(['sta' => '1', 'msg' => '点赞成功', 'data' => $data]);
        } else {
            return json_encode(['sta' => '0', 'msg' => '请求失败，参数错误', 'data' => '']);
        }

    }

    /**
     * @param $user_id
     * @param $userdynamics_id
     * @return mixed
     *
     */
    protected function get_collection_data($user_id, $userdynamics_id)
    {
        $data['set_self'] = Collection::where(['user_id' => $user_id, 'userdynamics_id' => $userdynamics_id, 'type' => '2'])->count();
        $data['set_count'] = Collection::where(['userdynamics_id' => $userdynamics_id, 'type' => '2'])->count();
        return $data;
    }

    /**
     * 日记转发
     * 这里一条链接跳转链接，图片标题 ，带评论内容
     * 获取日记id，第一张图片，标题。附带查看日志详情链接
     * 此方法已弃用
     */
    public function diary_forwarding()
    {
        //当前用户id,转发动态id,添加
        $user_id=Input::get('user_id')?:Auth::id();
        $userdynamics_id = Input::get('userdynamics_id');
        $forward_content=Input::get('forward_content');
        $get_user_dynamics = User_dynamics::where('id', $userdynamics_id)->get()->toArray();
        $meg="已转发";
        if ($get_user_dynamics) {
			$get_dynamics_userId=User_dynamics::find($userdynamics_id)->user_id;//动态表（userdynamics）
            $get_user_id=User_dynamics::select("user_id")->where("id","=",$userdynamics_id)->get()->toArray();
            $get_user_users=User::where("id",$get_user_id["user_id"])->select("nickname")->first();
            $message_record['user_id'] = $user_id;
//            $message_record['remind_name'] ="";
            if($get_user_users){$message_record['remind_name'] =$get_user_users["nickname"];}

            $message_record['userdynamics_id'] = $userdynamics_id;
            $message_record['record_type'] = "2";//状态1为点赞，具体查看sql文件
            $message_record['puser_id'] = $get_dynamics_userId;//点赞，评论所需的用户id
            $message_record['record_content'] = $meg;
            $message_record['record_status'] = '1';
            Message_record::create($message_record);
            //Forward::create(['user_id'=>$user_id,'userdynamics_id'=>$userdynamics_id,'forward_content'=>$forward_content]);
            return json_encode(['sta' => '1', 'msg' => "请求成功", 'data' => '']);
        } else {
            return json_encode(['sta' => '0', 'msg' => "请求失败", 'data' => '']);
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
		
		$data['share_name'] =Input::get('share_name')?:"";
        $data['user_id'] = Input::get('user_id');
       $data['share_content'] = $request->share_content;
		//$data['user_id'] =16;
		// $data['share_content'] = "111";
        $data['pid'] = $request->pid;
        if (empty($data['pid'])) {
            $data['pid'] = '';
        }
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
	
        $share_count = User_share::where('userdynamics_id', $request->userdynamics_id)->count();
        $dynamics->update(['comment_num' => $share_count]);
        //发送消息通知
        $msg = "";
        if ($rst) {
            //消息日志
            /**需要动态id，消息提醒用户id,点赞者id*/		
		
            $message_record['user_id'] = $data['user_id'];
            $message_record['remind_name'] ="";
            $message_record['userdynamics_id'] = $data['userdynamics_id'];
            if (!empty($data['pid'])) {//回复评论
                $message_record['record_type'] = "3";//状态4为回复评论
                $message_record['reply_id'] = $data['pid'];
            } else {
                $message_record['record_type'] = "3";
            }
            $message_record['puser_id'] = $dynamics->user_id;//点赞，评论所需的用户id
            $message_record['record_content'] = '';
            $message_record['share_id'] = $rst->id;
            $message_record['record_status'] = '0';
            $set_rst = Message_record::create($message_record);
		
			
            return json_encode(['msg' => "请求成功", 'sta' => '1', 'data' => $rst], JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(['msg' => "请求失败，服务器错误", 'sta' => '0', 'data' => ''], JSON_UNESCAPED_UNICODE);
        }
    }
    /**
     * @return mixed
     ** 获取好友动态信息
     * 任何用户都可以请求此接口
     * 需要参数：动态id(userdynamics_id)
     * 分两部分，动态内容，评论部分
     * 另需统计参数：转发数，点赞数
     */
    public function GetUserShare_list()
    {
        $page = Input::get('page');
        if (empty($page)) {
            $set_diary = User_dynamics::orderBy('id', 'desc')
                ->select('*')->offset(0)->limit(10)->get()->toArray();
        } else {
            $set_diary = User_dynamics::orderBy('id', 'desc')
                ->select('*')->offset(($page - 1) * 10)->limit(10)->get()->toArray();
        }
        if ($set_diary) {
            //获取评论信息
            $set_diary = $this->Dataprocess($set_diary);
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
        $user_id = Input::get('user_id');
        $data = User::find($user_id)->toArray();
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
        $data["dynmics"] = User_dynamics::where('user_id', $user_id)->count();
        //获取用户关注好友个数Userattention
        $data['attention'] = Userattention::where('user_id', $user_id)->count();
        //获取关注用户粉丝个数
        $data['fans'] = Userattention::where('attention_userid', $user_id)->count();
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
