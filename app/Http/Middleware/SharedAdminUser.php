<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Auth;

class SharedAdminUser
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
        if(Auth::check())
        {
            // $admin = Auth::user()->user_role_id == 1 && (Auth::user()->type == "super" || Auth::user()->type == "og" || Auth::user()->type == "bdu" || Auth::user()->type == "editor");
            $admin = Auth::user()->user_role_id == 1 && (Auth::user()->type == "super" || Auth::user()->type == "og" || Auth::user()->type == "editor");
            $user = Auth::user()->user_role_id == null && Auth::user()->type == "normal" && (Auth::user()->verified == -1 || Auth::user()->verified == 0 || Auth::user()->verified == 1);

            if(Auth::user()->status == "active" && ($admin || $user))
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



