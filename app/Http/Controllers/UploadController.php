<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function index () 
    {
        $hello = 'Hello,World!';
        $hello_array = ['Hello', 'こんにちは', 'ニーハオ'];

        $d = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime($d . '+1 day'));
        $nextweek = date('Y-m-d', strtotime($d . '+1 week'));

        return view('upload', compact('tomorrow', 'nextweek'));
    }

}
