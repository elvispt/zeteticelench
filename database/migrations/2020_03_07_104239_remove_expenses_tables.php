<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RemoveExpensesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('accounts');
        if (Schema::hasColumn('tags', 'type')) {
            if (config('database.default') === 'sqlite') {
                DB::raw(
<<<EOT
create table tags_dg_tmp
(
	id integer not null
		primary key autoincrement,
	tag varchar not null,
	created_at datetime,
	updated_at datetime,
	user_id integer default '0' not null,
	check ("type" in ('NOTE', 'EXPENSE'))
);

insert into tags_dg_tmp(id, tag, created_at, updated_at, user_id) select id, tag, created_at, updated_at, user_id from tags;

drop table tags;

alter table tags_dg_tmp rename to tags;

create unique index tags_tag_unique
	on tags (tag);
EOT
                );
            } else {
                DB::statement(
                    "ALTER TABLE `tags` DROP `type`;"
                );
                
            }
        }
        Schema::dropIfExists('movement_tag');
        Schema::dropIfExists('movements');
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
