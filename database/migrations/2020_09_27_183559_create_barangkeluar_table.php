<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangkeluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangkeluar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('tgl_penjualan'); 
            $table->mediumInteger('jumlah_barang')->unsigned();
            $table->string('pembeli', 100);
            $table->string('no_hp_pembeli', 100);
            $table->mediumInteger('durasi_garansi')->unsigned();
            $table->mediumInteger('total_harga')->unsigned();
            $table->uuid('uuid');
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
        Schema::dropIfExists('barangkeluar');
    }
}
