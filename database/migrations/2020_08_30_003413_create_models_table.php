<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('merk_id');
            $table->string('name');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');     
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['merk_id','name']);

            $table->foreign('merk_id')
              ->references('id')->on('merk')
              ->onUpdate('cascade')
              ->onDelete('restrict');

            $table->foreign('created_by')
              ->references('id')->on('users')
              ->onUpdate('cascade')
              ->onDelete('restrict');

            $table->foreign('updated_by')
              ->references('id')->on('users')
              ->onUpdate('cascade')
              ->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('models');
    }
}
