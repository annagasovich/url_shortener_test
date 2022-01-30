<?php

namespace App\Http\Controllers\Api;

use App\Models\Link;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class LinksController extends Controller
{

    public function createLink(Request $request)
    {
        $request_data = $request->json()->all();
        $response_data = [];

        //is request of single creation
        if(isset($request_data['long_url']))
            $request_data[] = $request_data;

        foreach ($request_data as $item) {

            $long_url = $item['long_url'];
            $existing_link = Link::where('long_url', $long_url)->active()->get();
            $title = $item['title'] ?? null;
            $tags = isset($item['tags']) ? json_encode($item['tags']) : null;
            $is_active = true;
            $data = compact(['long_url', 'title', 'tags', 'is_active']);

            if(!$existing_link->count()) {
                //validation

                try {
                    $link = Link::create($data);
                    $link->save();
                    $response_data[] = ['status' => true, 'data' => $link->toArray()];
                } catch (\Throwable $exception) {
                    $response_data[] = ['status' => false, 'error' => $exception->getMessage(), 'comment' => 'Link created'];
                }
            } else {
                $existing_link = $existing_link->first();
                $updated = $this->updateLink($request, $existing_link->short_url, $data);
                $response_data[] = $updated;
            }

        }
        return $response_data;

    }
    public function updateLink(Request $request, $id, $data = null)
    {
        $link = Link::where('short_url', $id)->get()->first();

        if(!$link)
            return Response::notFound($id);

        if(!$data) {
            $long_url = $request->get('long_url');
            if ($long_url)
                $link->long_url = $long_url;

            $title = $request->get('title');
            if ($title)
                $link->title = $title;

            $tags = $request->get('tags');
            if ($tags)
                $link->tags = $tags;
        } else {
            $link->update($data);
        }

        try {
            $link->save();
            $response_data = ['status' => true, 'data' => $link->toArray(), 'comment' => 'Link updated'];
        } catch (\Throwable $exception) {
            $response_data = ['status' => false, 'error' => $exception->getMessage()];
        }

        return $response_data;

    }
    public function deleteLink($id)
    {
        $link = Link::where('short_url', $id)->get()->first();

        if(!$link)
            return Response::notFound($id);

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
        $link = Link::where('short_url', $id)->get()->first();

        if(!$link)
            return Response::notFound($id);

        dd(DB::table('links')
            ->whereJsonContains('tags', 'GSM1')
            ->get());
        $link = Link::where('short_url', $id)
            ->whereJsonContains('tags->tags', 'a')
            ->get();
        return $link;
    }
}
