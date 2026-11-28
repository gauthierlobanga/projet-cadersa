<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Si l'utilisateur n'est pas connecté
        if (! Filament::auth()->check()) {
            Log::warning('Tentative d\'accès au panel admin par un utilisateur non authentifié.', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
            ]);

            return redirect()->to(Filament::getLoginUrl());
        }

        $user = Filament::auth()->user();

        // 2. Si l'utilisateur est connecté mais n'est PAS super_admin
        if (! $user->hasRole('super_admin')) {
            Log::info('Accès refusé au panel admin, redirection vers dashboard.', [
                'user_id' => $user->id,
                'email' => $user->email,
                'roles' => $user->getRoleNames(),
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
            ]);

            // On redirige silencieusement vers le dashboard au lieu de la page 403
            return redirect()->to('/dashboard');
        }

        // 3. Tout est bon, c'est un super_admin, on le laisse passer
        return $next($request);
    }
}
