<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClientTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('transaction_id');
            $table->text('reference_id');
            $table->double('amount');
            $table->string('gateway');
            $table->integer('status');
            $table->date('payment_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_transactions');
    }
}
