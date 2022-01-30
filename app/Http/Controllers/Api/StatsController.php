<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class LinksController extends Controller
{
    public function getStats()
    {

    }
    public function getStatsByLink($id)
    {
        $link = Link::where('short_url', $id)->get()->first();

        if(!$link)
            return Response::notFound($id);
    }
}
