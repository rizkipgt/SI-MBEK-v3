<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kambing;
use App\Models\Domba;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KambingUserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $otherUser;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test users
        $this->user = User::factory()->create();
        $this->otherUser = User::factory()->create();
        
        // Create test data for both users
        Kambing::factory()->count(3)->create(['user_id' => $this->user->id]);
        Domba::factory()->count(2)->create(['user_id' => $this->user->id]);
        
        // Create data for other user to test isolation
        Kambing::factory()->count(2)->create(['user_id' => $this->otherUser->id]);
        Domba::factory()->count(1)->create(['user_id' => $this->otherUser->id]);
    }

    /** @test */
    public function authenticated_user_can_access_dashboard()
    {
        $response = $this->actingAs($this->user)
                         ->get('/dashboard');
        
        $response->assertStatus(200)
                 ->assertViewIs('dashboard');
    }

    /** @test */
    public function guest_cannot_access_dashboard()
    {
        $response = $this->get('/dashboard');
        
        $response->assertRedirect('/login');
    }

    /** @test */
    public function dashboard_displays_only_users_own_kambing_and_domba()
    {
        $response = $this->actingAs($this->user)
                         ->get('/dashboard');
        
        $response->assertViewHas('kambings', function($kambings) {
            // Should have 3 kambing (only user's)
            return $kambings->count() === 3 && 
                   $kambings->every(function($kambing) {
                       return $kambing->user_id === $this->user->id;
                   });
        });
        
        $response->assertViewHas('dombas', function($dombas) {
            // Should have 2 domba (only user's)
            return $dombas->count() === 2 && 
                   $dombas->every(function($domba) {
                       return $domba->user_id === $this->user->id;
                   });
        });
    }

    /** @test */
    public function dashboard_displays_user_information()
    {
        $response = $this->actingAs($this->user)
                         ->get('/dashboard');
        
        $response->assertViewHas('user', function($viewUser) {
            return $viewUser->id === $this->user->id;
        });
    }

    /** @test */
    public function dashboard_displays_correct_counts()
    {
        $response = $this->actingAs($this->user)
                         ->get('/dashboard');
        
        // Get the view data
        $kambings = $response->viewData('kambings');
        $dombas = $response->viewData('dombas');
        
        $this->assertEquals(3, $kambings->count());
        $this->assertEquals(2, $dombas->count());
    }

    /** @test */
    public function dashboard_works_with_no_animals()
    {
        // Create a user with no animals
        $userWithoutAnimals = User::factory()->create();
        
        $response = $this->actingAs($userWithoutAnimals)
                         ->get('/dashboard');
        
        $response->assertStatus(200);
        
        $kambings = $response->viewData('kambings');
        $dombas = $response->viewData('dombas');
        
        $this->assertEquals(0, $kambings->count());
        $this->assertEquals(0, $dombas->count());
    }

    /** @test */
    public function dashboard_works_with_only_kambing()
    {
        $userWithOnlyKambing = User::factory()->create();
        Kambing::factory()->count(2)->create(['user_id' => $userWithOnlyKambing->id]);
        
        $response = $this->actingAs($userWithOnlyKambing)
                         ->get('/dashboard');
        
        $response->assertStatus(200);
        
        $kambings = $response->viewData('kambings');
        $dombas = $response->viewData('dombas');
        
        $this->assertEquals(2, $kambings->count());
        $this->assertEquals(0, $dombas->count());
    }

    /** @test */
    public function dashboard_works_with_only_domba()
    {
        $userWithOnlyDomba = User::factory()->create();
        Domba::factory()->count(4)->create(['user_id' => $userWithOnlyDomba->id]);
        
        $response = $this->actingAs($userWithOnlyDomba)
                         ->get('/dashboard');
        
        $response->assertStatus(200);
        
        $kambings = $response->viewData('kambings');
        $dombas = $response->viewData('dombas');
        
        $this->assertEquals(0, $kambings->count());
        $this->assertEquals(4, $dombas->count());
    }
}