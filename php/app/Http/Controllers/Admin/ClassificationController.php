<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/17
 * Time: 11:30
 */


namespace App\Http\Controllers\Admin;
use App\Models\Pgoods;
use App\Models\Brand;
use App\Models\Goods;
use App\Models\Dgoods;
use App\Models\User;
use App\Models\Sort;
use App\Models\Actice;
use App\Models\Attributes;
use App\Models\Goods_param;
use App\Models\Goods_standard;
use App\Models\Gcollection;
use App\Models\Site;
use App\Models\Order;
use App\Models\Order_goods_info;
use Input;
use phpDocumentor\Reflection\Types\Object_;
use phpDocumentor\Reflection\Types\Object;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use Response;
use Validator;
use App\Http\Controllers\Controller;


class ClassificationController extends Controller
{

    /**
     * 商品管理的处理开始
     */
    /**
     * Display a listing of the resource.
     * 商品分类列表
     * @return \Illuminate\Http\Response
     */
    /**
     * Display a listing of the resource.
     *
     *  获取商品分类
     * 商品的一级分类
     * 商品分类接口：域名+/class/index
     * 请求方式：get
     * ：返回：分类id（id），分类名称（name）
     *返回参数格式json如下
     *{"msg":"请求成功","sta":"1","data":""}
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
     $class_sort = Sort::where('pid', 0)->orderBy('id', 'asc')->get();

        if($class_sort){
            return json_encode(['msg'=>'请求成功','data'=>$class_sort,'sta'=>'1']);
        }else {
			$obj=(object)array();
            return json_encode(['msg' => '暂无分类', 'data' => $obj, 'sta' => '1']);
        }
    }


//分类信息
/*
 获取商品分类
     * 商品查询出来的信息的
     * 商品列表接口：域名+/gclass/queryclass
     * 请求方式：get
     * ：返回：商品的名字（goods_title）分类id（sort.id），分类名称（sort.name），图片(Thumbnails)
     *返回参数格式json如下
     *{"msg":"请求成功","sta":"1","data":""}
*/

public function queryclass(){
      $goods_sort = trim(Input::get('goods_sort'));
      $sortid = trim(Input::get('sortid'));

	 //  if($sortid and $goods_sort) {
           $class_sort = Sort::join('goods', 'sort.id','=','goods.sort_id')
                        ->where("sort.id", "=", $sortid)
					    ->where('goods_sort', "=", $goods_sort)
                        ->select('goods_title', 'sort.name', 'Thumbnails',"goods.id")
                        ->get();
			   //dd($class_sort);
           if (!empty($class_sort)) {
               for ($i = 0; $i < count($class_sort); $i++) {
                   $class_sort["$i"]->Thumbnails = md52url($class_sort["$i"]->Thumbnails);
               }
           }
           if($class_sort){
               return json_encode(['msg'=>'请求成功','data'=>$class_sort,'sta'=>'1']);
           }else {
               $obj=(object)array();
               return json_encode(['msg' => '暂无列表', 'data' => $obj, 'sta' => '1']);
           }
      // }
       //else {
//$obj=(object)array();
   //return json_encode(['msg' => '没有数据', 'data' =>"", 'sta' => '0']);
 //}

}


//获取商品详情信息
//gclass/commodity 详情信息：
//请求方式：get
// 所需参数：id;gid(传入的商品id)
//返回参数格式json如下
//{"msg":"请求成功","sta":"1","data":""}
    public function commodity()
    {
		//dd("123");
        $gid = trim(Input::get('gid'));
		$gsort=Input::get("goods_sort");
		 $user_id=Input::get("user_id")?:Auth::id();
	$class_sort=Goods::where('id',$gid)->first();
	
if(!$class_sort){
            return json_encode(['msg' => '暂无商品', 'data' => '', 'sta' => '0']);
        }
		else {
			$count=Dgoods::where("gid",$gid)->count();
			
            $goods_sort = Dgoods::where('gid', $gid)->orderBy('id', 'desc')->first();
		
	
            if (!empty($goods_sort)) {	
				if(!$goods_sort["specif"])
					{
						//$specifs=$this->SpcifName($gid,$goods_sort["specif"]);
					   $goods_sort["specif"]="";
					}
					//else
					//{
						//	$specifs=$this->SpcifName($gid,$goods_sort["specif"]);
					  // $goods_sort["specif"]=$specifs;
					//}
               $goods_sort["dcount"]=$count;
				if(!$goods_sort["dimg"])
				{
				$goods_sort["dimg"]=[];
				}
			else
			{
				$goods_sort["dimg"]=explode(",",$goods_sort["dimg"]);
				$arr=array();
				$arr=$goods_sort["dimg"];
				for($k=0;$k<count($arr);$k++)
				{
					$arr[$k]=md52url($arr[$k]);
			    }
			$goods_sort["dimg"]=$arr;
			}
			
				if($goods_sort["dcontent"]==null)
				{
					$goods_sort["dcontent"]="";
				}
                $good_user = User::where('id', $goods_sort['uid'])->select("id", "nickname", "avatar")->first()->toArray();
                $good_user['avatar'] = md52url($good_user['avatar']);
				$good_user['name']=$good_user["nickname"];
				unset($good_user["nickname"]);
                $class_sort['good_sort'] = $good_user;
   $class_sort['good_user'] = $goods_sort;
            }
			else{
				$obj=(object)array();
	 $class_sort['good_sort'] =$obj;
   $class_sort['good_user'] = $obj;
			}
			$patt=Attributes::where("sort_id","=",$class_sort["sort_id"])->where("pid","=","0")->get()->toArray();
			$pgoods=array();
			for($i=0;$i<count($patt);$i++){
				$pgoods[$i]["title"]=$patt[$i]["arr_name"];
				$pgoods[$i]["1-title"]=$patt[$i]["arr_name"];
				$pnames=Attributes::where("pid","=",$patt[$i]["id"])->get()->toArray();
				$pnamesx=array();
				for($j=0;$j<count($pnames);$j++)
				{
					$pnamesx[]=$pnames[$j]["arr_name"];
				}
				$comma_separated=implode(",",$pnamesx);
				$pgoods[$i]["value"]=$comma_separated;
				
			}
			$class_sort['pcontents']=$pgoods;
			$param=Goods_param::where("goods_id","=",$gid)->select("key","vel")->get()->toArray();
			$class_sort["parameter"]=$param;
			
			$standard=Goods_standard::where("goods_id","=",$gid)->orderBy("price")->get()->toArray();
			if($standard)
			{
				$class_sort["price"]=$standard[0]["price"];
			}
		else{
			$class_sort["price"]="0";
		}
			
			$brandname=Brand::where("id","=",$class_sort["brand_id"])->select("brand_name")->first();
			$class_sort["brand_name"]=$brandname["brand_name"];
			
			
			
        }		
            //处理商品详情信息
            $class_sort["content"] = htmlspecialchars(str_replace(array("\r\n", "\r", "\n"), "", $class_sort["content"]));
            $class_sort["Thumbnails"] = md52url($class_sort["Thumbnails"]);
			
            $plan = $class_sort["plan"];
			if($plan)
			{
					$plans = explode(',', $plan);
					$plangs = array();
					for ($i = 0; $i < count($plans); $i++) {
						$plangs[] = md52url($plans[$i]);
					}
					$class_sort["plan"] = $plangs;
			}
			else{
				$class_sort["plan"]=[];
			}

           $gc=Gcollection::where("goodid","=",$gid)->where("usersid","=",$user_id)->first();
            if($gc)
            {
                $class_sort["collect"]=1;
            }
            else
            {
                $class_sort["collect"]=0;
            }

            if ($class_sort) {
                return json_encode(['msg' => '请求成功', 'data' => $class_sort, 'sta' => '1']);
            } else {
                return json_encode(['msg' => '请求失败', 'data' => '', 'sta' => '0']);
            }

        }
		
		
		
