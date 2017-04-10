<?php

namespace App\Http\Controllers\Admin;

use App\Models\AclUser;
use App\Models\Sort;
use ClassesWithParents\G;
use Hamcrest\Type\IsNumeric;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;
use App\Models\Brand;
use Input;
use Validator;
use Auth;
use DB;

class ArticeControll extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('Admin.artice.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function artice_list()
    {

        return view('Admin.artice.action_list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function A_fenlei()
    {

        return view('Admin.artice.A_fenlei');
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Add_slide()
    {

        return view('Admin.artice.Add_slide');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function slide()
    {

        return view('Admin.artice.slide');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function member_list()
    {

        return view('Admin.artice.member_list');
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
        $sort = Sort::where('pid', '0')->select('id', 'pid', 'name')->orderBy('id', 'asc')->orderBy('num', 'asc')->get()->toArray();
        if (!empty($sort)) {
            foreach ($sort as $ky => $vy) {
                $rst = $this->get_category($vy['id']);
                if (strlen($rst) >= 4) {
                    $child = substr($rst, 0, strlen($rst) - 1);
                    $child = explode(',', $child);
                    foreach ($child as $k => $v) {
                        if ($v != $vy['id']) {
                            $result = Sort::where('id', $v)->select('id', 'pid', 'name')->get()->toArray();
                            if (!empty($result)) {
                                $sort[$ky]['child'][$k - 1] = $result[0];
                            }
                        }
                    }
                } else {
                    $sort[$ky]['child'] = "";
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
    public function Add_goods()
    {

        return view('Admin.artice.Add_goods');
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
        $sort = Sort::where('pid', '0')->select('id', 'pid', 'name')->orderBy('id', 'asc')->get()->toArray();
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
