<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Str;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $Conversations = [
            [
                'name' => 'Fortnite Group',
                'uuid' => Str::uuid(),
                'user_id' => 1,
                'product_id' => 1,
            ],

            [
                'name' => 'Pubg Group',
                'uuid' => Str::uuid(),
                'user_id' => 1,
                'product_id' => 1,

            ],

        ];
        DB::table('conversations')->insert($Conversations);

        DB::table('conversation_user')->insert(['conversation_id' => 1, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now(),]);
        DB::table('conversation_user')->insert(['conversation_id' => 2, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now(),]);
        DB::table('conversation_user')->insert(['conversation_id' => 1, 'user_id' => 2, 'created_at' => now(), 'updated_at' => now(),]);
        DB::table('conversation_user')->insert(['conversation_id' => 2, 'user_id' => 2, 'created_at' => now(), 'updated_at' => now(),]);

    }
}
