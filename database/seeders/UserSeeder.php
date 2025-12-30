<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Password default untuk semua user demo
        $defaultPassword = 'password';

        // Optional: override email / nama untuk role tertentu (kalau mau rapih seperti contoh kamu)
        $overrides = [
            'admin'    => ['name' => 'Admin TRL',    'email' => 'admin@trl.local'],
            'staff'    => ['name' => 'Staff TRL',    'email' => 'staff@trl.local'],
            'approval' => ['name' => 'Approval TRL', 'email' => 'approval@trl.local'],
            'peminjam' => ['name' => 'Peminjam TRL', 'email' => 'peminjam@trl.local'],
        ];

        // Ambil semua role
        $roles = Role::query()->get();

        foreach ($roles as $role) {
            $slug = $role->slug;

            // Tentukan email & nama default berdasarkan slug
            $email = $overrides[$slug]['email'] ?? ($slug . '@trl.local');
            $name  = $overrides[$slug]['name']  ?? ('User ' . Str::title(str_replace(['-', '_'], ' ', $slug)));

            User::updateOrCreate(
                ['email' => $email],
                [
                    'name'     => $name,
                    'password' => Hash::make($defaultPassword),
                    'role_id'  => $role->id,
                ]
            );
        }
    }
}
