<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIsLoggedIn
{
    public function handle(Request $request, Closure $next): Response
    {

        //check if is logged
        if (!session('user')) {
            return redirect('login');
        }

        return $next($request);
    }
}
