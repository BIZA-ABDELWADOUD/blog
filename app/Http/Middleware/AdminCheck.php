<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class AdminCheck
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
        if($request->path() == 'app/user_login') {
            return $next($request);

        }
        if(!Auth::check()) {
             return redirect('/login');  
        }
        $user = Auth::user();
        if($user->role->isAdmin == 0) {
            return redirect('/login');    
        }
       
            return $next($request);
    }
}