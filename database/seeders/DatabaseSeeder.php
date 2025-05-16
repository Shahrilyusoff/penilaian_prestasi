<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PydGroupsTableSeeder::class,
            UsersTableSeeder::class,
            EvaluationCriteriaTableSeeder::class,
        ]);
    }
}