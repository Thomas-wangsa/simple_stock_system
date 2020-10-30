<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('merk_id');
            $table->string('name');
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');     
            $table->timestamps();
            $table->softDeletes();

            $table->unique('merk_id','name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model');
    }
}
