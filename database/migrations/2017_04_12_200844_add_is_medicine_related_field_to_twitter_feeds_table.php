<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsMedicineRelatedFieldToTwitterFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('twitter_feeds', function (Blueprint $table) {
            $table->boolean('medicine_related')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('twitter_feeds', function (Blueprint $table) {
            $table->dropColumn('medicine_related');
        });
    }
}
