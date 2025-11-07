<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
                ['content' => '資料請求'],
                ['content' => '体験希望'],
                ['content' => '入会希望'],
                ['content' => '休会希望'],
                ['content' => '退会希望'],
        ]);
    }
}
