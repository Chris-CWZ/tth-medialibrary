<?php
/*
    **FOR THIS FILE, SINCE MIGRATIONS ARE TIME-STAMPED, COPYING IT DIRECTLY WILL CAUSE THE FILE NAME TO BE INACCURATE.
    THEREFORE, JUST CREATE THE MIGRATION ON YOUR OWN DEVICE AND THEN COPY THE CONTENTS FROM THIS FILE
    TO YOUR OWN MIGRATION FILE**
*/
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_elements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('parent_id')->nullable();
            $table->string('type')->default('d');
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
        Schema::dropIfExists('file_elements');
    }
}
