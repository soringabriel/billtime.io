<?php

namespace Tests\Feature\Frontend\Subuser;

use App\Domains\Auth\Events\User\UserCreated;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Permission;
use App\Models\Organization;
use App\Domains\Auth\Notifications\Frontend\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * Class CreateSubuserTest.
 */
class CreateSubuserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_logged_in_user_with_permissions_can_access_the_create_subuser_page()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id, 'subusers_quota' => -1]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $this->get('/subuser/create')->assertRedirect(route(homeRoute()));

        $user->syncPermissions([
            Permission::where('name', 'user.access.users.access')->first()->id, 
            Permission::where('name', 'user.access.users.create')->first()->id
        ]);

        $this->get('/subuser/create')->assertOk();
    }

    /** @test */
    public function create_subuser_requires_subusers_quota_validation()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id, 'subusers_quota' => 0]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.users.access')->first()->id, 
            Permission::where('name', 'user.access.users.create')->first()->id
        ]);

        $this->actingAs($user);

        $response = $this->post('/subuser');

        $response->assertSessionHas('flash_danger', __('Your organization reached the subusers quota limit.'));
    }

    /** @test */
    public function create_subuser_requires_validation()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id, 'subusers_quota' => -1]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.users.access')->first()->id, 
            Permission::where('name', 'user.access.users.create')->first()->id
        ]);

        $this->actingAs($user);

        $response = $this->post('/subuser');

        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    /** @test */
    public function subuser_email_needs_to_be_unique()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id, 'subusers_quota' => -1]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.users.access')->first()->id, 
            Permission::where('name', 'user.access.users.create')->first()->id
        ]);

        $this->actingAs($user);

        User::factory()->create(['email' => 'john@example.com', 'organization_id' => $organization->id]);

        $response = $this->post('/subuser', [
            'email' => 'john@example.com',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function a_organization_owner_can_create_new_subuser()
    {
        Notification::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id, 'subusers_quota' => -1]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.users.access')->first()->id, 
            Permission::where('name', 'user.access.users.create')->first()->id
        ]);

        $this->actingAs($user);

        $response = $this->post('/subuser', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'OC4Nzu270N!QBVi%U%qX',
            'password_confirmation' => 'OC4Nzu270N!QBVi%U%qX',
        ]);

        $this->assertDatabaseHas(
            'users',
            [
                'type' => User::TYPE_USER,
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'organization_id' => $organization->id,
                'active' => true,
            ]
        );

        $response->assertSessionHas(['flash_success' => __('The user was successfully created.')]);

        $user = User::where('email', 'john@example.com')->first();

        Notification::assertSentTo($user, VerifyEmail::class);
    }
}
