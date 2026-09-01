<?php
/**
     * Test guest cannot access guru api.
     *
     * @return public test_guest_cannot_access_guru_api
     */

    /**
     * Test guru api returns json data collection.
     *
     * @return public test_guru_api_returns_json_data_collection
     */

    /**
     * Test only admin can delete guru.
     *
     * @return public test_only_admin_can_delete_guru
     */

    /**
     * Test admin user can update guru.
     *
     * @return public test_admin_user_can_update_guru
     */

    /**
     * Test authenticated user can view guru detail.
     *
     * @return public test_authenticated_user_can_view_guru_detail
     */

    /**
     * Test admin user can store guru.
     *
     * @return public test_admin_user_can_store_guru
     */

    /**
     * Test admin user can create guru form.
     *
     * @return public test_admin_user_can_create_guru_form
     */

    /**
     * Test authenticated user can view guru listing.
     *
     * @return public test_authenticated_user_can_view_guru_listing
     */

    /**
     * Setup.
     *
     * @return public setUp
     */


namespace Tests\Feature;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuruCrudTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // Migrate and seed are handled by the test suite
    }

    public function test_authenticated_user_can_view_guru_listing(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $response = $this->actingAs($user)->get('/admin/guru');

        $response->assertStatus(200)
            ->assertSee('Guru')
            ->assertSee('NIP');
    }

    public function test_admin_user_can_create_guru_form(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $response = $this->actingAs($user)->get('/admin/guru/create');

        $response->assertStatus(200)
            ->assertSee('Create Guru');
    }

    public function test_admin_user_can_store_guru(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $guru = Guru::factory()->withUser($user)->create();

        $mockGuru = [
            'nama' => 'Test Guru',
            'nip' => '199001012020011001',
            'no_telepon' => '0812-3456-7890',
            'wali_kelas' => 'X-RPL-1',
        ];

        $response = $this->actingAs($user)->post('/admin/guru', $mockGuru);

        $response->assertRedirect()
            ->assertSessionHas('success');

        $this->assertTrue(Guru::where('nip', '199001012020011001')->exists());
    }

    public function test_authenticated_user_can_view_guru_detail(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_GURU,
        ]);
        $guru = Guru::factory()->withUser($user)->create();

        $response = $this->actingAs($user)->get('/admin/guru/' . $guru->id);

        $response->assertStatus(200)
            ->assertSee($guru->nama)
            ->assertSee($guru->nip);
    }

    public function test_admin_user_can_update_guru(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);
        $guru = Guru::factory()->withUser(User::factory()->create(['role' => User::ROLE_GURU]))->create();

        $response = $this->actingAs($user)->put('/admin/guru/' . $guru->id, [
            'nama' => 'Updated Guru Name',
            'nip' => $guru->nip,
            'no_telepon' => $guru->no_telepon,
            'wali_kelas' => 'X-RPL-1',
        ]);

        $response->assertRedirect();

        $guru->refresh();
        $this->assertEquals('Updated Guru Name', $guru->nama);
    }

    public function test_only_admin_can_delete_guru(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);
        $guru = Guru::factory()->withUser(User::factory()->create(['role' => User::ROLE_GURU]))->create();

        // Guru cannot delete
        $response = $this->actingAs(User::factory()->create(['role' => User::ROLE_GURU]))
            ->delete('/admin/guru/' . $guru->id);

        $response->assertStatus(403);
        $this->assertTrue(Guru::where('id', $guru->id)->exists());

        // Admin can delete
        $response = $this->actingAs($user)->delete('/admin/guru/' . $guru->id);

        $response->assertRedirect();
        $this->assertFalse(Guru::where('id', $guru->id)->exists());
    }

    public function test_guru_api_returns_json_data_collection(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_GURU]);
        $guru = Guru::factory()->withUser($user)->create();

        $response = $this->actingAs($user)->get('/api/guru');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'nama',
                    'nip',
                    'email',
                    'no_telepon',
                    'mata_pelajaran',
                ],
            ],
        ]);
    }

    public function test_guest_cannot_access_guru_api(): void
    {
        $response = $this->get('/api/guru');

        $response->assertStatus(401);
    }
}