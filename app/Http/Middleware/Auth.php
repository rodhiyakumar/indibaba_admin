<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has(Api::AUTH_KEY)) {
            return redirect()->route("login");
        }
        return $next($request);
    }
}
