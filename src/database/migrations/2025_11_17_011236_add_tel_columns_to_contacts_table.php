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
        // 念のため、「もしまだ tel カラムがなければ追加する」
        if (!Schema::hasColumn('contacts', 'tel')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->string('tel', 255)->after('email');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // ロールバック時に tel カラムを消す（存在する場合のみ）
        if (Schema::hasColumn('contacts', 'tel')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->dropColumn('tel');
            });
        }
    }
}