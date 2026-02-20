<?php

namespace App\Policies;

use App\Models\SalesReturn;
use App\Models\User;

class SalesReturnPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'sales', 'manager']);
    }

    public function view(User $user, SalesReturn $salesReturn): bool
    {
        return in_array($user->role, ['admin', 'sales', 'manager']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'sales']);
    }

    public function update(User $user, SalesReturn $salesReturn): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, SalesReturn $salesReturn): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, SalesReturn $salesReturn): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, SalesReturn $salesReturn): bool
    {
        return $user->role === 'admin';
    }
}