// tests/Feature/DeviceTest.php
<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Device;
use App\Models\Location;
use App\Models\MeasurementRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeviceTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        Company::create(['company_id' => 'COMP000001', 'company_name' => 'テスト会社']);
        Location::create(['location_id' => 'LOC0000001', 'location_name' => '本社', 'admin_user_id' => 'USR0000001']);
        Location::create(['location_id' => 'LOC0000002', 'location_name' => '支社', 'admin_user_id' => 'USR0000001']);

        $this->adminUser = User::create([
            'user_id'    => 'USR0000001',
            'company_id' => 'COMP000001',
            'user_name'  => '管理者',
            'email'      => 'admin@example.com',
            'password'   => bcrypt('password'),
            'role'       => 'admin',
        ]);
    }

    /** @test */
    public function デバイス更新時に拠点IDが変更されると測定履歴の拠点IDも更新される(): void
    {
        Device::create([
            'device_id'   => 'DEV00000000000000001',
            'location_id' => 'LOC0000001',
            'device_name' => 'テストデバイス',
        ]);

        MeasurementRecord::create([
            'device_id'        => 'DEV00000000000000001',
            'location_id'      => 'LOC0000001',
            'measurement_time' => now(),
            'alcohol_level'    => 0.00,
        ]);

        $this->actingAs($this->adminUser, 'api')
            ->postJson('/api/devices/DEV00000000000000001', [
                'device_name'  => 'テストデバイス',
                'location_id'  => 'LOC0000002',
            ]);

        $this->assertDatabaseHas('measurement_records', [
            'device_id'   => 'DEV00000000000000001',
            'location_id' => 'LOC0000002',
        ]);
    }
}