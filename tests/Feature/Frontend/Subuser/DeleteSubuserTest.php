<?php

namespace Tests\Feature\Backend\User;

use App\Domains\Auth\Events\User\UserDeleted;
use App\Domains\Auth\Events\User\UserDestroyed;
use App\Domains\Auth\Models\User;
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
    public function an_parent_user_can_access_deleted_subusers_page()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $response = $this->get('/subuser/deleted');

        $response->assertOk();
    }

    /** @test */
    public function an_subuser_cant_access_deleted_subusers_page()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $subuser = User::factory()->user()->create(['organization_id' => $organization->id]);

        $this->actingAs($subuser);

        $response = $this->get('/subuser/deleted');

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this page.'));
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

        $response = $this->delete("/subuser/{$subuser->id}");

        $response->assertSessionHas(['flash_success' => __('The user was successfully deleted.')]);

        $this->assertSoftDeleted('users', ['id' => $subuser->id]);

        Event::assertDispatched(UserDeleted::class);
    }

    /** @test */
    public function an_subuser_cant_delete_another_subuser()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $subuser = User::factory()->user()->create(['organization_id' => $organization->id]);

        $this->actingAs($subuser);

        $another_subuser = User::factory()->user()->create(['organization_id' => $user->id]);

        $response = $this->delete("/subuser/{$another_subuser->id}");

        $this->assertDatabaseHas('users', ['id' => $another_subuser->id]);

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this page.'));
    }

    /** @test */
    public function a_user_cant_delete_another_user()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $response = $this->delete("/subuser/{$another_user->id}");

        $this->assertDatabaseHas('users', ['id' => $another_user->id]);

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this User.'));
    }

    /** @test */
    public function a_user_cant_delete_another_users_subuser()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $subuser = User::factory()->user()->create(['organization_id' => $another_organization->id]);

        $response = $this->delete("/subuser/{$subuser->id}");

        $this->assertDatabaseHas('users', ['id' => $subuser->id]);

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this User.'));
    }

    /** @test */
    public function a_subuser_can_be_restored()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $subuser = User::factory()->deleted()->create(['organization_id' => $organization->id]);

        $this->assertSoftDeleted('users', ['id' => $subuser->id]);

        $response = $this->patch("/subuser/{$subuser->id}/restore");

        $response->assertSessionHas(['flash_success' => __('The user was successfully restored.')]);

        $this->assertDatabaseHas('users', ['id' => $subuser->id]);
    }

    /** @test */
    public function an_subuser_cant_restore_another_subuser()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $subuser = User::factory()->user()->create(['organization_id' => $organization->id]);

        $this->actingAs($subuser);

        $another_subuser = User::factory()->deleted()->create(['organization_id' => $organization->id]);

        $response = $this->patch("/subuser/{$another_subuser->id}/restore");

        $this->assertSoftDeleted('users', ['id' => $another_subuser->id]);

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this page.'));
    }


    /** @test */
    public function a_user_cant_restore_another_user()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $another_user = User::factory()->deleted()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $response = $this->patch("/subuser/{$another_user->id}/restore");

        $this->assertSoftDeleted('users', ['id' => $another_user->id]);

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this User.'));
    }

    /** @test */
    public function a_user_cant_restore_another_organization_subuser()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $another_user = User::factory()->deleted()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $subuser = User::factory()->deleted()->create(['organization_id' => $another_organization->id]);

        $response = $this->patch("/subuser/{$subuser->id}/restore");

        $this->assertSoftDeleted('users', ['id' => $subuser->id]);

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this User.'));
    }
}
