<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ContactMessage;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat site setting dengan email tujuan
        SiteSetting::factory()->create([
            'contact' => ['email' => 'admin@example.com']
        ]);
    }

    /** @test */
    public function guest_can_send_contact_message()
    {
        Notification::fake();

        $response = $this->post(route('contact.send'), [
            'nama' => 'John Doe',
            'email' => 'john@example.com',
            'telepon' => '+628123456789',
            'pesan' => 'Halo, ini pesan test',
        ]);

        $response->assertRedirect(); // kembali ke halaman sebelumnya
        $response->assertSessionHas('success', 'Pesan Anda berhasil dikirim!');

        Notification::assertSentOnDemand(ContactMessage::class, function ($notification, $channels, $notifiable) {
            return $notifiable->routes['mail'] === 'admin@example.com';
        });
    }

    /** @test */
    public function logged_in_user_can_send_contact_message()
    {
        Notification::fake();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('contact.send'), [
            'nama' => 'Jane Doe',
            'email' => 'jane@example.com',
            'telepon' => '08123456789',
            'pesan' => 'Ini pesan dari user login',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        Notification::assertSentOnDemand(ContactMessage::class, function ($notification, $channels, $notifiable) {
            return $notifiable->routes['mail'] === 'admin@example.com';
        });
    }

    /** @test */
    public function contact_form_requires_all_fields()
    {
        $response = $this->post(route('contact.send'), []);

        $response->assertSessionHasErrors(['nama', 'email', 'telepon', 'pesan']);
    }

    /** @test */
    public function invalid_email_or_phone_will_fail_validation()
    {
        $response = $this->post(route('contact.send'), [
            'nama' => 'John Doe',
            'email' => 'not-an-email',
            'telepon' => 'invalid###',
            'pesan' => 'Halo',
        ]);

        $response->assertSessionHasErrors(['email', 'telepon']);
    }
}