<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kambing;
use App\Models\Domba;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat site setting biar tidak error di view
        SiteSetting::factory()->create();

        // Buat user login
        $this->user = User::factory()->create();
    }

    /** @test */
    public function user_can_access_dashboard_and_see_his_kambing_and_domba()
    {
        // Buat kambing & domba untuk user ini
        $kambing = Kambing::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $domba = Domba::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
        $response->assertViewHas('kambings', function ($kambings) use ($kambing) {
            return $kambings->contains($kambing);
        });
        $response->assertViewHas('dombas', function ($dombas) use ($domba) {
            return $dombas->contains($domba);
        });
    }

    /** @test */
    public function user_does_not_see_other_users_kambing_and_domba()
    {
        $otherUser = User::factory()->create();

        $otherKambing = Kambing::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $otherDomba = Domba::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('kambings', function ($kambings) use ($otherKambing) {
            return !$kambings->contains($otherKambing);
        });
        $response->assertViewHas('dombas', function ($dombas) use ($otherDomba) {
            return !$dombas->contains($otherDomba);
        });
    }

    /** @test */
    public function guest_cannot_access_dashboard()
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }
}
