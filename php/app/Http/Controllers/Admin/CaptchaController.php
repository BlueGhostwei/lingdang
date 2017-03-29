<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use Input;
use Captcha;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CaptchaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return 12341234;
        return view('Html.home.captcha');
    }

    public function mews(){
        //return 1234124;
        return Captcha::create('default');
    }




    public function cpt(Request $request) {
        // dd(Input::get('cpt'));
        $rules = [
            "cpt" => 'required|captcha'
        ];
        $messages = [
            'cpt.required' => '请输入验证码',
            'cpt.captcha' => '验证码错误，请重试'
        ];
        //如果仅仅验证captcha的值可以
        //采用 Captcha::check(Input::get('cpt')); //返回bool
        $validator = Validator::make(Input::all(), $rules, $messages);
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } else {
            return "验证码OK!";
        }
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
