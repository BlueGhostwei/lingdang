<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Sort;
use Input;
use Redirect;
use Auth;
use Response;
use App\Http\Requests;
use Validator;
use App\Http\Controllers\Controller;

class SortController extends Controller
{
    /**
     * Display a listing of the resource.
     * 商品分类类
     * @return \Illuminate\Http\Response
     */
    /**
     *获取分类,页面渲染
     */
    public function index()
    {
        $sort=$this->get_sort_data();
        return view('Admin.artice.Add_brand', ['sort' => $sort]);
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
     *
     * 添加商品分类
     * 根据分类上传商品
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $sort = new Sort();
        $data['pid'] = Input::get('sort_id');
        $data['name'] = Input::get('name');
        $data['num'] = trim(Input::get('num'));//排序
        $rules = [
            'pid' => 'required',
            'name' => 'required|min:2|max:10|unique:' . $sort->getTable()
        ];
        $msg = [
            'pid.required' => '参数错误，请刷新页面重试',
            'name.required' => "分类名称不能为空",
            'name.min' => "分类名称不能少于两个字符",
            'name.max' => "分类名称最大长度为10个字符",
            'name.unique' => "改分类名称已被占用",
        ];
        if (Controller::unusual($data['name']) == true) {
            return Redirect::back()->withErrors(['name' => '分类名称不能带有特殊字符'])->withInput();
        }
        $validator = Validator::make($data, $rules, $msg);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        if ($data['pid'] != "0") {
            //查询所有父级id，然后拼接字符串，存储路径
            $pid = $this->get_top_parentid($data['pid']);
            $data['id_str'] = $pid;
        } else {
            $data['id_str'] = '';
        }
        $rst = $sort->create($data);//保存成功跳转到分类列表页
        if ($rst) {
            return Redirect()->route('artice.goods');
        }


    }

    /**
     * @param $id
     * @return \___PHPSTORM_HELPERS\static
     *  获取所有父级id
     */
    protected function get_top_parentid($id)
    {
        $r = Sort::where('id', $id)->select('pid', 'id')->get()->first();
        if ($r->pid != '0') return $this->get_top_parentid($r->pid);
        return $r->id;
    }

    /**
     * 添加品牌
     */
    public function storeBrand()
    {
        $brand = New Brand();
        $data['sort_id']=Input::get('sort_id');
        $data['brand_name']=Input::get('brand_name');
        $data['brand_num']=Input::get('brand_num');
        $data['user_id']=Auth::id();
        $msg = [
            'sort_id.required' => "请选择品牌所属分类",
            'brand_name.required' => "品牌名称不能为空",
            'brand_name.min' => "品牌名称至少两个字符",
            'brand_name.unique' => "该品牌名称已被占用",
        ];
        $validator = Validator::make($data, $brand->rules()['create'], $msg);
        $messages = $validator->messages();
        if($validator->fails()){
            $msg = $messages->toArray();
            foreach ($msg as $k => $v) {
                return json_encode(['sta' => 0, 'msg' => $v[0], 'data' => '']);
            }
        }
       $rst= $brand->create($data);
        if($rst){
            return Response::json(['sta'=>'1','msg'=>"请求成功",'data'=>$rst]);
        }else{
            return Response::json(['sta'=>'0','msg'=>"请求失败",'data'=>'']);
        }



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
     *  获取上级分类id与顶级分类id,
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sort = Sort::where(['pid'=>'0','type'=>'0'])->select('id', 'pid', 'name', 'num')->orderBy('id', 'asc')->get()->toArray();
        $edit_sort = Sort::where(['id'=>$id,'type'=>'0'])->select('id', 'pid', 'name', 'num')->first();
        if (!empty($edit_sort) && $edit_sort->pid != 0) {
            $par_id = $this->get_top_parentid($edit_sort->id);
        } else {
            $par_id = "";
        }
        return view('Admin.artice.Add_subtopic', ['sort' => $sort, 'id' => $par_id, 'edit_sort' => $edit_sort]);
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
        $edit_id = $request->edit_id;
        if ($edit_id) {
            $rst = Sort::find($edit_id);
            if ($rst) {
                $data['name'] = trim($request->name);
                $data['num'] = trim($request->num);
                $data['pid'] = trim($request->sort_id);
                if ($data['pid'] != 0) {
                    $pid = $this->get_top_parentid($data['pid']);
                    $data['id_str'] = $pid;
                }
                $up_rst = Sort::where('id', $edit_id)->update($data);
                if ($up_rst) {
                    return Redirect()->route('artice.goods');
                }
            }
        } else {
            return Redirect::back()->withErrors('参数错误，请刷新页面重试');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $id = Input::get('id');
        $rst = Sort::where('id', $id)->delete();
        return Response::json(['msg' => '删除成功', 'sta' => '1', 'data' => ""]);
    }
}
