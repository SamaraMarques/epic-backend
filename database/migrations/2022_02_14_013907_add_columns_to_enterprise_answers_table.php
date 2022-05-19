<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToEnterpriseAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enterprise_answers', function (Blueprint $table) {
            $table->unsignedBigInteger('analysis_id')->after('id');
            $table->foreign('analysis_id')->references('id')->on('analyses');
            $table->unsignedBigInteger('enterprise_id')->after('analysis_id');
            $table->foreign('enterprise_id')->references('id')->on('enterprises');
            $table->json('answers')->after('enterprise_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enterprise_answers', function (Blueprint $table) {
            $table->dropForeign(['analysis_id']);
            $table->dropColumn('analysis_id');
            $table->dropForeign(['enterprise_id']);
            $table->dropColumn('enterprise_id');
            $table->dropColumn('answers');
        });
    }
}
