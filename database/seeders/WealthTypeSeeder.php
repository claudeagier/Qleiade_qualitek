<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WealthType;

class WealthTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WealthType::factory(10)->create();
    }
}
