<?php

namespace App\Http\Controllers\Admin;

use App\Models\AclUser;
use App\Models\Goods;
use App\Models\Sort;
use Faker\Provider\Image;
use Hamcrest\Type\IsNumeric;
use Redirect;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Brand, App\Models\Photo;
use Input;
use Validator;
use Auth;
use App\Models\Actice;
use App\Models\Attributes;

class ArticeControll extends Controller
{


    public function ProductFormat()
    {
        $sort_id = Input::get('sort_id');
        $attribute_id = Input::get('attribute_id');
        $Getformat = Input::get('format');
        $type = Input::get('type');
        if ($type && $type = "update") {
            $result_M=Attributes::where(['sort_id'=>$sort_id,'pid'=>$attribute_id])->get()->toArray();
            if(!empty($result_M)){
                $arr_format=explode(',',$Getformat);
                foreach ($result_M as $key =>$vel){
                   if(!in_array($vel['arr_name'],$arr_format)){
                       Attributes::where('id',$vel['id'])->delete();
                   }
                }
            }
        }
        if (empty($sort_id) || empty($attribute_id)) {
            return Redirect::back()->with('errr_msg',"请求失败");
        }
        if (is_string($Getformat)) {
            $format = explode(',', $Getformat);
        } else {
            $format = preg_split('/\r\n/', $Getformat);
        }
        $store_num = Input::get('store_num');
        if (!empty($format)) {
            foreach ($format as $key => $value) {
                if (!empty($value)) {
                  //查找分类规格
                    $rst=Attributes::where(['sort_id'=>$sort_id,'pid'=>$attribute_id,'arr_name'=>"$value"])->get()->toArray();
                    if(empty($rst)){
                       Attributes::create([
                           'pid' => $attribute_id,
                           'sort_id' => $sort_id,
                           'store_num' => $store_num,
                           'arr_name' => $value
                       ]);
                   }
                }
            }
        } else {
            Attributes::create([
                'pid' => $attribute_id,
                'sort_id' => $sort_id,
                'store_num' => $store_num,
                'arr_name' => "",
            ]);
        }
        return Redirect::route('artice.M_properties')->with('保存成功');
    }


    public function SaveAttributes(Request $request)
    {
      //dd(Input::all());
        $arributes = new Attributes();
        $validate = Validator::make($request->all(), $arributes->rules()['create']);
        $messages = $validate->messages();
        if ($validate->fails()) {
            $msg = $messages->toArray();
            foreach ($msg as $k => $v) {
                return Redirect::back()->with("添加失败");
            }
        }
        $arributes->create($request->only($arributes->getFillable()));
        return Redirect::route('artice.M_properties')->with('添加成功');

    }

