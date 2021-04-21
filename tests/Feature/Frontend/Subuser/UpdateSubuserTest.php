<?php

namespace Tests\Feature\Backend\User;

use App\Domains\Auth\Events\User\UserUpdated;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class UpdateSubuserTest.
 */
class UpdateSubuserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_parent_user_can_access_the_edit_subuser_page()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $subuser = User::factory()->user()->create(['organization_id' => $organization->id]);

        $response = $this->get('/subuser/'.$subuser->id.'/edit');

        $response->assertOk();
    }
    
    /** @test */
    public function a_subuser_cant_access_the_edit_subuser_page()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $subuser = User::factory()->user()->create(['organization_id' => $organization->id]);

        $this->actingAs($subuser);

        $response = $this->get('/subuser/'.$subuser->id.'/edit');

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this page.'));
    }
    
    /** @test */
    public function a_parent_user_cant_access_the_edit_subuser_page_for_another_user()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $response = $this->get('/subuser/'.$another_user->id.'/edit');

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this User.'));
    }
        
    /** @test */
    public function a_parent_user_cant_access_the_edit_subuser_page_for_another_organization_subuser()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $subuser = User::factory()->user()->create(['organization_id' => $another_organization->id]);

        $response = $this->get('/subuser/'.$subuser->id.'/edit');

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this User.'));
    }

    /** @test */
    public function a_subuser_can_be_updated()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $subuser = User::factory()->user()->create(['organization_id' => $organization->id]);

        $this->patch("/subuser/{$subuser->id}", [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $subuser->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'organization_id' => $organization->id
        ]);

        Event::assertDispatched(UserUpdated::class);
    }

    /** @test */
    public function a_subuser_cant_update_another_subuser()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $subuser = User::factory()->user()->create(['organization_id' => $organization->id]);

        $this->actingAs($subuser);

        $another_subuser = User::factory()->user()->create(['organization_id' => $organization->id]);

        $response = $this->patch("/subuser/{$another_subuser->id}", [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $another_subuser->id,
            'name' => $another_subuser->name,
            'email' => $another_subuser->email,
            'organization_id' => $organization->id
        ]);

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this page.'));
    }
    
    /** @test */
    public function a_parent_user_cant_update_another_user()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $response = $this->patch("/subuser/{$another_user->id}", [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $another_user->id,
            'name' => $another_user->name,
            'email' => $another_user->email,
            'organization_id' => $another_organization->id,
        ]);

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this User.'));
    }

    /** @test */
    public function a_parent_user_cant_update_another_organization_subusers()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $subuser = User::factory()->user()->create(['organization_id' => $another_organization->id]);

        $response = $this->patch("/subuser/{$subuser->id}", [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $subuser->id,
            'name' => $subuser->name,
            'email' => $subuser->email,
            'organization_id' => $another_organization->id
        ]);

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this User.'));
    }
}
