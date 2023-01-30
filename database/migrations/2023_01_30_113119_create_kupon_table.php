<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kupon', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kupon');
            $table->string('jumlah_kupon');
            $table->string('tipe_kupon');
            $table->string('event_id')->nullable();
            $table->string('kode_kupon')->nullable();
            $table->string('tipe_potongan');
            $table->string('value');
            $table->date('kadaluarsa');
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
        Schema::dropIfExists('kupon');
    }
}
