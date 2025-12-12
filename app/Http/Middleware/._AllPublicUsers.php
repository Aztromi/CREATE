<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Auth;

class AllPublicUsers
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
        //ALL PUBLIC USERS. GUEST
        // FOR REMOVAL
        return $next($request); // remove upon implementation
        // if(Auth::check())
        // {
        //     if((Auth::user()->user_role_id == null && Auth::user()->type == "normal"))
        //     {
        //         return $next($request);
        //     }
        //     else
        //     {
        //         abort(401);
        //     }
        // }
        // else
        // {
        //     return redirect()->route('login');
        // }
    }
}
