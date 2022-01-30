<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Stats;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;

class RedirectController extends Controller
{
    public function index(Request $request, $id)
    {
        $link = Link::where('short_url', $id)->active()->get()->first();
        $stats = new Stats([
            'url_id' => $link->id,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);
        $stats->save();
        return Redirect::to($link->long_url);
    }
}
