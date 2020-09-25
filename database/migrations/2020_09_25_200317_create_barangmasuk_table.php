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
            $table->integer('kategori')->unsigned();
            $table->integer('merk')->unsigned(); 
            $table->integer('model')->unsigned();
            $table->string('penjual', 100);
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
        Schema::dropIfExists('barangmasuk');
    }
}
