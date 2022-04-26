<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // FaqSeeder::class,
            // TeamleaderSeeder::class,
            // // UserSeeder::class,
            // PrioritySeeder::class,
            // StatusSeeder::class,
            // TypeSeeder::class,
            ProductSeeder::class
        ]);
    }
}
