<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHackerNewsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hacker_news_items', function (Blueprint $table) {
            $table->unsignedBigInteger('id')
                ->primary();
            $table
                ->string('type', 10)
                ->comment('The type of item. One of "job", "story", "comment", "poll", or "pollopt".')
                ->index()
            ;
            $table
                ->unsignedBigInteger('parent_id')
                ->comment("The comment's parent: either another comment or the relevant story.")
                ->index()
                ->nullable()
            ;
            $table
                ->string('by', 255)
                ->comment("The username of the item's author.")
                ->nullable()
            ;
            $table
                ->smallInteger('score')
                ->comment("The story's score, or the votes for a pollopt.")
                ->default(0)
            ;
            $table
                ->unsignedSmallInteger('descendants')
                ->comment("In the case of stories or polls, the total comment count.")
                ->default(0)
            ;
            $table
                ->string('title', 1000)
                ->comment("The title of the story, poll or job.")
                ->nullable()
            ;
            $table
                ->text('text')
                ->comment("The comment, story or poll text. HTML.")
                ->nullable()
            ;
            $table->string('url', 1000)
                ->comment("The URL of the story.")
                ->nullable()
            ;
            $table
                ->json('kids')
                ->comment("The ids of the item's comments, in ranked display order.")
                ->nullable()
            ;
            $table
                ->boolean('dead')
                ->comment("true if the item is dead.")
                ->default(0)
            ;
            $table->softDeletesTz();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hacker_news_items');
    }
}
