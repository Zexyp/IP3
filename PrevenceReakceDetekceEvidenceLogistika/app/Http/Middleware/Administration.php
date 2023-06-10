<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Role;

class Administration extends Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */

    public function handle($request, Closure $next, ...$guards) {
        if (!auth()->user()->role == Role::ADMIN) {
            return response('Unauthorized', 401);
        }

        return $next($request);
    }
}
