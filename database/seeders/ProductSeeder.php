<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\Setting;
use Hamcrest\Core\Set;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* ******************************************** */
        Product::create([
            'user_id' => 1,
            'slug' => 'pubg-awesome-account',
            'pricing_method' => 'Fixed',
            'price' => '15.0000',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630445284.png',
            'os' => 's',
            'account_username' => 'pubggy',
            'account_email' => 'pubggy@gmail.com',
            'account_email_website' => 'https://emea.battlegrounds.pubg.com/en/',
            'account_password' => ''
        ])->categories()->attach([1,4]);
        ProductTranslation::create([
            'product_id' => 1,
            'locale' => 'ar',
            'name' => 'حساب ببحي رائع',
            'short_description' => 'حساب ببجي رائع بسكينات خرافية',
            'description' => 'حساب ببجي رائع بسكينات خرافية حساب ببجي رائع بسكينات خرافية حساب ببجي رائع بسكينات خرافية حساب ببجي رائع بسكينات خرافية'
        ]);
        ProductTranslation::create([
            'product_id' => 1,
            'locale' => 'en',
            'name' => 'PUBG Awesome Account',
            'short_description' => 'Amazing PUBG Account, with wonderful Skins',
            'description' => 'Amazing PUBG Account, with wonderful Skins Amazing PUBG Account, with wonderful Skins Amazing PUBG Account, with wonderful Skins Amazing PUBG Account, with wonderful Skins'
        ]);

        Product::create([
            'user_id' => 1,
            'slug' => 'fortnite-account',
            'pricing_method' => 'Fixed',
            'price' => '12.0000',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630442334.png',
            'account_username' => 'fortyforty',
            'account_email' => 'forty@gmail.com',
            'account_email_website' => 'https://www.epicgames.com',
            'account_password' => ''
        ])->categories()->attach([2,4]);
        ProductTranslation::create([
            'product_id' => 2,
            'locale' => 'ar',
            'name' => 'حساب فورتنايت',
            'short_description' => 'حساب فورتنايت رائع مع اسكنات خرافية',
            'description' => 'حساب فورتنايت رائع مع اسكنات خرافية حساب فورتنايت رائع مع اسكنات خرافية حساب فورتنايت رائع مع اسكنات خرافية حساب فورتنايت رائع مع اسكنات خرافية',
        ]);
        ProductTranslation::create([
            'product_id' => 2,
            'locale' => 'en',
            'name' => 'Fortnite Account',
            'short_description' => 'Amazing Forntnite Account with Awesome Skins',
            'description' => 'Amazing Forntnite Account with Awesome Skins Amazing Forntnite Account with Awesome Skins Amazing Forntnite Account with Awesome Skins Amazing Forntnite Account with Awesome Skins'
        ]);

        Product::create([
            'user_id' => 1,
            'slug' => 'minecraft-account',
            'pricing_method' => 'Fixed',
            'price' => '7.5000',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630444565.jpg',
            'isPaid' => 1,
            'account_username' => 'minimini',
            'account_email' => 'minimini@gmail.com',
            'account_email_website' => 'https://www.minecraft.net',
            'account_password' => ''
        ])->categories()->attach([2]);
        ProductTranslation::create([
            'product_id' => 3,
            'locale' => 'ar',
            'name' => 'حساب ماين كرافت',
            'short_description' => 'حساب ماينكرافت رائع مع اسكنات خرافية',
            'description' => 'حساب ماينكرافت رائع مع اسكنات خرافية حساب ماينكرافت رائع مع اسكنات خرافية حساب ماينكرافت رائع مع اسكنات خرافية حساب ماينكرافت رائع مع اسكنات خرافية',
        ]);
        ProductTranslation::create([
            'product_id' => 3,
            'locale' => 'en',
            'name' => 'MineCraft Account',
            'short_description' => 'Amazing MineCraft Account with Awesome Skins',
            'description' => 'Amazing MineCraft Account with Awesome Skins Amazing MineCraft Account with Awesome Skins Amazing MineCraft Account with Awesome Skins Amazing MineCraft Account with Awesome Skins'
        ]);

        Product::create([
            'user_id' => 1,
            'slug' => 'cod',
            'pricing_method' => 'Fixed',
            'price' => '12.9900',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630447842.jpg',
            'os' => 'p',
            'account_username' => 'cod',
            'account_email' => 'cod@gmail.com',
            'account_email_website' => 'https://www.callofduty.com',
            'account_password' => ''
        ])->categories()->attach([1,6]);
        ProductTranslation::create([
            'product_id' => 4,
            'locale' => 'ar',
            'name' => 'كول اوف ديوتي',
            'short_description' => 'حساب كول اوف ديوتي رائع',
            'description' => 'حساب كول اوف ديوتي رائع حساب كول اوف ديوتي رائع حساب كول اوف ديوتي رائع حساب كول اوف ديوتي رائع حساب كول اوف ديوتي رائع',
        ]);
        ProductTranslation::create([
            'product_id' => 4,
            'locale' => 'en',
            'name' => 'Call Of Duty',
            'short_description' => 'Amazing Call Of Duty Account',
            'description' => 'Amazing Call Of Duty Account Amazing Call Of Duty Account Amazing Call Of Duty Account Amazing Call Of Duty Account Amazing Call Of Duty Account'
        ]);

        Product::create([
            'user_id' => 1,
            'slug' => 'ldoemobile',
            'pricing_method' => 'Fixed',
            'price' => '8.0000',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630445287.jpg',
            'account_username' => 'ldoe',
            'os' => 's',
            'account_email' => 'ldoemobile@gmail.com',
            'account_email_website' => 'https://play.google.com/store/apps/details?id=zombie.survival.craft.z&hl=ar&gl=US',
            'account_password' => ''
        ])->categories()->attach([2,3,4]);
        ProductTranslation::create([
            'product_id' => 5,
            'locale' => 'ar',
            'name' => 'آخر يوم علي الارض - حساب موبايل',
            'short_description' => 'لعبة رائعة للموبايل حساب جميل',
            'description' => 'لعبة رائعة للموبايل حساب جميل لعبة رائعة للموبايل حساب جميل لعبة رائعة للموبايل حساب جميل لعبة رائعة للموبايل حساب جميل',
        ]);
        ProductTranslation::create([
            'product_id' => 5,
            'locale' => 'en',
            'name' => 'Last Day on the Earth - Mobile Account',
            'short_description' => 'Amazing Game for mobiles ios and android',
            'description' => 'Amazing Game for mobiles ios and android Amazing Game for mobiles ios and android Amazing Game for mobiles ios and android Amazing Game for mobiles ios and android'
        ]);

        Product::create([
            'user_id' => 1,
            'slug' => 'clash-royale',
            'pricing_method' => 'Fixed',
            'price' => '3.0000',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630556484.jpg',
            'os' => 'x',
            'account_username' => 'clashyman',
            'account_email' => 'clashyman@gmail.com',
            'account_email_website' => 'https://play.google.com/store/apps/details?id=com.supercell.clashroyale&hl=ar&gl=US',
            'account_password' => ''
        ])->categories()->attach([2]);
        ProductTranslation::create([
            'product_id' => 6,
            'locale' => 'ar',
            'name' => 'لعبة كلاش رويال حساب قديم',
            'short_description' => '',
            'description' => 'لعبة كلاش رويال حساب قديم لعبة كلاش رويال حساب قديم لعبة كلاش رويال حساب قديم',
        ]);
        ProductTranslation::create([
            'product_id' => 6,
            'locale' => 'en',
            'name' => 'Clash Royale',
            'short_description' => '',
            'description' => 'Clash Royale Clash Royale Clash Royale Clash Royale'
        ]);

        Product::create([
            'user_id' => 1,
            'slug' => 'pubg-awesome-account-2',
            'pricing_method' => 'Fixed',
            'price' => '8.0000',
            'isPaid' => 1,
            'os' => 'px',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630445284.png',
            'account_username' => 'pubggy2',
            'account_email' => 'pubggy2@gmail.com',
            'account_email_website' => 'https://emea.battlegrounds.pubg.com/en/',
            'account_password' => ''
        ])->categories()->attach([1,4]);
        ProductTranslation::create([
            'product_id' => 7,
            'locale' => 'ar',
            'name' => ' 2 حساب ببحي رائع',
            'short_description' => 'حساب ببجي رائع بسكينات خرافية',
            'description' => 'حساب ببجي رائع بسكينات خرافية حساب ببجي رائع بسكينات خرافية حساب ببجي رائع بسكينات خرافية حساب ببجي رائع بسكينات خرافية'
        ]);
        ProductTranslation::create([
            'product_id' => 7,
            'locale' => 'en',
            'name' => 'PUBG Awesome Account 2',
            'short_description' => 'Amazing PUBG Account, with wonderful Skins',
            'description' => 'Amazing PUBG Account, with wonderful Skins Amazing PUBG Account, with wonderful Skins Amazing PUBG Account, with wonderful Skins Amazing PUBG Account, with wonderful Skins'
        ]);

        Product::create([
            'user_id' => 1,
            'slug' => 'fortnite-account-2',
            'pricing_method' => 'Fixed',
            'price' => '14.0000',
            'os' => 'p',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630442334.png',
            'account_username' => 'fortyforty',
            'account_email' => 'forty@gmail.com',
            'account_email_website' => 'https://www.epicgames.com',
            'account_password' => ''
        ])->categories()->attach([2,4]);
        ProductTranslation::create([
            'product_id' => 8,
            'locale' => 'ar',
            'name' => 'حساب فورتنايت 2',
            'short_description' => 'حساب فورتنايت رائع مع اسكنات خرافية',
            'description' => 'حساب فورتنايت رائع مع اسكنات خرافية حساب فورتنايت رائع مع اسكنات خرافية حساب فورتنايت رائع مع اسكنات خرافية حساب فورتنايت رائع مع اسكنات خرافية',
        ]);
        ProductTranslation::create([
            'product_id' => 8,
            'locale' => 'en',
            'name' => 'Fortnite Account 2',
            'short_description' => 'Amazing Forntnite Account with Awesome Skins',
            'description' => 'Amazing Forntnite Account with Awesome Skins Amazing Forntnite Account with Awesome Skins Amazing Forntnite Account with Awesome Skins Amazing Forntnite Account with Awesome Skins'
        ]);

        Product::create([
            'user_id' => 1,
            'slug' => 'minecraft-account-2',
            'pricing_method' => 'Fixed',
            'price' => '17.5000',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630444565.jpg',
            'isPaid' => 1,
            'account_username' => 'minimini',
            'account_email' => 'minimini@gmail.com',
            'account_email_website' => 'https://www.minecraft.net',
            'account_password' => ''
        ])->categories()->attach([2]);
        ProductTranslation::create([
            'product_id' => 9,
            'locale' => 'ar',
            'name' => 'حساب ماين كرافت 2',
            'short_description' => 'حساب ماينكرافت رائع مع اسكنات خرافية',
            'description' => 'حساب ماينكرافت رائع مع اسكنات خرافية حساب ماينكرافت رائع مع اسكنات خرافية حساب ماينكرافت رائع مع اسكنات خرافية حساب ماينكرافت رائع مع اسكنات خرافية',
        ]);
        ProductTranslation::create([
            'product_id' => 9,
            'locale' => 'en',
            'name' => 'MineCraft Account 2',
            'short_description' => 'Amazing MineCraft Account with Awesome Skins',
            'description' => 'Amazing MineCraft Account with Awesome Skins Amazing MineCraft Account with Awesome Skins Amazing MineCraft Account with Awesome Skins Amazing MineCraft Account with Awesome Skins'
        ]);

        Product::create([
            'user_id' => 1,
            'slug' => 'cod-2',
            'pricing_method' => 'Fixed',
            'price' => '10.9900',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630447842.jpg',
            'account_username' => 'cod2',
            'account_email' => 'cod@gmail.com',
            'account_email_website' => 'https://www.callofduty.com',
            'account_password' => ''
        ])->categories()->attach([1,7]);
        ProductTranslation::create([
            'product_id' => 10,
            'locale' => 'ar',
            'name' => ' 2 كول اوف ديوتي',
            'short_description' => 'حساب كول اوف ديوتي رائع',
            'description' => 'حساب كول اوف ديوتي رائع حساب كول اوف ديوتي رائع حساب كول اوف ديوتي رائع حساب كول اوف ديوتي رائع حساب كول اوف ديوتي رائع',
        ]);
        ProductTranslation::create([
            'product_id' => 10,
            'locale' => 'en',
            'name' => 'Call Of Duty 2',
            'short_description' => 'Amazing Call Of Duty Account 2',
            'description' => 'Amazing Call Of Duty Account Amazing Call Of Duty Account Amazing Call Of Duty Account Amazing Call Of Duty Account Amazing Call Of Duty Account'
        ]);

        Product::create([
            'user_id' => 1,
            'slug' => 'ldoemobile-2',
            'pricing_method' => 'Fixed',
            'price' => '18.0000',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630445287.jpg',
            'os' => 'x',
            'account_username' => 'ldoe2',
            'account_email' => 'ldoemobile@gmail.com',
            'account_email_website' => 'https://play.google.com/store/apps/details?id=zombie.survival.craft.z&hl=ar&gl=US',
            'account_password' => ''
        ])->categories()->attach([2,3]);
        ProductTranslation::create([
            'product_id' => 11,
            'locale' => 'ar',
            'name' => 'آخر يوم علي الارض - حساب موبايل 2',
            'short_description' => 'لعبة رائعة للموبايل حساب جميل',
            'description' => 'لعبة رائعة للموبايل حساب جميل لعبة رائعة للموبايل حساب جميل لعبة رائعة للموبايل حساب جميل لعبة رائعة للموبايل حساب جميل',
        ]);
        ProductTranslation::create([
            'product_id' => 11,
            'locale' => 'en',
            'name' => 'Last Day on the Earth - Mobile Account 2',
            'short_description' => 'Amazing Game for mobiles ios and android',
            'description' => 'Amazing Game for mobiles ios and android Amazing Game for mobiles ios and android Amazing Game for mobiles ios and android Amazing Game for mobiles ios and android'
        ]);

        Product::create([
            'user_id' => 1,
            'slug' => 'clash-royale-2',
            'pricing_method' => 'Fixed',
            'price' => '1.0000',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630556484.jpg',
            'account_username' => 'clashyman2',
            'os' => 's',
            'account_email' => 'clashyman@gmail.com',
            'account_email_website' => 'https://play.google.com/store/apps/details?id=com.supercell.clashroyale&hl=ar&gl=US',
            'account_password' => ''
        ])->categories()->attach([5,7]);
        ProductTranslation::create([
            'product_id' => 12,
            'locale' => 'ar',
            'name' => 'لعبة كلاش رويال حساب قديم 2',
            'short_description' => '',
            'description' => 'لعبة كلاش رويال حساب قديم لعبة كلاش رويال حساب قديم لعبة كلاش رويال حساب قديم',
        ]);
        ProductTranslation::create([
            'product_id' => 12,
            'locale' => 'en',
            'name' => 'Clash Royale 2',
            'short_description' => '',
            'description' => 'Clash Royale Clash Royale Clash Royale Clash Royale'
        ]);
        /* ******************************************** */

        /* ******************************************** */
        Product::create([
            'user_id' => 1,
            'slug' => 'pubg-awesome-account-bid',
            'pricing_method' => 'Auction',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630445284.png',
            'start_bid_amount' => '12.0000',
            'auction_start' => '2021-09-04 12:38:54',
            'auction_end' => '2021-09-24 12:38:54',
            'account_username' => 'pubggy',
            'account_email' => 'pubggy@gmail.com',
            'account_email_website' => 'https://emea.battlegrounds.pubg.com/en/',
            'account_password' => ''
        ])->categories()->attach([1,4]);
        ProductTranslation::create([
            'product_id' => 13,
            'locale' => 'ar',
            'name' => 'حساب مزاد ببحي رائع',
            'short_description' => 'حساب ببجي رائع بسكينات خرافية',
            'description' => 'حساب ببجي رائع بسكينات خرافية حساب ببجي رائع بسكينات خرافية حساب ببجي رائع بسكينات خرافية حساب ببجي رائع بسكينات خرافية'
        ]);
        ProductTranslation::create([
            'product_id' => 13,
            'locale' => 'en',
            'name' => 'PUBG Awesome bid Account',
            'short_description' => 'Amazing PUBG Account, with wonderful Skins',
            'description' => 'Amazing PUBG Account, with wonderful Skins Amazing PUBG Account, with wonderful Skins Amazing PUBG Account, with wonderful Skins Amazing PUBG Account, with wonderful Skins'
        ]);

        Product::create([
            'user_id' => 1,
            'slug' => 'fortnite-account-bid',
            'pricing_method' => 'Auction',
            'start_bid_amount' => '14.0000',
            'auction_start' => '2021-09-04 12:38:54',
            'auction_end' => '2021-09-24 12:38:54',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630442334.png',
            'account_username' => 'fortyforty',
            'account_email' => 'forty@gmail.com',
            'account_email_website' => 'https://www.epicgames.com',
            'account_password' => ''
        ])->categories()->attach([2,4]);
        ProductTranslation::create([
            'product_id' => 14,
            'locale' => 'ar',
            'name' => 'حساب مزاد فورتنايت',
            'short_description' => 'حساب فورتنايت رائع مع اسكنات خرافية',
            'description' => 'حساب فورتنايت رائع مع اسكنات خرافية حساب فورتنايت رائع مع اسكنات خرافية حساب فورتنايت رائع مع اسكنات خرافية حساب فورتنايت رائع مع اسكنات خرافية',
        ]);
        ProductTranslation::create([
            'product_id' => 14,
            'locale' => 'en',
            'name' => 'Fortnite bid Account',
            'short_description' => 'Amazing Forntnite Account with Awesome Skins',
            'description' => 'Amazing Forntnite Account with Awesome Skins Amazing Forntnite Account with Awesome Skins Amazing Forntnite Account with Awesome Skins Amazing Forntnite Account with Awesome Skins'
        ]);

        Product::create([
            'user_id' => 1,
            'slug' => 'minecraft-account-bid',
            'pricing_method' => 'Auction',
            'start_bid_amount' => '7.5000',
            'auction_start' => '2021-09-04 12:38:54',
            'auction_end' => '2021-09-24 12:38:54',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630444565.jpg',
            'os' => 'p',
            'account_username' => 'minimini',
            'account_email' => 'minimini@gmail.com',
            'account_email_website' => 'https://www.minecraft.net',
            'account_password' => ''
        ])->categories()->attach([2]);
        ProductTranslation::create([
            'product_id' => 15,
            'locale' => 'ar',
            'name' => 'حساب مزاد ماين كرافت',
            'short_description' => 'حساب ماينكرافت رائع مع اسكنات خرافية',
            'description' => 'حساب ماينكرافت رائع مع اسكنات خرافية حساب ماينكرافت رائع مع اسكنات خرافية حساب ماينكرافت رائع مع اسكنات خرافية حساب ماينكرافت رائع مع اسكنات خرافية',
        ]);
        ProductTranslation::create([
            'product_id' => 15,
            'locale' => 'en',
            'name' => 'MineCraft bid Account',
            'short_description' => 'Amazing MineCraft Account with Awesome Skins',
            'description' => 'Amazing MineCraft Account with Awesome Skins Amazing MineCraft Account with Awesome Skins Amazing MineCraft Account with Awesome Skins Amazing MineCraft Account with Awesome Skins'
        ]);

        Product::create([
            'user_id' => 1,
            'slug' => 'cod-bid',
            'pricing_method' => 'Auction',
            'start_bid_amount' => '12.9900',
            'auction_start' => '2021-09-04 12:38:54',
            'auction_end' => '2021-09-24 12:38:54',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630447842.jpg',
            'account_username' => 'cod',
            'os' => 'p',
            'account_email' => 'cod@gmail.com',
            'account_email_website' => 'https://www.callofduty.com',
            'account_password' => ''
        ])->categories()->attach([1]);
        ProductTranslation::create([
            'product_id' => 16,
            'locale' => 'ar',
            'name' => 'كول اوف ديوتي مزاد',
            'short_description' => 'حساب كول اوف ديوتي رائع',
            'description' => 'حساب كول اوف ديوتي رائع حساب كول اوف ديوتي رائع حساب كول اوف ديوتي رائع حساب كول اوف ديوتي رائع حساب كول اوف ديوتي رائع',
        ]);
        ProductTranslation::create([
            'product_id' => 16,
            'locale' => 'en',
            'name' => 'Call Of Duty bid',
            'short_description' => 'Amazing Call Of Duty Account',
            'description' => 'Amazing Call Of Duty Account Amazing Call Of Duty Account Amazing Call Of Duty Account Amazing Call Of Duty Account Amazing Call Of Duty Account'
        ]);

        Product::create([
            'user_id' => 1,
            'slug' => 'ldoemobile-bid',
            'pricing_method' => 'Auction',
            'start_bid_amount' => '8.0000',
            'auction_start' => '2021-09-04 12:38:54',
            'auction_end' => '2021-09-24 12:38:54',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630445287.jpg',
            'account_username' => 'ldoe',
            'account_email' => 'ldoemobile@gmail.com',
            'account_email_website' => 'https://play.google.com/store/apps/details?id=zombie.survival.craft.z&hl=ar&gl=US',
            'account_password' => ''
        ])->categories()->attach([3]);
        ProductTranslation::create([
            'product_id' => 17,
            'locale' => 'ar',
            'name' => 'آخر يوم علي الارض - حساب موبايل مزاد',
            'short_description' => 'لعبة رائعة للموبايل حساب جميل',
            'description' => 'لعبة رائعة للموبايل حساب جميل لعبة رائعة للموبايل حساب جميل لعبة رائعة للموبايل حساب جميل لعبة رائعة للموبايل حساب جميل',
        ]);
        ProductTranslation::create([
            'product_id' => 17,
            'locale' => 'en',
            'name' => 'Last Day on the Earth - Mobile bid Account',
            'short_description' => 'Amazing Game for mobiles ios and android',
            'description' => 'Amazing Game for mobiles ios and android Amazing Game for mobiles ios and android Amazing Game for mobiles ios and android Amazing Game for mobiles ios and android'
        ]);

        Product::create([
            'user_id' => 1,
            'slug' => 'clash-royale-bid',
            'pricing_method' => 'Auction',
            'start_bid_amount' => '2.0000',
            'auction_start' => '2021-09-04 12:38:54',
            'os' => 'x',
            'auction_end' => '2021-09-24 12:38:54',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630556484.jpg',
            'account_username' => 'clashyman',
            'account_email' => 'clashyman@gmail.com',
            'account_email_website' => 'https://play.google.com/store/apps/details?id=com.supercell.clashroyale&hl=ar&gl=US',
            'account_password' => ''
        ])->categories()->attach([2]);
        ProductTranslation::create([
            'product_id' => 18,
            'locale' => 'ar',
            'name' => 'لعبة كلاش رويال حساب قديم مزاد',
            'short_description' => '',
            'description' => 'لعبة كلاش رويال حساب قديم لعبة كلاش رويال حساب قديم لعبة كلاش رويال حساب قديم',
        ]);
        ProductTranslation::create([
            'product_id' => 18,
            'locale' => 'en',
            'name' => 'Clash Royale bid',
            'short_description' => '',
            'description' => 'Clash Royale Clash Royale Clash Royale Clash Royale'
        ]);

        Product::create([
            'user_id' => 1,
            'slug' => 'pubg-awesome-account-bid-2',
            'pricing_method' => 'Auction',
            'start_bid_amount' => '8.0000',
            'auction_start' => '2021-09-04 12:38:54',
            'auction_end' => '2021-09-24 12:38:54',
            'os' => 'p',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630445284.png',
            'account_username' => 'pubggy2',
            'account_email' => 'pubggy2@gmail.com',
            'account_email_website' => 'https://emea.battlegrounds.pubg.com/en/',
            'account_password' => ''
        ])->categories()->attach([1,4]);
        ProductTranslation::create([
            'product_id' => 19,
            'locale' => 'ar',
            'name' => ' 2 حساب مزاد ببحي رائع',
            'short_description' => 'حساب ببجي رائع بسكينات خرافية',
            'description' => 'حساب ببجي رائع بسكينات خرافية حساب ببجي رائع بسكينات خرافية حساب ببجي رائع بسكينات خرافية حساب ببجي رائع بسكينات خرافية'
        ]);
        ProductTranslation::create([
            'product_id' => 19,
            'locale' => 'en',
            'name' => 'PUBG Awesome Account bid 2',
            'short_description' => 'Amazing PUBG Account, with wonderful Skins',
            'description' => 'Amazing PUBG Account, with wonderful Skins Amazing PUBG Account, with wonderful Skins Amazing PUBG Account, with wonderful Skins Amazing PUBG Account, with wonderful Skins'
        ]);

        Product::create([
            'user_id' => 1,
            'slug' => 'fortnite-account-bid-2',
            'pricing_method' => 'Auction',
            'start_bid_amount' => '14.0000',
            'auction_start' => '2021-09-04 12:38:54',
            'auction_end' => '2021-09-24 12:38:54',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630442334.png',
            'isPaid' => 1,
            'os' => 's',
            'account_username' => 'fortyforty',
            'account_email' => 'forty@gmail.com',
            'account_email_website' => 'https://www.epicgames.com',
            'account_password' => ''
        ])->categories()->attach([2,4]);
        ProductTranslation::create([
            'product_id' => 20,
            'locale' => 'ar',
            'name' => 'حساب مزاد فورتنايت 2',
            'short_description' => 'حساب فورتنايت رائع مع اسكنات خرافية',
            'description' => 'حساب فورتنايت رائع مع اسكنات خرافية حساب فورتنايت رائع مع اسكنات خرافية حساب فورتنايت رائع مع اسكنات خرافية حساب فورتنايت رائع مع اسكنات خرافية',
        ]);
        ProductTranslation::create([
            'product_id' => 20,
            'locale' => 'en',
            'name' => 'Fortnite bid Account 2',
            'short_description' => 'Amazing Forntnite Account with Awesome Skins',
            'description' => 'Amazing Forntnite Account with Awesome Skins Amazing Forntnite Account with Awesome Skins Amazing Forntnite Account with Awesome Skins Amazing Forntnite Account with Awesome Skins'
        ]);

        Product::create([
            'user_id' => 1,
            'slug' => 'minecraft-account-bid-2',
            'pricing_method' => 'Auction',
            'start_bid_amount' => '17.5500',
            'auction_start' => '2021-09-04 12:38:54',
            'auction_end' => '2021-09-24 12:38:54',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630444565.jpg',
            'account_username' => 'minimini',
            'account_email' => 'minimini@gmail.com',
            'account_email_website' => 'https://www.minecraft.net',
            'account_password' => ''
        ])->categories()->attach([2]);
        ProductTranslation::create([
            'product_id' => 21,
            'locale' => 'ar',
            'name' => 'حساب مزاد ماين كرافت 2',
            'short_description' => 'حساب ماينكرافت رائع مع اسكنات خرافية',
            'description' => 'حساب ماينكرافت رائع مع اسكنات خرافية حساب ماينكرافت رائع مع اسكنات خرافية حساب ماينكرافت رائع مع اسكنات خرافية حساب ماينكرافت رائع مع اسكنات خرافية',
        ]);
        ProductTranslation::create([
            'product_id' => 21,
            'locale' => 'en',
            'name' => 'MineCraft bid Account 2',
            'short_description' => 'Amazing MineCraft Account with Awesome Skins',
            'description' => 'Amazing MineCraft Account with Awesome Skins Amazing MineCraft Account with Awesome Skins Amazing MineCraft Account with Awesome Skins Amazing MineCraft Account with Awesome Skins'
        ]);

        Product::create([
            'user_id' => 1,
            'slug' => 'cod-bid-2',
            'pricing_method' => 'Auction',
            'start_bid_amount' => '10.0000',
            'auction_start' => '2021-09-04 12:38:54',
            'auction_end' => '2021-09-24 12:38:54',
            'os' => 's',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630447842.jpg',
            'account_username' => 'cod2',
            'account_email' => 'cod@gmail.com',
            'account_email_website' => 'https://www.callofduty.com',
            'account_password' => ''
        ])->categories()->attach([2]);
        ProductTranslation::create([
            'product_id' => 22,
            'locale' => 'ar',
            'name' => ' 2 مزاد كول اوف ديوتي',
            'short_description' => 'حساب كول اوف ديوتي رائع',
            'description' => 'حساب كول اوف ديوتي رائع حساب كول اوف ديوتي رائع حساب كول اوف ديوتي رائع حساب كول اوف ديوتي رائع حساب كول اوف ديوتي رائع',
        ]);
        ProductTranslation::create([
            'product_id' => 22,
            'locale' => 'en',
            'name' => 'Call Of Duty',
            'short_description' => 'bid Amazing Call Of Duty Account 2',
            'description' => 'Amazing Call Of Duty Account Amazing Call Of Duty Account Amazing Call Of Duty Account Amazing Call Of Duty Account Amazing Call Of Duty Account'
        ]);

        Product::create([
            'user_id' => 1,
            'slug' => 'ldoemobile-bid-2',
            'pricing_method' => 'Auction',
            'start_bid_amount' => '18.0000',
            'auction_start' => '2021-09-04 12:38:54',
            'auction_end' => '2021-09-24 12:38:54',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630445287.jpg',
            'os' => 's',
            'account_username' => 'ldoe2',
            'account_email' => 'ldoemobile@gmail.com',
            'account_email_website' => 'https://play.google.com/store/apps/details?id=zombie.survival.craft.z&hl=ar&gl=US',
            'account_password' => ''
        ])->categories()->attach([2]);
        ProductTranslation::create([
            'product_id' => 23,
            'locale' => 'ar',
            'name' => 'آخر يوم علي الارض - مزاد حساب موبايل 2',
            'short_description' => 'لعبة رائعة للموبايل حساب جميل',
            'description' => 'لعبة رائعة للموبايل حساب جميل لعبة رائعة للموبايل حساب جميل لعبة رائعة للموبايل حساب جميل لعبة رائعة للموبايل حساب جميل',
        ]);
        ProductTranslation::create([
            'product_id' => 23,
            'locale' => 'en',
            'name' => 'Last Day on the Earth - bid Mobile Account 2',
            'short_description' => 'Amazing Game for mobiles ios and android',
            'description' => 'Amazing Game for mobiles ios and android Amazing Game for mobiles ios and android Amazing Game for mobiles ios and android Amazing Game for mobiles ios and android'
        ]);

        Product::create([
            'user_id' => 1,
            'slug' => 'clash-royale-bid-2',
            'pricing_method' => 'Auction',
            'start_bid_amount' => '1.0000',
            'auction_start' => '2021-09-04 12:38:54',
            'auction_end' => '2021-09-24 12:38:54',
            'commission' => Setting::where('key', '=','commission')->first()->value,
            'main_image' => '1630556484.jpg',
            'account_username' => 'clashyman2',
            'os' => 's',
            'account_email' => 'clashyman@gmail.com',
            'account_email_website' => 'https://play.google.com/store/apps/details?id=com.supercell.clashroyale&hl=ar&gl=US',
            'account_password' => ''
        ])->categories()->attach([2,5]);
        ProductTranslation::create([
            'product_id' => 24,
            'locale' => 'ar',
            'name' => 'لعبة كلاش رويال حساب مزاد قديم 2',
            'short_description' => '',
            'description' => 'لعبة كلاش رويال حساب قديم لعبة كلاش رويال حساب قديم لعبة كلاش رويال حساب قديم',
        ]);
        ProductTranslation::create([
            'product_id' => 24,
            'locale' => 'en',
            'name' => 'Clash Royale bid 2',
            'short_description' => '',
            'description' => 'Clash Royale Clash Royale Clash Royale Clash Royale'
        ]);
        /* ******************************************** */
    }
}
