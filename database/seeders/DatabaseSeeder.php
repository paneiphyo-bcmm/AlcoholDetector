// database/seeders/DatabaseSeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CompanySeeder::class,
            LocationSeeder::class,
            UserSeeder::class,
            DeviceSeeder::class,
            LicenseSeeder::class,
        ]);
    }
}