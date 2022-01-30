<?php

namespace App\Models;

class Response
{
    public static function notFound($id)
    {
        return response()->json(['status' => 'false', 'error' => "Link '{$id}' not found"], 404);
    }

    public static function validationError($id, $error)
    {
        return response()->json(['status' => 'false', 'error' => "Request params validation error: link '{$id}' {$error}"], 400);
    }
}
