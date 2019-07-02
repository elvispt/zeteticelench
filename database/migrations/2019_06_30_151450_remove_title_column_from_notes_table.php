<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveTitleColumnFromNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropColumn('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notes', function (Blueprint $table) {
            $table
                ->string('title', 50)
                ->after('user_id')
            ;
        });
    }
}
