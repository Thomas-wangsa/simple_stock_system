<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');     
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('category');
    }
}
