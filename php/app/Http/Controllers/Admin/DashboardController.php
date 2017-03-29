<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Redirect;
use Response;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     

        return view('Admin.dashboard.league-agent');
    }









}
