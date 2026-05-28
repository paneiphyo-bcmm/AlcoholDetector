// database/seeders/LicenseSeeder.php
<?php

namespace Database\Seeders;

use App\Models\License;
use Illuminate\Database\Seeder;

class LicenseSeeder extends Seeder
{
    public function run(): void
    {
        License::insert([
            [
                'license_id'     => 'LIC0000000000000001',
                'company_id'     => 'COMP000001',
                'contract_count' => 10,
                'usage_count'    => 3,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'license_id'     => 'LIC0000000000000002',
                'company_id'     => 'COMP000002',
                'contract_count' => 5,
                'usage_count'    => 6,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}