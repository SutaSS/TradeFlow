<?php

namespace App\Policies;

use App\Models\DeliveryOrder;
use App\Models\User;

class DeliveryOrderPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'sales', 'manager']);
    }

    public function view(User $user, DeliveryOrder $deliveryOrder): bool
    {
        return in_array($user->role, ['admin', 'sales', 'manager']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'sales']);
    }

    public function update(User $user, DeliveryOrder $deliveryOrder): bool
    {
        return in_array($user->role, ['admin', 'sales']);
    }

    public function delete(User $user, DeliveryOrder $deliveryOrder): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, DeliveryOrder $deliveryOrder): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, DeliveryOrder $deliveryOrder): bool
    {
        return $user->role === 'admin';
    }
}