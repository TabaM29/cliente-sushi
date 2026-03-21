<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckToken
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si no existe el token del cliente en la sesión, mandarlo al login
        if (!session()->has('cliente_token')) {
            return redirect()->route('login.cliente')
                ->with('error', 'Debes iniciar sesión para acceder a tu perfil.');
        }

        return $next($request);
    }
}