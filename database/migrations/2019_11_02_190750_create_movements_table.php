<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedSmallInteger('account_id');
            $table->decimal('amount', 10, 2);
            $table
                ->string('description', 1000)
                ->nullable()
            ;
            $table->softDeletesTz();
            $table->timestampsTz();

            $table
                ->foreign('account_id')
                ->references('id')->on('accounts')
                ->onDelete('no action')
                ->onUpdate('no action')
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
        Schema::dropIfExists('movements');
    }
}
