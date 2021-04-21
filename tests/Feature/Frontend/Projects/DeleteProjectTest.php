<?php

namespace Tests\Feature\Frontend\Project;

use App\Events\Project\ProjectDeleted;
use App\Models\Project;
use App\Models\Client;
use App\Models\Organization;
use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class DeleteProjectTest.
 */
class DeleteProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_be_deleted()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $this->actingAs($user);

        $this->assertDatabaseHas('projects', ['id' => $project->id]);

        $this->delete("/projects/{$project->id}");

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);

        Event::assertDispatched(ProjectDeleted::class);
    }
    
    /** @test */
    public function a_subuser_cannot_delete_a_project()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $subuser = User::factory()->user()->create(['organization_id' => $organization->id]);

        $this->actingAs($subuser);

        $response = $this->delete("/projects/{$project->id}");

        $response->assertSessionHas('flash_danger', __('You don\'t have access to this page.'));
    }
    
    /** @test */
    public function a_user_cannot_delete_a_project_that_belongs_to_another_user()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $another_user = User::factory()->user()->create();
        $another_organization = Organization::factory()->create(['owner_id' => $another_user->id]);
        $another_user->update(['organization_id' => $another_organization->id]);
        
        $client = Client::factory()->create(['organization_id' => $another_organization->id]);

        $project = Project::factory()->create(['organization_id' => $another_organization->id, 'client_id' => $client->id]);

        $this->actingAs($user);

        $this->assertDatabaseHas('projects', ['id' => $project->id]);

        $this->delete("/projects/{$project->id}");

        $this->assertDatabaseHas('projects', ['id' => $project->id]);
    }
}
