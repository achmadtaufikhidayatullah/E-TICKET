<?php

namespace Database\Seeders;

use App\Models\UserBankAccount;
use Illuminate\Database\Seeder;

class UserBankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserBankAccount::create([
            'user_id' => 1,
            'bank_code' => '002',
            'bank_name' => 'BANK BCA',
            'account_number' => '7725344511',
            'account_holder_name' => 'Muhammad Ferrizal Zulkarnain',
            'status' => 'owner_account'
        ]);

        // UserBankAccount::create([
        //     'user_id' => 1,
        //     'bank_code' => '009',
        //     'bank_name' => 'BANK BNI',
        //     'account_number' => '123412341234',
        //     'account_holder_name' => 'Pemilik Rekening 2',
        //     'status' => 'owner_account'
        // ]);
    }
}
