<?php
/**
     * Test guest cannot access guru api.
     *
     * @return public test_guest_cannot_access_guru_api
     */

    /**
     * Test guru api returns a json data collection.
     *
     * @return public test_guru_api_returns_a_json_data_collection
     */


namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuruApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_guru_api_returns_a_json_data_collection(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->assertInstanceOf(User::class, $admin);
        $this->actingAs($admin);

        $response = $this->getJson('/api/guru');

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_guest_cannot_access_guru_api(): void
    {
        $this->getJson('/api/guru')->assertUnauthorized();
    }
}
