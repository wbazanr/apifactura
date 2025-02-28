<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicAuthRoutes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $username = $request->getUser();
        $password = $request->getPassword();

        $basic_auth_user = env('BASIC_AUTH_USER');
        $basic_auth_password = env ('BASIC_AUTH_PASSWORD');

        if ( $username !=$basic_auth_user || $password != $basic_auth_password)
        {
            return response()->json([
                "message" => "no autorizado",
                "estado" => 403
            
            ]);
        }

        return $next($request);
    }
}
