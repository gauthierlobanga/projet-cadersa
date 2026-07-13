<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\SystemNotification;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class SystemNotificationPolicy
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
        return $authUser->can('ViewAny SystemNotification');
    }

    public function view(AuthUser $authUser, SystemNotification $systemNotification): bool
    {
        return $authUser->can('View SystemNotification');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create SystemNotification');
    }

    public function update(AuthUser $authUser, SystemNotification $systemNotification): bool
    {
        return $authUser->can('Update SystemNotification');
    }

    public function delete(AuthUser $authUser, SystemNotification $systemNotification): bool
    {
        return $authUser->can('Delete SystemNotification');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny SystemNotification');
    }

    public function restore(AuthUser $authUser, SystemNotification $systemNotification): bool
    {
        return $authUser->can('Restore SystemNotification');
    }

    public function forceDelete(AuthUser $authUser, SystemNotification $systemNotification): bool
    {
        return $authUser->can('ForceDelete SystemNotification');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny SystemNotification');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny SystemNotification');
    }

    public function replicate(AuthUser $authUser, SystemNotification $systemNotification): bool
    {
        return $authUser->can('Replicate SystemNotification');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder SystemNotification');
    }
}
