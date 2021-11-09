<?php

namespace Database\Seeders;

use App\Models\BankName;
use Illuminate\Database\Seeder;

class BankNamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BankName::create([
           'name' => 'AlRajhi'
        ]);
        BankName::create([
            'name' => 'Sab'
        ]);    }
}
