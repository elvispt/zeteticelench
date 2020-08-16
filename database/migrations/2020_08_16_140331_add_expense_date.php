<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Expense;

class AddExpenseDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('expenses', function (Blueprint $table) {
            $table
                ->timestampTz('transaction_date')
                ->after('amount')
                ->nullable()
            ;
        });

        Expense::all()->each(static function (Expense $expense) {
            $expense->transaction_date = $expense->updated_at;
            $expense->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('transaction_date');
        });
    }
}
