<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRedeemedByAndRedeemDateFieldsToBookedTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booked_tickets', function (Blueprint $table) {
            $table->foreignId('redeemed_by')->nullable()->after('status')->constrained('users');
            $table->datetime('redeem_date')->nullable()->after('redeemed_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booked_tickets', function (Blueprint $table) {
            $table->dropForeign(['redeemed_by']);
            $table->dropColumn(['redeemed_by', 'redeem_date']);
        });
    }
}
