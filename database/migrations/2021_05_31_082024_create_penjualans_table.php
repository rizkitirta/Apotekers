<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('kwitansi');
            $table->date('tanggal');
            $table->string('status')->nullable();
            $table->integer('qty');
            $table->integer('harga');
            $table->decimal('pajak',9,2)->nullable();
            $table->integer('diskon')->nullable();
            $table->decimal('sub_total',9,2);
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('obats')->cascadeOnDelete();
            $table->unsignedBigInteger('consumer_id');
            $table->foreign('consumer_id')->references('id')->on('pasiens')->cascadeOnDelete();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
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
        Schema::dropIfExists('penjualans');
    }
}
