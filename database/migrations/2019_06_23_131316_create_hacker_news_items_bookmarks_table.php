<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHackerNewsItemsBookmarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'hacker_news_items_bookmarks',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('hacker_news_item_id');
                $table->unsignedBigInteger('user_id');
                $table->timestampsTz();

                $table
                    ->foreign('hacker_news_item_id')
                    ->references('id')->on('hacker_news_items')
                    ->onDelete('CASCADE')
                    ->onUpdate('no action')
                ;

                $table
                    ->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('CASCADE')
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
        Schema::dropIfExists('hacker_news_items_bookmarks');
    }
}
