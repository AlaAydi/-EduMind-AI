<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    private const PROFILE_URI = '/profile';
    private const TEST_USER_NAME = 'Test User';
    private const TEST_EMAIL = 'test@example.com';
    private const WRONG_PASSWORD = 'wrong-password';
    private const CORRECT_PASSWORD = 'password';

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(self::PROFILE_URI);

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch(self::PROFILE_URI, [
                'name' => self::TEST_USER_NAME,
                'email' => self::TEST_EMAIL,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(self::PROFILE_URI);

        $user->refresh();

        $this->assertSame(self::TEST_USER_NAME, $user->name);
        $this->assertSame(self::TEST_EMAIL, $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch(self::PROFILE_URI, [
                'name' => self::TEST_USER_NAME,
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(self::PROFILE_URI);

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete(self::PROFILE_URI, [
                'password' => self::CORRECT_PASSWORD,
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
            ->from(self::PROFILE_URI)
            ->delete(self::PROFILE_URI, [
                'password' => self::WRONG_PASSWORD,
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect(self::PROFILE_URI);

        $this->assertNotNull($user->fresh());
    }
}
