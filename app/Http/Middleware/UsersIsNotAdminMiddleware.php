<?php

namespace App\Http\Middleware;

use Closure;

class UsersIsNotAdminMiddleware
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
        if (auth()->user()->isAdmin !== 1) {
            return $next($request);
        }
        return redirect('/')->with('error','You just have admin access');
    }
}