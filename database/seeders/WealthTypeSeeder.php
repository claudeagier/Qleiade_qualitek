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
        $fileType = new WealthType();
        $fileType->fill([
            'name' => 'file',
            'label' => 'file',
            'description' => 'the ressource is a file'
        ])->save();
        
        $linktype = new WealthType();
        $linktype->fill([
            'name' => 'link',
            'label' => 'lien',
            'description' => 'the ressource is a link'
        ])->save();

        $linktype = new WealthType();
        $linktype->fill([
            'name' => 'ypareo',
            'label' => 'ypareo',
            'description' => 'the ressource is an ypareo process'
        ])->save();
        
    }
}
