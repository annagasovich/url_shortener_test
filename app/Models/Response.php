<?php

namespace App\Models;

class Response
{
    public static function notFound($id = null)
    {
        if(!$id)
            return response()->json(['status' => 'false', 'error' => "Links with such parameters not found"], 404);
        return response()->json(['status' => 'false', 'error' => "Link '{$id}' not found"], 404);
    }

    public static function permissionDenied()
    {
        return response()->json(['status' => 'false', 'error' => "Bearer token not valid"], 403);
    }
}
