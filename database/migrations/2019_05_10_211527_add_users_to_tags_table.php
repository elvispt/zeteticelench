<?php

use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsersToTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function up()
    {
        $user = User::first();
        if (!$user) {
            throw new Exception('A user must exist on users table.');
        }
        $userId = $user->id;
        Schema::table('tags', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')
                  ->after('id');
        });

        Tag::All()->each(function (Tag $tag) use ($userId) {
            $tag->user_id = $userId;
            $tag->save();
        });

        Schema::table('tags', function (Blueprint $table) use ($userId) {
            $table
                ->foreign('user_id')
                ->references('id')->on('users')
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
        Schema::table('tags', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
