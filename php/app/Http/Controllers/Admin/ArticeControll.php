<?php

namespace App\Http\Controllers\Admin;

use App\Models\AclUser;
use App\Models\Sort;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;
use Input;
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

        return view('Admin.artice.brand_list');
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
        $sort = Sort::where('pid', '0')->select('id', 'pid', 'name')->orderBy('id', 'asc')->orderBy('num','asc')->get()->toArray();
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
                                $sort[$ky]['child'][$k-1] = $result[0];
                            }
                        }
                    }
                } else {
                    $sort[$ky]['child'] = "";
                }
            }
        }
       // dd($sort);
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
