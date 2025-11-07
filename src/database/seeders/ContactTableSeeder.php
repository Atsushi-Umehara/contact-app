<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [
                'category_id' => 1, //資料請求
                'first_name' => '一郎',
                'last_name' => '山田',
                'gender' => 1,
                'email' => 'ichiro@example.com',
                'tel' => '090-1234-5678',
                'address' => '京都府福知山市土師新町１',
                'building' => 'サンプルマンション101',
                'detail' => '資料請求をお願いします。',
            ],
            [
                'category_id' => 2, //体験希望
                'first_name' => '花子',
                'last_name' => '佐藤',
                'gender' => 2,
                'email' => 'hanako@example.com',
                'tel' => '080-1234-5678',
                'address' => '京都府福知山市土師新町2',
                'building' => 'サンプルマンション202',
                'detail' => '体験を希望します。',
            ]
        ];
        DB::table('contacts')->insert($rows);
        //
    }
}
