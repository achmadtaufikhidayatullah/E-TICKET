<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKuponToEventBacthesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_batches', function (Blueprint $table) {
            $table->string('kupon_status')->nullable();
            $table->string('kupon_aktif')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_batches', function (Blueprint $table) {
            $table->dropColumn('kupon_aktif');
        });
    }
}
