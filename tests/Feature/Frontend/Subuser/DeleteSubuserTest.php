<?php

namespace Tests\Feature\Backend\User;

use App\Domains\Auth\Events\User\UserDeleted;
use App\Domains\Auth\Events\User\UserDestroyed;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Permission;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class DeleteSubuserTest.
 */
class DeleteSubuserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_access_deleted_subusers_page()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $this->get('/subuser/deleted')->assertRedirect(route(homeRoute()));

        $user->syncPermissions([
            Permission::where('name', 'user.access.users.access')->first()->id, 
            Permission::where('name', 'user.access.users.delete')->first()->id
        ]);

        $this->get('/subuser/deleted')->assertOk();
    }

    /** @test */
    public function a_organization_owner_cant_be_deleted()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.users.access')->first()->id, 
            Permission::where('name', 'user.access.users.delete')->first()->id
        ]);

        $this->actingAs($user);

        $response = $this->delete("/subuser/{$user->id}");

        $response->assertSessionHas(['flash_danger' => __('You don\'t have access to this model.')]);
    }

    /** @test */
    public function a_subuser_can_be_deleted()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $subuser = User::factory()->user()->create(['organization_id' => $organization->id]);

        $this->delete("/subuser/{$subuser->id}")->assertRedirect(route(homeRoute()));

        $user->syncPermissions([
            Permission::where('name', 'user.access.users.access')->first()->id, 
            Permission::where('name', 'user.access.users.delete')->first()->id
        ]);

        $response = $this->delete("/subuser/{$subuser->id}");

        $response->assertSessionHas(['flash_success' => __('The user was successfully deleted.')]);

        $this->assertSoftDeleted('users', ['id' => $subuser->id]);

        Event::assertDispatched(UserDeleted::class);
    }

    /** @test */
    public function a_user_cant_delete_another_user()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.users.access')->first()->id, 
            Permission::where('name', 'user.access.users.delete')->first()->id
        ]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $response = $this->delete("/subuser/{$another_user->id}");

        $this->assertDatabaseHas('users', ['id' => $another_user->id]);

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this model.'));
    }

    /** @test */
    public function a_user_cant_delete_another_users_subuser()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.users.access')->first()->id, 
            Permission::where('name', 'user.access.users.delete')->first()->id
        ]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $subuser = User::factory()->user()->create(['organization_id' => $another_organization->id]);

        $response = $this->delete("/subuser/{$subuser->id}");

        $this->assertDatabaseHas('users', ['id' => $subuser->id]);

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this model.'));
    }

    /** @test */
    public function a_subuser_can_be_restored()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id, 'subusers_quota' => -1]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.users.access')->first()->id, 
            Permission::where('name', 'user.access.users.delete')->first()->id
        ]);

        $this->actingAs($user);

        $subuser = User::factory()->deleted()->create(['organization_id' => $organization->id]);

        $this->assertSoftDeleted('users', ['id' => $subuser->id]);

        $response = $this->patch("/subuser/{$subuser->id}/restore");

        $response->assertSessionHas(['flash_success' => __('The user was successfully restored.')]);

        $this->assertDatabaseHas('users', ['id' => $subuser->id]);
    }


    /** @test */
    public function a_user_cant_restore_another_user()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id, 'subusers_quota' => -1]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.users.access')->first()->id, 
            Permission::where('name', 'user.access.users.delete')->first()->id
        ]);

        $this->actingAs($user);

        $another_user = User::factory()->deleted()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $response = $this->patch("/subuser/{$another_user->id}/restore");

        $this->assertSoftDeleted('users', ['id' => $another_user->id]);

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this model.'));
    }

    /** @test */
    public function a_user_cant_restore_another_organization_subuser()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id, 'subusers_quota' => -1]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.users.access')->first()->id, 
            Permission::where('name', 'user.access.users.delete')->first()->id
        ]);

        $this->actingAs($user);

        $another_user = User::factory()->deleted()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $subuser = User::factory()->deleted()->create(['organization_id' => $another_organization->id]);

        $response = $this->patch("/subuser/{$subuser->id}/restore");

        $this->assertSoftDeleted('users', ['id' => $subuser->id]);

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this model.'));
    }

    /** @test */
    public function a_subuser_cant_be_restored_if_the_quota_will_be_reached()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id, 'subusers_quota' => 1]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.users.access')->first()->id, 
            Permission::where('name', 'user.access.users.delete')->first()->id
        ]);

        $this->actingAs($user);

        $subuser_active = User::factory()->active()->create(['organization_id' => $organization->id]);

        $subuser = User::factory()->deleted()->create(['organization_id' => $organization->id]);

        $this->assertSoftDeleted('users', ['id' => $subuser->id]);

        $response = $this->patch("/subuser/{$subuser->id}/restore");

        $response->assertSessionHas(['flash_danger' => __('Your organization reached the subusers quota limit.')]);
    }
}
