<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class VerifierRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.create'); // redirige si non connecté
        }

        $user = Auth::user();

        // Vérifie si le rôle de l'utilisateur est dans la liste des rôles autorisés
        if (!in_array($user->profil, $roles)) {
            abort(403, 'Accès refusé.');
        }

        return $next($request);
    }
}
