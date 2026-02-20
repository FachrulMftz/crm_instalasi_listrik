<?php

namespace App\Policies;

use App\Models\Installation;
use App\Models\User;

class InstallationPolicy
{
    public function view(User $user, Installation $installation): bool
    {
        if ($user->role === 'admin' || $user->role === 'sales') {
            return true;
        }

        // teknisi hanya bisa lihat miliknya
        return $installation->technician_id === $user->id;
    }
}