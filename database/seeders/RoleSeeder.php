<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin',              'slug' => 'admin',              'description' => 'Akses penuh sistem'],
            ['name' => 'Staff Perencanaan', 'slug' => 'perencanaan',        'description' => 'Mengatur alat yang dikirim'],
            ['name' => 'Staff Pengendalian','slug' => 'pengendalian',       'description' => 'Mengatur kondisi alat setelah kembali'],
            ['name' => 'Approval',          'slug' => 'approval',           'description' => 'Menyetujui rencana pengiriman'],
            ['name' => 'Peminjam',          'slug' => 'peminjam',           'description' => 'Mengajukan peminjaman alat'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['slug' => $role['slug']], $role);
        }
    }
}
