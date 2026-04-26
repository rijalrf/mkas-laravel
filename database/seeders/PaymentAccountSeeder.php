<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\PaymentAccount::create([
            'bank_name' => 'Bank Mandiri',
            'account_number' => '1234567890',
            'account_name' => 'Bendahara MKAS',
            'monthly_amount' => 100000,
        ]);
    }
}
