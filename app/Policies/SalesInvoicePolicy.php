<?php

namespace App\Policies;

use App\Models\SalesInvoice;
use App\Models\User;

class SalesInvoicePolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'sales', 'manager']);
    }

    public function view(User $user, SalesInvoice $salesInvoice): bool
    {
        return in_array($user->role, ['admin', 'sales', 'manager']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'sales']);
    }

    public function update(User $user, SalesInvoice $salesInvoice): bool
    {
        // Can only update if draft
        if ($salesInvoice->status !== 'Draft') {
            return false;
        }
        return in_array($user->role, ['admin', 'sales']);
    }

    public function delete(User $user, SalesInvoice $salesInvoice): bool
    {
        if ($salesInvoice->status !== 'Draft') {
            return false;
        }
        return $user->role === 'admin';
    }

    public function restore(User $user, SalesInvoice $salesInvoice): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, SalesInvoice $salesInvoice): bool
    {
        return $user->role === 'admin';
    }
}