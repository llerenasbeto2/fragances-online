<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response 
      {
        try {
        // Forzar que JWT lea el token del header Authorization
        $token = $request->bearerToken();
        
        if (!$token) {
            return $request->expectsJson()
                ? response()->json(['error' => 'Unauthorized'], 401)
                : redirect('/login');
        }

        // Autenticar con el token
        $user = auth('api')->setToken($token)->authenticate();

        if (!$user) {
            return $request->expectsJson()
                ? response()->json(['error' => 'Unauthorized'], 401)
                : redirect('/login');
        }

        if ($user->role !== $role) {
            return $request->expectsJson()
                ? response()->json(['error' => 'Forbidden'], 403)
                : redirect('/login');
        }

    } catch (\Exception $e) {
        return $request->expectsJson()
            ? response()->json(['error' => 'Unauthorized'], 401)
            : redirect('/login');
    }

    return $next($request);
    }
}
