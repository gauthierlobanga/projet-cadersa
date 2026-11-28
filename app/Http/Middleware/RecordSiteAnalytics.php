<?php

namespace App\Http\Middleware;

use App\Services\SiteAnalyticsTracker;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class RecordSiteAnalytics
{
    public function __construct(private SiteAnalyticsTracker $analytics) {}

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $this->shouldRecord($request, $response)) {
            return $response;
        }

        try {
            $this->analytics->recordPageView($request);

            $conversionStep = match (true) {
                $request->routeIs('contact') => 'contact',
                $request->routeIs('register') => 'registration',
                default => null,
            };

            if ($conversionStep) {
                $this->analytics->startConversion($conversionStep, $request);
            }
        } catch (Throwable $exception) {
            report($exception);
        }

        return $response;
    }

    private function shouldRecord(Request $request, Response $response): bool
    {
        $userAgent = strtolower($request->userAgent() ?? '');
        $contentType = strtolower($response->headers->get('Content-Type', ''));

        return $request->isMethod('GET')
            && ! $request->is('admin', 'admin/*', 'livewire/*', 'up', 'telescope*', '_ignition/*')
            && ! $request->routeIs('filament.*')
            && $response->isSuccessful()
            && str_contains($contentType, 'text/html')
            && ! preg_match('/bot|crawler|spider|headless|monitor/', $userAgent);
    }
}
