<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{

    public function createLink(Request $request)
    {
        $long_url = $request->get('long_url');
        $title = $request->get('title');
        $tags = $request->get('tags');
        $is_active = true;
        //validation

        $link = new Link(compact(['long_url', 'title', 'tags', 'is_active']));
        $link->save();
    }
    public function updateLink(Request $request, $id)
    {
        $link = Link::where('short_url', $id)->get()->first();
        if(!$link)
            return;

        $long_url = $request->get('long_url');
        if ($long_url)
            $link->long_url = $long_url;

        $title = $request->get('title');
        if ($title)
            $link->title = $title;

        $tags = $request->get('tags');
        if ($tags)
            $link->tags = $tags;

        $link->save();
    }
    public function deleteLink($id)
    {
        $link = Link::where('short_url', $id)->get()->first();
        $link->is_active = false;
        $link->save();
    }
    public function getLinks()
    {
        $links = Link::all();
        return $links;
    }
    public function getLink($id)
    {
        dd(DB::table('links')
            ->whereJsonContains('tags', 'GSM1')
            ->get());
        $link = Link::where('short_url', $id)
            ->whereJsonContains('tags->tags', 'a')
            ->get();
        return $link;
    }
    public function getStats()
    {

    }
    public function getStatsByLink($id)
    {

    }
}
