<?php

namespace App\Policies;

use App\Models\PurchaseRequisition;
use App\Models\User;

class PurchaseRequisitionPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'purchasing', 'manager']);
    }

    public function view(User $user, PurchaseRequisition $purchaseRequisition): bool
    {
        return in_array($user->role, ['admin', 'purchasing', 'manager']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'purchasing']);
    }

    public function update(User $user, PurchaseRequisition $purchaseRequisition): bool
    {
        // Can only update if draft
        if ($purchaseRequisition->status !== 'Draft') {
            return false;
        }
        return in_array($user->role, ['admin', 'purchasing']);
    }

    public function delete(User $user, PurchaseRequisition $purchaseRequisition): bool
    {
        if ($purchaseRequisition->status !== 'Draft') {
            return false;
        }
        return $user->role === 'admin';
    }

    public function restore(User $user, PurchaseRequisition $purchaseRequisition): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, PurchaseRequisition $purchaseRequisition): bool
    {
        return $user->role === 'admin';
    }

    public function approve(User $user, PurchaseRequisition $purchaseRequisition): bool
    {
        return $user->role === 'manager' || $user->role === 'admin';
    }
}