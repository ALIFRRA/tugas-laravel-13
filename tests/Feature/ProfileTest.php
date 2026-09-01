<?php
/**
     * Test correct password must be provided to delete account.
     *
     * @return public test_correct_password_must_be_provided_to_delete_account
     */

    /**
     * Test user can delete their account.
     *
     * @return public test_user_can_delete_their_account
     */

    /**
     * Test email verification status is unchanged when the email address is unchanged.
     *
     * @return public test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged
     */

    /**
     * Test profile information can be updated.
     *
     * @return public test_profile_information_can_be_updated
     */

    /**
     * Test user can upload custom avatar base64.
     *
     * @return public test_user_can_upload_custom_avatar_base64
     */

    /**
     * Test uploaded avatar is served by avatar route.
     *
     * @return public test_uploaded_avatar_is_served_by_avatar_route
     */

    /**
     * Test user can upload custom avatar file.
     *
     * @return public test_user_can_upload_custom_avatar_file
     */

    /**
     * Test user can update avatar to preset.
     *
     * @return public test_user_can_update_avatar_to_preset
     */

    /**
     * Test profile page is displayed.
     *
     * @return public test_profile_page_is_displayed
     */


namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('profile.show', $user->id));

        $response->assertOk();
    }

    public function test_user_can_update_avatar_to_preset(): void
    {
        $user = User::factory()->create([
            'avatar' => 'bocchi',
        ]);

        $response = $this
            ->actingAs($user)
            ->put(route('profile.update.user', $user->id), [
                'name' => 'Erika Sasaki, S.AP.',
                'avatar' => 'bocchi-maid',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('profile.show', $user->id));

        $user->refresh();
        $this->assertSame('bocchi-maid', $user->avatar);
        $this->assertSame('Erika Sasaki, S.AP.', $user->name);
    }

    public function test_user_can_upload_custom_avatar_file(): void
    {
        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('custom_avatar.png', 300, 300);

        $response = $this
            ->actingAs($user)
            ->put(route('profile.update.user', $user->id), [
                'name' => $user->name,
                'avatar_file' => $file,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('profile.show', $user->id));

        $user->refresh();
        $this->assertStringStartsWith('avatars/', $user->avatar);
        $this->assertTrue(Storage::disk('public')->exists($user->avatar));

        // Clean up test file
        if (Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }
    }

    public function test_uploaded_avatar_is_served_by_avatar_route(): void
    {
        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('custom_avatar.png', 300, 300);

        $this->actingAs($user)->put(route('profile.update.user', $user->id), [
            'name' => $user->name,
            'avatar_file' => $file,
        ])->assertRedirect(route('profile.show', $user->id));

        $user->refresh();

        $response = $this->get(route('avatar.show', ['filename' => basename($user->avatar)]));

        $response->assertOk();

        Storage::disk('public')->delete($user->avatar);
    }

    public function test_user_can_upload_custom_avatar_base64(): void
    {
        $user = User::factory()->create();

        // 1x1 transparent png in base64
        $base64 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';

        $response = $this
            ->actingAs($user)
            ->put(route('profile.update.user', $user->id), [
                'name' => $user->name,
                'avatar_base64' => $base64,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('profile.show', $user->id));

        $user->refresh();
        $this->assertStringStartsWith('avatars/', $user->avatar);
        $this->assertTrue(Storage::disk('public')->exists($user->avatar));

        // Clean up test file
        if (Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/account/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/account/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/account/profile', [
                'name' => 'Test User',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/account/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/account/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/account/profile')
            ->delete('/account/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/account/profile');

        $this->assertNotNull($user->fresh());
    }
}
