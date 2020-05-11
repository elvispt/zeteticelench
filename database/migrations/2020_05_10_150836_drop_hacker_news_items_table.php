<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::table('hacker_news_items_bookmarks', function (Blueprint $table) {
            $table->dropForeign('hacker_news_items_bookmarks_hacker_news_item_id_foreign');
        });

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
