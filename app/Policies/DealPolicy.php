<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Deal;
use App\Models\User;

class DealPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role?->canAccessAdmin() ?? false;
    }

    public function view(User $user, Deal $deal): bool
    {
        return $this->viewAny($user) || $user->role === UserRole::Client;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::Admin, UserRole::Manager, UserRole::Staff, UserRole::Demo], true);
    }

    public function update(User $user, Deal $deal): bool
    {
        return $this->create($user);
    }

    public function delete(User $user, Deal $deal): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::Admin, UserRole::Demo], true);
    }
}