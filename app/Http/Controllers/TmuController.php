<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TmuController extends Controller
{
    public function index()
    {
        $default = config('services.checkwx.default_airport');

        return view('tmu');
    }
}
