<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 30; $i++) {
            Supplier::create([
                'fname' => $faker->firstName,
                'mname' => $faker->randomElement(['A.', 'B.', 'C.', 'D.', 'E.', null]),
                'lname' => $faker->lastName,
                'contact_number' => '09' . $faker->numberBetween(100000000, 999999999),
                'company_name' => $faker->company,
                'company_address' => $faker->address,
            ]);
        }

    }
}
