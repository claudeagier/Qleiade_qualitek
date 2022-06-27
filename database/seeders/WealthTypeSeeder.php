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
        WealthType::create([
            'name' => 'file',
            'label' => 'file',
            'description' => 'the ressource is a file'
        ]);
        
        WealthType::create([
            'name' => 'link',
            'label' => 'lien',
            'description' => 'the ressource is a link'
        ]);

        WealthType::create([
            'name' => 'ypareo',
            'label' => 'ypareo',
            'description' => 'the ressource is an ypareo process'
        ]);
        
    }
}
