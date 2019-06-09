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
        Schema::table('tags', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')
                  ->after('id');
        });
        if (!$this->isTableEmpty()) {
            $user = User::first();
            if (!$user) {
                $user = new User();
                $user->name = "Ghost";
                $user->email = "ghost@example.com";
                $user->password = Hash::make(123);
                $user->save();
            }
            $userId = $user->id;
            Tag::All()->each(function (Tag $tag) use ($userId) {
                $tag->user_id = $userId;
                $tag->save();
            });
        }

        Schema::table('tags', function (Blueprint $table) {
            $table
                ->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action')
            ;
        });
    }

    protected function isTableEmpty()
    {
        return is_null(Tag::first());
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
