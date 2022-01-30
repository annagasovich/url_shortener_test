<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class IndexController extends Controller
{
    /**
     * @return string
     */
    public function index()
    {
        return view('index');
    }
}
