<?php

namespace Database\Seeders;

use Factory\Generator as factory;
use Illuminate\Database\Seeder;
use App\Models\Wealth;

class WealthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // wealthType, processus, careers, actions
        Wealth::factory(10)->create();
    }
}
