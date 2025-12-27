<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'nama' => 'Admin JTIK',
                'username' => 'admin_jtik',
                'password' => 'jtik123', // password baru
                'role' => 'admin_jtik'
            ],
            [
                'nama' => 'Admin TI',
                'username' => 'admin_ti',
                'password' => 'ti123',
                'role' => 'prodi_ti'
            ],
            [
                'nama' => 'Admin TRKJ',
                'username' => 'admin_trkj',
                'password' => 'trkj123',
                'role' => 'prodi_trkj'
            ],
            [
                'nama' => 'Admin TRMM',
                'username' => 'admin_trmm',
                'password' => 'trmm123',
                'role' => 'prodi_trmm'
            ],
        ];

        foreach ($admins as $admin) {
            // update jika sudah ada, buat baru jika belum ada
            Admin::updateOrCreate(
                ['username' => $admin['username']],
                [
                    'nama' => $admin['nama'],
                    'password' => Hash::make($admin['password']), // hash password baru
                    'role' => $admin['role']
                ]
            );
        }
    }
}
