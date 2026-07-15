<?php

namespace App\Livewire\Actions;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Features\SupportRedirects\Redirector;

class Logout
{
    /**
     * Log the current user out of the application.
     *
     * Invalidates the session and regenerates the CSRF token, then redirects to
     * the application root.
     *
     * @return \Illuminate\Features\SupportRedirects\Redirector|RedirectResponse
     */
    public function __invoke(): Redirector|RedirectResponse
    {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        return redirect('/');
    }
}
