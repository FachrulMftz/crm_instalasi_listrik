<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@crmlistrik'],
            [
                'name' => 'superuser',
                'password' => Hash::make('superadmin123'),
                'role' => 'superadmin',
            ]
        );
    }
}
