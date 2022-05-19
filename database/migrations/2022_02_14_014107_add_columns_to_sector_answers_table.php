<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSectorAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sector_answers', function (Blueprint $table) {
            $table->unsignedBigInteger('analysis_id')->after('id');
            $table->foreign('analysis_id')->references('id')->on('analyses');
            $table->unsignedBigInteger('sector_id')->after('analysis_id');
            $table->foreign('sector_id')->references('id')->on('sectors');
            $table->integer('gin')->after('sector_id');
            $table->integer('gcn')->after('gin');
            $table->json('answers')->after('gcn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sector_answers', function (Blueprint $table) {
            $table->dropForeign(['analysis_id']);
            $table->dropColumn('analysis_id');
            $table->dropForeign(['sector_id']);
            $table->dropColumn('sector_id');
            $table->dropColumn('gin');
            $table->dropColumn('gcn');
            $table->dropColumn('answers');
        });
    }
}
