<?php

namespace App\Http\Controllers\Api;

use App\Models\Link;
use App\Models\Response;
use App\Models\Stats;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function getStats()
    {
        $stats = Stats::with(['link' => function ($q) {
            $q->active();
        }])
            ->has('link');

        $total_views = $stats->get()->count();

        $unique_views = $stats->select('ip', 'user_agent', 'url_id')->distinct()->get()->count();

        $date = date("Y-d-m");

        return [compact('total_views', 'unique_views', 'date')];
    }

    public function getStatsByLink($id)
    {
        $link = Link::where('short_url', $id)->get()->first();

        if(!$link)
            return Response::notFound($id);


        $stats = Stats::with(['link' => function ($q) {
            $q->active();
        }])
            ->where('url_id', $link->id);

        $total_views = $stats->get()->count();

        $unique_views = $stats->select('ip', 'user_agent', 'url_id')->distinct()->get()->count();

        return [compact('total_views', 'unique_views', 'id')];

    }
}
