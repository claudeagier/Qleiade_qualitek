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
        QualityLabel::factory(2)->create()->each(function($qualityLabel){
            $qualityLabel->indicators()->saveMany(Indicator::factory(10)->make(['quality_label_id'=>$qualityLabel->id]));
        });
    }
}
