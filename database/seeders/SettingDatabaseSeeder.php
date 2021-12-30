<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $settings = [
            [
                'key' => 'commission',
                'value' => 3
            ],

            [
                'key' => 'ad_fixed_price',
                'value' => 25
            ],

            [
                'key' => 'ad_auction_price',
                'value' => 18
            ],

            [
                'key' => 'min_amount',
                'value' => 3
            ],
            [
                'key' => 'withdraw_min',
                'value' => 3
            ],
            [
                'key' => 'slider_images',
                'value' => '[]'
            ]
        ];

        DB::table('settings')->insert($settings);
    }
}
