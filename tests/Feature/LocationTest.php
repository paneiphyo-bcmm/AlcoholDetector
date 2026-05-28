// tests/Feature/LocationTest.php
<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;
    private User $orgUser;

    protected function setUp(): void
    {
        parent::setUp();

        $company = Company::create([
            'company_id'   => 'COMP000001',
            'company_name' => 'テスト株式会社',
        ]);

        $this->adminUser = User::create([
            'user_id'    => 'USR0000001',
            'company_id' => 'COMP000001',
            'user_name'  => '管理者',
            'email'      => 'admin@example.com',
            'password'   => bcrypt('password'),
            'role'       => 'admin',
        ]);

        $this->orgUser = User::create([
            'user_id'    => 'USR0000002',
            'company_id' => 'COMP000001',
            'user_name'  => '拠点管理者',
            'email'      => 'org@example.com',
            'password'   => bcrypt('password'),
            'role'       => 'organization',
            'location_id'=> 'LOC0000001',
        ]);
    }

    /** @test */
    public function 管理者は拠点一覧を取得できる(): void
    {
        Location::create([
            'location_id'   => 'LOC0000001',
            'location_name' => '本社',
            'admin_user_id' => 'USR0000001',
        ]);

        $response = $this->actingAs($this->adminUser, 'api')
            ->getJson('/api/locations');

        $response->assertOk()
            ->assertJsonStructure(['locations']);
    }

    /** @test */
    public function 管理者は拠点を登録できる(): void
    {
        $response = $this->actingAs($this->adminUser, 'api')
            ->postJson('/api/locations', [
                'location_id'   => 'LOC0000001',
                'location_name' => '本社',
                'admin_user_id' => 'USR0000001',
            ]);

        $response->assertCreated()
            ->assertJsonFragment(['message' => '拠点を登録しました。']);

        $this->assertDatabaseHas('locations', [
            'location_id'   => 'LOC0000001',
            'location_name' => '本社',
        ]);
    }

    /** @test */
    public function バリデーションエラーで拠点登録失敗(): void
    {
        $response = $this->actingAs($this->adminUser, 'api')
            ->postJson('/api/locations', [
                'location_id'   => '',
                'location_name' => '',
                'admin_user_id' => '',
            ]);

        $response->assertUnprocessable();
    }
}