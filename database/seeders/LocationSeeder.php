// database/seeders/LocationSeeder.php
<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        Location::insert([
            [
                'location_id'   => 'LOC0000001',
                'location_name' => '本社',
                'admin_user_id' => 'USR0000001',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'location_id'   => 'LOC0000002',
                'location_name' => '大阪支社',
                'admin_user_id' => 'USR0000002',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}