<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKuponToPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('kode_kupon')->nullable();
            $table->string('jumlah_potongan')->nullable();
            $table->string('harga_setelah_potongan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('kode_kupon');
            $table->dropColumn('jumlah_potongan');
            $table->dropColumn('harga_setelah_potongan');
        });
    }
}
