<?php

namespace App\Http\Controllers\Api;

use App\Models\Link;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

            $validator = $this->validator($item);

            $long_url = $item['long_url'];

            if (!$validator->fails()) {
                $existing_link = Link::where('long_url', $long_url)->active()->get();
                $title = $item['title'] ?? null;
                $tags = isset($item['tags']) ? json_encode($item['tags']) : null;
                $is_active = true;
                $data = compact(['long_url', 'title', 'tags', 'is_active']);

                if(!$existing_link->count()) {
                    try {
                        $link = Link::create($data);
                        $link->save();
                        $response_data[] = ['status' => true, 'data' => $link->toArray(), 'comment' => 'Link created'];
                    } catch (\Throwable $exception) {
                        $response_data[] = ['status' => false, 'error' => $exception->getMessage()];
                    }
                } else {
                    $existing_link = $existing_link->first();
                    $updated = $this->updateLink($request, $existing_link->short_url, $data);
                    $response_data[] = $updated;
                }
            } else {
                $response_data[] = ['status' => false, 'data' => $item, 'error' => $validator->getMessageBag()];
            }

        }

        return $response_data;

    }
    public function updateLink(Request $request, $id, $data = null)
    {
        $link = Link::where('short_url', $id)->get()->first();
        $request_data = $request->json()->all();

        if(!$link)
            return Response::notFound($id);

        if(!$data) {
            $data = [];
            $data['long_url'] = $request_data['long_url'] ?? null;
            $data['title'] = $request_data['title'] ?? null;
            $data['tags'] = $request_data['tags'] ?? null;
        }

        $validator = $this->validator($data);

        if (!$validator->fails()) {
            $link->update($data);

            try {
                $link->save();
                $response_data = ['status' => true, 'data' => $link->toArray(), 'comment' => 'Link updated'];
            } catch (\Throwable $exception) {
                $response_data = ['status' => false, 'error' => $exception->getMessage()];
            }

        } else {
            $response_data = ['status' => false, 'data' => $data, 'error' => $validator->getMessageBag()];
        }

        return $response_data;
    }
    public function deleteLink($id)
    {
        $link = Link::where('short_url', $id)->active()->get()->first();

        if(!$link)
            return Response::notFound($id);

        $link->is_active = false;

        try {
            $link->save();
            $link_url = $link->long_url;
            $response_data = ['status' => true, 'comment' => "Link to '{$link_url}' deleted"];
        } catch (\Throwable $exception) {
            $response_data = ['status' => false, 'error' => $exception->getMessage()];
        }

        return $response_data;
    }
    public function getLinks(Request $request)
    {
        $request_data = $request->json()->all();

        $links = Link::active();

        $title = $request_data['title'] ?? null;
        if ($title)
            $links->where('title', $title);

        $tags = $request_data['tags'] ?? null;
        if ($tags) {
            foreach ($tags as $tag) {
                $links->whereJsonContains('tags', $tag);
            }
        }

        $response_data = $links->get()->toArray();
        if(!count($response_data))
            return Response::notFound();

        return $response_data;
    }

    public function getLink($id)
    {
        $link = Link::where('short_url', $id)->active()->get()->first();

        if(!$link)
            return Response::notFound($id);

        return $link;
    }

    private function validator($item) {
        return Validator::make($item, [
            'long_url' => 'required|url',
            'title' => 'string|nullable',
            'tags' => 'array|nullable',
        ]);
    }
}