		/*
     * 商品选择接口  gclass/choose
	*cid 选择商品的规格
     */
	public  function  choose()
    {
        error_reporting( E_ALL&~E_NOTICE );
        $user_id = Input::get('uid')?:Auth::id();
        $cid=Input::get("cid");
        $gid=Input::get("gid");
        if($gid and $cid) {
            $stand = Goods_standard::where("goods_id", "=", $gid)->get()->toArray();
            $good = Goods::where("id", "=", $gid)->select("sort_id")->first();
            $cids = explode(",", $cid);
            $att = array();
            for ($i = 0; $i < count($cids); $i++) {
                $att[$i] = Attributes::where("arr_name", "=", "$cids[$i]")
                    ->where("sort_id", "=", $good['sort_id'])
                    ->select("id")
                    ->get()
                    ->toArray();
                    }
			     $arrs="";
            for ($j = 0; $j < count($att); $j++) {
                $arr[$j] = $att[$j][0];
                if($j<(count($att)-1)) {
                    $arrs .= $arr[$j]["id"] . ",";
                }
                else
                {
                    $arrs .= $arr[$j]["id"];
                }
            }

                $attd = Goods_standard::where("goods_id", "=", $gid)
                    ->where("attributes_id", "=",$arrs)
                    ->select("price", "stock")
                    ->first();
					if($attd) {
						return json_encode(['msg' => '请求成功', 'data' => $attd, 'sta' => '1']);
					}else{
						return json_encode(['msg' => '输入参数有问题', 'data'=>['stock'=>0,'price'=>0], 'sta' => '1']);
					}
        }
        else{
            return json_encode(['msg' => '请求失败', 'data' => '', 'sta' => '0']);
        }

    }
	
		
		
		
		
		
    /**
     * 获取规格名称
     */
    protected function SpcifName($id, $name)
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
					$sort_name = $sort_name = $Att["arr_name"];
                    }
                }
                return $sort_name;
            }
        }
    }
		
		
		    /**
     * 获取规格id
     */
    protected function Spcifid($gid,$specif){
					
	 $StrArr = explode(',',$specif);
			if (!empty($StrArr)) {
				$goodid=Goods::where("id","=",$gid)->select("sort_id")->first();
					if ($goodid) {
						$sort_name = "";
							foreach ($StrArr as $key => $vey) {
								$Att = Attributes::where(['sort_id' => $goodid["sort_id"], 'arr_name' => $vey])->first();
									if ($sort_name != '') {
										$sort_name = $sort_name . ',' . $sort_name = $Att->id;
									} else {
									$sort_name = $sort_name = $Att["id"];
									}
							}
				  return $sort_name;
					}
			}
	
	}
		
		/*
		*获取订单的规格
		*/
		
			 
		//$data=array (
 //0 => array (
  
 //'dimg' => '1f1b4eb291c97c0ff1fa9a9b4140f8c0002',

  // 'specif' => '白',或者白，x
 
  // 'gid' => 35,
   
  // 'oid' => '360557426992665016',
 
   //'user_id' => 16,
   
   ///'dcontent' => '',
  
