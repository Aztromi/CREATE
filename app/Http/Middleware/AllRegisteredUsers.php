<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Auth;

class AllRegisteredUsers
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
            if((Auth::user()->status == "active" && Auth::user()->user_role_id == null && Auth::user()->type == "normal" && (Auth::user()->verified == -1 || Auth::user()->verified == 0 || Auth::user()->verified == 1)))
            {
                return $next($request);
            }
            else
            {
                return redirect()->route('login');
            }
        }
        else
        {
            return redirect()->route('login');
        }
    }
}
