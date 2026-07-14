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

        // Build CSP depending on environment
        $nonce = base64_encode(random_bytes(12));

        if (app()->environment('local') || app()->environment('testing')) {
            // Relaxed CSP for local/testing to allow vite HMR and inline scripts during development
            $csp = [
                "default-src 'self'",
                "script-src * blob: 'unsafe-inline' 'unsafe-eval'",
                "style-src * 'unsafe-inline'",
                'img-src * data: blob:',
                'font-src * data:',
                'connect-src * ws: wss:',
                'frame-src *',
                'media-src *',
                "object-src 'none'",
                "base-uri 'self'",
                "form-action 'self'",
                "worker-src 'self' blob:",
            ];

            $policy = implode('; ', $csp).';';

            // In development we do not set report-only by default
            $response->headers->set('Content-Security-Policy', $policy);
        } else {
            // Production: strict CSP — NO unsafe-inline / unsafe-eval
            // We allow scripts from self and stripe; include a per-request nonce for safe inline scripts if used
            $csp = [
                "default-src 'self'",
                "script-src 'self' 'nonce-{$nonce}' https://js.stripe.com",
                "style-src 'self' https://fonts.bunny.net https://fonts.googleapis.com",
                "img-src 'self' data: https:",
                "font-src 'self' data: https://fonts.bunny.net https://fonts.gstatic.com",
                "connect-src 'self' https://api.stripe.com",
                "frame-src 'self' https://js.stripe.com https://hooks.stripe.com",
                "media-src 'self'",
                "object-src 'none'",
                "base-uri 'self'",
                "form-action 'self'",
                "worker-src 'self' blob:",
            ];

            $policy = implode('; ', $csp).';';

            // If CSP_REPORT_URI is set in config (use config to be safe when config is cached), enable report-only header during roll-out
            $reportUri = config('app.csp_report_uri');
            if ($reportUri) {
                // Add a report-uri for older user-agents and a report-to for modern ones
                $policyReportOnly = $policy." report-uri {$reportUri};";

                // 'Report-To' header requires a JSON structure
                $reportTo = json_encode([
                    'group' => 'csp-endpoint',
                    'max_age' => 10886400,
                    'endpoints' => [['url' => $reportUri]],
                ]);

                $response->headers->set('Report-To', $reportTo);
                $response->headers->set('Content-Security-Policy-Report-Only', $policyReportOnly);
            }

            // Always set the enforcement CSP header in production
            $response->headers->set('Content-Security-Policy', $policy);

            // Expose nonce to the response for use in views if needed
            $response->headers->set('X-CSP-Nonce', $nonce);
        }

        return $response;
    }
}
