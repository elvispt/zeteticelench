<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovementTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movement_tag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('movement_id');
            $table->unsignedBigInteger('tag_id');

            $table
                ->foreign('movement_id')
                ->references('id')->on('movements')
                ->onDelete('cascade')
            ;
            $table
                ->foreign('tag_id')
                ->references('id')->on('tags')
                ->onDelete('cascade')
            ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movement_tag');
    }
}
