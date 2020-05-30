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
           DB::raw(
<<<EOT
create table hacker_news_items_bookmarks_dg_tmp
(
	id integer not null
		primary key autoincrement,
	hacker_news_item_id integer not null,
	user_id integer not null
		references users
			on delete cascade,
	created_at datetime,
	updated_at datetime
);

insert into hacker_news_items_bookmarks_dg_tmp(id, hacker_news_item_id, user_id, created_at, updated_at) select id, hacker_news_item_id, user_id, created_at, updated_at from hacker_news_items_bookmarks;

drop table hacker_news_items_bookmarks;

alter table hacker_news_items_bookmarks_dg_tmp rename to hacker_news_items_bookmarks;
EOT
           );
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
