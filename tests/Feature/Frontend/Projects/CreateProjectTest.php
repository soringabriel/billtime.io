<?php

namespace Tests\Feature\Frontend\Project;

use App\Events\Project\ProjectCreated;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Permission;
use App\Models\Project;
use App\Models\Client;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class CreateProjectTest.
 */
class CreateProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_an_user_with_permissions_can_access_the_create_a_project_page()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        
        $this->get('/projects/create')->assertRedirect('/login');

        $this->actingAs($user);

        $this->get('/projects/create')->assertRedirect(route(homeRoute()));

        $user->syncPermissions([
            Permission::where('name', 'user.access.projects.access')->first()->id, 
            Permission::where('name', 'user.access.projects.create')->first()->id
        ]);

        $this->get('/projects/create')->assertOk();
    }
    
    /** @test */
    public function creating_a_project_requires_validation()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.projects.access')->first()->id, 
            Permission::where('name', 'user.access.projects.create')->first()->id
        ]);

        $this->actingAs($user);
        
        $response = $this->post('/projects');

        $response->assertSessionHasErrors(['name', 'client_id']);
    }

    /** @test */
    public function a_project_with_another_organization_client_id_can_not_be_created()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.projects.access')->first()->id, 
            Permission::where('name', 'user.access.projects.create')->first()->id
        ]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $client = Client::factory()->create(['organization_id' => $another_organization->id]);
        
        $response = $this->post('/projects', [
            'name' => 'name',
            'client_id' => $client->id,
        ]);

        $response->assertSessionHasErrors(['client_id']);
    }

    /** @test */
    public function a_project_can_be_created()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        $user->syncPermissions([
            Permission::where('name', 'user.access.projects.access')->first()->id, 
            Permission::where('name', 'user.access.projects.create')->first()->id
        ]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $response = $this->post('/projects', [
            'name' => 'name',
            'client_id' => $client->id,
        ]);

        $this->assertDatabaseHas('projects', [
            'name' => 'name',
            'client_id' => $client->id,
            'organization_id' => $organization->id,
        ]);

        Event::assertDispatched(ProjectCreated::class);
    }
}
