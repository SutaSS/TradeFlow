<?php

namespace App\Policies;

use App\Models\GoodsReceipt;
use App\Models\User;

class GoodsReceiptPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'purchasing', 'manager']);
    }

    public function view(User $user, GoodsReceipt $goodsReceipt): bool
    {
        return in_array($user->role, ['admin', 'purchasing', 'manager']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'purchasing']);
    }

    public function update(User $user, GoodsReceipt $goodsReceipt): bool
    {
        return in_array($user->role, ['admin', 'purchasing']);
    }

    public function delete(User $user, GoodsReceipt $goodsReceipt): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, GoodsReceipt $goodsReceipt): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, GoodsReceipt $goodsReceipt): bool
    {
        return $user->role === 'admin';
    }
}