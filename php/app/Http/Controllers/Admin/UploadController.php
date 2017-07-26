<?php

namespace App\Http\Controllers\Admin;
use Input, Response, Config,Image,File;
use App\Http\Controllers\Controller;
use App\Models\Image_pic;

/**
 * 文件上传类, 支持普通上传, base64编码上传, 远程下载
 * 普通上传: post 发送到 /upload
 * base64上传: post 发送到 /upload/encode
 * 远程下载: post 发送 url 到 /upload/remote
 *
 * @package App\Http\Controllers
 *
 * @author  fengqi <lyf362345@gmail.com>
 * @copyright Copyright (c) 2015 udpower.cn all rights reserved.
 */
class UploadController extends Controller
{
    /**
     * 允许的文件类型字典
     *
     * @var array
     */

    public $fileType = [
        '001' => 'jpg',
        '002' => 'png',
        '003' => 'gif',
        '004' => 'bmp',
        '005' => 'psd',
        '006' => 'zip',
        '007' => 'rar',
        '008' => '7z',
        '009' => 'tar',
        '010' => 'txt',
        '011' => 'pdf',
        '012' => 'csv',
        '013' => 'doc',
        '014' => 'docx',
        '015' => 'ppt',
        '016' => 'pptx',
        '017' => 'xls',
        '018' => 'xlsx',
    ];

    /**
     * 允许的最大文件大小, 单位字节, 20 MB
     *
     * @var int
     */
    public $allowMaxSize = 1024 * 1024 * 20;

    /**
     * 图片的缩略图设置
     *
     * @var array
     */
    public $thumb = [
        // avatar
        '50x50', '100x100',
    ];

