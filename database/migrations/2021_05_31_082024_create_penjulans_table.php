<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjulansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjulans', function (Blueprint $table) {
            $table->id();
            $table->string('nota');
            $table->date('tanggal');
            $table->string('status');
            $table->integer('qty');
            $table->decimal('pajak',9,2)->nullable();
            $table->integer('diskon')->nullable();
            $table->decimal('subTotal',9,2);
            $table->integer('item_id');
            $table->integer('consumer_id');
            $table->integer('user_id');
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
        Schema::dropIfExists('penjulans');
    }
}
