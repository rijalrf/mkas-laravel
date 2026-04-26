<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Deposit;
use App\Models\PaymentAccount;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Users
        $admin = User::create([
            'name' => 'Bendahara MKAS',
            'email' => 'admin@mkas.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $user1 = User::create([
            'name' => 'Ahmad Rijal',
            'email' => 'user@mkas.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $user2 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@mkas.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // 2. Categories
        $categories = ['Umum', 'Listrik', 'Air', 'Internet', 'Konsumsi', 'Transportasi', 'Pemeliharaan'];
        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
        $allCats = Category::all();

        // 3. Payment Account
        PaymentAccount::create([
            'bank_name' => 'Bank Mandiri',
            'account_number' => '1234567890',
            'account_name' => 'Bendahara Umum MKAS',
            'monthly_amount' => 100000,
        ]);

        // 4. Dummy Transactions (Approved)
        for ($i = 0; $i < 10; $i++) {
            Transaction::create([
                'type' => $i % 3 == 0 ? 'IN' : 'OUT',
                'amount' => rand(50000, 500000),
                'description' => ($i % 3 == 0 ? 'Kas Masuk Ke-' : 'Pengeluaran ') . ($i + 1),
                'photo' => 'receipts/dummy.jpg',
                'status' => 'APPROVED',
                'user_id' => $user1->id,
                'category_id' => $allCats->random()->id,
                'created_at' => now()->subDays(rand(1, 30)),
            ]);
        }

        // 5. Dummy Deposits (Approved)
        $months = [now()->format('Y-m'), now()->subMonth()->format('Y-m')];
        foreach ([$user1, $user2] as $u) {
            foreach ($months as $m) {
                Deposit::create([
                    'user_id' => $u->id,
                    'month' => $m,
                    'amount' => 100000,
                    'status' => 'APPROVED',
                    'description' => 'Iuran Rutin ' . $m,
                ]);
            }
        }

        // 6. Pending Requests (For Admin to Test Approval)
        Transaction::create([
            'type' => 'OUT',
            'amount' => 150000,
            'description' => 'Beli ATK Kantor',
            'photo' => 'receipts/dummy.jpg',
            'status' => 'PENDING',
            'user_id' => $user2->id,
            'category_id' => $allCats->where('name', 'Umum')->first()->id,
        ]);

        Deposit::create([
            'user_id' => $user1->id,
            'month' => now()->addMonth()->format('Y-m'),
            'amount' => 100000,
            'status' => 'PENDING',
            'description' => 'Iuran Dimuka',
        ]);
    }
}
