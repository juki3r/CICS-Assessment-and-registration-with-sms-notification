<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyController extends Controller
{


    // BSCS
    public function bscs()
    {
        return view('bscs');
    }

    // BLIS
    public function blis()
    {
        return view('blis');
    }

    // SMS LOGS
    public function smslogs()
    {
        return view('smslogs');
    }
}
