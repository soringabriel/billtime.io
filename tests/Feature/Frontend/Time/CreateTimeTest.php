<?php

namespace Tests\Feature\Frontend\Time;

use App\Events\Time\TimeCreated;
use App\Domains\Auth\Models\User;
use App\Models\Time;
use App\Models\Project;
use App\Models\Client;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class CreateTimeTest.
 */
class CreateTimeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_an_user_can_access_the_create_a_time_page()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);
        
        $this->get('/time/create')->assertRedirect('/login');

        $this->actingAs($user);

        $this->get('/time/create')->assertOk();
    }

    /** @test */
    public function creating_a_time_requires_validation()
    {
        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $this->actingAs($user);
        
        $response = $this->post('/time');

        $response->assertSessionHasErrors(['start_time', 'end_time', 'details']);
    }

    /** @test */
    public function a_time_can_be_created()
    {
        Event::fake();

        $user = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $user->id]);
        $user->update(['organization_id' => $organization->id]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $this->actingAs($user);

        $this->post('/time', [
            'start_time' => '2020-12-01 00:00',
            'end_time' => '2020-12-01 01:00',
            'project_id' => $project->id,
            'task' => 'https://task.ro',
            'details' => 'details',
        ]);

        $this->assertDatabaseHas('time', [
            'start_time' => '2020-12-01 00:00',
            'end_time' => '2020-12-01 01:00',
            'project_id' => $project->id,
            'task' => 'https://task.ro',
            'details' => 'details',
        ]);

        Event::assertDispatched(TimeCreated::class);
    }

    /** @test */
    public function a_time_with_a_parent_project_can_be_created()
    {
        Event::fake();

        $parent = User::factory()->user()->create();
        $organization = Organization::factory()->create(['owner_id' => $parent->id]);
        $parent->update(['organization_id' => $organization->id]);

        $user = User::factory()->user()->create(['organization_id' => $organization->id]);

        $client = Client::factory()->create(['organization_id' => $organization->id]);

        $project = Project::factory()->create(['organization_id' => $organization->id, 'client_id' => $client->id]);

        $this->actingAs($user);

        $this->post('/time', [
            'start_time' => '2020-12-01 00:00',
            'end_time' => '2020-12-01 01:00',
            'project_id' => $project->id,
            'task' => 'https://task.ro',
            'details' => 'details',
        ]);

        $this->assertDatabaseHas('time', [
            'start_time' => '2020-12-01 00:00',
            'end_time' => '2020-12-01 01:00',
            'project_id' => $project->id,
            'task' => 'https://task.ro',
            'details' => 'details',
        ]);

        Event::assertDispatched(TimeCreated::class);
    }

    /** @test */
    public function a_time_with_another_organization_project_can_not_be_created()
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

        $response = $this->post('/time', [
            'start_time' => '2020-12-01 00:00',
            'end_time' => '2020-12-01 01:00',
            'project_id' => $project->id,
            'task' => 'https://task.ro',
            'details' => 'details',
        ]);

        $response->assertSessionHasErrors(['project_id']);

        $this->assertDatabaseMissing('time', [
            'start_time' => '2020-12-01 00:00',
            'end_time' => '2020-12-01 01:00',
            'project_id' => $project->id,
            'task' => 'https://task.ro',
            'details' => 'details',
        ]);
    }
}