    /**
     * 文章处理开始
     */
    /**
     * Display a listing of the resource.
     * 文章分类列表
     * @return \Illuminate\Http\Response
     */
    public function A_fenlei()
    {
        $artice_sort = Sort::where('type', 1)->select('name', 'id')->orderBy('num', 'asc')->paginate(10);
        return view('Admin.artice.A_fenlei', ['artice_sort' => $artice_sort]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Add_fenlei()
    {

        return view('Admin.artice.Add_fenlei');
    }

    /**
     * @return $this|\Illuminate\Http\RedirectResponse
     *  添加文章分类
     */
    public function save_fenlei()
    {
        $sort = new Sort();
        $data['name'] = trim(Input::get('sort_name'));
        $data['num'] = trim(Input::get('sort_num'));
        $data['type'] = "1";//绑定分类
        if ($data['name'] != '') {
            if ($this->unusual($data['name']) == true) {
                return Redirect::back()->withErrors(['sort_name' => "分类名称不能带有特殊字符！"]);
            }
        } else {
            return Redirect::back()->withErrors(['sort_name' => "分类名称不能为空"]);
        }
        $rst = $sort->where('name', $data['name'])->select('id')->get()->toArray();
        if ($rst) {
            return Redirect::back()->withErrors(['sort_name' => "该分类名称已被占用"])->withInput();
        }

        $data['pid'] = "0";
        $data['id_str'] = '';
        $data['simg'] = trim(Input::get('file1'));
        $rst = $sort->create($data);
        if ($rst) {
            return Redirect()->route('artice.A_fenlei');
        }
    }

    /**
     * @param $id
     * @return $this
     * 查看文章分类详情
     */
    public function support_show($id)
    {
        $Rst_Data = Sort::find($id);
        if ($Rst_Data) {
            return view('Admin.artice.Add_fenlei', ['Rst_Data' => $Rst_Data]);
        } else {
            return Redirect::back()->withErrors('请求失败，参数错误');
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * 修改文章分类
     */
    public function support_update()
    {
        $id = Input::get('id');
        $result = Sort::find($id);
        if ($result) {
            $result['name'] = Input::get('sort_name');
            $result['num'] = Input::get('sort_num');
            $rst = $result->save();
            return Redirect()->route('artice.A_fenlei')->with('msg', '请求成功');
        } else {
            return Redirect()->route('artice.A_fenlei')->with('msg', '请求失败，参数错误');
        }

    }

    /**
     * Display a listing of the resource.
     *  添加文章页面
     *  获取文章分类
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actice_sort = Sort::where('type', 1)->orderBy('num', 'asc')->get();
        return view('Admin.artice.index', ['actice_sort' => $actice_sort]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     *  'user_id', 操作者id
     * 'sort_id',文章分类id
     * 'writer',作者
     * 'title',标题
     * 'content'内容，因为这里的内容存在表情，所以要以base处理存储
     */
    public function store_actice(Request $request)
    {
        $actice = New Actice();
        $msg = [
            'sort_id.required' => '请选择文章栏目分类',
            'writer.required' => '请输入文章作者',
            'writer.min' => '作者名称至少2个字符',
            'title.required' => '请输入文章标题',
            'title.unique' => '该文章标题已被占用',
            'content.required' => '文章内容不能为空',
            'content.min' => '文章内容至少20个字符',
            'aimg' => '缩略图必填'
        ];
        $validator = Validator::make($request->all(), $actice->rules()['create'], $msg);
        if ($validator->failed()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $rst = $actice->create($request->only($actice->getFillable()));
        if ($rst) {
            return \Response::json(['msg' => '添加成功', 'sta' => '1', 'data' => '']);
        } else {
            return \Response::json(['msg' => '网络错误，添加失败', 'sta' => '0', 'data' => '']);
        }

    }

    /**
     * Display a listing of the resource.
     * 文章列表
     * @return \Illuminate\Http\Response
     */
    public function artice_list()
    {
        $keyword = trim(Input::get('keyword'));
        if ($keyword) {
            $actice_data = Actice::where('id', $keyword)->orWhere('title', 'like', "%$keyword%")->orderBy('id', 'asc')->paginate(10);
        } else {
            $actice_data = Actice::orderBy('id', 'asc')->paginate(10);
        }
        return view('Admin.artice.action_list', ['actice_data' => $actice_data, 'keyword' => $keyword]);
    }

    /**
     * @param $id
     * @return $this
     * 文章展示
     */
    public function artice_list_show($id)
    {
        $actice = Actice::find($id);
        $actice_sort = Sort::where('type', 1)->orderBy('num', 'asc')->get();
        if ($actice) {
            return view('Admin.artice.index', ['actice_sort' => $actice_sort, 'actice' => $actice]);
        } else {
            return Redirect::back()->withErrors('请求失败，请刷新页面重试');
        }
    }


    public function artice_home()
    {
        //广告栏 sort_id=22
        $class_sort = Actice::where('sort_id', 22)->orderBy('id', 'asc')->get()->toArray();
//        if(!$class_sort)
//        {
//            return json_encode(['msg' => '请求失败', 'data' => '', 'sta' => '0']);
//        }
        for ($i = 0; $i < count($class_sort); $i++) {
            $class_sort[$i]["content"] = htmlspecialchars(str_replace(array("\r\n", "\r", "\n"), "", $class_sort[$i]["content"]));

        }

        //穿搭课堂 sort_id=23
        $classroom = Actice::where('sort_id', 23)->orderBy('id', 'asc')->get()->toArray();
//        if(!$classroom)
//        {
//            return json_encode(['msg' => '请求失败', 'data' => '', 'sta' => '0']);
//        }
        for ($j = 0; $j < count($classroom); $j++) {
            $classroom[$j]["content"] = htmlspecialchars(str_replace(array("\r\n", "\r", "\n"), "", $class_sort[$j]["content"]));

        }
        //精选专题 sort_id=24
        $selected = goods::where('sort_id', 24)->orderBy('id', 'asc')->get()->toArray();
//        if(!$selected)
//        {
//            return json_encode(['msg' => '请求失败', 'data' => '', 'sta' => '0']);
//        }
        for ($h = 0; $h < count($selected); $h++) {
            $selected[$h]["content"] = htmlspecialchars(str_replace(array("\r\n", "\r", "\n"), "", $selected[$h]["content"]));
            $selected[$h]["aimg"] = md52url($class_sort[$h]["aimg"]);
            $plan = $selected[$h]["plan"];
            $plans = explode(',', $plan);
            $plangs = array();
            for ($z = 0; $z < count($plans); $z++) {
                $plangs[] = md52url($plans[$z]);
            }
            $selected[$h]["plan"] = $plangs;
        }
        $home = array();
        $home['class_sort'] = $class_sort;
        $home['classroom'] = $classroom;
        $home['selected'] = $selected;
        if ($home) {
            return json_encode(['msg' => '请求成功', 'data' => $home, 'sta' => '1']);
        } else {
            return json_encode(['msg' => '请求失败', 'data' => '', 'sta' => '0']);
        }


    }

    /*
 * 广告或者活动详细信息
     * 广告活动详细接口：域名+/artice/artice_detailed
     * 请求方式：get
     *传入aid(传入的内容id)
     * ：返回:所属用户（user_id）所属分类（sort_id）缩略图（aimg），作者（writer），标题(title),内容(content)
     *返回参数格式json如下
     *{"msg":"请求成功","sta":"1","data":""}
*/
    public function artice_detailed()
    {
        $aid = trim(Input::get('aid'));
        $class_sort = Actice::where("id", "=", "$aid")->orderBy('id', 'asc')->first();
        if (!$class_sort) {
            return json_encode(['msg' => '请求失败', 'data' => '', 'sta' => '0']);
        }
        $class_sort["content"] = htmlspecialchars(str_replace(array("\r\n", "\r", "\n"), "", $class_sort["content"]));
        $class_sort["aimg"] = md52url($class_sort["aimg"]);

        if ($class_sort) {
            return json_encode(['msg' => '请求成功', 'data' => $class_sort, 'sta' => '1']);
        } else {
            return json_encode(['msg' => '请求失败', 'data' => '', 'sta' => '0']);
        }
    }


    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     * 更新文章
     */
    public function artice_list_update(Request $request)
    {
        $actice = Actice::find($request->actice_id);
        $msg = [
            'sort_id.required' => '请选择文章栏目分类',
            'writer.required' => '请输入文章作者',
            'writer.min' => '作者名称至少2个字符',
            'title.required' => '请输入文章标题',
            'content.required' => '文章内容不能为空',
            'content.min' => '文章内容至少20个字符'
        ];
        $validator = Validator::make($request->all(), $actice->rules()['update'], $msg);
        if ($validator->failed()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $rst = $actice->update($request->only($actice->getFillable()));
        if ($rst) {
            return \Response::json(['msg' => '修改成功', 'sta' => '1', 'data' => '']);
        } else {
            return \Response::json(['msg' => '网络错误，修改失败', 'sta' => '0', 'data' => '']);
        }

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * 文章删除
     */
    public function artice_list_destroy()
    {
        $id = Input::get('actice_id');
        $actice = Actice::find($id);
        if ($actice) {
            Actice::where('id', $id)->delete();
            return \Response::json(['sta' => '1', 'msg' => '删除成功']);
        } else {
            return \Response::json(['sta' => '0', 'msg' => '请求失败，参数错误']);
        }

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Add_slide()
    {
        return view('Admin.artice.Add_slide');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 保存banner图片
     */
    public function save_slide()
    {
        $photo = new Photo();
        $data['file_name'] = Input::get('file_name');
        $data['img_Md5'] = Input::get('img_Md5');
        $data['line'] = Input::get('line');
        $data['number'] = Input::get('number');
        if (empty($data['img_Md5'])) {
            return \Response::json(['msg' => '请选择要上传的图片', 'sta' => '0', 'data' => '']);
        }
        if (!empty($data['line']) && $this->check_url($data['line']) == false) {
            return \Response::json(['msg' => '请输入合法的地址链接', 'sta' => '0', 'data' => '']);
        }
        if (!empty($data['number']) && !is_numeric(intval($data['number']))) {
            return \Response::json(['msg' => '编号只能为整数', 'sta' => '0', 'data' => '']);
        }
        $rst = $photo->create($data);
        if ($rst) {
            return \Response::json(['sta' => '1', 'msg' => '保存成功', 'data' => $rst]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function slide()
    {
        $photo = Photo::orderBy('number', 'asc')->get()->toArray();
        return view('Admin.artice.slide', ['photo' => $photo]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function member()
    {

        return view('Admin.artice.member');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function brand_list()
    {
        $BrandData = Brand::select('*')->orderBy('id', 'desc')->paginate(10);
        return view('Admin.artice.brand_list', ['BrandData' => $BrandData]);
    }


    /**
     * @param $id
     * @return mixed
     *品牌修改显示
     */

    public function brand_edit($id)
    {
        $sort = $this->get_sort_data();
        $Get_Brand = Brand::where('id', $id)->get()->toArray();
        if (!empty($Get_Brand)) {
            foreach ($Get_Brand as $ky => $vy) {
                $sort_id = explode(',', $vy['sort_id']);
                foreach ($sort_id as $k => $v) {
                    $result = Sort::where('id', $v)->select('id', 'name')->get()->toArray();
                    if (!empty($result)) {
                        $Get_Brand['sort_data'][$k] = $result[0];
                    } else {
                        $Get_Brand['sort_data'][$k] = '';
                    }
                }
            }
        }
        return view('Admin.artice.Add_brand', ['sort' => $sort, 'Get_Brand' => $Get_Brand]);

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 品牌修改
     */
    public function brand_update()
    {
        $id = Input::get('up_id');
        $data['sort_id'] = Input::get('sort_id');
        $data['brand_name'] = Input::get('brand_name');
        $data['brand_num'] = Input::get('brand_num');
        $data['user_id'] = Auth::id();
        if (!is_numeric($data['brand_num'])) {
            return \Response::json(['sta' => '0', 'msg' => '序号必须为数字', 'data' => '']);
        }
        if (empty($data['brand_name'])) {
            return \Response::json(['sta' => '0', 'msg' => '品牌名不能为空', 'data' => '']);
        }
        if (empty($data['sort_id'])) {
            return \Response::json(['sta' => '0', 'msg' => '请选择品牌所属分类', 'data' => '']);
        }
        $result = Brand::where('id', $id)->update($data);
        if ($result) {
            return \Response::json(['sta' => '1', 'msg' => '更新品牌成功', 'data' => '']);
        } else {
            return \Response::json(['sta' => '0', 'msg' => '更新品牌信息失败', 'data' => '']);
        }

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     *删除品牌信息
     */
    public function Brand_Dele()
    {
        $id = Input::get('id');
        $rst = Brand::where('id', $id)->delete();
        if ($rst) {
            return \Response::json(['sta' => '1', 'msg' => '删除成功', 'data' => '']);
        } else {
            return \Response::json(['sta' => '0', 'msg' => '删除失败', 'data' => '']);
        }

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Add_brand()
    {
        return view('Admin.artice.Add_brand');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function consumption()
    {
        return view('Admin.artice.consumption');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function chongzhi()
    {
        return view('Admin.artice.chongzhi');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function goods()
    {
        $sort = Sort::where(['type' => '0', 'pid' => "0"])->select('id', 'pid', 'name')->orderBy('id', 'asc')->orderBy('num', 'asc')->paginate(10);
        if (count($sort) >= 1) {
            foreach ($sort as $ky => $vy) {
                $rst = $this->get_category($vy->id);
                if (strlen($rst) >= 4) {
                    $sort[$ky]->child = $rst;
                }
            }
        }
        return view('Admin.artice.goods', ['sort' => $sort]);
    }


    /**
     * @param $category_id
     * @return string
     * 获取所有的子集
     */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function goods_list()
    {

        return view('Admin.artice.goods_list');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function order()
    {

        return view('Admin.artice.order');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function order_XQ()
    {

        return view('Admin.artice.order_XQ');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Add_subtopic($id)
    {
        $sort = Sort::where(['type' => '0', 'pid' => "0"])->select('id', 'pid', 'name')->orderBy('id', 'asc')->get()->toArray();
        //查询二级分类
        if (!empty($sort)) {
            foreach ($sort as $key => &$vel) {
                $sort[$key]['child'] = Sort::where('pid', $vel['id'])->select('id', 'name', 'img_path', 'content')->get()->toArray();
            }
        }
        return view('Admin.artice.Add_subtopic', ['sort' => $sort, 'id' => $id]);
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
     * 轮播图展示
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rst = Photo::find($id);
        if ($rst) {
            return view('Admin.artice.Add_slide', ['rst' => $rst]);
        } else {
            return Redirect::back()->withErrors('请求失败，参数错误');
        }
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
     * 轮播图更新
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $rst = Photo::find(Input::get('photo_id'));
        if ($rst) {
            $data['file_name'] = Input::get('file_name');
            $data['line'] = Input::get('line');
            $data['img_Md5'] = Input::get('img_Md5');
            $data['number'] = Input::get('number');
            $result = Photo::where('id', Input::get('photo_id'))->update($data);
            if ($result) {
                return \Response::json(['msg' => '更新成功', 'sta' => '1', 'data' => '']);
            } else {
                return \Response::json(['msg' => '请求失败，参数错误', 'sta' => '0', 'data' => '']);
            }
        } else {
            return \Response::json(['msg' => '请求失败，参数错误', 'sta' => '0', 'data' => '']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $id = Input::get('id');
        $rst = Photo::find($id);
        if ($rst) {
            Photo::where('id', $id)->delete();
            return \Response::json(['msg' => '删除成功', 'sta' => '1', 'data' => '']);
        } else {
            return \Response::json(['msg' => '删除失败，参数错误', 'sta' => '0', 'data' => '']);
        }
    }
}
