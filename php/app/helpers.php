<?php

use App\Models\AclResource;
use App\Models\AclRole;
use App\Http\Controllers\Admin\UploadController;
use App\Models\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Arr;
use App\Models\Sort,App\Models\Goods,App\Models\Brand;
use App\Models\Attributes;


/**
 * 修改角色权限时, 判断是否选中某个功能
 *
 * @param $action
 * @param $have
 *
 * @return string
 */
function roleResourceChecked($action, $have)
{
    if (!is_array($action) && in_array($action, $have)) {
        return 'checked';
    }

    if (is_array($action) && count($have) - count(array_diff($have, $action)) == count($action)) {
        return 'checked';
    }
}

/**
 * 统计某角色拥有的权限个数
 *
 * @param $role
 *
 * @return int
 */
function roleAccessCount($role)
{
    return AclRole::where('role', $role)->count();
}

/**
 * 角色索引 id 转换为对应的名称
 *
 * @param $role
 *
 * @return string
 */
function role2text($role)
{
    return (new AclRole())->role2text($role);
}

/**
 * 评断是否是合法的 email
 *
 * @param $email
 *
 * @return bool
 */
function isEmail($email)
{
    return boolval(filter_var($email, FILTER_VALIDATE_EMAIL));
}

/**
 * 文件大小格式化, 传入字位
 *
 * @param $bytes
 * @return string
 */
function sizeFormat($bytes)
{
    $s = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    $e = floor(log($bytes) / log(1024));

    return sprintf('%.2f ' . $s[$e], ($bytes / pow(1024, floor($e))));
}

/*function routeMa($routeName)
{
    $route = Route::getRoutes()->getByName($routeName);

    dd($route->getActionName());
}

function ma($identifier = null)
{
    if (!Auth::check()) return false;
    $rootNameSpace = "App\Http\Controllers";

    $acl = (new AclResource)->getResource();

    $currentAction = Route::currentRouteAction();
    $actionName = $currentAction;

    $identifier && $actionName = $actionName.'-'.$identifier;//判断是否有标识符对应的权限
    $userAcl = Auth::user()->getACL();

    return in_array($actionName, $acl) && in_array($actionName, $userAcl) || in_array('*', $userAcl);
}*/

/**
 * 判断用户权限
 *
 * @return bool
 */
function acl($role = '', $action = '')
{
    if (!Auth::check()) return false;

    $namespace = "App\\Http\\Controllers\\Admin";
    !$action && $action = Route::current()->getActionName();


    $action = strtr($action, [$namespace . '\\' => '']);;
    !$role && $role = Auth::user()->role;
     //这里添加了p_role_id字段判断
    /*$aclRole = AclRole::where('role', $role)->orWhere(['p_role_id'=>$role,'user_id'=>Auth::user()->id])->get(['resource'])->toArray();*/
    $aclRole = AclRole::where('role', $role)->get(['resource'])->toArray();
    $aclRole = Arr::pluck($aclRole, 'resource');
    // 首页
    if ($action == 'DashboardController@index') {
        return true;
    }

    // 最高权限, 或包含当前路由
    if (in_array('*', $aclRole) || in_array($action, $aclRole)) {
        return true;
    }

    $actionParse = explode('@', $action);
    foreach ($aclRole as $item) {
        $itemParse = explode('@', $item);

        // 排除
        if ('!' . $item == $action) {
            return false;
        }

        // 仅指定类, 如 TestController
        if (!is_int(strpos($action, '@')) && $action == $itemParse[0]) {
            return true;
        }

        // 通配符, 如 TestController@*
        if ((count($actionParse) == 2 && $actionParse[1] == '*' && $actionParse[0] == $itemParse[0])) {
            return true;
        }

        // 通配符
        if ((fnmatch($action, $itemParse[0], FNM_NOESCAPE) || fnmatch($action, $item, FNM_NOESCAPE))) {
            return true;
        }
    }

    return false;
}

