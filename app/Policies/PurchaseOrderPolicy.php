<?php

namespace App\Policies;

use App\Models\PurchaseOrder;
use App\Models\User;

class PurchaseOrderPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'purchasing', 'manager']);
    }

    public function view(User $user, PurchaseOrder $purchaseOrder): bool
    {
        return in_array($user->role, ['admin', 'purchasing', 'manager']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'purchasing']);
    }

    public function update(User $user, PurchaseOrder $purchaseOrder): bool
    {
        if ($purchaseOrder->status !== 'Draft') {
            return false;
        }
        return in_array($user->role, ['admin', 'purchasing']);
    }

    public function delete(User $user, PurchaseOrder $purchaseOrder): bool
    {
        if ($purchaseOrder->status !== 'Draft') {
            return false;
        }
        return $user->role === 'admin';
    }

    public function restore(User $user, PurchaseOrder $purchaseOrder): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, PurchaseOrder $purchaseOrder): bool
    {
        return $user->role === 'admin';
    }

    public function approve(User $user, PurchaseOrder $purchaseOrder): bool
    {
        return $user->role === 'manager' || $user->role === 'admin';
    }
}