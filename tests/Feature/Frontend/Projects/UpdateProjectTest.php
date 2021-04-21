<?php

namespace Tests\Feature\Frontend\Project;

use App\Events\Project\ProjectUpdated;
use App\Models\Project;
use App\Models\Client;
use App\Models\Organization;
use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class UpdateProjectTest.
 */
class UpdateProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_an_user_can_access_the_edit_a_project_page()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);
        
        $this->get("/projects/{$project->id}/edit")->assertRedirect('/login');

        $this->actingAs($user);

        $this->get("/projects/{$project->id}/edit")->assertOk();
    }

    /** @test */
    public function a_subuser_cannot_access_the_list_of_the_projects()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $subuser = User::factory()->user()->create(['organization_id' => $organization->id]);

        $this->actingAs($subuser);

        $response = $this->get("/projects/{$project->id}/edit");

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this page.'));
    }

    /** @test */
    public function a_user_cannot_access_edit_project_page_for_other_organization_projects()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $client = Client::factory()->create(['organization_id' => $another_organization->id]);

        $project = Project::factory()->create(['organization_id' => $another_organization->id, 'client_id' => $client->id]);
        
        $this->get("/projects/{$project->id}/edit")->assertRedirect(route(homeRoute()));
    }

    /** @test */
    public function updating_a_project_requires_validation()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $response = $this->patch("/projects/{$project->id}");

        $response->assertSessionHasErrors(['name', 'client_id']);
    }
    
    /** @test */
    public function a_project_with_another_organization_client_id_can_not_be_created()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $another_client = Client::factory()->create(['organization_id' => $another_organization->id]);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $response = $this->patch("/projects/{$project->id}", [
            'name' => 'name',
            'client_id' => $another_client->id,
        ]);

        $response->assertSessionHasErrors(['client_id']);
    }

    /** @test */
    public function a_project_can_be_updated()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $another_client = Client::factory()->create(['organization_id' => $organization->id]);

        $response = $this->patch("/projects/{$project->id}", [
            'name' => 'name',
            'client_id' => $another_client->id,
        ]);

        $this->assertDatabaseHas('projects', [
            'name' => 'name',
            'client_id' => $another_client->id,
        ]);

        Event::assertDispatched(ProjectUpdated::class);
    }

    /** @test */
    public function a_user_cannot_update_another_organization_project()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);

        $client = Client::factory()->create(['organization_id' => $another_organization->id]);

        $project = Project::factory()->create(['organization_id' => $another_organization->id, 'client_id' => $client->id]);

        $another_client = Client::factory()->create(['organization_id' => $organization->id]);

        $response = $this->patch("/projects/{$project->id}", [
            'name' => 'name',
            'client_id' => $another_client->id,
        ]);

        $response->assertSessionHas('flash_danger', __("You don't have access to this model."));

        $this->assertDatabaseHas('projects', [
            'name' => $project->name,
            'client_id' => $client->id,
        ]);
    }
}
