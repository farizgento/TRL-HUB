<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin', 'slug' => 'admin', 'description' => 'Akses penuh sistem'],
            ['name' => 'Staff', 'slug' => 'staff', 'description' => 'Kelola peminjaman dan operasional'],
            ['name' => 'Approval', 'slug' => 'approval', 'description' => 'Persetujuan akhir peminjaman'],
            ['name' => 'Peminjam', 'slug' => 'peminjam', 'description' => 'Request peminjaman alat'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['slug' => $role['slug']], $role);
        }
    }
}
