<?php

namespace Tests\Feature\SuperAdmin;

use App\Models\SuperAdmin;
use App\Models\User;
use App\Models\Kambing;
use App\Models\Domba;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected SuperAdmin $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a super admin for testing
        $this->superAdmin = SuperAdmin::factory()->create([
            'name' => 'Super Admin Test',
            'email' => 'superadmin@test.com',
            'password' => Hash::make('password123'),
        ]);
        // Create site setting if needed
        SiteSetting::factory()->create();
    }

    /** @test */
    public function super_admin_can_view_profile_edit_page()
    {
        $response = $this->actingAs($this->superAdmin, 'super_admin')
            ->get(route('super-admin.profile.edit'));

        $response->assertStatus(200);
        $response->assertViewIs('superadmin.profile.edit');
        $response->assertViewHas('user', $this->superAdmin);
    }

    /** @test */
    public function guest_cannot_access_profile_edit_page()
    {
        $response = $this->get(route('super-admin.profile.edit'));

        $response->assertRedirect(route('super-admin.login'));
    }

    /** @test */
    public function super_admin_can_update_profile_successfully()
    {
        $updateData = [
            'name' => 'Updated Super Admin Name',
            'email' => 'updated@superadmin.com',
        ];

        $response = $this->actingAs($this->superAdmin, 'super_admin')
            ->patch(route('super-admin.profile.update'), $updateData);

        $response->assertRedirect(route('super-admin.profile.edit'));
        $response->assertSessionHas('status', 'profile-updated');

        $this->assertDatabaseHas('super_admins', [
            'id' => $this->superAdmin->id,
            'name' => 'Updated Super Admin Name',
            'email' => 'updated@superadmin.com',
        ]);
    }

    /** @test */
    public function super_admin_profile_update_resets_email_verification_when_email_changes()
    {
        // Set email_verified_at first
        $this->superAdmin->update(['email_verified_at' => now()]);

        $updateData = [
            'name' => $this->superAdmin->name,
            'email' => 'newemail@superadmin.com',
        ];

        $response = $this->actingAs($this->superAdmin, 'super_admin')
            ->patch(route('super-admin.profile.update'), $updateData);

        $response->assertRedirect(route('super-admin.profile.edit'));

        $this->superAdmin->refresh();
        $this->assertNull($this->superAdmin->email_verified_at);
    }

    /** @test */
    public function super_admin_profile_update_keeps_email_verification_when_email_unchanged()
    {
        $verifiedAt = now();
        $this->superAdmin->update(['email_verified_at' => $verifiedAt]);

        $updateData = [
            'name' => 'Updated Name',
            'email' => $this->superAdmin->email, // Same email
        ];

        $response = $this->actingAs($this->superAdmin, 'super_admin')
            ->patch(route('super-admin.profile.update'), $updateData);

        $response->assertRedirect(route('super-admin.profile.edit'));

        $this->superAdmin->refresh();
        $this->assertNotNull($this->superAdmin->email_verified_at);
    }

    /** @test */
    public function super_admin_profile_update_requires_validation()
    {
        $response = $this->actingAs($this->superAdmin, 'super_admin')
            ->patch(route('super-admin.profile.update'), [
                'name' => '',
                'email' => 'invalid-email',
            ]);

        $response->assertSessionHasErrors(['name', 'email']);
    }

    /** @test */
    public function super_admin_can_delete_account_with_correct_password()
    {
        $response = $this->actingAs($this->superAdmin, 'super_admin')
            ->delete(route('super-admin.profile.destroy'), [
                'password' => 'password123',
            ]);

        $response->assertRedirect('/super-admin/login');

        $this->assertDatabaseMissing('super_admins', [
            'id' => $this->superAdmin->id,
        ]);

        // Assert user is logged out
        $this->assertGuest('super_admin');
    }

    /** @test */
    public function super_admin_cannot_delete_account_with_wrong_password()
    {
        $response = $this->actingAs($this->superAdmin, 'super_admin')
            ->delete(route('super-admin.profile.destroy'), [
                'password' => 'wrong-password',
            ]);

        $response->assertSessionHasErrorsIn('userDeletion', ['password']);

        $this->assertDatabaseHas('super_admins', [
            'id' => $this->superAdmin->id,
        ]);
    }

    /** @test */
    public function test_super_admin_can_delete_user_successfully()
{
    $user = User::factory()->create([
        'profile_picture' => 'test-image.jpg' // Use the correct field name
    ]);

    // Create the image in the real filesystem
    $imagePath = public_path('upload/profilImage/test-image.jpg');
    
    // Ensure the directory exists
    if (!file_exists(dirname($imagePath))) {
        mkdir(dirname($imagePath), 0777, true);
    }
    
    // Create the file
    file_put_contents($imagePath, 'fake image content');

    // Verify the file exists before deletion
    $this->assertFileExists($imagePath);

    $response = $this->actingAs($this->superAdmin, 'super_admin')
        ->delete(route('super-admin.profile.destroyuser', $user));

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Data user berhasil dihapus');

    $this->assertDatabaseMissing('users', [
        'id' => $user->id,
    ]);

    // Verify image was deleted from filesystem
    $this->assertFileDoesNotExist($imagePath);
    
    // Clean up: remove the directory if it's empty
    if (file_exists(dirname($imagePath)) && count(scandir(dirname($imagePath))) == 2) {
        rmdir(dirname($imagePath));
    }
}

    /** @test */
    public function super_admin_can_view_all_penitip_users()
    {
        // Create users with kambing and domba
        $userWithKambing = User::factory()->create();
        $userWithDomba = User::factory()->create();
        $userWithBoth = User::factory()->create();
        $userWithoutAnimals = User::factory()->create();

        // Create relationships (assuming Kambing and Domba models exist)
        Kambing::factory()->create(['user_id' => $userWithKambing->id]);
        Domba::factory()->create(['user_id' => $userWithDomba->id]);
        Kambing::factory()->create(['user_id' => $userWithBoth->id]);
        Domba::factory()->create(['user_id' => $userWithBoth->id]);

        $response = $this->actingAs($this->superAdmin, 'super_admin')
            ->get(route('super-admin.penitip'));

        $response->assertStatus(200);
        $response->assertViewIs('superadmin.pengguna');
        $response->assertViewHas('users');
        $response->assertViewHas('currentType', null);
    }

    /** @test */
    public function super_admin_can_view_kambing_penitip_users_only()
    {
        $userWithKambing = User::factory()->create();
        $userWithDomba = User::factory()->create();

        Kambing::factory()->create(['user_id' => $userWithKambing->id]);
        Domba::factory()->create(['user_id' => $userWithDomba->id]);

        $response = $this->actingAs($this->superAdmin, 'super_admin')
            ->get(route('super-admin.penitip', 'kambing'));

        $response->assertStatus(200);
        $response->assertViewIs('superadmin.pengguna');
        $response->assertViewHas('currentType', 'kambing');
        
        // Should only show users with kambing
        $users = $response->viewData('users');
        $this->assertTrue($users->contains($userWithKambing));
        $this->assertFalse($users->contains($userWithDomba));
    }

    /** @test */
    public function super_admin_can_view_domba_penitip_users_only()
    {
        $userWithKambing = User::factory()->create();
        $userWithDomba = User::factory()->create();

        Kambing::factory()->create(['user_id' => $userWithKambing->id]);
        Domba::factory()->create(['user_id' => $userWithDomba->id]);

        $response = $this->actingAs($this->superAdmin, 'super_admin')
            ->get(route('super-admin.penitip', 'domba'));

        $response->assertStatus(200);
        $response->assertViewIs('superadmin.pengguna');
        $response->assertViewHas('currentType', 'domba');
        
        // Should only show users with domba
        $users = $response->viewData('users');
        $this->assertFalse($users->contains($userWithKambing));
        $this->assertTrue($users->contains($userWithDomba));
    }

    /** @test */
    public function penitip_users_include_animal_counts()
    {
        $user = User::factory()->create();
        
        // Create multiple animals for count testing
        Kambing::factory()->count(3)->create(['user_id' => $user->id]);
        Domba::factory()->count(2)->create(['user_id' => $user->id]);

        $response = $this->actingAs($this->superAdmin, 'super_admin')
            ->get(route('super-admin.penitip'));

        $response->assertStatus(200);
        
        $users = $response->viewData('users');
        $foundUser = $users->where('id', $user->id)->first();
        
        $this->assertEquals(3, $foundUser->kambing_count);
        $this->assertEquals(2, $foundUser->domba_count);
    }

    /** @test */
    public function penitip_listing_is_paginated()
    {
        // Create more than 10 users to test pagination
        User::factory()->count(15)->create()->each(function ($user) {
            Kambing::factory()->create(['user_id' => $user->id]);
            Domba::factory()->create(['user_id' => $user->id]);
        });

        $response = $this->actingAs($this->superAdmin, 'super_admin')
            ->get(route('super-admin.penitip'));

        $response->assertStatus(200);
        
        $users = $response->viewData('users');
        $this->assertEquals(10, $users->perPage());
        $this->assertEquals(15, $users->total());
    }

    /** @test */
    public function guest_cannot_access_penitip_listing()
    {
        $response = $this->get(route('super-admin.penitip'));

        $response->assertRedirect(route('super-admin.login'));
    }

    /** @test */
    public function regular_user_cannot_access_super_admin_routes()
    {
        $regularUser = User::factory()->create();

        $response = $this->actingAs($regularUser)
            ->get(route('super-admin.profile.edit'));

        $response->assertRedirect(route('super-admin.login'));
    }
}