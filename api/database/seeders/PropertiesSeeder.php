<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertiesSeeder extends Seeder
{
    const TOTAL_ROWS = 100000;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $batchSize = 1000;
        $faker = Factory::create();

        $this->command->info("Seeding" . self::TOTAL_ROWS . "rows into the 'properties' table...");

        for ($i = 0; $i < self::TOTAL_ROWS / $batchSize; $i++) {
            $data = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $data[] = [
                    'name' => $faker->sentence(3),
                    'price' => $faker->numberBetween(10000000, 100000000),
                    'bedrooms' => $faker->numberBetween(1, 10),
                    'bathrooms' => $faker->numberBetween(1, 5),
                    'storeys' => $faker->numberBetween(1, 5),
                    'garages' => $faker->numberBetween(0, 3),
                ];
            }

            DB::table('properties')->insert($data);

            $this->command->info("Inserted batch " . ($i + 1) . " of " . (self::TOTAL_ROWS / $batchSize));
        }

        $this->command->info("Seeding completed.");
    }
}
