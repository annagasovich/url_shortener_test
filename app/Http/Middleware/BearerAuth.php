<?php

namespace App\Http\Middleware;

use App\Models\Response;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class BearerAuth
{
    /**
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        $user = User::where('api_token', $token)->first();
        if ($user) {
            auth()->login($user);
            return $next($request);
        }
        return Response::permissionDenied();
    }
}
