<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Common last names for more realistic names
        $lastNames = [
            'Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Miller', 'Davis', 'Garcia',
            'Rodriguez', 'Wilson', 'Martinez', 'Anderson', 'Taylor', 'Thomas', 'Hernandez',
            'Moore', 'Martin', 'Jackson', 'Thompson', 'White', 'Lopez', 'Lee', 'Gonzalez',
            'Harris', 'Clark', 'Lewis', 'Robinson', 'Walker', 'Perez', 'Hall', 'Young',
            'Allen', 'Sanchez', 'Wright', 'King', 'Scott', 'Green', 'Baker', 'Adams',
            'Nelson', 'Hill', 'Ramirez', 'Campbell', 'Mitchell', 'Roberts', 'Carter', 'Phillips'
        ];

        $students = [];

        for ($i = 0; $i < 100; $i++) {
            $firstName = $faker->firstName;
            $lastName = $faker->randomElement($lastNames);
            $year = 2019; // Starting year
            $sequence = str_pad($i + 1, 3, '0', STR_PAD_LEFT); // 001 to 100
            
            $students[] = [
                'name' => $firstName . ' ' . $lastName,
                'student_id' => $year . $sequence,
            ];
        }

        foreach ($students as $student) {
            $nameParts = explode(' ', $student['name']);
            $firstName = strtoupper(substr($nameParts[0], 0, 2));
            $lastName = strtoupper(substr($nameParts[1], 0, 2));
            $password = $firstName . $lastName . substr($student['student_id'], -4);

            User::create([
                'name' => $student['name'],
                'email' => $student['student_id'] . '@ub.ac.bw',
                'password' => Hash::make($password),
                'role' => 'student',
                'student_id' => $student['student_id'],
            ]);
        }
    }
}