<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta sección.');
        }

        $user = Auth::user();

        if ($user->role === 'agent' && !$user->is_approved) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Tu cuenta de Agente Inmobiliario está pendiente de aprobación por el Administrador General.');
        }

        if (!in_array($user->role, $roles)) {
            return redirect()->route('properties.index')->with('error', 'No tienes permisos para acceder al área de administración.');
        }

        return $next($request);
    }
}
