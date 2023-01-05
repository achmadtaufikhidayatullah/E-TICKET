<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('123'),
            'role' => 'Super Admin',
            'no_ktp' => '111111111',
            'phone_number' => '081234567890',
            'remember_token' => '',
            'status' => 'Aktif'
        ]);
        
        User::create([
            'name' => 'Member',
            'email' => 'member@gmail.com',
            'password' => bcrypt('123'),
            'role' => 'Member',
            'no_ktp' => '1234123412341234',
            'phone_number' => '081999888777',
            'remember_token' => '',
            'status' => 'Aktif'
        ]);
    }
}
