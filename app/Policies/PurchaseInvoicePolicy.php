<?php

namespace App\Policies;

use App\Models\PurchaseInvoice;
use App\Models\User;

class PurchaseInvoicePolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'purchasing', 'manager']);
    }

    public function view(User $user, PurchaseInvoice $purchaseInvoice): bool
    {
        return in_array($user->role, ['admin', 'purchasing', 'manager']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'purchasing']);
    }

    public function update(User $user, PurchaseInvoice $purchaseInvoice): bool
    {
        return in_array($user->role, ['admin', 'purchasing']);
    }

    public function delete(User $user, PurchaseInvoice $purchaseInvoice): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, PurchaseInvoice $purchaseInvoice): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, PurchaseInvoice $purchaseInvoice): bool
    {
        return $user->role === 'admin';
    }
}