//),
//);		 
//file_put_contents("GetInputAll.txt",var_export($data,true),FILE_APPEND);	
	  //$data=json_decode(Input::get('data'),true);
		//$myfile = fopen("user_log111.txt","w");
   // fwrite($myfile,var_export($data,true));
  // fclose($myfile);
	  // dd($data);	
		
		
		
		//商品的评论
		//gclass/add_comment
		public  function  add_comment(){
					
			$data=Input::get('data');
			$data=json_decode($data,true);
	
		if($data)
		{
			
			$soid=$data[0]["oid"];
			//dd($soid);

			$ord=Order::where("order_id","=",$soid)->select("status")->first();
			$ordcount=Order::join("order_goods_info","order.order_id","=","order_goods_info.order_id")
			->where("order_goods_info.order_id","=",$soid)
			->count();
			$datacount=count($data);
			//dd($datacount);
			   
			
					//dd($ord["status"]);
					if($ord["status"]=="3")
					{		   
						   //$dgoods=new Dgoods();
									foreach($data as $k=>$v)
									{
										
										$dgoods=new Dgoods();
										 $first=dgoods::where("gid","=",$v["gid"])
										 ->where("uid","=",$v["user_id"])
										  ->where("oid","=",$v["oid"])
										  ->where("specif","=",$v["specif"])
										  ->first();
							
											  if($first)
											  {
												  return json_encode(['msg' => '不能重复评论', 'data' => '', 'sta' => '0']); 
											  }
											$user_id=$v["user_id"];
											$gid=$v["gid"];
											$dimg=$v["dimg"];
											$specif=$v["specif"];
											$dcontent=$v["dcontent"];
											$orderid=$v["oid"];
											if(empty($v["dimg"]) and empty($v["dcontent"]))
											{
												return json_encode(['msg' => '评论的图片和内容不能同时为空', 'data' => '', 'sta' => '0']);
											}
											//$dgoods->gid=$gid;
											//$dgoods->uid=$user_id;
											//$dgoods->dimg=$dimg;
											//$dgoods->specif=$specif;
											//$dgoods->dcontent=$dcontent;
											//$dgoods->oid=$orderid;
											$dgoods->gid=$v["gid"];
											$dgoods->uid=$v["user_id"];
											$dgoods->dimg=$v["dimg"];
											$dgoods->specif=$v["specif"];
											$dgoods->dcontent=$v["dcontent"];
											$dgoods->oid=$v["oid"];
											
											$boll[$k]=$dgoods->save();	
//var_dump($dgoods->specif);										
											$specif=$this->Spcifid($gid,$specif);
											$ordrt_up=Order_goods_info::where("order_id","=",$orderid)
													   ->where("goods_id","=",$gid)->where("specif","=",$specif)
														  ->update(["geval"=>1]);
													
														  
														  $countord=Order_goods_info::where("order_id","=",$orderid)->where("geval","=",1)
														  ->count();
														  
											  if($ordcount==$countord)
														  {
															  $ordup=Order::where("order_id","=",$orderid)
															  ->where("user_id","=",$user_id)->update(["eval"=>1]);
														  }
									}
										  if($ordcount==$datacount)
														  {
															 $ordup=Order::where("order_id","=",$orderid)
															  ->where("user_id","=",$user_id)->update(["eval"=>1]);
														 }
							return json_encode(['msg' => '请求成功', 'data' =>"1", 'sta' => '1']);
					}
			else
			{
			 return json_encode(['msg' => '权限不够', 'data' =>"0", 'sta' => '0']); 	
			}
		}
   else
   {
   
	  return json_encode(['msg' => '请求失败', 'data' =>"0", 'sta' => '0']); 
  }
}

