<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectAdminLogin
{
    public function handle(Request $request, Closure $next)
    {
        // Si l'URL demandée est /admin/login, rediriger vers la page de connexion publique
        if ($request->is('admin/login')) {
            return redirect()->to('/login');
        }

        return $next($request);
    }
}
