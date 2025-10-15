<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\packageInclusion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Generate 30 random packages
        for ($i = 1; $i <= 30; $i++) {

            // Create a random package
            $package = Package::create([
                'pkg_name' => ucfirst($faker->words(3, true)) . ' Package', // e.g. "Golden Sunset Package"
            ]);

            // Create 2–6 random inclusions for each package
            $inclusionCount = rand(2, 6);
            for ($j = 1; $j <= $inclusionCount; $j++) {
                packageInclusion::create([
                    'pkg_inclusion' => ucfirst($faker->sentence(rand(2, 4))), // e.g. "Professional embalming service"
                    'package_id' => $package->id,
                ]);
            }
        }
    }
}