/*
*所有商品的评论
*gclass/commentlist
*/
public function commentlist()
{ 
	$page=$this->SetPage();
$gid=Input::get("gid");
//$user_id = Input::get('uid')?:Auth::id();
	$goods=Goods::where("id","=",$gid)->first();
	if(!$goods)
	{
		     return json_encode(['msg' => '你评论的商品不存在', 'data' => '', 'sta' => '0']);
	}

 $commentlist=Dgoods::join("user","dgoods.uid","=","user.id")->where("gid","=",$gid)
              ->select("dgoods.*","nickname","avatar")
			  ->offset($page)->limit(10)
			  ->get()
			  ->toArray();
 for($i=0;$i<count($commentlist);$i++)
 {
	 
	// $good_user['name']=$good_user["nickname"];
				//unset($good_user["nickname"]);
				
	$specifs=$this->SpcifName($gid,$commentlist[$i]["specif"]);
		$commentlist[$i]["specif"]=$specifs;
		
     $commentlist[$i]["name"]=$commentlist[$i]["nickname"];
	 unset($commentlist[$i]["nickname"]);
	 $commentlist[$i]["avatar"]=md52url($commentlist[$i]["avatar"]);
	
	 if(!$commentlist[$i]["dimg"])
	 {
		$commentlist[$i]["dimg"]=[];
	 }
	 else{
		  $commentlist[$i]["dimg"]=explode(",",$commentlist[$i]["dimg"]);
		for($j=0;$j<count($commentlist[$i]["dimg"]);$j++)
		  {
			  $commentlist[$i]["dimg"][$j]=md52url($commentlist[$i]["dimg"][$j]);
		  }
	 }
	 if($commentlist[$i]["dcontent"]==null)
	 {
		$commentlist[$i]["dcontent"]=""; 
	 }
	 
	 
 }
   if($commentlist)
   {
	   return json_encode(['msg' => '请求成功', 'data' =>$commentlist, 'sta' => '1']);
   }
   else{
	   $obj=(object)array();
	      return json_encode(['msg' => '暂无评论', 'data' => $obj, 'sta' => '1']);
   }

	
}	
		
		
    public  function  details(){
        $users = DB::table('user_share')
           ->join('user', 'user.id', '=', 'user_share.user_id')
           ->join('brand', 'brand.id', '=', 'goods.brand_id')

           ->get();

        return response()->json($users);

    }

