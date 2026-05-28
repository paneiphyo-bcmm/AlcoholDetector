// database/seeders/DeviceSeeder.php
<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
{
    public function run(): void
    {
        Device::insert([
            [
                'device_id'         => 'DEV00000000000000001',
                'location_id'       => 'LOC0000001',
                'device_name'       => 'アルコール検知器 001',
                'serial_number'     => 'SN-001-2024',
                'installation_date' => '2024-01-01',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ]);
    }
}