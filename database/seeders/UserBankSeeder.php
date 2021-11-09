<?php

namespace Database\Seeders;

use App\Models\BankName;
use App\Models\UserBank;
use Illuminate\Database\Seeder;

class UserBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserBank::create([
           'user_id' => 1,
            'full_name' => 'Ahmed Yahya Ahmed Khan',
            'bank' => 'AlRajhi',
            'iban_number' => 'SA10951050915915'
        ]);

        UserBank::create([
            'user_id' => 2,
            'full_name' => 'Zaher Faisal Khalid Salem',
            'bank' => 'Sab',
            'iban_number' => 'SE90159895650115'
        ]);

        UserBank::create([
            'user_id' => 3,
            'full_name' => 'Samer Faleh Aesa Ghamdi',
            'bank' => 'Sab',
            'iban_number' => 'SE59186961061060'
        ]);
    }
}