/*
*系统消息  gclass/systems
 * get的请求
     *  返回参数格式json如下
     *{"msg":"请求成功","sta":"1","data":""}
*/
	
	 public function systems(){
	    $system=Sort::where("name","=","系统日志")->select("id")->first();
	     if($system)
	        {
		      $syslists=Actice::where("sort_id","=",$system["id"])->get()->toArray();
		      if($syslists){
			     for($i=0;$i<count($syslists);$i++){
				  $syslists[$i]["content"] = strip_tags(str_replace(array("\r\n", "\r", "\n"), "",$syslists[$i]["content"]));
		         $syslists[$i]["aimg"] = md52url($syslists[$i]["aimg"]);
			         }//for	

			 if($syslists){ return json_encode(["sta" => '1', 'msg' => '请求成功', 'data' => $syslists]); }//if
		    else { 
			  $obj=(object)array();
			return json_encode(["sta" => '1', 'msg' => '暂无系统消息', 'data' =>$obj]);}//else		 
 }//syslists
		    else { 
			return json_encode(["sta" => '0', 'msg' => '请求失败', 'data' =>""]);}//else		
	              }//$system
		 else{
			 return json_encode(["sta" => '0', 'msg' => '请求失败', 'data' =>""]);
		 }
	 }

	 
	 /*添加收货地址
     * gclass/address
     * get的请求
     * 返回参数格式json如下
     *{"msg":"请求成功","sta":"1","data":""}
     */
