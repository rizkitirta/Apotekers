<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 55);
            $table->string('kode', 55);
            $table->string('dosis', 55);
            $table->string('indikasi', 55);
            $table->unsignedBigInteger('kategori_id');
            $table->foreign('kategori')->references('id')->on('kategoris')->onDelete('cascade');
            $table->unsignedBigInteger('satuan_id');
            $table->foreign('satuan')->references('id')->on('satuans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obats');
    }
}
