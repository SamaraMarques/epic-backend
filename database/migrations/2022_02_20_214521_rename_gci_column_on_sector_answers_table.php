<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameGciColumnOnSectorAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sector_answers', function (Blueprint $table) {
            $table->dropColumn('gcn');
            $table->integer('gci')->after('gin');
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
            $table->dropColumn('gci');
            $table->integer('gcn')->after('gin');
        });
    }
}