/**
 * 根据传入的参数以及 acl 决定是否输出 active class,
 * 可同时传入多个, 可使用通配符, 排除符!
 * 命名空间只需要精确到 Controllers 下面即可, 如:
 *     App\Http\Controllers\Api\HelperController => Api\HelperController
 *
 * example: mla('DashboradController', 'SystemController@index', '!WalletController', 'VerifyController@*')
 *
 * // todo ACL
 *
 * @return string
 */
function mla(...$actionNames)
{
    if (empty($actionNames)) return '';

    $rootNameSpace = "App\Http\Controllers\Admin";
    $currentAction = Route::currentRouteAction();
    $currentActionParse = explode('@', $currentAction);

    $active = false;
    $access = false;

    // active
    foreach ($actionNames as $v) {
        // 排除
        if (is_int(stripos($v, '!'))) {
            $v = '!' . $rootNameSpace . strtr($v, ['!' => '']);
        } else {
            $v = $rootNameSpace . '\\' . $v;
        }
        if ('!' . $currentAction == $v) {
            $active = false;
            continue;
        }

        $vParse = explode('@', $v);
        if (
            // 具体 action 如, TestController@index
            $v == $currentAction ||

            // 仅指定类, 如 TestController
            (!is_int(strpos($v, '@')) && $v == $currentActionParse[0]) ||

            // 通配符, 如 TestController@*
            (count($vParse) == 2 && $vParse[1] == '*' && $vParse[0] == $currentActionParse[0]) ||

            // 通配符
            (fnmatch($v, $currentActionParse[0], FNM_NOESCAPE) || fnmatch($v, $currentAction, FNM_NOESCAPE))
        ) {
            $active = true;
            break;
        }
    }


    //dd($actionNames);
    // 权限, mla 模式下有其中一个权限, 都不会输出 hide
    foreach ($actionNames as $item) {
        if (acl(Auth::user()->role, $item)) {
            $access = true;
            break;
        }
    }

    return $access && $active ? 'active' : (!$access ? 'hide' : '');
}

/**
 * 35位的 md5 转为真实 url
 *
 * @param $md5
 * @param bool|false $location
 * @param null $config
 *
 * @return string
 */
function md52url($md5, $location = false, $config = null)
{
    return (new UploadController())->md52url($md5, $location, $config);
}

function get_extension($file)
{
    return pathinfo($file, PATHINFO_EXTENSION);
}

/**
 *获取分类信息名称
 */
function get_srot_name($id){
    $id=explode(',',$id);
    $name="";
    foreach ($id as $k =>$v){
      $rst=Sort::where('id',$v)->select('name')->first();
        if(!empty($name)){
            $name=$name."[ ".$rst->name." ]"." ";
        }else{
            $name="[ ".$rst->name." ]"." ";
        }
    }
  return $name;
}

/**
 * @param $id
 * @return bool
 * 判断上级分类
 */
function read_pid($id){
    $rst=Sort::where('id',$id)->select('id','pid','name')->first();
    if($rst->pid && $rst->pid != 0){
        return true;
    }else{
        return false;
    }
}

/**
 * @param $id
 * @param $child
 * @return array|string
 * 获取子集分类名字
 */
function child_sort($id,$child){
    if (strlen($child) >= 4) {
        $child = substr($child, 0, strlen($child) - 1);
        $child = explode(',', $child);
        $result=[];
        foreach ($child as $k => $v) {
            if ($v != $id) {
                $result[$k] = Sort::where('id', $v)->select('id', 'pid', 'name')->first();
            }
        }
      return $result;
    }
    return "";
}
/**
*
*修改商品
*
*/
function get_brand($id){


    
}

/**
 * 创建目录
 *
 * @param $action
 * @param $have
 *
 * @return string
 */
function mkdir_dirname($path){


    if(!is_dir(dirname($path))){
        $res=mkdir(iconv("UTF-8", "GBK", dirname($path)),0777,true);

        if ($res){
            return true;
        }else{
            return false;
        }
    }
}


