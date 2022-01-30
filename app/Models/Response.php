<?php

namespace App\Models;

class Response
{
    /**
     * @param string|null $id
     * @return \Illuminate\Support\Facades\Response
     */
    public static function notFound(string $id = null)
    {
        if(!$id)
            return response()->json(['status' => 'false', 'error' => "Links with such parameters not found"], 404);
        return response()->json(['status' => 'false', 'error' => "Link '{$id}' not found"], 404);
    }

    /**
     * @return \Illuminate\Support\Facades\Response
     */
    public static function permissionDenied()
    {
        return response()->json(['status' => 'false', 'error' => "Bearer token not valid"], 403);
    }
}
