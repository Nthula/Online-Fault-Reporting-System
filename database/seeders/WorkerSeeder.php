<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('workers')->insert([
            [
                'name' => 'John Doe',
                'department_id' => 1, // Replace with an existing department_id
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'department_id' => 1, // Replace with an existing department_id
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alice Johnson',
                'department_id' => 1, // Replace with an existing department_id
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
