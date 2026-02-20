<?php

namespace App\Policies;

use App\Models\PurchasePayment;
use App\Models\User;

class PurchasePaymentPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'purchasing', 'manager']);
    }

    public function view(User $user, PurchasePayment $purchasePayment): bool
    {
        return in_array($user->role, ['admin', 'purchasing', 'manager']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'purchasing']);
    }

    public function update(User $user, PurchasePayment $purchasePayment): bool
    {
        if (in_array($purchasePayment->status, ['success', 'failed'])) {
            return false;
        }
        return $user->role === 'admin';
    }

    public function delete(User $user, PurchasePayment $purchasePayment): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, PurchasePayment $purchasePayment): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, PurchasePayment $purchasePayment): bool
    {
        return $user->role === 'admin';
    }
}