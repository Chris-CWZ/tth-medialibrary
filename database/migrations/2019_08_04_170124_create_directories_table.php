<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Remove nullable fields after testing
        Schema::create('directories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('icon')->nullable();
            $table->enum('category', ['museum', 'dining']);
            $table->string('name');
            $table->string('phone_number')->nullable();
            $table->string('location');
            $table->string('level');
            $table->longtext('description');
            $table->string('location_image')->nullable();
            $table->string('website');
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
        Schema::dropIfExists('directories');
    }
}
