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
        // \App\Models\User::factory(10)->create();
        $this->call(StageSeeder::class);
        $this->call(WealthTypeSeeder::class);
        $this->call(QualityLabelSeeder::class);
        $this->call(ProcessusSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(IndicatorSeeder::class);
    }
}
