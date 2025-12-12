<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Auth;

class AllAdminUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // return $next($request); //remove once finalized
        if(Auth::check())
        {
            if(Auth::user()->status == "active" && Auth::user()->user_role_id == 1 && (Auth::user()->type == "super" || Auth::user()->type == "og" || Auth::user()->type == "bdu" || Auth::user()->type == "editor"))
            {
                return $next($request);
            }
            else
            {
                abort(401);
            }
        }
        else
        {
            return redirect()->route('login');
        }
    }
}
