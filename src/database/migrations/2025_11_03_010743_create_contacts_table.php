<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id(); // bigint unsigned, PRIMARY KEY
            $table->unsignedBigInteger('category_id'); // bigint unsigned, NOT NULL
            $table->string('first_name', 255); // varchar(255), NOT NULL
            $table->string('last_name', 255);  // varchar(255), NOT NULL
            $table->tinyInteger('gender'); // tinyint, NOT NULL（1:男性 2:女性 3:その他）
            $table->string('email', 255); // varchar(255), NOT NULL
            $table->string('tel', 255);   // varchar(255), NOT NULL
            $table->string('address', 255); // varchar(255), NOT NULL
            $table->string('building', 255)->nullable(); // varchar(255), NULL可
            $table->text('detail')->nullable(); // text, NULL可
            $table->timestamps(); // created_at, updated_at
        });


        // 外部キー制約
        Schema::table('contacts', function (Blueprint $table) {
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
