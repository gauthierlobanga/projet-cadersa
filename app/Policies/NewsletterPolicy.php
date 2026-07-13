<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Newsletter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class NewsletterPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Newsletter');
    }

    public function view(AuthUser $authUser, Newsletter $newsletter): bool
    {
        return $authUser->can('View:Newsletter');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Newsletter');
    }

    public function update(AuthUser $authUser, Newsletter $newsletter): bool
    {
        return $authUser->can('Update:Newsletter');
    }

    public function delete(AuthUser $authUser, Newsletter $newsletter): bool
    {
        return $authUser->can('Delete:Newsletter');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Newsletter');
    }

    public function restore(AuthUser $authUser, Newsletter $newsletter): bool
    {
        return $authUser->can('Restore:Newsletter');
    }

    public function forceDelete(AuthUser $authUser, Newsletter $newsletter): bool
    {
        return $authUser->can('ForceDelete:Newsletter');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Newsletter');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Newsletter');
    }

    public function replicate(AuthUser $authUser, Newsletter $newsletter): bool
    {
        return $authUser->can('Replicate:Newsletter');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Newsletter');
    }
}
