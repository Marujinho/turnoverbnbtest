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

            $table->unsignedBigInteger('bank_id');
            $table->foreign('bank_id')->references('id')->on('banks');

            $table->unsignedBigInteger('bank_user_id');
            $table->foreign('bank_user_id')->references('id')->on('bank_user');

            $table->string('type');
            $table->string('check')->nullable();
            $table->string('description');
            $table->decimal('amount', 8, 2);
            $table->decimal('customer_current_balance', 8, 2);
            $table->string('authorization_status');

            $table->timestamps();
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
