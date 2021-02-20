<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->decimal('value', 10, 2);
            $table->integer('payer_id');
            $table->integer('payee_id');
            $table->timestamps();


            $table->foreign('payer_id')
            ->references('id')
            ->on('accounts');
            $table->foreign('payee_id')
            ->references('id')
            ->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
