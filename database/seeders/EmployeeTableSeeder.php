<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EmployeeTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('uk_UA');
        $employees = [];

        for ($i = 1; $i <= 5; $i++) {
            $surname = $faker->lastName;
            $name = $faker->firstName;
            $patronymic = $faker->middleName ?? $faker->firstName . 'ович'; // Fallback for older faker versions

            $employees[] = [
                'employee_id' => $i,
                'employee_name' => "$surname $name $patronymic"
            ];
        }

        DB::table('employee')->insert($employees);
    }
}
