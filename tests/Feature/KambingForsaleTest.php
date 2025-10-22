<?php

namespace Tests\Feature\Kambing;

use Tests\TestCase;
use App\Models\User;
use App\Models\SiteSetting;
use App\Models\Kambing;
use App\Models\Domba;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class KambingForsaleTest extends TestCase
{
    use RefreshDatabase;

    protected $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        // Site setting agar view tidak error
        SiteSetting::factory()->create();

        // Login sebagai super admin
        $this->superAdmin = User::factory()->create();
        $this->actingAs($this->superAdmin, 'super_admin');
    }

/** @test */
public function super_admin_can_mark_kambing_as_for_sale()
{
    Storage::fake('public');
    $image = UploadedFile::fake()->image('kambing.jpg');

    $kambing = Kambing::factory()->create([
        'user_id' => $this->superAdmin->id,
        'for_sale' => 'no',
        'harga' => 1000000,
        'age_now' => 2, // Ensure this is an integer
    ]);

    $data = [
        'name' => $kambing->name,
        'age' => $kambing->age,
        'tanggal_lahir' => $kambing->tanggal_lahir,
        'user_id' => $kambing->user_id,
        'type_goat' => $kambing->type_goat,
        'jenis_kelamin' => $kambing->jenis_kelamin,
        'weight' => $kambing->weight,
        'faksin_status' => $kambing->faksin_status,
        'healt_status' => $kambing->healt_status,
        'age_now' => (int) $kambing->age_now, // Cast to integer
        'weight_now' => $kambing->weight_now,
        'for_sale' => 'yes',
        'harga' => $kambing->harga,
        'image' => $image,
    ];

    $response = $this->put(route('super-admin.kambings.update', $kambing), $data);

    $response->assertSessionHasNoErrors();
    $response->assertRedirect();

    $updatedKambing = Kambing::find($kambing->id);
    $this->assertEquals('yes', $updatedKambing->for_sale);
}

    /** @test */
    public function it_shows_all_products_when_category_is_semua()
    {
        $kambing = Kambing::factory()->create(['for_sale' => 'yes']);
        $domba   = Domba::factory()->create(['for_sale' => 'yes']);

        $response = $this->get(route('forsale', ['kategori_produk' => 'semua']));

        $response->assertStatus(200);
        $response->assertViewHas('totalProduk', 2);
        $response->assertSee($kambing->name);
        $response->assertSee($domba->name);
    }

    /** @test */
    public function it_filters_only_kambing_products()
    {
        $kambing = Kambing::factory()->create(['for_sale' => 'yes']);
        Domba::factory()->create(['for_sale' => 'yes']);

        $response = $this->get(route('forsale', ['kategori_produk' => 'kambing']));

        $response->assertStatus(200);
        $response->assertViewHas('totalProduk', 1);
        $response->assertSee($kambing->name);
    }

    /** @test */
    public function it_can_search_products_by_name()
    {
        $target = Kambing::factory()->create(['for_sale' => 'yes', 'name' => 'Super Goat']);
        Kambing::factory()->create(['for_sale' => 'yes', 'name' => 'Other Goat']);

        $response = $this->get(route('forsale', ['kategori_produk' => 'kambing', 'q' => 'Super']));

        $response->assertStatus(200);
        $response->assertSee('Super Goat');
        $response->assertDontSee('Other Goat');
    }

    /** @test */
    public function it_sorts_products_by_lowest_price()
    {
        $cheap = Kambing::factory()->create(['for_sale' => 'yes', 'harga' => 1000]);
        $expensive = Kambing::factory()->create(['for_sale' => 'yes', 'harga' => 5000]);

        $response = $this->get(route('forsale', ['kategori_produk' => 'kambing', 'sort' => 'price_low']));

        $response->assertStatus(200);
        $response->assertSeeInOrder([$cheap->name, $expensive->name]);
    }

    /** @test */
    public function it_filters_products_by_price_range()
    {
        $inside = Domba::factory()->create(['for_sale' => 'yes', 'harga' => 3000]);
        Domba::factory()->create(['for_sale' => 'yes', 'harga' => 10000]);

        $response = $this->get(route('forsale', [
            'kategori_produk' => 'domba',
            'harga_min' => 2000,
            'harga_max' => 5000
        ]));

        $response->assertStatus(200);
        $response->assertSee($inside->name);
        $response->assertViewHas('totalProduk', 1);
    }

    /** @test */
    public function it_returns_404_for_invalid_category()
    {
        $response = $this->get(route('forsale', ['kategori_produk' => 'invalid']));

        $response->assertStatus(404);
    }
}
