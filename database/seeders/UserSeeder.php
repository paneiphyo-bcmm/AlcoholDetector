// database/seeders/UserSeeder.php
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'user_id'    => 'USR0000001',
                'company_id' => 'COMP000001',
                'user_name'  => 'システム管理者',
                'email'      => 'admin@example.com',
                'password'   => Hash::make('password'),
                'location_id'=> null,
                'role'       => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id'    => 'USR0000002',
                'company_id' => 'COMP000001',
                'user_name'  => '拠点管理者',
                'email'      => 'org@example.com',
                'password'   => Hash::make('password'),
                'location_id'=> 'LOC0000001',
                'role'       => 'organization',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}