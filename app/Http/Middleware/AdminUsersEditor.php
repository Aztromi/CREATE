<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Auth;

class AdminUsersEditor
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
            if(Auth::user()->status == "active" && Auth::user()->user_role_id == 1 && in_array(Auth::user()->type, ['super', 'editor']))
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
            // abort(401);
            return redirect()->route('login');
        }
    }
}
