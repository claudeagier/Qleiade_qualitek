<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Processus;

class ProcessusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Processus::factory(5)->create();
    }
}
