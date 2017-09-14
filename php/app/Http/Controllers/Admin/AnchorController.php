<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Input;
use phpDocumentor\Reflection\Types\Null_;
use Redirect;
use Response;
use App\Models\User;
use App\Models\Anchor;
use App\Http\Requests;
use Validator;
use App\Models\Room;
use App\Models\Sort;
use App\Models\Focus;
use App\Models\Actice;
use App\Models\ServerAPI;
use App\Models\SendSMS;
use App\Models\AclUser;
use App\Models\AclRole;
use App\Models\AclResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AnchorController extends Controller
{
	
	  /*
 * 成为直播
 *  user/into
 */
    public  function into()
    {
		$user_id=Input::get("uid");
        $user=User::where("id","=",$user_id)->where("whether","=",1)->first();
        if($user)
        {
           return Redirect()->route('Bells.member_list')->with('msg', '请求失败');

        }
        else{
            $up_user=User::where("id","=",$user_id)
                ->update(["whether"=>1]);
            if($up_user)
            {
                return Redirect()->route('Bells.member_list')->with('msg', '请求成功');
            }
            else
            {
                return Redirect()->route('Bells.member_list')->with('msg', '请求失败');
            }
        }
	}

	/*
	 *成为会员
	 */
	 public function delinto()
	 {
		$user_id=Input::get("uid");
        $user=User::where("id","=",$user_id)->where("whether","=",0)->first();
        if($user)
        {
           return Redirect()->route('Bells.member_list')->with('msg', '请求失败');


        }
        else{
            $up_user=User::where("id","=",$user_id)
                ->update(["whether"=>0]);
            if($up_user)
            {
                return Redirect()->route('Bells.member_list')->with('msg', '请求成功');
            }
            else
            {
                return Redirect()->route('Bells.member_list')->with('msg', '请求失败');
            }
        } 
	 }
  public function index()
  {
		   $AppKey = '2bd1a04732b130f096c13ea321497222';
		  $AppSecret = 'e743f28f7a09';
		$p = new ServerAPI($AppKey,$AppSecret,'curl');		//php curl库
		return $p;
  }
  
  /*
   *创建一个频道
   */


  public function addanchor()
  {
	  $room=new Room();
	  $p=$this->index();
	  $rname=Input::get("rname"); 
	  $user_id=Input::get("user_id")?:Auth::id();

	  $key=Input::get("keyword");
	  if(empty($key))
	  {
		  $key="快乐直播每一天";
	  }

	   	$use_an=User::join("room","user.id","=","room.user_id")
		          ->where("room.user_id","=",$user_id)
		         ->select("avatar","nickname","keyword","rid","number","cid","like","user_id","rtmpPullUrl","pushUrl","rname")
				 ->first();
	  if(empty($rname))
	  {
		  return json_encode(['msg' => '频道不存在', 'data' =>["up_room" => 0], 'sta' => '0']);
	  }

//dd($use_an['keyword']);
	if($use_an)
	{
		   $use_an["avatar"]=md52url($use_an["avatar"]);

		if($use_an['rname']!==$rname || $use_an['keyword']!==$key) {
			//dd("123");
			$arr_up = $p->channelUpdate($rname, $use_an["cid"], 0);
			if ($arr_up) {
				$up_anchor = Room::where("user_id", "=", $user_id)->update(["rname" => $rname,"keyword"=>$key]);
				if ($up_anchor) {
					$room=User::join("room","user.id","=","room.user_id")
						->where("room.user_id","=",$user_id)
						  ->select("avatar","nickname","keyword","rid","number","cid","like","user_id","rtmpPullUrl","pushUrl","rname")
						->first();
					$room["avatar"]=md52url($room["avatar"]);
					return json_encode(['msg' => '修改成功', 'data' =>$room, 'sta' => '1']);
				} else {
					return json_encode(['msg' => '修改失败', 'data' =>"", 'sta' => '0']);
				}
			}
		}

			return json_encode(['msg' => '频道已经存在', 'data' =>$use_an, 'sta' => '1']);


	}
	else
	{	   $arr=$p->channelCreate(Input::get("rname"), 1) ;
	 if($arr["code"]==200)
	 {
		$room->rname=$arr["ret"]["name"];
		$room->cid=$arr["ret"]["cid"];
		$room->rid=$this->make_room();
	    $room->rtmpPullUrl=$arr["ret"]["rtmpPullUrl"];
		$room->pushUrl=$arr["ret"]["pushUrl"];
	    $room->ctime=$arr["ret"]["ctime"];
	    $room->msg=$arr["code"];
	    $room->status=0;
	    $room->type=0; 
		$room->number=0;
	    $room->like=0; 
		$room->user_id=$user_id;
		$room->keyword=$key;
		$room=$room->save();
		   	$rooms=User::join("room","user.id","=","room.user_id")
		          ->where("room.user_id","=",$user_id)
		          ->select("avatar","nickname","keyword","rid","number","cid","like","user_id","rtmpPullUrl","pushUrl","rname")
				 ->first();
		 if($room)
		   {
			   $rooms["avatar"]=md52url($rooms["avatar"]);
			 return json_encode(['msg' => '频道名称成功', 'data' =>$rooms, 'sta' => '1']);   
		   }
		   else
		   {
			   return json_encode(['msg' => '频道名称失败', 'data' =>'', 'sta' => '0']);   
		   }
	 }
	 else
	 {
		 return json_encode(['msg' => '频道创建失败', 'data' =>'', 'sta' => '0']);
	 }
	} 
  }
  
  /*
   *修改频道 anchor/up_anchor
   */
  
  public function up_anchor()
  {
	  $user_id=Input::get("user_id")?:Auth::id();
	  $key=Input::get("keyword");
	  $rname=Input::get("rname");
	  $use_an=Room::where("user_id","=",$user_id)->first();	
	  $room=new Room();
	  $p=$this->index(); 
	  $arr=$p->channelUpdate($rname,$use_an["cid"],0);
	  if($arr)
	  {
		  $up_anchor=Room::where("user_id","=",$user_id)->update(["keyword"=>$key,"rname"=>$rname]);
		  if($up_anchor)
		   {
			 return json_encode(['msg' => '修改成功', 'data' =>["up_room"=>1], 'sta' => '1']);    
		   }
		   else
		   {
			  return json_encode(['msg' => '修改失败', 'data' =>["up_room"=>0], 'sta' => '0']);   
		   }
	  }
	  else{
	  return json_encode(['msg' => '修改失败', 'data' =>["up_room"=>0], 'sta' => '0']); 
	  }
	  
  }
  
  
  /*
   *直播首页 anchor/livelist
   */
public function livelist()
{
		 error_reporting( E_ALL&~E_NOTICE );
        //广告栏 sort_id=22
		$page = $this->SetPage();
        $gsort=Sort::where("name","广告活动栏")->select("id")->first();
        $class_sort = Actice::where('sort_id',$gsort["id"])
		            ->orderBy("id","desc")
					->offset($page)
					->limit(10)
					->get()
					->toArray();
        if(empty($class_sort))
        {
            $class_sort=[];
        }
        for($i=0;$i<count($class_sort);$i++)
        {
            $class_sort[$i]["content"]=htmlspecialchars(str_replace(array("\r\n", "\r", "\n"), "",  $class_sort[$i]["content"]));
			
			$class_sort[$i]["aimg"]=md52url($class_sort[$i]["aimg"]);
        
        }
		$arr["sort"]=$class_sort;
		
		$livelist=User::join("room","user.id","=","room.user_id")
			->where("status","=","1")
		         ->select("avatar","nickname","keyword","number","rid","like","user_id","rtmpPullUrl","pushUrl","rname")
				 ->get()->toArray();
		if($livelist)
		{
						 
				for($j=0;$j<count($livelist);$j++)
				{
					$livelist[$j]["avatar"]=md52url($livelist[$j]["avatar"]);
				}
		$arr["livelist"]=$livelist;
		}
		else
		{
			$arr["livelist"]=[];
		}
	
	$arr["antice"]=[];
    return json_encode(['msg' =>'直播列表', 'data' =>$arr,'sta' => '1']);
	
				
}
  
  
	 /*
	  *开播
	  */
      public function start()
	  {
		  
		  
	   $user_id=Input::get("user_id")?:Auth::id();
	   $cid=Input::get("cid");
		$status=Input::get("status");
//	   $use=User::where("id","=",$user_id)
//            ->where("whether","=","1")
//             ->first();

			   if($status=="1")
			   {
				 // $room=new Room();
				 $up_room=Room::where("cid","=",$cid)
					        ->where("user_id","=",$user_id)
				           ->update(["status"=>1]);
				 if($up_room)
				   {
					  return json_encode(['msg' =>'开播成功，请好好直播', 'data' =>["room"=>1],'sta' => '1']);
			
				   }
				   else
				   {
					    return json_encode(['msg' =>'开播失败，请稍后在试', 'data' =>["room"=>0],'sta' => '0']);
		
				   }
				  
			   }
			   else
			   {
				   $up_room=Room::where("cid","=",$cid)
					   ->where("user_id","=",$user_id)
					   ->update(["status"=>0]);
				   if($up_room)
				   {
					   return json_encode(['msg' =>'关播成功,欢迎下次再来', 'data' =>["room"=>1],'sta' => '1']);

				   }
				   else
				   {
					   return json_encode(['msg' =>'关播失败，请稍后在试', 'data' =>["room"=>0],'sta' => '0']);

				   }
			   }
		  
		  }
		  
		  /*
		   *关注人数设置    anchor/followers
		   */
		   public function followers()
		   {
			  $user_id=Input::get("user_id")?:Auth::id();
			  $cid=Input::get("cid");
			  //$like=Input::get("like");
			  $other=Input::get("other");//主播的用户id
				  $use=Room::where("user_id","=",$other)->first();
				  if(!$use)
				  {
					 				return json_encode(['msg' =>'关注的用户有问题', 'data' =>'', 'sta' => '0']); 
				  }
				  $cids=Room::where("cid","=",$cid)->first();
				  if(!$cids)
				  {
					  return json_encode(['msg' =>'关注的房间有问题', 'data' =>'', 'sta' => '0']); 
				  }
			  if($user_id and $cid)
			    {
					$f_like=Focus::join("room","room.user_id","=","focus.other")
									->where("user_id","=",$user_id)
									->where("cid","=",$cid)
									->first();								
									
							if($f_like){
								
								$d_like=Focus::where("user_id","=",$other)
					                    ->where("cid","=",$cid)
										->delect();
										$like=$f_like["like"]-1;
										if($d_like)
										 {
											 $qup_room=Room::where("user_id","=",$other)
					                                  ->where("cid","=",$cid)
													  ->update(["like"=>$like]);
											return json_encode(['msg' =>'取消关注成功', 'data' =>'', 'sta' => '1']);  
										 }
										 else
										 {
											 return json_encode(['msg' =>'取消关注失败', 'data' =>'', 'sta' => '0']);  
										 }
							}
					
					$g_like=Room::where("user_id","=",$other)
					         ->where("cid","=",$cid)
							 ->first();
							 if($g_like){
					
								$focus=new Focus();
								$focus->user_id=$user_id;
								$focus->other=$other;
								$focus->rid=$g_like["rid"];
								$focus->cid=$cid;
								$focus->rname=$g_like["rname"];
								$focus->rtmpPullUrl=g_like["rtmpPullUrl"];
								$focus->pushUrl=g_like["pushUrl"];
		
								$g_focus=$focus->save();
								$like=$g_like["like"]+1;
									if($g_focus)
									{
										
										$up_rooms=Room::where("user_id","=",$other)
					                              ->where("cid","=",$cid)
												  ->update(["like"=>$like]);
											return json_encode(['msg' =>'关注成功', 'data' =>'', 'sta' => '1']);  
										 }
										 else
										 {
											 return json_encode(['msg' =>'关注失败', 'data' =>'', 'sta' => '0']);  
										 }								
							 }
							
							
							
							
				}
				else
				 {
					return json_encode(['msg' =>'传入的参数有问题', 'data' =>'', 'sta' => '1']);   
				 }
			   
		   }
		   
		   
		   /*
		    *关注人列表
			*/ 
		   public function focuslist()
		   {
			   $user_id=Input::get("user_id")?:Auth::id();
			   
			   if($user_id)
				   {
					   $focuslist=Focus::where("user_id","=",$user_id)
					              ->orderBy("id","desc")
								  ->get()
								  ->toArray();
						if(!empty($focuslist))
						 {
							return json_encode(['msg' =>'请求成功', 'data' =>$focuslist, 'sta' => '0']);   
						 }
						 else
						 {
							 $obj=(object)array();
					      return json_encode(['msg' =>'请求成功', 'data' =>$obj, 'sta' => '0']);    
						 }
				   }
			   else
			   {
				  			return json_encode(['msg' =>'请登录查看', 'data' =>'', 'sta' => '0']);     
			   }			   
			   
			   
		   }
		   
		   
		   
		   
		   
		   
		   
		   
		   

		  /*
		   * 不用
		   *开播后设置
		   */
		   public function set()
		    {
					   $user_id=Input::get("user_id")?:Auth::id();
					   $room_id=Input::get("room_id");
					   $theme=Input::get("themename");
					   $keyword=Input::get("keyword");
					   $anchor=new Anchor();
					   $anchor->user_id=$user_id;
					   $anchor->room_id=$room_id;
					   $anchor->themename=$theme;
					   $anchor->keyword=$keyword;
					   $anchor=$anchor->save();
					   if($anchor)
					    {
							 return json_encode(['msg' =>'开播设置成功', 'data' =>["room"=>1], 'sta' => '1']);
						}
						else
						{
							return json_encode(['msg' =>'开播设置失败', 'data' =>'', 'sta' => '0']);
						}
			}

			/*
			 *直播列表
			 */
          public function anchor_list()
		  {
			 //$p=$this->index();
			 //$arr=$p->channelList();
			 //$ret=$arr["ret"];
			 //$list=$ret["list"];
			 // dd($list);
			//$roomlist=Room::orderBy("created_at","desc")
				     //  ->get()->toArray();
			//for($i=0;$i<count($list);$i++)
			//{
				//if($list[$i]["cid"]==$roomlist[$i]["cid"] and $list[$i]["status"]!==$roomlist[$i]["status"])
				//{
				 	//$room_up=Room::where("cid","=",$list[$i]["cid"])->update(["status"=>$list[$i]["status"]]);
				//}
			//}
			
			
			
		  ignore_user_abort();//关掉浏览器，PHP脚本也可以继续执行.
		  set_time_limit(0);// 通过set_time_limit(0)可以让程序无限制的执行下去
		  //ini_set('memory_limit','512M'); // 设置内存限制
		  $interval=60*1;// 每隔1分钟运行
		  do{

			  $p=$this->index();
  		      $arr=$p->channelList();
			  $ret=$arr["ret"];
			  $list=$ret["list"];
				  $roomlist=Room::orderBy("created_at","desc")
				  ->get()->toArray();
				  for($i=0;$i<count($list);$i++)
				  {
					
					  if($list[$i]["cid"]==$roomlist[$i]["cid"] and $list[$i]["status"]!==$roomlist[$i]["status"])
					  {
						  $room_up=Room::where("cid","=",$list[$i]["cid"])->update(["status"=>$list[$i]["status"]]);
				       }
			         }
					 unset($list);
					 unset($roomlist);
				sleep($interval);	 
					 
		  } while(true);

		  }

 
 }


