<?php

use Illuminate\Database\Seeder;

class UsersTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // articlesテーブルにデータをinsert
        DB::table('users')->insert([
            [
                'name' => 'user1',
                'invent_code' => 'user1',
                'thumbnail' => 'user1',
                'api_key' => \App\Models\User::generateApiKey()
            ],
            [
                'name' => 'user2',
                'invent_code' => 'user2',
                'thumbnail' => 'user2',
                'api_key' => \App\Models\User::generateApiKey()
            ],
            [
                'name' => 'user3',
                'invent_code' => 'user3',
                'thumbnail' => 'user3',
                'api_key' => \App\Models\User::generateApiKey()
            ]
        ]);
    }
}
