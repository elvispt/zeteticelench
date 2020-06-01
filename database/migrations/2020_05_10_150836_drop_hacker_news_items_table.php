<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DropHackerNewsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (config('database.default') === 'sqlite') {
            Schema::create(
                'hacker_news_items_bookmarks_tmp',
                function (Blueprint $table) {
                    $table->bigIncrements('id');
                    $table->unsignedBigInteger('hacker_news_item_id');
                    $table->unsignedBigInteger('user_id');
                    $table->timestampsTz();

                    $table
                        ->foreign('user_id')
                        ->references('id')->on('users')
                        ->onDelete('CASCADE')
                        ->onUpdate('no action')
                    ;
                });
            DB::raw("insert into hacker_news_items_bookmarks_tmp(id, hacker_news_item_id, user_id, created_at, updated_at) select id, hacker_news_item_id, user_id, created_at, updated_at from hacker_news_items_bookmarks;");
            Schema::dropIfExists('hacker_news_items_bookmarks');
            Schema::rename('hacker_news_items_bookmarks_tmp', 'hacker_news_items_bookmarks');
        } else {
            Schema::table('hacker_news_items_bookmarks', function (Blueprint $table) {
                $table->dropForeign('hacker_news_items_bookmarks_hacker_news_item_id_foreign');
            });
        }

        Schema::dropIfExists('hacker_news_items');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // data deleted. No rollback. Need a full rebuild along with models.
    }
}
