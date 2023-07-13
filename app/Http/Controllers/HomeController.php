<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //page /vue home.blade.php
    public function home()
    {
        return view('home.home');
    }
    //page /vue about.blade.php
    public function about()
    {
        return view('home.about');
    }
    //page /vue dashboard.blade.php
    public function dashboard()
    {
        return view('home.dashboard');
    }
}
