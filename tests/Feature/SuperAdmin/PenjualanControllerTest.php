<?php

namespace Tests\Feature\SuperAdmin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Kambing;
use App\Models\Domba;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PenjualanControllerTest extends TestCase
{
    use RefreshDatabase;

    // Add property declarations
    protected $superAdmin;
    protected $user;
    protected $orderWithKambing;
    protected $orderWithDomba;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create site setting first to avoid null errors in views
        SiteSetting::factory()->create();
        
        // Create and login as super admin
        $this->superAdmin = User::factory()->create();
        $this->actingAs($this->superAdmin, 'super_admin');
        
        // Create test user
        $this->user = User::factory()->create();
        
        // Create test kambing and domba
        $kambing = Kambing::factory()->create(['user_id' => $this->user->id]);
        $domba = Domba::factory()->create(['user_id' => $this->user->id]);
        
        // Create orders with the new schema
        $this->orderWithKambing = Order::factory()->create([
            'user_id' => $this->user->id,
            'produk_id' => $kambing->id,
            'payment_method' => 'midtrans',
        ]);
        
        $this->orderWithDomba = Order::factory()->create([
            'user_id' => $this->user->id,
            'produk_id' => $domba->id,
            'payment_method' => 'manual',
        ]);
    }

    public function test_invoice_displays_order_with_kambing()
    {
        $response = $this->get("/super-admin/penjualan/invoice/{$this->orderWithKambing->order_id}");

        $response->assertStatus(200)
                ->assertViewIs('superadmin.invoice')
                ->assertViewHas('order');
    }

    public function test_invoice_displays_order_with_domba()
    {
        $response = $this->get("/super-admin/penjualan/invoice/{$this->orderWithDomba->order_id}");

        $response->assertStatus(200)
                ->assertViewIs('superadmin.invoice')
                ->assertViewHas('order');
    }


    public function test_manual_invoice_displays_order_with_kambing()
    {
        $response = $this->get("/super-admin/penjualan/manual-invoice/{$this->orderWithKambing->order_id}");

        $response->assertStatus(200)
                ->assertViewIs('superadmin.manual-invoice')
                ->assertViewHas('order');
    }

    public function test_manual_invoice_displays_order_with_domba()
    {
        $response = $this->get("/super-admin/penjualan/manual-invoice/{$this->orderWithDomba->order_id}");

        $response->assertStatus(200)
                ->assertViewIs('superadmin.manual-invoice')
                ->assertViewHas('order');
    }

    public function test_invoice_returns_404_for_nonexistent_order()
    {
        $response = $this->get('/super-admin/penjualan/invoice/nonexistent-order-id');

        $response->assertStatus(404);
    }

    public function test_manual_invoice_returns_404_for_nonexistent_order()
    {
        $response = $this->get('/super-admin/penjualan/manual-invoice/nonexistent-order-id');

        $response->assertStatus(404);
    }
}