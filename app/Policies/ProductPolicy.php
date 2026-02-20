<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'sales', 'purchasing', 'manager']);
    }

    public function view(User $user, Product $product): bool
    {
        return in_array($user->role, ['admin', 'sales', 'purchasing', 'manager']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'purchasing']);
    }

    public function update(User $user, Product $product): bool
    {
        return in_array($user->role, ['admin', 'purchasing']);
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, Product $product): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, Product $product): bool
    {
        return $user->role === 'admin';
    }
}