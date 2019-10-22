<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTwitterFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twitter_feeds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('twitter_id');
            $table->text('body');
            $table->string('media')->nullable();
            $table->string('user_id');
            $table->string('author_name');
            $table->string('author_screen_name');
            $table->boolean('author_verified');
            $table->timestamp('twitter_timestamp');
            $table->json('tags');
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
        Schema::dropIfExists('twitter_feeds');
    }
}
