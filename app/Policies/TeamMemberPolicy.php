<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\TeamMember;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class TeamMemberPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TeamMember');
    }

    public function view(AuthUser $authUser, TeamMember $teamMember): bool
    {
        return $authUser->can('View:TeamMember');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TeamMember');
    }

    public function update(AuthUser $authUser, TeamMember $teamMember): bool
    {
        return $authUser->can('Update:TeamMember');
    }

    public function delete(AuthUser $authUser, TeamMember $teamMember): bool
    {
        return $authUser->can('Delete:TeamMember');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:TeamMember');
    }

    public function restore(AuthUser $authUser, TeamMember $teamMember): bool
    {
        return $authUser->can('Restore:TeamMember');
    }

    public function forceDelete(AuthUser $authUser, TeamMember $teamMember): bool
    {
        return $authUser->can('ForceDelete:TeamMember');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TeamMember');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TeamMember');
    }

    public function replicate(AuthUser $authUser, TeamMember $teamMember): bool
    {
        return $authUser->can('Replicate:TeamMember');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TeamMember');
    }
}
