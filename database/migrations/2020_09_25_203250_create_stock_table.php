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
            $table->integer('kategori')->unsigned();
            $table->integer('merk')->unsigned(); 
            $table->integer('model')->unsigned();
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
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();

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
