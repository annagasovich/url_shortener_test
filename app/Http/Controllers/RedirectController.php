<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RedirectController extends Controller
{
    public function index($url)
    {
        return $url;
    }
}
