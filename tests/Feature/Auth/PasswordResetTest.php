<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Models\SiteSetting;
use App\Notifications\CustomResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\{Notification, Hash, DB};
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create default settings
        SiteSetting::create([
            'site_name' => 'Test Site',
            'site_logo' => 'default-logo.png',
            'site_description' => 'Test Description'
        ]);
    }

    public function test_reset_password_link_screen_can_be_rendered(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }

    public function test_reset_password_link_can_be_requested(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now()
        ]);

        $response = $this->post('/forgot-password', [
            'email' => $user->email
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        // Change ResetPassword to CustomResetPassword
        Notification::assertSentTo(
            $user,
            CustomResetPassword::class
        );

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => $user->email
        ]);
    }

    public function test_reset_password_screen_can_be_rendered(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $token = Password::createToken($user);

        $response = $this->get('/reset-password/' . $token);

        $response->assertStatus(200);
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $token = Password::createToken($user);

        $newPassword = 'new-password123';

        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => $user->email,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertTrue(Hash::check($newPassword, $user->fresh()->password));
    }
}
