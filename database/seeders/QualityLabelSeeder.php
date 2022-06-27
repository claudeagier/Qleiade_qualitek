<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QualityLabel;
use App\Models\Indicator;

class QualityLabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QualityLabel::create([
            "name" => "qualiopi",
            "label" => "Qualiopi",
        ]);
    }
}
