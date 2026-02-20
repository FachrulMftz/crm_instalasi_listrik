<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function installations()
    {
        return $this->hasMany(Installation::class, 'technician_id');
    }

    public function isSales()
{
    return $this->role === 'sales';
}

public function isTechnician()
{
    return $this->role === 'teknisi';
}

public function hasAnyRole(array $roles): bool
{
    return in_array($this->role, $roles);
}

}