//图片压缩
function resize_img($img,$new_with=200,$md5=true)
{
    if($md5==true){
        $old_url = md52url($img);//取出地址
    }else{
        $old_url = $img;
    }
    if ($old_url != NULL) {
        $host_url = parse_url(dirname($old_url).'/resize_' . $new_with . '_' .basename($old_url));
        if($host_url['host'] == 'lsadmin.umallushop.com'){
            $path =   str_replace('http://lsadmin.umallushop.com/','',dirname($old_url).'/resize_' . $new_with . '_' .basename($old_url));
        }else{
            $path = str_replace(url('/').'/','',dirname($old_url).'/resize_' . $new_with . '_' .basename($old_url));
        }
        $old_path = $img_url = str_replace(url('/').'/','',$old_url);
        //原图大小
        if(getimagesize($old_url)){
            $old_img_size = getimagesize($old_url);
            if ($old_img_size) {
                $old_width = $old_img_size['0'];
                $old_height = $old_img_size['1'];
                $new_height = ($old_height * $new_with) / $old_width;
                $new_url = dirname($old_url).'/resize_' . $new_with . '_' .basename($old_url);
                //判断图片是否存在
                if (!file_exists($path)) {

                    Image::make($old_path)->resize($new_with, $new_height)->save($path);
                }
                return $new_url;
            } else {
                return $old_url;
            }
        }else{
            return $old_url;
        }
    } else {
        return $old_url;
    }
}

//读取文件夹下所有图片名
function searchDir($path, &$data)
{
    if (is_dir($path)) {
        $dp = dir($path);
        while ($file = $dp->read()) {
            if ($file != '.' && $file != '..') {
                searchDir($path . '/' . $file, $data);
            }
        }
        $dp->close();
    }
    if (is_file($path)) {
        $data[] = $path;
    }
}


//微信分享图片下载
function share_img($url,$type='weixin',$rep_id='')
{


    if(getimagesize($url)){
        $size = getimagesize($url);


        if (is_array($size)) {

            $suffix = explode('/', $size['mime']);//分解图片后缀
            $pic_name_arr = explode('/', dirname($url));//分解图片地址
            $pic_name = $pic_name_arr[count($pic_name_arr) - 1];//取出图片名

            if($type == 'baidu'){

                $path = 'baidu_img/'.$rep_id .'_'. $pic_name .'_'.md5($url). '.' . $suffix[1];

            }else{
                $path = 'share_img/' . $pic_name . '.' . $suffix[1];

            }

            $new_url = url('') . '/' . $path;
            if (!file_exists($new_url)) {
                //mkdir($path, 0777);
                $ch = curl_init();
                $httpheader = array(
                    'Host' => 'mmbiz.qpic.cn',
                    'Connection' => 'keep-alive',
                    'Pragma' => 'no-cache',
                    'Cache-Control' => 'no-cache',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,/;q=0.8',
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.89 Safari/537.36',
                    'Accept-Encoding' => 'gzip, deflate, sdch',
                    'Accept-Language' => 'zh-CN,zh;q=0.8,en;q=0.6,zh-TW;q=0.4'
                );
                $options = array(
                    CURLOPT_HTTPHEADER => $httpheader,
                    CURLOPT_URL => $url,
                    CURLOPT_TIMEOUT => 5,
                    CURLOPT_FOLLOWLOCATION => 1,
                    CURLOPT_RETURNTRANSFER => true
                );
                curl_setopt_array($ch, $options);
                $result = curl_exec($ch);
                curl_close($ch);

                $dirname = mkdir_dirname($path);

                Image::make($result)->save($path);

            }

            return $new_url;


        } else {
            return '';
        }
    }else{
        return '';
    }
}
//微信内容多图片爬取
function content_img($arr_url)
{

    $img_url = explode(',', $arr_url);
    $content_url = array();
    foreach ($img_url as $k => $v) {

        if (!empty($v)) {


            $size = getimagesize($v);

            if (is_array($size)) {

                $suffix = explode('/', $size['mime']);//分解图片后缀
                $pic_name_arr = explode('/', dirname($v));//分解图片地址
                $pic_name = $pic_name_arr[count($pic_name_arr) - 1];//取出图片名

                $path = 'content_img/' . $pic_name . '.' . $suffix[1];

                $new_url = url('') . '/' . $path;
                if (!file_exists($new_url)) {
                    $ch = curl_init();
                    $httpheader = array(
                        'Host' => 'mmbiz.qpic.cn',
                        'Connection' => 'keep-alive',
                        'Pragma' => 'no-cache',
                        'Cache-Control' => 'no-cache',
                        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,/;q=0.8',
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.89 Safari/537.36',
                        'Accept-Encoding' => 'gzip, deflate, sdch',
                        'Accept-Language' => 'zh-CN,zh;q=0.8,en;q=0.6,zh-TW;q=0.4'
                    );
                    $options = array(
                        CURLOPT_HTTPHEADER => $httpheader,
                        CURLOPT_URL => $v,
                        CURLOPT_TIMEOUT => 5,
                        CURLOPT_FOLLOWLOCATION => 1,
                        CURLOPT_RETURNTRANSFER => true
                    );
                    curl_setopt_array($ch, $options);
                    $result = curl_exec($ch);
                    curl_close($ch);

                    $dirname = mkdir_dirname($path);


                    Image::make($result)->save($path);

                }
            } else {
                $new_url = '';
            }
            $content_url[] = $new_url;


        }
    }
    return $content_url;

}

