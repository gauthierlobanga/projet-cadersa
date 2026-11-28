<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SiteAnalyticsTracker
{
    private const VISITOR_SESSION_KEY = '_site_analytics_visitor_id';

    private const LAST_VISIT_ACTIVITY_KEY = '_site_analytics_last_visit_activity_at';

    /**
     * @return array{visitor_id: string, session_id: string}|null
     */
    public function identity(Request $request): ?array
    {
        if (! $request->hasSession()) {
            return null;
        }

        $visitorId = $request->session()->get(self::VISITOR_SESSION_KEY);

        if (! is_string($visitorId) || $visitorId === '') {
            $visitorId = (string) Str::uuid();
            $request->session()->put(self::VISITOR_SESSION_KEY, $visitorId);
        }

        return [
            'visitor_id' => $visitorId,
            'session_id' => $request->session()->getId(),
        ];
    }

    public function recordPageView(Request $request): void
    {
        $identity = $this->identity($request);

        if (! $identity) {
            return;
        }

        $now = now();
        $lastVisitActivityAt = $request->session()->get(self::LAST_VISIT_ACTIVITY_KEY);
        $isNewVisit = ! is_string($lastVisitActivityAt)
            || CarbonImmutable::parse($lastVisitActivityAt)->lessThan($now->subMinutes(30));

        $request->session()->put(self::LAST_VISIT_ACTIVITY_KEY, $now->toIso8601String());

        $path = '/'.ltrim($request->path(), '/');
        $pageId = (string) Str::uuid();
        $device = $this->deviceFor($request->userAgent());
        $platform = $this->platformFor($request->userAgent());
        $browser = $this->browserFor($request->userAgent());
        $language = strtok((string) $request->header('Accept-Language', ''), ',;') ?: null;
        $attribution = $this->attributionFor($request);

        DB::transaction(function () use ($identity, $now, $path, $pageId, $device, $platform, $browser, $language, $attribution, $isNewVisit): void {
            if ($isNewVisit) {
                DB::table('visits')->insert([
                    'id' => (string) Str::uuid(),
                    'visitor_id' => $identity['visitor_id'],
                    'session_id' => $identity['session_id'],
                    'visitable_type' => null,
                    'visitable_id' => null,
                    'url' => $path,
                    'path' => $path,
                    'method' => 'GET',
                    'referrer' => $attribution['referrer'],
                    'ip' => null,
                    'device' => $device,
                    'platform' => $platform,
                    'browser' => $browser,
                    'language' => $language,
                    'utm_params' => $attribution['utm_params'],
                    'duration' => 0,
                    'visited_at' => $now,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            DB::table('page_views')->insert([
                'id' => (string) Str::uuid(),
                'page_id' => $pageId,
                'session_id' => $identity['session_id'],
                'visitor_id' => $identity['visitor_id'],
                'url' => $path,
                'viewed_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('visitor_events')->insert([
                'id' => (string) Str::uuid(),
                'session_id' => $identity['session_id'],
                'visitor_id' => $identity['visitor_id'],
                'event_type' => 'page_view',
                'url' => $path,
                'page_id' => $pageId,
                'metadata' => null,
                'occurred_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        });
    }

    public function startConversion(string $step, ?Request $request = null): void
    {
        $request ??= request();
        $identity = $this->identity($request);

        if (! $identity || $this->isAdminRequest($request)) {
            return;
        }

        $now = now();

        DB::table('conversion_events')->insert([
            'id' => (string) Str::uuid(),
            'session_id' => $identity['session_id'],
            'visitor_id' => $identity['visitor_id'],
            'step' => $step,
            'completed' => false,
            'completed_at' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function completeConversion(string $step, ?Request $request = null): void
    {
        $request ??= request();
        $identity = $this->identity($request);

        if (! $identity || $this->isAdminRequest($request)) {
            return;
        }

        $now = now();
        $startedEvent = DB::table('conversion_events')
            ->where('visitor_id', $identity['visitor_id'])
            ->where('session_id', $identity['session_id'])
            ->where('step', $step)
            ->where('completed', false)
            ->orderByDesc('created_at')
            ->first();

        if ($startedEvent) {
            DB::table('conversion_events')
                ->where('id', $startedEvent->id)
                ->update([
                    'completed' => true,
                    'completed_at' => $now,
                    'updated_at' => $now,
                ]);

            return;
        }

        DB::table('conversion_events')->insert([
            'id' => (string) Str::uuid(),
            'session_id' => $identity['session_id'],
            'visitor_id' => $identity['visitor_id'],
            'step' => $step,
            'completed' => true,
            'completed_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    private function isAdminRequest(Request $request): bool
    {
        return $request->is('admin', 'admin/*') || $request->routeIs('filament.*');
    }

    /**
     * @return array{referrer: ?string, utm_params: ?string}
     */
    private function attributionFor(Request $request): array
    {
        $referrer = $request->headers->get('referer');
        $referrerHost = null;

        if (is_string($referrer) && in_array(parse_url($referrer, PHP_URL_SCHEME), ['http', 'https'], true)) {
            $host = parse_url($referrer, PHP_URL_HOST);
            $requestHost = preg_replace('/^www\./i', '', strtolower($request->getHost()));
            $referrerHost = is_string($host) ? preg_replace('/^www\./i', '', strtolower($host)) : null;

            if (is_string($referrerHost) && $referrerHost !== $requestHost) {
                $referrerHost = Str::limit($referrerHost, 255, '');
            } else {
                $referrerHost = null;
            }
        }

        $utmParams = collect(['utm_source', 'utm_medium', 'utm_campaign'])
            ->mapWithKeys(function (string $key) use ($request): array {
                $value = $request->query($key);

                if (! is_string($value) || trim($value) === '' || str_contains($value, '@') || ! preg_match('/^[\pL\pN._ -]+$/u', $value)) {
                    return [];
                }

                return [$key => Str::limit(trim($value), 120, '')];
            })
            ->all();

        return [
            'referrer' => $referrerHost,
            'utm_params' => $utmParams === [] ? null : json_encode($utmParams, JSON_THROW_ON_ERROR),
        ];
    }

    private function deviceFor(?string $userAgent): string
    {
        $userAgent = strtolower($userAgent ?? '');

        return match (true) {
            str_contains($userAgent, 'ipad'), str_contains($userAgent, 'tablet') => 'Tablette',
            str_contains($userAgent, 'mobile'), str_contains($userAgent, 'iphone'), str_contains($userAgent, 'android') => 'Mobile',
            $userAgent === '' => 'Non renseigné',
            default => 'Ordinateur',
        };
    }

    private function platformFor(?string $userAgent): ?string
    {
        $userAgent = strtolower($userAgent ?? '');

        return match (true) {
            str_contains($userAgent, 'windows') => 'Windows',
            str_contains($userAgent, 'iphone'), str_contains($userAgent, 'ipad'), str_contains($userAgent, 'mac os') => 'Apple',
            str_contains($userAgent, 'android') => 'Android',
            str_contains($userAgent, 'linux') => 'Linux',
            default => null,
        };
    }

    private function browserFor(?string $userAgent): ?string
    {
        $userAgent = strtolower($userAgent ?? '');

        return match (true) {
            str_contains($userAgent, 'edg/') => 'Edge',
            str_contains($userAgent, 'opr/'), str_contains($userAgent, 'opera') => 'Opera',
            str_contains($userAgent, 'chrome/') => 'Chrome',
            str_contains($userAgent, 'firefox/') => 'Firefox',
            str_contains($userAgent, 'safari/') => 'Safari',
            default => null,
        };
    }
}
