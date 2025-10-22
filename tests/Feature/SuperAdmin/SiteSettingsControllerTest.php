<?php

namespace Tests\Feature\SuperAdmin;

use App\Models\SuperAdmin;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SiteSettingsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $superAdmin;
    protected $siteSettings;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->superAdmin = SuperAdmin::factory()->create([
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'),
        ]);
        
        // Ensure we only have one site settings record
        SiteSetting::query()->delete();
        
        $this->siteSettings = SiteSetting::create([
            'id' => 1, // Explicit ID to ensure consistency
            'site_name' => 'Original Site Name',
            'site_logo' => 'original/logo.png',
            'sections' => [
                'hero' => [
                    'image' => 'old/hero/image.jpg',
                    'title' => 'Original Title',
                    'subtitle' => 'Original Subtitle',
                    'active' => true,
                    'description' => 'Original description',
                    'button_text' => 'Original button',
                    'button_url' => '#'
                ]
            ],
            'social' => [
                'twitter' => ['active' => 'on', 'url' => 'https://twitter.com/old'],
                'facebook' => ['active' => 'on', 'url' => 'https://facebook.com/old'],
                'instagram' => ['active' => null, 'url' => null],
                'linkedin' => ['active' => null, 'url' => null]
            ],
            'about_page' => [
                'active' => true,
                'title' => 'Original About Title',
                'subtitle' => 'Original About Subtitle',
                'sections' => []
            ],
            'contact' => [
                'address' => 'Original Address',
                'phone' => '000-000-0000',
                'email' => 'original@example.com'
            ],
            'map' => [
                'embed_code' => '<iframe>Original Map</iframe>'
            ]
        ]);
    }

    /** @test */
    public function super_admin_can_access_site_settings_page()
    {
        $response = $this->actingAs($this->superAdmin, 'super_admin')
            ->get(route('super-admin.site-settings.edit'));
        
        $response->assertStatus(200)
            ->assertViewIs('superadmin.site-settings.edit')
            ->assertViewHas('settings');
    }

    /** @test */
    public function unauthorized_user_cannot_access_site_settings_page()
    {
        // Guest user
        $response = $this->get(route('super-admin.site-settings.edit'));
        $response->assertRedirect(route('super-admin.login'));
    }

        /** @test */
    public function can_update_site_settings_with_valid_data()
    {
        // Verify initial state
        $initialSettings = SiteSetting::first();
        $this->assertEquals('Original Site Name', $initialSettings->site_name);
        $this->assertEquals('Original Title', $initialSettings->sections['hero']['title']);

        $response = $this->actingAs($this->superAdmin, 'super_admin')
            ->put(route('super-admin.site-settings.update'), [
                'site_name' => 'Updated Site Name',
                'sections' => [
                    'hero' => [
                        'title' => 'New Hero Title',
                        'subtitle' => 'New Hero Subtitle',
                        'active' => 'on'
                    ]
                ],
                'social' => [
                    'twitter' => ['active' => 'on', 'url' => 'https://twitter.com/new'],
                    'facebook' => ['active' => 'on', 'url' => 'https://facebook.com/new'],
                    'instagram' => ['url' => 'https://instagram.com/test'],
                    'linkedin' => ['url' => '']
                ]
            ]);

        // Check response
        $response->assertRedirect()
            ->assertSessionHas('success');

        // Get the updated settings directly from the database
        $updatedSettings = SiteSetting::first();
        
        // Debug if the assertion fails
        if ($updatedSettings->site_name !== 'Updated Site Name') {
            dd([
                'expected' => 'Updated Site Name',
                'actual' => $updatedSettings->site_name,
                'all_data' => $updatedSettings->toArray()
            ]);
        }

        // Assertions
        $this->assertEquals('Updated Site Name', $updatedSettings->site_name);
        $this->assertEquals('New Hero Title', $updatedSettings->sections['hero']['title']);
        $this->assertEquals('https://twitter.com/new', $updatedSettings->social['twitter']['url']);
    }

    /** @test */
    public function validation_fails_with_invalid_data()
    {
        $response = $this->actingAs($this->superAdmin, 'super_admin')
            ->put(route('super-admin.site-settings.update'), [
                'site_name' => '', // Required field empty
                'sections' => [
                    'hero' => [
                        'button_url' => 'invalid-url' // Should be URL
                    ]
                ]
            ]);

        $response->assertRedirect()
            ->assertSessionHasErrors(['site_name', 'sections.hero.button_url']);
    }

    /** @test */
    public function can_upload_and_replace_site_logo()
    {
        Storage::fake('public\logo');

        $file = UploadedFile::fake()->image('new-logo.jpg');

        $response = $this->actingAs($this->superAdmin, 'super_admin')
            ->put(route('super-admin.site-settings.update'), [
                'site_name' => 'Test Site',
                'site_logo' => $file
            ]);

        $response->assertRedirect()
            ->assertSessionHas('success');

        // Gunakan fresh() untuk mendapatkan data terbaru dari database
        $settings = SiteSetting::first()->fresh();
        
        $this->assertTrue(Storage::disk('public')->exists($settings->site_logo));
        $this->assertNotNull($settings->site_logo);
    }

    /** @test */
    public function can_upload_hero_image()
    {
        Storage::fake('public\logo');

        $file = UploadedFile::fake()->image('new-hero.jpg');

        $response = $this->actingAs($this->superAdmin, 'super_admin')
            ->put(route('super-admin.site-settings.update'), [
                'site_name' => 'Test Site',
                'hero_image' => $file
            ]);

        $response->assertRedirect()
            ->assertSessionHas('success');

        // Gunakan fresh() untuk mendapatkan data terbaru dari database
        $settings = SiteSetting::first()->fresh();

        $this->assertTrue(Storage::disk('public')->exists($settings->sections['hero']['image']));
        $this->assertNotNull($settings->sections['hero']['image']);
    }

    /** @test */
    public function social_media_urls_are_normalized_correctly()
    {
        $response = $this->actingAs($this->superAdmin, 'super_admin')
            ->put(route('super-admin.site-settings.update'), [
                'site_name' => 'Test Site',
                'social' => [
                    'twitter' => ['url' => ''],
                    'facebook' => ['url' => '#'],
                    'instagram' => ['url' => 'https://instagram.com/test'],
                    'linkedin' => ['active' => 'on', 'url' => 'https://linkedin.com/test']
                ]
            ]);

        $response->assertRedirect()
            ->assertSessionHas('success');

        // Gunakan fresh() untuk mendapatkan data terbaru dari database
        $settings = SiteSetting::first()->fresh();

        $this->assertNull($settings->social['twitter']['url']);
        $this->assertEquals('#', $settings->social['facebook']['url']);
        $this->assertEquals('https://instagram.com/test', $settings->social['instagram']['url']);
        $this->assertEquals('on', $settings->social['linkedin']['active']);
    }

    /** @test */
    public function about_page_sections_are_stored_correctly()
    {
        $input = [
            'site_name' => 'Test Site',
            'about_page' => [
                'active' => 'on',
                'title' => 'About Title',
                'subtitle' => 'About Subtitle',
                'sections' => [
                    [
                        'title' => 'Section 1',
                        'content' => 'Content 1',
                        'items' => ["Item 1", "Item 2"]
                    ]
                ]
            ]
        ];

        $response = $this->actingAs($this->superAdmin, 'super_admin')
            ->put(route('super-admin.site-settings.update'), $input);

        $response->assertRedirect()
            ->assertSessionHas('success');

        // Gunakan fresh() untuk mendapatkan data terbaru dari database
        $settings = SiteSetting::first()->fresh();

        $this->assertEquals('About Title', $settings->about_page['title']);
        $this->assertTrue($settings->about_page['active']);
        $this->assertCount(1, $settings->about_page['sections']);
        $this->assertEquals(["Item 1", "Item 2"], $settings->about_page['sections'][0]['items']);
    }

    /** @test */
    public function site_logo_is_preserved_when_not_updated()
    {
        $originalLogo = 'original/logo.png';
        
        $response = $this->actingAs($this->superAdmin, 'super_admin')
            ->put(route('super-admin.site-settings.update'), [
                'site_name' => 'Test Site'
                // No site_logo field in request
            ]);

        $response->assertRedirect()
            ->assertSessionHas('success');

        // Gunakan fresh() untuk mendapatkan data terbaru dari database
        $settings = SiteSetting::first()->fresh();
        $this->assertEquals($originalLogo, $settings->site_logo);
    }

    
    /** @test */
public function sections_are_merged_correctly_with_default_values()
{
    $response = $this->actingAs($this->superAdmin, 'super_admin')
        ->put(route('super-admin.site-settings.update'), [
            'site_name' => 'Test Site',
            'sections' => [
                'hero' => [
                    'active' => 'on',
                    'title' => 'Custom Hero Title'
                ]
            ]
        ]);

    $response->assertRedirect()
        ->assertSessionHas('success');

    $settings = SiteSetting::first()->fresh();

    // Custom values should be preserved
    $this->assertEquals('Custom Hero Title', $settings->sections['hero']['title']);
    
    // Controller menggunakan nilai default, bukan mempertahankan nilai yang ada
    $this->assertEquals('Pantau Pertumbuhan, Tingkatkan Produktivitas', $settings->sections['hero']['subtitle']);
}
}