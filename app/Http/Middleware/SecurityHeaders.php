<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Headers de sécurité à ajouter à toutes les réponses.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        // HSTS (Strict-Transport-Security) — uniquement en production avec HTTPS
        if (app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        $csp = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://js.stripe.com",
            "style-src 'self' 'unsafe-inline' https://fonts.bunny.net https://fonts.googleapis.com",
            "img-src 'self' data: https:",
            "font-src 'self' data: https://fonts.bunny.net https://fonts.gstatic.com",
            "connect-src 'self' ws: wss: https://api.stripe.com",
            "frame-src 'self' https://js.stripe.com https://hooks.stripe.com",
            "media-src 'self'",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "worker-src 'self' blob:",
        ];

        if (app()->environment('local')) {
            // Dans l'environnement local, on relaxe la politique pour ne pas bloquer Vite (et éviter les bugs IPv6 CSP)
            $csp[1] = "script-src * blob: 'unsafe-inline' 'unsafe-eval'";
            $csp[2] = "style-src * 'unsafe-inline'";
            $csp[5] = 'connect-src * ws: wss:';
            $csp[3] = 'img-src * data: blob:';
            $csp[4] = 'font-src * data:';
        }

        $response->headers->set('Content-Security-Policy', implode('; ', $csp).';');

        return $response;
    }
}
