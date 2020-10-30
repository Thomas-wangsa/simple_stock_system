<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('merk_id'); 
            $table->unsignedBigInteger('models_id');
            $table->integer('status')->unsigned();
            $table->string('penjual', 100);
            $table->date('tgl_pembelian'); 
            $table->string('uuid_barang_masuk', 100);

            $table->string('pembeli', 100)->nullable();
            $table->string('no_hp_pembeli', 100)->nullable();
            $table->date('tgl_penjualan')->nullable();
            $table->mediumInteger('durasi_garansi')->unsigned()->nullable();
            $table->mediumInteger('harga_jual')->unsigned()->nullable(); 
            $table->string('uuid_barang_keluar', 100)->nullable();


            $table->uuid('uuid');
            $table->string('barcode', 100);
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
        Schema::dropIfExists('stock');
    }
}
