// database/seeders/CompanySeeder.php
<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::insert([
            [
                'company_id'   => 'COMP000001',
                'company_name' => 'テスト株式会社',
                'corporate_id' => '1234567890123',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'company_id'   => 'COMP000002',
                'company_name' => 'サンプル合同会社',
                'corporate_id' => '9876543210987',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}