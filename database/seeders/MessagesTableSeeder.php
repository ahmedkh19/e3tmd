<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Setting;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Str;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create();

        for ( $s = 1; $s <= 2; $s++ ) {
            $conversation = Conversation::whereId($s)->with('users')->first();
            for ( $i = 1; $i <= 2; $i++ ) {

                Message::create([
                    'conversation_id' => $conversation->id,
                    'user_id' => $conversation->users->random()->id,
                    'body' => $faker->sentence,
                ]);

                Conversation::whereId($s)->update(['last_message_at' => now()]);
            }

        }
    }
}