    /**
     * 普通文件上传
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // 有效文件
        $key = Input::get('fileKey', 'file');
        $Editfile=Input::file('wangEditorH5File');
        if($Editfile==null){
            $file = Input::file($key);
        }else{
            $file=$Editfile;
        }
        //if (!$file || !$file->isValid()) return Response::json(array('sta' => 0, 'msg' => '无效的文件'));
		if (!$file || !$file->isValid()) return json_encode(array('sta' => 0, 'msg' => '无效的文件'));

        // 文件类型
        $mimeType = explode('/', $file->getClientMimeType());
        if (!$mimeType || count($mimeType) != 2) {
        //return Response::json(array('sta' => 0, 'msg' => '不允许的文件类型'));
			return json_encode(array('sta' => 0, 'msg' => '不允许的文件类型'));
        }

        // 使用文件的 mime 识别后缀
        $fileType = '';
        switch ($mimeType[0]) {
            case 'image':
                $fileType = $mimeType[1] == 'jpeg' ? 'jpg' : $mimeType[1];
                break;

            case 'text':
                $origin = $file->getClientOriginalName();
                $_tmp = strrpos($origin, '.');
                $fileType = is_int($_tmp) ? substr($origin, $_tmp + 1) : 'txt';
                break;

            case 'application':
                switch ($mimeType[1]) {
                    case 'zip':
                        // no break
                    case 'pdf':
                        // no break
                        $fileType = $mimeType[1];
                        break;

                    case 'x-tar':
                        $fileType = 'tar';
                        break;

                    case 'x-gzip':
                        $fileType = 'tgz';
                        break;

                    case 'x-xz':
                        $fileType = 'xz';
                        break;

                    case 'x-rar':
                        $fileType = 'rar';
                        break;

                    case 'x-7z-compressed':
                        $fileType = '7z';
                        break;

                    case 'msword':
                        $fileType = 'doc';
                        break;

                    case 'vnd.ms-powerpoint':
                        $fileType = 'ppt';
                        break;

                    case 'vnd.ms-excel':
                        $fileType = 'xls';
                        break;

                    case 'vnd.openxmlformats-officedocument.wordprocessingml.document':
                        $fileType = 'docx';
                        break;

                    case 'vnd.openxmlformats-officedocument.presentationml.presentation':
                        $fileType = 'pptx';
                        break;

                    case 'vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                        $fileType = 'xlsx';
                        break;
                }
                break;

            default:
                $fileType = $mimeType[1];
                break;
        }
        $fileTypeKey = array_search($fileType, $this->fileType);
        if (!$fileType || !$fileTypeKey) {
//			return Response::json(array('sta' => 0, 'msg' => '不允许的文件类型'));
            return json_encode(array('sta' => 0, 'msg' => '不允许的文件类型'));
        }

        // 大小判断
        if ($file->getSize() > $this->allowMaxSize) {
//			return Response::json(array('sta' => 0, 'msg' => '文件大小不能超过: '.sizeFormat($this->allowMaxSize)));
			return json_encode(array('sta' => 0, 'msg' => '文件大小不能超过: '.sizeFormat($this->allowMaxSize)));
        }


        // 是否已经上传过

        $md5 = md5_file($file->getRealPath());

        //dd($file->getRealPath(),$md5,$file->getSize());
        $md5 = $md5.$fileTypeKey;

        $path = $this->md52url($md5, true);

        //dd(Input::all(),$fileTypeKey,$file->getRealPath(),$md5,$path);

        if (!is_file($path)) {
            $file->move(dirname($path), basename($path));
        }

        //压缩图片
        $resize = Input::get('resize');


        if($resize){
            $resize_img = resize_img($md5,$resize,true);
            File::put(config_path('rebate.php'), sprintf("<?php%s%sreturn %s;%s", PHP_EOL, PHP_EOL, var_export($resize, true), PHP_EOL));
			return json_encode([
                'sta' => 1,
                'msg' => '上传成功',
                'md5' => $md5,
                'url' => $this->md52url($md5),
                'resize_img' => $resize_img
            ]);
        }
       if($Editfile != null){
           return $this->md52url($md5);
       }else{
			return json_encode([
               'sta' => 1,
               'msg' => '上传成功',
               'md5' => $md5,
               'url' => $this->md52url($md5),
           ]);
       }

    }


    public function Cut_out(){
        $pic_url=Input::get('url');
        $set_re = strpos($pic_url, 'resize_480_lcover'); //判断图片是否裁剪过。
        if ($set_re != false) { //二次裁剪容错代码
            $pic_url= str_replace('resize_480_lcover', '',$pic_url);
        }
        $base64_str = Input::get('base64');
        $image = base64_decode($base64_str);
        $match= substr($pic_url,strlen(dirname($pic_url))+1);//获取图片名称
        $png_url = "lcover".strtok($match,'.').".jpg";
        $path = 'live_cover/' . $png_url;
        $bath='live_cover/'.'resize_480_'.$png_url;//判断图片是否存在
        if(is_file($bath) == true){
            unlink($bath);
        }
        if(!is_dir(dirname($path))){
            mkdir(iconv("UTF-8", "GBK", dirname($path)),0777,true);
        }
        file_put_contents($path, $image);
       // $img_txt = Image::make($path);
        return json_encode([
            'md5' => basename($path),
            'sta' => 1,
            'msg' =>'上传成功',
            'url' => env('assets').'/'.$path
        ]);

    }



    /**
     * base64 编码方式图片上传, 若是使用js发送POST数据, 需要用encodeURIComponent()方法转换下数据
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function encode()
    {
        // todo
       //$img_pic=new Image_pic();
       //$base64_str = $img_pic->base_img();
        $base64_str = Input::get('base64');
        $image = base64_decode($base64_str);
        $png_url = "lcover".time().".jpg";
        $path = 'live_cover/' . $png_url;
        if(!is_dir(dirname($path))){
            mkdir(iconv("UTF-8", "GBK", dirname($path)),0777,true);
        }
        file_put_contents($path, $image);
       // $img_txt = Image::make($path);
        //压缩图片
        $resize = Input::get('resize');
        if($resize){
            $resize_img = resize_img(env('assets').'/'.$path,$resize,false);
            return json_encode([
                'img_path' => $path,
                'sta' => 1,
                'msg' =>'上传成功',
                'url' => env('assets').'/'.$path,
                'resize_img' => $resize_img
            ]);
        }
        return json_encode([
            'img_path' => $path,
            'sta' => 1,
            'msg' =>'上传成功',
            'url' => env('assets').'/'.$path
        ]);



    }

    public  function base64imgsave(){

        $setimg=New Image_pic();
        $img=$setimg->base_img();

        //文件夹日期
        $ymd = date("Ymd");

        //图片路径地址
        $basedir = 'upload/base64/'.$ymd.'';
        $fullpath = $basedir;
        if(!is_dir($fullpath)){
            mkdir($fullpath,0777,true);
        }
        $types = empty($types)? array('jpg', 'gif', 'png', 'jpeg'):$types;
        $img = str_replace(array('_','-'), array('/','+'), $img);
        $b64img = substr($img, 0,100);
        if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $b64img, $matches)){
            $type = $matches[2];
            if(!in_array($type, $types)){
                return json_encode(['sta'=>1,'msg'=>'图片格式不正确，只支持 jpg、gif、png、jpeg哦！','data'=>'']);
            }
            $img = str_replace($matches[1], '', $img);
            $img = base64_decode($img);
            $photo = '/'.md5(date('YmdHis').rand(1000, 9999)).'.'.$type;
            file_put_contents($fullpath.$photo, $img);
            $ary['sta'] = 1;
            $ary['msg'] = '保存图片成功';
            $ary['url'] = $basedir.$photo;

            return $ary;

        }

        $ary['sta'] = 0;
        $ary['msg'] = '请选择要上传的图片';

        return $ary;


    }



    /**
     * 下载远程文件到本地, 返回 md5 信息
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function remote()
    {
        // todo
        return Response::json([]);
    }

    /**
     * 把 35 位长度的 md5 转为为真实链接/地址
     * c4ca4238a0b923820dcc509a6f75849b003
     * c4ca4238a0b923820dcc509a6f75849b 003
     * /c4/ca/42/38a0b923820dcc509a6f75849b.gif
     *
     * @param $md5
     * @param bool|false $location
     * @param string $config
     *
     * @return string
     */
    public function md52url($md5, $location = false, $config = null)
    {
        if (empty($md5) || strlen($md5) != 35) return '';

        // 文件子目录
        $sub1 = substr($md5, 0, 2);
        $sub2 = substr($md5, 2, 2);
        $sub3 = substr($md5, 4, 2);
        $type = substr($md5, -3, 3);
        $filePath = sprintf("/%s/%s/%s/%s.%s", $sub1, $sub2, $sub3, $md5, $this->fileType[$type]);

        // 本地 或 http 域名
        $baseDir = base_path('public');
        $assets = Config::get('financial.assets');
        $domain = $assets[array_rand($assets)];

        // 转换为有参数的链接
        if ($config) {
            $filePath .= sprintf("@%s.%s", $config, $this->fileType[substr($md5, -3)]);
        }

        return ($location ? $baseDir : $domain) . '/files' .$filePath;
    }

    /**
     * 获取上传配置和限制
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function config()
    {
        return Response::json(['fileType' => $this->fileType, 'allowMaxSize' => $this->allowMaxSize]);
    }
}
