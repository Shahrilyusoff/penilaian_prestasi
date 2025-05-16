<?php

namespace Database\Seeders;

use App\Models\PydGroup;
use Illuminate\Database\Seeder;

class PydGroupsTableSeeder extends Seeder
{
    public function run()
    {
        $groups = [
            ['nama_kumpulan' => 'Pegawai Kumpulan Pengurusan dan Professional'],
            ['nama_kumpulan' => 'Pegawai Kumpulan Perkhidmatan Sokongan (I)'],
            ['nama_kumpulan' => 'Pegawai Kumpulan Perkhidmatan Sokongan (II)'],
        ];

        foreach ($groups as $group) {
            PydGroup::create($group);
        }
    }
}