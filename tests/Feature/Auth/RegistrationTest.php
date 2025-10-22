<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        SiteSetting::create([
            'site_name' => 'Test Site',
            'site_logo' => 'default-logo.png',
            'site_description' => 'Test Description'
        ]);
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => 'on',
            'alamat' => 'Test Address',
            'no_telepon' => '081234567890'
        ];

        $response = $this->post('/register', $userData);

        // Verify response status
        $response->assertSessionHasNoErrors();
        
        // Assert user was created
        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
            'name' => $userData['name'],
            'alamat' => $userData['alamat'],
            'no_telepon' => $userData['no_telepon']
        ]);

        // Verify authentication and redirect
        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }
}
