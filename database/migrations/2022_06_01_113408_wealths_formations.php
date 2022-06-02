<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WealthsFormations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wealths_formations', function (Blueprint $table) {
            $table->id();
            $table->string('wealth_id');
            $table->foreign('wealth_id')
                ->references('id')
                ->on('wealth') ->onDelete('cascade');
            $table->string('formation_id');
            $table->foreign('formation_id')
                ->references('id')
                ->on('formation') ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wealths_formations');
    }
}
