<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTelColumnsToContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('tel1', 5)->nullable();
            $table->string('tel2', 5)->nullable();
            $table->string('tel3', 5)->nullable();

            if (Schema::hasColumn('contacts', 'tel')) {
                $table->dropColumn('tel');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('tel')->nullable();
            $table->dropColumn(['tel1','tel2','tel3']);
        });
    }
}
