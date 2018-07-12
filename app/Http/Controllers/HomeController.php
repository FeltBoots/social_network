<?php

namespace Tugger\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Tugger\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
//        if (!$user) {
//            return view('auth.login');
//        }
        return view('pages/profile', compact('user'));
    }
}
