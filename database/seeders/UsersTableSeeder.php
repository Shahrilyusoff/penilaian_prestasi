<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'peranan' => 'super_admin',
            'jawatan' => 'Pembangun Sistem',
            'kementerian_jabatan' => 'Institut Koperasi Malaysia'
        ]);

        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'peranan' => 'admin',
            'jawatan' => 'Pentadbir Sistem',
            'kementerian_jabatan' => 'Institut Koperasi Malaysia'
        ]);

        // PPP (Pegawai Penilai Pertama)
        User::create([
            'name' => 'PPP 1',
            'email' => 'ppp1@example.com',
            'password' => Hash::make('password'),
            'peranan' => 'ppp',
            'jawatan' => 'Ketua Jabatan',
            'kementerian_jabatan' => 'Institut Koperasi Malaysia'
        ]);

        // PPK (Pegawai Penilai Kedua)
        User::create([
            'name' => 'PPK 1',
            'email' => 'ppk1@example.com',
            'password' => Hash::make('password'),
            'peranan' => 'ppk',
            'jawatan' => 'Pengarah',
            'kementerian_jabatan' => 'Institut Koperasi Malaysia'
        ]);

        // PYD (Pegawai Yang Dinilai) - Pengurusan
        User::create([
            'name' => 'PYD Pengurusan',
            'email' => 'pyd1@example.com',
            'password' => Hash::make('password'),
            'peranan' => 'pyd',
            'pyd_group_id' => 1,
            'jawatan' => 'Pegawai Pengurusan',
            'gred' => 'N41',
            'kementerian_jabatan' => 'Institut Koperasi Malaysia'
        ]);

        // PYD (Pegawai Yang Dinilai) - Sokongan I
        User::create([
            'name' => 'PYD Sokongan I',
            'email' => 'pyd2@example.com',
            'password' => Hash::make('password'),
            'peranan' => 'pyd',
            'pyd_group_id' => 2,
            'jawatan' => 'Pegawai Sokongan',
            'gred' => 'N22',
            'kementerian_jabatan' => 'Institut Koperasi Malaysia'
        ]);

        // PYD (Pegawai Yang Dinilai) - Sokongan II
        User::create([
            'name' => 'PYD Sokongan II',
            'email' => 'pyd3@example.com',
            'password' => Hash::make('password'),
            'peranan' => 'pyd',
            'pyd_group_id' => 3,
            'jawatan' => 'Pegawai Sokongan',
            'gred' => 'N17',
            'kementerian_jabatan' => 'Institut Koperasi Malaysia'
        ]);
    }
}