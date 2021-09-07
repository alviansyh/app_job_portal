<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidationAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ( ! Auth::check()){
            return redirect()->guest(route('login'))->with('error', trans('app.unauthorized_access'));
        }
        
        $user = Auth::user();
        if ($user->is_employer() || $user->is_admin() || $user->is_sysadmin()) {
            return $next($request);
        }
    }
}