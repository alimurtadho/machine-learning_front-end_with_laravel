<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
        return auth()->guest() ? view('index') : view('index');
    }
}
