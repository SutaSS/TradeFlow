<?php

namespace App\Policies;

use App\Models\SalesOrder;
use App\Models\User;

class SalesOrderPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'sales', 'manager']);
    }

    public function view(User $user, SalesOrder $salesOrder): bool
    {
        return in_array($user->role, ['admin', 'sales', 'manager']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'sales']);
    }

    public function update(User $user, SalesOrder $salesOrder): bool
    {
        // Can only update if draft
        if ($salesOrder->status !== 'Draft') {
            return false;
        }
        return in_array($user->role, ['admin', 'sales']);
    }

    public function delete(User $user, SalesOrder $salesOrder): bool
    {
        // Can only delete draft
        if ($salesOrder->status !== 'Draft') {
            return false;
        }
        return $user->role === 'admin';
    }

    public function restore(User $user, SalesOrder $salesOrder): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, SalesOrder $salesOrder): bool
    {
        return $user->role === 'admin';
    }
}