// tests/Feature/LicenseTest.php
<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Device;
use App\Models\License;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LicenseTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        Company::create(['company_id' => 'COMP000001', 'company_name' => 'テスト会社']);

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
    public function ライセンスを登録できる(): void
    {
        $response = $this->actingAs($this->adminUser, 'api')
            ->postJson('/api/licenses', [
                'company_id'     => 'COMP000001',
                'contract_count' => 10,
            ]);

        $response->assertCreated()
            ->assertJsonFragment(['message' => 'ライセンスを登録しました。']);
    }

    /** @test */
    public function 測定履歴登録時に利用数がインクリメントされる(): void
    {
        License::create([
            'license_id'     => 'LIC0000000000000001',
            'company_id'     => 'COMP000001',
            'contract_count' => 10,
            'usage_count'    => 0,
        ]);

        Location::create(['location_id' => 'LOC0000001', 'location_name' => '本社', 'admin_user_id' => 'USR0000001']);
        Device::create(['device_id' => 'DEV00000000000000001', 'location_id' => 'LOC0000001', 'device_name' => 'テスト']);

        $this->actingAs($this->adminUser, 'api')
            ->postJson('/api/measurement_records', [
                'device_id'        => 'DEV00000000000000001',
                'location_id'      => 'LOC0000001',
                'user_id'          => 'USR0000001',
                'measurement_time' => now()->format('Y-m-d H:i:s'),
                'alcohol_level'    => 0.00,
            ]);

        $this->assertDatabaseHas('licenses', [
            'company_id'  => 'COMP000001',
            'usage_count' => 1,
        ]);
    }

    /** @test */
    public function 契約数超過フィルタが機能する(): void
    {
        License::create([
            'license_id'     => 'LIC0000000000000002',
            'company_id'     => 'COMP000001',
            'contract_count' => 5,
            'usage_count'    => 6,
        ]);

        $response = $this->actingAs($this->adminUser, 'api')
            ->getJson('/api/licenses?exceeded_only=1');

        $response->assertOk()
            ->assertJsonCount(1, 'licenses');
    }
}