public  function  address(Request $request)
{
 
        $data['user_id']=Input::get("user_id")?:Auth::id();
        $data["consignee"]=Input::get("consignee");//收货人
        $data["phone"]=Input::get("phone");//电话
        $data["area"]=Input::get("area");//所在省
        $data["street"]=Input::get("street");//市
		$data['district']=Input::get("district");//区或县   
		$data["scene"]=Input::get("scene");//街道
        $data["scontent"]=Input::get("scontent");//详细地址

       $data["sdefault"]=Input::get("sdefault");//是否默认
	   
	     
	 
	 
	         if($data["sdefault"]=="1")
               {
               $supdate=Site::where("user_id","=",$data['user_id'])
                   ->update(['sdefault' =>"0"]);
                 }
//	$myfile = fopen("user_log111.txt","w");
    // fwrite($myfile,var_export($supdate,true));
    // fclose($myfile);
	   
        $site = new Site();
        $messages = [
            'consignee.required' => '收货人的地址请填写',
            'phone.required' => '电话请填写',
			'phone.numeric' => '电话号必须是数字',
			 'area.required' => '省请填写',
            'street.required' => '市请填写',
          'scontent.required' => '详细地址请填写',
		    'district.required' => '区或县请填写',
			 //'scene.required' => '街道请填写',
        ];
        $validator = Validator::make($request->all(),$site->rules()['create'], $messages);
        $messages = $validator->messages();
        if ($validator->fails()) {
            $msg = $messages->toArray();
            foreach ($msg as $k => $v) {
                return json_encode(['sta' => '0', 'msg' => $v[0], 'data' => '']);
            }
        }
        $rst = $site->create($data);//保存成功跳转到分类列表页	
        if ($rst) {
            return json_encode(["sta" => '1', 'msg' => '请求成功', 'data' => $rst]);
        }
        else
        {
         return json_encode(["sta" => '0', 'msg' => '请求失败', 'data' =>'']);
		}


}


 /*
     * 删除地址管理
     * gclass/ressdel
     * 传入参数 地址管理的sid 用户的id （user_id）
     *
     */
    public function ressdel(){
        $userid=Input::get("user_id")?:Auth::id();
        $sid=Input::get("sid");
		//dd($userid);
    
            $resdel=Site::where("sid","=",$sid)->where("user_id","=",$userid)->delete();
            if($resdel)
            {
                return json_encode(["sta" => '1', 'msg' => '请求成功', 'data' =>$resdel]);
            }
            else
            {
                return json_encode(["sta" => '0', 'msg' => '请求失败', 'data' =>'']);
            }

   

    }

	 
	 /*
     * 地址修改
     * gclass/ressupdate
     * 传入参数 地址管理的sid
      *  {"msg":"请求成功","sta":"1","data":""}
     */
   
   public  function  ressupdate(Request $request)
    {
	
        $actice = Site::find(Input::get("sid"));

		$user_id=$actice["user_id"];
		$sid=Input::get("sid");
		 if(!$actice)
		 {
			  return json_encode(['msg' => '暂无该地址', 'data' => '', 'sta' => 0]);
		 }
        $messages = [
            'consignee.required' => '收货人的地址请填写',
            'phone.required' => '电话请填写',
			'phone.numeric' => '电话号必须是数字',
            'area.required' => '省请填写',
            'street.required' => '市请填写',
            'scontent.required' => '详细地址请填写',
            'district.required' => '区或县请填写',	
        ];

        $validator = Validator::make($request->all(), $actice->rules()['update'],$messages);
        $messages = $validator->messages();
        if ($validator->fails()) {
            $msg = $messages->toArray();
            foreach ($msg as $k => $v) {
                return json_encode(['sta' => 0, 'msg' => $v[0], 'data' => '']);
            }
        }
		 
        $rst_data=$actice->update($request->only($actice->getFillable()));
		$myfile = fopen("user_log111.txt","w");
      fwrite($myfile,var_export($request->all(),true));
      fclose($myfile);
    if($rst_data)
	{
		$up_site=Site::where("user_id","=",$user_id)
			    ->where("sid","not",$sid)
			   ->update(['sdefault' =>"0"]);
	}

  
		  	//$myfile = fopen("user_log111.txt","w");
     // fwrite($myfile,var_export($request->all(),true));
      //fclose($myfile);
  
        if($rst_data){
            return json_encode(['msg'=>'更新成功','data'=>'1','sta'=>'1']);
        }else {
            return json_encode(['msg' => '更新失败', 'data' => '', 'sta' => 0,]);
        }

    }

	
    /*
     * 默认地址
     * 传入参数 用户的id(用户id)
     * gclass/ressdefault
     * {"msg":"请求成功","sta":"1","data":""}
     */

    public  function ressdefault()
    {
        $user_id=Input::get("user_id")?:Auth::id();
        $rdefault=Site::where("user_id","=",$user_id)->where("sdefault","=","1")->first();
       if($rdefault)
       {
           return json_encode(['msg'=>'请求成功','data'=>$rdefault,'sta'=>'1']);
       }
        else
        {
			$obj=(object)array();
            return json_encode(['msg'=>'暂无默认地址','data'=>$obj,'sta'=>'1']);
        }
    }


	
	
	
	

	   public  function  gressupdate(Request $request)
    {
        $sid=Input::get("sid");
        $actice = Site::find($sid);
        //dd($actice);
        if($actice) {
            $messages = [
                'consignee.required' => '收货人的地址请填写',
                'phone.required' => '电话请填写',
                'area.required' => '省请填写',
                'street.required' => '市请填写',
                'scontent.required' => '详细地址请填写',
                'district.required' => '区或县请填写',
            ];
            $validator = Validator::make($request->all(), $actice->rules()['update'], $messages);
            $messages = $validator->messages();
            if ($validator->fails()) {
                $msg = $messages->toArray();
                foreach ($msg as $k => $v) {
                    return json_encode(['sta' => 0, 'msg' => $v[0], 'data' => '']);
                }
            }
            $rst_data = $actice->update($request->only($actice->getFillable()));
            if ($rst_data) {
                return json_encode(['msg' => '更新成功', 'data' => $rst_data, 'sta' => '1']);
            } else {
                return json_encode(['msg' => '更新失败', 'data' => '', 'sta' => 0,]);
            }
        }
        else{
            return json_encode(['msg' => '更新失败', 'data' => '', 'sta' => 0,]);
        }

    }
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	     /*
    * 地址列表管理
    * gclass/resslist
    * 传入参数 地址管理的sid 用户的id （user_id）
    *
    */
    public  function  resslist(){
        $userid=Input::get("user_id")?:Auth::id();
        if($userid)
        {

            $reslist=Site::where("user_id","=",$userid)->orderBy("sdefault","desc")->get()->toArray();
            if($reslist)
            {
                return json_encode(["sta" => '1', 'msg' => '请求成功', 'data' =>$reslist]);
            }
            else
            {
				$obj=(object)array();
                return json_encode(["sta" => '1', 'msg' => '没有列表', 'data' =>$obj]);
            }
        }
        else
        {
            return json_encode(["sta" => '0', 'msg' => '请求失败', 'data' =>'']);
        }
    }
	
	
	/*
	*热卖推荐
	*/
	 
	 public function goods_hot()
	 {
		   //$page = $this->SetPage();
		   $user_id=Input::get("user_id")?:Auth::id();
		$order=Order_goods_info::select("goods_id",DB::raw('count(goods_id) as count'))
		  ->orderBy("count","desc")
		 // ->offset($page)
		  ->limit(10)
		  ->groupBy("goods_id")
		  ->get()
		   ->toArray();
	
	 if($order){
		   for($i=0;$i<count($order);$i++)
		    {
			   $sortid[$i]=Goods::join("goods_standard","goods.id","=","goods_standard.goods_id")
			           ->where("id","=",$order[$i]["goods_id"])
			           ->select("sort_id","Thumbnails","goods_title","id","price")
					   ->orderBy("price")
					   ->first();
					   if($sortid[$i]["price"]==null)
					   {
						   $sortid[$i]["price"]=0;
					   }
					   $sortid[$i]["Thumbnails"]=md52url($sortid[$i]["Thumbnails"]);
					   
					   if($user_id and $user_id!=0)
					   {	 
						$gc=Gcollection::where("goodid","=",$order[$i]["goods_id"])->where("usersid","=",$user_id)->first();
						        if($gc)
								{

									$sortid[$i]["collect"]=1;
								}
								else
								{
									$sortid[$i]["collect"]=0;
								}   
					   }
					   else
					   {
						  $sortid[$i]["collect"]=0;
					   }
					   
					$gcounts=Gcollection::where("goodid","=",$order[$i]["goods_id"])->count();
						  if($gcounts)
						  {
							  $sortid[$i]["gcounts"]=$gcounts;
						  }
						  else
						  {
							  $sortid[$i]["gcounts"]=0;
						  }  
		   }
      return json_encode(["sta" => '1', 'msg' => '请求成功', 'data' =>$sortid]);
	 }
else
{
	$obj=(object)array();
	 return json_encode(["sta" => '1', 'msg' => '暂无列表', 'data' =>$obj]);
}
	 
	 
	 }	 
}