/**
 * 输出方法 rep 默认视图输出
 *
 * @param $action
 * @param $have
 *
 * @return string
 */

function rev($page = null, $data = null, $back = 'view')
{
    switch ($back) {
        case 'view':
            if ($page == null) {
                return '请传入面向视图路由back_type(view,"view.view")';
            } else {
                return view($page, [
                    'data' => $data,
                ]);
            }
        case 'go':
            if ($page == null) {
                return '请传入跳转路由(demo.demo)';
            }
            return Redirect::route($page);
            break;
        case 'error':
            return Redirect::back()->withErrors($data);
            break;
    }

}

/**
 * 输出方法 rej 默认json输出.  前端要什么输出可传back=json或back=callback
 * 动态获取callback
 *
 * @param $action
 * @param $have
 *
 * @return string
 */

function rej($sta = 1, $msg = '请求成功', $data = null, $back = 'json')
{

    if (Input::get('back')) {
        $back = Input::get('back');
    }

    switch ($sta) {
        case '1':
            switch ($back) {
                case 'json':

                    return json_encode([
                        'sta' => 1,
                        'msg' => $msg,
                        'data' => $data
                    ]);
                    break;
                case 'callback':
                    $callback = Input::get('callback');
                    if ($callback) {
                        return $callback . '(' . json_encode([
                            'sta' => 1,
                            'data' => $data,
                            'msg' => $msg
                        ]) . ')';
                    } else {
                        return '请传$callback';
                    }

                    break;
            }
            break;

        case '0':
            switch ($back) {

                case 'json':

                    return json_encode([
                        'sta' => 0,
                        'msg' => $msg,
                        'data' => $data
                    ]);
                    break;
                case 'callback':
                    $callback = Input::get('callback');
                    return $callback . '(' . json_encode([
                        'sta' => 0,
                        'data' => $data,
                        'msg' => $msg
                    ]) . ')';
                    break;
            }
            break;
        default:
            return '传入状态为0和1';
    }

    return '传入正确参数$data。re_js($sta=1,$back=null,$data,$msg=null)';
}

/**
 * 数组循环取值
 *
 * @param $action
 * @param $have
 *
 * @return string
 */
function resize_url($img='',$new_with=''){

    if( isset($new_with) && !empty($new_with)){
        return dirname($img).'/resize_'.$new_with.'_'.basename($img);
    }else{
        return dirname($img).'/resize_'.config('rebate').'_'.basename($img);
    }

}

function get_val($arr_data, $obj = '')
{
    if (is_array($arr_data)) {
        $data = array();
        foreach ($arr_data as $k => $v) {
            $data[] = $v[$obj];
        }
        return $data;
    } else {
        return '请确认$arr_data参数为数组';
    }
}
//获取商品名称
function GetGoodsName($id){
 $goods=Goods::find($id);
 if($goods){
  return $goods['goods_title'];
 }
}
function SortName($id){
    if($id){
        $result=Sort::find($id);
        return $result->name;
    }
}
function BrandName($Bid){
    if($Bid){
        $result=Brand::find($Bid);
        return $result->brand_name;
    }
}








