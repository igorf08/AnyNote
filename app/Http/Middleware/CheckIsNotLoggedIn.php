<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIsNotLoggedIn
{
    public function handle(Request $request, Closure $next): Response
    {

        if (session('user')) {
            return redirect('/');
        }

        return $next($request);
    }
}
