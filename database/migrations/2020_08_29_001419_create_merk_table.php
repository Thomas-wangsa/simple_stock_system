<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merk', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->string('name');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');     
            $table->timestamps();
            $table->softDeletes();


            $table->unique(['category_id','name']);

            $table->foreign('category_id')
              ->references('id')->on('category')
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
        Schema::dropIfExists('merk');
    }
}
