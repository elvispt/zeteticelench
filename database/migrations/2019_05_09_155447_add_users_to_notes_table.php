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
        $user = User::first();
        if (!$user) {
            throw new Exception('A user must exist on users table.');
        }
        $userId = $user->id;

        Schema::table('notes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')
                ->after('id');
        });

        Note::withTrashed()->get()->each(function (Note $note) use ($userId) {
            $note->user_id = $userId;
            $note->save();
        });

        Schema::table('notes', function (Blueprint $table) use ($userId) {
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
        Schema::table('notes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
