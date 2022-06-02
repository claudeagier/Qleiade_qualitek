<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stage;
use App\Models\Action;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Stage::factory(3)->create()->each(function($stage){
            $stage->actions()->saveMany(Action::factory(10)->make(['stage_id'=>$stage->id]));
        });
    }
}
