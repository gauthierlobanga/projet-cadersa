<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\CookieConsent;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class CookieConsentPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('super_admin') || $user->hasRole('editeur')) {
            return true;
        }

        if (function_exists('tenant') && tenant() && $user->canAccessTenant(tenant())) {
            return true;
        }

        return null;
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny CookieConsent');
    }

    public function view(AuthUser $authUser, CookieConsent $cookieConsent): bool
    {
        return $authUser->can('View CookieConsent');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create CookieConsent');
    }

    public function update(AuthUser $authUser, CookieConsent $cookieConsent): bool
    {
        return $authUser->can('Update CookieConsent');
    }

    public function delete(AuthUser $authUser, CookieConsent $cookieConsent): bool
    {
        return $authUser->can('Delete CookieConsent');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny CookieConsent');
    }

    public function restore(AuthUser $authUser, CookieConsent $cookieConsent): bool
    {
        return $authUser->can('Restore CookieConsent');
    }

    public function forceDelete(AuthUser $authUser, CookieConsent $cookieConsent): bool
    {
        return $authUser->can('ForceDelete CookieConsent');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny CookieConsent');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny CookieConsent');
    }

    public function replicate(AuthUser $authUser, CookieConsent $cookieConsent): bool
    {
        return $authUser->can('Replicate CookieConsent');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder CookieConsent');
    }
}
