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
        $type = new WealthType();
        $type->fill([
            'name' => 'file',
            'label' => 'file',
            'description' => 'the ressource is a file'
        ])->save();

        
        WealthType::factory(10)->create();
    }
}
