<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AcceptMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        $roles = is_array($roles) ? $roles : explode(',', $roles);
        
        foreach ($roles as $role) 
            if (auth()->user()->type == $role) 
                return $next($request);
            
        abort(401);
    }
}
