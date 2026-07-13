<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApplyUserPreferences
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check if user is authenticated and session is missing preferences
        if (Auth::check()) {
            $user = Auth::user();

            if (! session()->has('locale') && $user->getPreference('locale')) {
                session(['locale' => $user->getPreference('locale')]);
            }
            if (! session()->has('country') && $user->getPreference('country')) {
                session(['country' => $user->getPreference('country')]);
            }
            if (! session()->has('currency') && $user->getPreference('currency')) {
                session(['currency' => $user->getPreference('currency')]);
            }
        }

        // 2. Set App Locale
        $locale = session('locale', config('app.locale'));
        App::setLocale($locale);

        return $next($request);
    }
}
