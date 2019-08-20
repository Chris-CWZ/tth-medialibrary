<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->string('session_id')->nullable();
            $table->enum('payment_method', ['paypal', 'fpx']);
            $table->string('transaction_id')->unique();
            $table->float('sub_total', 8, 2);
            $table->float('grand_total', 8, 2);
            $table->enum('status', ['processing', 'shipped', 'completed']);
            $table->string('promo_code')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
