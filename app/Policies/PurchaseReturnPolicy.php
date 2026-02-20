<?php

namespace App\Policies;

use App\Models\PurchaseReturn;
use App\Models\User;

class PurchaseReturnPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'purchasing', 'manager']);
    }

    public function view(User $user, PurchaseReturn $purchaseReturn): bool
    {
        return in_array($user->role, ['admin', 'purchasing', 'manager']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'purchasing']);
    }

    public function update(User $user, PurchaseReturn $purchaseReturn): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, PurchaseReturn $purchaseReturn): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, PurchaseReturn $purchaseReturn): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, PurchaseReturn $purchaseReturn): bool
    {
        return $user->role === 'admin';
    }
}