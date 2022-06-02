<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWealthsCareersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wealths_careers', function (Blueprint $table) {
            $table->id();
            $table->string('wealth_id');
            $table->foreign('wealth_id')
                ->references('id')
                ->on('wealth') ->onDelete('cascade');
            $table->string('career_id');
            $table->foreign('career_id')
                ->references('id')
                ->on('career') ->onDelete('cascade');
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
        Schema::dropIfExists('wealths_careers');
    }
}
