<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EverythingCreativeController extends Controller
{
    

    public function showPage()
    {
        return view('website.everything-creative.index');
    }
}
