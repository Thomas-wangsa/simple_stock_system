<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_rule', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rule_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('rule_id')
              ->references('id')->on('rule')
              ->onUpdate('cascade')
              ->onDelete('restrict');

            $table->foreign('user_id')
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
        Schema::dropIfExists('user_rule');
    }
}
