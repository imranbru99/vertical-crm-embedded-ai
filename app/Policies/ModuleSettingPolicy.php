<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\ModuleSetting;
use App\Models\User;

class ModuleSettingPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::Admin, UserRole::Demo], true);
    }

    public function view(User $user, ModuleSetting $moduleSetting): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::Admin], true);
    }

    public function update(User $user, ModuleSetting $moduleSetting): bool
    {
        return $this->create($user);
    }

    public function delete(User $user, ModuleSetting $moduleSetting): bool
    {
        return $user->role === UserRole::SuperAdmin;
    }
}