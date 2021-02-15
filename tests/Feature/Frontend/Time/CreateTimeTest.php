<?php

namespace Tests\Feature\Frontend\Time;

use App\Events\Time\TimeCreated;
use App\Domains\Auth\Models\User;
use App\Models\Time;
use App\Models\Project;
use App\Models\Client;
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
        
        $this->get('/time/create')->assertRedirect('/login');

        $this->actingAs($user);

        $this->get('/time/create')->assertOk();
    }

    /** @test */
    public function creating_a_time_requires_validation()
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);
        
        $response = $this->post('/time');

        $response->assertSessionHasErrors(['start_time', 'end_time', 'details']);
    }

    /** @test */
    public function a_time_can_be_created()
    {
        Event::fake();

        $user = User::factory()->user()->create();

        $client = Client::factory()->create(['user_id' => $user->id]);

        $project = Project::factory()->create(['user_id' => $user->id, 'client_id' => $client->id]);

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

        $user = User::factory()->user()->create(['parent_user_id' => $parent->id]);

        $client = Client::factory()->create(['user_id' => $parent->id]);

        $project = Project::factory()->create(['user_id' => $parent->id, 'client_id' => $client->id]);

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
    public function a_time_with_another_user_project_can_not_be_created()
    {
        $user = User::factory()->user()->create();

        $another_user = User::factory()->user()->create();

        $client = Client::factory()->create(['user_id' => $another_user->id]);

        $project = Project::factory()->create(['user_id' => $another_user->id, 'client_id' => $client->id]);

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
