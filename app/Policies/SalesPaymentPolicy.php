<?php

namespace App\Policies;

use App\Models\SalesPayment;
use App\Models\User;

class SalesPaymentPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'sales', 'manager']);
    }

    public function view(User $user, SalesPayment $salesPayment): bool
    {
        return in_array($user->role, ['admin', 'sales', 'manager']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'sales']);
    }

    public function update(User $user, SalesPayment $salesPayment): bool
    {
        // Cannot update if already processed
        if (in_array($salesPayment->status, ['success', 'failed'])) {
            return false;
        }
        return $user->role === 'admin';
    }

    public function delete(User $user, SalesPayment $salesPayment): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, SalesPayment $salesPayment): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, SalesPayment $salesPayment): bool
    {
        return $user->role === 'admin';
    }
}