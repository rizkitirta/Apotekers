<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApotiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apotiks', function (Blueprint $table) {
            $table->id();
            $table->string('nama',255);
            $table->string('direktur',255);
            $table->string('telp',255);
            $table->string('email',255);
            $table->string('rekening',255);
            $table->text('alamat');
            $table->decimal('balance', 9,2)->nullable();
            $table->text('logo')->nullable();
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
        Schema::dropIfExists('apotiks');
    }
}
