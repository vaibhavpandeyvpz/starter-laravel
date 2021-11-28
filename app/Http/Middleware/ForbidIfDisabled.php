<?php

namespace App\Http\Middleware;

use Closure;

class ForbidIfDisabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        abort_if($user && !$user->enabled, 403);

        return $next($request);
    }
}
