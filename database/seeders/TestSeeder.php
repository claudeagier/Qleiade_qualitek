<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(StageSeeder::class);
        $this->call(WealthTypeSeeder::class);
        $this->call(QualitylabelSeeder::class);
        $this->call(ProcessusSeeder::class);
        $this->call(CareerSeeder::class);
    }
}
