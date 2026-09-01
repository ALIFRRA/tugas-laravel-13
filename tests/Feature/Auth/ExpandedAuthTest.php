<?php
/**
     * Test guest cannot access protected routes.
     *
     * @return public test_guest_cannot_access_protected_routes
     */

    /**
     * Test user cannot update another users profile.
     *
     * @return public test_user_cannot_update_another_users_profile
     */

    /**
     * Test user can update own profile.
     *
     * @return public test_user_can_update_own_profile
     */

    /**
     * Test registered user can access profile.
     *
     * @return public test_registered_user_can_access_profile
     */

    /**
     * Test new users can register.
     *
     * @return public test_new_users_can_register
     */

    /**
     * Test registration screen can be rendered.
     *
     * @return public test_registration_screen_can_be_rendered
     */

    /**
     * Test users can logout.
     *
     * @return public test_users_can_logout
     */

    /**
     * Test users can not authenticate with invalid password.
     *
     * @return public test_users_can_not_authenticate_with_invalid_password
     */

    /**
     * Test users can authenticate using the login screen.
     *
     * @return public test_users_can_authenticate_using_the_login_screen
     */

    /**
     * Test login screen can be rendered.
     *
     * @return public test_login_screen_can_be_rendered
     */


namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpandedAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200)
            ->assertSee('Email');
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password',
            'role' => User::ROLE_MURID,
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200)
            ->assertSee('Name');
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
        $this->assertTrue(User::where('email', 'test@example.com')->exists());
    }

    public function test_registered_user_can_access_profile(): void
    {
        $user = User::factory()->create([
            'email' => 'profile@example.com',
            'password' => 'password',
        ]);

        $response = $this->actingAs($user)->get('/profile/1');

        $response->assertStatus(200);
    }

    public function test_user_can_update_own_profile(): void
    {
        $user = User::factory()->create([
            'email' => 'update@example.com',
            'password' => 'password',
            'name' => 'Original Name',
        ]);

        $this->actingAs($user)->put('/account/profile', [
            'name' => 'Updated Name',
            'email' => 'update@example.com',
        ]);

        $user->refresh();
        $this->assertEquals('Updated Name', $user->name);
    }

    public function test_user_cannot_update_another_users_profile(): void
    {
        $currentUser = User::factory()->create([
            'email' => 'current@example.com',
            'password' => 'password',
            'role' => User::ROLE_ADMIN,
        ]);

        $otherUser = User::factory()->create([
            'email' => 'other@example.com',
            'password' => 'password',
            'name' => 'Other Name',
        ]);

        $this->actingAs($currentUser)->put('/account/profile/1', [
            'name' => 'Hacked Name',
        ]);

        $otherUser->refresh();
        $this->assertEquals('Other Name', $otherUser->name);
    }

    public function test_guest_cannot_access_protected_routes(): void
    {
        $response = $this->get('/dashboard');

        $response->assertStatus(302)
            ->assertRedirect('/login');
    }
}