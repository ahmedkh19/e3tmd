<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionTableSeeder::class,
            SettingDatabaseSeeder::class,
            CreateAdminUserSeeder::class,
            CategoryDatabaseSeeder::class,
            ProductSeeder::class,
            ConversationSeeder::class,
            BankNamesSeeder::class,
            UserBankSeeder::class,
        ]);
    }
}
