<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->enum('type', ['percentage', 'fixed', 'bundled']);
            $table->dateTime('start_date');
            $table->dateTime('expiry_date');
            $table->float('discount_percentage', 3, 2)->nullable();
            $table->float('discount_amount', 8, 2)->nullable();
            $table->float('cap_amount', 8, 2)->nullable();
            $table->float('min_spending', 8, 2)->nullable();
            $table->integer('usage_limit')->nullable();
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
        Schema::dropIfExists('promotions');
    }
}
