<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangmasukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangmasuk', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('tgl_pembelian'); 
            $table->mediumInteger('jumlah_barang')->unsigned();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('merk_id'); 
            $table->unsignedBigInteger('models_id');
            $table->string('penjual', 100);
            $table->uuid('uuid');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');     
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')
              ->references('id')->on('category')
              ->onUpdate('cascade')
              ->onDelete('restrict');

            $table->foreign('merk_id')
              ->references('id')->on('merk')
              ->onUpdate('cascade')
              ->onDelete('restrict');

            $table->foreign('models_id')
              ->references('id')->on('models')
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
        Schema::dropIfExists('barangmasuk');
    }
}
