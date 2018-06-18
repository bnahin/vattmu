<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    /**
     * Show the application front.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::loginUsingId(1, true);

        return view('index');
    }
}
