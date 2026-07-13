<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\NewsletterSend;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class NewsletterSendPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     */
    public function before(AuthUser $user, string $ability): ?bool
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
        return $authUser->can('ViewAny NewsletterSend');
    }

    public function view(AuthUser $authUser, NewsletterSend $newsletterSend): bool
    {
        return $authUser->can('View NewsletterSend');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create NewsletterSend');
    }

    public function update(AuthUser $authUser, NewsletterSend $newsletterSend): bool
    {
        return $authUser->can('Update NewsletterSend');
    }

    public function delete(AuthUser $authUser, NewsletterSend $newsletterSend): bool
    {
        return $authUser->can('Delete NewsletterSend');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny NewsletterSend');
    }

    public function restore(AuthUser $authUser, NewsletterSend $newsletterSend): bool
    {
        return $authUser->can('Restore NewsletterSend');
    }

    public function forceDelete(AuthUser $authUser, NewsletterSend $newsletterSend): bool
    {
        return $authUser->can('ForceDelete NewsletterSend');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny NewsletterSend');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny NewsletterSend');
    }

    public function replicate(AuthUser $authUser, NewsletterSend $newsletterSend): bool
    {
        return $authUser->can('Replicate NewsletterSend');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder NewsletterSend');
    }
}
