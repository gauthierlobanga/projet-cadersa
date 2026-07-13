<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\PostBookMark;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class PostBookMarkPolicy
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
        return $authUser->can('ViewAny PostBookMark');
    }

    public function view(AuthUser $authUser, PostBookMark $postBookMark): bool
    {
        return $authUser->can('View PostBookMark');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create PostBookMark');
    }

    public function update(AuthUser $authUser, PostBookMark $postBookMark): bool
    {
        return $authUser->can('Update PostBookMark');
    }

    public function delete(AuthUser $authUser, PostBookMark $postBookMark): bool
    {
        return $authUser->can('Delete PostBookMark');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny PostBookMark');
    }

    public function restore(AuthUser $authUser, PostBookMark $postBookMark): bool
    {
        return $authUser->can('Restore PostBookMark');
    }

    public function forceDelete(AuthUser $authUser, PostBookMark $postBookMark): bool
    {
        return $authUser->can('ForceDelete PostBookMark');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny PostBookMark');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny PostBookMark');
    }

    public function replicate(AuthUser $authUser, PostBookMark $postBookMark): bool
    {
        return $authUser->can('Replicate PostBookMark');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder PostBookMark');
    }
}
