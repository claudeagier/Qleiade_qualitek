<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWealthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wealth', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('wealth_type_id');
            $table->foreign('wealth_type_id')->references('id')->on('wealth_type');
            $table->bigInteger('processus_id');
            $table->foreign('processus_id')->references('id')->on('processus');
            $table->string('name');
            $table->string('description', 1500)
                ->nullable();
            $table->string('tracking', 1500)
                ->nullable();
            $table->unsignedTinyInteger('conformity_level')
                ->nullable();
            $table->dateTime('validity_date')
                ->nullable();
            $table->jsonb('attachment')->nullable();
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
        Schema::dropIfExists('wealth');
    }
}
