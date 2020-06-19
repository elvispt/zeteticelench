<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RemoveDefaultOnUpdateOnMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (config('database.default') !== 'sqlite') {
            DB::statement(
                "ALTER TABLE `movements` CHANGE `amount_date` `amount_date` TIMESTAMP NULL DEFAULT NULL;"
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (config('database.default') !== 'sqlite') {
            DB::statement(
                "ALTER TABLE `movements` CHANGE `amount_date` `amount_date` TIMESTAMP on update CURRENT_TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;"
            );
        }
    }
}
