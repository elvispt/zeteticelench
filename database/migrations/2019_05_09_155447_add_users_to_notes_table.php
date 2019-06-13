<?php

use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersToNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function up()
    {
        Schema::table('notes', function (Blueprint $table) {
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
            Note::withTrashed()->get()->each(function (Note $note) use ($userId) {
                $note->user_id = $userId;
                $note->save();
            });
        }

        Schema::table('notes', function (Blueprint $table) {
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
        return is_null(Note::withTrashed()->first());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
