<?php
/**
     * Test only admin can delete muris.
     *
     * @return public test_only_admin_can_delete_muris
     */

    /**
     * Test admin user can update muris.
     *
     * @return public test_admin_user_can_update_muris
     */

    /**
     * Test authenticated user can view muris detail.
     *
     * @return public test_authenticated_user_can_view_muris_detail
     */

    /**
     * Test admin user can store muris.
     *
     * @return public test_admin_user_can_store_muris
     */

    /**
     * Test admin user can create muris.
     *
     * @return public test_admin_user_can_create_muris
     */

    /**
     * Test authenticated user can view muris listing.
     *
     * @return public test_authenticated_user_can_view_muris_listing
     */


namespace Tests\Feature;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MurisCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_muris_listing(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $response = $this->actingAs($user)->get('/admin/siswa');

        $response->assertStatus(200)
            ->assertSee('Siswa')
            ->assertSee('NIS');
    }

    public function test_admin_user_can_create_muris(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $response = $this->actingAs($user)->get('/admin/siswa/create');

        $response->assertStatus(200)
            ->assertSee('Create Siswa');
    }

    public function test_admin_user_can_store_muris(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $mockSiswa = [
            'name' => 'Test Student',
            'email' => 'test@murid.test',
            'nis' => '20260001',
            'kelas' => 'X-RPL-1',
            'jenis_kelamin' => 'L',
            'alamat' => 'Test Address',
        ];

        $response = $this->actingAs($user)->post('/admin/siswa', $mockSiswa);

        $response->assertRedirect()
            ->assertSessionHas('success');

        $this->assertTrue(Siswa::where('nis', '20260001')->exists());
    }

    public function test_authenticated_user_can_view_muris_detail(): void
    {
        $siswa = Siswa::factory()->create([
            'user' => User::factory()->create(['role' => User::ROLE_MURID]),
        ]);

        $response = $this->get('/admin/siswa/' . $siswa->id);

        $response->assertStatus(200)
            ->assertSee($siswa->nama)
            ->assertSee($siswa->nis);
    }

    public function test_admin_user_can_update_muris(): void
    {
        $siswa = Siswa::factory()->create([
            'user' => User::factory()->create(['role' => User::ROLE_MURID]),
        ]);

        $response = $this->actingAs(User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]))->put('/admin/siswa/' . $siswa->id, [
            'name' => 'Updated Student Name',
            'nis' => $siswa->nis,
            'kelas' => 'X-RPL-1',
            'jenis_kelamin' => 'L',
            'alamat' => 'Updated Address',
        ]);

        $response->assertRedirect();

        $siswa->refresh();
        $this->assertEquals('Updated Student Name', $siswa->nama);
    }

    public function test_only_admin_can_delete_muris(): void
    {
        $siswa = Siswa::factory()->create([
            'user' => User::factory()->create(['role' => User::ROLE_MURID]),
        ]);

        // Muris cannot delete
        $response = $this->actingAs(User::factory()->create(['role' => User::ROLE_MURID]))
            ->delete('/admin/siswa/' . $siswa->id);

        $response->assertStatus(403);
        $this->assertTrue(Siswa::where('id', $siswa->id)->exists());

        // Admin can delete
        $response = $this->actingAs(User::factory()->create(['role' => User::ROLE_ADMIN]))
            ->delete('/admin/siswa/' . $siswa->id);

        $response->assertRedirect();
        $this->assertFalse(Siswa::where('id', $siswa->id)->exists());
    }
}