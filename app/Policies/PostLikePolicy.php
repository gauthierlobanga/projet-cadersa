<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\PostLike;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class PostLikePolicy
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
        return $authUser->can('ViewAny PostLike');
    }

    public function view(AuthUser $authUser, PostLike $postLike): bool
    {
        return $authUser->can('View PostLike');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create PostLike');
    }

    public function update(AuthUser $authUser, PostLike $postLike): bool
    {
        return $authUser->can('Update PostLike');
    }

    public function delete(AuthUser $authUser, PostLike $postLike): bool
    {
        return $authUser->can('Delete PostLike');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny PostLike');
    }

    public function restore(AuthUser $authUser, PostLike $postLike): bool
    {
        return $authUser->can('Restore PostLike');
    }

    public function forceDelete(AuthUser $authUser, PostLike $postLike): bool
    {
        return $authUser->can('ForceDelete PostLike');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny PostLike');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny PostLike');
    }

    public function replicate(AuthUser $authUser, PostLike $postLike): bool
    {
        return $authUser->can('Replicate PostLike');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder PostLike');
    }
}
