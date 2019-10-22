<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHtmlFieldsToCodesDatasetsThreadsRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('datasets', function (Blueprint $table) {
            $table->text('description_html')->nullable()->after('description');
        });

        Schema::table('codes', function (Blueprint $table) {
            $table->text('description_html')->nullable()->after('description');
        });

        Schema::table('threads', function (Blueprint $table) {
            $table->text('body_html')->nullable()->after('body');
        });

        Schema::table('replies', function (Blueprint $table) {
            $table->text('body_html')->nullable()->after('body');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('datasets', function (Blueprint $table) {
            $table->dropColumn('description_html');
        });

        Schema::table('codes', function (Blueprint $table) {
            $table->dropColumn('description_html');
        });

        Schema::table('threads', function (Blueprint $table) {
            $table->dropColumn('body_html');
        });

        Schema::table('replies', function (Blueprint $table) {
            $table->dropColumn('body_html');
        });
    }
}
