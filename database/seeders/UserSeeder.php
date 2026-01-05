<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = 'password';

        $overrides = [
            'admin'        => ['name' => 'admin',        'email' => 'admin@trl.local'],
            'perencanaan'  => ['name' => 'staff perencanaan',    'email' => 'staff1@trl.local'],
            'pengendalian' => ['name' => 'staff pengendalian',   'email' => 'staff2@trl.local'],
            'approval'     => ['name' => 'approval',     'email' => 'approval@trl.local'],
            'peminjam'     => ['name' => 'peminjam',     'email' => 'peminjam@trl.local'],
        ];

        $roles = Role::get();

        foreach ($roles as $role) {

            $data = $overrides[$role->slug] ?? [
                'name' => $role->slug,
                'email'    => $role->slug.'@trl.local'
            ];

            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'password' => Hash::make($password),
                    'role_id'  => $role->id,
                    'verified' => true,
                ]
            );
        }
    }
}
